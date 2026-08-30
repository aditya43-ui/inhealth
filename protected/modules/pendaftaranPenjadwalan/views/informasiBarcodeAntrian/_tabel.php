<?php

$caraPrint = isset($caraPrint)?$caraPrint:null;

$table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
$sort = true;
$visible = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
$filter = $model;
$data = $model->searchRiwayatPanggil2();
if (isset($caraPrint)) {
    $row = '$row+1';
    $visible = false;
    $data->pagination = false;
    
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL"){
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    $filter = null;
} else {
    
    $template = "{summary}\n{items}\n{pager}";
}

$this->widget($table, array(
    'id' => 'daftar-penunjang-grid',
    'enableSorting' => $sort,
    'dataProvider' => $data,
    'template' => $template,
    'itemsCssClass' => 'table table-striped table-bordered table-condensed', 
    'columns' => array(
        array(
          'header'=>'No.',
          'value'=>'(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
          'type'=>'raw',
        ),
        'jam_panggil',
        'barcode',
        array(
            'header' => 'No. Antrian',
            'value'  => function($data) {
                if($data->modelantrian_id == 1) {
                    // return $data->modelantrian_singkatan;
                    echo $data->modelantrian_singkatan . '-'. $data->noantrian;
                } else {
                    echo $data->ruangan_singkatan . '-' .$data->noantrian;
                }
            }
        ),
        // 'noantrian',
        [
            'header' => 'Poliklinik',
            'name' => 'ruangan_nama'
        ],        
        'status_barcode',
        [
            'name' => 'jenis_kunjungan',
            'type' => 'raw',
            'value' => function($data){
                if ($data->jenis_kunjungan == ParamsConst::JENIS_KUNJUNGAN_ANTRIAN_FASTTRACK){
                    return $data->jenis_kunjungan;
                }else{
                    return CHtml::link('<i class="'.MyIcon::getIcons('ubah').'"></i> '.$data->jenis_kunjungan, 'javascript:;', ['onclick'=>'ubahFasttrack('.$data->antrian_id.',"generate");', 'class'=>'btn btn-default', 'rel'=>'tooltip', 'title'=>'Klik untuk mengubah ke jenis kunjungan fast track']);
                }
            }
        ],
        [
            'header' => '<center>Aksi</center>',
            'type' => 'raw',
            'value' => function($data){
                $statusbarcode = strtolower($data->status_barcode);
                
                if ($statusbarcode == 'belum barcode'){
                    return CHtml::link("Barcode",'javascript:;',['style'=>'width:150px;','class'=>'btn btn-warning','onclick'=>'showBarcode('.$data->antrian_id.');']);
                }else if($statusbarcode == 'sudah barcode'){
                    return CHtml::link("Cetak Ulang Karcis",'javascript:;',['style'=>'width:150px;','class'=>'btn btn-danger','onclick'=>'print('.$data->antrian_id.');']);
                }else if($statusbarcode == 'terlambat'){
                    return CHtml::link("Aktifkan",'javascript:;',['style'=>'width:150px;','class'=>'btn btn-info','onclick'=>"prosesSimpan('".$data->barcode."','aktifkan',".$data->antrian_id.");"]);
                }
            },            
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ]
        ]
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});            
    }',
));
?>
