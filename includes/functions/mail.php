<?php 
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