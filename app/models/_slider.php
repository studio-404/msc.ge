<?php 
class _slider
{
	public $data;

	public function index()
	{
		require_once("app/functions/strip_output.php"); 
		require_once("app/functions/l.php");
		$l = new functions\l();

		$out = array();
		$out["list"] = "";
		$out["printr"] = print_r($this->data, true);
		$out["count"] = 0;
		
		$out["count"] = count($this->data);

		if($out["count"])
		{
			$out["list"] .= "<div id=\"rev_slider_4_1_wrapper\" class=\"rev_slider_wrapper fullwidthbanner-container\" data-alias=\"classicslider1\">";
			$out["list"] .= "<div id=\"rev_slider_4_1\" class=\"rev_slider fullwidthabanner\" data-version=\"5.0.7\">";
			$out["list"] .= "<ul>";


			foreach($this->data as $value):
				$photos = new Database("photos",array(
					"method"=>"selectByParent", 
					"idx"=>(int)$value['idx'],  
					"lang"=>strip_output::index($value['lang']),  
					"type"=>strip_output::index($value['type'])
				));
				if($photos->getter()){
					$pic = $photos->getter();
					$image = strip_output::index($pic[0]['path']);
				}else{
					$image = "/public/filemanager/noimage.png";
				}

			$out["list"] .= sprintf(
				"<li data-index=\"rs-%s\">",
				$value['idx']
			);
			$out["list"] .= sprintf(
				"<img src=\"%s\"  alt=\"First Slide\"  data-bgposition=\"center center\" data-bgfit=\"cover\" data-bgrepeat=\"no-repeat\" data-bgparallax=\"10\" class=\"rev-slidebg\" />", 
				$image
			);

			$out["list"] .= "<div class=\"tp-caption tp-shape tp-shapewrapper layer1 tp-resizeme rs-parallaxlevel-0\" 
                                 id=\"slide-16-layer-3\" 
                                 data-x=\"['center','center','center','center']\" data-hoffset=\"['0','0','0','0']\" 
                                 data-y=\"['middle','middle','middle','middle']\" data-voffset=\"['0','0','0','0']\" 
                                            data-width=\"full\"
                                data-height=\"full\"
                                data-whitespace=\"normal\"
                                data-transform_idle=\"o:1;\"
                     
                                 data-transform_in=\"opacity:0;s:1500;e:Power3.easeInOut;\" 
                                 data-transform_out=\"s:300;s:300;\" 
                                data-start=\"1000\" 
                                data-basealign=\"slide\" 
                                data-responsive_offset=\"on\"> 
                            </div>
";

			$out["list"] .= "<div class=\"tp-caption Newspaper-Title-Centered layer2 tp-resizeme rs-parallaxlevel-0\"  
				data-x=\"['center','center','center','center']\" 
				data-hoffset=\"['0','0','0','0']\"
				data-y=\"['middle','middle','middle','middle']\" 
				data-voffset=\"['0','0','0','1']\" 
				data-fontsize=\"['50','50','50','30']\"
				data-lineheight=\"['55','55','55','35']\"
				data-width=\"['721','721','721','420']\"
				data-height=\"none\"
				data-whitespace=\"normal\"
				data-transform_idle=\"o:1;\"                     
				data-transform_in=\"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;\" 
				data-transform_out=\"auto:auto;s:1000;\" 
				data-mask_in=\"x:0px;y:0px;\" 
				data-mask_out=\"x:0;y:0;\" 
				data-start=\"1000\" 
				data-splitin=\"none\" 
				data-splitout=\"none\" 
				data-responsive_offset=\"on\">".strip_tags($value['description'])."
				</div>";

            $out["list"] .= "<div class=\"tp-caption Newspaper-Subtitle layer3 tp-resizeme rs-parallaxlevel-0\" 
				data-x=\"['center','center','center','center']\" 
				data-hoffset=\"['0','0','0','0']\" 
				data-y=\"['middle','middle','middle','middle']\" 
				data-voffset=\"['-82','-82','-82','-58']\" 
				data-width=\"none\"
				data-height=\"none\"
				data-whitespace=\"nowrap\"
				data-transform_idle=\"o:1;\" 
				data-transform_in=\"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;\" 
				data-transform_out=\"auto:auto;s:1000;\" 
				data-mask_in=\"x:0px;y:0px;\" 
				data-mask_out=\"x:0;y:0;\" 
				data-start=\"1000\" 
				data-splitin=\"none\" 
				data-splitout=\"none\" 
				data-responsive_offset=\"on\">".strip_tags($value['title'])."
				</div>";

			$out["list"] .= "<div class=\"tp-caption layer4 rs-parallaxlevel-0 g-slider-button\" 
			data-x=\"['center','center','center','center']\" 
			data-hoffset=\"['0','0','0','0']\" 
			data-y=\"['middle','middle','middle','middle']\" 
			data-voffset=\"['92','92','92','76']\" 
			data-width=\"none\"
			data-height=\"none\"
			data-whitespace=\"nowrap\"
			data-transform_idle=\"o:1;\"
			data-transform_hover=\"o:1;rX:0;rY:0;rZ:0;z:0;s:300;e:Power1.easeInOut;\"
			data-style_hover=\"c:rgba(0, 0, 0, 1.00);bg:rgba(255, 255, 255, 1.00);bc:rgba(255, 255, 255, 1.00);cursor:pointer;\"
			data-transform_in=\"y:50px;opacity:0;s:1500;e:Power4.easeInOut;\" 
			data-transform_out=\"y:50px;opacity:0;s:1000;s:1000;\" 
			data-start=\"1000\" 
			data-splitin=\"none\" 
			data-splitout=\"none\" 
			data-responsive_offset=\"on\" 
			data-responsive=\"off\"><a href=\"".strip_tags($value['url'])."\" class=\"button primary bordered-light\" target=\"".strip_tags($value['classname'])."\">".$l->translate("more")."</a> 
			</div>";

			$out["list"] .= "</li>";
			endforeach;


			$out["list"] .= "</ul>";
			$out["list"] .= "<div class=\"tp-static-layers\"></div>";
			$out["list"] .= "<div class=\"tp-bannertimer\"></div> ";
			$out["list"] .= "</div>";
			$out["list"] .= "</div>";
		}
		
		return $out;
	}
}