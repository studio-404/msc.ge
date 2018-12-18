<?php 
class _header
{
	public $public;
	public $lang;
	public $pagedata;
	public $imageSrc;
	public $product;

	public function index(){ 

		$getter = $this->pagedata->getter(); 

		if(isset($getter['title'])){
			$title = strip_tags($getter['title']);
			$description = strip_tags($getter['description']);
		}else if(isset($getter[0]['title'])){
			$title = strip_tags($getter[0]['title']); 
			$description = strip_tags($getter[0]['description']);
		}else{
			$title = "";
			$description = "";
		}

		if(isset($this->product)){
			$title = strip_tags($this->product['title']);
			$description = strip_tags($this->product['short_description']);
		}

		$out = "<!DOCTYPE html>\n";
		$out .= "<html>\n";
		$out .= "<head>\n";
		/* google analitics start */
		// $out .= "<!-- Global site tag (gtag.js) - Google Analytics -->
		// <script async src=\"https://www.googletagmanager.com/gtag/js?id=UA-117764606-1\"></script>
		// <script>
		// window.dataLayer = window.dataLayer || [];
		// function gtag(){dataLayer.push(arguments);}
		// gtag('js', new Date());

		// gtag('config', 'UA-117764606-1');
		// </script>\n";
		/* google analitics end */
		
		/* fb plugin start */
		// $out .= "<div id=\"fb-root\"></div>
		// <script>(function(d, s, id) {
		// var js, fjs = d.getElementsByTagName(s)[0];
		// if (d.getElementById(id)) return;
		// js = d.createElement(s); js.id = id;
		// js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12&appId=1388834851138933&autoLogAppEvents=1';
		// fjs.parentNode.insertBefore(js, fjs);
		// }(document, 'script', 'facebook-jssdk'));</script>\n";
		/* fb plugin end */

		$out .= sprintf(
			"<base url=\"%s\" />\n",
			Config::WEBSITE
		);
		$out .= "<meta charset=\"utf-8\">\n";
		$out .= "<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n";
				
		$out .= "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no\" />\n";
		$out .= "<meta name=\"format-detection\" content=\"telephone=no\"/>\n";
		$out .= sprintf("<title>%s - Vip Intellect Group</title>\n", strip_tags($title));
		
		$actual_link = "http://".$_SERVER["HTTP_HOST"].htmlentities($_SERVER["REQUEST_URI"]);
		$out .= "<meta property=\"fb:app_id\" content=\"719286371756996\" />\n";
		$out .= "<meta property=\"og:title\" content=\"".strip_tags($title)."\" />\n";
		$out .= "<meta property=\"og:type\" content=\"website\" />\n";
		$out .= "<meta property=\"og:url\" content=\"".$actual_link."\"/>\n";
		$keywords = str_replace(" ", ",", strip_tags($description));
		$out .= sprintf(
			"<meta name=\"keywords\" content=\"%s\" />\n", 
			htmlentities($keywords)
		);
		
		if(isset($this->imageSrc)){
			$image = $this->imageSrc;
		}else{
			$image = $this->public."img/share2.jpg";
		}
		$out .= sprintf(
			"<meta property=\"og:image\" content=\"%s\" />\n", 
			$image
		);
		$out .= sprintf(
			"<link rel=\"image_src\" type=\"image/jpeg\" href=\"%s\" />\n", 
			$image
		);


		$out .= "<meta property=\"og:image:width\" content=\"600\" />\n";
		$out .= "<meta property=\"og:image:height\" content=\"315\" />\n";
		$out .= "<meta property=\"og:site_name\" content=\"Vip Intellect Group\" />\n";
		$out .= "<meta property=\"og:description\" content=\"".htmlentities($description)."\"/>\n";


		$out .= sprintf(
			"<link rel=\"icon\" type=\"image/ico\" href=\"%simg/favicon.png?v=%s\" />\n", 
			$this->public,
			Config::WEBSITE_VERSION
		);
		
		

		$out .= sprintf(
			"<link href=\"%scss/web/animate.css?v=%s\" rel=\"stylesheet\" type=\"text/css\">\n", 
			$this->public,
			Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<link href=\"%scss/web/foundation.min.css?v=%s\" rel=\"stylesheet\" type=\"text/css\">\n", 
			$this->public,
			Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<link href=\"%scss/web/font-awesome.min.css?v=%s\" rel=\"stylesheet\" type=\"text/css\">\n", 
			$this->public,
			Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<link href=\"%scss/web/owl.carousel.css?v=%s\" rel=\"stylesheet\" type=\"text/css\">\n", 
			$this->public,
			Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<link href=\"%scss/web/lightbox.min.css?v=%s\" rel=\"stylesheet\" type=\"text/css\">\n", 
			$this->public,
			Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<link href=\"%scss/web/style.css?v=%s\" rel=\"stylesheet\" type=\"text/css\">\n", 
			$this->public,
			Config::WEBSITE_VERSION
		);

		$out .= "<link href=\"https://fonts.googleapis.com/css?family=Lato:400,700%7CMontserrat:400,700%7CRoboto+Slab:400%7CRoboto:900,700\" rel=\"stylesheet\" type=\"text/css\" />\n";

		$out .= sprintf(
			"<link href=\"%slib/revolution/css/settings.css?v=%s\" rel=\"stylesheet\" type=\"text/css\">\n", 
			$this->public,
			Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<link href=\"%slib/revolution/css/layers.css?v=%s\" rel=\"stylesheet\" type=\"text/css\">\n", 
			$this->public,
			Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<link href=\"%slib/revolution/css/navigation.css?v=%s\" rel=\"stylesheet\" type=\"text/css\">\n", 
			$this->public,
			Config::WEBSITE_VERSION
		);

		

		if(isset($_SESSION['LANG']) && $_SESSION['LANG']=="ge"){
			$out .= sprintf(
				"<link rel=\"stylesheet\" type=\"text/css\" href=\"%scss/web/ge.css?v=%s\" />\n", 
				$this->public,
				Config::WEBSITE_VERSION
			);   
		}

		$out .= "</head>\n";
		$out .= "<body>\n";

		$out .= "<div id=\"fb-root\"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/ka_GE/sdk.js#xfbml=1&autoLogAppEvents=1&version=v3.1&appId=719286371756996';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>";

		$out .= "<div id=\"loading\">\n";
		$out .= "<div id=\"loading-center\">\n";
		$out .= "<div id=\"loading-center-absolute\">\n";
		$out .= "<div id=\"object\"></div>\n";
		$out .= "</div>\n";
		$out .= "</div>\n";
		$out .= "</div>\n";
		
		
		return $out;
	}
}