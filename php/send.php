<?php
session_start();
$_SESSION['errors'] = array();



    $name = $tele = $email = $message = $dsgvo = '';

    $notHuman = 'unchecked';
    $isHuman =  'unchecked';

    

	if ($_SERVER["REQUEST_METHOD"] == "POST") {


        if (isset($_POST["name"])) {   

            if (empty($_POST["name"])) {
                $_SESSION['errors']['name'] = 'Bitte geben Sie Ihren Namen an';
                
            } elseif (ctype_space($_POST["name"])) {
                $_SESSION['errors']['name'] = 'Bitte geben Sie Ihren Namen an';

            } elseif (!preg_match("/^[a-zA-Z ]*$/",$_POST["name"])) {
                $_SESSION['errors']['name'] = 'Bitte überprüfen Sie Ihre Eingabe';

            } else {
                $name = test_input($_POST["name"]);
            }

        }


        if (isset($_POST["tele"])) {   

            if (empty($_POST["tele"])) {
                $_SESSION['errors']['tele'] = 'Btte geben Sie Ihre Telefonnummer an';
                
            } elseif (ctype_space($_POST["tele"])) {
                $_SESSION['errors']['tele'] = 'Btte geben Sie Ihre Telefonnummer an';
                
            } elseif (preg_match("/^[a-zA-Z ]*$/",$_POST["tele"])) {
                $_SESSION['errors']['tele'] = 'Bitte überprüfen Sie Ihre Eingabe';

            } else {
                $tele = test_input($_POST["tele"]);
            }

        }


        if (isset($_POST["email"])) { 
            
            $mailTest = $_POST["email"];

            if (empty($_POST["email"])) {
                $_SESSION['errors']['email'] = 'Bitte geben Sie Ihre E-Mail Adresse an';
                
            } elseif (ctype_space($_POST["email"])) {
                $_SESSION['errors']['email'] = 'Bitte geben Sie Ihre E-Mail Adresse an';
                
            } elseif (!filter_var($mailTest,FILTER_VALIDATE_EMAIL)) {
                $_SESSION['errors']['email'] = 'Bitte überprüfen Sie Ihre Eingabe';

            } else {
                $email = test_input($_POST["email"]);
            }

        }


        if (isset($_POST["msg"])) {   

            if (empty($_POST["msg"])) {
                $_SESSION['errors']['msg'] = 'Bitte teilen Sie uns Ihr Anliegen mit';
                
            } elseif (ctype_space($_POST["msg"])) {
                $_SESSION['errors']['msg'] = 'Bitte teilen Sie uns Ihr Anliegen mit';
                
            } else {
                $message = test_input($_POST["msg"]);
            }

        }


        if (!isset($_POST["dsgvo"])) {   

            $_SESSION['errors']['dsgvo'] = 'Bitte bestätigen Sie, dass Sie unsere Datenschutzvereinbarung gelesen haben und akzeptieren.';
                
        } elseif (isset($_POST["dsgvo"])) {
            $dsgvo = 'checked';
        }

        //Honeypot
        if (isset($_POST["confirm"])) {   

           $notHuman = 'checked';
                
        }

         if (isset($_POST["confirm-human"])) {   

            $isHuman = 'checked';
                 
         }

        //Error Handling
        if (count($_SESSION['errors']) > 0) {

            echo json_encode($_SESSION['errors']);

        }

    }

    if (!empty($name) && !empty($tele) && !empty($email) && !empty($message) && $dsgvo === 'checked') {


            $mailTo = 'your@mail.com';
            $subject = "Anfrage von $name";
            $headers = "From: $email"; 
            $mailContent = "$message\n\n Ich bitte um Rückruf unter: $tele";
            
            

            if (!empty($_POST["website"]) && $isHuman === 'unchecked') {
                die('spam detected');
    
            } elseif (!empty($_POST["website"]) && $notHuman === 'checked') {
                die('spam detected');
    
            } elseif (!empty($_POST["website"]) && $isHuman === 'checked' && $notHuman === 'unchecked'){
                mail($mailTo, $subject, $mailContent, $headers);
    
            } else {
                mail($mailTo, $subject, $mailContent, $headers);
            }

            echo json_encode('success');
        
    }


    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    



?>