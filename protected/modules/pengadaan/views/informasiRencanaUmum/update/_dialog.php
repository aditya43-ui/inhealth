<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPaketPekerjaan',
    'options' => array(
        'title' => 'Daftar Paket Pekerjaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));

$moKegiatan = new RupPaketV();
$moKegiatan->default = 'kosong';

if (isset($_GET['RupPaketV'])) {    
    $moKegiatan->attributes = $_GET['RupPaketV'];   
    $moKegiatan->default = isset($_GET['RupPaketV']['default'])?$_GET['RupPaketV']['default']:null;
}


$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'paketpekerjaan-m-grid',
    'dataProvider' => $moKegiatan->searchPaket(),
    'filter' => $moKegiatan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $res = $data->attributes;                               
                $res = json_encode($res);

                return CHtml::Link("<i class=\"icon-form-check\"></i>", "#", array(
                            "class" => "btn-small",
                            "onClick" => "setPaketPekerjaan(" . $res . ");                                 
                                $('#dialogPaketPekerjaan').dialog('close');return false;"
                    )
                );
            }
        ),
        array(
            'header'=>'Nama',
            'filter' => CHtml::activeHiddenField($moKegiatan, 'unitkerja_id').CHtml::activeHiddenField($moKegiatan, 'periodeanggaran_id').CHtml::activeTextField($moKegiatan, 'kode_paketpekerjaan'),
            'value'=>'$data->kode_paketpekerjaan'
        ),
        array(
            'header'=>'Sub Kegiatan',
            'filter' => CHtml::activeTextField($moKegiatan, 'subkegiatanprogram_nama'),
            'value'=>'$data->subkegiatanprogram_nama'
        ),
        array(
           
            'header'=>'Kode Rekening',
            'filter' => CHtml::activeTextField($moKegiatan, 'kodeanggaran'),
            'value'=>'$data->kodeanggaran'
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
    'dataProvider'=>$modBrgJasa->searchRAB(),
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
                                CHtml::activeHiddenField($modBrgJasa, 'instalasi_id', array('class' => 'barang_instalasi_id')) . 
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



/** pejabat pengadaan PA **/
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPA',
    'options'=>array(
            'title'=>'Pencarian Pejabat Pengadaan <span id="jenis_jabatan"></span>',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>800,
            'height'=>500,
            'resizable'=>false,
    ),
));
$modPA = new PejabatpengadaanM('search');
$modPA->default = 'ada';
if(isset($_GET['PejabatpengadaanM'])){
    $modPA->attributes = $_GET['PejabatpengadaanM'];
    $modPA->nomorindukpegawai = isset($_GET['PejabatpengadaanM']['nomorindukpegawai'])?$_GET['PejabatpengadaanM']['nomorindukpegawai']:null;
    $modPA->nama_pegawai = isset($_GET['PejabatpengadaanM']['nama_pegawai'])?$_GET['PejabatpengadaanM']['nama_pegawai']:null;
    $modPA->namaunitkerja = isset($_GET['PejabatpengadaanM']['namaunitkerja'])?$_GET['PejabatpengadaanM']['namaunitkerja']:null;
    $modPA->jabatan_nama = isset($_GET['PejabatpengadaanM']['jabatan_nama'])?$_GET['PejabatpengadaanM']['jabatan_nama']:null;
    $modPA->default = isset($_GET['PejabatpengadaanM']['default'])?$_GET['PejabatpengadaanM']['default']:null;    
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pejabatpa-m-grid',
    'dataProvider'=>$modPA->searchDialogPejabat(),
    'filter'=>$modPA,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>function($data) {
                            $load = $data->attributes;
                            $load['namaLengkap'] = $data->nama_lengkap;
                            $res = json_encode($load);
    
                            return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"javascript:;",array("class"=>"btn-small", 
                                    "onclick" => 'setPejabatPengadaan('.$res.');$("#dialogPA").dialog("close")'));
                        },
                ),               
                array(
                    'header'=>'NIP',
                    'name'=>'nomorindukpegawai',   
                    'filter'=> CHtml::activeHiddenField($modPA, 'jabatan_pengadaan').CHtml::activeTextField($modPA, 'nomorindukpegawai')
                ),
                array(
                    'header'=>'Nama',
                    'name'=>'nama_pegawai',                    
                    'value'=>'$data->nama_lengkap'
                ),
                array(
                    'header'=>'Jabatan',
                    'name'=>'jabatan_nama',                    
                ),
                array(
                    'header'=>'Unit Kerja',
                    'name'=>'namaunitkerja',                                       
                ),                
        ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();