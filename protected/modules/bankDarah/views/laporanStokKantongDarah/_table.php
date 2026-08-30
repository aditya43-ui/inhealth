<?php
$itemCssClass='table table-striped table-bordered table-condensed';
//    $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
    $sort = true;
if (isset($caraPrint)){
    $data = $model->searchPrintLaporan();
    $template = "{items}";
    $sort = false;
    
    if ($caraPrint == "EXCEL"){
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    
    if ($caraPrint == "PDF"){
        $itemCssClass='table border';
    }
    
    echo "
        <style>
            .border th, .border td{
                border:1px solid #000;
            }
            .table thead:first-child{
                border-top:1px solid #000;        
            }

            thead th{
                background:none;
                color:#333;
            }

            .border {
                box-shadow:none;
                border-spacing: 0;
                padding: 0;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
    $itemCssClass='table border';
} else{
    $data = $model->searchLaporan();
    $template = "{summary}\n{items}\n{pager}";
}
?>

<?php
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'laporanstokkantongdarah-v-grid',
                            'dataProvider' => $data,
                             'enableSorting'=>$sort,
                            'replaceUrl'=>true,
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => $itemCssClass,
                            'columns' => array(
                                array(
                                    'header'=>'No.',
                                    'value' => '($this->grid->dataProvider->pagination) ? 
                                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                    : ($row+1)',
                                    'type'=>'raw',
                                    'htmlOptions'=>array('style'=>'text-align:left;'),
                                ),
                                array(
                                    'header'=>'Jenis Komponen Darah',
                                    'value'=> '$data->singkatan_komp'
                                ),
                                array(
                                    'header'=>'Golongan Darah',
                                    'value'=>function($data){
                                            echo $data->gol_darah;
                                    },
                                ),
                                             array(
                                    'header' => 'Tanggal Pencatatan',
                                    'name'=>'tanggal', 
                                    'value' => function($data){
                                        if(!empty($data->tglpencatatan)){
                                            return MyFormatter::formatDateTimeForUser($data->tglpencatatan);
                                        }
                                    },
                                    'filter'=>false,  
                                ), 
                                array(
                                    'header' => 'Tanggal Kedaluwarsa',
                                    'name'=>'tanggal', 
                                    'value' => function($data){
                                        if(!empty($data->tgl_kadaluarsa)){
                                            return MyFormatter::formatDateTimeForUser($data->tgl_kadaluarsa);
                                        }
                                    },
                                    'filter'=>false,  
                                ), 
                                array(
                                    'header'=>'Stok Kantong Darah',
                                    'value'=>function($data){
                                            return $data->getStokKantongDarahLaporan($data->singkatan_komp,$data->gol_darah,$data->tgl_kadaluarsa);
                                    },
                                ),
                                array(
                                    'header'=>'Stok Darah Siap',
                                    'value'=>function($data){
                                            echo $data->getStokDarahSiapLaporan($data->singkatan_komp,$data->gol_darah,$data->tgl_kadaluarsa);
                                    },
                                ),
                                array(
                                    'header'=>'Stok Keluar',
                                    'value'=>function($data){
                                            echo $data->getStokDarahKeluarLaporan($data->singkatan_komp,$data->gol_darah,$data->tgl_kadaluarsa);
                                    },
                                ),
                            ),
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                        ));
                        ?>   