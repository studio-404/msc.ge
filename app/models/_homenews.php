<?php 
class _homenews
{
	public $data;

	public function index()
	{
		require_once("app/functions/string.php");
		require_once("app/functions/l.php");
		$l = new functions\l();
		$sting = new functions\string();
		
		$out = "";

		if(count($this->data)){
			$month = array("ge"=>array("Jan"=>"იან", "Feb"=>"თებ", "Mar"=>"მარ", "Apr"=>"აპრ", "May"=>"მაი", "Jun"=>"ივნ", "Jul"=>"ივლ", "Aug"=>"აგვ", "Sep"=>"სექ", "Oct"=>"ოქტ", "Nov"=>"ნოე", "Dec"=>"დეკ"), "en"=>array("Jan"=>"Jan", "Feb"=>"Feb", "Mar"=>"Mar", "Apr"=>"Apr", "May"=>"May", "Jun"=>"Jun", "Jul"=>"Jul", "Aug"=>"Aug", "Sep"=>"Sep", "Oct"=>"Oct", "Nov"=>"Nov", "Dec"=>"Dec"));
			
			foreach($this->data as $item) {
				$photos = new Database("photos",array(
					"method"=>"selectByParent", 
					"idx"=>(int)$item['idx'],  
					"lang"=>strip_output::index($item['lang']),  
					"type"=>strip_output::index($item['type'])
				));
				if($photos->getter()){
					$pic = $photos->getter();
					$image = sprintf(
						"%s%s/image/loadimage?f=%s%s&w=360&h=220",
						Config::WEBSITE,
						strip_output::index($_SESSION['LANG']),
						Config::WEBSITE_,
						strip_output::index($pic[0]['path'])
					);
				}else{
					$image = "/public/filemanager/noimage.png";
				}


				$str = str_replace(date("M", (int)$item['date']), $month[strip_output::index($_SESSION['LANG'])][date("M", (int)$item['date'])], date("M d, Y", (int)$item['date']));
				$title = strip_tags($item['title']);
				$titleUrl = str_replace(array(" ", "'", '"'), "-", $title);

				$out .= "<div class=\"medium-4 small-12 columns\">";
				$out .= "<div class=\"post\">";
				$out .= "<div class=\"post-thumb\">";
				$out .= sprintf(
					"<a href=\"%s%s/%s/%s/%s\">",
					Config::WEBSITE,
					strip_output::index($_SESSION['LANG']),
					$item["type"],
					(int)$item['idx'],
					strip_output::index($titleUrl) 
				);
				$out .= sprintf(
					"<img src=\"%s\" alt=\"\" />", 
					$image
				);
				$out .= "</a>";
				$out .= "</div>";
				$out .= "<div class=\"post-content\">";
				$out .= sprintf(
					"<h4 style=\"min-height:80px\"><a href=\"%s%s/%s/%s/%s\">%s</a></h4>",
					Config::WEBSITE,
					strip_output::index($_SESSION['LANG']),
					$item["type"],
					(int)$item['idx'],
					strip_output::index($titleUrl),
					$sting->cut($title, 70)
				);
				$out .= "<div class=\"post-meta\">";
				$out .= sprintf(
					"<strong>%s:</strong> %s",
					$l->translate("date"), 
					$str
				);
				$out .= "</div>";
				$out .= sprintf(
					"<p>%s <a href=\"%s%s/%s/%s/%s\">%s &raquo;</a></p>",
					$sting->cut(strip_tags($item['description']), 160),
					Config::WEBSITE,
					strip_output::index($_SESSION['LANG']),
					$item["type"],
					(int)$item['idx'],
					strip_output::index($titleUrl),
					$l->translate("more")
				);
				$out .= "</div>";
				$out .= "</div>";
				$out .= "</div>";
				
			}

		}
		return $out;
	}
}