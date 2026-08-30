<style>
	 @page {
        margin-top: 12mm;
    }
	
	@media print {
        #headers {
            position: fixed;
            top: 0;
        }
        
        body {
            display:table;
            table-layout:fixed;
            padding-top:4cm;
            padding-left: 1mm;
            height:auto;
			width:100%;
        }
    }
</style>
<?php 
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}

//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode, 'colspan'=>10));  
$period = '';
if (!empty($model->periodeposting_id)){
	$period = PeriodepostingM::model()->findByPk($model->periodeposting_id)->periodeposting_nama;
}

if ($caraPrint != 'PDF'){
	echo "<div id='headers'>";
	echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> ucwords($period), 'colspan'=>10));  
	echo '</div>';
}else{
	//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> ucwords($period), 'colspan'=>10));  
}


$table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchSaldoAwalPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchByFilter();
         $template = "{summary}\n{items}\n{pager}";
    }
  ?>  

<?php 

$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
    'id'=>'obatalkes-m-grid',
    'dataProvider'=>$model->searchSaldoAwalPrint(), //RND-6011 
    'template'=>"{items}",
    'itemsCssClass'=>'table border',
    'columns'=>array(         
			array(
				'header' => 'No',
				'value' => '$row+1'
			),
            array(
				'header' => 'Nama Akun',
				'value' => '$data->kdrekening5." - ".$data->nmrekening5'
			),
            array(
				'header' => 'Mata Uang/<br/>Kurs',
				'type'=>'raw',
				'value'=> function($data){
					$mt = MatauangM::model()->findByPk($data->matauang_id);
					$kr = KursrpM::model()->findByPk($data->kursrp_id);
					
					
					$data = '';
					if (!empty($mt)){
						$data .= $mt->matauang;
					}else{
						$data .= 'Rupiah';
					}
					
					if (!empty($kr)){
						$data .= '/<br/>'.$kr->nilai.' - '.number_format($kr->rupiah,2,"",".");
					}					
					echo $data;
				}
			),
			array(
				'header' => 'Saldo Debit',
				'type'=>'raw',
				'value' => '!empty($data->jmlsaldoawald)?number_format($data->jmlsaldoawald,2,",","."):number_format(0,2,",",".")',
				'htmlOptions' => array('style' => 'text-align:right;')
			),
			array(
				'header' => 'Saldo Kredit',
				'type'=>'raw',
				'value' => '!empty($data->jmlsaldoawalk)?number_format($data->jmlsaldoawalk,2,",","."):number_format(0,2,",",".")',
				'htmlOptions' => array('style' => 'text-align:right;')
			),
    ),
        'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            //console.log("kick");
            
            $(".cekList").each(function() {setNol(this); });
            $("#obatalkes-m-grid .float2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2,"symbol":null})                                    
                }',
)); 

            ?>

<?php 
    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK' || $caraPrint == 'EXCEL' ){?>
        <div id="footer" style = "width:100%;">
             <div style = "display:inline-block;float:left;text-align:left;" >
                 <i><b>
                    Created At : 
                    <?php 
                        echo MyFormatter::formatDateTimeId(date('Y-m-d H:i:s'));
                    ?>
                </b></i>
             </div>
             <div style = "text-align:right;float:right;">
                 <i><b>
                    Created By : 
                    <?php 
                        echo $this->pageTitle=Yii::app()->user->nama_pemakai;
                    ?>
                </b></i>
             </div>
         </div>
<?php }?>