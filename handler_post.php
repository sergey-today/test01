<?

	require __DIR__ . '/db.php';
	require __DIR__ . '/fun.php';

	$filter_args = array(
		'email' => array(
	    	'filter'  => FILTER_VALIDATE_REGEXP,
	    	'options' => array('regexp' => "/^[a-z0-9\!\#\$\%\&\*\+\-\/\=\?\_\{\|\}\~\(\)\,\:\@\.]{1,256}$/")
	    ),
	    'name' 	=> array(
	    	'filter'  => FILTER_VALIDATE_REGEXP,
	    	'options' => array('regexp' => "/^[a-zа-яё0-9\s-]{1,100}$/ui")
	    ),
	    'phone' => array(
	    	'filter'  => FILTER_VALIDATE_REGEXP,
	    	'options' => array('regexp' => "/^[0-9\_\-\(\)\+\-\s.]{1,99}$/")
	    )
	);

	$input_post = filter_input_array(INPUT_POST, $filter_args);
	$input_post = array_filter($input_post);

	$response_message = [];

	if (count($input_post) < 3) {

		$response_message['status'] = false;
		$response_message['message'] = 'Форма не полная. Данные не записаны в базу, файлы не загружены. ';

	} else {

		$id_rand = randString(6);
		$db->query("
			INSERT INTO test_table (
				id_rand, 
				name, 
				email, 
				phone
			) 
			VALUE (?, ?, ?, ?)
		", 
			$id_rand,
			$input_post['name'], 
			$input_post['email'], 
			$input_post['phone']
		);
		$user_id = $db->query("SELECT id FROM test_table WHERE id_rand = ?", $id_rand)->fetchColumn();

		$response_message['status'] = true;
		$response_message['message'] = 'Форма отправлена. ';
		$response_message['user_id'] = $user_id;

	}

	echo json_encode($response_message);

?>