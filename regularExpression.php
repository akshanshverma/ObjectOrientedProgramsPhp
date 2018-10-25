<?php
    /**
    * 
    * Purpose: to replace value of string with the help of regex
    *
    *  @author  Akshansh Verma
    *  @version 1.0
    *  @since   25-10-2018
    */
    $str = "Hello <<name>>, We have your full name as <<full name>> in our system. 
your contact number is 91-xxxxxxxxxx. Please,let us know in case of any clarification 
Thank you BridgeLabz xx/xx/xxxx.";
    //first name 
    echo "enter first name\n";
    $fName = trim(fgets(STDIN));
    //last name 
    echo "enter last name\n";
    $LName = trim(fgets(STDIN));
    //mobile number
    echo "enter mobile number\n";
    $number = trim(fgets(STDIN));
    //while loop until we get 10 digit number 
    while (strlen($number) != 10) {
        echo "enter valid mobile number\n";
        $number = trim(fgets(STDIN));
    }
    //date
    echo "enter date like xx/xx/xxxx\n";
    $date = trim(fgets(STDIN));

    //replace values
    $str = preg_replace("/\d{2}-x+/",$number,$str)."\n";
    $str = preg_replace("/<+\w+>+/",$fName,$str)."\n";
    $str = preg_replace("/<+\w+\s\w+>+/",$fName." ".$LName,$str)."\n";
    $str = preg_replace("/x+\/x+\/x+/",$date,$str);

    echo $str."\n";
?>  