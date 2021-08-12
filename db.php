<?

	class db {
		
		private
			$host = '...',
			$dbname = '...',
			$user = '...',
			$password = '...',
			$charset = 'utf8',
			$options = [
				PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES   => false,
			];

		function query($query, ...$q) {
			$pdo = new PDO(
				'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=' . $this->charset,
				$this->user,
				$this->password,
				$this->options
			);
			$data = $pdo->prepare($query);
			$data->execute(array(...$q));
			return $data;
		}
		
	}

	$db = new db();

?>