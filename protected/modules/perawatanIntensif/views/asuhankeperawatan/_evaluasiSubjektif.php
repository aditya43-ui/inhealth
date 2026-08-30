<?php
$modEvaluasiSubjektif = RIAsuhankeperawatanT::model()->findByAttributes(array('asuhankeperawatan_id'=>$asuhankeperawatan_id));
if(count((array)$modEvaluasiSubjektif)>0)
    {
        echo $modEvaluasiSubjektif->evaluasi_subjektif;        
    }
else
    {
        echo "Tidak di Set";
    }   
?>

