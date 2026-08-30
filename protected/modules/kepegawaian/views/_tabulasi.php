<?php 
$module = '/'.$this->module->id.'/';
$controlModule = $module.$this->id.'/';
$urlRoute = Yii::app()->createUrl($this->route);

//$urlIni = Yii::app()->createUrl($controlModule.$this->action->id);
//if (strtolower($urlRoute) == strtolower($urlIni)){
//    echo 'GGGGG';
//}
$id_pegawai = isset($id_pegawai) ? '&id=' . $id_pegawai : '';
$urlPendidikan= $this->createUrl($module.'pencatatanRiwayat/index'.$id_pegawai);
$urlPengkerja =$this->createUrl($module.'pencatatanRiwayat/index'.$id_pegawai);
$urlPengorganisasi = $this->createUrl($module.'pengorganisasiR/create'.$id_pegawai);
$urlPrestasi =  $this->createUrl($module.'prestasikerjaR/create'.$id_pegawai);
$urlPerjalanan = $this->createUrl($module.'perjalanandinasR/create'.$id_pegawai);
$urlSunKel = $this->createUrl($module.'susunankelM/create'.$id_pegawai);
$urlPangkat = $this->createUrl($module.'kenaikanpangkatT/create'.$id_pegawai);
$urlDiklat = $this->createUrl($module.'PegawaiM/Pencatatanriwayat'.$id_pegawai);
$urlJabatan = $this->createUrl($module.'PegawaiM/Pencatatanriwayat'.$id_pegawai);
$urlMutasi = $this->createUrl($module.'PegawaiM/Pencatatanriwayat'.$id_pegawai);
$urlCuti = $this->createUrl($module.'PegawaiM/Pencatatanriwayat'.$id_pegawai);
$urlHukuman = $this->createUrl($module.'PegawaiM/Pencatatanriwayat'.$id_pegawai);

$this->widget('bootstrap.widgets.BootMenu', array(
    'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked' => false, // whether this is a stacked menu
    'items' => array(
        array('label' => 'Pendidikan', 'url' =>$urlPendidikan, 'active' =>((strtolower($urlRoute) == strtolower($urlPendidikan)) ? true : false)),
        array('label' => 'Diklat', 'url' =>$urlDiklat.'&tab=1', 'linkOptions' => array('onclick' => 'return palidasiForm(this);'), 'active' =>((strtolower($urlRoute) == strtolower($urlDiklat)) ? true : false)),
        array('label' => 'Pengalaman Kerja', 'url' => $urlPengkerja.'&tab=2', 'active' => (strtolower($urlRoute) == strtolower($urlPengkerja)) ? true : false),
        array('label' => 'Pengalaman Organisasi', 'url' => $urlPengorganisasi.'&tab=3', 'active' => (strtolower($urlRoute.$id_pegawai) == strtolower($urlPengorganisasi)) ? true : false),
        array('label' => 'Jabatan', 'url' =>$urlJabatan.'&tab=4', 'active' => (strtolower($urlRoute) == strtolower($urlJabatan)) ? true : false),
//        array('label' => 'Pangkat', 'url' => $urlPangkat, 'active' => (strtolower($urlRoute) == strtolower($urlPangkat)) ? true : false),
        array('label' => 'Mutasi Kerja', 'url' => $urlMutasi.'&tab=6', 'active' => (strtolower($urlRoute) == strtolower($urlMutasi)) ? true : false),
        array('label' => 'Cuti', 'url' => $urlCuti.'&tab=7', 'linkOptions' => array('onclick' => 'return palidasiForm(this);'), 'active' => (strtolower($urlRoute) == strtolower($urlCuti)) ? true : false),
        array('label' => 'Ijin Tugas Belajar', 'url' => $urlCuti.'&tab=8', 'linkOptions' => array('onclick' => 'return palidasiForm(this);'), 'active' => (strtolower($urlRoute) == strtolower($urlCuti)) ? true : false),
        array('label' => 'Hukuman Disiplin', 'url' => $urlHukuman.'&tab=9', 'active' => (strtolower($urlRoute) == strtolower($urlHukuman)) ? true : false),
        array('label' => 'Susunan Keluarga', 'url' =>$urlSunKel, 'active' => (strtolower($urlRoute.$id_pegawai) == strtolower($urlSunKel)) ? true : false),
        array('label' => 'Prestasi Kerja', 'url' =>$urlPrestasi, 'active' => (strtolower($urlRoute.$id_pegawai) == strtolower($urlPrestasi)) ? true : false),
        array('label' => 'Perjalanan Dinas', 'url' =>$urlPerjalanan, 'active' => (strtolower($urlRoute.$id_pegawai) == strtolower($urlPerjalanan)) ? true : false),
            ),
));