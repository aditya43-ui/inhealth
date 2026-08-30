<?php 
/**
 * view yang digunakan untuk menambahkan tabulasi menu
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0 
 * @link    <http://piindonesia.co.id>
 */
$module = '/'.$this->module->id;
$is_verifikasi = $modPendaftaran->verifikasitagihan_id != null;
// var_dump($is_verifikasi);die;
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(      
        // array('label' => 'Riwayat Pasien Smartplus', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'cekRM(this);', 'tab'=>'smart')),  
        array('label'=>'Kajian Awal Medis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/anamnesaTRI/index')),
       // array('label'=>'Asessmen Awal', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/anamnesaTRI/index')),
       array('label'=>'Pemeriksaan Fisik', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/pemeriksaanFisikTRI2/index&frame=1')),

        // array('label'=>'Rencana Awal (O)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'/rawatInap/pemeriksaanFisikTRI2/index')),
        // array('label'=>'Diagnosis Awal (A)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/diagnosaTRINew/index')),
        array('label'=>'Tindakan (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/tindakan/index')),
        // array('label'=>'Akomodasi Ruangan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/tindakanAkomodasi/index')),
        array('label'=>'Diagnosis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/diagnosaNew/index&frame=1')),
        array('label'=>'Reseptur (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/resepturTRI/index', 'class' => 'reseptur')),

        array('label'=>'Laboratorium', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/laboratorium/index', 'class' => 'labKlinik')),
        array('label'=>'Laboratorium Patologi Anatomi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/patologiAnatomiTRI/index&frame=1', 'class' => 'labPA')),
        array('label'=>'Radiologi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/radiologiNew/index/index&frame=1', 'class' => 'labRadiologi')),
        array('label'=>'Mikrobiologi Klinik', 'url'=>'javascript:void(0);', 'itemOptions'=>array('style'=>'display: ','onclick'=>'setTab(this);', 'tab'=>'rawatJalan/mikrobiologiKlinik/index', 'class' => 'labMikro')),

        //  array('label'=>'Laboratorium (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/laboratoriumTRI/index')),
        //  array('label' => 'Patologi Anatomi (P)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/patologiAnatomiTRINew/index')),
      //    array('label'=>'Radiologi (P)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/radiologiTRI/index')),
        array('label'=>'Catatan Perkembangan Pasien Terintegrasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/CPPTRI/index')),
        array('label' => 'Konsultasi Dokter Antar Spesialis', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatDarurat/konsulPoliAntarSpesialis/index', 'class' => 'konsulPoli')),
        array('label'=>'Resume Medis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rekamMedis/ResumeMedis/index')),
            // array('label'=>'Rujuk Rehab Medis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/rehabMedisTRI/index')),
        // array('label'=>'Konsultasi Gizi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=> 'rawatJalan/konsulGizi/index')),
       //   array('label'=>'Konsultasi Dokter Lain', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/konsulPoliTRI/index')),
        //  array('label'=>'Konsultasi Dokter Lain', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/konsulPoli/index')),
      
        // array('label'=>'Konsultasi MCU', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/konsulMCURI/index')),                
            array('label'=>'Rujuk Bedah Sentral', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/bedahSentralNew/index')),
            array('label'=>'Rujukan Ke Luar', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/rujukanKeluarTRI/index')), 
        // array('label'=>'Pemakaian Bahan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/pemakaianBahanTRI/index')),
        // array('label'=>'Asesmen Awal Keperawatan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/asesmenAwalKeperawatan/index')),
        // array('label'=>'Asesmen Nyeri', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/asesmenNyeri/index')),
        array('label'=>'Asesmen Ulang Risiko jatuh', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/asesmenResikoJatuh/index')),
        // array('label'=>'Catatan Obat', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/catatanPemberianObat/create')),
        // array('label'=>'Surveilans HAIs', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/surveilansTRI/index')),
        // array('label'=>'Early Warning Score', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatDarurat/EarlyWarningScore/index&frame=1')),
        // array('label'=>'Catatan Edukasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/CatatanEdukasi/create')),
        // array('label' => 'Catatan Perawat', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' =>'rawatJalan/CatatanPerawat/index')),
        array('label'=>'Grafik Tanda Vital', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/grafikTandaVital/create')),
        array('label'=>'Surat Keterangan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/suratKeteranganTRI/suratKeterangan')),
        // array('label'=>'Ringkasan Pasien Pulang (Resume Medis)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab1(this);', 'tab'=>$module.'/RingkasanMasukKeluar/index')),
        array('label'=>'Ruangan Tindakan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/ruangTindakanTRI/index')),
        array('label'=>'Upload Dokumen Rekam Medis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=> '/rekamMedis/ScanRM/Index')),
        array('label'=>'Permintaan Darah', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/PermintaanDarahDariPelayananTRI/index&frame=1')),
        array('label'=>'Catatan Tindakan Dokter', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=> '/rawatJalan/catatanTindakan/index')),

        // array('label' => 'Ringkasan Pasien Pulang (Resume Medis)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatInap/RingkasanMasukKeluar/index')),
//        array('label'=>'Unit Dosis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$module.'/unitDosisTRI/index')),
    ),
    'htmlOptions'=>[
        'id'=>'tab-periksa'
    ] 
));
?>