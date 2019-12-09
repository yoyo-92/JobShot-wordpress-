<?php

function get_time_to_station($address){
    mb_language("Japanese");//文字コードの設定
    mb_internal_encoding("UTF-8");
    $api_key='AIzaSyAo-HEaelxKq4jLvmvCg8HI7_UKoGAz_ms';
    $address = urlencode($address[0]);
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "+&key=" . $api_key ;
    $contents= file_get_contents($url);
    $jsonData = json_decode($contents,true);

    $lat = $jsonData["results"][0]["geometry"]["location"]["lat"];//最寄りの緯度
    $lng = $jsonData["results"][0]["geometry"]["location"]["lng"];//最寄りの経度

    $stations=array();

    $url1="https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=".strval($lat).",".strval($lng)."&radius=800&type=train_station&language=ja&key=" . $api_key ;
    $contents1= file_get_contents($url1);
    $jsonData1 = json_decode($contents1,true);
    foreach($jsonData1["results"] as $data){
        $sta=$data["name"];
        $endpoint = 'https://maps.googleapis.com/maps/api/directions/json?language=ja&origin='.$sta.'&mode=walking&destination='.$address.'&key='.$api_key;
        $contents3= file_get_contents($endpoint);
        $jsonData3 = json_decode($contents3,true);
        $sta1 = rtrim($sta, '駅');
        $get_lines='http://express.heartrails.com/api/json?method=getStations&name='.$sta1;
        $lines_contents=file_get_contents($get_lines);
        $lines_json = json_decode($lines_contents,true);
        $lines=array();
        foreach($lines_json['response']['station'] as $ln){
            array_push($lines,$ln['line']);
        }
        array_push($stations,array('name'=>$sta,'distance'=>$jsonData3["routes"][0]["legs"][0]["distance"]["text"],'time'=>$jsonData3["routes"][0]["legs"][0]["duration"]["text"],'line'=>$lines));
    }

    $url2="https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=".strval($lat).",".strval($lng)."&radius=800&type=subway_station&language=ja&key=" . $api_key ;
    $contents2= file_get_contents($url2);
    $jsonData2 = json_decode($contents2,true);
    foreach($jsonData2["results"] as $data){
        $sta=$data["name"];
        $endpoint = 'https://maps.googleapis.com/maps/api/directions/json?language=ja&origin='.$sta.'&mode=walking&destination='.$address.'&key='.$api_key;
        $contents4= file_get_contents($endpoint);
        $jsonData4 = json_decode($contents4,true);
        $sta1 = rtrim($sta, '駅');
        $get_lines='http://express.heartrails.com/api/json?method=getStations&name='.$sta1;
        $lines_contents=file_get_contents($get_lines);
        $lines_json = json_decode($lines_contents,true);
        $lines=array();
        foreach($lines_json['response']['station'] as $ln){
            array_push($lines,$ln['line']);
        }
        array_push($stations,array('name'=>$sta,'distance'=>$jsonData4["routes"][0]["legs"][0]["distance"]["text"],'time'=>$jsonData4["routes"][0]["legs"][0]["duration"]["text"],'line'=>$lines));
    }
    return $stations;
}
add_shortcode('get_time_to_station','get_time_to_station');

Array ( [results] => Array ( [0] => Array ( [address_components] => Array ( [0] => Array ( [long_name] => Faculty of Engineering Bldg.2 [short_name] => Faculty of Engineering Bldg.2 [types] => Array ( [0] => premise ) )
 [1] => Array ( [long_name] => 1 [short_name] => 1 [types] => Array ( [0] => premise ) ) [2] => Array ( [long_name] => 3 [short_name] => 3 [types] => Array ( [0] => political [1] => sublocality [2] => sublocality_level_4 ) ) [3] => Array ( [long_name] => 7-chōme [short_name] => 7-chōme [types] => Array ( [0] => political [1] => sublocality [2] => sublocality_level_3 ) ) [4] => Array ( [long_name] => Hongō [short_name] => Hongō [types] => Array ( [0] => political [1] => sublocality [2] => sublocality_level_2 ) ) [5] => Array ( [long_name] => Bunkyo City [short_name] => Bunkyo City [types] => Array ( [0] => locality [1] => political ) ) [6] => Array ( [long_name] => Tōkyō-to [short_name] => Tōkyō-to [types] => Array ( [0] => administrative_area_level_1 [1] => political ) )
  [7] => Array ( [long_name] => Japan [short_name] => JP [types] => Array ( [0] => country [1] => political ) ) [8] => Array ( [long_name] => 113-0033 [short_name] => 113-0033 [types] => Array ( [0] => postal_code ) ) )
   [formatted_address] => Faculty of Engineering Bldg.2, 7-chōme-3-1 Hongō, Bunkyo City, Tōkyō-to 113-0033, Japan [geometry] => Array ( [location] => Array ( [lat] => 35.7141631 [lng] => 139.7621022 ) [location_type] => ROOFTOP [viewport] => Array ( [northeast] => Array ( [lat] => 35.715512080291 [lng] => 139.76345118029 ) [southwest] => Array ( [lat] => 35.712814119708 [lng] => 139.76075321971 ) ) )
    [place_id] => ChIJjR5fcVGNGGAR2nk304it8jo [plus_code] => Array ( [compound_code] => PQ76+MR Tokyo, 東京都 Japan [global_code] => 8Q7XPQ76+MR )
     [types] => Array ( [0] => street_address ) ) ) [status] => OK ) 
Array ( [geocoded_waypoints] => Array ( [0] => Array ( [geocoder_status] => OK [place_id] => ChIJKT-Ojy6MGGARePPzb67Jr1A [types] => Array ( [0] => establishment [1] => point_of_interest [2] => subway_station [3] => transit_station ) )
[1] => Array ( [geocoder_status] => OK [place_id] => ChIJjR5fcVGNGGAR2nk304it8jo [types] => Array ( [0] => street_address ) ) )
  [routes] => Array ( [0] => Array ( [bounds] => Array ( [northeast] => Array ( [lat] => 35.7177222 [lng] => 139.7656883 ) [southwest] => Array ( [lat] => 35.7141882 [lng] => 139.7621138 ) )
   [copyrights] => 地図データ ©2019 Google [legs] => Array ( [0] => Array ( [distance] => Array ( [text] => 0.7 km [value] => 742 ) [duration] => Array ( [text] => 10分 [value] => 584 ) [end_address] => 日本、〒113-0033 東京都文京区本郷７丁目３−１ 工2号館 [end_location] => Array ( [lat] => 35.7141882 [lng] => 

?>