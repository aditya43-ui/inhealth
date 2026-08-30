<?php 
$module = '/'.$this->module->id;
$instalasi_id=Yii::app()->user->getState('instalasi_id');
$ruangan_id=Yii::app()->user->getState('ruangan_id');

$namaInstalasi = InstalasiM::model()->findByPk($instalasi_id);
$modInstalasi = InstalasiM::model()->findByPk(Yii::app()->user->getState("instalasi_id"));
$modruangan = RuanganM::model()->findByPk(Yii::app()->user->getState("ruangan_id"));
$init = $modInstalasi->instalasi_singkatan;
$is_pulang = $modPendaftaran->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG;

$loginpemakai = Yii::app()->user->id;
$criteria = new CDbCriteria;
$criteria->addCondition('loginpemakai_id = ' . $loginpemakai);
$pegawai = LoginpemakaiK::model()->find($criteria);
$kelPegawai = PegawaiM::model()->findByPk($pegawai->pegawai_id);
$kelPegawaippds = PpdsM:: model()->findByPk($pegawai->ppds_id);

$showTab1; $showTab2; $showTab2s; $showTab3; $showTab4; $showTab5; $showTab6; $showTab7; $showTab8; $showTab9; $showTab10; $showTab11; $showTab12; $showTab13; $showTab14; $showTab15; $showTab16; $showTab17; $showTab18; $showTab19; $showTab20; $showTab21; $showTab22; $showTabn; 
// var_dump($pegawai,$kelPegawaippds,Yii::app()->user->getState('loginpemakai_id'));die;
$showTab1 =  $showTab2 = $showTab2s = $showTab3 =  $showTab4 =  $showTab5 =  $showTab6 = $showTab7 =  $showTab8 = $showTab9 = $showTab10 = $showTab11 = $showTab12 =  $showTab13 = $showTab14 = $showTab15 = $showTab16 = $showTab17 = $showTab18 = $showTab19 = $showTab20 = $showTab21 = $showTab22 = $showTab23 = $showTabn = 'none';
if($kelPegawai !== null){
  if ((!empty($kelPegawai->loginpemakai_id == Yii::app()->user->getState('loginpemakai_id')) && !empty($kelPegawai->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN))) {
    $showTab1 = $showTab3 = $showTab2 = $showTab5 = $showTab6 = $showTab8 = $showTab7 = $showTab4 = $showTab12 = $showTab9 = $showTab10 = $showTab14 = $showTab13 = $showTab19 = $showTab20 = $showTab23 = 'block'; 
 } else if ((!empty($kelPegawai->loginpemakai_id == Yii::app()->user->getState('loginpemakai_id')) && !empty($kelPegawai->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP))) {
   $showTab1 = $showTab21 = $showTab2s = $showTab3 = $showTab4 = $showTab5 = $showTab6 = $showTab7 = $showTab8 = $showTab9 = $showTab10 = $showTab11 = $showTab12 = $showTab13 = $showTab15 = $showTab16 = $showTab19 = $showTab20 = $showTab22 = $showTab23 = 'block';
 }else if((!empty($pegawai->loginpemakai_id == Yii::app()->user->getState('loginpemakai_id'))) && !empty($modruangan->ruangan_id == Params::RUANGAN_ID_KLINIK_ANASTESI)){
  $showTab1 = $showTab2 = $showTab21 = $showTab3 = $showTab4 = $showTab5 = $showTab6 = $showTab7 =  $showTab8 = $showTab9 = $showTab11 = $showTab14 = $showTab10  = $showTab12 = $showTab13 = $showTab15 = $showTab16 = $showTab17  = $showTab19 = $showTab20  = $showTab22 = $showTab23 = $showTabn =  'block';
} 
 else {
   $showTab1 = $showTab2 = $showTab21 = $showTab3 = $showTab4 = $showTab5 = $showTab6 = $showTab7 =  $showTab8 = $showTab9 = $showTab11 = $showTab14 = $showTab10  = $showTab12 = $showTab13 = $showTab15 = $showTab16 = $showTab17  = $showTab19 = $showTab20  = $showTab22 = $showTab23 = $showTabn =  'block';
 }
}else{
// var_dump(!empty($pegawai->ppds_id ) && !empty($kelPegawaippds->kelompokpegawai_id));die;
  if (!empty($pegawai->ppds_id ) && !empty($kelPegawaippds->kelompokpegawai_id) ){
    if ((!empty($pegawai->loginpemakai_id == Yii::app()->user->getState('loginpemakai_id'))) && !empty($kelPegawaippds->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP)) {
     $showTab1 = $showTab21 = $showTab2s = $showTab3 = $showTab4 = $showTab5 = $showTab6 = $showTab7 = $showTab8 = $showTab9 = $showTab10 = $showTab11 = $showTab12 = $showTab13 = $showTab15 = $showTab16 = $showTab19 = $showTab20 = $showTab22 = $showTab23 = 'block';
   }else {
     $showTab1 = $showTab2 = $showTab21 = $showTab3 = $showTab4 = $showTab5 = $showTab6 = $showTab7 =  $showTab8 = $showTab9 = $showTab11 = $showTab14 = $showTab10  = $showTab12 = $showTab13 = $showTab15 = $showTab16 = $showTab17  = $showTab19 = $showTab20  = $showTab22 = $showTab23  = 'block';
   }
  }
  

}

$klinik_gigi = Yii::app()->user->getState('klinikgigi_id');

$ruangan = RuanganM::model()->findByAttributes(array(
  'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
  'is_jiwa'=>true,
));

$showGIGI = 'none';

if (!empty($klinik_gigi) && trim($klinik_gigi) != "" && in_array(Yii::app()->user->getState('ruangan_id'), explode(",", $klinik_gigi))) {
  $showGIGI = 'block';
}
// if (!empty(Yii::app()->user->getState('is_jiwa')) && Yii::app()->user->getState('is_jiwa') == true) {
//     $menu_list = array_merge($menu_list, array(
//         array('label'=>'Keperawatan Jiwa', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/keperawatanJiwa/index')),
//     ));
// }

// untuk cppt ada kondisi
$url = '/rekamMedis/CPPTRK/index';
if(Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_REHABMEDIS){
  $url = '/rehabMedis/CPPT/index';
}


$this->widget('bootstrap.widgets.BootMenu', array(
  'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
  'stacked'=>false, // whether this is a stacked menu
  'items'=>array(
    array('label'=>'Odontogram', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showGIGI, 'onclick'=>'setTab(this);', 'tab'=>$module.'/periksaGigi/index&frame=1')),
    array('label'=>'Rongga Mulut', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showGIGI, 'onclick'=>'setTab(this);', 'tab'=>$module.'/periksaRonggaMulut/index&frame=1')),
     array('label'=>'Anamnesis Keperawatan (S)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab2s,'onclick'=>'setTab(this);', 'tab'=>$module.'/anamnesa/index')),
     array('label'=>'Anamnesis Keperawatan (S)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab2,'onclick'=>'setTab(this);', 'tab'=>$module.'/anamnesa/index')),

     array('label'=>'Anamnesis Medis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab21,'onclick'=>'setTab(this);', 'tab'=>$module.'/anamnesaMedis/index')),
     array('label'=>'Periksa Fisik Awal (O)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab3,'onclick'=>'setTab(this);', 'tab'=>$module.'/pemeriksaanFisik/index')),
     array('label'=>'Diagnosis Awal (A)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab1,'onclick'=>'setTab(this);', 'tab'=>$module.'/diagnosaNew/index')),

     array('label'=>'Reseptur (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab4,'onclick'=>'setTab(this);', 'tab'=>$module.'/reseptur/index', 'class' => 'reseptur')),
     array('label'=>'Laboratorium Patologi Klinik (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab5,'onclick'=>'setTab(this);', 'tab'=>$module.'/laboratorium/index', 'class' => 'labKlinik')),
     array('label'=>'Patologi Anatomi (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab6,'onclick'=>'setTab(this);', 'tab'=>'rawatInap/patologiAnatomiTRI/index', 'class' => 'labPA')),
     array('label'=>'Mikrobiologi Klinik', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab7,'onclick'=>'setTab(this);', 'tab'=>$module.'/mikrobiologiKlinik/index', 'class' => 'labMikro')),
     
     array('label'=>'Radiologi (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab8,'onclick'=>'setTab(this);', 'tab'=>$module.'/radiologiNew/index', 'class' => 'labRadiologi')),
     array('label'=>'Tindakan (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab12,'onclick'=>'setTab(this);', 'tab'=>$module.'/tindakan/index')),     
     array('label'=>'Catatan Tindakan Dokter', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=> '/rawatJalan/catatanTindakan/index')),   
     array('label'=>'Asesmen Nyeri', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTabn,'onclick'=>'setTab(this);', 'tab'=>'rawatInap/asesmenNyeri/index')),

     array('label' => 'Catatan Pasien Rawat Jalan', 'url' => 'javascript:void(0);', 'itemOptions' => array('style'=>'display: '.$showTab9,'onclick'=>'setTab(this);', 'tab' =>$url)),
     array('label'=>'Konsultasi Dokter Lain', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab10,'onclick'=>'setTab(this);', 'tab'=>$module.'/konsulPoli/index', 'class' => 'konsulPoli')),
     array('label'=>'Rujuk Bedah Sentral', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab11,'onclick'=>'setTab(this);', 'tab'=>$module.'/bedahSentralNew/index')),
     array('label'=>'Surat Keterangan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab13,'onclick'=>'setTab(this);', 'tab'=>$module.'/SuratKeteranganTRJ/suratKeterangan')),
      $is_pulang ? null : array('label'=>'Rujukan Ke Luar', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab14,'onclick'=>'setTab(this);', 'tab'=>$module.'/rujukanKeluar/index')),        
    array('label'=>'Surat Perintah Rawat Inap', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab15,'onclick'=>'setTab(this);', 'tab'=>$module.'/suratPerintahRawatInap/index')),
    // array('label'=>'Rujuk Rehab Medis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab16,'onclick'=>'setTab(this);', 'tab'=>$module.'/rehabMedis/index')),
     $is_pulang ? null : array('label'=>'Konsultasi Gizi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab17,'onclick'=>'setTab(this);', 'tab'=>$module.'/konsulGizi/index')),
   //  $is_pulang ? null : array('label'=>'Rujuk Bedah Sentral', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab18,'onclick'=>'setTab(this);', 'tab'=>$module.'/bedahSentral/index')),
     array('label'=>'Ruangan Tindakan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab19,'onclick'=>'setTab(this);', 'tab'=>$module.'/ruangTindakan/index')),
     array('label'=>'Upload Dokumen Pendukung', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab20,'onclick'=>'setTab(this);', 'tab'=> '/rekamMedis/ScanRM/Index')),
     array('label'=>'Resume Medis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab22,'onclick'=>'setTab(this);', 'tab'=>'rekamMedis/ResumeMedis/index')),
     array('label'=>'Permintaan Darah', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab23, 'onclick'=>'setTab(this);', 'tab'=>'rawatJalan/PermintaanDarahDariPelayananTRJ/index&frame=1')),
    array('label' => 'Rencana Kontrol', 'url' => 'javascript:void(0);', 'itemOptions' => array('style' => 'display: ' . $showTab23, 'onclick' => 'setTab(this);', 'tab' => "rawatJalan/daftarPasien/RencanaKontrolPasienRJ&pendaftaran_id='". $modPendaftaran->pendaftaran_id."'")),
    
           
     //        array('label'=>'Surat Denda', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default', 'style'=>'display: '.$showTab14, 'onclick'=>'setTab(this);', 'tab'=>$this->getUrlSuratDenda())),
  ),
  'htmlOptions'=>[
    'id'=>'tab-periksa'
]
));


?>