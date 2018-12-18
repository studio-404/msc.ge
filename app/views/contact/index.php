<?php 
require_once("app/functions/l.php"); 
require_once("app/functions/string.php"); 
require_once("app/functions/strip_output.php"); 
require_once("app/functions/menu_data.php"); 
require_once("app/functions/breadcrups.php"); 
$menu_data = new functions\menu_data(); 
$l = new functions\l(); 
$string = new functions\string(); 
echo $data['headerModule'];// assets

// $photo = (isset($data["pageData"]["photo"])) ? Config::WEBSITE_.$data["pageData"]["photo"] : "";
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

    <div class="content-section module">
            <div class="row">
                
                <!-- Map Area -->
                <div class="map-wrapper module">
                    <?=strip_tags($data["contact"][4]["description"], "<iframe>")?>
                </div>
                <!-- Map Ends /-->
                
                <!-- Contact content area -->
                <div class="content-wrapper">
                    
                
                    <div class="medium-3 small-12 columns">
                        <div class="contact-info">
                            <h4><?=$l->translate("address")?></h4>
                            <p><?=strip_tags($data["contact"][3]["description"])?></p>
                        </div>
                        <div class="contact-info">
                            <h4><?=$l->translate("getintouch")?></h4>
                            <p><strong><?=$l->translate("contactnumber")?>: </strong><?=strip_tags($data["contact"][0]["description"])?></p>
                        </div>
                        <div class="contact-info">
                            <h4><?=$l->translate("follow")?></h4>
                             <div class="socialicons">
                                <?php 
                                foreach ($data["socialnetworks"] as $value):
                                ?>
                                    <a href="<?=$value['url']?>" target="_blank"><i class="fa <?=$value['classname']?>"></i></a>
                                <?php endforeach; ?>
                            </div><!-- Social Icons /-->
                        </div>

                        <div class="contact-info">
                            <h4><?=$l->translate("map")?></h4>
                            <div id="map" style="width: 100%; height: 150px;"></div>
                        </div>
                    </div><!-- Left column Ends /-->
                    
                    <div class="medium-9 small-12 columns">
                        <h2><?=$l->translate("fillformbellow")?></h2>
                        <div class="contact-form">

                            <div class="row">
                                <div class="small-12 columns">
                                    <div class="message-text"></div>
                                </div>

                                <div class="medium-6 small-12 columns">
                                    <label>
                                        <?=$l->translate("namelname")?> *
                                        <input type="text" class="firstname" value="" >
                                    </label>    
                                </div>
                                <div class="medium-6 small-12 columns">
                                    <label>
                                        <?=$l->translate("email")?> *
                                        <input type="text" class="email" value="">
                                    </label>
                                </div>
                            </div><!-- Row Ends /-->
                            
                            
                            <div class="row">
                                <div class="medium-12 small-12 columns">
                                    <label>
                                        <?=$l->translate("message")?> *
                                        <textarea rows="10" class="message"></textarea>
                                    </label>    
                                    <input type="button" class="button primary contact-button" value="<?=$l->translate("send")?>">
                                </div>
                            </div><!-- Row Ends /-->

                        </div><!-- Contact form /-->
                    </div><!-- Right Column Ends /-->
                    <div class="clearfix"></div>
                </div>
                <!-- Contact Content Area /-->
                
            </div><!-- Row /-->
        </div>

    <!-- Footer -->
    <?=$data['footer_top']?>
    <!-- Footer Ends here /-->
</div>

<?=$data['footer']?>

<script type="text/javascript">
<?php 
//
$map_coordinates = (isset($data["contactmap"][0]["map_coordinates"]) && !empty($data["contactmap"][0]["map_coordinates"])) ? explode(",", $data["contactmap"][0]["map_coordinates"]) : array();
$LAT = "41.694618163949855";
$LNG = "44.80085620117188";
if(isset($map_coordinates[0]) && isset($map_coordinates[1])){
    $LAT = $map_coordinates[0];
    $LNG = $map_coordinates[1];
}
?>
var map;
function initMap() {
    var locationRio = {lat: <?=$LAT?>, lng: <?=$LNG?>};
    $('#map_coordinates').val(locationRio.lat+','+locationRio.lng);

    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 13,
        center: locationRio,
        gestureHandling: 'cooperative'
    });

    var locations = [
        ['marker', locationRio.lat, locationRio.lng]
    ];
    var bounds = new google.maps.LatLngBounds();
    var marker, i;

    for (i = 0; i < locations.length; i++) {  
        if(locations[i][1]==0 || locations[i][2]==0){
            $(".map-title").hide();
            $("#map").hide();
            break;
        }
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map,
            animation: google.maps.Animation.DROP,
            title: locations[i][0],
            draggable:true
        });

        bounds.extend(marker.position);
    }
    map.fitBounds(bounds);

    var listener = google.maps.event.addListener(map, "idle", function() { 
      if (map.getZoom() > 14) map.setZoom(14); 
      google.maps.event.removeListener(listener); 
    });

    google.maps.event.addListener(marker, 'drag', function() {
        var latLng = marker.getPosition();
        $('#map_coordinates').val(latLng.lat()+','+latLng.lng());
    });
}

</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?=Config::GOOGLE_API_KEY?>&amp;callback=initMap" type="text/javascript"></script>

</body>
</html>