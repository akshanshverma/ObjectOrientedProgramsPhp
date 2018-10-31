<?php

$rank = array("2", "3", "4", "5", "6", "7", "8", "9", "10", "jack", "queen", "king", "ace");
$suit = array("clubs" => $rank, "diamonds" => $rank, "hearts" => $rank, "spades" => $rank);
$check = array("clubs", "diamonds", "hearts", "spades");



$player = array(array(), array(), array(), array());
//echo sizeof($suit[$check[2]]);
for ($i = 0; $i < 9; $i++) {
    for ($j = 0; $j < 4; $j++) {
        //if (sizeof($suit['clubs']) == 0 || sizeof($suit['diamonds']) == 0 || sizeof($suit['hearts']) == 0 || sizeof($suit['spades']) == 0)
        //{
            foreach ($suit as $key) {
                if (sizeof($key) == 0) {
                    unset($key);
                }
            }

        //}
        $a = random_int(0, sizeof($suit) - 1);
        $b = random_int(0, sizeof($suit[$check[$a]]) - 1);

        $player[$j][$i] = $suit[$check[$a]][$b] . " " . $check[$a];
        array_splice($suit[$check[$a]], $b, 1);

    }
}
for ($i = 0; $i < 4; $i++) {
    echo "player " . ($i + 1) . ": ";
    for ($j = 0; $j < 9; $j++) {
        echo $player[$i][$j] . ", ";
    }
    echo "\n";
}

?>