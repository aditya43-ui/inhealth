<?php 
/**
 * Tab menu untuk Kelengkapan Dokumen Pengadaan 
 * Jika menambahkan tab baru, tambahkan juga hak aksesnya 
 * @author Aida Rahmawati <aidarahmawati@.com>
 */
$module = $this->module->id;
$controller = '/'.Yii::app()->controller->id;

$cri = new CDbCriteria();
$cri->addCondition('pegawai_id = '.Yii::app()->user->getState('pegawai_id'));
$cri->addCondition('pejabatpengadaan_aktif is true');
$cri->addCondition("jabatan_pengadaan = '".Params::JABATAN_PENGADAAN_PPK."' OR jabatan_pengadaan = '".Params::JABATAN_PENGADAAN_PPKOM."'");
$modPPK = PejabatpengadaanM::model()->find($cri); 

$cri2 = new CDbCriteria();
$cri2->addCondition('pegawai_id = '.Yii::app()->user->getState('pegawai_id'));
$cri2->addCondition('pejabatpengadaan_aktif is true');
$cri2->addCondition("jabatan_pengadaan = '".Params::JABATAN_PENGADAAN_PEJABAT_PENGADAAN."'");
$modPejabatPengadaan = PejabatpengadaanM::model()->find($cri2); 

$cri3 = new CDbCriteria();
$cri3->addCondition('pegpengadaan_id IN ('.Yii::app()->user->getState('pegawai_id').')');
$modInfoPengadaan = InfoumumpengadaanT::model()->find($cri3);

$modPegPengadaan = PegawaiM::model()->findByAttributes(array('pegawai_id' => Yii::app()->user->getState('pegawai_id'), 'unitkerja_id' => Params::UNITKERJA_ID_PENGADAAN_DAN_JASA, 'pegawai_aktif' => true));

$showTab1; $showTab2; $showTab3; $showTab4; $showTab5; $showTab6; $showTab7; $showTab8; $showTab9; $showTab10; $showTab11; $showTab12; $showTab13; $showTab14; 

$showTab1 =  $showTab2 =  $showTab3 =  $showTab4 =  $showTab5 =  $showTab6 = $showTab7 =  $showTab8 = $showTab9 = $showTab10 = $showTab11 =  $showTab12 = $showTab13 = $showTab14 = 'none';

if (!empty($modPPK)) {
    $showTab1 = $showTab2 = $showTab3 = $showTab4 = $showTab5 = $showTab6 = $showTab7 = $showTab9 = $showTab10 = $showTab11 = $showTab12 = $showTab13 = 'block';
} else if (!empty($modPejabatPengadaan)) {
    $showTab1 = $showTab2 = $showTab3 = $showTab4 = $showTab5 = $showTab6 = $showTab7 = $showTab8 = 'block'; 
}

$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Informasi Umum', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab1, 'id'=>'info-umum', 'onclick'=>'setTab(this);', 'tab'=>$this->getUrlInformasiUmumT())),
        array('label'=>'Pembukaan Penawaran', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab2,  'id'=>'buka-penawaran', 'onclick'=>'setTab(this);', 'tab'=>$this->getUrlPembukaanPenawaran())),
        array('label'=>'Evaluasi Penawaran', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab3,  'id'=>'eval-penawaran', 'onclick'=>'setTab(this);', 'tab'=>$this->getUrlEvaluasipenawaran())),
        array('label'=>'BA Klarifikasi/Negosiasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab4, 'id'=>'ba-nego', 'onclick'=>'setTab(this);', 'tab'=>$this->getUrlBANegosiasi())),
        array('label'=>'BA Hasil Pengadaan Langsung', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab5, 'id'=>'ba-langsung', 'onclick'=>'setTab(this);', 'tab'=>$this->getUrlBAPengadaanLangsung())),
        array('label'=>'Penetapan Pemenang', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab6, 'id'=>'penetapan', 'onclick'=>'setTab(this);', 'tab'=>$this->getUrlPenetapanPemenang())),
        array('label'=>'Pengumuman Pemenang', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab7,'id'=>'pengumuman', 'onclick'=>'setTab(this);', 'tab'=>$this->getUrlPengumumanPemenang())),
        array('label'=>'Nota Dinas Pejabat Pengadaan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab8,'id'=>'nota-dinas', 'onclick'=>'setTab(this);', 'tab'=>$this->getUrlNotaDinas())),
        array('label'=>'Penunjukan Penyedia', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab9,'id'=>'penyedia', 'onclick'=>'setTab(this);', 'tab'=>$this->getUrlSPPBJ())),
        array('label'=>'Kontrak', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab10, 'id'=>'kontrak', 'onclick'=>'setTab(this);', 'tab'=>$this->getUrlPerjanjianKerja())),
        array('label'=>'SSKK', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab11, 'id'=>'sskk', 'onclick'=>'setTab(this);', 'tab'=>$this->getUrlSSKK())),
        array('label'=>'Perintah Mulai Kerja', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab12, 'id'=>'mulai-kerja','onclick'=>'setTab(this);', 'tab'=>$this->getUrlSuratPerintahMulaiKerja())),
        array('label'=>'Perintah Pengiriman', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab13, 'id'=>'pengiriman','onclick'=>'setTab(this);', 'tab'=>"pengadaan/perintahPengirimanT/index")),
//        array('label'=>'Surat Denda', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default', 'style'=>'display: '.$showTab14, 'onclick'=>'setTab(this);', 'tab'=>$this->getUrlSuratDenda())),
    ),
));
?>

<div>
    <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; overflow-x: scroll;" ></iframe>
</div>