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

   // check if the form was submitted
   if($form->submit()) {

    // process and validate the POST data
    $username   = $form->post('uname','Username','slug');
    $password   = $form->post('passwd','Password','min_length[6]');

    // check if there were any errors
    if(!$form->errors()) {
        // no errors
        $user = get_user_by_uname($username);

        if(!$user) {
            $form->errors['uname'] = "Sorry, $username is not recognized as an active username";
        } else {
            if (!password_verify($password, $user->hashedPassword)) {
                $form->errors['uname'] = "You have entered an invalid username or password";
            } else {
                $_SESSION['login_user'] = $username;
                
                if ($location) {
                    header("Location: " . $location);
                } else {
                    header("Location: " . ROOT);
                }
            }
        }

        // $_SESSION['login_user'] = $username;

        // header("Location: index.php");
    }
}