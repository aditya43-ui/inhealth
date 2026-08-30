<?php
$modRencanaKeperawatan = ASIntervensiaskepT::model()->with('rencanakeperawatan')->findAllByAttributes(array('asuhankeperawatan_id'=>$asuhankeperawatan_id));

if(COUNT($modRencanaKeperawatan)>0)
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
        echo "-";
    }   
?>

