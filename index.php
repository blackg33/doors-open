<?php 
require 'doorsOpen.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Doors Open Toronto</title>
        <link href="css/reset.css" rel='stylesheet' type='text/css'/>
        <link href="css/style.css" rel='stylesheet' type='text/css'/>
    </head>
    <body>
        <header>
            <nav id="social"></nav>
        </header>
        <div class="fixed_img">
            <h1>Doors Open T.O.</h1>
            <h2>May 23-24</h2>
            <h3>Explore Toronto's charming & unique heritage sites</h3>
        </div>
        <div class="scroll">
            <div id='head'>
                <!--<label class='search'>Find a building near you: </label>-->
                <input id="search_box" type='text' placeholder='  Enter your location'></input>
            </div>
            <div id='map'>
                
            </div>
            <div id="details">
                
            </div>
        </div>
        
    </body>
</html>
<script type="text/javascript" src="script/jquery-1.11.1.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places"></script>
<script>
    $(document).ready(function(){

    function initialize() {

    //GRAB MAP DIV BY ID & SET OPTIONS FOR MAP STARTING POINT/TYPE
    var mapCanvas = document.getElementById('map');
    var myLatlng = new google.maps.LatLng(43.661368200000000000, -79.383094200000020000);
    //SET MAP OPTIONS
    var options = {
      center:myLatlng,
      zoom: 14,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      scrollwheel: false,
      draggable: true,
    };
    //CREATE NEW MAP OBJECT
    var map =new google.maps.Map(mapCanvas, options); 
   
     var marker = new google.maps.Marker({
        icon: 'img/here.png',
        position: myLatlng,
        map: map,
    });
   
  
/*--------------------GEOLOCATION----------------------*/
   /* if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(function(position)){
            var pos = new google.maps.LatLng(position.coords.latitude,
                                             position.coords.longitude);
          
            var infowindow = new google.maps.InfoWindow({
                map: map,
                position:pos,
                content:'GEO SHIT'
            }); 
            
            map.setCenter(pos);
        }, function(){
            handleNoGeolocation(true);
        });  
    } else{
        handleNoGeolocation(false);
    }
    */
/*--------------SEARCH BOX------------------*/
    //CREATE NEW SEARCH BOX OBJECT FOR LOCATION SEARCH
   var search_box = new google.maps.places.SearchBox(document.getElementById('search_box'));
    //EVENT LISTENER FOR SEARCH BOX
    google.maps.event.addListener(search_box, 'places_changed',function(){

        var places = search_box.getPlaces();
        var bounds = new google.maps.LatLngBounds();
        var i, place;

    //SET MARKER TO SEARCH LOCATION 
        for(i=0;place=places[i];i++){
            console.log(place.geometry.location);
            bounds.extend(place.geometry.location);
            marker.setPosition(place.geometry.location);
            marker.setTitle('You are here');
          
        }

        map.fitBounds(bounds);
        map.setZoom(16); //SET ZOOM FOR NEW LOCATIONS
    });
    //BIAS SEARCH RESULTS BASED ON WHATS IN CURRENT BOUNDS
    google.maps.event.addListener(map, 'bounds_changed', function() {
        var bounds = map.getBounds();
        search_box.setBounds(bounds);
      });
      
      
   /*--------------DOORS OPEN LOCATION MARKERS------------------*/   
      var all_buildings = <?php echo json_encode($all_buildings); ?>;
      //var markers = [];
           
      function generateMarkers(all_buildings) {
  
          for (var i = 0; i < all_buildings.length; i++) {
            var coords = all_buildings[i].split(",");
           
            var markers = new google.maps.Marker({
              position: new google.maps.LatLng(coords[1],coords[0]),
              map: map,
              //icon: 'images/cycling.png',
              title: coords[2]
            });
          //console.log(coords[2]);
           
           google.maps.event.addListener(markers, 'click', function() {
               var venueName = this.title;
              // console.log(coords[2]);
               getData(venueName);
            });
    
          }
                    
        }
        
        generateMarkers(all_buildings);
        
       function getData(name){ 
        console.log(name);   
        //var theName = name;
        $.ajax({
                        url: 'doorsOpen.php',
                        type: 'GET',
                        data: {name: name},
                        success: function(data) {
                             $('#details').html(data);
                         }
                     });
        }
                 
        
        
        
        
        

        /* ADD INFO WINDOWS FOR AVAILABLE BIKES
        var info_window = new google.maps.InfoWindow({
            content:"test"
        });
        google.maps.event.addListener(marker, 'click', function(){
            info_window.open(map,marker);
        });*/
        
    };//END INITIALIZE 

    google.maps.event.addDomListener(window, 'load', initialize);

    //marker.setMap(map);

    });

</script>
<script type='text/javascript' src='script/script.js'></script>