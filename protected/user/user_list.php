<?php if(!isset($_SESSION['admin']) || $_SESSION['admin'] < 1) : ?>
	<h1>Page access is forbidden!</h1>
<?php else : ?>
	<?php 
	$query = "SELECT username, email, admin FROM userlist";
	require_once DATABASE_CONTROLLER;
	$users = getList($query);
	?>
	<?php if(count($users) <= 0) : ?>
		<h1>No users found in the database.</h1>
	<?php else : ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Userame</th>
					<th scope="col">Email</th>
					<th scope="col">Admin</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 0; ?>
				<?php foreach ($users as $u) : ?>
					<?php $i++; ?>
					<tr>
						<th scope="row"><?=$i ?></th>
						<td><?=$u['username'] ?></td>
						<td><?=$u['email'] ?></td>
						<td><?=$u['admin'] ?></td>
					</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	<?php endif; ?>
<?php endif; ?>