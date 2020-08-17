<!doctype html>
<html>
<head></head>

<body>

<table>
	<tr><td>Название</td><td>Автор</td><td>Описание</td></tr>
	<?php 

		foreach ($books as $title => $book)
		{
			echo '<tr><td><a href="index.php?book='.$title.'">'.$book->title.'</a></td><td>'.$book->author.'</td><td>'.$book->description.'</td></tr>';
		}

	?>
</table>

</body>
</html>