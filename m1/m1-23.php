<?php
    $items = array("Ken","Alice","Judy","BOSS","Bob");
    foreach($items as $person){
        if($person=="BOSS"){
            echo "Good morning $person!<br>";
        }else{
            echo "Hi! $person<br>";
        }
    }
?>