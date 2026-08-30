<?php
$modMasukPenunjang = RJPasienMasukPenunjangT::model()->with('ruangan')->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
$jumlah = count((array)$modMasukPenunjang);
foreach($modMasukPenunjang as $row){
        $result .= "".CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl("daftarPasien/detailHasilLab",array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"pesan","rel"=>"tooltip","title"=>"Klik untuk Detail Hasil Pemeriksaan '".$row->ruangan->ruangan_nama."'", "onclick"=>"window.parent.$('#dialogDetailHasilLab').dialog('open');"));
}
echo $result;
?>