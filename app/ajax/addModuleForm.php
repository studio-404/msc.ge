<?php 
class addModuleForm
{
	public $out; 

	public function __construct()
	{
		require_once 'app/core/Config.php';
		if(!isset($_SESSION[Config::SESSION_PREFIX."username"]))
		{
			exit();
		}
	}
	
	public function index(){
		require_once 'app/core/Config.php';
		require_once 'app/functions/makeForm.php';
		require_once 'app/functions/request.php';
		require_once 'app/functions/string.php';

		$this->out = array(
			"Error" => array(
				"Code"=>1, 
				"Text"=>"მოხდა შეცდომა !",
				"Details"=>"!"
			)
		);

		$moduleSlug = functions\request::index("POST","moduleSlug");
		$lang = functions\request::index("POST","lang");
		$random = functions\string::random(25);

		$Database = new Database("modules", array(
			"method"=>"selectParentFieldsByType",
			"type"=>$moduleSlug
		));
		$fetch = $Database->getter();

		// $form = print_r($fetch, true);

		$form = functions\makeForm::open(array(
			"action"=>"?",
			"method"=>"post",
			"id"=>"",
			"id"=>"",
		));

		/*
		* Date field 
		*/
		if($fetch["date"]["visibility"]=="true"){
			$form .= functions\makeForm::label(array(
				"id"=>"dateLabel", 
				"for"=>"date", 
				"name"=>$fetch["date"]["title"],
				"require"=>""
			));

			$form .= functions\makeForm::inputText(array(
				"placeholder"=>$fetch["date"]["title"], 
				"id"=>"date", 
				"name"=>"date",
				"value"=>date("d-m-Y")
			));
			$form .= "<script type=\"text/javascript\"> $(\"#date\").datepicker({ dateFormat: \"dd-mm-yy\"}).attr(\"readonly\",\"readonly\");</script>";
		}else{
			$form .= functions\makeForm::inputHidden(array(
				"id"=>"date", 
				"name"=>"date",
				"value"=>date("d-m-Y")
			));
		}		

		/*
		* Title field
		*/
		if($fetch["title"]["visibility"]=="true"){
			$form .= functions\makeForm::label(array(
				"id"=>"titleLabel", 
				"for"=>"title", 
				"name"=>$fetch["title"]["title"],
				"require"=>""
			));
			$form .= functions\makeForm::inputText(array(
				"placeholder"=>$fetch["title"]["title"], 
				"id"=>"title", 
				"name"=>"title",
				"value"=>$fetch["title"]["defaultValue"] 
			));
		}else{
			$form .= functions\makeForm::inputHidden(array(
				"id"=>"title", 
				"name"=>"title",
				"value"=>"Hidden Field"
			));
		}

		/*
		* PageText field
		*/
		if($fetch["pageText"]["visibility"]=="true"){
			$form .= functions\makeForm::label(array(
				"id"=>"longDescription", 
				"for"=>"pageText", 
				"name"=>$fetch["pageText"]["title"],
				"require"=>""
			));

			$form .= functions\makeForm::textarea(array(
				"id"=>"pageText",
				"name"=>"pageText",
				"placeholder"=>$fetch["pageText"]["title"],
				"value"=>$fetch["pageText"]["defaultValue"]
			));
		}else{
			$form .= functions\makeForm::inputHidden(array(
				"id"=>"pageText",
				"name"=>"pageText",
				"value"=>"Hidden Field"
			));
		}

		/*
		* Classname field
		*/
		if($fetch["classname"]["visibility"]=="true"){
			$form .= functions\makeForm::label(array(
				"id"=>"classnameLabel", 
				"for"=>"classname", 
				"name"=>$fetch["classname"]["title"],
				"require"=>""
			));

			$form .= functions\makeForm::inputText(array(
				"placeholder"=>$fetch["classname"]["title"], 
				"id"=>"classname", 
				"name"=>"classname",
				"value"=>$fetch["classname"]["defaultValue"]
			));
		}else{
			$form .= functions\makeForm::inputHidden(array(
				"id"=>"classname", 
				"name"=>"classname",
				"value"=>"Hidden Field"
			));
		}

		/*
		* Link field
		*/
		if($fetch["link"]["visibility"]=="true"){
			$form .= functions\makeForm::label(array(
				"id"=>"linkLabel", 
				"for"=>"link", 
				"name"=>$fetch["link"]["title"],
				"require"=>""
			));
			$form .= functions\makeForm::inputText(array(
				"placeholder"=>$fetch["link"]["title"], 
				"id"=>"link", 
				"name"=>"link",
				"value"=>$fetch["link"]["defaultValue"]
			));
		}else{
			$form .= functions\makeForm::inputHidden(array(
				"id"=>"link", 
				"name"=>"link",
				"value"=>""
			));
		}

		/*
		* additional 1 field
		*/
		if($fetch["additional1"]["visibility"]=="true"){
			$form .= functions\makeForm::label(array(
				"id"=>"additional1Label", 
				"for"=>"additional1", 
				"name"=>$fetch["additional1"]["title"],
				"require"=>""
			));
			$form .= functions\makeForm::inputText(array(
				"placeholder"=>$fetch["additional1"]["title"], 
				"id"=>"additional1", 
				"name"=>"additional1",
				"value"=>$fetch["additional1"]["defaultValue"]
			));
		}else{
			$form .= functions\makeForm::inputHidden(array(
				"id"=>"additional1", 
				"name"=>"additional1",
				"value"=>""
			));
		}


		/*
		* additional 2 field
		*/
		if($fetch["additional2"]["visibility"]=="true"){
			$form .= functions\makeForm::label(array(
				"id"=>"additional2Label", 
				"for"=>"additional2", 
				"name"=>$fetch["additional2"]["title"],
				"require"=>""
			));
			$form .= functions\makeForm::inputText(array(
				"placeholder"=>$fetch["additional2"]["title"], 
				"id"=>"additional2", 
				"name"=>"additional2",
				"value"=>$fetch["additional2"]["defaultValue"]
			));
		}else{
			$form .= functions\makeForm::inputHidden(array(
				"id"=>"additional2", 
				"name"=>"additional2",
				"value"=>""
			));
		}

		/*
		* additional 3 field
		*/
		if($fetch["additional3"]["visibility"]=="true"){
			$form .= functions\makeForm::label(array(
				"id"=>"additional3Label", 
				"for"=>"additional3", 
				"name"=>$fetch["additional3"]["title"],
				"require"=>""
			));
			$form .= functions\makeForm::inputText(array(
				"placeholder"=>$fetch["additional3"]["title"], 
				"id"=>"additional3", 
				"name"=>"additional3",
				"value"=>$fetch["additional3"]["defaultValue"]
			));
		}else{
			$form .= functions\makeForm::inputHidden(array(
				"id"=>"additional3", 
				"name"=>"additional3",
				"value"=>""
			));
		}


		/*
		* additional 4 field
		*/
		if($fetch["additional4"]["visibility"]=="true"){
			$form .= functions\makeForm::label(array(
				"id"=>"additional4Label", 
				"for"=>"additional4", 
				"name"=>$fetch["additional4"]["title"],
				"require"=>""
			));
			$form .= functions\makeForm::inputText(array(
				"placeholder"=>$fetch["additional4"]["title"], 
				"id"=>"additional4", 
				"name"=>"additional4",
				"value"=>$fetch["additional4"]["defaultValue"]
			));
		}else{
			$form .= functions\makeForm::inputHidden(array(
				"id"=>"additional4", 
				"name"=>"additional4",
				"value"=>""
			));
		}


		/*
		* additional 5 field
		*/
		if($fetch["additional5"]["visibility"]=="true"){
			$form .= functions\makeForm::label(array(
				"id"=>"additional5Label", 
				"for"=>"additional5", 
				"name"=>$fetch["additional5"]["title"],
				"require"=>""
			));
			$form .= functions\makeForm::inputText(array(
				"placeholder"=>$fetch["additional5"]["title"], 
				"id"=>"additional5", 
				"name"=>"additional5",
				"value"=>$fetch["additional5"]["defaultValue"]
			));
		}else{
			$form .= functions\makeForm::inputHidden(array(
				"id"=>"additional5", 
				"name"=>"additional5",
				"value"=>""
			));
		}


		/*
		* PhotoUploaderBox field
		*/
		if($fetch["photoUploaderBox"]["visibility"]=="true"){
			$form .= functions\makeForm::label(array(
				"id"=>"PhotoUploaderLabel", 
				"for"=>"PhotoUploader", 
				"name"=>$fetch["photoUploaderBox"]["title"],
				"require"=>""
			));

			$form .= "<div class=\"row\" id=\"photoUploaderBox\" style=\"margin:0 -10px\">";
			
			$form .= "<div class=\"col s4 imageItem\" id=\"img1\">
				<div class=\"card\">
		    
		    		<div class=\"card-image waves-effect waves-block waves-light\">
		    			<input type=\"hidden\" name=\"managerFiles[]\" class=\"managerFiles\" value=\"\" />
		      			<img class=\"activator\" src=\"/public/img/noimage.png\" />
		    		</div>

		    		<div class=\"card-content\">
	                	<p>
	                		<a href=\"javascript:void(0)\" onclick=\"openFileManager('photoUploaderBox', 'img1')\" class=\"large material-icons\">mode_edit</a>
	                		<a href=\"javascript:void(0)\" onclick=\"removePhotoItem('img1')\" class=\"large material-icons\">delete</a>
	                	</p>
	              	</div>

	    		</div>
	  		</div>";				

	  		$form .= "</div>";
  		}

  		$form .= "<div style=\"clear:both\"></div>";

  		/*
		* File_attach field
		*/
		if($fetch["file_attach"]["visibility"]=="true"){
	  		$form .= "<div class=\"input-field\">
	            <label>{$fetch["file_attach"]["title"]}: </label>
	          </div>";

	        $form .= "<div style=\"clear:both\"></div>";

	        $form .= "<a href=\"javascript:void(0)\" class=\"waves-effect waves-light btn margin-bottom-20\" style=\"clear:both; margin-top: 40px;\" onclick=\"openFileManagerForFiles('attachfiles')\"><i class=\"material-icons left\">note_add</i>ატვირთვა</a>";

	  		$form .= sprintf(
	  			"<input type=\"hidden\" name=\"random\" id=\"random\" value=\"%s\" />",
	  			$random
	  		);
	  		$form .= "<input type=\"hidden\" name=\"file_attach_type\" id=\"file_attach_type\" value=\"module\" />";
	  		$form .= "<ul class=\"collection with-header\" id=\"sortableFiles-box\">";
	      	$form .= "</ul>";
      	}


      	/*
		* File_attach field
		*/
		if($fetch["map_coordinates"]["visibility"]=="true"){
			$form .= "<label>{$fetch["map_coordinates"]["title"]}: </label>";
			$form .= sprintf(
	  			"<input type=\"hidden\" name=\"map_coordinates\" id=\"map_coordinates\" value=\"\" />"
	  		);
	        $form .= "<div style=\"clear:both; margin-bottom:10px;\"></div>";	        

	  		$form .= "<div id=\"map\" style=\"width:100%; height:350px;\"></div>";
 
	  		$form .= "
	  		<script type=\"text/javascript\">
			var map;
			function initMap() {
				var locationRio = {lat: 41.694618163949855, lng: 44.80085620117188};
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
						$(\".map-title\").hide();
						$(\"#map\").hide();
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

			    var listener = google.maps.event.addListener(map, \"idle\", function() { 
				  if (map.getZoom() > 14) map.setZoom(14); 
				  google.maps.event.removeListener(listener); 
				});

				google.maps.event.addListener(marker, 'drag', function() {
				    var latLng = marker.getPosition();
				    $('#map_coordinates').val(latLng.lat()+','+latLng.lng());
				});
			}

			</script>
			<script async defer src=\"https://maps.googleapis.com/maps/api/js?key=".Config::GOOGLE_API_KEY."&amp;callback=initMap\" type=\"text/javascript\"></script>
			";
		}


		$form .= functions\makeForm::close();

		
		$this->out = array(
			"Error" => array(
				"Code"=>0, 
				"Text"=>"ოპერაცია შესრულდა წარმატებით !",
				"Details"=>""
			),
			"form" => $form,
			"attr" => "formModuleAdd('".$moduleSlug."', '".$lang."')"
		);



		return $this->out;
	}
}