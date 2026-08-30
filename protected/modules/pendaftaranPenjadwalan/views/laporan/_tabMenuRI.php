<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Umur', 'url'=>$this->createUrl('/rawatInap/diagnosakeperawatanM/admin'),'active'=>true),
        array('label'=>'Jenis Kelamin', 'url'=>$this->createUrl('/rawatInap/rencanaKeperawatanM/admin'),),
        array('label'=>'Kedatangan Lama / Baru', 'url'=>$this->createUrl('/rawatInap/implementasikeperawatanM/admin'),),
        array('label'=>'Agama', 'url'=>$this->createUrl('/rawatInap/implementasikeperawatanM/admin'),),
        array('label'=>'Pekerjaan', 'url'=>$this->createUrl('/rawatInap/implementasikeperawatanM/admin'),),
        array('label'=>'Status Perkawinan', 'url'=>$this->createUrl('/rawatInap/implementasikeperawatanM/admin'),),
        array('label'=>'Alamat Lengkap', 'url'=>$this->createUrl('/rawatInap/implementasikeperawatanM/admin'),),
        array('label'=>'Kecamatan', 'url'=>$this->createUrl('/rawatInap/implementasikeperawatanM/admin'),),
        array('label'=>'Kab. / Kota', 'url'=>$this->createUrl('/rawatInap/implementasikeperawatanM/admin'),),
        array('label'=>'Cara Masuk', 'url'=>$this->createUrl('/rawatInap/implementasikeperawatanM/admin'),),
        array('label'=>'Rujukan', 'url'=>$this->createUrl('/rawatInap/implementasikeperawatanM/admin'),),
        array('label'=>'Rekam Medik', 'url'=>$this->createUrl('/rawatInap/implementasikeperawatanM/admin'),),
        array('label'=>'Kamar Ruangan', 'url'=>$this->createUrl('/rawatInap/implementasikeperawatanM/admin'),),
        array('label'=>'Keterangan Pulang', 'url'=>$this->createUrl('/rawatInap/implementasikeperawatanM/admin'),),
        array('label'=>'Alasan Pulang', 'url'=>$this->createUrl('/rawatInap/implementasikeperawatanM/admin'),),
        array('label'=>'P3 / Asuransi', 'url'=>$this->createUrl('/rawatInap/implementasikeperawatanM/admin'),),
        array('label'=>'Nama Dokter', 'url'=>$this->createUrl('/rawatInap/implementasikeperawatanM/admin'),),
        
            ),
)); 
?>