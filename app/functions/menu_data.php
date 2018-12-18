<?php 
namespace functions;

class menu_data
{
	public function data($idx, $column, $l = false)
	{
		$lang = ($l) ? $l : $_SESSION['LANG'];
		$Database = new \Database("page", array(
			"method"=>"selectByIdColumn", 
			"column"=>$column, 
			"idx"=>$idx, 
			"lang"=>$lang
		));
		$getter = $Database->getter(); 

		if($getter){
			return $getter[$column];
		}else{
			return "E";
		}
	}
}