<?php

	require_once 'core/init.php';
	
	$user = new Users();
	
	if(!$user->isLoggedIn())
	{
		Session::put('success', 'Sorry you are not logged in, you cannot view profile.');
		Redirect::to('index.php');
	}
	
	if(Input::exists())
	{
		if(Token::check(Input::get('token')))
		{
			$validate = new Validation();
			
			$validate->check($_POST, array
			(
				'name' => array
				(
					'required' => true,
					'name' => 'Name',
					'min' => 6,
					'max' => 50
				)
			));
			
			if($validate->passed())
			{
				try
				{
					$user->update(array('name' => Input::get('name')));
					
					Session::put('success', 'Your details have been updated.');
					Redirect::to('index.php');
				}
				catch(Exception $e)
				{
					echo '<p>' . $e->getMessage() . '</p>';
				}
			}
			else
			{
				foreach($validate->errors() as $error)
				{
					echo '<p>'.$error.'</p>';
				}
			}
		}
	}

?>

<form action="" method="post">
	<div class="field">
		<label for="name">Name</label>
		<input type="text" name="name" value="<?php echo escape($user->data()->name);?>">
	</div>
	
	<input type="submit" value="Update">
	<input type="hidden" name="token" value="<?php echo Token::generate();?>">
</form>