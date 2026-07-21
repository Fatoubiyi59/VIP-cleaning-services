<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

$subject = 'New booking request';

$userEmail = trim($_POST['Email'] ?? '');
$to = 'info@vipcleaningservices.com';
if ($userEmail !== '' && filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
    $to = 'info@vipcleaningservices.com, ' . $userEmail;
}

$fields = [
    'First Name' => 'First Name',
    'Last Name' => 'Last Name',
    'Email' => 'Email',
    'Service Type' => 'Service Type',
    'Address' => 'Address',
    'Place Type' => 'Place Type',
    'Hours of Service' => 'Hours of Service',
    'Date' => 'Date',
    'Time' => 'Time',
    'Additional Information' => 'Additional Information'
];

$message = "New booking request:\n\n";
foreach ($fields as $label => $key) {
    $value = isset($_POST[$key]) ? trim($_POST[$key]) : '';
    $message .= $label . ': ' . $value . "\n";
}

$headers = "From: no-reply@vipcleaningservices.com\r\n";
$headers .= "Reply-To: " . ($userEmail !== '' ? $userEmail : 'no-reply@vipcleaningservices.com') . "\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

mail($to, $subject, $message, $headers);
header('Location: standard-cleaning.html?sent=1');
