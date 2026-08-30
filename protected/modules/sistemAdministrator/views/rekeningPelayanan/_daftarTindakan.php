<?php
	$modDaftarTindakan=TindakanruanganM::model()->findAll('ruangan_id='.$ruangan_id.'');
	$modTarifTindakan = TariftindakanM::model()->findAllByAttributes(array('daftartindakan_id'=>$modDaftarTindakan[0]->daftartindakan_id));
if(count((array)$modDaftarTindakan)>0)
    {   
        echo "<ul>"; 
        foreach($modDaftarTindakan as $i=>$tindakan)
        {
            echo "<li>".$tindakan->daftartindakan->daftartindakan_nama.'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo Yii::t('zii','Not set'); 
    }   
?>
<br><br>
<legend class=rim> Daftar Nominal Tarif </legend>
<table class=table table-striped table-bordered table-condensed>
    <thead>
        <tr>
            <th>No.</th>
            <th>Kelas Pelayanan</th>
            <th>Nominal Tarif</th>
        </tr>
    </thead>
    <tbody>
<?php
    foreach($modTarifTindakan as $key=>$tarif){
        echo "<tr>";
        echo "<td>".($key+1)."</td>";
        echo "<td>".$tarif->kelaspelayanan->kelaspelayanan_nama."</td>";
        echo "<td>".$tarif->harga_tariftindakan."</td>";
        echo "</tr>";
    }
?>
    </tbody>
</table>