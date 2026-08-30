<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel',array('judulLaporan'=>$judulLaporan, 'colspan'=>5)); ?>
    <div class="header">
    <?php //echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
    </div>
    <div class="content">
    
<table bgcolor='white' class='table' style = "box-shadow:none;">
    <tr bgcolor='white' >
        <td>
             <b><?php echo CHtml::encode($model->getAttributeLabel('nopengajuan')); ?></b>
        </td>
        <td>
            : <?php echo CHtml::encode($model->nopengajuan); ?>
        </td>
        <td>
            &nbsp;
        </td>    
        <td>
            <b>Jumlah Orang</b>            
        </td>
        <td>: <?php echo CHtml::encode($model->jmlorang); ?></td>
    </tr>
    <tr>
        <td>
             <b><?php echo CHtml::encode($model->getAttributeLabel('tglpengajuan')); ?></b>
        </td>
        <td>
            : <?php echo !empty($model->tglpengajuan)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($model->tglpengajuan)))):"-" ?>
        </td>
        <td>
            &nbsp;
        </td> 
         <td>
            <b>Untuk Keperluan</b>            
        </td>
        <td>: <?php echo CHtml::encode($model->untukkeperluan); ?></td>
        
     <tr>
          <td>
            <b>keterangan</b>            
        </td>
        <td>: <?php echo CHtml::encode($model->keterangan); ?></td>
        <td>
            &nbsp;
        </td> 
        <td>
            &nbsp;
        </td> 
        <td>
            &nbsp;
        </td> 
    </tr>
</table>
<table style="width: 100%; border: none;">
	<tr>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="2">
		<?php 
		if(isset($model->tgl_mengetahui)){ ?>
			Mengetahui,
			<br><br><br><br><br><br>
			( <?php echo $model->namaLengkapMengetahui;?> )
		<?php } ?>			
		</th>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="2">
			Menyetujui,
			<br><br><br><br><br><br>
			( <?php echo $model->namaLengkapMenyetujui;?> )
		</th>
	</tr>
</table>
    </div>
    
<?php } 
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF' && $caraPrint != 'EXCEL'){
    
    
?>

 <table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => ''));
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                <table bgcolor='white' class='table' style = "box-shadow:none;">
    <tr bgcolor='white' >
        <td>
             <b><?php echo CHtml::encode($model->getAttributeLabel('nopengajuan')); ?></b>
        </td>
        <td>
            : <?php echo CHtml::encode($model->nopengajuan); ?>
        </td>
        <td>
            &nbsp;
        </td>    
        <td>
            <b>Jumlah Orang</b>            
        </td>
        <td>: <?php echo CHtml::encode($model->jmlorang); ?></td>
    </tr>
    <tr>
        <td>
             <b><?php echo CHtml::encode($model->getAttributeLabel('tglpengajuan')); ?></b>
        </td>
        <td>
            : <?php echo !empty($model->tglpengajuan)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($model->tglpengajuan)))):"-" ?>
        </td>
        <td>
            &nbsp;
        </td> 
         <td>
            <b>Untuk Keperluan</b>            
        </td>
        <td>: <?php echo CHtml::encode($model->untukkeperluan); ?></td>
        
     <tr>
          <td>
            <b>keterangan</b>            
        </td>
        <td>: <?php echo CHtml::encode($model->keterangan); ?></td>
        <td>
            &nbsp;
        </td> 
        <td>
            &nbsp;
        </td> 
        <td>
            &nbsp;
        </td> 
    </tr>
</table>
<table style="width: 100%; border: none;">
	<tr>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="2">
		<?php 
		if(isset($model->tgl_mengetahui)){ ?>
			Mengetahui,
			<br><br><br><br><br><br>
			( <?php echo $model->namaLengkapMengetahui;?> )
		<?php } ?>			
		</th>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="2">
			Menyetujui,
			<br><br><br><br><br><br>
			( <?php echo $model->namaLengkapMenyetujui;?> )
		</th>
	</tr>
</table>

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
<?php //$this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => '')); ?>
</div>
<div class="content">
   
<table bgcolor='white' class='table border' style = "box-shadow:none;">
    <tr bgcolor='white' >
        <td>
             <b><?php echo CHtml::encode($model->getAttributeLabel('nopengajuan')); ?></b>
        </td>
        <td>
            : <?php echo CHtml::encode($model->nopengajuan); ?>
        </td>
        <td>
            &nbsp;
        </td>    
        <td>
            <b>Jumlah Orang</b>            
        </td>
        <td>: <?php echo CHtml::encode($model->jmlorang); ?></td>
    </tr>
    <tr>
        <td>
             <b><?php echo CHtml::encode($model->getAttributeLabel('tglpengajuan')); ?></b>
        </td>
        <td>
            : <?php echo !empty($model->tglpengajuan)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($model->tglpengajuan)))):"-" ?>
        </td>
        <td>
            &nbsp;
        </td> 
         <td>
            <b>Untuk Keperluan</b>            
        </td>
        <td>: <?php echo CHtml::encode($model->untukkeperluan); ?></td>
        
     <tr>
          <td>
            <b>keterangan</b>            
        </td>
        <td>: <?php echo CHtml::encode($model->keterangan); ?></td>
        <td>
            &nbsp;
        </td> 
        <td>
            &nbsp;
        </td> 
        <td>
            &nbsp;
        </td> 
    </tr>
</table>
<table style="width: 100%; border: none;">
	<tr>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="2">
		<?php 
		if(isset($model->tgl_mengetahui)){ ?>
			Mengetahui,
			<br><br><br><br><br><br>
			( <?php echo $model->namaLengkapMengetahui;?> )
		<?php } ?>			
		</th>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="2">
			Menyetujui,
			<br><br><br><br><br><br>
			( <?php echo $model->namaLengkapMenyetujui;?> )
		</th>
	</tr>
</table>
</div>

<?php
}

 ?>