<?php

require_once  'vendor/autoload.php';

$params = array (
   
     'id' => '165714',
     'membershipYear' => '2022'
);

$members = new Salsan\Members\Query($params);

// $total = $members->getNumber();

// echo $total['rookie'];

$members = $members->getList();

// print_r($members);

$test = array(
     "123456" => [
         "name" => 'SANTAGATI SALVATORE',
         "age" => "100",
     ]
 );
$name = htmlentities("SANTAGATI SALVATORE");
// https://stackoverflow.com/a/11843479/1501286
$nameUTF8 = $members[165714]["name"];

echo "COMPARE STRING";
echo strcmp($name, $nameUTF8).PHP_EOL;
echo $nameUTF8. " - ".  strlen($nameUTF8) . PHP_EOL;
echo "ENCODING - ";
echo mb_detect_encoding($nameUTF8).PHP_EOL;
var_dump(bin2hex($nameUTF8)).PHP_EOL;
echo base64_encode($nameUTF8);
echo PHP_EOL;
var_dump(iconv_get_encoding('all'));

echo $name . " - " . strlen($name). PHP_EOL;
echo "ENCODING - ";
echo mb_detect_encoding($name);
var_dump(bin2hex($name));
echo base64_encode($name);

$string = "SANTAGATI SALVATORE";

$stringUTF8 = mb_convert_encoding($string, 'UTF-8', mb_detect_encoding($string));

echo mb_detect_encoding($string).PHP_EOL;
echo mb_detect_encoding($stringUTF8).PHP_EOL;
echo strcmp($string, $stringUTF8).PHP_EOL;

// echo setlocale(LC_CTYPE, 0);


// https://www.federscacchi.it/str_tess.php?id=&cgn=Santagati&gen=&an1=&an2=&cat=&pro=&reg=&socpro=&socreg=&cir=&anno=2022&tiptes=&ord=&senso=&ric=1
// https://www.federscacchi.it/str_tess.php?id=&cgn=Santagati&gen=&an1=&an2=&cat=&pro=&reg=&socpro=&socreg=&cir=&anno=2023&tiptes=&ord=2&senso=asc&ric=1
// https://www.federscacchi.it/str_tess.php?id=&cgn=Santagati&gen=&an1=&an2=&cat=&pro=&reg=&socpro=&socreg=&cir=&anno=&tiptes=&ord=2=&senso=&ric=1


// http://www.federscacchi.it/str_tess.php?codice=15101&anno=2023




        // Add comments parameters
        // Add COmment like this https://stackoverflow.com/a/36789970/1501286
