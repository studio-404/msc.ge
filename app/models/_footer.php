<?php 
class _footer
{
	public $data;

	public function index()
	{
		//contactdetails
		require_once("app/functions/l.php");
		require_once("app/functions/strip_output.php");  
		require_once("app/functions/string.php");
		require_once("app/functions/request.php"); 

		$l = new functions\l(); 	

		$out = "<a href=\"#top\" id=\"top\" class=\"animated fadeInUp start-anim\"><i class=\"fa fa-angle-up\"></i></a>";
			

		$out .= sprintf(
			"<script src=\"%sjs/web/jquery.js?v=%s\" type=\"text/javascript\"></script>\n", 
			Config::PUBLIC_FOLDER,
			Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<script src=\"%sjs/web/script.js?v=%s\" type=\"text/javascript\"></script>\n", 
			Config::PUBLIC_FOLDER,
			Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<script src=\"%sjs/web/foundation.min.js?v=%s\" type=\"text/javascript\"></script>\n", 
			Config::PUBLIC_FOLDER,
			Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<script src=\"%sjs/web/owl.carousel.min.js?v=%s\" type=\"text/javascript\"></script>\n", 
			Config::PUBLIC_FOLDER,
			Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<script src=\"%sjs/web/webful.js?v=%s\" type=\"text/javascript\"></script>\n", 
			Config::PUBLIC_FOLDER,
			Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<script src=\"%sjs/web/lightbox.min.js?v=%s\" type=\"text/javascript\"></script>\n", 
			Config::PUBLIC_FOLDER,
			Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<script src=\"%slib/revolution/js/jquery.themepunch.tools.min.js?v=%s\" type=\"text/javascript\"></script>\n",
			 Config::PUBLIC_FOLDER,
			 Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<script src=\"%slib/revolution/js/jquery.themepunch.revolution.min.js?v=%s\" type=\"text/javascript\"></script>\n",
			 Config::PUBLIC_FOLDER,
			 Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<script src=\"%slib/revolution/js/extensions/revolution.extension.actions.min.js?v=%s\" type=\"text/javascript\"></script>\n",
			 Config::PUBLIC_FOLDER,
			 Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<script src=\"%slib/revolution/js/extensions/revolution.extension.carousel.min.js?v=%s\" type=\"text/javascript\"></script>\n",
			 Config::PUBLIC_FOLDER,
			 Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<script src=\"%slib/revolution/js/extensions/revolution.extension.kenburn.min.js?v=%s\" type=\"text/javascript\"></script>\n",
			 Config::PUBLIC_FOLDER,
			 Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<script src=\"%slib/revolution/js/extensions/revolution.extension.layeranimation.min.js?v=%s\" type=\"text/javascript\"></script>\n",
			 Config::PUBLIC_FOLDER,
			 Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<script src=\"%slib/revolution/js/extensions/revolution.extension.migration.min.js?v=%s\" type=\"text/javascript\"></script>\n",
			 Config::PUBLIC_FOLDER,
			 Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<script src=\"%slib/revolution/js/extensions/revolution.extension.navigation.min.js?v=%s\" type=\"text/javascript\"></script>\n",
			 Config::PUBLIC_FOLDER,
			 Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<script src=\"%slib/revolution/js/extensions/revolution.extension.parallax.min.js?v=%s\" type=\"text/javascript\"></script>\n",
			 Config::PUBLIC_FOLDER,
			 Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<script src=\"%slib/revolution/js/extensions/revolution.extension.slideanims.min.js?v=%s\" type=\"text/javascript\"></script>\n",
			 Config::PUBLIC_FOLDER,
			 Config::WEBSITE_VERSION
		);

		$out .= sprintf(
			"<script src=\"%slib/revolution/js/extensions/revolution.extension.video.min.js?v=%s\" type=\"text/javascript\"></script>\n",
			 Config::PUBLIC_FOLDER,
			 Config::WEBSITE_VERSION
		);



		return $out;
	}
}