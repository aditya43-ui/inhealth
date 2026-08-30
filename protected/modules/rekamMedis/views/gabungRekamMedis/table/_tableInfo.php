<?php
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'kpinfohukumanpoinpeg-v-grid',
    'dataProvider' => $model->searchInformasi(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'No.',
            'filter' => false,
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
        ),
        array(
            'header' => 'Tanggal Gabung',
            'name' => 'tglmerge',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglmerge)'
        ),
        array(
            'header' => 'No. Rekam Medik Lama',
            'value' => '$data->pasienlama->no_rekam_medik'
        ),
        array(
            'header' => 'Nama Pasien Lama',
            'value' => '$data->pasienlama->nama_pasien'
        ),
        array(
            'header' => 'No. Rekam Medik Baru',
            'value' => '$data->pasienbaru->no_rekam_medik'
        ),
        array(
            'header' => 'Nama Pasien Baru',
            'value' => '$data->pasienbaru->nama_pasien'
        ),
        //        array(
        //            'header' => 'Detail',
        //            'type' => 'raw',
        //            'value' => function($data){
        //                return CHtml::link("<i class='".MyIcon::getIcons('lihat2')."'>",Yii::app()->controller->createUrl('/'.Yii::app()->controller->module->id."/".Yii::app()->controller->id."/detailgabung",array("id"=>$data->mergerekammedik_id)),array('rel'=>'tooltip','title'=>'Klik ikon ini, jika anda ingin menampilkan <b>detail data penggabungan</b>'));
        //            }
        //        ), 
        array(
            'header' => 'Operator',
            'value' => '$data->getLoginpemakaiItems($data->create_loginpemakai_id)'
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
        $("table").find("input[type=text]").each(function(){
            cekForm(this);
        })
    }',
));
