<?php

$caraPrint = isset($caraPrint)?$caraPrint:null;

$table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
$sort = true;
$visible = true;
$filter = $model;
$excel = false;

$row = '$row+1';
$visible = false;
$data = $model->searchPrint();
$data->pagination = false;
$template = "{items}";
$sort = false;
if ($caraPrint == "EXCEL"){
    $excel = true;
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
$filter = null;
$tableCss = 'grid prinout w100';


$this->widget($table, array(
    'id' => 'sajenis-kelas-m-grid',
    'enableSorting' => $sort,
    'dataProvider' => $data,
//    'filter'=>$filter,
    'template' => $template,
    'itemsCssClass' => $tableCss, 
    'mergeHeaders'=>array(
            array(
                    'name'=>'<center>Sampling</center>',
                    'start'=>3, //indeks kolom 3
                    'end'=>8, //indeks kolom 4
            ),           
    ),
    'mergeColumns'=>array('tahun','bulan'),
    'columns' => array(
        [
            'header' => 'Tahun',
            'name' => 'tahun',
            'type' => 'raw',
            'htmlOptions' => ['style'=>'text-align:center'],
            'value' => function($data){    
                $pecah = str_split($data['tahun']);
                
                $temp = '';
                foreach($pecah as $det){
                    $temp .= $det.'<br/>';
                }
                return '<h3><b>'.$temp.'</b></h3>';
            }
        ],
        [
            'header' => 'Bulan',
            'name' => 'bulan',
            'type' => 'raw',
            'htmlOptions' => ['style'=>'text-align:center'],
            'value' => function($data){
                $pecah = str_split($data['bulan']);
                
                $temp = '';
                foreach($pecah as $det){
                    $temp .= $det.'<br/>';
                }
                return '<h3><b>'.$temp.'</b></h3>';
            }
        ],
        [
            'header' => 'Tgl',
            'name' => 'tanggal',
             'htmlOptions' => ['style'=>'text-align:center;'],
            'value' => function($data){
                return $data['tanggal'];
            }
        ],        
       [
            'header' => 'Shift 1',
            'type' => 'raw',
            'headerHtmlOptions' => ['style'=>'text-align:center;'],
            'htmlOptions' => ['style'=>'text-align:center;'],
            'value' => function ($data) use ($excel){
                if ($data['ada_data'] == 'ada'){
                    return CustomFunction::set_pilihan_ceklis($data['is_shift1'], $excel);
                }
            }
        ],
        [
            'header' => 'ttd',
            'type' => 'raw',
            'headerHtmlOptions' => ['style'=>'text-align:center;'],
            'value' => function ($data) use ($excel){
                //return $data->pegawai_shift1_nama;
            }
        ],
        [
            'header' => 'Shift 2',
            'type' => 'raw',
            'headerHtmlOptions' => ['style'=>'text-align:center;'],
            'htmlOptions' => ['style'=>'text-align:center;'],
            'value' => function ($data) use ($excel){
                if ($data['ada_data'] == 'ada'){
                    return CustomFunction::set_pilihan_ceklis($data['is_shift2'], $excel);
                }
            }
        ],
        [
            'header' => 'ttd',
            'type' => 'raw',
            'headerHtmlOptions' => ['style'=>'text-align:center;'],
            'value' => function ($data) use ($excel){
                //return $data->pegawai_shift2_nama;
            }
        ],
        [
            'header' => 'Late Shift',
            'type' => 'raw',
            'headerHtmlOptions' => ['style'=>'text-align:center;'],
            'htmlOptions' => ['style'=>'text-align:center;'],
            'value' => function ($data) use ($excel){
                if ($data['ada_data'] == 'ada'){
                    return CustomFunction::set_pilihan_ceklis($data['is_lateshift'], $excel);
                }
            }
        ],
        [
            'header' => 'ttd',
            'type' => 'raw',
            'headerHtmlOptions' => ['style'=>'text-align:center;'],
            'value' => function ($data) use ($excel){
                //return $data->pegawai_lateshift_nama;
            }
        ],
        [
            'header' => 'Status',
            'type' => 'raw',
            'headerHtmlOptions' => ['style'=>'text-align:center;'],
            'value' => function ($data) use ($excel){
                return $data['status'];
            }
        ],       
    ),
    'afterAjaxUpdate' => 'function(id, data){
           
    }',
));
        
        echo $this->renderPartial($this->path_view.'_instruksi',[], true);
?>