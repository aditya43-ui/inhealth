<?php
$modTindakanPelayanan= SAPaketpelayananM::model()->with('daftartindakan')->findAllByAttributes(array('tipepaket_id'=>$tipepaket_id));
if(count((array)$modTindakanPelayanan)>0)
{
    $res = array();
    foreach ($modTindakanPelayanan as $item) {
        $idx = 0;
        $nama = "Lain-lain";
        $r = RuanganM::model()->findByPk($item->ruangan_id);
        
        if (!empty($r)) {
            $idx = $item->ruangan_id;
            $nama = $r->ruangan_nama;
        }
        
        
        
        if (empty($res[$idx])) {
            $res[$idx] = array(
                'nama'=>$nama,
                'detail'=>array(),
            );
        }
        $res[$idx]['detail'][] = $item;
    }
    
    foreach ($res as $item) {
        echo "<b>".$item['nama']."</b><br>";
        echo "<ul>";
        foreach($item['detail'] as $i=>$row)
        {
            echo '<li>'.$row->daftartindakan->daftartindakan_nama.'</li>';
        }
        echo "</ul>";
    }


}else
{
	echo "Belum di Set";
}
?>
