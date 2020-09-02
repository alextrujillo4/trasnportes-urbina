<?php

// configure
$from = 'email@domain.com';
$sendTo = 'ventas@transportesurbina.com, urbina_express@hotmail.com';
$subject = 'Nuevo mensaje desde WEB de: ' . $_POST['email'];
$fields = array('name' => 'First Name', 'surname' => 'Last Name', 'phone' => 'Phone', 'email' => 'Email', 'message' => 'Message'); // array variable name => Text to appear in the email
$okMessage = 'Gracias por tu mensaje, te responderemos lo más pronto posible!';
$errorMessage = 'Hay un error al enviar el mensaje. Por favor intenta más tarde';

try{
    $emailText = "Tienes un nuevo mensaje<br>=============================<br>";
    foreach ($_POST as $key => $value) {
        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value<br>";
        }
    }

    $headers = array('Content-Type: text/html; charset="UTF-8";',
        'From: ' . $_POST['email'],
        'Reply-To: ' . $_POST['email'],
        'Return-Path: ' . $from,
    );

    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}catch (\Exception $e){
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);
    header('Content-Type: application/json');
    echo $encoded;
}else {
    echo $responseArray['message'];
}
