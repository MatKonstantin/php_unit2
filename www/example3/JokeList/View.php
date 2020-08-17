<?php
namespace JokeList;
class View {
	public function output(\JokeSite\JokeList  $model): string {
		$output = '
		<p><a href="index.php?route=edit">Добавить новую шутку</a></p>
		<form action="" method="get">
				<input type="hidden" value="filterList" name="route" />
				<input type="hidden" value="' . $model->getSort() . '" name="sort" />
				<input type="text"  placeholder="Введите текст для поиска" name="search" />

				<input type="submit" value="Найти" />
			</form>

			<p>Сортировка: <a href="index.php?route=filterList&amp;sort=newest">Сначала новые</a> | <a href="index.php?route=filterList&amp;sort=oldest">Сначала старые</a>
			<ul>

			';

		foreach ($model->getJokes() as $joke) {
			$output .= '<li>' . $joke['text'];

			$output .= ' <a href="index.php?route=edit&amp;id=' . $joke['id'] . '">Редактировать</a>';
			$output .= '<form action="index.php?route=delete" method="POST">
						<input type="hidden" name="id" value="' . $joke['id'] . '" />
						<input type="submit" value="Удалить" />
						</form>';
			$output .= 	'</li>';
		}

		$output .= '</ul>';
		return $output;

	}
}
