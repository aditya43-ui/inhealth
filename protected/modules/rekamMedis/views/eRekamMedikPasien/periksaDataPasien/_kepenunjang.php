<?php
$result = "";
$modMasukPenunjang = PasienmasukpenunjangV::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
$jumlah = count((array)$modMasukPenunjang);
foreach($modMasukPenunjang as $row){
        $nama = "";
        $login = LoginpemakaiK::model()->findByPk($row->create_loginpemakai_id);
        if (!empty($login->pegawai)) {
            $nama = $login->pegawai->namaLengkap;
        } else {
            $nama = $login->nama_pemakai;
        }
        $ada = true;
        $subresult = '<li>';
        
        $nama = trim($nama);
        
        $modHasilLab = HasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$row->pasienmasukpenunjang_id));
        $modHasilRad = HasilpemeriksaanradT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$row->pasienmasukpenunjang_id));
        $modHasilRehab = HasilpemeriksaanrmT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$row->pasienmasukpenunjang_id));
        $modAsesmenGizi = AsesmengiziT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$row->pasienmasukpenunjang_id), array(
            'order'=>'asesmengizi_id desc'
        ));
        
        if($modHasilLab){ //cek jika sudah ada hasil lab
            $subresult .= "".CHtml::link("<i class='icon-list-alt'></i> ".$row->ruangan_nama.'<br>('.$nama.')',Yii::app()->controller->createUrl("detailHasilLab",array("pendaftaran_id"=>$row->pendaftaran_id, "pasien_id"=>$row->pasien_id,"pasienmasukpenunjang_id"=>$row->pasienmasukpenunjang_id)),array("id"=>"$row->no_pendaftaran","target"=>"pesan","rel"=>"tooltip","title"=>"Klik untuk Detail Hasil Pemeriksaan '".$row->ruangan_nama."'", "onclick"=>"window.parent.$('#dialogDetailHasilLab').dialog('open');"))."<br>";
        } else if($modHasilRad){ //jika radiologi
            $subresult .= "".CHtml::link("<i class='icon-list-alt'></i> ".$row->ruangan_nama.'<br>('.$nama.')',Yii::app()->controller->createUrl("detailHasilRad",array("pendaftaran_id"=>$row->pendaftaran_id, "pasien_id"=>$row->pasien_id,"pasienmasukpenunjang_id"=>$row->pasienmasukpenunjang_id)),array("id"=>"$row->no_pendaftaran","target"=>"pesan","rel"=>"tooltip","title"=>"Klik untuk Detail Hasil Pemeriksaan '".$row->ruangan_nama."'", "onclick"=>"window.parent.$('#dialogDetailHasilLab').dialog('open');"))."<br>";
        } else if($modHasilRehab) {
            $subresult .= "".CHtml::link("<i class='icon-list-alt'></i> ".$row->ruangan_nama.'<br>('.$nama.')',Yii::app()->controller->createUrl("detailHasilRehab",array("pendaftaran_id"=>$row->pendaftaran_id, "pasien_id"=>$row->pasien_id,"pasienmasukpenunjang_id"=>$row->pasienmasukpenunjang_id)),array("id"=>"$row->no_pendaftaran","target"=>"pesan","rel"=>"tooltip","title"=>"Klik untuk Detail Hasil Pemeriksaan '".$row->ruangan_nama."'", "onclick"=>"window.parent.$('#dialogDetailHasilLab').dialog('open');"))."<br>";
        } else if ($modAsesmenGizi) {
            if (!empty($modAsesmenGizi->ahligizi_id)) {
                $peg = PegawaiM::model()->findByPk($modAsesmenGizi->ahligizi_id);
                $nama = $peg->namaLengkap;
            } 
            
            $subresult .= "".CHtml::link("<i class='icon-list-alt'></i> ".$row->ruangan_nama.'<br>('.$nama.')',Yii::app()->controller->createUrl("detailHasilGizi",array("pendaftaran_id"=>$row->pendaftaran_id, "pasien_id"=>$row->pasien_id,"pasienmasukpenunjang_id"=>$row->pasienmasukpenunjang_id)),array("id"=>"$row->no_pendaftaran","target"=>"pesan","rel"=>"tooltip","title"=>"Klik untuk Detail Koonsultasi '".$row->ruangan_nama."'", "onclick"=>"window.parent.$('#dialogDetailHasilLab').dialog('open');"))."<br>";
        } else {
            $ada = false;
            $subresult .= "<br>";
        }
        
        
        $subresult .= '</li>';
        
        if ($ada) {
            $result .= $subresult;
        }
        
}
echo $result;
?>