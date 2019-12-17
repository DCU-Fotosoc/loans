<?php
/*
$db = mysqli_connect('localhost','root','root','test_users');


$user = "";
$equipment = "";

$notes = "";
$errors = array();

if (isset($_POST['request'])){
    $user = $_SESSION['username'];
    $equipment = $_POST['Equipments'];
    $notes = $_POST['purpose'];

    if(empty($notes)) {array_push($errors,"This field should not be empty");}

        $hash = md5( rand(0,1000) );
        $requestdate = DateTime();

        $query = "INSERT INTO allrequests (User,Equipment,Notes,DateRequested,Hash,Action) VALUES ('$user','$equipment','$notes','$requestdate','$hash', 'Check-Out')";

        mysqli_query($db,$query);

        header("Location: index2.php?sent=1");



}
*/
include('serverconnect.php');
session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location: index.php');
    exit();
}


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'assets/src/Exception.php';
require 'assets/src/PHPMailer.php';
require 'assets/src/SMTP.php';

$db = mysqli_connect('remotemysql.com', 'tgsK9nTZNV', 'UFJLMZcF2L', 'tgsK9nTZNV');


$user = "";
$equipment = "";
$notes = "";
$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $user = $_SESSION['name'];
    $equipment = $_POST['equipment'];
    $notes = $_POST['purpose'];
    $hash = md5(rand(0, 1000));
    $requestdate = date('Y-m-d H:i:s');

    echo $equipment;
    echo $notes;
    echo $hash;

    $query = "INSERT INTO allrequests (User,Equipment,Notes,Hash,Action) VALUES ('$user','$equipment','$notes','$hash', 'Check-Out')";

    mysqli_query($db, $query);

    header("Location: home.php?sent=1");

    /*    $to = '***REMOVED***'; // Send email to our user
        $subject = 'Signup | Verification'; // Give the email a subject
        $message = '

    Thanks for signing up!
    Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.

    ------------------------
    Username: ' . $user . '
    Password: ' . $notes . '
    ------------------------

    Please click this link to activate your account:
    http://www.yourwebsite.com/verify.php?hash=' . $hash . '

    '; // Our message above including the link

        $headers = 'From:***REMOVED***' . "\r\n"; // Set from headers
        mail($to, $subject, $message, $headers); // Send our email*/


    $mail = new PHPMailer;

    $mail->isSMTP();                            // Set mailer to use SMTP
    $mail->Host = '***REMOVED***';             // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                     // Enable SMTP authentication
    $mail->Username = '***REMOVED***';          // SMTP username
    $mail->Password = '***REMOVED***'; // SMTP password
    $mail->SMTPSecure = 'tls';                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port = ***REMOVED***;                          // TCP port to connect to

    $mail->setFrom('***REMOVED***', '***REMOVED***');
    $mail->addReplyTo('***REMOVED***', ':***REMOVED***');
    $mail->addAddress('***REMOVED***');   // Add a recipient

    $mail->isHTML(true);  // Set email format to HTML

    $bodyContent = '<p>The following user has requested to borrow an equipment:
<br> 
----------------------------------------------------------<br>
Equipment: '. $equipment .' <br>
Name: ' . $user . ' <br>
Notes: ' . $notes . '<br>
----------------------------------------------------------
<br>
Please click this link to approve this check out:
http://localhost:81/EquipManage/verify.php?hash='.$hash.'</p>';

    $mail->Subject = 'Equipment Approval';
    $mail->Body = $bodyContent;

    if (!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }


}


