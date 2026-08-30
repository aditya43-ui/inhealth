<style>
    
    .tab-detail th {
        font-weight: bold;
    }
    .tab-detail td, .tab-detail th {
        padding: 2px;
    }
    
</style>

<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
	$template = "{items}";
	if($caraPrint=='EXCEL'){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');   
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
}

if (!empty($caraPrint)) {
    echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judul_print, 'deskripsi'=>'', 'colspan'=>10));
}
?>
<div class="row">
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo CHtml::label('Tgl. Pencatatan', 'barangpecahbelah_tgl', array('class' => 'control-label')); echo " :";?>
			<?php echo isset($model->barangpecahbelah_tgl) ? MyFormatter::formatDateTimeId($model->barangpecahbelah_tgl) : "-";  ?>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('No. Pencatatan', 'barangpecahbelah_no', array('class' => 'control-label')); echo " :"; ?>
				<?php echo isset($model->barangpecahbelah_no) ? $model->barangpecahbelah_no : "-";  ?>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')); echo " :"; ?>
				<?php echo isset($model->ruangan->instalasi->instalasi_nama) ? $model->ruangan->instalasi->instalasi_nama : "-";  ?>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')); echo " :"; ?>
				<?php echo isset($model->ruangan->ruangan_nama) ? $model->ruangan->ruangan_nama : "-";  ?>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Keterangan', 'keterangan', array('class' => 'control-label')); echo " :"; ?>
				<?php echo isset($model->keterangan) ? $model->keterangan : "-";  ?>
		</div>
	</div>
</div>
	
	<table border="1" width="100%" style='margin-left:auto; margin-right:auto;' class="tab-detail">
		<thead class="border">
			<tr>
				<th>Kode Barang</th>
				<th>Nama Barang</th>
				<th>Jumlah</th>
				<th>Harga</th>
				<th>Total</th>
				<th>Keterangan</th>
			</tr>
		</thead>
		<tbody>
			<?php 
                $main_total = 0;
				foreach ($modDetail as $i=>$item){ 
                    $main_total += $item->jumlah * $item->harga_satuan;
			?>
				<tr>
					<td><?php echo $item->barang->barang_kode; ?></td>
					<td><?php echo $item->barang->barang_nama; ?></td>
					<td style="text-align: right;"><?php echo $item->jumlah; ?></td>
					<td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item->harga_satuan); ?></td>
					<td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item->jumlah * $item->harga_satuan); ?></td>
					<td><?php echo $item->keterangan; ?></td>
				</tr>
			<?php } ?>
                <tr>
                    <td colspan="4" style="font-weight: bold;">Total Keseluruhan</td>
                    <td style="text-align: right; font-weight: bold;"><?php echo MyFormatter::formatNumberForPrint($main_total); ?></td>
                    <td></td>
                </tr>
		</tbody>
	</table>
	<table width="100%" style="margin-top:20px;">
    <tr>
		<td width="35%" align="center">
			<div>Menerima<br></div>
			<div style="margin-top:60px;"><?php echo !empty($model->pegmenerima) ? $model->pegmenerima->namaLengkap : "-"; ?></div>
		</td>
		<td width="35%" align="center">
			<div>Mengetahui</div>
			<div style="margin-top:60px;"><?php echo !empty($model->pegmengetahui) ? $model->pegmengetahui->namaLengkap : "-"; ?></div>
			<div></div>
		</td>
    </tr>
</table>

<?php if (empty($caraPrint)) : 
    
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
    
?>

<script>

function print(caraPrint)
{
    var barangpecahbelah_id = '<?php echo isset($_GET['barangpecahbelah_id']) ? $_GET['barangpecahbelah_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&barangpecahbelah_id='+barangpecahbelah_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

</script>


<?php endif; ?>
