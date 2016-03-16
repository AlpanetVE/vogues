<?php
$var = '1234567891234567891234';
echo "Original: $var<hr />\n";
   
 $var =substr_replace("$var","-",4,0);
 $var =substr_replace("$var","-",9,0);
echo substr_replace("$var","-",12,0);


?>