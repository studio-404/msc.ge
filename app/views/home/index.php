<?php 
require_once("app/functions/l.php"); 
require_once("app/functions/string.php"); 
require_once("app/functions/strip_output.php"); 
require_once("app/functions/menu_data.php"); 
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

        <!-- Banner Starts -->
        <div class="main-banner">
          <?=$data['slider']['list']?>
        </div>
        <!-- Banner Ends /-->
        
        <!-- information boxes starts -->
        <div class="information-boxes module" style="margin-bottom: 0px;">
        
          <div class="courses-info g-after-slider-boxes medium-4 small-12 columns">
              <div class="">
                  <h3><i class="fa fa-graduation-cap" aria-hidden="true"></i> 
                    <?=$string->cut($menu_data->data(127, "title"),20)?></h3>
                    <p style="word-wrap: break-word; min-height: 50px;">
                      <?=$string->cut(strip_tags($menu_data->data(127, "text")), 150)?>
                    </p>
                    
                    <div class="clearfix"></div>
                    <a href="/<?=$_SESSION["LANG"]?>/Professional-programs" class="primary button bordered-light"><?=$l->translate("more")?></a>
                </div>
            </div><!-- courses column Ends /-->
            
            <div class="faculty-info g-after-slider-boxes medium-4 small-12 columns">
              <div class="">
                <h3><i class="fa fa-bullseye" aria-hidden="true"></i> <?=$string->cut($menu_data->data(123, "title"),20)?></h3>
                <p style="word-wrap: break-word; min-height: 50px;">
                  <?=$string->cut(strip_tags($menu_data->data(123, "text")), 150)?>
                </p>
                <div class="clearfix"></div>
                <a href="/<?=$_SESSION["LANG"]?>/Mission" class="primary button bordered-light"><?=$l->translate("more")?></a>
              </div>
            </div><!-- faculty info ends /-->
            
            <div class="newadmission-info g-after-slider-boxes medium-4 small-12 columns">
                <div class="">
                <h3><i class="fa fa-eye" aria-hidden="true"></i> <?=$string->cut($menu_data->data(125, "title"),20)?></h3>
                <p style="word-wrap: break-word; min-height: 50px;">
                  <?=$string->cut(strip_tags($menu_data->data(125, "text")), 150)?>
                </p>
                <div class="clearfix"></div>
                <a href="/<?=$_SESSION["LANG"]?>/our-view" class="primary button bordered-light"><?=$l->translate("more")?></a>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <!-- information boxes ends /-->
        
        <!-- Welcome Message -->
        <!-- <div class="welcome-message module">
          <div class="row">
            
                <div class="medium-6 small-12 columns">
                    <img src="<?=$menu_data->data(105, "photo")?>" alt="Education Background" />
                </div>

                <div class="medium-6 small-12 columns">
                  <h2><span><?=functions\string::cut($menu_data->data(105, "title"),20)?></span></h2>
                    <?=strip_tags($menu_data->data(105, "text"), "<p><a>")?>
                    <a href="/<?=$_SESSION["LANG"]?>/about-us" class="primary bordered-dark button"><?=$l->translate("more")?></a>
                </div>
                
            </div>
        </div> -->
        <!-- Welcome Message Ends /-->
        
         <!-- Blog Posts -->
        <div class="blog-posts module grey-bg" style="margin-bottom: 0px;">
          <div class="section-title-wrapper">
                <div class="section-title">
                    <h2><?=$l->translate("lastnews")?></h2>
                    <p>&nbsp;</p>
                </div>
            </div> <!-- Title Ends /-->
            
          <div class="row">
              
                <div class="posts-wrapper">
                  
                    <?=$data["news"]?>
                    <div class="clearfix"></div>
                </div><!-- Posts Wrapper /-->
                <div class="clearfix"></div>
                <div class="load-more text-center">
                  <a href="/<?=$_SESSION["LANG"]?>/news" class="button primary bordered-dark"><?=$l->translate("allnews")?>...</a>
                </div><!-- Load more /-->
                
            </div><!-- Row Ends /-->
        
        </div>
        <!-- Blog Posts Ends /-->     
        
        
      
        
        <!-- Footer -->
        <?=$data['footer_top']?>
        <!-- Footer Ends here /-->
        
    </div>
    <!-- Main Container /-->


<?=$data['footer']?>


</body>
</html>