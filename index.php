<?php

$possible_languages = array(
	'eng' => 'English'
	, 'fren' => 'French'
	, 'spain' => 'Spanish'
);

$errors = array();
$display_thanks = false;

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$username = filter_input(INPUT_POST,'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
$preferredlang = filter_input(INPUT_POST, 'preferredlang', FILTER_SANITIZE_STRING);
$message = filter_input(INPUT_POST,'message', FILTER_SANITIZE_STRING);
//$acceptterms = filter_input(INPUT_POST, 'acceptterms', FILTER_FILTER_DEFAULT);
$terms = filter_input(INPUT_POST, 'terms', FILTER_DEFAULT);

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Check to see if the form has been submitted before validating
	if (empty($name)) {
		$errors['name'] = true;
	}
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = true;
	}
	if (mb_strlen($username) > 25) {
		$errors['username'] = true;
	}
	
	if (empty($password)) {
		$errors['password'] = true;
	}
	
	if (!array_key_exists($preferredlang, $possible_languages)) {
		$errors['preferredlang'] = true;
	}
	if (mb_strlen($message) < 25) { // mb_strlen = multi-byte string length
		$errors['message'] = true;
	}
	/*if ($acceptterms !== '') {
		$errors['acceptterms'] = true;
	}*/
	/*if(!isset($_POST['terms'])){
		$errors['terms']=true;
	}*/
	if (empty($terms)) {
		$errors['terms'] = true;
	}
	
	if (empty($errors)){
		$display_thanks = true;
	}
	
	
	$thankyou = "Thank you for filling the form.";
	
}

?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Registration Form</title>
	<link href="css/general.css" rel="stylesheet">
</head>
<body>
	
    <!--< ?php if (isset($_REQUEST['email'])){
		$subject = "You are Registered!";
		$from = "gupt0040@algonquinlive.com";
		$message = "You have received this mail because you have registered with:";
		$header = "Aditya Gupta" . $from;
  	 	mail($email, $subject, $message, $header);
  		echo "Please check your mailbox.";
  	}
	? > -->
    
    <?php if ($display_thanks) : ?>
    
    	<Strong>Thanks!</Strong>
        
    <?php else: ?>   
    
    <form method="post" action="index.php">
		<div>
			<label for="name">Name<?php if (isset($errors['name'])) : ?> <strong>is required</strong><?php endif; ?></label>
			<input id="name" name="name" value="<?php echo $name; ?>" required>
		</div>
		<div>
			<label for="email">E-mail Address<?php if (isset($errors['email'])) : ?> <strong>is required</strong><?php endif; ?></label>
			<input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
		</div>
        <div>
			<label for="username">Username<?php if (isset($errors['username'])) : ?> <strong>can have maximum of 25 characters</strong><?php endif; ?></label>
			<input id="username" name="username" value="<?php echo $username; ?>" required>
		</div>
         <div>
			<label for="password">Password<?php if (isset($errors['password'])) : ?> <strong>Please enter a password</strong><?php endif; ?></label>
			<input type="password" id="password" name="password" value="<?php echo $password; ?>" required>
		</div>
        <fieldset>
			<legend>Preferred Language</legend>
			<?php if (isset($errors['preferredlang'])) : ?> <strong>Select a Language please!</strong><?php endif; ?>
			<?php foreach ($possible_languages as $key => $value) : ?>
        		<label for="<?php echo $key; ?>"><?php echo $value; ?></label>
				<input type="radio" id="<?php echo $key; ?>" name="preferredlang" value="<?php echo $key; ?>"<?php if ($key == $preferredlang) { echo ' checked'; } ?>>
			<?php endforeach; ?>
		</fieldset>
        <div>
			<label for="message">Notes:<?php if (isset($errors['message'])) : ?> <strong>must be at least 25 characters</strong><?php endif; ?></label>
			<textarea id="message" name="message" required><?php echo $message; ?></textarea>
		</div>
		<div>
	        <!--<label for="acceptterms">I have read and accept the Terms & Conditions< ?php if (isset($errors['acceptterms'])) : ?> <strong>Please check the box!</strong>< ?php endif; ?></label>
			<input type="checkbox" id="acceptterms" name="acceptterms" value="< ?php echo $acceptterms; ?>" required> -->
            <input type="checkbox" id="terms" name="terms" <?php if (!empty($terms)) {echo 'checked'; } ?>>
            <label for="terms">Accept Terms?</label> 
			<?php if (isset($errors['terms'])) :?><strong>You must Comply</strong><?php endif; ?>
        </div>
		<div>
			<button type="submit">Send Message</button>
        </div>
	</form>
    <?php endif; ?>
    
</body>
</html>
