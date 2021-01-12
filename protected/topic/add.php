<?php if(!isset($_SESSION['admin'])) : ?>
	<h1>Page access is forbidden!</h1>
<?php else : ?>
	<?php
		if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addTopic'])) {
			$postData = [
				'name' => $_POST['name'],
				'category' => $_POST['category'],
				'content' => $_POST['content']
			];

			if(empty($postData['name']) || ($postData['category'] < 0 && $postData['category'] > 2) || empty($postData['content'])) {
				echo "Hiányzó adat(ok)!";
			} else {
				$query = "INSERT INTO topics (name, user, category, content, timeposted) VALUES (:name, :user, :category, :content, :timeposted)";
				$params = [
					':name' => $postData['name'],
					':user' => $_SESSION['uname'],
					':category' => $postData['category'],
					':content' => $postData['content'],
					':timeposted' => date("Y-m-d")
				];
				require_once DATABASE_CONTROLLER;
				if(!executeDML($query, $params)) {
					echo "Hiba az adatbevitel során!";
				} header('Location: index.php?P=list_topic');
			}
		}
	?>

	<form method="post">
		<div class="form-row">
			<div class="form-group col-md-12">
				<label for="topicName">Topic Name</label>
				<input type="text" class="form-control" id="topicName" name="name">
			</div>
			<div class="form-group col-md-12">
		    	<label for="topicCategory">Category</label>
		    	<select class="form-control" id="topicCategory" name="category">
		      		<option value="0">Building</option>
		      		<option value="1">Games</option>
		      		<option value="2">Other</option>
		    	</select>
		  	</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-12">
				<label for="topicContent">Topic Content</label>
				<textarea class="form-control" id="topicContent" name="content" rows="8"></textarea>
			</div>
		</div>
		<button type="submit" class="btn btn-primary" name="addTopic">Add Topic</button>
	</form>
<?php endif; ?>