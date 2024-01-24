<?php

// To get the data sent by the shopify outgoing webhook

$input = file_get_contents("php://input");

// Get all headers from the request
$headers = getallheaders();

//check to match the header
foreach ($headers as $name => $value) {
    if( $name === 'x-shopify-topic' && $value === 'customers/create' ){
    echo "$name: $value <br>";
    echo "Header matched";
    }
}

//Zoho access token
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://accounts.zoho.com/oauth/v2/token?refresh_token=1000.311bf0a489da22cef6656eb5c169d561.dd939799ac861b343595b779562d2cc2&client_id=1000.VHW2SHWSUT3H71G73IBHIQW9RHUKEI&client_secret=a4da6d57c7b2efec6f2ab70c994e54d66b9275961b&grant_type=refresh_token',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_HTTPHEADER => array(
    'Cookie: stk=b4d0981c42f4f9d4cbfcf535e0aead7d; JSESSIONID=A3C517A465F2478FEAB59FEAC83F4130; _zcsr_tmp=ea59dba0-1a28-4dde-9876-5b5d91e5b632; b266a5bf57=a7f15cb1555106de5ac96d088b72e7c8; e188bc05fe=8db261d30d9c85a68e92e4f91ec8079a; iamcsr=ea59dba0-1a28-4dde-9876-5b5d91e5b632'
  ),
));

$token = curl_exec($curl);
$access_token = json_decode($token, true);
$gettoken = $access_token['access_token']; 
//echo $gettoken;
curl_close($curl);

//use the input data from the post request
$dataArray = json_decode($input, true);

$customer_id = $dataArray['id'];
//echo $customer_id;
$email = $dataArray['email'];
$fname = $dataArray['first_name'];
$lname = $dataArray['last_name'];
$total = $dataArray['total_spent'];
$note = $dataArray['note'];
$currency = $dataArray['currency'];
$phone = $dataArray['phone'];
$address = $dataArray['addresses'];
$email_consent = $dataArray['email_marketing_consent'];
$sms_consent = $dataArray['sms_marketing_consent'];

$dynamicData = array(
    "data" => array(
        array(
            "Company" => "Earthly Comfort", 
            "Last_Name" => $lname,
            "First_Name" => $fname,
            "Email" => $email,
            "shopifyextension__Lead_Shopify_Id" => "$customer_id", 
            "State" => ""
            
        )
    ),
    "trigger" => array(
        "approval",
        "workflow",
        "blueprint"
    )
);

// Convert the dynamic data array to JSON
$jsonData = json_encode($dynamicData, true);

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://www.zohoapis.com/crm/v2/leads',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $jsonData,  
    CURLOPT_HTTPHEADER => array(
        'Authorization: Zoho-oauthtoken ' . $gettoken,
        'Content-Type: application/json',
        'Cookie: 1a99390653=1e68a5d03bce7cc70d75c24f75e25abf; 1ccad04dca=b13f29b80337275633ee296dd14e08be; JSESSIONID=DD1F450B072F44C87526836CD5C749D2; _zcsr_tmp=162b23e1-abef-499b-9043-3fa9733e8b4f; crmcsr=162b23e1-abef-499b-9043-3fa9733e8b4f'
    ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

?>