<?php 

// define variables and set to empty values
$name_error = $email_error = $message_error = "";
$name = $email = $message = $success = "";

//form is submitted with POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
      $name_error = "error";
      echo "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
        $name_error = "error";
        echo "Only letters and white space allowed";
    }
  }

  if (empty($_POST["email"])) {
      $email_error = "error";
      echo "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Invalid email format"; 
        echo "Invalid email format";
    }
  }
  
  if (empty($_POST["message"])) {
      $message_error = "error";
      echo "You must enter a message";
  } else {
    $message = test_input($_POST["message"]);
  }
  
  if ($name_error == '' and $email_error == ''){
      $message_body = '';
      unset($_POST['submit']);
      foreach ($_POST as $key => $value){
          $message_body .=  "$key: $value\n";
      }
      
      $headers = "From: $name <$email>";
      
      $to = 'jawad.saad@syncoms.co.uk';
      
      
      $subject = 'Contact Form Submission';
      
      if (mail($to, $subject, $message_body, $headers)){
          $success = "Message sent, thank you for contacting us!";
          $name = $email = $message = '';
          http_response_code(200);
          echo "Message sent, thank you for contacting us!";
      } else {
          $success = "Failed to send. We are working hard to fix this!";
          echo "Failed to send. We are working hard to fix this!";
      }
  }
  
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}