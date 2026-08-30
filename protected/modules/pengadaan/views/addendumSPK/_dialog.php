<?php
//========= Dialog untuk ....  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPPK',
    'options' => array(
        'title' => 'Pejabat Pembuat Komitmen (PPK)',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));


$modPPK = new PejabatpengadaanM('search');
$modPPK->unsetAttributes();
if (isset($_GET['PejabatpengadaanM'])) {
    $modPPK->attributes = $_GET['PejabatpengadaanM'];
    $modPPK->nama_pegawai = isset($_GET['PejabatpengadaanM']['nama_pegawai']) ? $_GET['PejabatpengadaanM']['nama_pegawai'] : null;
    $modPPK->nomorindukpegawai = isset($_GET['PejabatpengadaanM']['nomorindukpegawai']) ? $_GET['PejabatpengadaanM']['nomorindukpegawai'] : null;
    $modPPK->unitkerja_id = isset($_GET['PejabatpengadaanM']['unitkerja_id']) ? $_GET['PejabatpengadaanM']['unitkerja_id'] : null;
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ppk-grid',
    'dataProvider' => $modPPK->searchDialogPPK(),
    'filter' => $modPPK,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>function($data) {
                    $load = $data->attributes;
                    $modPegawai = PegawaiM::model()->findByPk($data->pegawai_id);
                    $load['alamat'] = $modPegawai->alamat_pegawai;
                    $load['nomorindukpegawai'] = $modPegawai->nomorindukpegawai;
                    $load['nama_pegawai'] = $modPegawai->namaLengkap;
                    $load['jabatan_nama'] = !empty($modPegawai->jabatan_id) ? $modPegawai->jabatan->jabatan_nama : "";
                    $res = json_encode($load);

                    return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"javascript:;",array("class"=>"btn-small", 
                            "onclick" => 'setPPK('.$res.');$("#dialogPPK").dialog("close")'));
                },
        ),  
        array(
            'header' => 'Nomor Induk Pegawai',
            'name' => 'nomorindukpegawai',
            'value' => function($data){
                return $data->pegawai->nomorindukpegawai;
            }
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => function($data){
                return $data->pegawai->namaLengkap;
            }
        ),
        array(
            'header' => 'Unit Kerja',
            'filter' => CHtml::activeDropDownList($modPPK, 'unitkerja_id', CHtml::listData(
                UnitkerjaM::model()->findAll('unitkerja_aktif = true order by namaunitkerja'), 'unitkerja_id', 'namaunitkerja'
            ), array('empty' => '-- Pilih --')),
            'value' => function($data){
                if (empty($data->unitkerja_id)) {
                    return "-";
                }
                
                $modUnit = UnitkerjaM::model()->findByPk($data->unitkerja_id);
                if (!empty($modUnit)) {
                    return $modUnit->namaunitkerja;
                } else {
                    return "-";
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

    <?php
//========= Dialog untuk ....  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogKuasaPengguna',
    'options' => array(
        'title' => 'Kuasa Pengguna Anggaran (KPA)',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));
    
    
$modKuasa = new PejabatpengadaanM('search');
$modKuasa->unsetAttributes();
if (isset($_GET['PejabatpengadaanM'])) {
    $modKuasa->attributes = $_GET['PejabatpengadaanM'];
    $modKuasa->nama_pegawai = isset($_GET['PejabatpengadaanM']['nama_pegawai']) ? $_GET['PejabatpengadaanM']['nama_pegawai'] : null;
    $modKuasa->nomorindukpegawai = isset($_GET['PejabatpengadaanM']['nomorindukpegawai']) ? $_GET['PejabatpengadaanM']['nomorindukpegawai'] : null;
    $modKuasa->unitkerja_id = isset($_GET['PejabatpengadaanM']['unitkerja_id']) ? $_GET['PejabatpengadaanM']['unitkerja_id'] : null;

}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'kuasa-grid',
    'dataProvider' => $modKuasa->searchDialogKPA(),
    'filter' => $modKuasa,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectItem",
                "onClick" => "
                    $(\".kuasapenggunaanggaran_id\").val(".$data->pegawai_id.");
                    $(\".kuasapenggunaanggaran_nama\").val(\"".$data->pegawai->namaLengkap."\");
                    $(\"#dialogKuasaPengguna\").dialog(\"close\");
                    return false;"))',
        ),
        'nomorindukpegawai',
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => function($data){
                return $data->pegawai->namaLengkap;
            }
        ),
        array(
            'header' => 'Unit Kerja',
            'filter' => CHtml::activeDropDownList($modPPK, 'unitkerja_id', CHtml::listData(
                UnitkerjaM::model()->findAll('unitkerja_aktif = true order by namaunitkerja'), 'unitkerja_id', 'namaunitkerja'
            ), array('empty' => '-- Pilih --')),
            'value' => function($data){
                if (empty($data->unitkerja_id)) {
                    return "-";
                }
                
                $modUnit = UnitkerjaM::model()->findByPk($data->unitkerja_id);
                if (!empty($modUnit)) {
                    return $modUnit->namaunitkerja;
                } else {
                    return "-";
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
    
$this->endWidget();

/* ========= Dialog untuk mencari data barnag dan jasa ========================= */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogBarangJasa',
    'options'=>array(
            'title'=>'Daftar Barang dan Jasa',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>800,
            'height'=>500,
            'resizable'=>false,
    ),
));
$modBrgJasa = new DokumenpelaksanaananggarandetT('search');
$modBrgJasa->unsetAttributes();
if(isset($_GET['DokumenpelaksanaananggarandetT'])){
    $modBrgJasa->attributes = $_GET['DokumenpelaksanaananggarandetT'];
    $modBrgJasa->instalasi_id = isset($_GET['DokumenpelaksanaananggarandetT']['instalasi_id'])?$_GET['DokumenpelaksanaananggarandetT']['instalasi_id']:null;
    $modBrgJasa->periodeanggaran_id = isset($_GET['DokumenpelaksanaananggarandetT']['periodeanggaran_id'])?$_GET['DokumenpelaksanaananggarandetT']['periodeanggaran_id']:null;
    $modBrgJasa->unitkerja_id = isset($_GET['DokumenpelaksanaananggarandetT']['unitkerja_id'])?$_GET['DokumenpelaksanaananggarandetT']['unitkerja_id']:null;
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'barangjasa-m-grid',
    'dataProvider'=>$modBrgJasa->searchAddendum(),
    'filter'=>$modBrgJasa,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
                 array(
                        'header'=>CHtml::checkBox('pilihSemua', false, array(
                                'class'=>'check_all_barangjasa', 'onchange'=>'setSemuaBarang(this);'
                        )).' Pilih Semua',
                        'type'=>'raw',
                        'value'=>function($data){
                                return CHtml::checkBox('check', false, array(                                
                                        'onchange'=>'setBarangCek(this);',
                                        'class'=>'pilih',
                                        'id-data'=>$data->dokumenpelaksanaananggarandet_id 
                                ));
                        },
                        'htmlOptions'=>array(
                                'style'=>'text-align: center',
                        ),
                        'footer' => CHtml::htmlButton('OK', array('class'=>'btn btn-green', 'onclick'=>'loadBarangJasaByDetId();'))
                ),
                array(
                    'header'=>'No',
                    'value'=>'($this->grid->dataProvider->pagination) ? 
                        ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                        : ($row+1)'
                ),
                array(
                    'header'=>'Barang/Jasa',
                    'name'=>'uraian',                    
                ),
                array(
                    'header'=>'Satuan',
                    'name'=>'satuan',
                    'filter' => CHtml::activeHiddenField($modBrgJasa, 'paketpekerjaan_id', array('class' => 'barang_paketpekerjaan_id')) .                                 
                                CHtml::activeHiddenField($modBrgJasa, 'periodeanggaran_id', array('class' => 'barang_periodeanggaran_id')) . 
                                CHtml::activeHiddenField($modBrgJasa, 'subkegiatanprogram_id', array('class' => 'barang_subkegiatanprogram_id')) .
                                CHtml::activeHiddenField($modBrgJasa, 'unitkerja_id', array('class' => 'barang_unitkerja_id')),
                ),
                array(
                    'header'=>'Volume',
                    'value' => 'number_format($data->sisavolume_pengadaan, 2, ",", ".")',
                    'filter' => false,
                    'htmlOptions'=>array('style'=>'text-align:right')
                ),
                array(
                    'header'=>'Harga Satuan',
                    'name'=>'harga_satuan',
                    'value'=>'MyFormatter::formatNumberForPrint($data->harga_satuan,2)',
                    'filter' => false,
                    'htmlOptions'=>array('style'=>'text-align:right')
                ),
                array(
                    'header'=>'Jumlah',
                    'name'=>'harga_satuan',
                    'value'=>function ($data){
                        return MyFormatter::formatNumberForPrint(($data->sisavolume_pengadaan * $data->harga_satuan),2);
                    },
                    'filter' => false,
                    'htmlOptions'=>array('style'=>'text-align:right')
                ),
        ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});cekListBarang();}',
)); 

$this->endWidget();
?>

<?php 

////========= Dialog untuk Obat  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogObat',
    'options' => array(
        'title' => 'Data Obat',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));
    
$modelObat = new ObatalkesM('search');
$modelObat->unsetAttributes();
$modelObat->obatalkes_aktif = true;
if (isset($_GET['ObatalkesM'])) {
    $modelObat->attributes = $_GET['ObatalkesM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obat-grid',
    'dataProvider' => $modelObat->search(),
    'filter' => $modelObat,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>function($data) {
                    $load = $data->attributes;                                
                    $load['barang_id'] = $data->obatalkes_id;
                    $load['barang_nama'] = $data->obatalkes_nama;
                    $res = json_encode($load);
                    return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"javascript:;",array("class"=>"btn-small", 
                            "onclick" => 'setNamaSPK('.$res.');'));
                },
        ),
        'obatalkes_nama',
        array(
            'name'=>'obatalkes_kategori',
            'filter'=> CHtml::activeHiddenField($modelObat, 'generik_id', array('class' => 'obat_generik_id')) . 
                        CHtml::activeDropDownList($modelObat, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array('empty'=>'-- Pilih --'))
        ),
        array(
            'name'=>'obatalkes_golongan',
            'filter'=> CHtml::activeDropDownList($modelObat, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array('empty'=>'-- Pilih --'))
        ),
        array(
            'header'=>'Satuan Kecil',
            'name'=>'satuankecil_nama',
            'type'=>'raw',
            'value'=>'$data->satuankecil->satuankecil_nama',
            'filter'=>CHtml::activeDropDownList($modelObat, 'satuankecil_id', CHtml::listData(
           SatuankecilM::model()->findAll(array('condition'=>'satuankecil_aktif = true', 'order'=>'satuankecil_nama asc')), 'satuankecil_id', 'satuankecil_nama'
            ), array('empty'=>'-- Pilih --')),
        ),
        array(
            'header'=>'SSHBJ',
            'name'=>'sshbj',
            'value'=>'MyFormatter::formatNumberForPrint($data->sshbj)',
            'filter'=>false,
            'htmlOptions'=>array('style'=>'text-align: right'),
        ),
        
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
    
$this->endWidget();
?>

<?php 

////========= Dialog untuk Obat  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogBarang',
    'options' => array(
        'title' => 'Data Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));
    
$modelBarang = new BarangM('search');
$modelBarang->unsetAttributes();
$modelBarang->barang_aktif = true;
if (isset($_GET['BarangM'])) {
    $modelObat->attributes = $_GET['BarangM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'barang-m-grid',
    'dataProvider' => $modelBarang->search(),
    'filter' => $modelBarang,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>function($data) {
                    $load = $data->attributes;                                
                    $load['barang_id'] = $data->barang_id;
                    $load['barang_nama'] = $data->barang_nama;
                    $res = json_encode($load);
                    return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"javascript:;",array("class"=>"btn-small", 
                            "onclick" => 'setNamaSPK('.$res.', obj);'));
                },
        ),
        'barang_kode',
        'barang_nama',
        array(
            'header'=>'SSHBJ',
            'name'=>'sshbj',
            'value'=>'MyFormatter::formatNumberForPrint($data->sshbj)',
            'filter'=>false,
            'htmlOptions'=>array('style'=>'text-align: right'),
        ),
        
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
    
$this->endWidget();
?>