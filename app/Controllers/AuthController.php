<?php

namespace App\Controllers;

use Exception;
use App\Domain\Models\UserModel;
use App\Helpers\FlashMessage;
use App\Helpers\SessionManager;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Controller for authentication
 */
class AuthController extends BaseController
{
    /**
     * Constructor for Auth controller
     * @param Container $container
     * @param UserModel $userModel
     */
    public function __construct(Container $container, private UserModel $userModel)
    {
        parent::__construct($container);
    }

    /**
     * Renders register page
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function register(Request $request, Response $response, array $args): Response
    {
        $data['data'] = [
            'title' => 'Register | Create a new account',
        ];

        if (isset($_SESSION["account_info"])) {
            $data['data']['account_info'] = $_SESSION["account_info"];
            unset($_SESSION["account_info"]);
        }
        return $this->render($response, "auth/register.php", $data);
    }

    /**
     * Handles account creation
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function store(Request $request, Response $response, array $args): Response
    {
        $form_data = $request->getParsedBody();

        $return_to_form = false;
        if (!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
            FlashMessage::error('Enter a valid email');
            $return_to_form = true;
        }
        if ($this->userModel->emailExists($form_data['email'])) {
            FlashMessage::error('This email is already registered');
            $return_to_form = true;
        }
        // regex string to match 8 characters or more
        if (
            !preg_match("/^.{8,}$/i", $form_data['password']) &&
            // regex string to match any digit
            !preg_match("/\d/", $form_data['password'])
        ) {
            FlashMessage::error('Password must be at least 8 characters long and contain a number');
            $return_to_form = true;
        }
        if ($form_data['password'] !== $form_data['confirm_password']) {
            FlashMessage::error('Passwords do not match');
            $return_to_form = true;
        }

        if ($return_to_form) {
            SessionManager::set("account_info", $form_data);
            return $this->redirect($request, $response, 'auth.register');
        }

        $userParams = [
            'first_name' => $form_data['first_name'],
            'last_name' => $form_data['last_name'],
            'username' => $form_data['username'],
            'email' => $form_data['email'],
            'password' => $form_data['password']
        ];
        try {
            $accountId = $this->userModel->createUser($userParams);
            FlashMessage::success("Created user #$accountId");
            return $this->render($response, '/auth/login.php');
        } catch (Exception $e) {
            FlashMessage::error($e->getMessage());
            return $this->redirect($request, $response, 'auth.register');
        }
    }

    //* Authentication Lab Methods (login, logout, etc.) would go here
    /**
     * Display the login form (GET request).
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function login(Request $request, Response $response, array $args): Response
    {
        // TODO: Create a $data array with 'title' => 'Login'
        $data = [
            'title' => 'Login'
        ];

        // TODO: Render 'auth/login.php' view and pass $data
        return $this->render($response, 'auth/login.php', $data);
    }

    /**
     * Process login form submission (POST request).
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function authenticate(Request $request, Response $response, array $args): Response
    {
        // TODO: Extract the identifier and password from the submitted form
        $form_data = $request->getParsedBody();

        // TODO: Validate that both fields are present
        if (isset($form_data['identifier']) && isset($form_data['password'])) {
            // TODO: Attempt to verify the credentials using the UserModel
            $user = $this->userModel->verifyCredentials($form_data['identifier'], $form_data['password']);
            // TODO: If authentication fails, display an error and redirect to the login page
            if ($user === null) {
                FlashMessage::error('Invalid Credentials.');
                return $this->redirect($request, $response, 'auth.login');
            }
            // TODO: Store the authenticated user's data in the session
            //       (ID, email, full name, role, and a flag indicating they are authenticated)
            SessionManager::set('user', [
                'id' => $user['id'],
                'email' => $user['email'],
                'full_name' => $user['first_name'] . ' ' . $user['last_name'],
                'role' => $user['role'],
                'is_authenticated' => true
            ]);
            // TODO: Display a welcome message and redirect based on role:
            //       admins go to the admin dashboard, customers go to the user dashboard
            FlashMessage::success("Welcome back, {$user['first_name']}!");


            if ($user['role'] === 'admin') {
                return $this->redirect($request, $response, 'admin.dashboard');
            } else {
                return $this->redirect($request, $response, 'user.dashboard');
            }
        }
        FlashMessage::error('Please input credentials');
        return $this->redirect($request, $response, 'auth.login');
    }

    /**
     * Logout the current user (GET request).
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function logout(Request $request, Response $response, array $args): Response
    {
        // TODO: Destroy the session, display a success message, and redirect to the login page
        $existingFlashes = $_SESSION['flash_messages'] ?? [];

        SessionManager::destroy();
        SessionManager::start();

        if (!empty($existingFlashes)) {
            $_SESSION['flash_messages'] = $existingFlashes;
        }

        FlashMessage::success('You have successfully logged out');
        return $this->redirect($request, $response, 'auth.login');
    }

    /**
     * Displays user dashboard (protected route)
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function dashboard(Request $request, Response $response, array $args): Response
    {
        // TODO: Create a $data array with 'title' => 'Dashboard'
        $data = [
            'title' => 'Dashboard'
        ];

        // TODO: Render 'user/dashboard.php' view and pass $data
        return $this->render($response, 'user/dashboard.php', $data);
    }
}
