<?php 
if(!array_key_exists('w', $_GET) || empty($_GET['w'])) : 
	header('Location: index.php');
else: 
	$queryTopic = "SELECT id, points, name, user, category, timeposted, content FROM topics WHERE id = :id";
	$queryComments = "SELECT user, commentText FROM comment WHERE topicId = :id";
	$params = [':id' => $_GET['w']];
	require_once DATABASE_CONTROLLER;
	$topic = getRecord($queryTopic, $params);
	$comment = getList($queryComments, $params);
	if(empty($topic)) :
		header('Location: index.php');
	else : ?>
		<h1><?=$topic['name'] ?></h2>
		<h4><?=$topic['user'] ?></h4>		
		<p><?=$topic['content'] ?></p>
		<p><?=$topic['timeposted'] ?></p>
		<h3>Comments:</h3>

		<?php
		if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addComment'])) {
			$postData = [
				'commentText' => $_POST['commentText']
			];
			if(empty($postData['commentText'])) {
				echo "Hiányzó adat(ok)!";
			}
			else {
				$query = "INSERT INTO comment (commentText, user, topicId) VALUES (:commentText, :user, :topicId)";
				$params = [
					':commentText' => $postData['commentText'],
					':user' => $_SESSION['uname'],
					':topicId' => $topic['id']
				];
				require_once DATABASE_CONTROLLER;
				if(!executeDML($query, $params)) {
					echo "Hiba az adatbevitel során!";
				} echo "<meta http-equiv='refresh' content='0'>";
			}
		}
	?>

		<form method="post">
			<div class="form-group">
				<label for="commentText">Your Comment</label>
		   		<textarea class="form-control" id="commentText" name="commentText" rows="5"></textarea>
			</div>
			<button type="submit" class="btn btn-primary" name="addComment">Add Comment</button>
		</form>
		<?php endif; ?>

		<?php foreach ($comment as $c) : ?>
			<h4><?=$c['user'] ?></h4>
			<p><?=$c['commentText'] ?></p>
		<?php endforeach;?>
		
<?php endif; ?>