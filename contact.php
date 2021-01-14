<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["name"]));
				$name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $message = $_POST["message"];
        $message = "Nombre: " . $name . "\r\n" . "Email: " . $email . "\r\n" . "Mensaje: " .  $message;
		
        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Lo sentimos pero su mensaje no ha sido enviado\n";
			echo "Inténtelo más tarde.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "copps@pmi.org.pe";

        // Set the email subject.
        $subject = "Nuevo correo de : $name";

        // Build the email content.
        $email_content = "Mensaje:\n\n$message";

        // Send the email.
        if (mail($recipient, $subject, $email_content)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Muchas gracias por escribir.\r\n";
			echo "Nos estaremos contactando contigo pronto.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
			echo "Lo sentimos pero su mensaje no ha sido enviado.\r\n";
			echo "Inténtelo más tarde.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
		http_response_code(403);
        echo "Lo sentimos pero su mensaje no ha sido enviado.\r\n";
		echo "Inténtelo más tarde.";
    }
?>