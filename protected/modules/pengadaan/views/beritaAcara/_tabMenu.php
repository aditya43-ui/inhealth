<?php
$modPPK = PejabatpengadaanM::model()->findByAttributes(array('jabatan_pengadaan' => Params::JABATAN_PENGADAAN_PPK, 'pejabatpengadaan_aktif' => true, 'pegawai_id' => Yii::app()->user->getState('pegawai_id')));
$modKPA = PejabatpengadaanM::model()->findByAttributes(array('jabatan_pengadaan' => Params::JABATAN_PENGADAAN_KPA, 'pejabatpengadaan_aktif' => true, 'pegawai_id' => Yii::app()->user->getState('pegawai_id')));
$cri = new CDbCriteria();
$cri->addCondition('pegpengadaan_id = '. Yii::app()->user->getState('pegawai_id'));
$modPegPengadaan = InfoumumpengadaanT::model()->find($cri);
$modUnitPengadaan = PegawaiM::model()->findByAttributes(array('unitkerja_id' => Params::UNITKERJA_ID_PENGADAAN_DAN_JASA));
$showTab1 = $showTab2 = $showTab3 = $showTab4 = $showTab5 = $showTab6 = $showTab7 = $showTab8 = $showTab9 = $showTab10 = $showTab11 = $showTab12 = 'block';

if (!empty($modPPK)) {
//    $showTab5 = $showTab7 = $showTab10 = $showTab11 = 'none';
} else if (!empty($modKPA)) {
//    $showTab1 = $showTab2 = $showTab3 = $showTab4 = $showTab5 = $showTab6 = $showTab8 = $showTab9 = $showTab10 = $showTab11 = $showTab12= 'none';
} else if (!empty($modPegPengadaan) || !empty($modUnitPengadaan)) {
//    $showTab1 = $showTab2 = $showTab3 = $showTab6 = $showTab7 = $showTab8 = $showTab9 = 'none';
}


$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Pembelian Langsung', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style' => 'display : '.$showTab1, 'id'=>'pembelian-langsung','onclick'=>'setTab(this);', 'tab'=>'pengadaan/BAPembelianLangsung/index')),
        array('label'=>'Kemajuan Hasil Pekerjaan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style' => 'display : '.$showTab2, 'id'=>'kemajuan-hasil','onclick'=>'setTab(this);', 'tab'=>'pengadaan/BAKemajuanHasilPekerjaan/index')),
        array('label'=>'Nota Dinas PPK', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style' => 'display : '.$showTab3, 'id'=>'nota-dinas','onclick'=>'setTab(this);', 'tab'=>'pengadaan/BANotaDinasPPK/index')),
        array('label'=>'Uji Coba/Uji Fungsi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style' => 'display : '.$showTab4, 'id'=>'uji-coba','onclick'=>'setTab(this);', 'tab'=>'pengadaan/BAUjiCoba/index')),
        array('label'=>'Pemeriksaan Pekerjaan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style' => 'display : '.$showTab5, 'id'=>'pemeriksaan','onclick'=>'setTab(this);', 'tab'=>'pengadaan/BAPemeriksaanPekerjaan/index')),
        array('label'=>'Hasil Pemeriksaan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style' => 'display : '.$showTab6, 'id'=>'hasil-periksa','onclick'=>'setTab(this);', 'tab'=>'pengadaan/BAHasilPemeriksaan/index')),
        array('label'=>'Nota Dinas KPA', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style' => 'display : '.$showTab7, 'id'=>'nota-dinas-kpa','onclick'=>'setTab(this);', 'tab'=>'pengadaan/BANotaDinasKpa/index')),
        array('label'=>'Serah Terima', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style' => 'display : '.$showTab8, 'id'=>'serah-terima','onclick'=>'setTab(this);', 'tab'=>'pengadaan/BASerahTerima/index')),
        array('label'=>'Penyerahan Barang dan Jasa', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style' => 'display : '.$showTab9, 'id'=>'penyerahan','onclick'=>'setTab(this);', 'tab'=>'pengadaan/BAPenyerahanBarangJasa/index')),
        array('label'=>'Pemeriksaan Administratif PjPHP', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style' => 'display : '.$showTab10, 'id'=>'admin-pjphp','onclick'=>'setTab(this);', 'tab'=>'pengadaan/BAPemeriksaanAdmPjPHP/index')),
        array('label'=>'Pemeriksaan Administratif PPHP', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style' => 'display : '.$showTab11, 'id'=>'admin-pphp','onclick'=>'setTab(this);', 'tab'=>'pengadaan/BAPemeriksaanAdmPPHP/index')),
        array('label'=>'Surat Denda', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style' => 'display : '.$showTab12, 'id'=>'surat-denda','onclick'=>'setTab(this);', 'tab'=>'pengadaan/suratDenda/index')),
    ),
));
?>