<?php

// Vérification du token de sécurité.
check_admin_referer('feedback','nonce_feedback_field');

//Send feedback by mail
$to      = 'feedback@dark-sides.com';
$subject = 'Feedback WSI';
$message = "<html><head><title>Feedback WSI</title></head><body>";
$message.= $_POST['feedback_message'];
if ($_POST['feedback_sendInfos']) {
	$message.= "\n\n".$this->get_system_info();
}
$message.= "</body></html>";

// Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
$headers = 'MIME-Version: 1.0' . "\r\n";
$headers.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers.= 'From: '.$_POST['feedback_email'];

mail($to, $subject, $message, $headers);

?>