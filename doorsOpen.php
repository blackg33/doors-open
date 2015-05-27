
<?php

$url = 'http://wx.toronto.ca/inter/culture/doorsopen.nsf/OpenDataDOTBuilding.JSON?OpenPage';

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$json_data = curl_exec($curl);
curl_close($curl);
    
 $result = json_decode($json_data, true);
 
$all_buildings = array();

foreach($result['buildings'] as $item){
    
    $building = $item['dot_Address']['dot_Longitude'] . "," . $item['dot_Address']['dot_Latitude']
            . "," . $item['dot_buildingName'];
    
    $all_buildings[]=$building;
   
}

$name = (isset($_GET['name']) ? $_GET['name'] : null);

function getDetails($data, $name){

    foreach($data['buildings'] as $detail){
        if((string)$detail['dot_buildingName']==$name){
            $details = $detail['dot_buildingName'] . "," . $detail['dot_Address']['dot_Latitude']; 
        }
    }
  echo $details;
    
}

if(isset($name)){ 
    getDetails($result, $name);   
}



   /*  
echo '<pre>';
echo print_r($result);
echo '</pre>';

*/