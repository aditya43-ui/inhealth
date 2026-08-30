<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $itemCssClass = 'table table-striped table-condensed';
    $sort = true;
     $visible =  true;
    if (isset($caraPrint)){
        $data = $model->searchPrintInformasi();
        $template = "{items}";
        $sort = false;
        $visible = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
        
         if ($caraPrint == "PDF"){
            $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
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
                    border-spacing:0px;
                    padding:0px;
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>";
          $itemCssClass = 'table border';
    }   
     

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF'){
    
    
?>

 <table width="100%">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                        <br>
			<div class="judulcontent"> <?php echo $judulLaporan; ?></div>
                        <br>
                <?php $this->widget($table,array(
                        'id'=>'penutupan-grid',
                        'dataProvider'=>$data,
                        'template'=>$template,
                        'itemsCssClass'=>$itemCssClass,
                        'columns'=>array(
                            array(
                                'header' => 'No',
                                'type' => 'raw',
                                'value' => '$row+1'
                            ),
                            array(
                                'header'=>'Tanggal Penutupan',
                                'type' => 'raw',
                                'value'=>'MyFormatter::formatDateTimeForUser($data->tglpenutupan)',
                            ),
                             array(
                                'header'=>'No Penutupan',
                                'type' => 'raw',
                                'value'=>'$data->nopenutupan',
                            ),
                            array(
                                'header'=>'Periode Akuntansi',
                                'type'=>'raw',
                                'value'=>function($data) {
                                    $rek = RekperiodM::model()->findByPk($data->rekperiod_id);
                                    return $rek->deskripsi;
                                }
                            ),
                            array(
                                'header'=>'Saldo Debit',
                                'type'=>'raw',
                                'value'=>'MyFormatter::formatNumberForPrint($data->saldodebit)',
                                'htmlOptions'=>array('style'=>'text-align: right'),
                            ),
                            array(
                                'header'=>'Saldo Kredit',
                                'type'=>'raw',
                                'value'=>'MyFormatter::formatNumberForPrint($data->saldokredit)',
                                'htmlOptions'=>array('style'=>'text-align: right'),
                            ),
                            array(
                                'header'=>'Petugas',
                                'type'=>'raw',
                                'value'=>function($data) {
                                    $peg = PegawaiM::model()->findByPk($data->pegawai_id);
                                    return (isset($peg)? $peg->namaLengkap: "-");
                                }
                            ),
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
    <?php   if (isset($caraPrint) && $caraPrint!="PDF"){  ?>
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>   

<?php
}
if ($caraPrint == 'PDF'){
?>
<div class="header">
<?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
</div>
<div class="content">
     <br>
    <div class="judulcontent"> <?php echo $judulLaporan   ?></div>
     <br> 
     <?php $this->widget($table,array(
                        'id'=>'penutupan-grid',
                        'dataProvider'=>$data,
                        'template'=>$template,
                        'itemsCssClass'=>$itemCssClass,
                        'columns'=>array(
                            array(
                                'header' => 'No',
                                'type' => 'raw',
                                'value' => '$row+1'
                            ),
                            array(
                                'header'=>'Tanggal Penutupan',
                                'type' => 'raw',
                                'value'=>'MyFormatter::formatDateTimeForUser($data->tglpenutupan)',
                            ),
                             array(
                                'header'=>'No Penutupan',
                                'type' => 'raw',
                                'value'=>'$data->nopenutupan',
                            ),
                            array(
                                'header'=>'Periode Akuntansi',
                                'type'=>'raw',
                                'value'=>function($data) {
                                    $rek = RekperiodM::model()->findByPk($data->rekperiod_id);
                                    return $rek->deskripsi;
                                }
                            ),
                            array(
                                'header'=>'Saldo Debit',
                                'type'=>'raw',
                                'value'=>'MyFormatter::formatNumberForPrint($data->saldodebit)',
                                'htmlOptions'=>array('style'=>'text-align: right'),
                            ),
                            array(
                                'header'=>'Saldo Kredit',
                                'type'=>'raw',
                                'value'=>'MyFormatter::formatNumberForPrint($data->saldokredit)',
                                'htmlOptions'=>array('style'=>'text-align: right'),
                            ),
                            array(
                                'header'=>'Petugas',
                                'type'=>'raw',
                                'value'=>function($data) {
                                    $peg = PegawaiM::model()->findByPk($data->pegawai_id);
                                    return (isset($peg)? $peg->namaLengkap: "-");
                                }
                            ),
                        ),
                        
                        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                    )); ?>
</div>

<?php
}?>
