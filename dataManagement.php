<?php

/**
 * 
 * Purpose: to take value form user and save data into json file the get 
 * data from json file and calculate the values 
 *
 *  @author  Akshansh Verma
 *  @version 1.0
 *  @since   25-10-2018
 */
require("utility.php");
/**
 * get data from user and store the value in the array
 * 
 * @param $n number of item which user select 
 */
function getData($n)
{
    global $item;
    //array with keys
    $arr = array("name" => "", "weight" => 0, "priceKg" => 0);
    //switch case on the base of user input
    switch ($n) {
        //case 1 is for rice data store in the array
        case 1:
            $priceOfRice = 35;
            $arr["name"] = "rice";
            echo "weight\n";
            $w = Utility::getInt();
            $arr["weight"] = $w;
            $arr["priceKg"] = $priceOfRice;
            array_push($item, $arr);
            break;
        //case 2 is for pulses data store in the array
        case 2:
            $priceOfPulses = 60;
            $arr["name"] = "pulses";
            echo "weight\n";
            $w = Utility::getInt();
            $arr["weight"] = $w;
            $arr["priceKg"] = $priceOfPulses;
            array_push($item, $arr);
            break;
        //case 3 is for wheat data store in the array
        case 3:
            $priceOfWheat = 20;
            $arr["name"] = "wheat";
            echo "weight\n";
            $w = Utility::getInt();
            $arr["weight"] = $w;
            $arr["priceKg"] = $priceOfWheat;
            array_push($item, $arr);
            break;

        default:
            //echo "invalid input\n";
            break;
    }
}

/**
 * function saveData is to save data in the json file
 * 
 * @param $item array  to save data in json file
 */
function saveData($item)
{
    //$json object 
    $json['inventory'] = $item;
    $fp = fopen('dataManagement.json', 'w');
    //write to file
    fwrite($fp, json_encode($json));
    fclose($fp);
}

/**
 * function getJson is to get data from json file and decode data
 * 
 * @return array of json decoded data
 */
function getJson()
{
    //read file
    $fp = fopen('dataManagement.json', 'r');
    //get data in strig
    $str = fread($fp, filesize('dataManagement.json'));
    fclose($fp);
    //decode and return array
    return json_decode($str, true);
}

/**
 * function cal is to calculate the value of json file data
 * 
 * @param array of json file
 */
function cal($arr)
{
    //total value 
    $total = 0;
    foreach ($arr['inventory'] as $key) {
        echo "\n" . $key['name'] . " " . $key['weight'] * $key['priceKg'] . "Rs\n";
        //add each value
        $total += $key['weight'] * $key['priceKg'];
    }
    echo "\ntotal " . $total . "Rs";
}

//$array to hold item
$item = array();
$n = 0;
//get user input
while ($n < 4) {
    echo "select item\n1 rice\n2 pulses\n3 wheat\n4 exit\n";
    $n = Utility::getInt();
    getData($n);
}
//save data to json file
saveData($item);
//get data form json file and calculate the value of json file
cal(getJson());
?>