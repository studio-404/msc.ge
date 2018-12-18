<?php 
class _footer_top
{
	public $data;

	public function index()
	{
		require_once("app/functions/l.php");
		require_once("app/functions/strip_output.php");  
		require_once("app/functions/string.php");
		require_once("app/functions/request.php"); 

        $l = new functions\l();     
		$string = new functions\string(); 	

		$out = "<div class=\"call-to-action\">\n";
		$out .= "<div class=\"row\">\n";
		$out .= "<div class=\"medium-10 small-12 columns\">\n";
		$out .= sprintf(
			"<h2><i class=\"fa fa-phone\" aria-hidden=\"true\"></i>  %s <span>%s</span></h2>\n", 
            $l->translate("haveaquestio"), 
			strip_tags($this->data['contactdetails'][0]["description"])
		);
		$out .= "</div>\n";
		$out .= "<div class=\"medium-2 small-12 columns\">\n";
		$out .= sprintf(
            "<a href=\"#\" class=\"button secondary\">%s</a>\n",
            $l->translate("apointment")
        );
		$out .= "</div>\n";
		$out .= "</div>\n";
        $out .= "</div>\n";

        $out .= "<div class=\"footer\">\n";
        $out .= "<div class=\"footerTop\">\n";
        $out .= "<div class=\"row\">\n";

        $out .= "<div class=\"large-3 medium-3 small-12 columns footer-widget\">\n";
		$out .= sprintf("<h2>%s</h2>\n", $l->translate("lastnews"));
        $out .= "<div class=\"tx-div\"></div>\n";
        $out .= "<ul  class=\"menu vertical\">\n";

        if(count($this->data["footer_news"])){
            foreach ($this->data["footer_news"] as $v) {
                $titleUrl = str_replace(array(" ", "'", '"'), "-", $v['title']);
                $out .= sprintf(
                    "<li><a href=\"%s%s/%s/%s/%s\">%s</a></li>\n",
                    Config::WEBSITE,
                    $_SESSION['LANG'],
                    $v["type"],
                    (int)$v['idx'],
                    strip_output::index($titleUrl),
                    $string->cut($v['title'], 70)
                );
            }            
        }
        $out .= "</ul>\n";
        $out .= "</div>\n";


        $out .= "<div class=\"large-3 medium-3 small-12 columns footer-widget\">\n";
		$out .= sprintf("<h2>%s</h2>\n", $l->translate("usefulllinks"));
        $out .= "<div class=\"tx-div\"></div>\n";
        
        if(count($this->data["footer_usefull"])){
            $out .= "<ul  class=\"menu vertical\">\n";            
            foreach ($this->data["footer_usefull"] as $v):
            $out .= sprintf(
                "<li style=\"display:block\"><a href=\"%s\">%s</a></li>\n",
                $v["url"],
                $v["title"]
            );
            endforeach;
            $out .= "</ul>\n";           
        }
        
        $out .= "</div>\n";
    

        $out .= "<div class=\"large-3 medium-3 small-12 columns footer-widget\">\n";
        $out .= sprintf("<h2>%s</h2>\n", $l->translate("workinghours"));
        $out .= "<div class=\"tx-div\"></div>\n";
       
        if(count($this->data["footer_working_hour"])){
            $out .= "<ul  class=\"menu vertical\">\n";            
            foreach ($this->data["footer_working_hour"] as $v):
            $out .= sprintf(
                "<li style=\"display:block\"><a href=\"#\">%s: %s</a></li>\n",
                $v["title"],
                $v["classname"]
            );
            endforeach;
            $out .= "</ul>\n";           
        }

        $out .= "</div>\n";

        $out .= "<div class=\"large-3 medium-3 small-12 columns footer-widget\">\n";
        $out .= "<div class=\"textwidget\">\n";
        $out .= "<ul  class=\"address\">\n";
       
        $out .= "<li>\n";
        $out .= "<i class=\"fa fa-home\"></i>\n";
        $out .= sprintf("<h4>%s:</h4>\n", $l->translate("address"));
        $out .= sprintf(
            "<p>%s</p>\n",
            strip_tags($this->data['contactdetails'][3]["description"])
        );
        $out .= "</li>\n";

        $out .= "<li>\n";
        $out .= "<i class=\"fa fa-mobile\"></i>\n";
        $out .= sprintf(
            "<h4>%s:</h4>\n",
            $l->translate("contactinfo")
        );
        $out .= sprintf(
            "<p>%s</p>\n", 
            strip_tags($this->data['contactdetails'][0]["description"])
        );
        $out .= "</li>\n";

        $out .= "<li>\n";
        $out .= "<i class=\"fa fa-envelope\"></i>\n";
        $out .= sprintf(
            "<h4>%s:</h4>\n", 
            $l->translate("email")
        );
        $out .= sprintf(
            "<p>%s</p>\n",
            strip_tags($this->data['contactdetails'][1]["description"])
        );
        $out .= "</li>\n";

        $out .= "</ul>\n";
        $out .= "<hr>\n";
        $out .= "<div class=\"socialicons\">\n";
        // $out .= print_r($this->data['socialnetworks'], true); 
        foreach ($this->data['socialnetworks'] as $v):
            $out .= sprintf(
                "<a href=\"%s\" target=\"_blank\"><i class=\"fa %s\"></i></a>\n",
                $v['url'], 
                $v['classname'] 
            );
        endforeach;
        $out .= "</div>\n";
        $out .= "</div>\n";
        $out .= "</div>\n";
        $out .= "<div class=\"clearfix\"></div>\n";
        $out .= "</div><!-- Row Ends /-->\n";
        $out .= "</div><!-- footerTop Ends here.. -->\n";

        $out .= "<div class=\"footerbottom\">\n";
        $out .= "<div class=\"row\">\n";
        $out .= "<div class=\"medium-6 small-12 columns\">\n";
        $out .= "<div class=\"copyrightinfo\">2018 &copy; <a href=\"#\">მარნეულის საზოგადოებრივი კოლეჯი</div>\n";
        $out .= "</div><!-- left side /-->\n";
        $out .= "<div class=\"medium-6 small-12 columns hide-for-small-only\">\n";
        $out .= "<div class=\"pull-right\">\n";
        // $out .= "<ul class=\"menu\">\n";
        // $out .= "<li><a href=\"\">მთავარი</a></li>\n";
        // $out .= "<li><a href=\"\">მთავარი</a></li>\n";
        // $out .= "<li><a href=\"\">მთავარი</a></li>\n";
        // $out .= "</ul>\n";
        $out .= $this->data['footer_navigation'];
        $out .= "</div>\n";
        $out .= "</div>\n";
        $out .= "</div>\n";
        $out .= "</div>\n";

        $out .= "<div style=\"padding:0 0 20px 0; text-align:center; background:#2f2f2f\">\n";
        $out .= sprintf(
            "<!-- TOP.GE ASYNC COUNTER CODE -->
            <div id=\"top-ge-counter-container\" data-site-id=\"111650\"></div>
            <script async src=\"//counter.top.ge/counter.js\"></script>
            <!-- / END OF TOP.GE COUNTER CODE -->\n"
        );
        $out .= "</div>\n";

        $out .= "</div>\n";
        $out .= "</div>\n";
        $out .= "</div>\n";

		return $out;
	
	}
}