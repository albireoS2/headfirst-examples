<?php
	require_once('appvars.php');
	require_once('connectvars.php');

	// Connect to the database
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	
	if (isset($_POST['submit'])) {
		$username = mysqli_real_escape_string($dbc, trim($_POST['username']));
		$password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
		$password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));
		
		if (!empty($username) && !empty($password1) && !empty($password2) 
				&& ($password1 == $password2)) {
			$query = "SELECT * FROM mismatch_user WHERE username = '$username'";
			
			$data = mysqli_query($dbc, $query);
			
			if (mysqli_num_rows($data) == 0) {
				$query = "INSERT INTO mismatch_user (username, password, join_date) 
					VALUES ('$username', SHA('$password1'), NOW())";
				
				mysqli_query($dbc, $query);
				
				echo '<p>Your new account has been successfully created. You\'re now ready to log in and 
					<a href="editprofile.php">edit your profile</a></p>';
				
				mysqli_close($dbc);
				exit();
			}
			else {
				echo '<p class="error">An account already exist for this username.
					Please use a different address.</p>';			
			}
		}
		
		else {
			echo '<p class="error">You must enter all of the sign-up data,    
				including the desired password twice.</p>';
		}
	}
	
	mysqli_close($dbc);
	
?>


<p> Please enter your username and desired password to sign up to Mismatch.</p>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<fieldset>
		<label for="username">Username:</label>
		<input type="text" id="username" name="username" value="<?php if (!empty($username)) echo $username; ?>"> <br>
		<label for="password1">Password:</label>
		<input type="password" id="password1" name="password1"><br>
		<label for="password2">Password(retype):</label>
		<input type="password" id="password2" name="password2"><br>
	</fieldset>
	<input type="submit" value="Sign Up" name="submit">
</form>
