<?php 
class editModules
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

		$idx = functions\request::index("POST","idx");
		$lang = functions\request::index("POST","lang");
		$random = functions\string::random(25);


		if($idx == "" || $lang=="")
		{
			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>"მოხდა შეცდომა !",
					"Details"=>"!"
				)
			);
		}else{
			$Database = new Database('modules', array(
					'method'=>'selectById', 
					'idx'=>$idx, 
					'lang'=>$lang
			));
			$output = $Database->getter();

			$Database = new Database("modules", array(
				"method"=>"selectParentFieldsByType",
				"type"=>$output['type'] 
			));
			$fetch = $Database->getter();

			$photos = new Database('photos', array(
				'method'=>'selectByParent', 
				'idx'=>$idx, 
				'lang'=>$lang, 
				'type'=>$output['type'] 
			));
			$pictures = $photos->getter();

			$file = new Database('file', array(
				'method'=>'selectFilesByPageId', 
				'page_id'=>$idx, 
				'lang'=>$lang,
				'type'=>"module" 
			));
			$files = $file->getter();


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
					"value"=>date("d-m-Y", $output['date'])
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
					"value"=>$output['title']
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
					"value"=>$output['description']
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
					"value"=>$output['classname'] 
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
					"value"=>$output['url']
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
					"value"=>$output['additional1']
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
					"value"=>$output['additional2']
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
					"value"=>$output['additional3']
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
					"value"=>$output['additional4']
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
					"value"=>$output['additional5']
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

				if(count($pictures)){
					$i = 2;
					
					foreach($pictures as $picture) {
						$form .= "<div class=\"col s4 imageItem\" id=\"img".$i."\">
							<div class=\"card\">
					    		<div class=\"card-image waves-effect waves-block waves-light\">
					    			<input type=\"hidden\" name=\"managerFiles[]\" class=\"managerFiles\" value=\"".$picture['path']."\" />
					      			<img class=\"activator\" src=\"".Config::WEBSITE.Config::MAIN_LANG."/image/loadimage?f=".Config::WEBSITE_.$picture["path"]."&w=215&h=173\" />
					    		</div>

					    		<div class=\"card-content\">
				                	<p>
				                		<a href=\"javascript:void(0)\" onclick=\"openFileManager('photoUploaderBox', 'img".$i."')\" class=\"large material-icons\">mode_edit</a>
				                		<a href=\"javascript:void(0)\" onclick=\"removePhotoItem('img".$i."')\" class=\"large material-icons\">delete</a>
				                	</p>
				              	</div>

				    		</div>
				  		</div>";
				  		$i++;
					}
				}

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

	        	$form .= "<input type=\"hidden\" name=\"random\" id=\"random\" value=\"".$random."\" />";
	        	$form .= "<input type=\"hidden\" name=\"file_attach_type\" id=\"file_attach_type\" value=\"module\" />";
	        	
	        	$form .= "<ul class=\"collection with-header\" id=\"sortableFiles-box\">";

		  		if(count($files))
		  		{
		  			$runed = 1;
		  			foreach ($files as $f) {
		  				$explode = explode("/", $f['file_path']);
		  				$filename = end($explode);

		  				$form .= "<li class=\"collection-item level-0 popupfile0\" data-item=\"".$f['idx']."\" data-cid=\"".$f['cid']."\" data-file=\"".$f['file_path']."\">
								<div>
									".$filename."
									
									<a href=\"javascript:void(0)\" onclick=\"removeAttachedFile('level-0','".$f['idx']."', true)\" class=\"secondary-content tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"წაშლა\"><i class=\"material-icons\">delete</i></a>
									<a href=\"".Config::ADMIN_DASHBOARD_COMMENTS."?file=".$f['idx']."\" class=\"secondary-content tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"კომენტარი\"><i class=\"material-icons\">comment</i></a>
									<a href=\"javascript:void(0)\" onclick=\"openFileManagerForSubFiles('subfilex".$f['idx']."','".$f['idx']."')\" class=\"secondary-content tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"დამატება\"><i class=\"material-icons\">note_add</i></a>
								</div>";
				       $form .= "</li>";
				       $database = new Database("file", array(
				       		"method"=>"selectFilesByPageId", 
				       		"cid"=>$f['idx'], 
				       		"page_id"=>$f['page_id'], 
				       		"type"=>$f['type'], 
				       		"lang"=>$f['lang']  
				       ));
				       
				       $subfiles = $database->getter(); 
				       if(count($subfiles))
				       { 
					       	if($runed==1){
									$form .= "<ul id=\"subfilex-".$f['idx']."\" class=\"collection with-header sortableFiles-box2\" data-cid=\"".$f['idx']."\" style=\"margin:10px;\">";
							}
				       		foreach ($subfiles as $sf) {
				       			$ex = explode("/", $sf['file_path']); 
				       			$fn = end($ex);
								$form .= "<li class=\"collection-item level-2\" data-item=\"".$sf['idx']."\" data-cid=\"".$sf['cid']."\" data-path=\"".$sf['file_path']."\">";
								$form .= "<div>";
								$form .= $fn;
								$form .= "<a href=\"javascript:void(0)\" onclick=\"removeAttachedFile('level-2','".$sf['idx']."', false)\"  class=\"secondary-content tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"წაშლა\"><i class=\"material-icons\">delete</i></a>";
								$form .= "<a href=\"\" class=\"secondary-content tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"კომენტარი (5)\"><i class=\"material-icons\">comment</i></a>";
								$form .= "</div>";
								$form .= "</li>";
				       		}
				       		if($runed==1){
								$form .= "</ul>";
							}
				       }
						
		  			}
		  		}

		  		$form .= "</ul>";
		  	}


		  	/*
			* File_attach field
			*/
			if($fetch["map_coordinates"]["visibility"]=="true"){
				$map_coordinates = (isset($output["map_coordinates"]) && !empty($output["map_coordinates"])) ? explode(",", $output["map_coordinates"]) : array();
				$LAT = "41.694618163949855";
				$LNG = "44.80085620117188";
				if(isset($map_coordinates[0]) && isset($map_coordinates[1])){
					$LAT = $map_coordinates[0];
					$LNG = $map_coordinates[1];
				}

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
					var locationRio = {lat: ".$LAT.", lng: ".$LNG."};
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
				"attr" => "formModuleEdit('".$idx."','".$lang."')"
			);	
		}

		

		return $this->out;
	}
}