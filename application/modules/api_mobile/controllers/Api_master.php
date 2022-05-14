
<?php

defined('BASEPATH') or exit('No direct script access allowed');

Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');

class Api_master extends CI_Controller
{


function list_wilayah(){

$url = "https://api.edunitas.com/mod/edun-load-g";

$postData = array(

  "format"=> "json",
  "formdata_groupjkt"=> 1,
  "formdata_listmod"=> "Provinsi",
  "formdata_origin"=> "pt",
  "formdata_type"=> "1",
  "setdata_mod"=> "list-wilayah",


);



// for sending data as json type
$fields = json_encode($postData);




$ch = curl_init($url);
curl_setopt(
$ch,
CURLOPT_HTTPHEADER,
array(
'Content-Type: application/json', // if the content type is json
//  'bearer: '.$token // if you need token in header
)
);

//  curl_setopt($ch, CURLOPT_HEADER, false);
// curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

$result = curl_exec($ch);
curl_close($ch);



$output = json_decode($result);

echo json_encode($output);

}






function list_campus(){

    $url = "https://api.edunitas.com/mod/edun-kampus-g";
    
    $postData = array(
    
        "format"=> "json",
        "formdata_filterkelas"=> "Program-Perkuliahan-Reguler",
        "formdata_filterprodi"=> "semua-prodi",
        "formdata_filterwilayah"=> "semua-wilayah",
        "formdata_getlist"=> "listcampus",
        "formdata_length"=> "300",
        "formdata_origin"=> "list",
        "formdata_page"=> "1",
        "setdata_mod"=> "get-data",
    
    
    );
    
    
    
    // for sending data as json type
    $fields = json_encode($postData);
    
    
    
    
    $ch = curl_init($url);
    curl_setopt(
    $ch,
    CURLOPT_HTTPHEADER,
    array(
    'Content-Type: application/json', // if the content type is json
    //  'bearer: '.$token // if you need token in header
    )
    );
    
    //  curl_setopt($ch, CURLOPT_HEADER, false);
    // curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    
    $result = curl_exec($ch);
    curl_close($ch);
    
    
    
    $output = json_decode($result);
    
    echo json_encode($output);
    
    }




}

?>