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
                    $photos = new Database("photos",array(
                        "method"=>"selectByParent", 
                        "idx"=>(int)$data['pageData']['idx'],  
                        "lang"=>strip_output::index($data['pageData']['lang']),  
                        "type"=>strip_output::index($data['pageData']['type'])
                    ));
                    if($photos->getter()){
                        $pic = $photos->getter();
                        $image = sprintf(
                            "%s%s/image/loadimage?f=%s%s&w=750&h=280",
                            Config::WEBSITE,
                            strip_output::index($_SESSION['LANG']),
                            Config::WEBSITE_,
                            strip_output::index($pic[0]['path'])
                        );
                ?>
                <div class="event-thumb">
                    <img src="<?=$image?>" width="100%" alt="Something0" class="thumbnail">
                </div><!-- Course Thumb /-->
                <?php 
                }
                ?>
                
                
                <div class="event-content" style="word-wrap: break-word;">
                    <?php 
                    $text = preg_replace_callback(
                        "/\[https\:\/\/\w+\.youtube\.com\/watch\?v=(\w+|\w+-\w+)\]/",
                        function($metches){
                            $iframe = "<iframe width=\"100%\" height=\"415\" src=\"https://www.youtube.com/embed/".$metches[1]."\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>";
                            return $iframe;
                        },
                        strip_tags($data['pageData']['text'], "<h2><img><p><a><ul><li><br><table><tr><td><strong>")
                    );
                    echo $text;
                    
                    if(count($data["sub_navigation"])){
                        ?>
                        <ul class="list-links glakho">
                        <?php foreach($data["sub_navigation"] as $item): ?>
                            <li>
                                <a href="<?=Config::WEBSITE.$_SESSION['LANG']?>/<?=$item['slug']?>"><?=$item['title']?></a>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    <?php } ?> 

                    <!-- Your share button code -->
                    <?php 
                    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                    ?>
                   <iframe src="https://www.facebook.com/plugins/share_button.php?href=<?=urlencode($actual_link)?>&layout=button_count&size=small&mobile_iframe=true&appId=719286371756996&width=69&height=20" width="69" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
                   <br />
                   <br />
                   <div class="fb-comments" data-href="<?=$actual_link?>" data-width="100%" data-numposts="5"></div>

                </div><!-- Course content /-->
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