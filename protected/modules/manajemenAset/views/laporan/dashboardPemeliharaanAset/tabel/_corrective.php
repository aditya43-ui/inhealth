<?php

$caraPrint = isset($caraPrint)?$caraPrint:null;

$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
$visible = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
$filter = $model;
$data = $model->searchDashboardCorrective();
$template = "{items}";

$this->widget($table, array(
    'id' => 'invperalatan-grid',
    'enableSorting' => $sort,
    'dataProvider' => $data,    
    'template' => $template,
    'itemsCssClass' => 'table table-striped table-bordered table-condensed', 
    'columns' => array(        
        [
            'header' => 'Peralatan',
            'type' => 'raw',
            'name' => 'invperalatan_namabrg',
            'value' => function($data){
                return $data->invperalatan_namabrg.'<br/>'.$data->invperalatan_kode.'<br/>'.$data->lokasiaset_namalokasi;
            }
        ],
        array(
            'header'=>'Status',
            'type'=>'raw',
            'value'=>function($data) {
                if (ucwords($data->korektifmainten_status) == ParamsConst::STATUSDOKUMENOPEN ) {
                    return '<button style="width:120px;" id="red" class="btn btn-danger" name="yt1" onclick="setStatus('.$data->korektifmainten_id.',\''.Params::STATUSDOKUMENINPROGRESS.'\'); ">'.ucwords($data->korektifmainten_status).'</button>';   
                }else if (($data->korektifmainten_status) == ParamsConst::STATUSDOKUMENPENDING ) {
                    return '<button style="width:120px;" id="red" class="btn btn-gold" name="yt1" onclick="setStatus('.$data->korektifmainten_id.',\''.Params::STATUSDOKUMENINPROGRESS.'\'); ">'.ucwords($data->korektifmainten_status).'</button>';   
                }else if($data->korektifmainten_status ==  ParamsConst::STATUSDOKUMENINPROGRESS) {                                                    
                    $btn = '<button  style="width:120px;"  type="button" class="btn btn-blue">In Progress</button>';
                    return $btn;                                                    
                }else if (($data->korektifmainten_status) == ParamsConst::STATUSDOKUMENFINISH ) {
                        $click='';
                        return '<button style="width:120px;" id="red" class="btn btn-info" name="yt1" onclick="'.$click.'">'.$data->korektifmainten_status.'</button>';   
                }else if(($data->korektifmainten_status) == ParamsConst::STATUSDOKUMENCLOSE ){
                    return '<button style="width:120px;" id="red" class="btn btn-success" name="yt1">'.$data->korektifmainten_status.'</button>';   
                }else{
                    return '<button style="width:120px;" id="red" class="btn btn-purple" name="yt1">'.$data->korektifmainten_status.'</button>';   
                }
                    
            }
        ), 
    ),
    'afterAjaxUpdate' => 'function(id, data){    
                
    }',
));
?>