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
                    'enableSorting'=>$sort,
                'dataProvider'=>$data,
                    'template'=>$template,
                    'itemsCssClass'=> $itemCssClass,
                'columns'=>array(
            //            'instalasi_nama',
            //            'carakeluar',
                        array(
                            'header'=>'Tindak Lanjut',
                            'type'=>'raw',
                            'value'=>'(empty($data->pasienpulang_id))?"PULANG":$data->carakeluar',
                        ),
                        array(
                            'header' => 'Tanggal Pendaftaran/ <br> No. Pendaftaran',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/ <br>".$data->no_pendaftaran'
                        ),            
                        'no_rekam_medik',
                        array(
                            'header' => 'Nama Pasien',
                            'value' => '$data->namadepan." ".$data->nama_pasien'
                        ),
                    //    'nama_pasien',
                        
                        'umur',
                        //'jeniskelamin',
                        array(
                            'header'=>'Nama Diagnosa',
                            'type'=>'raw',
                            //'value'=>'(!empty($data->diagnosa_nama))?$data->diagnosa_nama:""',
                        'value' => '$this->grid->getOwner()->renderPartial("tindakLanjut/_listDiagnosa",array("pendaftaran_id"=>$data->pendaftaran_id),true)'
                        ),
                        // 'diagnosa_nama',
            //            array(
            //                   'header'=>'CaraBayar/Penjamin',
            //                   'type'=>'raw',
            //                   'value'=>'$data->CaraBayarPenjamin',
            //                   'htmlOptions'=>array('style'=>'text-align: center')
            //            ),  
            //            'alamat_pasien',   
                ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
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
            'enableSorting'=>$sort,
        'dataProvider'=>$data,
            'template'=>$template,
            'itemsCssClass'=> $itemCssClass,
        'columns'=>array(
    //            'instalasi_nama',
    //            'carakeluar',
                array(
                    'header'=>'Tindak Lanjut',
                    'type'=>'raw',
                    'value'=>'(empty($data->pasienpulang_id))?"PULANG":$data->carakeluar',
                ),
                array(
                    'header' => 'Tanggal Pendaftaran/ <br> No. Pendaftaran',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/ <br>".$data->no_pendaftaran'
                ),            
                'no_rekam_medik',
                array(
                    'header' => 'Nama Pasien',
                    'value' => '$data->namadepan." ".$data->nama_pasien'
                ),
            //    'nama_pasien',
                
                'umur',
                //'jeniskelamin',
                 array(
                    'header'=>'Nama Diagnosa',
                    'type'=>'raw',
                    //'value'=>'(!empty($data->diagnosa_nama))?$data->diagnosa_nama:""',
                  'value' => '$this->grid->getOwner()->renderPartial("tindakLanjut/_listDiagnosa",array("pendaftaran_id"=>$data->pendaftaran_id),true)'
                ),
                // 'diagnosa_nama',
    //            array(
    //                   'header'=>'CaraBayar/Penjamin',
    //                   'type'=>'raw',
    //                   'value'=>'$data->CaraBayarPenjamin',
    //                   'htmlOptions'=>array('style'=>'text-align: center')
    //            ),  
    //            'alamat_pasien',   
        ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); 

}


?>



