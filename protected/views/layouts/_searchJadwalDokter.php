<?php
	$mod_jad_dok = new JadwaldokterV();
        if(isset($_GET['JadwaldokterV'])){
                $mod_jad_dok->attributes = $_REQUEST['JadwaldokterV'];
        }
	$this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id'=>'jadwal-dokter-grid',
                'dataProvider'=>$mod_jad_dok->searchHariIni(),
                'filter'=>$mod_jad_dok,
                'template'=>"{items}",
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                'columns'=>array(
                                    array(
                                        'value' => '"<strong>".(isset($data->gelardepan)?$data->gelardepan." ":"").$data->nama_pegawai.(isset($data->gelarbelakang_nama)?" ".$data->gelarbelakang_nama:"")."</strong><br>".'
                                        . '"Pukul : ".$data->jadwaldokter_buka',
                                        'type'  => 'raw',
                                        'headerHtmlOptions' => array('style' => 'display:none'),
                                        'filter'=> CHtml::activeTextField($mod_jad_dok, 'nama_pegawai',array('placeholder'=>'Cari Nama Dokter')),
                                    ),
                        ),
	));
?>