<style>
    .border th, .border td{
        border:1px solid #000;
        padding:2px;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }
    
    thead th{
        background:none;
        color:#333;
    }
    
    .border{
        box-shadow: none;
    }
    
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
</style>
<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
	$template = "{items}";
	if($caraPrint=='EXCEL'){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');   
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
}

echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
?>
<br>
<table width="100%">
	<tr>
		<td width="20%">No. Permintaan</td>
		<td width="70%">: <?php echo $model->nosuratpenawaran ?></td>
	</tr>
	<tr>
		<td>Tanggal Penawaran</td>
		<td>: <?php echo MyFormatter::formatDateTimeId($model->tglpenawaran) ?></td>
	</tr>
	<tr>
		<td>Status Penawaran</td>
		<td>: <?php echo $model->statuspenawaran ?></td>
	</tr>
	<tr>
		<td colspan="2"> <i>Merupakan penawaran <?php echo ($model->ispenawaranmasuk == TRUE)?"Masuk":"Keluar" ?> dari Supplier </i><b><?php echo $model->supplier_nama ?></b></td>
	</tr>
</table>
<table class="table border">
	<thead>
		<tr style="border:1px solid;">
			<th>No.</th>
			<th>Asal Barang</th>
			<th>Kategori / Nama Obat</th>
			<th>Jumlah Kemasan (Satuan)</th>
			<th>Jumlah Permintaan</th>
			<th>Harga Netto</th>
			<th>Stok Akhir</th>
			<th>Minimal Stok</th>
			<th>Sub Total</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$total = 0;
        $subtotal = 0;
		foreach($modDetails as $i => $modDetail){
		?>
		<tr>
			<td><?php echo $i+1; echo ". "; ?></td>
			<td><?php echo $modDetail->sumberdana->sumberdana_nama; ?></td>
			<td><?php echo (!empty($modDetail->obatalkes->obatalkes_kategori) ? $modDetail->obatalkes->obatalkes_kategori."/ " : "") ."". $modDetail->obatalkes->obatalkes_nama; ?></td>
			<td style="text-align: center;"><?php echo $modDetail->kemasanbesar; ?></td>
			<td style="text-align: center;"><?php echo $modDetail->qty; ?></td>
			<td style="text-align:right;"><?php echo "Rp".number_format($modDetail->harganetto,0,"","."); ?></td>
			<td style="text-align: center;"><?php
			$modDetail->stokakhir = StokobatalkesT::getJumlahStok($modDetail->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
			echo $modDetail->stokakhir; ?></td>
			<td style="text-align: center;"><?php echo $modDetail->minimalstok; ?></td>
			<td style="text-align:right;"><?php 
				$subtotal = ($modDetail->harganetto * $modDetail->qty);
				$total += $subtotal;
				echo "Rp".number_format($subtotal,0 ,"","."); ?>
			</td>
		</tr>
		<?php } ?>
		<tfoot>
			<tr>
				<td colspan="8" style="text-align:right;"><b>Total</b></td>
				<td style="text-align:right;">
					<b><?php echo "Rp".number_format($total,0,"",".") ?></b>
				</td>
			</tr>
		</tfoot>
	</tbody>
</table>
<table class="table" style = "box-shadow:none;">
	<tr>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="2">
		<?php 
		if(isset($model->tglmengetahui)){ ?>
			Mengetahui,
			<br><br><br><br><br><br>
			( <?php echo $model->PegawaimengetahuiLengkap;?> )
		<?php } ?>			
		</th>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="2">
			Menyetujui,
			<br><br><br><br><br><br>
			( <?php echo $model->PegawaimenyetujuiLengkap;?> )
		</th>
	</tr>
</table>