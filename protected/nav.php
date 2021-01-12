<hr>

<a href="index.php">Home</a>
<?php if(!IsUserLoggedIn()) : ?>
	<span> &nbsp; | &nbsp; </span>
	<a href="index.php?P=login">Login</a>
	<span> &nbsp; | &nbsp; </span>
	<a href="index.php?P=register">Register</a>
<?php else : ?>


	<span> &nbsp; || &nbsp; </span>
	<a href="index.php?P=users">User List</a>
	<span> &nbsp; | &nbsp; </span>		
	<span> &nbsp; | &nbsp; </span>
	<a href="index.php?P=list_topic">List Topics</a>
	<span> &nbsp; | &nbsp; </span>
	<a href="index.php?P=add_topic">Start Topic</a>
	<span> &nbsp; || &nbsp; </span>
	<a href="index.php?P=logout">Logout</a>
<?php endif; ?>

<hr>