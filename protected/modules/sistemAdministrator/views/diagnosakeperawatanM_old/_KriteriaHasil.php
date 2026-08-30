<?php
$modKriteriaHasil=  KriteriahasilM::model()->findAll('diagnosakeperawatan_id='.$diagnosakeperawatan_id.'');
if(count((array)$modKriteriaHasil)>0)
    {
        echo "<ul>";
        foreach($modKriteriaHasil as $i=>$namaKriteria)
        {
            echo '<li>'.$namaKriteria->kriteriahasil_nama.'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo "Belum di Set";
    }   
?>

