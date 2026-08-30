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
    <table class="table border">
	<thead>
		<tr>
			<th>No.</th>
			<th>No. Pemesanan</th>
			<th>Nama Peralatan dan Linen</th>
			<th>Jumlah</th>
			<th>Keterangan</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$total_jumlah = 0;
			$disabled = false;
			foreach ($modDetails as $i => $detail) {?>
				<tr>
						<td><?php echo $i+1; echo ". "; ?></td>
						<td><?php echo $detail->pesan->pesanperlinensteril_no; ?></td>
						<td><?php echo isset($detail->linen_id) ? $detail->linen->namalinen : $detail->barang->barang_nama ; ?></td>
						<td><?php echo $detail->pesanperlinensterildet_jml; ?></td>
						<td><?php echo $detail->pesanperlinensterildet_ket; ?></td>
						<?php $total_jumlah += $detail->pesanperlinensterildet_jml;?>
				</tr>
				<?php } ?>
	</tbody>
		<tfoot>
			<tr>
				<td colspan="3" style="text-align:right;">Total</td>
				<td>
					<?php echo $total_jumlah; ?>
				</td>
			</tr>
		</tfoot>
</table>

<table class="table">
	<tr>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="3">
			Mengetahui,
			<br><br><br><br><br><br>
			( <?php echo isset($model->pegmengetahui_id) ? $model->pegawaiMengetahui->nama_pegawai : "-";?> )		
		</th>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="3">
			Memesan,
			<br><br><br><br><br><br>
			( <?php echo $model->pegawaiMemesan->nama_pegawai;?> )
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
                <table class="table border">
	<thead>
		<tr>
			<th>No.</th>
			<th>No. Pemesanan</th>
			<th>Nama Peralatan dan Linen</th>
			<th>Jumlah</th>
			<th>Keterangan</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$total_jumlah = 0;
			$disabled = false;
			foreach ($modDetails as $i => $detail) {?>
				<tr>
						<td><?php echo $i+1; echo ". "; ?></td>
						<td><?php echo $detail->pesan->pesanperlinensteril_no; ?></td>
						<td><?php echo isset($detail->linen_id) ? $detail->linen->namalinen : $detail->barang->barang_nama ; ?></td>
						<td><?php echo $detail->pesanperlinensterildet_jml; ?></td>
						<td><?php echo $detail->pesanperlinensterildet_ket; ?></td>
						<?php $total_jumlah += $detail->pesanperlinensterildet_jml;?>
				</tr>
				<?php } ?>
	</tbody>
		<tfoot>
			<tr>
				<td colspan="3" style="text-align:right;">Total</td>
				<td>
					<?php echo $total_jumlah; ?>
				</td>
			</tr>
		</tfoot>
</table>

<table class="table">
	<tr>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="4">
			Mengetahui,
			<br><br><br><br><br><br>
			( <?php echo isset($model->pegmengetahui_id) ? $model->pegawaiMengetahui->nama_pegawai : "-";?> )		
		</th>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="4">
			Memesan,
			<br><br><br><br><br><br>
			( <?php echo $model->pegawaiMemesan->nama_pegawai;?> )
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
   
<table class="table border">
	<thead>
		<tr>
			<th>No.</th>
			<th>No. Pemesanan</th>
			<th>Nama Peralatan dan Linen</th>
			<th>Jumlah</th>
			<th>Keterangan</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$total_jumlah = 0;
			$disabled = false;
			foreach ($modDetails as $i => $detail) {?>
				<tr>
						<td><?php echo $i+1; echo ". "; ?></td>
						<td><?php echo $detail->pesan->pesanperlinensteril_no; ?></td>
						<td><?php echo isset($detail->linen_id) ? $detail->linen->namalinen : $detail->barang->barang_nama ; ?></td>
						<td><?php echo $detail->pesanperlinensterildet_jml; ?></td>
						<td><?php echo $detail->pesanperlinensterildet_ket; ?></td>
						<?php $total_jumlah += $detail->pesanperlinensterildet_jml;?>
				</tr>
				<?php } ?>
	</tbody>
		<tfoot>
			<tr>
				<td colspan="3" style="text-align:right;">Total</td>
				<td>
					<?php echo $total_jumlah; ?>
				</td>
			</tr>
		</tfoot>
</table>

<table class="table ">
	<tr>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="4">
			Mengetahui,
			<br><br><br><br><br><br>
			( <?php echo isset($model->pegmengetahui_id) ? $model->pegawaiMengetahui->nama_pegawai : "-";?> )		
		</th>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="4">
			Memesan,
			<br><br><br><br><br><br>
			( <?php echo $model->pegawaiMemesan->nama_pegawai;?> )
		</th>
	</tr>
</table>
</div>

<?php
}

 ?>