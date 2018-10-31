<?php
require("utility.php");
/**
 * function valueOf() is to calculate the total value of share money and return the amount 
 * 
 * @return double total amount of all share
 */
function valueOf()
{
    //to hold total value
    $total = 0;
    //read file data and the decode into json hand save in array
    $arr = json_decode(file_get_contents("stockAcount.json"), true);
    //get amount of every share
    foreach ($arr as $key) {
        $total += $key['totalPrice'];
    }
    return $total;
}

/**
 * function buy is for buy share it take amount and share name add to the list of
 * user account
 * 
 * @param $amount amount of share user want to buy
 * @param $symbol company symbol
 */
function buy($amount, $symbol)
{
    //get share file data into array
    $arr = json_decode(file_get_contents("stockAccountShareFile.json"), true);
    //get user acount data into array
    $stockAcount = json_decode(file_get_contents("stockAcount.json"), true);
    //detail we want to store into user account
    $stock = array("ShareName" => "", "symbol" => "", "shareNumber" => 0, "totalPrice" => 0, "date" => "", "time" => "");
    $b = false;
    foreach ($arr['list'] as $key) {
        if ($key['symbol'] == $symbol) {
            $i = 0;
            foreach ($stockAcount as $uKey) {
                if ($uKey['symbol'] == $symbol) {
                   
                    //number of share  
                    $stockAcount[$i]['shareNumber'] += $amount / $key['sharePrice'];
                    $stockAcount[$i]['totalPrice'] += $amount;
                    $stockAcount[$i]['date'] = date("d/m/Y");
                    $stockAcount[$i]['time'] = date("h:i:s");
                    save($stockAcount);
                    transaction($stockAcount[$i]['ShareName'], $amount, $symbol, "buy");
                    echo "successfully purchase...\n";
                    return $stockAcount;
                }
                $i++;
            }
            $b = true;
            $stock['ShareName'] = $key['ShareName'];
            $stock['symbol'] = $key['symbol'];
            //number of share  
            $stock['shareNumber'] = $amount / $key['sharePrice'];
            $stock['totalPrice'] = $amount;
            $stock['date'] = date("d/m/Y");
            $stock['time'] = date("h:i:s");
            array_push($stockAcount, $stock);
            save($stockAcount);
            transaction($key['ShareName'], $amount, $symbol, "buy");
            echo "successfully purchase...\n";
            return $stockAcount;
        }
    }
    if (!$b) {
        echo "no share found by " . $symbol . "\n";
    }
}

function sell($amount, $symbol)
{
    //get user acount data into array
    $stockAcount = json_decode(file_get_contents("stockAcount.json"), true);
    $i = 0;
    foreach ($stockAcount as $key) {
        if ($key['symbol'] == $symbol) {
            if ($key['totalPrice'] < $amount) {
                echo "ur current balance is " . $key['totalPrice'] . "\n";
                return;
            } elseif ($key['totalPrice'] == $amount) {
                unset($stockAcount[$i]);
                save($stockAcount);
                transaction($key['ShareName'], $amount, $symbol, "sell");
                echo "sell successfully...\n";
                return;
            }
            $stockAcount[$i]['shareNumber'] -= ($amount / ($key['totalPrice'] / $key['shareNumber']));
            $stockAcount[$i]['totalPrice'] -= $amount;
            $stockAcount[$i]['date'] = date("d/m/Y");
            $stockAcount[$i]['time'] = date("h:i:s");
            save($stockAcount);
            transaction($stockAcount[$i]['ShareName'], $amount, $symbol, "sell");
            echo "sell successfully...\n";
            return;
        }
        $i++;
    }
    echo "no data found\n";

}

function save($file)
{
    echo "press\n1. save data in file\n <<else any number>>\n";
    if (Utility::getInt() == 1) {
        Utility::writeFl(json_encode($file), "stockAcount.json");
        echo "data saved\n";
    }
}

function printReport()
{
    //get user acount data into array
    $stockAcount = json_decode(Utility::readFl("stockAcount.json"), true);
    echo "stockName  stockUnit totalPrice date       time\n";
    foreach ($stockAcount as $key) {
        echo sprintf("%-11s%-10u%-11u%-11s%-11s", $key['ShareName'], $key['shareNumber'], $key['totalPrice'], $key['date'], $key['time']) . "\n";
    }

}

function transaction($stockname, $amount, $symbol, $bs)
{
    //json_decode(file_get_contents("stockAcount.json"), true);
    $arr = json_decode(file_get_contents("stockAccountTList.json"), true);
    $stock = array("buyOrSell" => "", "ShareName" => "", "amount" => 0, "date" => "", "time" => "");
    $stock['buyOrSell'] = $bs;
    $stock['ShareName'] = $stockname;
    $stock['symbol'] = $symbol;
    $stock['amount'] = $amount;
    $stock['date'] = date("d/m/Y");
    $stock['time'] = date("h:i:s");

    array_push($arr, $stock);
    Utility::writeFl(json_encode($arr), "stockAccountTList.json");
    echo "transaction detail saved\n";
}

function main()
{
    $n = 1;
    while ($n != 5) {
        echo "press\n1. total value\n2. buy share\n3. sell share\n4. print report\n5. exit\n";
        $n = Utility::getInt();
        switch ($n) {
            case 1:
                echo valueOf() . "\n";
                break;
            case 2:
            //get share file data into array
                $arr = json_decode(file_get_contents("stockAccountShareFile.json"), true);
                echo "<stocks>  <symbol>\n";
                foreach ($arr['list'] as $key) {
                    echo sprintf("%-11s%-6s", $key['ShareName'], $key['symbol']) . "\n";
                }
                echo "\nenter stock symbol\n";
                $symbol = trim(fgets(STDIN));
                echo "enter amount\n";
                $amount = Utility::getInt();
                buy($amount, $symbol);
                break;
            case 3:
                echo "enter share symbol\n";
                $symbol = trim(fgets(STDIN));
                echo "enter amount\n";
                $amount = Utility::getInt();
                sell($amount, $symbol);
                break;
            case 4:
                printReport();
                break;
            default:
                if ($n != 5) {
                    echo "invalid input\n";
                }
                break;
        }
    }
}
//main();
?>