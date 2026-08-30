<?php 
if ($caraPrint == 'GRAFIK' && $caraPrint != "PRINT"){
echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
echo $this->renderPartial('_grafik', array('model'=>$model, 'data'=>$data, 'caraPrint'=>$caraPrint), true); 
}

?>

<?php

$itemCssClass='table border';
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
     echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'colspan' => 4));
    
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
$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
if (isset($caraPrint)) {
    $data = $model->searchPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
  
} else {
    $data = $model->searchPrint();
    $template = "{summary}\n{items}\n{pager}";
}
if ($caraPrint == 'PRINT' && $caraPrint != "GRAFIK"){
    
    
?>

 <table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
               if ($caraPrint != "PDF" && $caraPrint != "EXCEL" && $caraPrint != "GRAFIK") {
    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'colspan' => 10));
} ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                       
     
                <?php $this->widget($table,array(
                'id'=>'tableLaporan',
                'dataProvider'=>$data,
                'enableSorting'=>$sort,
            //    'filter'=>$model,
                    'template'=>$template,
                    'itemsCssClass'=>'table border',
            //    'mergeColumns' => array('instalasi_nama'),
                'columns'=>array(
                    array(
                        'header' => 'No.',
                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                    ),
                    array(
                        'header'=>'Kode Diagnosa',
                        'value'=>'$data->diagnosa_kode',
                    ),
            //        'diagnosa_kode',
                    array(
                        'header'=>'Nama Diagnosa',
                        'value'=>'$data->diagnosa_nama',
                    ),
            //        'diagnosa_nama',
                    'jumlah',
                    
                    
                    /*
                    'ruangan_nama',
                    'instalasi_id',
                    * 'diagnosa_id',
                    'instalasi_nama',*/
                ),
            //        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            )); ?> 

		</div>		
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">

    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>

</div>   

<?php
}
if($caraPrint == 'PDF'){
    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'colspan' => 10));
    $this->widget($table,array(
        'id'=>'tableLaporan',
        'dataProvider'=>$data,
        'enableSorting'=>$sort,
    //    'filter'=>$model,
            'template'=>$template,
            'itemsCssClass'=>'table border',
    //    'mergeColumns' => array('instalasi_nama'),
        'columns'=>array(
            array(
                'header' => 'No.',
                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
            ),
            array(
                'header'=>'Kode Diagnosa',
                'value'=>'$data->diagnosa_kode',
            ),
    //        'diagnosa_kode',
            array(
                'header'=>'Nama Diagnosa',
                'value'=>'$data->diagnosa_nama',
            ),
    //        'diagnosa_nama',
            'jumlah',
            
            
            /*
            'ruangan_nama',
            'instalasi_id',
             * 'diagnosa_id',
            'instalasi_nama',*/
        ),
    //        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));

}


?>



