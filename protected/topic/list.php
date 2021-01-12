<?php 
	if(array_key_exists('d', $_GET) && !empty($_GET['d'])) {
		$query = "DELETE FROM topics WHERE id = :id";
		$params = [':id' => $_GET['d']];
		require_once DATABASE_CONTROLLER;
		if(!executeDML($query, $params)) {
			echo "Hiba törlés közben!";
		}
	}
?>
<?php 
	$query = "SELECT id, name, user, category, timeposted FROM topics ORDER BY timeposted DESC";
	require_once DATABASE_CONTROLLER;
	$topics = getList($query);
?>
	<?php if(count($topics) <= 0) : ?>
		<h1>No topics found in the database</h1>
	<?php else : ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Topic Name</th>
					<th scope="col">Post User</th>
					<th scope="col">Category</th>
					<th scope="col">Date Posted</th>
					<?php if(!isset($_SESSION['admin']) || $_SESSION['admin'] >= 1) : ?>
						<th scope="col">Edit</th>
						<th scope="col">Delete</th>
					<?php endif ?>
				</tr>
			</thead>
			<tbody>
				<?php $i = 0; ?>
				<?php foreach ($topics as $t) : ?>
					<?php $i++; ?>
					<tr>
						<th scope="row"><?=$i ?></th>
						<td><a href="?P=topic&w=<?=$t['id'] ?>"><?=$t['name'] ?></a></td>
						<td><?=$t['user'] ?></td>
						<td><?=$t['category'] == 0 ? 'Building' : ($t['category'] == 1 ? 'Games' : 'Other') ?></td>
						<td><?=$t['timeposted'] ?></td>
						<?php if(!isset($_SESSION['admin']) || $_SESSION['admin'] >= 1) : ?>
							<td><a href="?P=edit_topic&e=<?=$t['id'] ?>">Edit</a></td>
							<td><a href="?P=list_topic&d=<?=$t['id'] ?>">Delete</a></td>
						<?php endif ?>
					</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	<?php endif; ?>

