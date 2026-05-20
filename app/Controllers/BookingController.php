<?php

namespace App\Controllers;

use App\Helpers\FlashMessage;
use App\Domain\Models\showModel;
use App\Domain\Models\bookingModel;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Helpers\SessionManager;


class BookingController extends BaseController
{
    public function __construct(Container $container, private showModel $showModel, private bookingModel $booking_model)
    {
        parent::__construct($container);
    }


    public function checkout(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        var_dump($data['seats']);

        //var_dump($data['schedule_id']);
        $showing = SessionManager::get('schedule');
        //var_dump($showing[0]['showing_id']);
        //var_dump($showing[0]['base_price']);

        $seats = SessionManager::get('seats');
        //var_dump($seats['data']['seats']);
        $tickets = SessionManager::get('CheckoutData');

        //var_dump($tickets);
        $user = SessionManager::get('user');
        //var_dump($user['id']);
        ///exit;

        $this->booking_model->createBooking($user['id'], $showing[0]['showing_id'], $data['seats'],  $seats['data']['seats'], $showing[0]['base_price']);




        //$this->showModel->$this->bookingModel->createBooking

        // get previous transactions
        $existing = SessionManager::get('CheckoutData');

        if (!is_array($existing)) {
            $existing = [];
        }

        //$data['seats'];


        // add new transaction
        $existing[] = $data;


        // save back
        SessionManager::set('CheckoutData', $existing);



        return $response
            ->withHeader('Location', APP_BASE_URL . '/user/shows')
            ->withStatus(302);

        //return $this->render($response, 'user/checkout.php', [
        //  'data' => $data
        //]);
    }

    public function index(Request $request, Response $response, array $args): Response
    {
        $booking = SessionManager::get('booking', []);
        $totalItems = 0;

        foreach ($booking as $item) {
            $totalItems += $item['quantity'];
        }
        $grandTotal = 0;

        foreach ($booking as $item) {
            $grandTotal += $item['price'] * $item['quantity'];
        }

        return $this->render($response, 'booking/bookingIndexView.php', ['booking' => $booking, 'totalItems' => $totalItems, 'grandTotal' => $grandTotal]);
    }
    public function getBookedSeatIds(int $showingId): array
    {
        $sql = "SELECT r.seat_id
            FROM reservations r
            JOIN transactions t ON t.transaction_id = r.transaction_id
            WHERE r.showing_id = :showing_id
            AND t.status != 'cancelled'";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':showing_id' => $showingId]);

        return array_column($stmt->fetchAll(), 'seat_id');
    }
    public function tickets(Request $request, Response $response, array $args): Response
    {
        $showing = SessionManager::get('schedule');
        //var_dump($showing[0]['showing_id']);
        //var_dump($showing[0]['base_price']);

        $seats = SessionManager::get('seats');
        var_dump($seats);
        //exit;
        $user = SessionManager::get('user');

        $data = $this->booking_model->getFullBookingsByUserId($user['id']);




        return $this->render($response, 'user/tickets.php', ['data' => $data]);
    }
    public function getScheduleForBooking(Request $request, Response $response, array $args): Response
    {


        //this id is the actual show id
        $id = (int)$args['id'];
        $show = $this->showModel->getByShowId($id);


        SessionManager::set('showTitle', $show["title"]);

        //var_dump($id);


        // get the ID from URL
        $show = $this->showModel->getByShowId($id);



        //$poster = $this->showModel->getPosterByShowId($id);
        $schedules = $this->showModel->getSchedulesByShowId($id);

        // fetch poster data
        return $this->render($response, 'user/bookingSchedule.php', ['show' => $show,  'schedules' => $schedules]);
    }
    public function getSelectedId(Request $request, Response $response, array $args): Response
    {


        //this id is the actual show id
        $id = $request->getParsedBody();
        return $this->render($response, 'user/bookingSchedule.php', ['schedule_id' => $id]);
    }



    public function seatSelect(Request $request, Response $response, array $args): Response
    {
        //shoing id is parsing
        $body = $request->getParsedBody();
        $scheduleId = (int)$body;


        $schedule = $this->showModel->getSchedulesByShowingId($scheduleId);



        SessionManager::set('schedule', $schedule);

        $row_A = $this->showModel->getSeatsByRow("A");
        $row_B = $this->showModel->getSeatsByRow("B");
        $row_C = $this->showModel->getSeatsByRow("C");


        $bookedSeatIds = $this->booking_model->getBookedSeatIds($scheduleId);


        $data = ["row_A" => $row_A, "row_B" => $row_B, "row_C" => $row_C, "bookedSeatIds" => $bookedSeatIds];






        //$showingId = (int) ($data['showing_id'] ?? 0);

        return $this->render($response, 'user/seats.php', $data);
    }


    public function SelectedScheduleId(int $id): int
    {
        return $id;
    }

    public function renderShows(Request $request, Response $response, array $args): Response
    {
        $shows = $this->showModel->getAllShows();
        return $this->render($response, 'admin/shows.php', $shows);
    }


    //the step before the reservation its select the seat and show ticket for purchaise;

    public function renderSeat(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        //$seats = $data['seats'] ?? [];
        $data = ["data" => $data];



        //SessionManager::set('seats', $data);





        // TODO: save $seats to DB here

        // Redirect to your booking confirmation page using its Slim route NAME

        return $this->render($response, 'user/booking.php', $data);
    }

    public function add(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $bookingId = (int)($data['booking_id'] ?? 0);

        if ($bookingId <= 0) {
            FlashMessage::add('error', "Invalid booking ID");
            return $this->render($response, 'booking.add', []);
        }

        // Fetch booking from DB
        $booking = $this->bookingsModel->findById($bookingId);

        if (!$booking) {
            FlashMessage::add('error', "Booking not found.");
            return $this->render($response, 'booking.add', []);
        }

        // Get session data
        $sessionBooking = SessionManager::get('booking', []);

        // Add or update
        if (isset($sessionBooking[$bookingId])) {
            $sessionBooking[$bookingId]['quantity']++;
        } else {
            $sessionBooking[$bookingId] = [
                'id' => $booking['id'],
                'name' => $booking['name'],
                'price' => $booking['price'],
                'quantity' => 1
            ];
        }

        // Save session
        SessionManager::set('booking', $sessionBooking);

        FlashMessage::add('success', $booking['name'] . ' added successfully.');

        return $this->render($response, 'booking.add', [
            'booking' => $sessionBooking
        ]);
    }
    public function update(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $bookingId = (int)($data['booking_id'] ?? 0);
        $quantity  = (int)($data['quantity'] ?? 0);

        $bookings = SessionManager::get('booking', []);

        if (!isset($bookings[$bookingId])) {
            FlashMessage::add('error', "Booking not found in your list.");
            return $this->redirect($request, $response, 'booking.index');
        }

        // Remove if quantity <= 0
        if ($quantity <= 0) {
            unset($bookings[$bookingId]);
            SessionManager::set('booking', $bookings);

            FlashMessage::add('success', "Booking removed from your list.");
            return $this->redirect($request, $response, 'booking.index');
        }

        // Update quantity
        $bookings[$bookingId]['quantity'] = $quantity;

        SessionManager::set('booking', $bookings);

        FlashMessage::add('success', "Booking quantity updated.");

        return $this->redirect($request, $response, 'booking.index');
    }
    public function remove(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $bookingId = (int)($data['booking_id'] ?? 0);

        $bookings = SessionManager::get('booking', []);

        if (isset($bookings[$bookingId])) {
            unset($bookings[$bookingId]);
            SessionManager::set('booking', $bookings);

            FlashMessage::add('success', "Booking removed successfully.");
        } else {
            FlashMessage::add('error', "Booking not found.");
        }

        return $this->redirect($request, $response, 'booking.index');
    }
    public function clear(Request $request, Response $response, array $args): Response
    {
        SessionManager::remove('booking');

        FlashMessage::add('success', "Your booking list has been cleared.");

        return $this->redirect($request, $response, 'booking.index');
    }
}
