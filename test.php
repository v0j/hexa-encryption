<?php
/**
 *  encryption of hexadecimal values
 */

// use basic encryption that outputs hexa decimal values
$hexa_test = md5('this is a test value1'); // outputs hexadecimal values
// TODO: inject a random 2 character salt that is within the charlist of encryptions
$salt = 'ab';
echo fc84(md5(fc84($hexa_test, $salt)), $salt);

/**
 * common function
 * function that converts large decimals into hexadecimals
 * @param $number - the decimals to convert into hexadecimals
 */
function dec2hex($number)
{
    $hexvalues = array('0','1','2','3','4','5','6','7',
               '8','9','A','B','C','D','E','F');
    $hexval = '';
     while($number != '0')
     {
        $hexval = $hexvalues[bcmod($number,'16')].$hexval;
        $number = bcdiv($number,'16',0);
    }
    return $hexval;
}

/**
 * common function
 * function that converts large hexadecimals into decimals
 * @param $number - the hexadecimal to convert into decimal
 */
function hex2dec($number)
{
    $decvalues = array('0' => '0', '1' => '1', '2' => '2',
               '3' => '3', '4' => '4', '5' => '5',
               '6' => '6', '7' => '7', '8' => '8',
               '9' => '9', 'A' => '10', 'B' => '11',
               'C' => '12', 'D' => '13', 'E' => '14',
               'F' => '15');
    $decval = '0';
    $number = strrev($number);
    for($i = 0; $i < strlen($number); $i++)
    {
        $decval = bcadd(bcmul(bcpow('16',$i,0),$decvalues[strtoupper($number{$i})]), $decval);
    }
    return $decval;
}

/**
 * common function
 * encrypts hexadecimal values to different charlist that you can defined
 * @param $hexadecimal - the hexadecimal to convert
 * @param $salt - the salt to inject into some the parts
 */
function fc84($hexadecimal, $salt = ''){

	$charlist = array('','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0','1','2','3','4','5','6','7','8','9','!','@','#','%','^','&','*','(',')','-','_','=','+','~',',','.',';',':','[',']','{','}');

    $charlist_length = count($charlist);
    $number = hex2dec($hexadecimal.md5($salt));

    $output = '';
    while($number != '0'){
        $output = $charlist[bcmod($number,(string)$charlist_length)].$output;
        $number = bcdiv($number,(string)$charlist_length,0);
    }

    // when adding salt
    if($salt){
       $output .= '$$'.$salt;
    }
    return $output;
}
