<style>
	 @page {
/*        margin-top: 12mm;*/
    }
	
	@media print {
        #headers {
            position: fixed;
            top: 0;
        }
        
        body {
            display:table;
            table-layout:fixed;
/*            padding-top:4cm;
            padding-left: 1mm;*/
            height:auto;
			width:100%;
        }
    }
</style>

<?php

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judul_print, 'periode' => "", 'colspan' => 5));
}

//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF'){
    
    
?>

 <table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                        if ($caraPrint != 'EXCEL') {
                            echo $this->renderPartial('application.views.headerReport.headerDefaultNewest', array('judulLaporan' => $judul_print, 'periode' => ""));
                        }
                        ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                        <br>
			<div class="judulcontent"> <?php //echo $judul_print   ?> <br> <?php echo ""   ?></div>
                        <br>
                        <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
				<tr>
                                    <td width="10%">Kode</td>
                                    <td width="15%">: <?php echo $model->obatalkes_kode; ?></td>
                                    <td width="10%">Satuan Besar</td>
                                    <td width="15%">: <?php echo $model->satuanbesar_nama; ?></td>
                            </tr>
				<tr>
					<td>Nama</td>
					<td>: <?php echo $model->obatalkes_nama; ?></td>
					<td>Satuan Kecil</td>
					<td>: <?php echo $model->satuankecil_nama; ?></td>
				</tr>
				<tr>
					<td>Jenis Obat Alkes</td>
					<td>: <?php echo $model->jenisobatalkes_nama; ?></td>
					<td>Isi Kemasan</td>
					<td>: <?php echo $model->isikemasan; ?></td>
				</tr>
			</table>
                        <br>
                <?php  $this->renderPartial($this->path_view.'_tableBaru', array('model2'=>$model2, 'caraPrint'=>$caraPrint, 'pilihTgl'=>$pilihTgl)); ?>
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
    <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNewest', array('judulLaporan' => $judul_print, 'periode' => "")); ?>
</div>
<div class="content">
 
     <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
				<tr>
                                    <td width="10%">Kode</td>
                                    <td width="15%">: <?php echo $model->obatalkes_kode; ?></td>
                                    <td width="10%">Satuan Besar</td>
                                    <td width="15%">: <?php echo $model->satuanbesar_nama; ?></td>
                            </tr>
				<tr>
					<td>Nama</td>
					<td>: <?php echo $model->obatalkes_nama; ?></td>
					<td>Satuan Kecil</td>
					<td>: <?php echo $model->satuankecil_nama; ?></td>
				</tr>
				<tr>
					<td>Jenis Obat Alkes</td>
					<td>: <?php echo $model->jenisobatalkes_nama; ?></td>
					<td>Isi Kemasan</td>
					<td>: <?php echo $model->isikemasan; ?></td>
				</tr>
			</table>
                        <br>
<?php $this->renderPartial($this->path_view.'_tableBaru', array('model2'=>$model2, 'caraPrint'=>$caraPrint, 'pilihTgl'=>"")); ?>
</div>

<?php
}
 ?>


