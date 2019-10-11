<?php
require __DIR__ . "/vendor/autoload.php";
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

function clean_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


function convertToShakespeare($englishTexts)
{
    //clean user data
  
    if ($englishTexts) {
       $englishTexts =  clean_input($englishTexts);
         try {
            $data = [
          'text' => $englishTexts
        ];
            $url = getenv("TRANSLATION_API_URL");
            $query_url = sprintf("%s?%s", $url, http_build_query($data));
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $query_url);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $result = curl_exec($curl);
            header('Content-type: application/json');
            $response = json_decode($result, true);
            if($response['success']['total'] === 1) {
              return $response['contents']['translated'];
            }
            curl_close($curl);
        } catch (exception $e) {
            print_r($e);
        }
    }
}