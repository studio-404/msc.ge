<?php 
class _homestaff
{
	public $data;

	public function index()
	{
		require_once("app/functions/string.php");
		require_once("app/functions/l.php");
		$l = new functions\l();
		$string = new functions\string();
		
		$out = "";

		if(count($this->data)){			
			foreach($this->data as $item) {
				$title = strip_tags($item['title']);
				$titleUrl = str_replace(array(" ", "'", '"'), "-", $title);

				$photos = new Database("photos",array(
					"method"=>"selectByParent", 
					"idx"=>(int)$item['idx'],  
					"lang"=>strip_output::index($_SESSION['LANG']),  
					"type"=>strip_output::index($item['type'])
				));
				if($photos->getter()){
					$pic = $photos->getter();
					$image = sprintf(
						"%s%s/image/loadimage?f=%s%s&w=220&h=220",
						Config::WEBSITE,
						strip_output::index($_SESSION['LANG']),
						Config::WEBSITE_,
						strip_output::index($pic[0]['path'])
					);
				}else{
					$image = "/public/filemanager/noimage.png";
				}

				$out .=  "<div class=\"medium-4 teacher\" style=\"padding:10px; float:left;\">";
				$out .=  "<div class=\"teacher-thumb\">";
				$out .=  sprintf(
					"<img src=\"%s\" alt=\"\" />",
					$image
				);

				$out .= "<div class=\"teacher-links menu-centered\">";
				$out .= "<ul class=\"menu\">";
				if(!empty($item['additional1']) && $item['additional1']!="empty"):
				$out .= sprintf(
					"<li><a href=\"%s\" target=\"_blank\"><i class=\"fa fa-facebook\"></i></a></li>",
					$item['additional1']
				);
				endif;
				if(!empty($item['additional1']) && $item['additional1']!="empty"):
				$out .= sprintf(
					"<li><a href=\"%s\" target=\"_blank\"><i class=\"fa fa-twitter\"></i></a></li>",
					$item['additional2']
				);
				endif;
				if(!empty($item['additional1']) && $item['additional1']!="empty"):
				$out .= sprintf(
					"<li><a href=\"%s\" target=\"_blank\"><i class=\"fa fa-linkedin\"></i></a></li>",
					$item['additional3']
				);
				endif;
				$out .= "</ul>";
				// $out .= sprintf(
				// 	"<a href=\"%s%s/staff/%s/%s\" class=\"small-button\">%s &raquo;</a>",
				// 	Config::WEBSITE,
				// 	strip_output::index($_SESSION['LANG']),
				// 	(int)$item['idx'],
				// 	strip_output::index($titleUrl),
				// 	$l->translate("more")
				// );
				$out .= "</div>";
				$out .= "</div>";
				$out .= "<div class=\"teacher-meta\">";
				$out .= sprintf(
					"<h3>%s</h3>",
					$string->cut($title, 70)
				);
				$out .= sprintf(
					"<p>%s</p>",
					$string->cut($item['classname'], 100)
				);
				$out .= "</div>";
				$out .= "</div>";

				
				
			}

		}
		return $out;
	}
}