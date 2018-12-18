<?php 
require_once("app/functions/l.php"); 
require_once("app/functions/string.php"); 
require_once("app/functions/strip_output.php"); 
require_once("app/functions/menu_data.php"); 
require_once("app/functions/breadcrups.php"); 
require_once("app/functions/poll.php"); 
$menu_data = new functions\menu_data(); 

$l = new functions\l(); 
$string = new functions\string(); 
echo $data['headerModule'];// assets

?>
<!-- Main Container -->
<div class="main-container">
    <?php 
    echo $data['headertop']; // navigation &...
    ?>

    <!-- Title Section Start -->
    <div class="title-section module">
        <div class="row">
    
            <div class="small-12 columns">
                <h1><?=$data['pageData']['title']?></h1>
            </div><!-- Top Row /-->
    
            <div class="small-12 columns">
                <?php 
                $breadcrups = new functions\breadcrups();
                echo $breadcrups->index();
                ?>
            </div><!-- Bottom Row /-->
            
        </div><!-- Row /-->
    </div>
    
    <!-- Title Section End -->   

    <div class="content-section module blog-page">
        <div class="row">
            <div class="medium-9 small-12 columns posts-wrap">
                

                <?php 
                if(count($data["search"])<=0){
                   ?>
                   <div class="search-list-item" style="margin-bottom: 20px;">
                        <div class="testimonial">
                            <a href="javascript:void(0)">
                                <div class="testimonial-detail" style="width: 100%;">
                                    <h4><?=$l->translate("search")?></h4>
                                    <p><?=$l->translate("notfound")?></p>
                                </div>
                            </a>
                            <div class="clearfix"></div>
                        </div> 
                    </div>
                   <?php
                }

                foreach ($data["search"] as $value):
                    $url = "";
                    if($value["page_type"]=="text"){
                        $url = Config::WEBSITE.$_SESSION["LANG"]."/".$value["page_slug"];
                    }
                    if($value["page_type"]=="news"){
                        $url = Config::WEBSITE.$_SESSION["LANG"]."/news/".(int)$value["page_idx"]."/".urlencode($value["page_title"]);
                    }
                ?>
                <div class="search-list-item" style="margin-bottom: 20px;">
                    <div class="testimonial">
                        <a href="<?=$url?>" target="_blank">
                            <div class="testimonial-detail" style="width: 100%;">
                                <h4><?=$value["page_title"]?></h4>
                                <p><?=$string->cut(strip_tags($value["page_text"]), 420)?></p>
                                <cite><?=urldecode($url)?></cite>
                            </div>
                        </a>
                        <div class="clearfix"></div>
                    </div> 
                </div>
                <?php endforeach; ?>                

                
            </div><!-- Posts wrap ends /-->
            
            <div class="medium-3 small-12 columns sidebar">
                <div class="widget">
                    <h2 class="BPGNinoMtavruli"><?=$l->translate("news")?></h2>
                    <ol class="menu vertical">
                        <?php 
                        if(count($data["left_news"]))
                        {
                            foreach ($data["left_news"] as $v):
                                $titleUrl = str_replace(array(" ", "'", '"'), "-", $v["title"]);
                            ?>
                            <li>
                                <?php 
                                echo sprintf(
                                    "<a href=\"%s%s/%s/%s/%s\" class=\"BPGGlaxo\">%s</a>", 
                                    Config::WEBSITE,
                                    strip_output::index($_SESSION['LANG']),
                                    $v["type"],
                                    (int)$v['idx'],
                                    strip_output::index($titleUrl), 
                                    $v['title']
                                );
                                ?>
                            </li>
                            <?php
                            endforeach;
                        }
                        ?>
                    </ol>
                </div><!-- widget ends /-->
                
                <div class="widget">
                    <h2 class="BPGNinoMtavruli"><?=$l->translate("usefulllinks")?></h2>
                    <ol class="menu vertical">
                        <?php 
                        if(count($data["left_usefull"]))
                        {
                            foreach ($data["left_usefull"] as $v):
                            ?>
                            <li>
                                <?php 
                                echo sprintf(
                                    "<a href=\"%s\" class=\"BPGGlaxo\">%s</a>", 
                                    $v["url"],
                                    $v['title']
                                );
                                ?>
                            </li>
                            <?php
                            endforeach;
                        }
                        ?>
                    </ol>
                </div><!-- widget ends /-->  

                <div class="widget">
                    <h2 class="BPGNinoMtavruli"><?=$l->translate("poll")?></h2>
                    <div class="poll-container">
                    <?php 
                    $poll = new functions\poll("poll", array(
                        "classname",
                        "url",
                        "additional1",
                        "additional2",
                        "additional3"
                    )); 
                    echo $poll->select();
                    ?>
                    </div>
                </div><!-- widget ends /-->  


            </div><!-- right bar ends here /-->                
        </div><!-- Row Ends /-->          
    </div>  
    
    <!-- Footer -->
    <?=$data['footer_top']?>
    <!-- Footer Ends here /-->
    
</div>
<!-- Main Container /-->


<?=$data['footer']?>


</body>
</html>