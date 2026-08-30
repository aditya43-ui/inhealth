<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked' => false, // whether this is a stacked menu
    'items' => array(
        array('label' => 'Kelompok Umur', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTab(this);', 'tab' => $this->getUrlKelompokUmur())),
        array('label' => 'Satuan Hasil', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $this->getUrlSatuanHasil())),
        array('label' => 'Nilai Rujukan (Referensi)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $this->getUrlNilaiRujukan())),
        array('label' => 'Kelompok Pemeriksaan', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $this->getUrlKelompokPemeriksaan())),
        array('label' => 'Jenis Pemeriksaan', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $this->getUrlJenisPemeriksaan())),
        array('label' => 'Jenis Form', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $this->getUrlFormLab())),
        array('label' => 'Jenis Form Detail Laboratorium', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $this->getUrlJenisFormLabDet())),
        array('label' => 'Sub-Jenis Pemeriksaan', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $this->getUrlSubJenisPemeriksaan())),
        array('label' => 'Sample Lab', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $this->getUrlSampleLab())),
        array('label' => 'Pemeriksaan', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $this->getUrlPemeriksaanLab())),
        array('label' => 'Detail Pemeriksaan', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $this->getUrlDetailPemeriksaanLab())),
        array('label' => 'Jenis Kegiatan Laboratorium', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $this->getUrlJenisKegiatanLab())),
        array('label' => 'Cara Ambil Sample', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $this->getUrlCaraAmbilSample())),
    ),
));
