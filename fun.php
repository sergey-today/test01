<?

	function randString($strength = 10) {
		$permitted_chars = 'crazy0fredrick1bought2many3very4exquisite5opal6jewels789';
		$input_length = strlen($permitted_chars);
		$random_string = '';
		for ( $i = 0; $i < $strength; $i++ ) {
			$random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
			$random_string .= $random_character;
		}
		return $random_string;
	}

?>