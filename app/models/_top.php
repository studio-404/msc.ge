<?php 
class _top
{
	public  $data;

	public function index()
	{
		require_once("app/functions/l.php"); 
		require_once("app/functions/strip_output.php"); 
		require_once("app/functions/language_output_name.php"); 
		require_once("app/functions/request.php"); 

		$word = "";
		if(functions\request::index("GET","w")){
			$word = strip_tags(functions\request::index("GET","w"));
			$word = str_replace(
				array("-", "%20", "'", '"'),
				array(" ", " ", "", ""),
				$word
			); 
		}

		$language_output_name = new functions\language_output_name();
		$outputName = $language_output_name->index();

		$l = new functions\l();



		// $out = print_r($this->data['contactdetails'], true);
		$out = "\n";

		// Top bar start
		$out .= "<div class=\"topBar\">\n";
		$out .= "<div class=\"row\">\n";
		$out .= "<div class=\"large-6 medium-6 small-12 columns left-side\">\n";
		$out .= sprintf(
			"<p style=\"line-height: 35px;\"><span style=\"color:white\">გაქვთ კითხვები?</span> <i class=\"fa fa-phone\"></i> %s</p>\n",  
			strip_tags($this->data['contactdetails'][0]['description'])
		);
		$out .= "</div>\n";
		$out .= "<div class=\"large-6 medium-6 small-12 columns\">\n";
		$out .= "<ul class=\"menu text-right\">\n";
		$out .= sprintf(
			"<li><i class=\"fa fa-envelope\"></i> %s</li>\n",
			strip_tags($this->data['contactdetails'][1]['description'])
		);
		$out .= sprintf(
			"<li><i class=\"fa fa-clock-o\"></i> %s</li>\n",
			strip_tags($this->data['contactdetails'][2]['description'])
		);
		$x=1;
		foreach ($this->data['socialnetworks'] as $v):
			$out .= sprintf(
				"<li class=\"%ssocial\"><a href=\"%s\" target=\"_blank\"><i class=\"fa %s\"></i></a></li>\n",
				($x==1) ? 'first-social ' : '',
				$v['url'],
				$v['classname']
			);
			$x=2;
		endforeach;
		
		/* Language manipulation */
		$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		if(isset($_SESSION["LANG"]) && $_SESSION["LANG"]=="en"){
			$changeLanguage = str_replace("/en/", "/ge/", $actual_link, $count);
			if($count <= 0){
				$changeLanguage = Config::WEBSITE."ge";
			}
			$laName = "GE";
		}else{			
			$changeLanguage = str_replace("/ge/", "/en/", $actual_link, $count);
			if($count <= 0){
				$changeLanguage = Config::WEBSITE."en";
			}
			$laName = "EN";
		}

		$out .= sprintf(
			"<li><a href=\"%s\">%s</a></li>",
			$changeLanguage,
			$laName
		);

		$out .= "</ul>\n";
		$out .= "</div>\n";
		$out .= "</div>\n";
		$out .= "</div>\n";
		// Top bar end

		// Header start
		$out .= "<div class=\"header\">\n";
		$out .= "<div class=\"row\">\n";
		$out .= "<div class=\"medium-4 small-12 columns\">\n";
		$out .= "<div class=\"logo\">\n";
		$out .= sprintf("<a href=\"/%s/home\">\n", $_SESSION["LANG"]);
		$out .= sprintf(
			"<img src=\"%simg/logo.svg\" alt=\"\" />\n",
			Config::PUBLIC_FOLDER
		);
		$out .= "</a>\n";
		$out .= "</div>\n";
		$out .= "</div>\n";

		$out .= "<div class=\"medium-8 small-12 columns nav-wrap\">\n";
		$out .= "<div class=\"top-bar\">\n";
		$out .= "<div class=\"top-bar-title\">\n";
		$out .= "<span data-responsive-toggle=\"responsive-menu\" data-hide-for=\"medium\">\n";
		$out .= "<a data-toggle><span class=\"menu-icon dark float-left\"></span></a>\n";
		$out .= "</span>\n";
		$out .= "</div>\n";

		$out .= $this->data['navigationModule'];
		$out .= "</div>\n";

		$out .= "<div class=\"search-wrap float-right\">\n";
		$out .= " <a href=\"#\" class=\"search-icon-toggle\" data-toggle=\"search-dropdown\"><i class=\"fa fa-search\"></i></a>\n";
		$out .= "</div>";

		$out .= "<div class=\"dropdown-pane\" id=\"search-dropdown\" data-dropdown data-auto-focus=\"true\">";
		$out .= sprintf(
			"<input type=\"hidden\" class=\"lang\" value=\"%s\" />
			<input type=\"text\" class=\"mainsearch\" placeholder=\"%s\" />",
			$_SESSION["LANG"],
			$l->translate("searchword")
		);
		$out .= "</div>";
		$out .= "</div>";

		$out .= "</div>";
		$out .= "</div>";

		// Header Ends
		
		return $out;
	}
}