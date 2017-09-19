<?php

	require_once 'core/init.php';
	
	/*Config.php check:
	//echo $GLOBALS['config']['mysql']['host'];
	//echo Config::get();
	*/
	
	/*singleton desing method check
	*///$db = new DB(); - wrong;
	
	//checking the function of the query() method;
	//$user = DB::singleton()->query("SELECT username FROM users WHERE username = ?", array('alex'));
	
	//checking the function of the action() method;
	//$user = DB::singleton()->action("SELECT *", "users", array("username", "=", "Noor"));
	
	//checking the function of the get() method;
	//$user = DB::singleton()->get("users", array("username", "=", "Noor"));
	
	//checking the function of the delete() method;
	//and the function of the count() method under the action of the delete method
	/*$user = DB::singleton()->delete("users", array("username", "=", "Noor"));
	
	if($user->count())
	{
		echo $user->count();
	}
	else
	{
		echo "no action performed in any row.";
	}
	*/
	
	//checking the results() method functionality under query() function
	/*$user = DB::singleton()->query("SELECT * FROM users");
	
	if(!$user->count())
	{
		echo "no action performed in any row.";
	}
	else
	{
		foreach($user->results() as $user)
		{
			echo $user->username, '<br>';
		}
	}
	*/
	
	/*checking the first() method functionality under get() method
	$user = DB::singleton()->get("users", array("username", "=", "Noor"));
	
	if(!$user->count())
	{
		echo "no action performed in any row.";
	}
	else
	{
		//grabing the value of the [0] index username object of results array.
		/*echo $user->results()[0]->username;
		//echo $user->results()->username;
		//wrong - gives - trying to get property of non-object,
		//becauser results() is an array of objects, not an object itself.
		
		
		//useing the first() method instead to grab the first row username
		echo $user->first()->username;
	}
	*/
	
	/*checking the insert() function
	$user = DB::singleton()->insert('users', array
	(
		'username' => 'twaha',
		'password' => 'password',
		'salt' => 'salt'
	));
	*/
	
	//checking the update() function
	/*
	if($user = DB::singleton()->update('users', 7, array
	(
		'username' => 'Twaha',
		'password' => 'newpassword',
		'name' => 'Twaha Mukammel'
	)))
	{
		echo 'successfully updated.';
	}
	*/
	
	
	if(Session::exists('success'))
	{
		echo '<p>'.Session::flash('success').'</p>';
	}
	
	$user = new Users();
	
	if($user->isLoggedIn())
	{
	?>
		<p>Hello <a href="profile.php?user=<?php echo escape($user->data()->username);?>"><?php echo escape($user->data()->username);?></a></p>
		
		<ul>
			<li><a href="logout.php">Log out</a></li>
			<li><a href="update.php">Change profile</a></li>
			<li><a href="changepassword.php">Change password</a></li>
		</ul>
	<?php
	
		if($user->hasPermission('admin'))
		{
			echo '<p>You are an administrator.</p>';
		}
		else if($user->hasPermission('moderator'))
		{
			echo '<p>You are a moderator.</p>';
		}
	}
	else
	{
		echo '<p>You need to <a href="login.php">log in</a> or <a href="register.php">register</a>.</p>';
	}
	
	//checking the session value of the set session on a login
	/*
	echo Session::get(Config::get('session/session_name'));
	*/
?>