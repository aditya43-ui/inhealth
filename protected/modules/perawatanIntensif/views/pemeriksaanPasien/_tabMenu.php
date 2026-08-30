<?php 
$module = '/'.$this->module->id;
$showTab12 = 'block';

$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        
        array('label'=>'Kajian Awal Medis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/anamnesaTRI/index')),
        
        array('label'=>'Anamnesis Awal (S)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/anamnesaTPI/index')),
     
        array('label'=>'Pemeriksaan Fisik', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/pemeriksaanFisikTRI2/index&frame=1')),
       
        array('label'=>'Tindakan (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/tindakan/index')),
        
        array('label'=>'Diagnosis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/diagnosaNew/index&frame=1')),
        array('label'=>'Reseptur (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/resepturTRI/index', 'class' => 'reseptur')),

        array('label'=>'Laboratorium', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/laboratorium/index', 'class' => 'labKlinik')),
        array('label'=>'Laboratorium Patologi Anatomi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/patologiAnatomiTRI/index&frame=1', 'class' => 'labPA')),
        array('label'=>'Radiologi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/radiologiNew/index/index&frame=1', 'class' => 'labRadiologi')),
        array('label'=>'Mikrobiologi Klinik', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: ','onclick'=>'setTab(this);', 'tab'=>'rawatJalan/mikrobiologiKlinik/index', 'class' => 'labMikro')),
      
        array('label'=>'Catatan Perkembangan Pasien Terintegrasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/CPPTRI/index')),
        array('label' => 'Konsultasi Dokter Antar Spesialis', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatDarurat/konsulPoliAntarSpesialis/index', 'class' => 'konsulPoli')),
        array('label'=>'Resume Medis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rekamMedis/ResumeMedis/index')),
        
        array('label'=>'Rujuk Bedah Sentral', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/bedahSentralNew/index')),
        array('label'=>'Rujukan Ke Luar', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/rujukanKeluarTRI/index')), 
      
        array('label'=>'Asesmen Ulang Risiko jatuh', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/asesmenResikoJatuh/index')),
        
        array('label'=>'Grafik Tanda Vital', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/grafikTandaVital/create')),
        array('label'=>'Surat Keterangan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/suratKeteranganTRI/suratKeterangan')),
       
        array('label'=>'Ruangan Tindakan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/ruangTindakanTRI/index')),
        array('label'=>'Upload Dokumen Rekam Medis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=> '/rekamMedis/ScanRM/Index')),
        array('label'=>'Permintaan Darah', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/PermintaanDarahDariPelayananTRI/index&frame=1')),
        array('label'=>'Catatan Tindakan Dokter', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=> '/rawatJalan/catatanTindakan/index')),
        
    ),
    'htmlOptions'=>[
        'id'=>'tab-periksa'
    ] 
));



// tabulasi tidak terpakai
// array('label' => 'Riwayat Pasien Smartplus', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'cekRM(this);', 'tab'=>'smart')),
// array('label'=>'Kajian Awal Medis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/kajianAwalMedis')),
        
// array('label' => 'Periksa Fisik Awal (O)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/pemeriksaanFisikTPI/index')),
// array('label' => 'Diagnosis', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => '/rawatJalan/diagnosaNew/index')),
// !empty($modPendaftaran->verifikasitagihan_id) ? null : array('label' => 'Tindakan (P)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/tindakanTPI/index')),
// !empty($modPendaftaran->verifikasitagihan_id) ? null : array('label' => 'Reseptur (P)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/resepturTPI/index')),
// array('label'=>'Laboratorium', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/laboratorium/index', 'class' => 'labKlinik')),

// !empty($modPendaftaran->verifikasitagihan_id) ? null : array('label' => 'Laboratorium (P)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatJalan/laboratorium/index')),
// !empty($modPendaftaran->verifikasitagihan_id) ? null : array('label' => 'Patologi Anatomi (P)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/patologiAnatomiTPI/index')),
// !empty($modPendaftaran->verifikasitagihan_id) ? null : array('label' => 'Radiologi (P)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/radiologiNewTPI/index')),
// array('label'=>'Mikrobiologi Klinik', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/rawatJalan/mikrobiologiKlinik/index')),
// array('label'=>'Tindakan (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: '.$showTab12,'onclick'=>'setTab(this);', 'tab'=>'rawatJalan/tindakan/index')),    
// // array('label'=>'Akomodasi Ruangan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/tindakanAkomodasi/index')),
// array('label'=>'Konsultasi Dokter Antar Spesialis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/rawatDarurat/konsulPoliAntarSpesialis/index')),
// array('label'=>'Ruang Tindakan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/rawatInap/ruangTindakanTRI/index')),
// array('label'=>'Permintaan Darah', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/PermintaanDarahDariPelayananTRI/index&frame=1')),
// array('label' => 'Catatan Perkembangan Pasien Terintegrasi', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rekamMedis/CPPTRK/index')),
// array('label' => 'Resume Medis', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rekamMedis/ResumeMedis/index')),
// !empty($modPendaftaran->verifikasitagihan_id) ? null : array('label' => 'Rujuk Rehab Medis', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/rehabMedisTPI/index')),
// !empty($modPendaftaran->verifikasitagihan_id) ? null : array('label' => 'Konsultasi Dokter Lain', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/konsulPoliTPI/index')),
// !empty($modPendaftaran->verifikasitagihan_id) ? null : array('label' => 'Rujuk Bedah Sentral', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatJalan/bedahSentralNew/index')),
// !empty($modPendaftaran->verifikasitagihan_id) ? null : array('label' => 'Rujukan Ke Luar', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/rujukanKeluarTPI/index')),
// array('label'=>'Asesmen Nyeri', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/asesmenNyeriPI/index')),
// array('label'=>'Pemakaian Bahan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/pemakaianBahanTPI/index')),     
// array('label'=>'Asesmen Risiko jatuh', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/asesmenResikoJatuhPI/index')),
//        RSSP-577
// array('label'=>'Konsultasi Gizi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/konsulGiziTPI/index')),

//        RSSP-544 dihidden mengacu pada RSSP-543
// array('label'=>'Konsultasi MCU', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/konsulMCUPI/index')),
//		RSSP-1397
//        array('label'=>'Diagnosis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/diagnosaTPI/index')),
// array('label'=>'Rujuk Bedah Sentral', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/bedahSentralTPI/index')),
// array('label'=>'Rujukan Ke Luar', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/rujukanKeluarTPI/index')),
// array('label'=>'Surveilans HAIs', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/surveilansTPI/index')),
// array('label'=>'Lembar Observasi Pasien', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/kardeksT/create')),
// array('label' => 'Catatan Perawat', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' =>'rawatJalan/CatatanPerawat/index')),
// array('label'=>'Grafik Tanda Vital', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/GrafikTandaVitalTPI/create')),
// array('label' => 'Riwayat Pasien Smartplus', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'cekRM(this);')),
// array('label'=>'Surat Keterangan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/suratKeteranganTRM/suratKeterangan')),
// array('label' => 'Ringkasan Pasien Pulang (Resume Medis)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatInap/RingkasanMasukKeluar/index')),
// array('label' => 'Catatan Tindakan Dokter', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=> '/rawatJalan/catatanTindakan/index')),
//        array('label'=>'Unit Dosis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/unitDosisTPI/index')),
?>