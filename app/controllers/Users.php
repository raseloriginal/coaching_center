<?php
class UsersController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = $this->model('User');
    }

    public function login() {
        // Check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Init data
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',
            ];

            // Validate Email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            }

            // Validate Password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }

            // Check for user/email
            if ($this->userModel->findUserByEmail($data['email'])) {
                // User found
            } else {
                // User not found
                $data['email_err'] = 'No user found';
            }

            // Make sure errors are empty
            if (empty($data['email_err']) && empty($data['password_err'])) {
                // Validated
                // Check and set logged in user
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedInUser) {
                    // Create Session
                    $this->createUserSession($loggedInUser);
                    log_action('LOGIN', 'User logged into administration panel');
                } else {
                    $data['password_err'] = 'Password incorrect';
                    $this->view('users/login', $data);
                }
            } else {
                // Load view with errors
                $this->view('users/login', $data);
            }

        } else {
            // Init data
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
            ];

            // Load view
            $this->view('users/login', $data);
        }
    }

    public function createUserSession($user) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_role'] = $user->role ?? 'super_admin';
        $this->redirect('pages/dashboard');
    }

    public function logout() {
        log_action('LOGOUT', 'User logged out');
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_role']);
        session_destroy();
        $this->redirect('users/login');
    }

    // =====================
    // USER MANAGEMENT
    // =====================
    public function manage() {
        $this->middleware('RoleMiddleware', ['only' => ['manage', 'add', 'edit', 'delete'], 'roles' => ['super_admin']]);
        
        $users = $this->userModel->getAllUsers();
        $data = [
            'users' => $users
        ];
        $this->view('users/manage', $data);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'role' => $_POST['role'],
                'name_err' => '',
                'email_err' => '',
                'password_err' => ''
            ];

            if (empty($data['name'])) $data['name_err'] = 'Name is required';
            if (empty($data['email'])) $data['email_err'] = 'Email is required';
            elseif ($this->userModel->findUserByEmail($data['email'])) $data['email_err'] = 'Email already exists';
            if (empty($data['password'])) $data['password_err'] = 'Password is required';

            if (empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                if ($this->userModel->register($data)) {
                    log_action('ADD_ADMIN', "Added new admin user: {$data['name']} ({$data['role']})");
                    flash('user_message', 'Admin user added successfully');
                    $this->redirect('users/manage');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('users/add', $data);
            }
        } else {
            $data = [
                'name' => '', 'email' => '', 'password' => '', 'role' => 'super_admin',
                'name_err' => '', 'email_err' => '', 'password_err' => ''
            ];
            $this->view('users/add', $data);
        }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'role' => $_POST['role'],
                'name_err' => '', 'email_err' => ''
            ];

            if (empty($data['name'])) $data['name_err'] = 'Name is required';
            if (empty($data['email'])) $data['email_err'] = 'Email is required';

            if (empty($data['name_err']) && empty($data['email_err'])) {
                if (!empty($data['password'])) {
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                }
                
                if ($this->userModel->update($data)) {
                    log_action('UPDATE_ADMIN', "Updated admin user: {$data['name']} (ID: {$data['id']})");
                    flash('user_message', 'User updated');
                    $this->redirect('users/manage');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('users/edit', $data);
            }
        } else {
            $user = $this->userModel->getUserById($id);
            $data = [
                'id' => $id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'name_err' => '', 'email_err' => ''
            ];
            $this->view('users/edit', $data);
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($id == $_SESSION['user_id']) {
                flash('user_message', 'You cannot delete yourself!', 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4');
            } else {
                if ($this->userModel->delete($id)) {
                    log_action('DELETE_ADMIN', "Deleted admin user with ID: {$id}");
                    flash('user_message', 'User removed');
                }
            }
            $this->redirect('users/manage');
        }
    }
}
