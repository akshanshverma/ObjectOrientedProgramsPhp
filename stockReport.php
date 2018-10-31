<?php

/**
 * 
 * Purpose: to get the data of stock market market save in json file and
 * update data and print data
 *
 *  @author  Akshansh Verma
 *  @version 1.0
 *  @since   26-10-2018
 */
require("utility.php");
/**
 * function getStockData
 */
function getStockData($n)
{
    $stock['stock'] = array();
    for ($i = 0; $i < $n; $i++) {
        $tempArr = array('ShareName' => "", 'shareNumber' => 0, 'sharePrice' => 0);
        echo "enter Share Name \n";
        $name = trim(fgets(STDIN));
        $tempArr['ShareName'] = $name;
        echo "enter Number of Share \n";
        $tempArr['shareNumber'] = Utility::getInt();
        echo "enter Share Price\n";
        $tempArr['sharePrice'] = Utility::getInt();

        array_push($stock['stock'], $tempArr);
    }
    return $stock;
}

function update()
{
    echo "<<number of share u want to add>>\n";
    $update = getStockData(Utility::getInt());
    $toUpdate = json_decode(Utility::readFl("stockR.json"), true);
    foreach ($update['stock'] as $key) {
        array_push($toUpdate['stock'], $key);
    }
    return $toUpdate;
}
function write($arr)
{
    Utility::writeFl(json_encode($arr), "stockR.json");
}

function showRp()
{
    $data = json_decode(file_get_contents("stockR.json"), true);
    echo "stock name  stock price  total stock total price\n";
    foreach ($data['stock'] as $key) {
        echo sprintf("%-12s%-13u%-12u%-12u", $key['ShareName'], $key['shareNumber'], $key['sharePrice'], $key['shareNumber'] * $key['sharePrice']) . "\n";
    }

}

$n = 1;
while ($n == 1) {
    echo "press\n1 to creat new file\n2 update more share\n3 print report\n";
    $num = Utility::getInt();
    if ($num == 1) {
        echo "<<enter number of share>>\n";
        write(getStockData(Utility::getInt()));
    } elseif ($num == 2) {
        write(update());
    } elseif ($num == 3) {
        showRp();
    }
    echo "press 1 to continue\n";
    $n = Utility::getInt();
}
?>