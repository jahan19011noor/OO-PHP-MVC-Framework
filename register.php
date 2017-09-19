<?php
	require_once 'core/init.php';
	
	//var_dump(Token::check(Input::get('token')));
	
	if(Input::exists())
	{
		if(Token::check(Input::get('token')))
		{
			//echo Input::get('username');
			
			$validate = new Validation();
			//have to declare object first
			//because class is not singleton
			//no method inside class to instantiate it
			//so have to instantiate before call
			//by creating object.
			//$validate = Validation::check() - wrong.
			
			//and again, the functions in the Validation class are not static
			//so cannot be used with creating an object. so again
			//$validate = Validation::check() - wrong.
			
			$validate->check($_POST, array
			(
				'username' => array
				(
					'name' => 'username',
					'required' => true,
					'min' => 4,
					'max' => 20,
					'unique' => 'users'
				),
				'password' => array
				(
					'name' => 'password',
					'required' => true,
					'min' => 6
				),
				'confirm_password' => array
				(
					'name' => 'repeated password',
					'required' => true,
					'matches' => 'password'
				),
				'name' => array
				(
					'name' => 'name',
					'required' => true,
					'min' => 6,
					'max' => 50
				)
			));
			
			if($validate->passed())
			{
				$register = new Users();
				$salt = Hash::salt(32);
				//die();
				
				try
				{
					$register->create(array
					(
						'username' => Input::get('username'),
						'password' => Hash::make(Input::get('password'), $salt),
						'salt' => $salt,
						'name' => Input::get('name'),
						'joined' => date('Y-m-d H:i:s'),
						'group' => 1
					));
					
					Session::put('success', 'You are successfully registered!');
					Redirect::to('index.php');
				}
				catch(Exception $e)
				{
					echo '<p>' . $e->getMessage() . '</p>';
				}
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
		<label for="username">Username</label>
		<input type="text" name="username" id="username" value="<?php echo escape(Input::get('username'))?>" autocomplete="off">
	</div>
	
	<div class="field">
		<label for="password">Password</label>
		<input type="password" name="password" id="password">
	</div>
	
	<div class="field">
		<label for="confirm_password">Repeat password</label>
		<input type="password" name="confirm_password" id="confirm_password">
	</div>
	
	<div class="field">
		<label for="name">Enter Your Name</label>
		<input type="text" name="name" id="name" value="<?php echo escape(Input::get('name'))?>">
	</div>
	
	<input type="hidden" name="token" value="<?php echo Token::generate();?>">
	
	<input type="submit" value="Register!">
</form>