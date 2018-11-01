<?php
require("/home/pc/AkshanshPhp/AlgorithmPrograms/utility.php");
function dealing()
{
    $rank = array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14);
    $suit = array("Clubs", "Diamonds", "Hearts", "Spades");
    $check = array();
    $i = 0;
    $j = 0;
    $player = array(array(), array(), array(), array());
    while (sizeof($check) != 36) {
        $a = random_int(0, 3);
        $b = random_int(0, 12);
        $temp = ($rank[$b] . " " . $suit[$a]);
    //echo $temp."<<<\n";
        $u = array_search($temp, $check);

        if ($u === false) {
        //echo $u."<<<".$i." ".$j."\n" ;
            $player[$i++][$j] = array($rank[$b], $suit[$a]);
            array_push($check, $temp);

        }
        if ($i == 4) {
            $j++;
            $i = 0;
        }
    }
    return $player;
}

function printCard($player)
{
    $special = array("Jack", "Queen", "King", "Ace");
    //print_r($player);
    for ($i1 = 0; $i1 < 4; $i1++) {
        echo "player " . ($i1 + 1) . ": ";
        for ($j1 = 0; $j1 < 9; $j1++) {

            if ($player[$i1][$j1][0] == 11 || $player[$i1][$j1][0] == 12 || $player[$i1][$j1][0] == 13 || $player[$i1][$j1][0] == 14) {
                if ($player[$i1][$j1][0] == 11) {
                    $player[$i1][$j1][0] = $special[0];
                    echo $player[$i1][$j1][0]." ".$player[$i1][$j1][1].", ";
                } elseif ($player[$i1][$j1][1] == 12) {
                    $player[$i1][$j1][0] = $special[1];
                    echo $player[$i1][$j1][0]." ".$player[$i1][$j1][1].", ";
                } elseif ($player[$i1][$j1][0] == 13) {
                    $player[$i1][$j1][0] = $special[2];
                    echo $player[$i1][$j1][0]." ".$player[$i1][$j1][1].", ";
                } elseif ($player[$i1][$j1][0] == 14) {
                    $player[$i1][$j1][0] = $special[3];
                    echo $player[$i1][$j1][0]." ".$player[$i1][$j1][1].", ";
                }
            } else {
                echo $player[$i1][$j1][0]." ".$player[$i1][$j1][1]. ", ";
            }

        }
        echo "\n";
    }
}

function sortCard($player)
{
    for ($main = 0; $main < 4; $main++) {

        for ($i = 1; $i < sizeof($player[$main]); $i++) {
                //save the value of array index into temp
            $temp = $player[$main][$i];
                //$k to hold previous value 
            $k = $i - 1;
                //while loop until temp value is less then index value of array  or 0 index 
            while ($k >= 0 && $player[$main][$k][0] > $temp[0]) {
                //echo $player[$main][$k]."\n";
                    //swap the index 
                $player[$main][$k + 1] = $player[$main][$k];
                //echo $player[$main][$k + 1]."\n";
                $k--;
            }
                //after while loop get position of temp varible 
            $player[$main][$k + 1] = $temp;
        }

    }
    return $player;
}
printCard(sortCard(dealing()));
?>