<?php
$counter = 0;
include("smtp/PHPMailerAutoload.php");
// echo $counter . "<br>";
$mail = new PHPMailer();
// echo $counter . "<br>";
// $mail->SMTPDebug = 3;
$mail->IsSMTP();
// echo $counter . "<br>";
$mail->SMTPAuth = true;
// echo $counter . "<br>";
$mail->SMTPSecure = 'TLS';
// echo $counter . "<br>";
$mail->Host = "smtp.gmail.com";
// echo $counter . "<br>";
$mail->Port = 587;
$mail->IsHTML(true);
// echo $counter . "<br>";
$mail->CharSet = 'UTF-8';
$mail->Username = "test.service.working@gmail.com";
$mail->Password = "lhefeqzbulvqxrml";
$mail->SetFrom("test.service.working@gmail.com");
function smtp_mailer($to, $subject, $msg)
{

    global $counter, $mail;
    $counter += 1;
    // echo $counter . "<br>";

    // echo $counter . "<br>";
    $mail->Subject = $subject;
    $mail->Body = $msg;
    // echo $counter . "<br>";
    $mail->ClearAddresses();
    $mail->AddAddress($to);
    // echo $counter . "<br>";
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => false
        )
    );
    // echo $counter . "<br>";
    // $mail->send();
    if (!$mail->Send()) {
        // echo $counter . " if <br>";
        echo $mail->ErrorInfo;
    } else {
        // echo $counter . " else <br>";
        return 'Sent';
    }
    echo $counter . " end <br>";
}

if (isset($_POST['sendBills'])) {

    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";

    $con = mysqli_connect($server, $username, $password, $dbname);

    if (!$con) {
        die("connection to this database failed due to" . mysqli_connect_error());
    }

    $sql = "SELECT box.ID as bid,name,email,Due_Amount,Due_Date_Time FROM customer,box
         WHERE customer.ID=box.Customer_ID AND Due_Date_Time>=NOW() AND Due_Date_Time<=DATE_ADD(NOW(), INTERVAL 1 MONTH)";

    $result = mysqli_query($con, $sql);
    // echo $result;
    while ($row = mysqli_fetch_assoc($result)) {
        $to = $row['email'];
        $subject = "Your bill is due";
        // $message = "Hi <h5>" . $row['name'] . "</h5>,\n\nThis is a reminder that your bill of <h5>$" . $row['Due_Amount']. "</h5> for <h4>Box ID ".$row['bid']  . "</h4> is due on <h5>" . $row['Due_Date_Time'] . "</h5>.\n\nPlease make the payment as soon as possible.\n\nThanks,\nThe Billing Team";
        $headers = "MIME-Version: 1.0" . "\r\n";
        // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        // generate email body
        $message = "<html><body>";
        $message .= "<h2>Hi " . $row['name'] . ",</h2>";
        $message .= "<p>This is a reminder that your bill of <b>$" . $row['Due_Amount'] . "</b> for <b>Box ID #" . $row['bid'] . "</b> is due on <b>" . $row['Due_Date_Time'] . "</b>.</p>";
        $message .= "<p>Please make the payment as soon as possible.</p>";
        $message .= "<p>Thanks,<br>The Billing Team</p>";
        $message .= "</body></html>";
        echo $row['name'];
        echo "<br>";
        echo $to;
        echo "<br>";
        smtp_mailer($to, $subject, $message);
        echo "Function returned";
    }
    echo "Emails sent successfully!";

    mysqli_close($con);
    // echo "ww";
}

?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>

<body>
    <form method="post">
        Hello Mr. Employee.. How are you?<br>
        Press the button to send bills<br>
        <button name='sendBills'>Send Bills</button>
    </form>
</body>

</html>