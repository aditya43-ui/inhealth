<?php

/**
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * 
 * Dialog Terapi Obat
 */

//========= Dialog buat cari data Alat Kesehatan (RACIKAN)  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogTerapiObat',
    'options'=>array(
        'title'=>'Terapi Obat',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>480,
        'height'=>320,
        'resizable'=>false,
    ),
));

$modTherapiobat = new RITherapiobatM('search');
$modTherapiobat->unsetAttributes();
if(isset($_GET['RITherapiobatM'])){
//    $modTherapiobat->attributes = $_GET['RITherapiobatM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'therapiobat-grid',
	'dataProvider'=>$modTherapiobat->searchDialog(),
	'filter'=>$modTherapiobat,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
												$(\"#therapiobat_id\").val(\"$data->therapiobat_id\"); 
												$(\"#therapiobat_nama\").val(\"$data->therapiobat_nama\"); 
                                                $(\'#dialogTerapiObat\').dialog(\'close\');
												setOAJoinTerapi();
											return false;"))',
                ),
				'therapiobat_nama',
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>