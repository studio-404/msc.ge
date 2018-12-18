<?php 
class _gallery
{
	public $data; 

	public function index()
	{
		require_once("app/functions/string.php"); 
		require_once("app/functions/l.php"); 
		require_once("app/functions/strip_output.php");
		
		$l = new functions\l(); 
		$sting = new functions\string();
		$out = "<ul class=\"gallery-list\">";

		foreach($this->data as $item) {
			$title = strip_tags($item['title']);

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
				$bigimage = sprintf(
                    "%s%s/image/loadimage?f=%s%s&w=100&h=100&full=true",
                    Config::WEBSITE,
                    strip_output::index($_SESSION['LANG']),
                    Config::WEBSITE_,
                    strip_output::index($pic[0]['path'])
                );
			}else{
				$image = "/public/filemanager/noimage.png";
				$bigimage = "/public/filemanager/noimage.png";
			}

			if($item["url"]=="empty" || $item["url"]==""){
				$out .= "<li>";
                $out .= sprintf(
                	"<a href=\"%s\" class=\"image-popup\" title=\"%s\">",
                	$bigimage,
                	htmlentities($item['title'])
                );
                $out .= sprintf(
                	"<img src=\"%s\" alt=\"\" />", 
                	$image
                );
                $out .= "</a>";
                $out .= "</li>";
			}else{
				$embedUrl = $this->youtube($item["url"]);
				$out .= "<li>";
                $out .= sprintf(
                	"<a href=\"%s\" class=\"video-popup\" title=\"%s\">",
                	$embedUrl["link"],
                	htmlentities($item['title'])
                );
                if($image != "/public/filemanager/noimage.png"){
                	$out .= sprintf(
	                	"<img src=\"%s\" alt=\"\" />",
	                	$image
	                );
                }else{
                	$out .= sprintf(
	                	"<img src=\"%s\" alt=\"\" />",
	                	$embedUrl["image"]
	                );
                }
                
                $out .= "</a>";
                $out .= "</li>";
			}
		}
		$out .= "</ul>";
		return $out; 
	}


	private function youtube($url)
	{
		$youtube_id = "";
		$shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_]+)\??/i';
        $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))(.*)/i';

        if (preg_match($longUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }

        if (preg_match($shortUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }
        $embed["link"] = 'https://www.youtube.com/embed/' . $youtube_id;
        $embed["image"] = 'https://img.youtube.com/vi/'.$youtube_id.'/0.jpg';
        return $embed;
	}

}