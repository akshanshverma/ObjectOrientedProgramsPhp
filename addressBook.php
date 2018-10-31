<?php
require("utility.php");
function validInt($int, $min, $max)
{
    while (filter_var($int, FILTER_VALIDATE_INT, array("options" => array("min_range" => $min, "max_range" => $max))) === false) {
        echo ("invalid input\n");
        echo "enter again : ";
        $int = Utility::getInt();
    }
    return $int;
}

function addAddress($fName, $lName, $address, $city, $state, $zip, $pNumber)
{
    $addressBook = json_decode(file_get_contents("addressBook.json"), true);
    $adDetail = array("firstname" => $fName, "lastName" => $lName, "address" => $address, "city" => $city, "state" => $state, "zip" => $zip, "pNumber" => $pNumber);
    array_push($addressBook, $adDetail);
    Utility::writeFl(json_encode($addressBook), "addressBook.json");
    echo "address data save\n";
}

function editAddress($fName, $lName)
{
    $addressBook = json_decode(file_get_contents("addressBook.json"), true);
    for ($i = 0; $i < sizeof($addressBook); $i++) {
        if ($addressBook[$i]['firstname'] == $fName && $addressBook[$i]['lastName'] == $lName) {
            echo "...address deatil...\naddress\n";
            $addressBook[$i]['address'] = trim(fgets(STDIN));
            echo "city\n";
            $addressBook[$i]['city'] = trim(fgets(STDIN));
            echo "state\n";
            $addressBook[$i]['state'] = trim(fgets(STDIN));
            echo "enter zip\n";
            $addressBook[$i]['zip'] = validInt(Utility::getInt(), 100000, 999999);
            echo "mobile number\n";
            $addressBook[$i]['pNumber'] = validInt(Utility::getInt(), 1000000000, 9999999999);
            echo "data save\n";
            Utility::writeFl(json_encode($addressBook), "addressBook.json");
            return;
        }
    }
    echo "no address found by name " . $fName . " " . $lName;
}

function remove($fName, $lName)
{
    $addressBook = json_decode(file_get_contents("addressBook.json"), true);
    $i = 0;
    foreach ($addressBook as $key) {
        if ($key['firstname'] == $fName && $key['lastName'] == $lName) {
            unset($addressBook[$i]);
            Utility::writeFl(json_encode($addressBook), "addressBook.json");
            echo "address deleted\n";
            return;
        }
        $i++;
    }
    echo "no data found to delete\n";
}

function sortAd($n)
{
    $addressBook = json_decode(file_get_contents("addressBook.json"), true);
    if ($n == 2) {
        for ($i = 1; $i < sizeof($addressBook); $i++) {
            //save the value of array index into temp
            $temp = $addressBook[$i];
            //$k to hold previous value 
            $k = $i - 1;
            //while loop until temp value is less then index value of array  or 0 index 
            while ($k >= 0 && $addressBook[$k]['zip'] > $temp['zip']) {
                //swap the index 
                $addressBook[$k + 1] = $addressBook[$k];
                $k--;
            }
            //after while loop get position of temp varible 
            $addressBook[$k + 1] = $temp;
            
        }   
        show($addressBook);
    } elseif ($n == 1) {
        for ($i = 1; $i < sizeof($addressBook); $i++) {
            //save the value of array index into temp
            $temp = $addressBook[$i];
            //$k to hold previous value 
            $k = $i - 1;
            //while loop until temp value is less then index value of array  or 0 index 
            while ($k >= 0 && $addressBook[$k]['firstname'] > $temp['firstname']  ) {
                //swap the index 
                $addressBook[$k + 1] = $addressBook[$k];
                $k--;
            }
            //after while loop get position of temp varible 
            $addressBook[$k + 1] = $temp;
            
        }
        show($addressBook);
    }else {
        echo "invalid input\n";
        main();
    }
}
function show($arr)
{
    foreach ($arr as $key) {
        echo "name: ".$key['firstname']." ".$key['lastName']."\n";
        echo "address: ".$key['address']."\n".$key['city']." ".$key['state']."\n";
        echo "zip: ".$key['zip']."\n";
        echo "number: ".$key['pNumber']."\n";
        echo "-------------------------------\n";
    }
}
function main()
{
    $n = 0;
    while ($n != 5) {
        echo "press\n1. add new address\n2. edit address\n3. remove address\n4. show address book\n5. exit\n";
        $n = Utility::getInt();
        switch ($n) {
            case 1:
                echo "enter first name\n";
                $fName = trim(fgets(STDIN));
                echo "enter last name\n";
                $lName = trim(fgets(STDIN));
                echo "enter address\n";
                $address = trim(fgets(STDIN));
                echo "enter city\n";
                $city = trim(fgets(STDIN));
                echo "enter state\n";
                $state = trim(fgets(STDIN));
                echo "enter zip code\n";
                $zip = validInt(Utility::getInt(), 100000, 999999);
                echo "enter mobile number\n";
                $pNumber = validInt(Utility::getInt(), 1000000000, 9999999999);
                addAddress($fName, $lName, $address, $city, $state, $zip, $pNumber);
                break;
            case 2:
                echo "enter first name\n";
                $fName = trim(fgets(STDIN));
                echo "enter last name\n";
                $lName = trim(fgets(STDIN));
                editAddress($fName, $lName);
                break;
            case 3:
                echo "enter first name\n";
                $fName = trim(fgets(STDIN));
                echo "enter last name\n";
                $lName = trim(fgets(STDIN));
                remove($fName, $lName);
                break;
            case 4:
                echo "press\n1. sort by name\n2. sort by zip\n";
                $s = Utility::getInt();
                sortAd($s);
                break;

            default:
                if($n != 5){
                    echo "invalid input\n";
                }
                break;
        }
    }
}
main();
?>