<?php
$model = new DraftasesmentriaseT('searchDialog');
$model->default = 'kosong';
if(isset($_GET['DraftasesmentriaseT'])){
    $model->attributes = $_GET['DraftasesmentriaseT'];        
    $model->default = isset($_GET['DraftasesmentriaseT']['default'])?$_GET['DraftasesmentriaseT']['default']:null;
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'draft-asesmen-triage-grid',
	'dataProvider'=>$model->searchDaftarTriase(),
	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Nama Pasien',
                    'type'=>'raw',
                    'filter' => CHtml::activeHiddenField($model, 'default'),
                    'value'=>function($data){    
                        $dt = $data->attributes;                                                
                        $res = json_encode($dt);
                        return CHtml::Link("<u>".$data->namapasien."</u>","javascript:;",array("class"=>"btn-small", 
                            "id" => "selectObat",
                            "onClick" => "
                                setPasien(".$res.",'')
                            return false;"));
                    },
                ),
                [
                    'header' => 'Tanggal',
                    'value' => '!empty($data->tglasesmentriase)?MyFormatter::formatDateTimeForUser($data->tglasesmentriase):""'
                ],
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
