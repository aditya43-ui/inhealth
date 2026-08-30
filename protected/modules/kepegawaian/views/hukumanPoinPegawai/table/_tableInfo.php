<?php 
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'kpinfohukumanpoinpeg-v-grid',
    'dataProvider'=>$model->searchInformasi(),   
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header' => 'No.',				
            'filter' => false,
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
            'headerHtmlOptions' => array('style' => 'text-align:center')
        ),
        array(
            'name' => 'poinpegawai_tgl',
            'value' => 'MyFormatter::formatDateTimeForUser($data->poinpegawai_tgl)'
        ),
        array(
            'name' => 'nama_pegawai',            
        ),
        array(
            'name' => 'nama_pembuat',            
        ),
       array(
            'name' => 'poinpegawai_alasan',            
        ),
        array(
            'header' => 'Detail',
            'type' => 'raw',
            'value' => function($data){
                return CHtml::link("<i class='".MyIcon::getIcons('lihat2')."'>",Yii::app()->controller->createUrl('/'.Yii::app()->controller->module->id."/".Yii::app()->controller->id."/detail",array("id"=>$data->poinpegawai_id)),array('rel'=>'tooltip','title'=>'Klik ikon ini, jika Anda ingin menampilkan <b>detail data nilai poin</b>', 'data-html'=>true,"id"=>"$data->poinpegawai_id","target"=>"frameDetail", "onclick"=>"window.parent.$('#dialogDetail').dialog('open');"));
            }
        ),
    ),
   'afterAjaxUpdate'=>'function(id, data){
        jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
        $("table").find("input[type=text]").each(function(){
            cekForm(this);
        })
    }',
)); ?>                   