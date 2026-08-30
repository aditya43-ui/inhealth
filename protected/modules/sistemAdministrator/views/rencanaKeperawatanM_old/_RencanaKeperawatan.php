<?php
$Rencana= SARencanaKeperawatanM::model()->with('rencanakeperawatan')->findByPk($diagnosakeperawatan_id)->rencana_kode;
$modRencana = SARencanaKeperawatanM::model()->findAllByAttributes(array('rencana_kode'=>$Rencana));
if(count((array)$modRencana)>0)
    {
        echo "<ul>";
        foreach($modRencana as $i=>$rencana_kode)
        {
            echo '<li>'.$rencana_kode->rencanakeperawatan->rencana_kode.'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo "Belum di Set";
    }   
?>

