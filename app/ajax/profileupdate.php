<?php
class profileupdate
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
		require_once 'app/functions/makeForm.php';
		require_once 'app/functions/request.php';

		$lang = functions\request::index("POST","lang");

		$this->out = array(
			"Error" => array(
				"Code"=>1, 
				"Text"=>"მოხდა შეცდომა !",
				"Details"=>"!"
			)
		);

		$form = functions\makeForm::open(array(
			"action"=>"?",
			"method"=>"post",
			"class"=>"materialize",
			"id"=>"",
		));

		$form .= functions\makeForm::label(array(
			"id"=>"usernameLabel", 
			"for"=>"username", 
			"name"=>"მომხმარებლის სახელი",
			"require"=>""
		));

	
		$form .= functions\makeForm::inputText(array(
			"placeholder"=>"მომხმარებლის სახელი", 
			"id"=>"username", 
			"name"=>"username",
			"readonly"=>"true",
			"value"=>$_SESSION[Config::SESSION_PREFIX."username"]
		));

		$form .= functions\makeForm::label(array(
			"id"=>"oldpasswordLabel", 
			"for"=>"oldpassword", 
			"name"=>"ძველი პაროლი",
			"require"=>""
		));

	
		$form .= functions\makeForm::inputText(array(
			"placeholder"=>"ძველი პაროლი", 
			"id"=>"oldpassword", 
			"name"=>"oldpassword",
			"value"=>""
		));


		$form .= functions\makeForm::label(array(
			"id"=>"passwordLabel", 
			"for"=>"password", 
			"name"=>"პაროლი",
			"require"=>""
		));

	
		$form .= functions\makeForm::inputText(array(
			"placeholder"=>"პაროლი", 
			"id"=>"password", 
			"name"=>"password",
			"value"=>""
		));

		$form .= functions\makeForm::label(array(
			"id"=>"passwordConfirmLabel", 
			"for"=>"passwordConfirm", 
			"name"=>"პაროლის დადასტურება",
			"require"=>""
		));

	
		$form .= functions\makeForm::inputText(array(
			"placeholder"=>"პაროლის დადასტურება", 
			"id"=>"passwordConfirm", 
			"name"=>"passwordConfirm",
			"value"=>""
		));



		$form .= functions\makeForm::close();

		
		$this->out = array(
			"Error" => array(
				"Code"=>0, 
				"Text"=>"ოპერაცია შესრულდა წარმატებით !",
				"Details"=>""
			),
			"form" => $form,
			"attr" => "edit_profile_password('".$lang."')"
		);



		return $this->out;
	}
}