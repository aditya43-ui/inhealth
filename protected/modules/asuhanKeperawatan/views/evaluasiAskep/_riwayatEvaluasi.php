<?php
$itemCss = 'table table-striped table-bordered table-condensed';
$template = "{summary}\n{items}\n{pager}";
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';

if (isset($caraPrint)){
    $template = "{items}";
    $row = '$row+1';
    $itemCss = 'grid grubrincian rincian-detail';
    $model->load_all = true;
}

$data = $model->search_riwayat_evaluasi_by_rencana();

$this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp', array(
    'id' => 'implementasi-t-grid',
    'dataProvider' => $data,
    'template' => $template,
    'itemsCssClass' => $itemCss,
    'mergeColumns'=>array('evaluasiaskep_tgl', 'nourut', 'nama_pegawai'),
    'columns' => array(
        array(
            'header' => 'No.',
            'type' => 'raw',
            'name' => 'nourut',
            'value' => '$data["nourut"]',
            'htmlOptions' => ['class'=>'identitas','style'=>'vertical-align:top !important;']
            
        ),
        array(
            'header' => 'Tgl. Evaluasi',
            'name' => 'evaluasiaskep_tgl',
            'value' => '$data["evaluasiaskep_tgl"]',
            'htmlOptions' => ['class'=>'identitas','style'=>'vertical-align:top !important;']
        ),
         [
            'header' => 'Evaluasi',
            'value' => function($data){
                return $data['evaluasi'];
            },
            'htmlOptions' => ['class'=>'identitas','style'=>'vertical-align:top;']
        ],
        [
            'header' => 'Hasil',
            'type'=>'raw',
            'value' => function($data){
                return $data['evaluasi_hasil'];
            },
            'htmlOptions' => ['class'=>'identitas','style'=>'vertical-align:top;']
        ],
        [
            'header' => 'Nama Perawat',
            'name' => 'nama_pegawai',
            'type' => 'raw',
            'value' => function($data){
                return $data['nama_pegawai'].'<span style="display:none;">'.$data['nourut'].'</span>';
            },
                    
            'htmlOptions' => ['class'=>'identitas','style'=>'vertical-align:top !important;']
        ],
        
    ),
    'afterAjaxUpdate' => 'function(id, data){
                 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                
            
            }',
));