<?php
$modRencanaKeperawatan = RJIntervensiaskepT::model()->with('rencanakeperawatan')->findAllByAttributes(array('asuhankeperawatan_id'=>$asuhankeperawatan_id));

if(count((array)$modRencanaKeperawatan)>0)
    {
        echo "<ul>";
        foreach($modRencanaKeperawatan as $i=>$row)
        {
            echo '<li>'.$row->rencanakeperawatan->rencana_intervensi.'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo "Tidak di Set";
    }   
?>

