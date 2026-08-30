<?php
$criteria =new CDbCriteria();
if(!empty($asuhankeperawatan_id)){
	$criteria->addCondition("asuhankeperawatan_id = ".$asuhankeperawatan_id); 	
}
$criteria->addCondition('kolaborasilanjutan is NULL');
$modIntervensiLanjutan = ASPlaningaskepT::model()->findAll($criteria);

if(COUNT($modIntervensiLanjutan)>0)
    {
        echo "<ul>";
        foreach($modIntervensiLanjutan as $i=>$row)
        {
            echo '<li>'.$row->intervensilanjutan.'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo "-";
    }   
?>

