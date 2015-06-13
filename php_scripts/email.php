<?php 
	// session_start();
	if(isset($_POST['submit'])){
		//create safe variables to use in the email
		$name = htmlspecialchars($_POST['name']);
		$email = htmlspecialchars($_POST['email']);
		$subject = htmlspecialchars($_POST['subject']);
		$phone_number = htmlspecialchars($_POST['phone']);
		$message = htmlspecialchars($_POST['message']);

		//check if all required fields were submitted
		//if they were not, send user back to contact form and re-populate the fields
		if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['subject']) && !empty($_POST['message']))
		{
			$_SESSION['submitted'] = true;
			$data['submitted'] = $_SESSION['submitted']; 
		}
		else
		{
			$_SESSION['submitted'] = false;
			//create session variables to re-populate the form if using php without ajax
			$_SESSION['name'] = $name;
			$_SESSION['email'] = $email;
			$_SESSION['subject'] = $subject;
			$_SESSION['phone'] = $phone_number;
			$_SESSION['message'] = $message;
			
			//variables to be passed back to ajax
			$data['success'] = $_SESSION['submitted']; 
			$data['name'] = $name;
			echo json_encode($data);
			exit;
		}
	}
	

	//function that checks script injections
	function IsInjected($str)
	{
	    $injections = array('(\n+)',
	           '(\r+)',
	           '(\t+)',
	           '(%0A+)',
	           '(%0D+)',
	           '(%08+)',
	           '(%09+)'
	           );
	                
	    $inject = join('|', $injections);
	    $inject = "/$inject/i";
	     
	    //perform regular expression match
	    if(preg_match($inject,$str))
	    {
	      return true;
	    }
	    else
	    {
	      return false;
	    }
	}

	//call function
	if(IsInjected($email))
	{
	    echo '<!DOCTYPE html>
		<html class="no-js" lang="en">
		  <head>
		    <meta charset="utf-8" />
		    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		    <title>E-mail Success</title>
		    <link rel="stylesheet" href="css/app.css" />
		    <script src="bower_components/modernizr/modernizr.js"></script>
		    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		  </head>
			<body>
				<div class="row success">
					<h1 style="text-align: center;" class="success_noAccess">This is not cool. Bad cookie!</h1>
				</div>

			<!-- SCRIPT TAGS
			==================================== -->
			<script src="bower_components/jquery/dist/jquery.min.js"></script>
			<script src="bower_components/foundation/js/foundation.min.js"></script>
			</body>
		</html>';
	    exit;
	}

	//customize message
	$email_body = "

	Nova mensagem enviada no site eipiano.com.br. 

	REMETENTE: $name

	E-MAIL: $email 

	TELEFONE: $phone_number 
	                        
	MENSAGEM: $message.

	";

	//prepare message
	$to = 'eipianopira@gmail.com';
	$headers = 'From:  eipiano.com.br' . "\r\n" .
	'Reply-To:  eipianopira@gmail.com' . "\r\n" .
	'X-Mailer: PHP/' . phpversion();

	//send email
	mail($to, $subject, $email_body, $headers);

	//Test if email was sent
	if( @mail($to, $subject, $email_body, $headers) )
	{
		//variables to be passed back to ajax
		$data['name'] = $name;
		$data['success'] = true;
	 	echo json_encode($data);
		exit;
	}
	else
	{
		$data['name'] = $name;
	 	echo json_encode($data);
		exit;
	}
 ?>