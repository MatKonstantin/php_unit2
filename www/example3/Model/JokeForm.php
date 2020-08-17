<?php
namespace JokeSite;
class JokeForm {
	private $pdo;

	/* $submitted: Была ли отправлена форма */
	private $submitted = false;

	/* Ошибки проверки представленных данных */
	private $errors = [];

	/* Представляемая запись. Может прийти из базы данных или формы представления */
	private $record = [];

	public function __construct(\PDO $pdo, $submitted = false, array $record = [], array $errors = []) {
		$this->pdo = $pdo;
		$this->record = $record;
		$this->submitted = $submitted;
		$this->errors = $errors;
	}

	/*
	* @description загрузить запись из базы данных
	* @param $id - ID записи для загрузки из базы данных
	*/
	public function load(int $id): JokeForm {
		$stmt = $this->pdo->prepare('SELECT * FROM joke WHERE id = :id');
		$stmt->execute(['id' => $id]);
		$record = $stmt->fetch();
		return new JokeForm($this->pdo, $this->submitted, $record);
	}

	/*
	* @description  возвращает запись, которая в данный момент представлена
	*  это может быть из базы данных или $ _POST
	*/
	public function getJoke(): array {
		return $this->record;
	}

	/*
	* @description форма была отправлена или нет?
	*/
	public function isSubmitted(): bool {
		return $this->submitted;
	}

	/*
	* @description вернуть список ошибок валидации в текущем $record
	*/
	public function getErrors(): array {
		return $this->errors;
	}


	/*
	* @description попытаться сохранить $ record в базу данных, вставить или обновить
	* в зависимости от того, установлен ли $record ['id']
	*/
	public function save(array $record): JokeForm {
		$errors = $this->validate($record);

		if (!empty($errors)) {
	// Возвращаем новый экземпляр с $record установленным на отправку формы
	// Когда представление отображает шутку, оно отображает недействительный
	// отправка формы обратно в коробку
			return new JokeForm($this->pdo, true, $record, $errors);
		}

		if (!empty($record['id'])) {
			return $this->update($record);
		}
		else {
			return $this->insert($record);
		}
	}

	/*
	* @description проверяет $record
	*/
	private function validate(array $record): array {
		$errors = [];

		if (empty($record['text'])) {
			$errors[] = 'Text cannot be blank';
		}

		return $errors;
	}

	/*
	* @description сохраняет запись с использованием запроса UPDATE 
	*/
	private function update(array $record): JokeForm {
		$stmt = $this->pdo->prepare('UPDATE joke SET text = :text WHERE id = :id');
		$stmt->execute($record);

		return new JokeForm($this->pdo, true, $record);
	}

	/*
	* @description сохраняет запись через запрос INSERT 
	*/
	private function insert(array $record): JokeForm {
		$stmt = $this->pdo->prepare('INSERT INTO joke (text) VALUES(:text)');

		$stmt->execute(['text' => $record['text']]);

		$record['id'] = $this->pdo->lastInsertId();

		return new JokeForm($this->pdo, true, $record);
	}
}