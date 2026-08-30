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
	
	.btn-danger{
		background-color: #a91e1e;
		border:#981b1b 1px solid;		
	}
	
</style>
<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF'){
    
    
?>

 <table style="width: 100%; border: none;">
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
			<div class="judulcontent"> <?php echo $judulLaporan   ?> <br> <?php echo $periode   ?></div>
                        <br>
                <?php  $ruanganAsal = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'))->ruangan_nama;?>
<div style="text-align: center;">
    <!--<h2><?php //echo $judulLaporan; ?></h2>-->
   <!--<b>Periode : <?php //echo $periode; ?></b><br>-->
    <b>Ruangan : <?php echo $ruanganAsal; ?></b>
</div>

							<?php 
                                                        $subtotal = 0;
                                                        
                                                        $prov = $modFaktur->searchPrint();
                                                        $cloneProv = clone $prov;
                                                        
                                                        foreach ($cloneProv->data as $dataClone){
                                                            $subtotal += $dataClone->totalhutangusaha;
                                                        }
							$this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
								'id'=>'fakturpembelianumum-m-grid',
								'dataProvider'=>$modFaktur->searchPrint(),
								'template'=>"{items}",
                                                            'enableSorting'=>false,
								'itemsCssClass'=>'table table-bordered table-striped table-condensed',
								'columns'=>array(
									array(
										'header'=>'Tanggal Faktur',
										'type'=>'raw',
										'value'=>'MyFormatter::formatDateTimeForUser($data->tglfaktur)',
                                                                                'footer'=>'Total :',
										'footerHtmlOptions'=>array('colspan'=>16,'style'=>'text-align:right;'),
									),
									'nofaktur',
									array(
										'header'=>'Tanggal Terima',
										'type'=>'raw',
										'value'=>'MyFormatter::formatDateTimeForUser($data->tglterima)',
									),
									'nopenerimaan',
									array(
										'header' => 'No. Permintaan',
										'type' => 'raw',
										'value' => '$data->nopembelian',
									),
									'supplier_nama',
									array(
										'header' => 'Tanggal Jatuh Tempo',
										'name' => 'tgljatuhtempo',
										'value' => 'MyFormatter::formatDateTimeForUser($data->tgljatuhtempo)'
									),                    
									array(
										'header'=>'Keterangan Faktur',
										'type'=>'raw',
										'value'=>'$data->keteranganfaktur',
									),
                                                                        array(
										'header'=>'Syarat Bayar',
										'type'=>'raw',
										'value'=>'$data->syaratbayar_nama',
									),
									array(
										'header'=>'Umur Utang',
										'type'=>'raw',
										'value'=>'$data->getUmurHutang($data->tgljatuhtempo, $data->tglfaktur)',
										'htmlOptions' => array('style'=>'text-align:right;')
									),
									array(
										'header'=>'Total Harga',
										'name'=>'totalharga',
										'type'=>'raw',
										'value'=>'number_format($data->totalharga,2,",",".")',
										'htmlOptions' => array('style'=>'text-align:right;')
									),
									
									array(
										'header '=> 'Keringanan',
										'name'=>'discount',
										'type'=>'raw',
										'value'=>'number_format($data->discount,2,",",".")',   
										'htmlOptions' => array('style'=>'text-align:right;')
									),
									array(
										'header'=>'Total Pajak PPN',
										'name'=>'pajakppn',
										'type'=>'raw',
										'value'=>'number_format($data->pajakppn,2,",",".")',
										'htmlOptions' => array('style'=>'text-align:right;')
									),      
                                                                    array(
										'header'=>'Total Pajak PPh',
										'name'=>'pajakpph',
										'type'=>'raw',
										'value'=>'number_format($data->pajakpph,2,",",".")',
										'htmlOptions' => array('style'=>'text-align:right;')
									),
									array(
										'header'=>'Total Keseluruhan',
										'type' => 'raw',
										'value'=>'number_format($data->totalkeseluruhan,2,",",".")',
										'htmlOptions' => array('style'=>'text-align:right;')
									),
                                                                    array(
                                                                        'header'=>'Jumlah Uang Muka',
                                                                        'type' => 'raw',
                                                                        'value'=>'number_format($data->jlmuangmukabeli,2,",",".")',
                                                                        'htmlOptions' => array('style'=>'text-align: right;'),
									),
                                                                    array(
                                                                        'header'=>'Total Harga Netto',
                                                                        'type' => 'raw',
                                                                        'value'=>'number_format($data->totalhutangusaha,2,",",".")',
                                                                        'htmlOptions' => array('style'=>'text-align: right;'),
                                                                        'footer'=>number_format($subtotal,2,",","."),
										'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                                                                    ),
								),
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
    <div class="judulcontent"> <?php echo $judulLaporan   ?> <br> <?php echo $periode   ?></div>
     <br>
<?php  $ruanganAsal = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'))->ruangan_nama;?>
<div style="text-align: center;">
    <!--<h2><?php //echo $judulLaporan; ?></h2>-->
   <!--<b>Periode : <?php //echo $periode; ?></b><br>-->
    <b>Ruangan : <?php echo $ruanganAsal; ?></b>
</div>

							<?php 
							$this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
								'id'=>'fakturpembelianumum-m-grid',
								'dataProvider'=>$modFaktur->searchPrint(),
								'template'=>"{items}",
								'itemsCssClass'=>'table table-bordered table-striped table-condensed',
								'columns'=>array(
									array(
										'header'=>'Tanggal Faktur',
										'type'=>'raw',
										'value'=>'MyFormatter::formatDateTimeForUser($data->tglfaktur)',
                                                                                'footer'=>'Total :',
										'footerHtmlOptions'=>array('colspan'=>14,'style'=>'text-align:right;'),
									),
									'nofaktur',
									array(
										'header'=>'Tanggal Terima',
										'type'=>'raw',
										'value'=>'MyFormatter::formatDateTimeForUser($data->tglterima)',
									),
									'nopenerimaan',
									array(
										'header' => 'No. Permintaan',
										'type' => 'raw',
										'value' => '$data->nopembelian',
									),
									'supplier_nama',
									array(
										'header' => 'Tanggal Jatuh Tempo',
										'name' => 'tgljatuhtempo',
										'value' => 'MyFormatter::formatDateTimeForUser($data->tgljatuhtempo)'
									),                    
									array(
										'header'=>'Keterangan Faktur',
										'type'=>'raw',
										'value'=>'$data->keteranganfaktur',
									),
                                                                        array(
										'header'=>'Syarat Bayar',
										'type'=>'raw',
										'value'=>'$data->syaratbayar_nama',
									),
									array(
										'header'=>'Umur Utang',
										'type'=>'raw',
										'value'=>'$data->getUmurHutang($data->tgljatuhtempo, $data->tglfaktur)',
										'htmlOptions' => array('style'=>'text-align:right;')
									),
									array(
										'header'=>'Total Harga',
										'name'=>'totalharga',
										'type'=>'raw',
										'value'=>'number_format($data->totalharga,2,",",".")',
										'htmlOptions' => array('style'=>'text-align:right;')
									),
									
									array(
										'header '=> 'Keringanan',
										'name'=>'discount',
										'type'=>'raw',
										'value'=>'number_format($data->discount,2,",",".")',   
										'htmlOptions' => array('style'=>'text-align:right;')
									),
									array(
										'header'=>'Total Pajak PPN',
										'name'=>'pajakppn',
										'type'=>'raw',
										'value'=>'number_format($data->pajakppn,2,",",".")',
										'htmlOptions' => array('style'=>'text-align:right;')
									),      
                                                                    array(
										'header'=>'Total Pajak PPh',
										'name'=>'pajakpph',
										'type'=>'raw',
										'value'=>'number_format($data->pajakpph,2,",",".")',
										'htmlOptions' => array('style'=>'text-align:right;')
									),
									array(
										'header'=>'Total Keseluruhan',
										'type' => 'raw',
										'value'=>'number_format($data->totalkeseluruhan,2,",",".")',
										'htmlOptions' => array('style'=>'text-align:right;')
									),
                                                                    array(
                                                                        'header'=>'Jumlah Uang Muka',
                                                                        'type' => 'raw',
                                                                        'value'=>'number_format($data->jlmuangmukabeli,2,",",".")',
                                                                        'htmlOptions' => array('style'=>'text-align: right;'),
									),
                                                                    array(
                                                                        'header'=>'Total Harga Netto',
                                                                        'type' => 'raw',
                                                                        'value'=>'number_format($data->totalhutangusaha,2,",",".")',
                                                                        'htmlOptions' => array('style'=>'text-align: right;'),
                                                                        'footer'=>number_format($subtotal,2,",","."),
										'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                                                                    ),
								),
							)); ?>

</div>

<?php
}

 ?>