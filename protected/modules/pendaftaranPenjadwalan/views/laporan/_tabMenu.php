<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Umur', 'url'=>$this->createAbsoluteUrl($controller.'/laporanKunjunganUmurRD'),'active'=>true),
        array('label'=>'Jenis Kelamin', 'url'=>$this->createAbsoluteUrl($controller.'/laporanKunjunganJkRD'),),
        array('label'=>'Kedatangan Lama / Baru', 'url'=>$this->createAbsoluteUrl($controller.'/laporanStatusKunjunganRD'),),
        array('label'=>'Agama', 'url'=>$this->createAbsoluteUrl($controller.'/laporanAgamaKunjunganRD'),),
        array('label'=>'Pekerjaan', 'url'=>$this->createAbsoluteUrl($controller.'/laporanPekerjaanKunjunganRD'),),
        array('label'=>'Status Perkawinan', 'url'=>$this->createAbsoluteUrl($controller.'/laporanStatusPerkawinanKunjunganRD'),),
        array('label'=>'Alamat Lengkap', 'url'=>$this->createAbsoluteUrl($controller.'/laporanAlamatKunjunganRD'),),
        array('label'=>'Kecamatan', 'url'=>$this->createAbsoluteUrl($controller.'/laporanKecamatanKunjunganRD'),),
        array('label'=>'Kab. / Kota', 'url'=>$this->createAbsoluteUrl($controller.'/laporanKabKotaKunjunganRD'),),
        array('label'=>'Cara Masuk', 'url'=>$this->createAbsoluteUrl($controller.'/laporanCaraMasukKunjunganRD'),),
        array('label'=>'Rujukan', 'url'=>$this->createAbsoluteUrl($controller.'/laporanRujukanKunjunganRD'),),
        array('label'=>'Pemeriksaan', 'url'=>$this->createAbsoluteUrl($controller.'/laporanPemeriksaanKunjunganRD'),),
        array('label'=>'Keterangan Pulang', 'url'=>$this->createAbsoluteUrl($controller.'/laporanKetPulangKunjunganRD'),),
        array('label'=>'Penjamin Pasien', 'url'=>$this->createAbsoluteUrl($controller.'/laporanPenjaminKunjunganRD'),),
        array('label'=>'Nama Dokter', 'url'=>$this->createAbsoluteUrl($controller.'/laporanDokterPemeriksaKunjunganRD'),),
        
            ),
)); 
?>