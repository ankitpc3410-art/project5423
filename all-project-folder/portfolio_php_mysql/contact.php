<?php
require __DIR__ . '/config.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('index.php#contact');
csrf_check();
$name = trim($_POST['name'] ?? ''); $email = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? ''); $message = trim($_POST['message'] ?? '');
if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $message === '' || strlen($message) > 5000) {
    flash('Please enter a valid name, email and message.', 'danger'); redirect('index.php#contact');
}
$stmt = db()->prepare('INSERT INTO messages (name,email,subject,message) VALUES (?,?,?,?)');
$stmt->execute([$name,$email,$subject,$message]);
redirect('index.php?sent=1#contact');
