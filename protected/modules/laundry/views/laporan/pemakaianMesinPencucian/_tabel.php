<?php

    $itemCssClass = 'table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';    
    $data = $model->search();    
    $visible = false;
    if (isset($caraPrint)){
        $visible = true;
        $itemCssClass = "w100 prinout grid";
        $labelvalidator = '<br/>(Paraf)';
        $row = '$row+1';
        $data->pagination = false;
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
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
        $template = "{summary}\n{items}\n{pager}";
    }    
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
    'template'=>$template,
    'enableSorting'=>$sort,
    'itemsCssClass'=>$itemCssClass,
    'columns' => array(
        [
            'header' => 'No',
            'value' => $row
        ],
        [
            'header' => 'Tanggal Pemakaian',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpencucianlinen)'
        ],
        'mesinpencucian_nama',      
        [
            'header'=>'Bahan Pencucian',
            'type'=>'raw',
            'value'=>function($data){
                $bahan = (json_decode($data->bahanperawatan_nama));
                echo '<ol>';
                foreach($bahan as $det){
                    echo "<li>".$det."</li>";
                }
                echo '</ol>';
            }   
        ],
        [
            'header' => 'Berat Cucian',
            'type' => 'raw',
            'value' => '$data->beratlinen." Kg"',           
        ]
    ),
    'afterAjaxUpdate' => 'function(id, data){
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});        
    }',
));
