<?php

require_once("stockAccount.php");


function add()
{
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
}

function remove()
{
    $stockAcount = json_decode(file_get_contents("stockAcount.json"), true);
    echo "<stocks>  <symbol>\n";
    foreach ($stockAcount as $key) {
        echo sprintf("%-11s%-6s", $key['ShareName'], $key['symbol']) . "\n";
    }
    echo "enter symbol to remove data\n";
    $symbol = trim(fgets(STDIN));
    $i = 0;
    foreach ($stockAcount as $key) {
        if ($key['symbol'] == $symbol) {
            unset($stockAcount[$i]);
            Utility::writeFl(json_encode($stockAcount), "stockAcount.json");
            echo "data removed\n";
            return;
        }
        $i++;
    }
    echo "no data found\n";
}

function mainll()
{
    $n = 1;
    while ($n != 4) {
        echo "press\n1. add share\n2. remove share\n3. show list\n4. exit\n";
        $n = Utility::getInt();
        switch ($n) {
            case 1:
                add();
                break;
            case 2:
                remove();
                break;
            case 3:
                printReport();
                break;
            default:
                if ($n != 4) {
                    echo "invalid input\n";
                }
                break;
        }
    }
}
mainll();


?>