<?php
$modTanggunganPenjamin=  SATanggunganpenjaminM::model()->with('carabayar','kelaspelayanan')->findAllByAttributes(array('carabayar_id'=>$carabayar_id, 'kelaspelayanan_id'=>$kelaspelayanan_id));

if(count((array)$modTanggunganPenjamin)>0)
    {
        echo "<ul>";
        foreach($modTanggunganPenjamin as $i=>$row)
        {
            echo '<li>'.$row->penjamin->penjamin_nama.'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo "Belum di Set";
    }   
?>

