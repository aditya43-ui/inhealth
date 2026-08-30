
<?php 
$module = '/'.$this->module->id;
$instalasi_id=Yii::app()->user->getState('instalasi_id');
$namaInstalasi = InstalasiM::model()->findByPk($instalasi_id);
$modInstalasi = InstalasiM::model()->findByPk(Yii::app()->user->getState("instalasi_id"));
$modKonfig = KonfigsystemK::model()->findByPk(Yii::app()->user->getState('konfigsystem_id'));
$init = $modInstalasi->instalasi_singkatan;


$is_pulang = in_array($modPendaftaran->statusperiksa, array(Params::STATUSPERIKSA_SUDAH_PULANG, Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO, Params::STATUSPERIKSA_SEDANG_DIRAWATINAP));

if ($modKonfig->metode_triage == Params::METODE_TRIAGE_WPS){
    $menu_list = array(
        // array('label' => 'Riwayat Pasien Smartplus', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'cekRM(this);', 'tab' => 'smart')),
        array('label'=>'Asesmen Triage', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/asesmenTriage/indexWPS&tab=1')),
    );

    $ruangan = RuanganM::model()->findByAttributes(
        array(
            'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
            'is_jiwa' => true,
        )
    );

    $menu_list = array_merge($menu_list, array(
        array('label' => 'Anamnesis Keperawatan (S)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/anamnesaTRD/index')),
        array('label'=>'Anamnesis Medis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/anamnesaMedisTRD/index')),
        array('label' => 'Periksa Fisik Awal (O)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/pemeriksaanFisikTRD/index')),
        array('label' => 'Diagnosis Awal (A)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => '/rawatJalan/DiagnosaNew/index')),
       array('label' => 'Tindakan (P)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/tindakanTRD/index')),
       array('label'=>'Catatan Tindakan Dokter', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=> '/rawatJalan/catatanTindakan/index')),
       array('label' => 'Reseptur (P)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/resepturTRD/index')),
      array('label' => 'Laboratorium (P)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/laboratoriumTRD/index')),
      array('label' => 'Patologi Anatomi (P)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/patologiAnatomiTRD/index')),
      array('label' => 'Radiologi (P)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/radiologiTRD/index')),
      array('label' => 'Catatan Pasien Rawat Jalan', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => '/rekamMedis/CPPTRK/index')),
      array('label' => 'Konsultasi Dokter Antar Spesialis', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/konsulPoliAntarSpesialis/index')),
      // array('label' => 'Konsultasi Dokter Lain', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/konsulPoliTRD/index')),
      array('label'=>'Ruangan Tindakan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/ruangTindakan/index')),
      array('label'=>'Mikrobiologi Klinik', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: ','onclick'=>'setTab(this);', 'tab'=>'rawatJalan/mikrobiologiKlinik/index')),

      //array('label'=>'Rehab Medis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/rehabMedisTRD/index')),
        array('label'=>'Konsultasi Gizi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/konsulGiziTRD/index')),
        //konsultasi mcu di komen sesuai issue RSCMS-186
//        array('label'=>'Konsultasi MCU', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/konsulMCURD/index')),        
        //  array('label' => 'Rujuk Bedah Sentral', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/bedahSentralTRD/index')),
         array('label' => 'Rujukan Ke Luar', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/rujukanKeluarTRD/index')),
        // array('label'=>'Asesmen Pasien', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/asesmenPerawat/index')),    
        // array('label'=>'Surveilans HAIs', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/surveilansTRD/index')),
        // array('label'=>'Early Warning Score', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatDarurat/EarlyWarningScore/index')),
        // array('label'=>'Catatan Edukasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/CatatanEdukasi/create')),
        // array('label' => 'Catatan Perawat', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' =>'rawatJalan/CatatanPerawat/index')),
        // array('label'=>'Grafik Tanda Vital', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/GrafikTandaVitalRD/create')),
        // array('label'=>'Pemakaian Bahan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/pemakaianBahanTRD/index')),
        // array('label' => 'Surat Perintah Rawat Inap', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatJalan/SuratPerintahRawatInap/index')),
        array('label' => 'Resume Medis', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rekamMedis/ResumeMedis/index')),
        array('label' => 'Surat Keterangan', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/suratKeteranganTRD/suratKeterangan')),
        array('label'=>'Upload Dokumen Rekam Medis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=> '/rekamMedis/ScanRM/Index')),
        array('label'=>'Permintaan Darah', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/PermintaanDarahDariPelayananTRJ/index&frame=1')),
       
    )
    );

    $this->widget('bootstrap.widgets.BootMenu', array(
        'type' => 'tabs',
        // '', 'tabs', 'pills' (or 'list')
        'stacked' => false,
        // whether this is a stacked menu
        'items' => $menu_list,
        'htmlOptions' => [
            'id' => 'tab-periksa'
        ]
    )
    );

} else {

    $menu_list = array(
        // array('label' => 'Riwayat Pasien Smartplus', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'cekRM(this);', 'tab' => 'smart')),
        array('label' => 'Asesmen Triage', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/asesmenTriage/index')),
    );



    $ruangan = RuanganM::model()->findByAttributes(
        array(
            'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
            'is_jiwa' => true,
        )
    );

    $menu_list = array_merge($menu_list, array(
        array('label' => 'Anamnesis Awal (S)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/anamnesaTRD/index')),
        array('label' => 'Periksa Fisik Awal (O)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/pemeriksaanFisikTRD/index')),
        array('label' => 'Diagnosis Awal (A)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/DiagnosaTRDNew/index')),
       array('label' => 'Tindakan (P)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/tindakanTRD/index')),
        array('label' => 'Reseptur (P)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/resepturTRD/index')),
       array('label' => 'Laboratorium (P)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/laboratoriumTRD/index')),
       array('label' => 'Patologi Anatomi (P)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/patologiAnatomiTRD/index')),
       array('label' => 'Radiologi (P)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/radiologiTRD/index')),
       array('label' => 'Catatan Perkembangan Pasien Terintegrasi', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => '/rekamMedis/CPPTRK/index')),
       array('label' => 'Konsultasi Dokter Antar Spesialis', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/konsulPoliAntarSpesialis/index')),
       array('label' => 'Konsultasi Dokter Lain', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/konsulPoliTRD/index')),
        //array('label'=>'Rehab Medis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/rehabMedisTRD/index')),
        // array('label'=>'Konsultasi Gizi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/konsulGiziTRD/index')),
        //konsultasi mcu di komen sesuai issue RSCMS-186
//        array('label'=>'Konsultasi MCU', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/konsulMCURD/index')),        
      array('label' => 'Rujuk Bedah Sentral', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/bedahSentralTRD/index')),
      array('label' => 'Rujukan Ke Luar', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/rujukanKeluarTRD/index')),
        // array('label'=>'Asesmen Pasien', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/asesmenPerawat/index')),    
        // array('label'=>'Surveilans HAIs', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/surveilansTRD/index')),
        // array('label'=>'Early Warning Score', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatDarurat/EarlyWarningScore/index')),
        // array('label'=>'Catatan Edukasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/CatatanEdukasi/create')),
        // array('label' => 'Catatan Perawat', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' =>'rawatJalan/CatatanPerawat/index')),
        // array('label'=>'Grafik Tanda Vital', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/GrafikTandaVitalRD/create')),
        // array('label'=>'Pemakaian Bahan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/pemakaianBahanTRD/index')),
        array('label' => 'Surat Perintah Rawat Inap', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatJalan/SuratPerintahRawatInap/index')),
        array('label' => 'Resume Medis', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rekamMedis/ResumeMedis/index')),
        array('label' => 'Surat Keterangan', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/suratKeteranganTRD/suratKeterangan')),
        array('label' => 'Catatan Tindakan Dokter', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => '/rawatJalan/catatanTindakan/index')),

    )
    );


    $this->widget('bootstrap.widgets.BootMenu', array(
        'type' => 'tabs',
        // '', 'tabs', 'pills' (or 'list')
        'stacked' => false,
        // whether this is a stacked menu
        'items' => $menu_list,
        'htmlOptions' => [
            'id' => 'tab-periksa'
        ]
    )
    );
}
?>