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
                    'name'=>'<center>Brine Tank Inspection</center>',
                    'start'=>1, //indeks kolom 3
                    'end'=>3, //indeks kolom 4
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
            'value' => function($data){
                return $data['tanggal'];
            }
        ],
        [
            'header' => 'Jam',
            'value' => '""'
        ],
        [
            'header' => 'Water Level',
            'type' => 'raw',
            'headerHtmlOptions' => ['style'=>'text-align:center;'],
            'htmlOptions' => ['style'=>'text-align:center;'],
            'value' => function ($data) use ($excel){
                if (!empty($data['nama_pegawai'])){
                    return CustomFunction::set_pilihan_ceklis($data['is_waterlevel'], $excel);
                }
            }
        ],
        [
            'header' => 'Water Condition',
            'type' => 'raw',
            'headerHtmlOptions' => ['style'=>'text-align:center;'],
            'htmlOptions' => ['style'=>'text-align:center;'],
            'value' => function ($data) use ($excel){
                if (!empty($data['nama_pegawai'])){
                    return CustomFunction::set_pilihan_ceklis($data['is_watercondition'], $excel);
                }
            }
        ],
        [
            'header' => 'Salt Bridge',
            'type' => 'raw',
            'headerHtmlOptions' => ['style'=>'text-align:center;'],
            'htmlOptions' => ['style'=>'text-align:center;'],
            'value' => function ($data) use ($excel){
                if (!empty($data['nama_pegawai'])){
                    return CustomFunction::set_pilihan_ceklis($data['is_saltbridge'], $excel);
                }
            }
        ],
        [
            'header' => 'Salt Adding Procedure',
            'type' => 'raw',
            'headerHtmlOptions' => ['style'=>'text-align:center;'],
            'htmlOptions' => ['style'=>'text-align:center;'],
            'value' => function ($data) use ($excel){
                if (!empty($data['nama_pegawai'])){
                    return CustomFunction::set_pilihan_ceklis($data['is_saltaddingprocedure'], $excel);
                }
            }
        ],
        [
            'header' => 'Pegawai',
            'type' => 'raw',
            'name' => 'nama_pegawai'
        ],        
    ),
    'afterAjaxUpdate' => 'function(id, data){
           
    }',
));
        
        echo $this->renderPartial($this->path_view.'_instruksi',[], true);
?>