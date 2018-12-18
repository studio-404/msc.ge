<?php 
class searchBy
{
	private $conn;

	public function index($conn, $args)
	{
		$out = 0;
		$this->conn = $conn;
		if(method_exists("searchBy", $args['method']))
		{
			$out = $this->$args['method']($args);
		}
		return $out;
	}

	public function select($args)
	{
		if(mb_strlen($args["word"],'UTF-8')<=6){
			return array();
		}
		$sql = "
		(SELECT 
		`navigation`.`idx` AS page_idx,  
		`navigation`.`title` AS page_title,  
		`navigation`.`text` AS page_text,  
		`navigation`.`type` AS page_type, 
		`navigation`.`slug` AS page_slug, 
		`navigation`.`cid` AS page_cid 
		FROM 
		`navigation` 
		WHERE 
		(
			MATCH (`navigation`.`title`) AGAINST (:post) OR 
			MATCH (`navigation`.`description`) AGAINST (:post) OR 
			MATCH (`navigation`.`text`) AGAINST (:post) OR 
			`navigation`.`title` LIKE '%:post%' OR 
			`navigation`.`description` LIKE '%:post%' OR 
			`navigation`.`text` LIKE '%:post%'
		) AND 
		`lang`=:lang AND 
		`visibility`!=:one AND 
		`status`!=:one ORDER BY `navigation`.`title` ASC)
		UNION 
		(
			SELECT 
			`usefull`.`idx` AS page_idx, 
			`usefull`.`title` AS page_title, 
			`usefull`.`description` AS page_text, 
			`usefull`.`type` AS page_type, 
			`usefull`.`idx` AS page_slug, 
			`usefull`.`cid` AS page_cid
			FROM 
			`usefull` 
			WHERE 
			(
				MATCH (`usefull`.`title`) AGAINST (:post) OR 
				MATCH (`usefull`.`description`) AGAINST (:post) OR 
				`usefull`.`title` LIKE '%:post%' OR 
				`usefull`.`description` LIKE '%:post%'  
			) AND 
			`usefull`.`lang`=:lang AND 
			`usefull`.`visibility`!=:one AND 
			`usefull`.`status`!=:one AND 
			(
				`usefull`.`type`='news' 				
			) ORDER BY `usefull`.`title` ASC
		)
		";

		$prepare = $this->conn->prepare($sql);
		$prepare->execute(array(
			":lang"=>$args["lang"], 
			":one"=>1,
			":post"=>$args["word"]
		));
		if($prepare->rowCount()){
			return $prepare->fetchAll(PDO::FETCH_ASSOC);
		}
		return array();

	}
}