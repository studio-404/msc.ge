<?php 
class modules
{
	private $conn;

	public function __construct(){

	}

	public function index($conn, $args)
	{
		$out = 0;
		$this->conn = $conn;
		if(method_exists("modules", $args['method']))
		{
			$out = $this->$args['method']($args);
		}
		return $out;
	}

	private function editParentModule($args)
	{
		$update = "UPDATE `usefull_modules` SET `title`=:title, `fields`=:field WHERE `lang`=:lang AND `idx`=:idx";
		$prepare = $this->conn->prepare($update);
		$prepare->execute(array(
			":title"=>$args['title'],
			":field"=>trim($args['field'], " "),
			":lang"=>$args['lang'], 
			":idx"=>$args['idx'] 
		));		
		return true;
	}

	private function deleteParentModule($args)
	{
		$select1 = "SELECT `type` FROM `usefull_modules` WHERE `idx`=:idx LIMIT 1";
		$prepare1 = $this->conn->prepare($select1);
		$prepare1->execute(array(
			":idx"=>$args['idx'] 
		));

		if($prepare1->rowCount()){
			$fetch1 = $prepare1->fetch(PDO::FETCH_ASSOC);
			
			$update2 = "UPDATE `usefull_modules` SET `status`=:one WHERE `idx`=:idx";
			$prepare2 = $this->conn->prepare($update2);
			$prepare2->execute(array(
				":one"=>1, 
				":idx"=>$args['idx'] 
			));

			$update3 = "UPDATE `usefull` SET `status`=:one WHERE `type`=:type";
			$prepare3 = $this->conn->prepare($update3);
			$prepare3->execute(array(
				":one"=>1, 
				":type"=>$fetch1['type'] 
			));		
		}
		return true;
	}

	private function selectParentUsefull($args)
	{
		$fetch = array();
		$select = "SELECT * FROM `usefull_modules` WHERE `lang`=:lang AND `status`!=:one ORDER BY `id` ASC";
		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":one"=>1,
			":lang"=>$_SESSION["LANG"]
		));
		if($prepare->rowCount()){
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
		}
		
		return $fetch;
	}

	private function selectParentFieldsByType($args)
	{
		$fetchJson = "[]";
		$select = "SELECT `fields` FROM `usefull_modules` WHERE `type`=:type AND `lang`=:lang AND `status`!=:one";
		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":type"=>$args['type'],
			":one"=>1,
			":lang"=>$_SESSION["LANG"]
		));
		if($prepare->rowCount()){
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
			$fetchJson = $fetch['fields']; 
		}
		
		return json_decode($fetchJson, true);
	}

	private function parentModuleOptions($args)
	{
		$options = array();
		$fetch = $this->selectParentUsefull($args);
		foreach ($fetch as $val) {
			$options[$val['type']] = $val['title'];
		}
		$options["false"] = "- მიმაგრების მოხსნა";
		return $options;
	}

	private function selectContactData($args)
	{
		$fetch = "[]";
		$json = Config::CACHE."module_contactinfo_".str_replace(array("-"," "), "", implode("_",$_SESSION['URL']))."_".$args['lang'].".json";

		if(file_exists($json)){
			$fetch = @file_get_contents($json); 
		}else{
			$select = "SELECT `title`, `classname`, `description` FROM `usefull` WHERE `type`=:type AND `lang`=:lang AND `visibility`!=:one AND `status`!=:one ORDER BY `date` DESC";
			$prepare = $this->conn->prepare($select);
			$prepare->execute(array(
				":type"=>"contactinfo",
				":one"=>1,
				":lang"=>$args['lang']
			));
			if($prepare->rowCount()){
				$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
				

				$fh = @fopen($json, 'w') or die("Error opening output file");
				@fwrite($fh, json_encode($fetch, JSON_UNESCAPED_UNICODE));
				@fclose($fh);

				$fetch = @file_get_contents($json); 

			}
		}
		
		return json_decode($fetch, true);
	}

	private function resultPoll($args)
	{
		$select = "SELECT 
		`poll`.*
		FROM 
		`poll` 
		WHERE 
		`poll`.`poll_id`=:poll_id";

		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":poll_id"=>$args['poll_id']
		));

		$answer1 = 0;
		$answer2 = 0;
		$answer3 = 0;
		$answer4 = 0;
		$answer5 = 0;
		$total = $prepare->rowCount();
		if($total){
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);

			foreach($fetch as $val):
				if($val["answer"]=="classname"){
					$answer1 += 1;
				}

				if($val["answer"]=="url"){
					$answer2 += 1;
				}

				if($val["answer"]=="additional1"){
					$answer3 += 1;
				}

				if($val["answer"]=="additional2"){
					$answer4 += 1;
				}

				if($val["answer"]=="additional3"){
					$answer5 += 1;
				}
			endforeach;

			$out["classname"] = (100 / $total) * $answer1;
			$out["url"] = (100 / $total) * $answer2;
			$out["additional1"] = (100 / $total) * $answer3;
			$out["additional2"] = (100 / $total) * $answer4;
			$out["additional3"] = (100 / $total) * $answer5;
			
		}

		return $out;
	}

	private function selectPoll($args)
	{
		$fetch = array();
		$select = "SELECT 
		`usefull`.*
		FROM 
		`usefull` 
		WHERE 
		`usefull`.`type`=:type AND 
		`usefull`.`visibility`!=:one AND 
		`usefull`.`lang`=:lang AND 
		`usefull`.`status`!=:one ORDER BY rand() LIMIT 1";

		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":type"=>$args['type'], 
			":one"=>1,
			":lang"=>$_SESSION["LANG"]
		));
		if($prepare->rowCount()){
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		}

		return $fetch;
	}

	private function updatePoll($args)
	{
		$delete = "DELETE FROM `poll` WHERE `poll_id`=:poll_id AND `user_ip`=:user_ip";

		$prepare = $this->conn->prepare($delete);
		$prepare->execute(array(
			":poll_id"=>$args['poll_id'], 
			":user_ip"=>$args['user_ip'] 
		));
		
		$insert = "INSERT INTO `poll` SET  `poll_id`=:poll_id, `user_ip`=:user_ip, `answer`=:answer";
		$prepare2 = $this->conn->prepare($insert);
		$prepare2->execute(array(
			":poll_id"=>$args['poll_id'], 
			":user_ip"=>$args['user_ip'],
			":answer"=>$args['answer']
		));

		return 1;
	}

	private function selectModuleByType($args)
	{
		$fetch = "[]";
		$orderBy = (isset($args["order"]) && isset($args["by"])) ? sprintf(" ORDER BY %s %s", $args["order"], $args["by"]) : "";
		$limit = (isset($args['from']) && isset($args['num'])) ? " LIMIT ".$args["from"].",".$args['num'] : "";
		$from = (isset($args["from"])) ? $args["from"] : 0;
		$lang = (isset($args['lang'])) ? $args['lang'] : $_SESSION["LANG"];
		$where = (isset($args["where"])) ? $args["where"] : '';
		$jsonAddon = (isset($args["jsonAddon"])) ? $args["jsonAddon"] : '';
		// $visibility = (isset($args["visibility"])) ? 0 : '';
		$num = (isset($args['num']) && !empty($args['num'])) ? $args['num'] : "";
		$json = Config::CACHE."module_type_".$num.str_replace(array("-"," "), "", implode("_",$_SESSION['URL']))."_".$lang.$from.$args['type'].$jsonAddon.".json";


		if(file_exists($json)){
			$fetch = @file_get_contents($json); 
		}else{
			$select = "SELECT 
			`usefull`.*, 
			(
				SELECT 
				COUNT(`usefull`.`idx`) 
				FROM 
				`usefull`
				WHERE 
				`usefull`.`type`=:type AND 
				`usefull`.`visibility`!=:one AND 
				`usefull`.`lang`=:lang AND 
				`usefull`.`status`!=:one{$where}
			) AS count, 
			(SELECT `photos`.`path` FROM `photos` WHERE `photos`.`parent`=`usefull`.`idx` AND `photos`.`type`=`usefull`.`type` AND `photos`.`lang`=`usefull`.`lang` AND `photos`.`status`!=:one ORDER BY `photos`.`id` ASC LIMIT 1) AS photo
			FROM 
			`usefull` 
			WHERE 
			`usefull`.`type`=:type AND 
			`usefull`.`visibility`!=:one AND 
			`usefull`.`lang`=:lang AND 
			`usefull`.`status`!=:one{$where}".$orderBy.$limit;

			$prepare = $this->conn->prepare($select);
			$prepare->execute(array(
				":type"=>$args['type'], 
				":one"=>1,
				":lang"=>$lang
			));
			if($prepare->rowCount()){
				$db_fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);

				$fh = @fopen($json, 'w') or die("Error opening output file");
				@fwrite($fh, json_encode($db_fetch,JSON_UNESCAPED_UNICODE));
				@fclose($fh);

				$fetch = @file_get_contents($json); 
			}
		}
		
		return json_decode($fetch, true);
	}

	private function selectModuleByTypeLoadmore($args)
	{
		$fetch = array();
		$limit = (isset($args['from']) && isset($args['num'])) ? " LIMIT ".(int)$args["from"].",".(int)$args['num'] : ""; 
		
		$select = "SELECT *, 
		(
			SELECT `photos`.`path` FROM `photos` WHERE 
			`photos`.`parent`=`usefull`.`idx` AND 
			`photos`.`lang`=:lang AND 
			`photos`.`type`='news' AND 
			`photos`.`status`!=:one 
			ORDER BY `photos`.`id` ASC LIMIT 1
		) as photo 
		FROM 
		`usefull` 
		WHERE 
		`usefull`.`type`=:type AND 
		`usefull`.`visibility`!=:one AND 
		`usefull`.`lang`=:lang AND 
		`usefull`.`status`!=:one 
		ORDER BY `usefull`.`date` DESC".$limit;	

		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":type"=>$args['type'], 
			":one"=>1,
			":lang"=>$_SESSION["LANG"]
		));
		if($prepare->rowCount()){
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
		}
		
		return $fetch;
	}

	private function select($args)
	{
		$fetch = array();
		$itemPerPage = $args['itemPerPage'];
		$from = (isset($_GET['pn']) && $_GET['pn']>0) ? (($_GET['pn']-1)*$itemPerPage) : 0;
		
		$s = '';
		if(isset($_GET['s'])){
			$s = ' AND (`title` LIKE "%'.$_GET['s'].'%" OR `description`="%'.$_GET['s'].'%") ';
		}

		$parsed_url = $args['parsed_url'];
		if(isset($parsed_url[3])){
			$select = "SELECT (SELECT COUNT(`id`) FROM `usefull` WHERE `type`=:type AND `lang`=:lang AND `status`!=:one) as counted, `idx`, `title`, `visibility`, `lang` FROM `usefull` WHERE `type`=:type AND `lang`=:lang AND `status`!=:one{$s} ORDER BY `date` DESC LIMIT ".$from.",".$itemPerPage;
			$prepare = $this->conn->prepare($select); 
			$prepare->execute(array(
				":type"=>$parsed_url[3], 
				":lang"=>$args['lang'],
				":one"=>1
			));
			if($prepare->rowCount()){
				$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
			}
		}
		return $fetch;
	}

	private function selectById($args)
	{
		$fetch = array();
		
		$select = "SELECT * FROM `usefull` WHERE `idx`=:idx AND `lang`=:lang AND `status`!=:one";
		$prepare = $this->conn->prepare($select); 
		$prepare->execute(array(
			":idx"=>$args['idx'], 
			":lang"=>$args['lang'], 
			":one"=>1
		));
		if($prepare->rowCount()){
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		}
		return $fetch;
	}

	private function selectByIdAndType($args)
	{
		require_once("app/functions/request.php");
		$view = (int)functions\request::index("GET","view");
		$fetch = "[]";
		
		$json = Config::CACHE."module_bytypeandid_".$view.str_replace(array("-"," "), "", implode("_",$_SESSION['URL']))."_".$_SESSION["LANG"].$args['type'].".json";


		if(file_exists($json)){
			$fetch = @file_get_contents($json); 
		}else{
			$select = "SELECT * FROM `usefull` WHERE `idx`=:idx AND `type`=:type AND `lang`=:lang AND `status`!=:one";
			$prepare = $this->conn->prepare($select); 
			$prepare->execute(array(
				":idx"=>$args['idx'], 
				":lang"=>$args['lang'], 
				":type"=>$args['type'], 
				":one"=>1
			));
			if($prepare->rowCount()){
				$db_fetch = $prepare->fetch(PDO::FETCH_ASSOC);

				$fh = @fopen($json, 'w') or die("Error opening output file");
				@fwrite($fh, json_encode($db_fetch,JSON_UNESCAPED_UNICODE));
				@fclose($fh);

				$fetch = @file_get_contents($json); 

			}
		}
		return json_decode($fetch, true);
	}

	private function edit($args)
	{
		require_once 'app/functions/files.php';

		$idx = $args["idx"];
		$lang = $args["lang"];
		$date = strtotime($args["date"]);
		$date_format = date("Y-m-d", $date);
		$title = $args["title"];
		$description = $args["pageText"];
		$url = (!empty($args["link"])) ? $args["link"] : "";
		$additional1 = (!empty($args["additional1"])) ? $args["additional1"] : "";
		$additional2 = (!empty($args["additional2"])) ? $args["additional2"] : "";
		$additional3 = (!empty($args["additional3"])) ? $args["additional3"] : "";
		$additional4 = (!empty($args["additional4"])) ? $args["additional4"] : "";
		$additional5 = (!empty($args["additional5"])) ? $args["additional5"] : "";
		$classname = (!empty($args["classname"])) ? $args["classname"] : "";
		$map_coordinates = (!empty($args["map_coordinates"])) ? $args["map_coordinates"] : "";
		$type = $this->getTypeByIdx($args["idx"]);

		// update all languages
		$update1 = "UPDATE `usefull` SET 
		`date`=:datex, 
		`date_format`=:date_format 
		WHERE `idx`=:idx";
		$prepare1 = $this->conn->prepare($update1);
		$prepare1->execute(array(
			":datex"=>$date,
			":date_format"=>$date_format,
			":idx"=>$idx
		));

		$update = "UPDATE `usefull` SET 
		`title`=:title, 
		`description`=:description, 
		`url`=:url, 
		`additional1`=:additional1, 
		`additional2`=:additional2, 
		`additional3`=:additional3, 
		`additional4`=:additional4, 
		`additional5`=:additional5, 
		`classname`=:classname, 
		`map_coordinates`=:map_coordinates
		WHERE `idx`=:idx AND `lang`=:lang";
		$prepare = $this->conn->prepare($update);
		$prepare->execute(array(
			":title"=>$title,
			":description"=>$description,
			":url"=>$url,
			":additional1"=>$additional1,
			":additional2"=>$additional2,
			":additional3"=>$additional3,
			":additional4"=>$additional4,
			":additional5"=>$additional5,
			":classname"=>$classname,
			":map_coordinates"=>$map_coordinates,
			":idx"=>$idx, 
			":lang"=>$lang 
		));	

		$photos = new Database('photos', array(
			'method'=>'deleteByParent', 
			'idx'=>$idx, 
			'type'=>$type
		));


		$select = "SELECT `title` FROM `languages`";
		$prepare = $this->conn->prepare($select);
		$prepare->execute();
		$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);

		foreach ($fetch as $val) :
		if(count($args["serialPhotos"])){
			foreach($args["serialPhotos"] as $pic) {
				if(!empty($pic)):
				$photo = 'INSERT INTO `photos` SET `parent`=:parent, `path`=:pathx, `type`=:type, `lang`=:lang, `status`=:zero';
				$photoPerpare = $this->conn->prepare($photo);
				$photoPerpare->execute(array(
					":parent"=>$idx, 
					":pathx"=>$pic, 
					":type"=>$type, 
					":lang"=>$val['title'], 
					":zero"=>0
				));
				endif;
			}
		}
		endforeach;

		// remove old files
		$removeFiles = "DELETE FROM `file_system` WHERE `page_id`=:page_id AND `type`=:type AND `lang`=:lang"; 
		$fileDeletePerpare = $this->conn->prepare($removeFiles);
		$fileDeletePerpare->execute(array(
			":page_id"=>$args["idx"], 
			":lang"=>$lang, 
			":type"=>"module"  
		));

		if(count($args["serialFiles"])){
			$fileposition = 1;
			foreach ($args["serialFiles"] as $file) {
				if(!empty($file)):
				$explode = explode(",",$file); 
				$type = (isset($explode[0])) ? $explode[0] : "";
				$random = (isset($explode[1])) ? $explode[1] : "";
				$idx = (isset($explode[2])) ? $explode[2] : "";
				$cid = (isset($explode[3])) ? $explode[3] : "";
				$path = (isset($explode[4])) ? $explode[4] : "";

				$fpath = Config::WEBSITE.Config::PUBLIC_FOLDER_NAME."/".$path;
				$file_size = functions\files::get_size($fpath);

				if($idx != "" && $cid != "" && $path != ""){
					$files = 'INSERT INTO `file_system` SET `date`=:datex, `idx`=:idx, `cid`=:cid, `page_id`=:page_id, `file_path`=:file_path, `file_size`=:file_size, `type`=:type, `lang`=:lang, `position`=:position';
					$filePerpare = $this->conn->prepare($files);
					$filePerpare->execute(array(
					":datex"=>time(), 
					":idx"=>$idx, 
					":cid"=>$cid, 
					":page_id"=>$args["idx"], 
					":file_path"=>$path, 
					":file_size"=>$file_size,
					":lang"=>$lang,
					":type"=>$type,
					":position"=>$fileposition					
					));

					$fileposition++;					
				}
				
				endif;
			}
		}
		$this->clearCache();
		return 1;
	}

	private function getTypeByIdx($idx)
	{
		$sql = "SELECT `type` FROM `usefull` WHERE `idx`=:idx AND `status`!=:one";
		$prepare = $this->conn->prepare($sql);
		$prepare->execute(array(
			":idx"=>$idx, 
			":one"=>1 
		));
		if($prepare->rowCount())
		{
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
			return $fetch['type'];
		}
		return 0;
	}

	private function updateVisibility($args)
	{
		$visibility = ($args['visibility']==0) ? 1 : 0;
		$idx = (int)$args['idx'];

		$update = "UPDATE `usefull` SET `visibility`=:visibility WHERE `idx`=:idx";
		$prepare = $this->conn->prepare($update);
		$prepare->execute(array(
			":visibility"=>$visibility, 
			":idx"=>$idx
		));
		if($prepare->rowCount())
		{
			$this->clearCache();
			return 1;
		}
		return 0;
	}

	// private function updateParentFieldModule($args)
	// {
	// 	$fetch = array();
	// 	$select = "SELECT `id`, `fields` FROM `usefull_modules`";
	// 	$prepare = $this->conn->prepare($select);
	// 	$prepare->execute();
	// 	if($prepare->rowCount()){
	// 		$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);

	// 		foreach ($fetch as $v) {
	// 			$toArray = json_decode($v['fields'], true);
	// 			$toArray["map_coordinates"] = array(
	// 				"visibility"=>"false",
	// 				"title"=>"რუკის კორდინატები",
	// 				"defaultValue"=>""
	// 			);

	// 			$toJson = json_encode($toArray, JSON_UNESCAPED_UNICODE); 
	// 			$update = "UPDATE `usefull_modules` SET `fields`=:fields WHERE `id`=:id";
	// 			$prepare2 = $this->conn->prepare($update);
	// 			$prepare2->execute(array(
	// 				":fields"=>$toJson,
	// 				":id"=>$v["id"]
	// 			));
	// 		}
	// 	}

	// 	return $fetch;
	// }

	private function addParent($args)
	{
		$type = $args['type'];
		$title = $args['title'];

		$select = "SELECT `title` FROM `languages`";
		$prepare = $this->conn->prepare($select);
		$prepare->execute();
		$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);

		$max = "SELECT MAX(`idx`) as maxidx FROM `usefull_modules`";
		$prepare2 = $this->conn->prepare($max);
		$prepare2->execute(array(":one"=>1));
		$fetch2 = $prepare2->fetch(PDO::FETCH_ASSOC);
		$maxId = ($fetch2["maxidx"]) ? $fetch2["maxidx"] + 1 : 1;
		$json = '{
			"date": {
			  "visibility":"true",
			  "title":"თარიღი",
			  "defaultValue":""
			},
			"title":{
				"visibility":"true",
				"title":"სათაური",
				"defaultValue":""
			},
			"pageText":{
				"visibility":"true",
				"title":"აღწერა",
				"defaultValue":""
			},
			"classname":{
				"visibility":"true",
				"title":"კლასი",
				"defaultValue":""
			},
			"link":{
				"visibility":"true",
				"title":"ბმული",
				"defaultValue":""
			},
			"additional1":{
				"visibility":"false",
				"title":"Additional 1",
				"defaultValue":""
			},
			"additional2":{
				"visibility":"false",
				"title":"Additional 2",
				"defaultValue":""
			},
			"additional3":{
				"visibility":"false",
				"title":"Additional 3",
				"defaultValue":""
			},
			"additional4":{
				"visibility":"false",
				"title":"Additional 4",
				"defaultValue":""
			},
			"additional5":{
				"visibility":"false",
				"title":"Additional 5",
				"defaultValue":""
			},
			"photoUploaderBox":{
				"visibility":"true",
				"title":"ფოტოს მიმაგრება",
				"defaultValue":""
			},
			"file_attach":{
				"visibility":"true",
				"title":"ფაილის მიმაგრება",
				"defaultValue":""
			},
			"map_coordinates":{
				"visibility":"false",
				"title":"რუკის კორდინატები",
				"defaultValue":""
			}
		}';
		foreach ($fetch as $val) {
			$insert = "INSERT INTO `usefull_modules` SET `idx`=:idx, `type`=:type, `title`=:title, `fields`=:fields, `lang`=:lang";
			$prepare3 = $this->conn->prepare($insert);
			$prepare3->execute(array(
				":idx"=>$maxId,  
				":type"=>$type, 
				":title"=>$title, 
				":fields"=>trim($json, " "), 
				":lang"=>$val['title']
			)); 
		}

		$this->clearCache();
		return array("test"=>"true");
	}

	private function add($args)
	{
		$date = strtotime($args['date']);
		$date_format = date("Y-m-d", $date);
		$type = $args['moduleSlug'];
		$title = $args['title'];
		$pageText = $args['pageText'];
		$link = (!empty($args["link"])) ? $args["link"] : "";
		$additional1 = (!empty($args["additional1"])) ? $args["additional1"] : "";
		$additional2 = (!empty($args["additional2"])) ? $args["additional2"] : "";
		$additional3 = (!empty($args["additional3"])) ? $args["additional3"] : "";
		$additional4 = (!empty($args["additional4"])) ? $args["additional4"] : "";
		$additional5 = (!empty($args["additional5"])) ? $args["additional5"] : "";
		$classname = (!empty($args["classname"])) ? $args["classname"] : "";
		$map_coordinates = (!empty($args["map_coordinates"])) ? $args["map_coordinates"] : "";

		$select = "SELECT `title` FROM `languages`";
		$prepare = $this->conn->prepare($select);
		$prepare->execute();
		$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);

		$max = "SELECT MAX(`idx`) as maxidx FROM `usefull`";
		$prepare2 = $this->conn->prepare($max);
		$prepare2->execute(array(":one"=>1));
		$fetch2 = $prepare2->fetch(PDO::FETCH_ASSOC);
		$maxId = ($fetch2["maxidx"]) ? $fetch2["maxidx"] + 1 : 1;

		foreach ($fetch as $val) {
			$insert = "INSERT INTO `usefull` SET 
			`idx`=:idx, 
			`date`=:datex, 
			`date_format`=:date_format, 
			`type`=:type, 
			`title`=:title, 
			`description`=:description, 
			`url`=:url, 
			`classname`=:classname, 
			`map_coordinates`=:map_coordinates, 
			`additional1`=:additional1, 
			`additional2`=:additional2, 
			`additional3`=:additional3, 
			`additional4`=:additional4, 
			`additional5`=:additional5, 
			`lang`=:lang";
			$prepare3 = $this->conn->prepare($insert);
			$prepare3->execute(array(
				":idx"=>$maxId, 
				":datex"=>$date, 
				":date_format"=>$date_format, 
				":type"=>$type, 
				":title"=>$title, 
				":description"=>$pageText, 
				":url"=>$link,
				":classname"=>$classname,
				":map_coordinates"=>$map_coordinates,
				":additional1"=>$additional1,
				":additional2"=>$additional2,
				":additional3"=>$additional3,
				":additional4"=>$additional4,
				":additional5"=>$additional5,
				":lang"=>$val['title']
			)); 

			if(count($args["serialPhotos"])){
				foreach ($args["serialPhotos"] as $pic) {
					if(!empty($pic)):
					$photo = 'INSERT INTO `photos` SET `parent`=:parent, `path`=:pathx, `type`=:type, `lang`=:lang, `status`=:zero';
					$photoPerpare = $this->conn->prepare($photo);
					$photoPerpare->execute(array(
						":parent"=>$maxId, 
						":pathx"=>$pic, 
						":type"=>$type, 
						":lang"=>$val['title'], 
						":zero"=>0
					));
					endif;
				}
			}
		}

		if(count($args["serialFiles"])){
			$fileposition = 1;
			foreach ($args["serialFiles"] as $file) {
				if(!empty($file)):
				$explode = explode(",",$file); 
				$type = (isset($explode[0])) ? $explode[0] : "";
				$random = (isset($explode[1])) ? $explode[1] : "";
				$idx = (isset($explode[2])) ? $explode[2] : "";
				$cid = (isset($explode[3])) ? $explode[3] : "";
				$path = (isset($explode[4])) ? $explode[4] : "";
				$current_lang = $args['lang'];

				if($type != "" && $random != "" && $idx != "" && $cid != "" && $path != ""){
					$files = 'UPDATE `file_system` SET `type`=:type, `random`=:clear, `page_id`=:page_id, `lang`=:lang, `position`=:position WHERE `idx`=:idx AND `cid`=:cid AND `random`=:random';
					$filePerpare = $this->conn->prepare($files);
					$filePerpare->execute(array(
					":clear"=>"", 
					":page_id"=>$maxId, 
					":position"=>$fileposition, 
					":lang"=>$current_lang,
					":idx"=>$idx, 
					":cid"=>$cid, 
					":random"=>$random, 
					":type"=>$type 
					));

					$fileposition++;					
				}
				
				endif;
			}
		}
		$this->clearCache();
		return array("test"=>"true");
	}

	private function selectMonthEvents($args)
	{
		$date = sprintf(
			"%s-%s-%s", 
			$args["day"],
			$args["month"], 
			$args["year"] 
		);
		$date = strtotime($date);

		$fetch = array();
		$sql = "SELECT `idx`,`title` FROM `usefull` WHERE `type`=:type AND `date`=:datex AND `lang`=:lang AND `visibility`!=:one AND `status`!=:one";
		$prepare = $this->conn->prepare($sql);
		$prepare->execute(array(
			":type"=>"event", 
			":datex"=>$date, 
			":lang"=>$args['lang'], 
			":one"=>1 
		));
		if($prepare->rowCount())
		{
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
			return $fetch;
		}
		return false;
	}

	private function translate($args)
	{
		$fetch = array();
		$sql = "SELECT `description` FROM `usefull` WHERE `title`=:title AND `type`=:type AND `lang`=:lang AND `visibility`!=:one AND `status`!=:one";
		$prepare = $this->conn->prepare($sql);
		$prepare->execute(array(
			":type"=>"languagedata", 
			":title"=>$args['word'], 
			":lang"=>$args['lang'], 
			":one"=>1 
		));
		if($prepare->rowCount())
		{
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
			return strip_tags($fetch['description']);
		}
		return "";
	}

	private function removeModule($args)
	{
		$idx = $args['idx'];

		$selectType = "SELECT `type` FROM `usefull` WHERE `idx`=:idx"; 
		$prep = $this->conn->prepare($selectType); 
		$prep->execute(array(
			"idx"=>$idx
		));
		if($prep->rowCount()){
			$fet = $prep->fetch(PDO::FETCH_ASSOC); 
			$photoRemove = "UPDATE `photos` SET `status`=:one WHERE `parent`=:parent AND `type`=:type";
			$photoPrepare = $this->conn->prepare($photoRemove); 
			$photoPrepare->execute(array(
				":one"=>1,
				":parent"=>$idx,
				":type"=>$fet['type']
			));
		}

		$update = "UPDATE `usefull` SET `status`=:one WHERE `idx`=:idx";
		$prepare = $this->conn->prepare($update); 
		$prepare->execute(array(
			":one"=>1,
			":idx"=>$idx
		));
		$this->clearCache();
		return $prepare->rowCount();
	}

	private function clearCache()
	{
		$mask = Config::CACHE.'module_*.*';
		array_map('unlink', glob($mask));
	}
}