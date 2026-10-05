<?php
$cadastro=[
    ["pessoa 1",  22],
    ["pessoa 2",  13],
    ["pessoa 3",  67]
];

$cadastro [1] [1]= 17;
foreach($cadastro as $teste){
    echo "nome:" . $teste [0] . "idade:" . $teste[1] . "<br>";
}
?>