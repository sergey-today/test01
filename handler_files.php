<?

	require __DIR__ . '/db.php';
	require __DIR__ . '/fun.php';

	$response_message = [
		'status' => false,
		'message' => []
	];

	if (filter_var($_POST['user_id'], FILTER_SANITIZE_NUMBER_INT)) {
		if (isset($_FILES['upload']['name'][0])) {
			$count_files = count($_FILES['upload']['name']);
			if ($count_files < 6) {
				for ( $i = 0 ; $i < $count_files ; $i++ ) {
					$file = $_FILES['upload']['name'][$i];
					$file_tmp = $_FILES['upload']['tmp_name'][$i];
					if ($_FILES['upload']['error'][$i] === UPLOAD_ERR_OK and is_uploaded_file($file_tmp)) {
						if ($_FILES['upload']['size'][$i] < 1024*1024*0.3) {
							$file_ext = pathinfo($file, PATHINFO_EXTENSION);
							$file_ext = strtolower($file_ext);
							if ($file_ext == 'jpg' or $file_ext == 'jpeg') {
								$file_name_rand = time().'_'.randString(6).'.'.$file_ext;
								$new_file_path = __DIR__ . '/uploads/'.$file_name_rand;
								$db->query("
									INSERT INTO test_table_files (
										user_id, 
										file_name
									) 
									VALUE (?, ?)
								", 
									$_POST['user_id'],
									$file_name_rand
								);
								if (move_uploaded_file($file_tmp, $new_file_path)) {
									$response_message['status'] = true;
									array_push($response_message['message'], 'Форма отправлена. ');
								} else {
									$response_message['status'] = false;
									array_push($response_message['message'], 'Форма отправлена. Не удалось загрузить файл '.$file.'. Попробуйте загрузить его снова. ');
								}
							} else {
								$response_message['status'] = false;
								array_push($response_message['message'], 'Форма отправлена. Ошибка при загрузке файла '.$file.', допускаются расширения файлов только .jpg и .jpeg. Попробуйте загрузить другой файл. ');
							}
						} else {
							$response_message['status'] = false;
							array_push($response_message['message'], 'Форма отправлена. Ошибка при загрузке файла <b>'.$file.'</b>, файл больше 300KB. Попробуйте загрузить другой файл. ');
						}
					} else {
						$response_message['status'] = false;
						array_push($response_message['message'], 'Форма отправлена. Ошибка при загрузке файла <b>'.$file.'</b>. Попробуйте загрузить его снова. ');
					}
				}
			} else {
				$response_message['status'] = false;
				array_push($response_message['message'], 'Форма отправлена. Количество выбранных файлов больше 5, файлы не загружены. Выберите до 5 файлов. ');
			}
		} else {
			$response_message['status'] = false;
			array_push($response_message['message'], 'Форма отправлена. Файлы не прикреплены. ');
		}
	} else {
		$response_message['status'] = false;
		array_push($response_message['message'], 'Ошибка. ');
	}

	echo json_encode($response_message);

?>