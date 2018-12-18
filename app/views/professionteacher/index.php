<?php 
require_once("app/functions/l.php"); 
require_once("app/functions/string.php"); 
require_once("app/functions/strip_output.php"); 
require_once("app/functions/pagination.php");
require_once("app/functions/menu_data.php"); 
require_once("app/functions/breadcrups.php"); 
$menu_data = new functions\menu_data(); 
$l = new functions\l(); 
$pagination = new functions\pagination();
$string = new functions\string(); 
echo $data['headerModule'];// assets

// echo "<pre>";
// print_r($data["sub_navigation"]);
// echo "</pre>";

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

                    <?php if(count($data["sub_navigation"])): ?>
                    <ul>
                        <?php foreach($data["sub_navigation"] as $sub): ?>
                            <li><a href="<?=Config::WEBSITE.$_SESSION["LANG"]?>/<?=$sub["slug"]?>"><?php echo $sub["title"]; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?> 

                    <?=$data["staff"]?> 
                </div>
                
                <div class="medium-3 small-12 columns sidebar">
                    
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