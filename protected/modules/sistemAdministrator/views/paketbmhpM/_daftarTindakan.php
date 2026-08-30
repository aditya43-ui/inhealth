<?php
$modPaketBMHP= SAPaketbmhpM::model()->findAllByAttributes(array('tipepaket_id'=>$tipepaket_id));
if(count((array)$modPaketBMHP)>0)
    {
        echo "<ol>";
        foreach($modPaketBMHP as $i=>$row)
        {
            echo '<li>'.$row->daftartindakan->daftartindakan_nama.'</li>';
        }
        echo "</ol>";
    }
else
    {
        echo "Belum di Set";
    }   
?>

