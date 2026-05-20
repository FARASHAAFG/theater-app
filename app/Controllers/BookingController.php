<?php

namespace App\Controllers;

use App\Helpers\FlashMessage;
use App\Domain\Models\showModel;
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
     */
    public function __construct(Container $container, private showModel $showModel)
    {
        parent::__construct($container);
    }

    /**
     * Display the admin dashboard with e-commerce statistics.
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
        //shoing id is parsing
        $body = $request->getParsedBody();
        $scheduleId = (int)$body;

        $schedule = $this->showModel->getSchedulesByShowingId($scheduleId);



        SessionManager::set('schedule', $schedule);

        $row_A = $this->showModel->getSeatsByRow("A");
        $row_B = $this->showModel->getSeatsByRow("B");
        $row_C = $this->showModel->getSeatsByRow("C");



        $data = ["row_A" => $row_A, "row_B" => $row_B, "row_C" => $row_C];






        //$showingId = (int) ($data['showing_id'] ?? 0);

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
        $data = $request->getParsedBody();

        //$seats = $data['seats'] ?? [];
        $data = ["data" => $data];



        // TODO: save $seats to DB here

        // Redirect to your booking confirmation page using its Slim route NAME

        return $this->render($response, 'user/booking.php', $data);
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
}
