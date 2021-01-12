<?php if(!isset($_SESSION['admin']) || $_SESSION['admin'] < 1) : ?>
	<h1>Page access is forbidden!</h1>
<?php else :
	if(!array_key_exists('e', $_GET) || empty($_GET['e'])) : 
		header('Location: index.php');
else: 
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editTopic'])) {
		$postData = [
			'id' => $_POST['topicId'],
			'name' => $_POST['name'],
			'category' => $_POST['category'],
			'content' => $_POST['content']
		];
		if($postData['id'] != $_GET['e']) {
			echo "Hiba a topic azonosítása során!";
		} else {
			if(empty($postData['name']) || $postData['category'] < 0 && $postData['category'] > 2 || empty($postData['content'])) {
				echo "Hiányzó adat(ok)!";
			} else {
				$query = "UPDATE topics SET name = :name, category = :category, content = :content WHERE id = :id";
				$params = [
					':name' => $postData['name'],
					':category' => $postData['category'],
					':content' => $postData['content'],
					':id' => $postData['id']
				];
				require_once DATABASE_CONTROLLER;
				if(!executeDML($query, $params)) {
					echo "Hiba az adatbevitel során!";
				} header('Location: ?P=list_topic');
			}
		}
	}
	$query = "SELECT id, name, category, content FROM topics WHERE id = :id";
	$params = [':id' => $_GET['e']];
	require_once DATABASE_CONTROLLER;
	$topic = getRecord($query, $params);
	if(empty($topic)) :
		header('Location: index.php');
		else : ?>
			<form method="post">
				<input type="hidden" name="topicId" value="<?=$topic['id'] ?>">
				<div class="form-row">
					<div class="form-group col-md-12">
						<label for="topicName">Name</label>
						<input type="text" class="form-control" id="topicName" name="name" value="<?=$topic['name'] ?>">
					</div>					
				<div class="form-group col-md-12">
		    		<label for="topicCategory">Category</label>
		    			<select class="form-control" id="topicCategory" name="category">
							<option value="0" <?=$topic['category'] == 0 ? 'selected' : '' ?> >Building</option>
							<option value="1" <?=$topic['category'] == 1 ? 'selected' : '' ?> >Games</option>
							<option value="2" <?=$topic['category'] == 2 ? 'selected' : '' ?> >Other</option>
						</select>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-12">
						<label for="topicContent">Topic Content</label>
						<textarea class="form-control" id="topicContent" name="content" rows="8"><?php echo $topic['content']; ?></textarea>
					</div>
				</div>

				<button type="submit" class="btn btn-primary" name="editTopic">Save Topic</button>
			</form>
		<?php endif;
	endif;
endif;
?>