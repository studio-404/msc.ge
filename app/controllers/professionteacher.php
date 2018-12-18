<?php 
class Professionteacher extends Controller
{
	public $staffslug;
	public function __construct()
	{
		
	}

	public function index($lang = '', $staffid = '')
	{ 
		$this->staffslug = $_SESSION["URL"][1];
		/* DATABASE */
		$db_langs = new Database("language", array(
			"method"=>"select"
		)); /* # */
		
		$db_contactdetails = new Database("modules", array(
			"method"=>"selectModuleByType", 
			"type"=>"contactdata"
		)); /* # */


		$db_navigation = new Database("page", array(
			"method"=>"select", 
			"cid"=>0, 
			"nav_type"=>0,
			"lang"=>$_SESSION['LANG'],
			"status"=>0 
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

		$pageDatax = $db_pagedata->getter();
		
		$db_dub_navigation = new Database("page", array(
			"method"=>"select", 
			"cid"=>$pageDatax['idx'], 
			"nav_type"=>0,
			"lang"=>$_SESSION['LANG'],
			"status"=>0 
		));
		

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


		$header->pagedata = $db_pagedata; 
		$fromstaff = (isset($_GET['pn']) && is_numeric($_GET['pn']) && $_GET['pn']>0) ? ($_GET['pn']-1)*Config::STAFF_PER_PAGE : 0;
		$db_staff = new Database("modules", array(
			"method"=>"selectModuleByType", 
			"type"=>"professionteacher",
			"from"=>$fromstaff,
			"order"=>"`date`",
			"by"=>"DESC",
			"num"=>Config::STAFF_PER_PAGE
		));

		/* Staff */
		$staff = $this->model('_homestaff');
		$staff->data = $db_staff->getter();

		/* view */
		$this->view('professionteacher/index', [
			"header"=>array(
				"website"=>Config::WEBSITE,
				"public"=>Config::PUBLIC_FOLDER
			),
			"headerModule"=>$header->index(), 
			"pageData"=>$db_pagedata->getter(), 
			"staff"=>$staff->index(), 
			"headertop"=>$headertop->index(), 
			"footer"=>$footer->index(),
			"slogan"=>$db_slogan->getter(), 
			"left_usefull"=>$db_footer_usefull_links->getter(), 
			"sub_navigation"=>$db_dub_navigation->getter(),
			"footer_top"=>$footer_top->index()
		]);
		
	}
}