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

$data = $model->search_riwayat_implementasi_by_rencana();

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'implementasi-t-grid',
    'dataProvider' => $data,
    'template' => $template,
    'itemsCssClass' => $itemCss,
    'columns' => array(
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => $row,
            'htmlOptions' => ['class'=>'identitas','style'=>'vertical-align:top;']
            
        ),
        array(
            'header' => 'Tgl. Implementasi',
            'name' => 'implementasiaskep_tgl',
            'value' => 'MyFormatter::formatDateTimeForUser($data["implementasiaskep_tgl"])',
            'htmlOptions' => ['class'=>'identitas','style'=>'vertical-align:top;']
        ),
        [
            'header' => 'Implementasi',
            'value' => function($data){
                if (!empty($data["det"])){
                    foreach($data["det"] as $det){
                        if (isset($det['imp'])){
                            echo "<ul>";
                            foreach($det['imp'] as $imp){
                                echo "<li>".$imp."</li>";
                            }
                            echo "</ul>";
                        }
                    }
                }
            },
            'htmlOptions' => ['class'=>'identitas','style'=>'vertical-align:top;']
        ],
        [
            'header' => '',
            'value' => function($data){
                if (!empty($data["det"])){
                    foreach($data["det"] as $det){
                        if (isset($det['indikator'])){
                            echo "<ul>";
                            foreach($det['indikator'] as $imp){
                                echo "<li>".$imp."</li>";
                            }
                            echo "</ul>";
                        }
                    }
                }
            },
            'htmlOptions' => ['class'=>'identitas','style'=>'vertical-align:top;']
        ],
        [
            'header' => 'Nama Pegawai',
            'value' => function($data){
                return $data['nama_pegawai'];
            },
            'htmlOptions' => ['class'=>'identitas','style'=>'vertical-align:top;']
        ],
        
    ),
    'afterAjaxUpdate' => 'function(id, data){
                 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                
            
            }',
));