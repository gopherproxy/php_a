<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Comments</title>
<style type="text/css">
	.comment{
		border: 1px solid black;
		width: 230px;
		padding: 10px;
		margin: 5px;
	}
	.comment form{
		margin-top: 5px;
	}
</style>
</head>

<body>
<!-- Form for adding comments -->
<form>
	<input type="text" name="comment" required>
	<input type="submit" name="submitComment" value="Submit your comment">
</form>
<?php 
	require_once("db_con.php");
	// grabbing form input in order to create a new comment
	$submitComment = filter_input(INPUT_GET, 'submitComment');
	$newComment = filter_input(INPUT_GET, 'comment');
	// grabbing form values from "delete" form
	$delete = filter_input(INPUT_GET, 'deleteComment');
	// IMPORTANT: storing comment id from hidden input element!
	$commentID = filter_input(INPUT_GET, 'id');
	// if the submitComment-button was pressed 
	if($submitComment){
		// establish connection and insert into the database table
		$stmt = $con->prepare("INSERT INTO comments (comment) VALUES (?)");
		$stmt->bind_param("s", $newComment);
		$stmt->execute();
		$stmt->close();
	}
	// if the deleteComment-button was pressed 
	if($delete){
		// establish connection and delete the corresponding row from the database table comments
		$stmt = $con->prepare("DELETE FROM comments WHERE id=$commentID");
		$stmt->execute();
		$stmt->close();	
	}
	
	// rendering from database
	$stmt = $con->prepare("SELECT id, comment FROM comments");
	$stmt->execute();
	$stmt->bind_result($id, $comment);	
?>	
<!-- Dynamic rendering from databse in PHP shorthand notation (http://w3epic.com/php-short-open-tags-short-hand-syntax-cheatsheet/) -->
<?php while($stmt->fetch()) : ?> 

		<div class="comment">
		<?= $comment; ?> 
		
		<form>
   		<!-- Creating a hidden input element for each comment storing the row id from database table-->
    		<input type="hidden" name="id" value="<?= $id ?>">
			<input type="submit" name="deleteComment" value="Delete me!">
		</form>
		
		</div>
		
<?php endwhile ?>

<?php
// finally closing the rendering statement and connection object ;-)
$stmt->close();
$con->close();
	
?>

</body>
</html>