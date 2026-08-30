<?php
$criteria =new CDbCriteria();
if(!empty($asuhankeperawatan_id)){
	$criteria->addCondition("asuhankeperawatan_id = ".$asuhankeperawatan_id); 	
}
$criteria->addCondition('intervensilanjutan is NULL');
$modKolaborasiLanjutan = RIPlaningaskepT::model()->findAll($criteria);

if(count((array)$modKolaborasiLanjutan)>0)
    {
        echo "<ul>";
        foreach($modKolaborasiLanjutan as $i=>$row)
        {
            echo '<li>'.$row->kolaborasilanjutan.'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo "Tidak di Set";
    }   
?>

