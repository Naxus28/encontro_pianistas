<?php 
if(isset($_POST) && !empty($_POST)){
	var_dump($_POST);
	echo '<br>';
	var_dump($_POST['TEST']);
	echo '<br>';
	var_dump($_POST['TEST']['coord']);
	echo '<br>';
	echo $_POST['TEST']['coord'];

	// echo $_POST['name'];
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>

</head>
<body>
	<form id="form" name="TEST" action="" method="post">
		<input id="submit" type="image" src="images/logo/logo_3.svg" style="width:100px;" name="TEST[coord]">
	</form>
	<script>
		var form = document.getElementById('form');
		// console.log(form);
		form.onsubmit= function(event){
			event.preventDefault();
        	console.log('input clicked');
		}
	</script>
</body>
</html>