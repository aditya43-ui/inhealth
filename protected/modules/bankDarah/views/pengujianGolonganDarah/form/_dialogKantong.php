

<?php
/* ========= Dialog buat cari Kantong Darah ========================= */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogKantongDarah',
    'options' => array(
        'title' => 'Daftar Kantong Darah',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
    ),
));

$modKantong = new BDInfostokkantongdarahV('searchDialogPengujianKompatibilitas');
$modKantong->unsetAttributes();
if (isset($_GET['BDInfostokkantongdarahV'])){
    $modKantong->attributes = $_GET['BDInfostokkantongdarahV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'kantong-m-grid',
    'dataProvider'=>$modKantong->searchDialogPengujianKompatibilitas(),
    'filter'=>$modKantong,
    'template'=>"{summary}\n{items}{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $res = CJSON::encode($data->attributes);
    
                return CHtml::Link("<i class='icon-form-check'></i>","#",array("class"=>"btn-small", 
                                "id" => "selectBahan",
                                "onClick" => "
                                    $('#nokantongdarahpilih').val('" . $data->no_kantongdarah . "')
                                    setKantong(".$res.");
                                    $('#dialogKantongDarah').dialog('close');
                                    return false;"));
            },
        ),
        array(
            'header'=>'Nomor Kantong Darah',
            'name'=>'no_kantongdarah',
            'value'=>'$data->no_kantongdarah',
        ),
        'no_kantongpabrik',
        array(
            'header'=>'Golongan Darah',
            'name'=>'gol_darah',
            'value'=>'$data->gol_darah',
            'filter'=> CHtml::activeHiddenField($modKantong,'singkatan_komp').CHtml::activeDropDownList($modKantong, 'gol_darah', LookupM::getItems('golongandarah'),array('empty' => '-- Pilih --'))
        ),
        array(
            'header'=>'Rhesus',
            'name'=>'rhesus',
            'value'=>'$data->rhesus',
        ),
        array(
            'header'=>'Jenis Kantong',
            'name'=>'nama_jenis',
            'value'=>'$data->nama_jenis',
       ),               
    ),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});cekStok();}',
));
            
echo "<div id='note-stok' style='color:red;' ></div>";
            
$this->endWidget();
?>