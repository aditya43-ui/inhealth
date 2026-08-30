<?php
$result = "";
$modMasukPenunjang = PasienmasukpenunjangV::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
// var_dump($modMasukPenunjang);die;
$jumlah = count((array)$modMasukPenunjang);
foreach($modMasukPenunjang as $h => $row){
        $nama = "";
        $login = LoginpemakaiK::model()->findByPk($row->create_loginpemakai_id);
        if (!empty($login->pegawai)) {
            $nama = $login->pegawai->namaLengkap ?? "-";
        } else {
            $nama = $login->nama_pemakai ?? "-";
        }
        $ada = true;
        $subresult = '<li>';
        $nama = '';//trim($nama);nama_pemakai
        
        $modHasilLab = RJHasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$row->pasienmasukpenunjang_id));
        $modHasilRad = HasilpemeriksaanradT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$row->pasienmasukpenunjang_id));
        $modHasilRehab = HasilpemeriksaanrmT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$row->pasienmasukpenunjang_id));
        $modAsesmenGizi = AsesmengiziT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$row->pasienmasukpenunjang_id), array(
            'order'=>'asesmengizi_id desc'
        ));

        $nama_pemeriksaan = null;
        if (!empty($modHasilRad->pemeriksaanrad_id)){
            $hasilRad = PemeriksaanradM::model()->findByPk($modHasilRad->pemeriksaanrad_id);
            $nama_pemeriksaan = $hasilRad->pemeriksaanrad_nama ?? "";
            // var_dump($hasilRad);
        }
        
        if(!empty($modHasilLab)){ //cek jika sudah ada hasil lab
            $cri = new CDbCriteria;
            $cri->join = " JOIN pemeriksaanlab_m lab ON lab.pemeriksaanlab_id =  t.pemeriksaanlab_id ";
            $cri->group = $cri->select = " lab.pemeriksaanlab_nama ";            
            $cri->addCondition(" hasilpemeriksaanlab_id = ".$modHasilLab->hasilpemeriksaanlab_id);
            $load = DetailhasilpemeriksaanlabT::model()->findAll($cri);
            
            $namalab = '';
            if (!empty($load)){
                foreach($load as $i => $val){
                    if ($i+1 != count($load)){
                        $namalab .= $val->pemeriksaanlab_nama.', ';
                    }else{
                        $namalab .= $val->pemeriksaanlab_nama;
                    }
                }
            }
            // echo CHtml::link("<i class='icon-form-anamnesa'></i> ",  Yii::app()->controller->createUrl(
            //     "daftarPasien/detailAnamnesa",
            //     array("id" => $modKunjungan->pendaftaran_id)
            // ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Anamnesis", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Pelayanan/Anamnesis"));
            
            $subresult .= "".CHtml::link("<i class='icon-list-alt'></i> ".$namalab.' - '.$modHasilLab->tglhasilpemeriksaanlab.' - '.$row->ruangan_nama,Yii::app()->createUrl(
                "rawatJalan/daftarPasien/detailHasilLab",array("pendaftaran_id"=>$row->pendaftaran_id, "pasien_id"=>$row->pasien_id,"pasienmasukpenunjang_id"=>$row->pasienmasukpenunjang_id)),array("id"=>"$row->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Hasil Pemeriksaan '".$row->ruangan_nama."'", "onclick"=>"window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');"));
                
            if($h == 0) {
                // echo "i = $i";
            }
                // echo "<br>";
        } else if(!empty($modHasilRad)){ //jika radiologiz
            $subresult .= "".CHtml::link("<i class='icon-list-alt'></i> ".$nama_pemeriksaan.' - '.$modHasilRad->tglpemeriksaanrad ?? "".' - '.$row->ruangan_nama?? "".'<br>'. $nama_pemeriksaan,Yii::app()->createUrl(
                "rawatJalan/daftarPasien/detailHasilRad",array("pendaftaran_id"=>$row->pendaftaran_id, "pasien_id"=>$row->pasien_id,"pasienmasukpenunjang_id"=>$row->pasienmasukpenunjang_id)),array("id"=>"$row->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Hasil Pemeriksaan '".$row->ruangan_nama."'", "onclick"=>"window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');"))."<br>";
        } else if(!empty($modHasilRehab)) {
            $subresult .= "".CHtml::link("<i class='icon-list-alt'></i> ".$modHasilRehab->tindakanrm->tindakanrm_nama.' - '.$modHasilRehab->tglpemeriksaanrm.' - '.$row->ruangan_nama,Yii::app()->controller->createUrl("daftarPasien/detailHasilRehab",array("pendaftaran_id"=>$row->pendaftaran_id, "pasien_id"=>$row->pasien_id,"pasienmasukpenunjang_id"=>$row->pasienmasukpenunjang_id)),array("id"=>"$row->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Hasil Pemeriksaan '".$row->ruangan_nama."'", "onclick"=>"window.parent.$('#ui-dialog-title-dialogDetailData').dialog('open');"))."<br>";
        } else if (!empty($modAsesmenGizi)) {
            if (!empty($modAsesmenGizi->ahligizi_id)) {
                $peg = PegawaiM::model()->findByPk($modAsesmenGizi->ahligizi_id);
                $nama = $peg->namaLengkap;
            } 
            
            $subresult .= "".CHtml::link("<i class='icon-list-alt'></i> ".$modAsesmenGizi->diagnosa.' - '.$modAsesmenGizi->tgl_konsultasi.' - '.$row->ruangan_nama,Yii::app()->controller->createUrl("daftarPasien/detailHasilGizi",array("pendaftaran_id"=>$row->pendaftaran_id, "pasien_id"=>$row->pasien_id,"pasienmasukpenunjang_id"=>$row->pasienmasukpenunjang_id)),array("id"=>"$row->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Koonsultasi '".$row->ruangan_nama."'", "onclick"=>"window.parent.$('#ui-dialog-title-dialogDetailData').dialog('open');"))."<br>";
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