<?php 
class _staff
{
	public $data; 

	public function index()
	{
		require_once("app/functions/string.php"); 
		require_once("app/functions/l.php"); 
		require_once("app/functions/strip_output.php");

		$l = new functions\l(); 
		$sting = new functions\string();
		$out = "";

		$return["count"] = (isset($this->data[0]['count'])) ? $this->data[0]['count'] : 0;
		if($return["count"]){
			foreach($this->data as $value) {
				$photos = new Database("photos",array(
					"method"=>"selectByParent", 
					"idx"=>(int)$value['idx'],  
					"lang"=>strip_output::index($value['lang']),  
					"type"=>strip_output::index($value['type'])
				));
				if($photos->getter()){
					$pic = $photos->getter();
					$image = sprintf(
						"%s%s/image/loadimage?f=%s%s&w=350&h=260",
						Config::WEBSITE,
						strip_output::index($_SESSION['LANG']),
						Config::WEBSITE_,
						strip_output::index($pic[0]['path'])
					);
				}else{
					$image = "/public/filemanager/noimage.png";
				}
				$title = strip_tags($value['title']);
				$titleUrl = str_replace(array(" ", "'", '"'), "-", $title); 

				$out .= "<div class=\"medium-4 small-12 columns\">";
				$out .= "<div class=\"course\">";
				$out .= "<div class=\"course-thumb\" style=\"margin-bottom:10px;\">";
				$out .= sprintf(
					"<img src=\"%s\" alt=\"\" width=\"%s\" />",
					$image,
					"100%"
				);
				$out .= "</div>";
				$out .= sprintf(
					"<h3>%s</h3>", 
					$title
				);
				$out .= sprintf(
					"<p>%s</p>", 
					$value['classname']
				);
				$out .= "<ul class=\"no-bullet\">";
				
				if(!empty($value['url'])):
					$out .= sprintf(
						"<li><i class=\"fa fa-phone-square\" aria-hidden=\"true\"></i> <span>%s</span></li>",
						strip_tags($value['url'])
					);
				endif;

				if(!empty($value['additional1'])):
				$out .= sprintf(
					"<li style=\"display: inline-block\"><a href=\"%s\"><i class=\"fa fa-facebook-official\" aria-hidden=\"true\"></i></a></li>",
					$value['additional1']
				);
				endif;

				if(!empty($value['additional2'])):
				$out .= sprintf(
					"<li style=\"display: inline-block\"><a href=\"%s\"><i class=\"fa fa-twitter-square\" aria-hidden=\"true\"></i></a></li>",
					$value['additional2']
				);
				endif;

				if(!empty($value['additional3'])):
				$out .= sprintf(
					"<li style=\"display: inline-block\"><a href=\"%s\"><i class=\"fa fa-linkedin-square\" aria-hidden=\"true\"></i></a></li>",
					$value['additional3']
				);
				endif;
				
				
				$out .= "</ul>";
				// $out .= sprintf(
				// 	"<a href=\"%s%s/staff/%s/%s\" class=\"secondary button\">%s</a>", 
				// 	Config::WEBSITE,
				// 	strip_output::index($_SESSION['LANG']),
				// 	(int)$value['idx'],
				// 	strip_output::index($titleUrl),
				// 	$l->translate("readmore")
				// );
				$out .= "</div>";
				$out .= "</div>";

				// $out .= "<div class=\"author-block course-speaker\">";
				// $out .= sprintf(
				// 	"<a href=\"%s%s/staff/%s/%s\">",
				// 	Config::WEBSITE,
				// 	strip_output::index($_SESSION['LANG']),
				// 	(int)$value['idx'],
				// 	strip_output::index($titleUrl)
				// );
				// $out .= "<figure class=\"author-picture\">";
				// $out .= sprintf(
				// 	"<img src=\"%s\" alt=\"\" />",
				// 	$image
				// );
				// $out .= "</figure>";
				// $out .= "</a>";
				// $out .= "<article class=\"paragraph-wrapper glakho\">";
				// $out .= "<div class=\"inner\">";
				// $out .= sprintf(
				// 	"<header><a href=\"%s%s/staff/%s/%s\">%s</a></header>",
				// 	Config::WEBSITE,
				// 	strip_output::index($_SESSION['LANG']),
				// 	(int)$value['idx'],
				// 	strip_output::index($titleUrl), 
				// 	$title
				// );
				// $out .= sprintf("<figure>%s</figure>", $value['classname']);
				// $out .= sprintf("<p>%s</p>", $sting->cut($value['description'], 100));
				// $out .= sprintf(
				// 	"<a href=\"%s%s/staff/%s/%s\" class=\"btn btn-framed btn-small btn-color-grey\">%s</a>",
				// 	Config::WEBSITE,
				// 	strip_output::index($_SESSION['LANG']),
				// 	(int)$value['idx'],
				// 	strip_output::index($titleUrl),
				// 	$l->translate("viewprofile")
				// );
				// $out .= "</div>";
				
				// $out .= "</article>";
				// $out .= "</div>";
			}
		}		
		$return["html"] = $out;
		return $return; 
	}
}