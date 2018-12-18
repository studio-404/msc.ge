<?php 
class editFormModules
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

		$idx = functions\request::index("POST","idx");
		$lang = functions\request::index("POST","lang");
		$date = functions\request::index("POST","date");
		$title = functions\request::index("POST","title");
		$pageText = functions\request::index("POST","pageText");
		$link = functions\request::index("POST","link");
		$additional1 = functions\request::index("POST","additional1");
		$additional2 = functions\request::index("POST","additional2");
		$additional3 = functions\request::index("POST","additional3");
		$additional4 = functions\request::index("POST","additional4");
		$additional5 = functions\request::index("POST","additional5");
		$classname = functions\request::index("POST","classname");
		$map_coordinates = functions\request::index("POST","map_coordinates");
		$serialPhotos = unserialize(functions\request::index("POST","serialPhotos"));
		$serialFiles = unserialize(functions\request::index("POST","serialFiles"));
		
		
		if($idx == "" || $lang=="" || $date=="" || $title=="")
		{
			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>"ყველა ველი სავალდებულოა !",
					"Details"=>"!"
				)
			);
		}else{
			$Database = new Database('modules', array(
					'method'=>'edit', 
					'idx'=>$idx, 
					'lang'=>$lang, 
					'date'=>$date, 
					'title'=>$title, 
					'pageText'=>$pageText, 
					'link'=>$link, 
					'additional1'=>$additional1, 
					'additional2'=>$additional2, 
					'additional3'=>$additional3, 
					'additional4'=>$additional4, 
					'additional5'=>$additional5, 
					'classname'=>$classname, 
					'map_coordinates'=>$map_coordinates, 
					'serialPhotos'=>$serialPhotos, 
					'serialFiles'=>$serialFiles  
			));
			$output = $Database->getter();

			if($output){
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
			}else{
				$this->out = array(
					"Error" => array(
						"Code"=>1, 
						"Text"=>"ოპერაციის შესრულებისას დაფიქსირდა შეცდომა !",
						"Details"=>""
					)
				);
			}
		}

		return $this->out;
	}
}