<?php

	require_once 'core/init.php';
	
	if(!$username = Input::get('user'))
	{
		Session::put('success', 'Your username is not being found.');
		Redirect::to('index.php');
	}
	else
	{
		$user = new Users($username);
		if(!$user->exists())
		{
			Redirect::to(404);
		}
		else
		{
			$data = $user->data();
		}
		
		?>
			<h4>Username: <?php echo escape($data->username)?></h4>
			<h5>Full name: <?php echo escape($data->name)?></h5>
		<?php
	}

?>