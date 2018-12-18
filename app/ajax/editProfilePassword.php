<?php 
class editProfilePassword
{
	public $out; 
	
	public function __construct()
	{
		require_once 'app/core/Config.php';
		if(!isset($_SESSION[Config::SESSION_PREFIX."username"]))
		{
			exit();
		}
	}
	
	public function index(){
		require_once 'app/core/Config.php';
		require_once 'app/functions/request.php';

		$this->out = array(
			"Error" => array(
				"Code"=>1, 
				"Text"=>"მოხდა შეცდომა !",
				"Details"=>"!"
			)
		);

		$lang = functions\request::index("POST","lang");
		$oldpassword = functions\request::index("POST","oldpassword");
		$password = functions\request::index("POST","password");
		$passwordConfirm = functions\request::index("POST","passwordConfirm");

		if($lang == "" || $oldpassword=="" || $password == "" || $passwordConfirm == "")
		{
			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>"ყველა ველი სავალდებულოა !",
					"Details"=>"!"
				)
			);
		}else if($password != $passwordConfirm){
			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>"პაროლები არ ემთხვევა ერთმანეთს !",
					"Details"=>"!"
				)
			);
		}else{
			$Database = new Database('user', array(
				'method'=>'updateAdminPassword', 
				'oldpassword'=>$oldpassword,
				'password'=>$password
			));

			if($Database->getter()){
				$this->out = array(
					"Error" => array(
						"Code"=>0, 
						"Text"=>"",
						"Details"=>""
					),
					"Success"=>array(
						"Code"=>1, 
						"Text"=>"ოპერაცია შესრულდა წარმატებით !",
						"Details"=>""
					)
				);
			}		
			
		}

		return $this->out;
	}
}