<?php

namespace App\Controllers;

use App\Helpers\FlashMessage;
use App\Domain\Models\showModel;
use App\Domain\Models\bookingModel;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Helpers\SessionManager;

/**
 * BookingController is the controller used for booking seats
 */
class BookingController extends BaseController
{
    /**
     * Constructor for BookingController
     * @param Container $container
     * @param showModel $showModel
     * @param bookingModel $bookingModel
     */
    public function __construct(Container $container, private showModel $showModel, private bookingModel $bookingModel)
    {
        parent::__construct($container);
    }

    public function checkout(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody() ?? [];
        $user = SessionManager::get('user');
        $showing = SessionManager::get('schedule');

        if (!$user) {
            FlashMessage::error('You must be logged in.');
            return $this->redirect($request, $response, 'auth.login');
        }

        if (empty($showing) || !isset($showing[0]['showing_id'])) {
            FlashMessage::error(t('booking.error_incomplete'));
            return $this->redirect($request, $response, 'posters.index');
        }

        $selectedSeats = $data['seats'] ?? [];
        if (!is_array($selectedSeats) || $selectedSeats === []) {
            $seatSession = SessionManager::get('seats', []);
            $selectedSeats = $seatSession['data']['seats'] ?? [];
        }

        if (!is_array($selectedSeats) || $selectedSeats === []) {
            FlashMessage::error(t('booking.error_no_seats'));
            return $this->redirect($request, $response, 'posters.index');
        }

        $selectedSeats = array_values(array_map('intval', $selectedSeats));
        $showingRow = $showing[0];

        $this->bookingModel->createBooking(
            (int) $user['id'],
            (int) $showingRow['showing_id'],
            $selectedSeats,
            $selectedSeats,
            (float) $showingRow['base_price']
        );

        SessionManager::remove('schedule');
        SessionManager::remove('seats');
        SessionManager::remove('showTitle');

        FlashMessage::success(t('booking.success'));

        return $response
            ->withHeader('Location', APP_BASE_URL . '/user/tickets')
            ->withStatus(302);
    }

    /**
     * Display the booking index with session cart data.
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
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

    public function tickets(Request $request, Response $response, array $args): Response
    {
        $user = SessionManager::get('user');
        if (!$user) {
            FlashMessage::error('You must be logged in.');
            return $this->redirect($request, $response, 'auth.login');
        }

        $data = $this->bookingModel->getFullBookingsByUserId((int) $user['id']);

        return $this->render($response, 'user/tickets.php', ['data' => $data]);
    }

    /**
     * Gets the schedule of the show from args and re-renders the booking page
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
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

    /**
     * Renders the bookingSchedule page with the given schedule_id
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function getSelectedId(Request $request, Response $response, array $args): Response
    {


        //this id is the actual show id
        $id = $request->getParsedBody();
        return $this->render($response, 'user/bookingSchedule.php', ['schedule_id' => $id]);
    }

    /**
     * Fetches available seats and uses the data to render seats page
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function seatSelect(Request $request, Response $response, array $args): Response
    {
        $body = $request->getParsedBody() ?? [];
        $scheduleId = (int) ($body['showing_id'] ?? 0);

        if ($scheduleId <= 0) {
            FlashMessage::error(t('booking.error_incomplete'));
            return $this->redirect($request, $response, 'posters.index');
        }

        $schedule = $this->showModel->getSchedulesByShowingId($scheduleId);

        if (empty($schedule)) {
            FlashMessage::error(t('booking.error_incomplete'));
            return $this->redirect($request, $response, 'posters.index');
        }

        SessionManager::set('schedule', $schedule);

        $row_A = $this->showModel->getSeatsByRow("A");
        $row_B = $this->showModel->getSeatsByRow("B");
        $row_C = $this->showModel->getSeatsByRow("C");

        $bookedSeatIds = $this->bookingModel->getBookedSeatIds($scheduleId);

        $data = ["row_A" => $row_A, "row_B" => $row_B, "row_C" => $row_C, "bookedSeatIds" => $bookedSeatIds];

        return $this->render($response, 'user/seats.php', $data);
    }

    /**
     * Getter function
     * @param int $id
     * @return int
     */
    public function SelectedScheduleId(int $id): int
    {
        return $id;
    }

    /**
     * Renders shows page
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function renderShows(Request $request, Response $response, array $args): Response
    {
        $shows = $this->showModel->getAllShows();
        return $this->render($response, 'admin/shows.php', $shows);
    }


    //the step before the reservation its select the seat and show ticket for purchaise;

    /**
     * The step before the reservation, select the seat and show ticket for purchase
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function renderSeat(Request $request, Response $response, array $args): Response
    {
        $body = $request->getParsedBody() ?? [];
        $selectedSeats = $body['seats'] ?? [];

        if (!is_array($selectedSeats) || $selectedSeats === []) {
            FlashMessage::error(t('booking.error_no_seats'));
            return $this->redirect($request, $response, 'posters.index');
        }

        SessionManager::set('seats', ['data' => ['seats' => array_values(array_map('intval', $selectedSeats))]]);

        return $this->render($response, 'user/booking.php', ['data' => $body]);
    }

    /**
     * Deals with ticket booking logic
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function add(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $bookingId = (int)($data['booking_id'] ?? 0);

        if ($bookingId <= 0) {
            FlashMessage::add('error', "Invalid booking ID");
            return $this->render($response, 'booking.add', []);
        }

        // Fetch booking from DB
        $booking = $this->bookingModel->findById($bookingId);

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

    /**
     * Updates bookings
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
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

    /**
     * Removes booking
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
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

    /**
     * Clears your bookings
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function clear(Request $request, Response $response, array $args): Response
    {
        SessionManager::remove('booking');

        FlashMessage::add('success', "Your booking list has been cleared.");

        return $this->redirect($request, $response, 'booking.index');
    }

    public function renderTransactionsPage(Request $request, Response $response, array $args): Response
    {
        $transactions = $this->bookingModel->getAllTransactions();


        return $this->render($response, 'admin/transactions.php', ['data' => $transactions]);
    }
}
