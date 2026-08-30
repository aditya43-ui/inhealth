<?php 
$module = '/'.$this->module->id;
$instalasi_id=Yii::app()->user->getState('instalasi_id');
$namaInstalasi = InstalasiM::model()->findByPk($instalasi_id);
$modInstalasi = InstalasiM::model()->findByPk(Yii::app()->user->getState("instalasi_id"));
$init = $modInstalasi->instalasi_singkatan;
$is_pulang = $modPendaftaran->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG;

$loginpemakai = Yii::app()->user->id;
$criteria = new CDbCriteria;
$criteria->addCondition('loginpemakai_id = ' . $loginpemakai);
$pegawai = LoginpemakaiK::model()->find($criteria);
$kelPegawai = PegawaiM::model()->findByPk($pegawai->pegawai_id);

// $cri = new CDbCriteria();
// $cri->addCondition('pegawai_id = '.Yii::app()->user->getState('pegawai_id'));
// $cri->addCondition('pegawai_aktif is true');
// $cri->addCondition("kelompokpegawai_id = '".Yii::app()->user->getState("kelompokpegawai_id")."'");
// $modPegawai = PegawaiM::model()->find($cri); 


// $cri2 = new CDbCriteria();
// $cri2->addCondition('pegawai_id = '.Yii::app()->user->getState('pegawai_id'));
// $cri2->addCondition('pegawai_aktif is true');
// $cri2->addCondition("kelompokpegawai_id = '2'");
// $modPegawai2 = PegawaiM::model()->find($cri2); 

$showTab1; $showTab2; $showTab3; $showTab4; $showTab5; $showTab6; $showTab7; $showTab8; $showTab9; $showTab10; $showTab11; $showTab12; $showTab13; $showTab14; $showTab15; $showTab16; $showTab17; $showTab18; $showTab19; $showTab20; $showTab21; 

$showTab1 =  $showTab2 =  $showTab3 =  $showTab4 =  $showTab5 =  $showTab6 = $showTab7 =  $showTab8 = $showTab9 = $showTab10 = $showTab11 = $showTab12 =  $showTab13 = $showTab14 = $showTab15 = $showTab16 = $showTab17 = $showTab18 = $showTab19 = $showTab20 = $showTab21 = 'none';

if ((!empty($kelPegawai->loginpemakai_id == Yii::app()->user->getState('loginpemakai_id')) && !empty($kelPegawai->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN))) {
  $showTab21 = $showTab7 = $showTab4 = $showTab5 = $showTab6 = $showTab10 = $showTab11 = $showTab1 =$showTab3 = $showTab2 = $showTab12 = $showTab9 = $showTab14 = $showTab13 = $showTab20 = 'block'; 
} else if ((!empty($kelPegawai->loginpemakai_id == Yii::app()->user->getState('loginpemakai_id')) && !empty($kelPegawai->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP))) {
  $showTab1 = $showTab2 = $showTab21 = $showTab3 = $showTab4 = $showTab5 = $showTab6 = $showTab7 = $showTab8 = $showTab9 = $showTab10 = $showTab11 = $showTab13 = $showTab15 = $showTab19 = $showTab20 = 'block';
}
  else {
  $showTab1 = $showTab2 = $showTab21 = $showTab3 = $showTab4 = $showTab5 = $showTab6 = $showTab7 =  $showTab8 = $showTab9 = $showTab8 = $showTab14 = $showTab10  = $showTab12 = $showTab13 = $showTab15 = $showTab16 = $showTab18 = $showTab19 = $showTab20 = 'block';
}


$klinik_gigi = Yii::app()->user->getState('klinikgigi_id');
$ruangan = RuanganM::model()->findByAttributes(array(
    'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
    'is_jiwa'=>true,
));

if (!empty($klinik_gigi) && trim($klinik_gigi) != "" && in_array(Yii::app()->user->getState('ruangan_id'), explode(",", $klinik_gigi))) {
  $menu_list = array_merge($menu_list, array(
      array('label'=>'Odontogram', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/periksaGigi/index&frame=1')),
      array('label'=>'Rongga Mulut', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/periksaRonggaMulut/index&frame=1')),
  ));
}
// if (!empty(Yii::app()->user->getState('is_jiwa')) && Yii::app()->user->getState('is_jiwa') == true) {
//     $menu_list = array_merge($menu_list, array(
//         array('label'=>'Keperawatan Jiwa', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/keperawatanJiwa/index')),
//     ));
// }


$this->widget('bootstrap.widgets.BootMenu', array(
  'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
  'stacked'=>false, // whether this is a stacked menu
  'items'=>array(
     array('label'=>'Diagnosis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab1,'onclick'=>'setTab(this);', 'tab'=>'/rawatJalan/diagnosaNew/index')),
     array('label'=>'Anamnesis Keperawatan (S)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab2,'onclick'=>'setTab(this);', 'tab'=>'rawatJalan/anamnesa/index')),
     array('label'=>'Anamnesis Medis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab21,'onclick'=>'setTab(this);', 'tab'=>$module.'/anamnesaMedis/index')),
     array('label'=>'Periksa Fisik Awal (O)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab3,'onclick'=>'setTab(this);', 'tab'=>$module.'/pemeriksaanFisik/index')),
     array('label'=>'Reseptur (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab4,'onclick'=>'setTab(this);', 'tab'=>'rawatJalan/reseptur/index')),
     array('label'=>'Laboratorium (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab5,'onclick'=>'setTab(this);', 'tab'=>'rawatJalan/laboratorium/index')),
     array('label'=>'Patologi Anatomi (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab6,'onclick'=>'setTab(this);', 'tab'=>'rawatJalan/patologiAnatomiTRJ/index')),
     array('label'=>'Mikrobiologi Klinik', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab7,'onclick'=>'setTab(this);', 'tab'=>'rawatJalan/mikrobiologiKlinik/index')),
     array('label'=>'Radiologi (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab8,'onclick'=>'setTab(this);', 'tab'=>'/rawatJalan/radiologiNew/index')),
     array('label' => 'Catatan Perkembangan Pasien Terintegrasi', 'url' => 'javascript:void(0);', 'itemOptions' => array('style'=>'display: '.$showTab9,'onclick'=>'setTab(this);', 'tab' =>'/rekamMedis/CPPTRK/index')),
     array('label'=>'Konsultasi Dokter Lain', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab10,'onclick'=>'setTab(this);', 'tab'=>'rawatJalan/konsulPoli/index')),
     array('label'=>'Rujuk Bedah Sentral', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab11,'onclick'=>'setTab(this);', 'tab'=>'rawatJalan/bedahSentralNew/index')),
     array('label'=>'Tindakan (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: ','onclick'=>'setTab(this);', 'tab'=>'tindakan/tindakan/index')),        
     array('label'=>'Surat Keterangan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab13,'onclick'=>'setTab(this);', 'tab'=>$module.'/SuratKeteranganTRJ/suratKeterangan')),
      $is_pulang ? null : array('label'=>'Rujukan Ke Luar', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab14,'onclick'=>'setTab(this);', 'tab'=>$module.'/rujukanKeluar/index')),        
    array('label'=>'Surat Perintah Rawat Inap', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab15,'onclick'=>'setTab(this);', 'tab'=>$module.'/suratPerintahRawatInap/index')),
    array('label'=>'Rujuk Rehab Medis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab16,'onclick'=>'setTab(this);', 'tab'=>$module.'/rehabMedis/index')),
     $is_pulang ? null : array('label'=>'Konsultasi Gizi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab17,'onclick'=>'setTab(this);', 'tab'=>$module.'/konsulGizi/index')),
     $is_pulang ? null : array('label'=>'Rujuk Bedah Sentral', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab18,'onclick'=>'setTab(this);', 'tab'=>'rawatJalan/bedahSentralNew/index')),
     array('label'=>'Ruangan Tindakan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab19,'onclick'=>'setTab(this);', 'tab'=>'/rawatJalan/ruangTindakan/index')),
     array('label'=>'Upload Dokumen Rekam Medis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab20,'onclick'=>'setTab(this);', 'tab'=> '/rekamMedis/ScanRM/Index')),
     array('label'=>'Permintaan Darah', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: block;', 'onclick'=>'setTab(this);', 'tab'=>'rawatJalan/PermintaanDarahDariPelayananTRJ/index&frame=1')),
     array('label'=>'Catatan Tindakan Dokter', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=> '/rawatJalan/catatanTindakan/index')), 
     //        array('label'=>'Surat Denda', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default', 'style'=>'display: '.$showTab14, 'onclick'=>'setTab(this);', 'tab'=>$this->getUrlSuratDenda())),
  ),
  'htmlOptions'=>[
    'id'=>'tab-periksa'
]
));


?>