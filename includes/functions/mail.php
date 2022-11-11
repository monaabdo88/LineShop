<?php
/*ini_set("display_errors", 1); 
error_reporting(E_ALL);*/
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require_once "/home/u482489328/public_html/backend/LineShop/vendor/autoload.php";

/*
function to add new subscriber
*/
if(! function_exists('add_mail')){
    function add_mail(){
        global $con;
        $errors = array();
        $email = $_POST['email'];
        
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['error'] = 'Not a valid email';
        }
        elseif(checkItem('email','mails',$email) > 0){
            $errors['error'] = 'This Email is Already Added';
        }
        else{
            $stmt = $con->prepare("INSERT INTO mails(email) VALUES(:zemail)");
            $stmt->execute(array('zemail' => $email));
            $errors['success'] = "Subscribe Done Successfully";

        }
        return $errors;
    }
}
/*
function to send email in contact page
*/
/*
if(!function_exists('send_email')){
    function send_email(){
        $errors = array();

        $email      = $_POST['email'];
        $name       = $_POST['name'];
        $subject    = $_POST['subject'];
        $message    = validate_msg($_POST['message']);
        $phone      = $_POST['phone'];
        $to_email = "monaabdo88@gmail.com";
        if(!$email || !$name || ! $subject || !$phone || !$message){
            $errors['error'] = 'All fields are Required';
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['error'] = 'Not a valid email';
        }else{
            $headers = 'From: '.$email;
            mail($to_email,$subject,$message,$headers);
            $errors['success'] = 'Thank You for connecting with us We Will connect back with you soon';

        }
        return $errors;
    }
}

*/
if(!function_exists('send_email')){
    function send_email(){
        $errors = array();
        $email      = $_POST['email'];
        $name       = $_POST['name'];
        $subject    = $_POST['subject'];
        $message    = validate_msg($_POST['message']);
        $phone      = $_POST['phone'];
        $to_email   = "lineshope@mona-abdo.com";
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $email = $_POST['email'];
            //validation
            if(!$email || !$name || ! $subject || !$phone || !$message){
                $errors['error'] = 'All fields are Required';
            }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['error'] = 'Not a valid email';
            }
            else{
                $mail = new PHPMailer();
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER; 
                //Enable verbose debug output
                
                //$message = str_replace('%link%', $link, $message);
                //$mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'imap.hostinger.com';                    //Set the SMTP server to send through
               // $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'lineshope@mona-abdo.com';                     //SMTP username
                $mail->Password   = '@Jskdl2012';                           //SMTP password
                //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 993;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
                //Recipients
                $mail->setFrom($email, $name);
                $mail->addAddress('lineshope@mona-abdo.com', 'Mona AbdoLine Shop');
                //Content
                $mail->Subject = $subject;
                $mail->Body    = $message;
                $mail->isHTML(true);
                $mail->CharSet="utf-8";//Set email format to HTML
                //$mail->Body = '<p><b> Hello '.$username.' Click On This Link to Reset Password </b></p>';
                //$mail->Body.='<a class="btn btn-primary" href="'.$link.'">Reset Password</a>'; 
                
                //$mail->AltBody = 'Update Your Password in LineShop';
            
                if($mail->send())
                    $errors['success'] =  'Message has been sent';
                else
                    $errors['error'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            
                                            
            }
                
                
                
                
                
            /*$mail = new PHPMailer();

            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'imap.hostinger.com';                    //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'lineshope@mona-abdo.com';                     //SMTP username
                $mail->Password   = '@Jskdl2012';                           //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 993;   
                //Recipients
                $mail->setFrom($email, $name);
                $mail->addAddress('lineshope@mona-abdo.com', 'Mona AbdoLine Shop');     //Add a recipient

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body    = $message;
               
                $mail->send();
                $errors['success'] =  'Message has been sent';
            } catch (Exception $e) {
                $errors['error']  = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }*/
                                            
            }
            return $errors;
        }
        
    }

/*
function to validate message
take one param message
*/
if(! function_exists('validate_msg')){
    function validate_msg($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
         
    }
}