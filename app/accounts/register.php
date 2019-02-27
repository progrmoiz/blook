<?php
    require_once LIB . 'formr/class.formr.php';
    require_once LIB . 'user/get_user_by_uname.php';

    if (isUserLoggedIn()) {
        header ("Location: " . ROOT);
        die();
    }

    $form = new Formr();


    if(!isset($_SESSION))
    {
        session_start();
    }

    // make all fields required
    $form->required = '*';

    $username = $email = $full_name = "";

    // check if the form was submitted
    if($form->submit()) {

        // process and validate the POST data
        $username   = $form->post('uname','Username','slug');
        $email      = $form->post('email','Email','valid_email|sanitize_email');
        $full_name  = $form->post('full_name','Full Name','sanitize_string');
        $password   = $form->post('passwd','Password','min_length[6]|hash');
        $pass_conf  = $form->post('passwd_conf','Confirm Password','min_length[6]|matches[passwd]');
        $agree      = $form->post('agree', 'Terms of services');

        // check if there were any errors
        if(!$form->errors()) {
            $user = get_user_by_uname($username);
            if($user) {
                $form->errors['uname'] = 'This username is already taken. Please try another one.';
            } else {
            // no errors
            // user has entered a valid email address, username, and confirmed their password
            $registration = $db->prepare("INSERT INTO `userAccount` (`username`, `name`, `email`, `hashedPassword`, `createdAt`, `isAdmin`) VALUES (?, ?, ?, ?, ?, ?)");

            $success = $registration->execute(
                array(
                    $username,
                    $full_name,
                    $email,
                    $password,
                    date(MYSQL_DATETIME),
                    0,
                    )
                );
                
                $_SESSION['login_user'] = $username;
                
                if ($location) {
                    header("Location: " . $location);
                } else {
                    header("Location: " . ROOT);
                }
            }
        }
    }

    // print messages
    // print_r($form->errors());
?>