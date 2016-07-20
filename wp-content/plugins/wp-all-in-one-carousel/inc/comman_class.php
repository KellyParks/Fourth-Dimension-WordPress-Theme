<?php 

class Functions_swp_carou{

	public static function throwError($message,$code=null){
		if(!empty($code))
			throw new Exception($message,$code);
		else
			throw new Exception($message);
	}	

	protected function error_msg($mcode){

		$msg = array(

			'1' => 'Slider Title should not be empty.',
			'2' => 'Display Setting Updated.',
			'3' => 'Level Title should not be empty',
			'4' => 'Product Image should not be empty',
			'5' => '',
			'6' => 'Levels Setting Updated.',
			'7' => 'Hover Setting Updated.',
			'8' => 'Sale Setting Updated.',
			'9' => 'Button Setting Updated.',
			'10'=> 'Your Import file is empty.',
			'11'=> 'Slider Import Successfully.'

		);

		return $msg[$mcode];

	}

	

}
