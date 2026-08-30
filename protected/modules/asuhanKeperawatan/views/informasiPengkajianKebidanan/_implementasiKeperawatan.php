<?php
$modImplementasiKeperawatan = ASImplementasiaskepT::model()->with('implementasikeperawatan')->findAllByAttributes(array('asuhankeperawatan_id'=>$asuhankeperawatan_id));

if(COUNT($modImplementasiKeperawatan)>0)
    {
        echo "<ul>";
        foreach($modImplementasiKeperawatan as $i=>$row)
        {
            echo '<li>'.$row->implementasikeperawatan->implementasi_nama.'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo "-";
    }   
?>

