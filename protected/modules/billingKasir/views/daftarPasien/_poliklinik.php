<?php
$ruangan = RuanganM::model()->findByPk($ruangan_id);
    if (count((array)$ruangan) > 0){
    		echo $ruangan->ruangan_nama;
    }else{
    	echo "-";
    }
?>