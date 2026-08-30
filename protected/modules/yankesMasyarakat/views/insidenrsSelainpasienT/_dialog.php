<?php 
//========= Dialog buat cari data unitkerja =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogUnit',
    'options'=>array(
        'title'=>'Pencarian Data Satuan Kerja',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,
        'resizable'=>false,
    ),
));
$modDialogUnitKerja = new UnitkerjaM('search');
if(isset($_GET['UnitkerjaM'])) {
    $modDialogUnitKerja->attributes = $_GET['UnitkerjaM'];   
}
$modDialogUnitKerja->unitkerja_aktif = TRUE;
$modDialogUnitKerja->hasinstalasi = TRUE;

$this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'unitkerja-m-grid',
        'dataProvider'=>$modDialogUnitKerja->search(),
        'filter'=>$modDialogUnitKerja,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                    "id" => "selectPegawai",
                    "onClick" => "
                        $(\"#YKMInsidenrsSelainpasienT_unitkerja_pelapor_nama\").val(\"$data->namaunitkerja\");
                        $(\"#YKMInsidenrsSelainpasienT_unitkerja_pelapor_id\").val(\"$data->unitkerja_id\");
                        $(\"#dialogUnit\").dialog(\"close\");
                    "))',
            ),
            
            'namaunitkerja',
            array(
                'header' => 'Instalasi',
                'value' => '!empty($data->instalasi->instalasi_nama)?$data->instalasi->instalasi_nama:""'
            )
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
////======= unitkerja =============
?>