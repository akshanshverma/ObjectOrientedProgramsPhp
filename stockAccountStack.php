<?php
function getStockData()
{
    $stockAcount = json_decode(file_get_contents("stockAccountTList.json"), true);
    print_r($stockAcount);
    $j = sizeof($stockAcount)-1;
    echo "<symbol>  <type>\n";
    for ($i=sizeof($stockAcount)-1; $i >=0 ; $i--) { 
        echo sprintf("%-11s%-6s", $stockAcount[$j]['symbol'], $stockAcount[$j]['buyOrSell'])."\n";
        $j--;
    }
}
getStockData();
?>