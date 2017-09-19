<?php

	require_once 'core/init.php';
	
	if(Input::exists())
	{
		if(Token::check(Input::get('token')))
		{
			$validate = new Validation();
			
			$validate->check($_POST, array
			(
				'username' => array
				(
					'required' => true,
					'name' => 'username',
					'exists' => 'users'
				),
				'password' => array
				(
					'required' => true,
					'name' => 'password'
				)
			));
			
			if($validate->passed())
			{
				$login = new Users();
				
				$remember = (Input::get('remember') === 'on') ? true : false;
				
				try
				{
					$login->login(Input::get('username'), Input::get('password'), $remember);
					
					Session::put('success', $login->data()->username.' is logged in.');
					Redirect::to('index.php');
					
				}
				catch(Exception $e)
				{
					echo '<p>'.$e->getMessage().'</p>';
				}
			}
			else
			{
				foreach($validate->errors() as $errors)
				{
					echo '<p>'.$errors.'</p>';
				}
			}
		}
	}
?>


<form action="" method="post">
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" autocomplete="off">
	</div>
	
	<div class="field">
		<label for="password">Password</label>
		<input type="password" name="password" id="password">
	</div>
	
	<div class="field">
		<label for="remember">
			<input type="checkbox" name="remember" id="remember"> Remember me
		</label>
	</div>
	
	<input type="hidden" name="token" value="<?php echo Token::generate();?>">
	
	<input type="submit" value="Login!">
</form>