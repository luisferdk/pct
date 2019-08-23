<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" dir="ltr">
  <head>
  <meta charset="utf-8">
</head>
<body>
<?php
$text = "ааЛаЕаКбаЕаЙ" ;
$text2 = "Andrew" ;
// mb_detect_order("cp1251, UTF-8"); //устанавливаем список кодировок
//        $enc=mb_detect_encoding($text); //узнаем кодировку
//        $text=iconv($enc, "UTF-8", $text); //перегоняем из cp в utf

//<option value="::ISO-8859-5" selected='selected'> Алексей </option>
//<option value=":UTF-8:ISO-8859-5"> Алексей </option>
//$str = iconv("KOI-8895-5", "Windows-1251", "ааЛаЕаКбаЕаЙ");
echo "UTF: ";
echo $text;
echo '<br>';
echo "Win to UTF: ";
echo (iconv("Windows-1251", "UTF-8", $text));
echo '<br>';
echo "UTF to ISO: ";
echo (iconv("UTF-8", "ISO-8859-5", $text));
echo '<br>';
echo "UTF to ISO: ";
echo (iconv("UTF-8", "ISO-8859-5", $text2));

echo '<br>';
echo "TRANSLIT: ";

var_dump(iconv("UTF-8", "ASCII//TRANSLIT//IGNORE", transliterator_transliterate('Any-Latin; Latin-ASCII',
    "A æ Übérmensch på høyeste nivå! И я люблю PHP! есть. аЃаЛббаНаОаВбаК")));

//echo (iconv("Windows-1251", "UTF", "ааЛаЕаКбаЕаЙ"));

        echo "<hr>Перекодировались? {$text}<hr>"; //да   
//echo (iconv("Windows-1251", "UTF", "ааЛаЕаКбаЕаЙ"));
//echo '<br>';
/*
echo( mb_convert_encoding('а?аЛаЕаКб?аЕаЙ', "Windows-1251"));
echo '<br>';
echo( mb_convert_encoding('а?аАб?аАаГб?аЗаИаН', "Windows-1251"));
echo '<br>';
echo( mb_convert_encoding('а?аИб?аОаВаА, 38-3', "CP1251"));
echo '<br>';
echo( mb_convert_encoding('аЃаЛб?б?аНаОаВб?аК', "CP1251"));
echo '<br>';
echo( mb_convert_encoding('а?аАб?аАаГб?аЗаИаН а?аЛаЕаКб?аЕаЙ', "CP1251"));
*/
/*
    [FIRSTNAME] => ааЛаЕаКбаЕаЙ
    [LASTNAME] => ааАбаАаГбаЗаИаН
    [SHIPTOSTREET] => ааИбаОаВаА, 38-3
    [SHIPTOCITY] => аЃаЛббаНаОаВбаК
    [SHIPTOZIP] => 432000
    [SHIPTOCOUNTRY] => RU
    [SHIPTONAME] => ааАбаАаГбаЗаИаН ааЛаЕаКбаЕаЙ
*/
?>
</body>
