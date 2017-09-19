<?php

	require_once 'core/init.php';
	
	$user = new Users();
	
	if(!$user->isLoggedIn())
	{
		Session::put('success', 'Sorry you are not logged in, you cannot access this page.');
		Redirect::to('index.php');
	}
	
	if(Input::exists())
	{
		if(Token::check(Input::get('token')))
		{
			$validate = new Validation();
			
			$validate->check($_POST, array
			(
				'current_password' => array
				(
					'required' => true,
					'name' => 'current password',
					'min' => 6,
					'same_as' => 'previous'
				),
				'new_password' => array
				(
					'required' => true,
					'name' => 'new password',
					'min' => 6
				),
				'confirm_new_password' => array
				(
					'required' => true,
					'name' => 'repeated password',
					'matches' => 'new_password',
					'min' => 6
				)
			));
			
			if($validate->passed())
			{
				$salt = Hash::salt(32);
				$password = Hash::make(Input::get('new_password'), $salt);
				
				$user->update(array
				(
					'password' => $password,
					'salt' => $salt
				));
				
				Session::put('success', 'You have successfully changed your password');
				Redirect::to('index.php');
			}
			else
			{
				foreach($validate->errors() as $errors)
				{
					echo $errors.'<br>';
				}
			}
		}
	}

?>

<form action="" method="post">
	<div class="field">
		<label for="password">Current Password</label>
		<input type="password" name="current_password" id="current_password">
	</div>
	
	<div class="field">
		<label for="password">New Password</label>
		<input type="password" name="new_password" id="new_password">
	</div>
	
	<div class="field">
		<label for="confirm_password">Repeat New password</label>
		<input type="password" name="confirm_new_password" id="confirm_new_password">
	</div>
	
	<input type="hidden" name="token" value="<?php echo Token::generate();?>">
	
	<input type="submit" value="Change password!">
</form>