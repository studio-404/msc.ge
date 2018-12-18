<?php
class Home extends Controller
{
	public function __construct()
	{
		
	}

	public function index($name = '')
	{ 
		/* DATABASE */
		$db_langs = new Database("language", array(
			"method"=>"select"
		)); /* # */
		
		$db_contactdetails = new Database("modules", array(
			"method"=>"selectModuleByType", 
			"type"=>"contactdata"
		)); /* # */


		$db_slider = new Database("modules", array(
			"method"=>"selectModuleByType", 
			"type"=>"slider",
			"order"=>"`date`",
			"by"=>"DESC",
			"from"=>0, 
			"num"=>15
		));

		$db_usefulllinks = new Database("modules", array(
			"method"=>"selectModuleByType", 
			"type"=>"usefulllinks",
			"order"=>"`date`",
			"by"=>"DESC"
		));

		$db_navigation = new Database("page", array(
			"method"=>"select", 
			"cid"=>0, 
			"nav_type"=>0,
			"lang"=>$_SESSION['LANG'],
			"status"=>0 
		));

		$db_footerHelpNav = new Database("page", array(
			"method"=>"selecteByCid", 
			"cid"=>7, 
			"lang"=>$_SESSION['LANG']
		));

		$db_slogan = new Database("modules", array(
			"method"=>"selectById", 
			"idx"=>7,
			"lang"=>$_SESSION["LANG"]
		));

		$s = (isset($_SESSION["URL"][1])) ? $_SESSION["URL"][1] : Config::MAIN_CLASS;
		$db_pagedata = new Database("page", array(
			"method"=>"selecteBySlug", 
			"slug"=>$s,
			"lang"=>$_SESSION['LANG'], 
			"all"=>true
		));

		$db_socialnetworks = new Database("modules", array(
			"method"=>"selectModuleByType", 
			"type"=>"socialnetworks",
			"order"=>"`date`",
			"by"=>"DESC"
		));

		$db_news = new Database("modules", array(
			"method"=>"selectModuleByType", 
			"type"=>"news",
			"order"=>"`date`",
			"by"=>"DESC",
			"from"=>0,
			"num"=>Config::HOME_PAGE_NEWS_NUM
		));

		$db_footer_news = new Database("modules", array(
			"method"=>"selectModuleByType", 
			"type"=>"news",
			"order"=>"`date`",
			"by"=>"DESC",
			"from"=>0,
			"num"=>Config::FOOTER_NEWS_NUM
		));

		$db_footer_usefull_links = new Database("modules", array(
			"method"=>"selectModuleByType", 
			"type"=>"usefulllink",
			"order"=>"`date`",
			"by"=>"DESC",
			"from"=>0,
			"num"=>Config::FOOTER_USEFULL_LINKS_NUM
		));

		$db_footer_working_hours = new Database("modules", array(
			"method"=>"selectModuleByType", 
			"type"=>"workinghours",
			"order"=>"`date`",
			"by"=>"DESC",
			"from"=>0,
			"num"=>Config::FOOTER_WORKING_HOURS_NUM
		));

		$db_staff = new Database("modules", array(
			"method"=>"selectModuleByType", 
			"type"=>"staff",
			"order"=>"`date`",
			"by"=>"DESC",
			"from"=>0,
			"num"=>Config::HOME_PAGE_STAFF_NUM
		));

		$db_partners = new Database("modules", array(
			"method"=>"selectModuleByType", 
			"type"=>"partners",
			"order"=>"`date`",
			"by"=>"DESC",
			"from"=>0,
			"num"=>Config::HOME_PAGE_PARTNERS_NUM
		));

		$db_gallery = new Database("modules", array(
			"method"=>"selectModuleByType", 
			"type"=>"gallery",
			"order"=>"`date`",
			"by"=>"DESC",
			"from"=>0,
			"num"=>Config::HOME_PAGE_GALLERY_NUM
		));

		/* gallery module */
		$gallery = $this->model('_gallery');
		$gallery->data = $db_gallery->getter();
		

		/* HEDARE */
		$header = $this->model('_header');
		$header->public = Config::PUBLIC_FOLDER; 
		$header->lang = $_SESSION["LANG"]; 
		$header->pagedata = $db_pagedata; 

		/* NAVIGATION */
		$navigation = $this->model('_navigation');
		$navigation->data = $db_navigation->getter();

		/* NAVIGATION Footer */
		$navigation_footer = $this->model('_navigation');
		$navigation_footer->data = $db_navigation->getter();
		$navigation_footer->footerNavigation = true;

		/* Home page news */
		$news = $this->model('_homenews');
		$news->data = $db_news->getter();

		/* Home page staff */
		$staff = $this->model('_homestaff');
		$staff->data = $db_staff->getter();

		/* slidr */
		$slider = $this->model('_slider');
		$slider->data = $db_slider->getter(); 

		/* header top */
		$headertop = $this->model('_top');
		$headertop->data["contactdetails"] = $db_contactdetails->getter();
		$headertop->data["socialnetworks"] = $db_socialnetworks->getter();
		$headertop->data["navigationModule"] = $navigation->index();

		/*footer */
		$footer = $this->model('_footer');
		$footer_top = $this->model('_footer_top');
		$footer_top->data["contactdetails"] = $db_contactdetails->getter(); /* # */
		$footer_top->data["socialnetworks"] = $db_socialnetworks->getter(); /* # */
		$footer_top->data["footer_navigation"] = $navigation_footer->index(); /* # */
		$footer_top->data["footer_news"] = $db_footer_news->getter(); /* # */
		$footer_top->data["footer_usefull"] = $db_footer_usefull_links->getter(); /* # */
		$footer_top->data["footer_working_hour"] = $db_footer_working_hours->getter(); /* # */





		/* view */
		$this->view('home/index', [
			"header"=>array(
				"website"=>Config::WEBSITE,
				"public"=>Config::PUBLIC_FOLDER
			),
			"headerModule"=>$header->index(), 
			"headertop"=>$headertop->index(), 
			"pageData"=>$db_pagedata->getter(), 
			"slogan"=>$db_slogan->getter(), 
			"news"=>$news->index(), 
			"staff"=>$staff->index(), 
			"gallery"=>$gallery->index(), 
			"slider"=>$slider->index(), 
			"partners"=>$db_partners->getter(), 
			"footer"=>$footer->index(), 
			"footer_top"=>$footer_top->index(), 
		]);
	}

}