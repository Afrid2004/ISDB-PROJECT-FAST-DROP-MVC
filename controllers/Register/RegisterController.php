<?php


class RegisterController
{
  function index()
  {
    view('');
  }

  function create()
  {
    if (isset($_POST['btn_submit'])) {
      // user role id by default role = user
      $role_id = 3;
      $name = trim($_POST['name']);
      $email = trim($_POST['email']);
      $password = trim($_POST['password']);
      $confpassword = trim($_POST['confpassword']);
      $passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&^#()_\-+=])[A-Za-z\d@$!%*?&^#()_\-+=]{6,}$/";

      //save all old data
      $_SESSION['old'] = [
        'name'      => $name,
        'email'     => $email,
      ];

      //if all field are empty then shpw error
      if (empty($name) || empty($email) || empty($password) || empty($confpassword)) {
        $_SESSION['error'] = "All fields are required!";
        redirect('register');
        exit;
      }

      // validate name length 
      if (strlen($name) < 3) {
        $_SESSION['error'] = "Name must be at least 3 characters.";
        redirect('register');
        exit;
      }

      // builin email validation 
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["error"] = "Invalid email address.";
        redirect("register");
        exit;
      }

      // email count validation 
      if (User::countUserEmail($email) >= 3) {
        $_SESSION["error"] = "Maximum 3 accounts can be created using this email.";
        redirect("register");
        exit;
      }

      // validate password
      if (!preg_match($passwordPattern, $password)) {
        $_SESSION["error"] = "Password must be at least 6 characters and contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
        redirect("register");
        exit;
      }

      // Password Match
      if ($password != $confpassword) {
        $_SESSION["error"] = "Passwords do not match.";
        redirect("register");
        exit;
      }

      //if all ok then save user data and redirect to login page
      $user = new User();
      $user->set(null, $role_id, $name, $email, password_hash($password, PASSWORD_DEFAULT));
      $data = $user->save();
      if ($data) {
        unset($_SESSION['old']);
        redirect("login");
        exit;
      }

      // if another error then show error 
      $_SESSION["error"] = "Registration failed.";
      redirect("register");
      exit;
    }
  }
}
