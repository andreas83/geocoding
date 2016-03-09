<?php


$sourceCSV="example.csv";


$api_key="";


if (($earthcsv = fopen($sourceCSV, "r")) !== false)
{
    $curl = curl_init();
    $i=0;
    $x=0;
    while(($earthdata = fgetcsv($earthcsv, 1000, ",")) != false)
    {
        $i++;   

        if($i==1)
            continue;
            
        $adresse = $earthdata[1]. ' '.  $earthdata[2]. ', ' . $earthdata[3];
        
        $earthresult = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($adresse) . "&key=".$api_key;
        
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $earthresult
        ));
        $resp = curl_exec($curl);
        $json=json_decode($resp);

        $lat= $json->results['0']->geometry->location->lat;
        $lng= $json->results['0']->geometry->location->lng;   
        
        while(count($earthdata)>$x)
        {
            echo '"'.$earthdata[$x].'",';
            $x++;
        }
        $x=0;
        echo '"'.$lat.'",';
        echo '"'.$lng.'"';
        echo PHP_EOL;
        
    }     
        
}
?>
