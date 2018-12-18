<?php
namespace functions;

class poll{

	private $module_type;
	private $user_ip;
	private $module_colums;


	public function __construct($module_type, $module_colums){
		require_once("app/functions/server.php");
		$server = new \functions\server();
		$this->module_type = $module_type;
		$this->user_ip = $server->ip();
		$this->module_colums = $module_colums;
	}

	public function select()
	{
		$selectModuleByType = new \Database("modules", array(
			"method"=>"selectPoll",
			"type"=>$this->module_type
		));

		$fetch = $selectModuleByType->getter();
		$out = "";
		if($fetch){
			$out .= "<div class=\"pollbox\">";
			$out .= sprintf(
				"<div class=\"polltitle\">%s</div>",
				$fetch["title"]
			);

			$out .= "<div class=\"pollanswers\">";
			
			$resultPoll = new \Database("modules", array(
				"method"=>"resultPoll",
				"type"=>"poll",
				"poll_id"=>$fetch["idx"]
			));
			$result = $resultPoll->getter();

			$x = 1;
			foreach($this->module_colums as $value):
			if($fetch[$value]!="" && $fetch[$value]!="empty"){
				$out .= sprintf(
					"<div class=\"answer\" data-col=\"%s\" data-polid=\"%s\" title=\"%s\"><span>%s %s</span><span class=\"per\" style=\"width:%s\"></span></div>",
					$value,
					$fetch["idx"],
					strip_tags($fetch[$value]),
					strip_tags($fetch[$value]),
					(int)$result[$value]."%",
					(int)$result[$value]."%"
				);
			}
			$x++;
			endforeach;

			$out .= "</div>";


			$out .= "</div>";
		}
		return $out;
	}


	public function insertAnswer($poll_id, $answer)
	{
		$Database = new \Database('modules', array(
			'method'=>'updatePoll', 
			'poll_id'=>$poll_id, 
			'user_ip'=>$this->user_ip, 
			'answer'=>$answer
		));	
		return $this->select();
	}



}