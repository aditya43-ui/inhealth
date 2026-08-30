<?php
$modEvaluasiSubjektif = RJAsuhankeperawatanT::model()->findByAttributes(array('asuhankeperawatan_id'=>$asuhankeperawatan_id));
if(!empty($modEvaluasiSubjektif))
    {
        echo $modEvaluasiSubjektif->evaluasi_objektif;        
    }
else
    {
        echo "Tidak di Set";
    }   
?>

