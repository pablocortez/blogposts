<!doctype html>
<html class="no-js" lang="en">
<head>
  <meta charset="utf-8">

  <title>Simple UI</title>
  <meta name="description" content="Nope, it's not another framework. This is a set of the most popular components used in many web applications. These components can act as a core for a fresh development, are fully customizable and the markup is minimal so you can use and style them as you please.">
  <meta name="author" content="Rafal Bromirski">

  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <link rel="stylesheet" href="css/application.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<?php

require 'classes/Database.php';

$database = new Database;

// var_dump($database);


$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

if ($post['submit']) {
	$title = $post['title'];
	$body = $post['body'];

	$database->query('INSERT INTO posts (title, body) VALUES (:title, :body)');
	$database->bind(':title', $title);
	$database->bind(':body', $body);
	$database->execute();

	if ( $database->lastInsertId() ) {
		echo "<p>Post Added!</p>";
	}


}

$database->query('SELECT * FROM posts');
// $database->bind(':id', 1);

$rows = $database->resultset();
?>
<body>

<header>
  <h1 class="site-title">Blog Posts</h1>
</header>


<div class="content">

  <?php foreach ($rows as $row): ?>
  <div class="box">
    <h3 class="box_head"><?php echo $row['title']; ?></h3>
    <div class="box_body">
      <?php echo $row['body']; ?>
    </div>
  </div>
<?php endforeach; ?>

  <hr>
  <h2 class="new-post-heading"> Add A New Blog Post </h2>
	<form class="form" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
		<input class="input" type="text" name="title" placeholder="Add a Title..."> <br> <br>
		<textarea name="body" id="" cols="60" rows="10"></textarea> <br> <br>
		<input class="bt submit" type="submit" name="submit" value"Submit">
	</form>

</div>

</body>
</html>
