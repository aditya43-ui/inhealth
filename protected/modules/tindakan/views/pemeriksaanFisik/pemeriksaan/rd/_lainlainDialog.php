<?php

//=============================== Dialog Ruangan =======================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogRuanganRI',
    'options'=>array(
        'title'=>'Rawat Inap Ruangan',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1002,
        'minWidth'=>600,
        'minHeight'=>400,            
        'resizable'=>true,
    ),
));

$modRuangan = new RuanganM();
$modRuangan->unsetAttributes();
$modRuangan->ruangan_aktif = true;
$modRuangan->instalasi_id = array(Params::INSTALASI_ID_RI, Params::INSTALASI_ID_PERAWATAN_INTENSIF);

if(isset($_GET['RuanganM'])){
    $modRuangan->attributes=$_GET['RuanganM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'dialog-ruangan-m-grid',
    'dataProvider'=>$modRuangan->search(),
    'filter'=>$modRuangan,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>function($data) {
                return CHtml::Link('<i class="icon-form-check"></i>',"#",array("class"=>"btn-small", 
                            "onclick" => ' $("#tl_rawatinap_ruang").val("'.$data->ruangan_nama.'"); $("#dialogRuanganRI").dialog("close"); return false;'));
            },
        ),
        array(
            'name'=>'ruangan_nama',
        ),
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//=============================== Ebd Dialog Ruangan =======================================

//=============================== Dialog DPJP =======================================
$this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
        'id'=>'dialogDokterDPJP',
        'options'=>array(
            'title'=>'Dokter Penerima' ,
            'autoOpen'=>false,
            'width' => 840,
            'height' => 420,
            'resizable' => true,
        ),
    )
);

$format = new MyFormatter();
$modDPJP=new PegawaiV('search');
$modDPJP->unsetAttributes();
if(isset($_GET['PegawaiV'])){
    $modDPJP->attributes=$_GET['PegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'dialog-dpjp-m-grid',
    'dataProvider'=>$modDPJP->searchDokterDPJP(),
    'filter'=>$modDPJP,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>function($data) {
                return CHtml::Link('<i class="icon-form-check"></i>',"#",array("class"=>"btn-small", 
                            "onclick" => ' $("#dpjp").val("'.$data->namaLengkap.'"); $("#dialogDokterDPJP").dialog("close"); return false;'));
            },
        ),
        array(
            'name'=>'nama_pegawai',
            // 'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
            'value'=>'$data->namaLengkap',
        ),
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//=============================== END DPJP =======================================

//=============================== Dialog Ruangan =======================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogRujukan',
    'options'=>array(
        'title'=>'Rujukan',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1002,
        'minWidth'=>600,
        'minHeight'=>400,            
        'resizable'=>true,
    ),
));

$modRujukan = new RujukandariM;
$modRujukan->unsetAttributes();

if(isset($_GET['RujukandariM'])){
    $modRujukan->attributes=$_GET['RujukandariM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'dialog-rujukan-m-grid',
    'dataProvider'=>$modRujukan->search(),
    'filter'=>$modRujukan,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>function($data) {
                return CHtml::Link('<i class="icon-form-check"></i>',"#",array("class"=>"btn-small", 
                            "onclick" => ' $("#tl_rujuk_nama").val("'.$data->namaperujuk.'"); $("#tl_rujukandari_id").val("'.$data->rujukandari_id.'"); $("#dialogRujukan").dialog("close"); return false;'));
            },
            'filter'=>CHtml::activeHiddenField($modRujukan, 'asalrujukan_id', array('id'=>'dialog_asalrujukan_id')),
        ),
        array(
            'name'=>'namaperujuk',
        ),
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//=============================== End Dialog Ruangan =======================================

//=============================== Dialog Form Rujukan =======================================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogAddRujukanDari',
    'options'=>array(
        'title'=>'Menambah data Nama Rujukan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>450,
        'height'=>500,
        'resizable'=>false,
    ),
));

echo '<div class="divForFormRujukanDari"></div>';
$this->endWidget();

//=============================== End Dialog Form Rujukan =======================================