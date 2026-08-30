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
echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
 
$sukses = null;
if(isset($_GET['sukses'])){
	$sukses = $_GET['sukses'];
}
if($sukses > 0){
	Yii::app()->user->setFlash('success',"Status menyetujui berhasil disimpan !");
}
$this->widget('bootstrap.widgets.BootAlert'); 
?>
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
<table class="table border" id="table-rencanaanggaranpenerimaan">
	<thead>
		<tr>
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
				<td style="text-align: right;"><?php echo "Rp".number_format($modDetail->harganetto,0,"","."); ?></td>
				<td style="text-align: center;"><?php
				$modDetail->stokakhir = StokobatalkesT::getJumlahStok($modDetail->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
				echo $modDetail->stokakhir; ?></td>
				<td style="text-align: center;"><?php echo $modDetail->minimalstok; ?></td>
				<td style="text-align: right;"><?php 
					$subtotal = ($modDetail->harganetto * $modDetail->qty);
					$total += $subtotal;
					echo "Rp".number_format($subtotal,0,"","."); ?>
				</td>
		</tr>
		<?php } ?>
		<tfoot>
			<tr>
				<td colspan="8" style="text-align:right;"><b>Total</b></td>
				<td style="text-align: right;">
                                    <b>
					<?php echo "Rp".number_format($total,0,"","."); ?>
                                    </b>
				</td>
			</tr>
		</tfoot>
	</tbody>
</table>
<div class="row-fluid">
	<div class="span6" style="text-align:center;">
			<?php 
			if(isset($_GET['sukses'])){
				echo "<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>";
				echo "Mengetahui,";
			}else{
				echo "<div class='<div class='control-group' style='margin-bottom: 50px;'>";
				echo CHtml::link(Yii::t('mds',' Mengetahui'), 
				$this->createUrl($this->id.'/index'), 
				array('class'=>'btn btn-primary',
					'onclick'=>'myConfirm("Apakah anda yakin ?","Perhatian!",
					function(r) {if(r) window.location = "'.$this->createUrl('Mengetahui',array('permintaanpenawaran_id'=>$model->permintaanpenawaran_id,'approve'=>true)).'";} ); return false;'));  
			}
			?>
		</div>	
		<div class="control-group">
			( <?php echo $model->PegawaimengetahuiLengkap;?> )
		</div>	
	</div>
	<div class="span6" style="text-align:center;">
		<div class="control-group" style="margin-bottom: 57.5px;margin-top: 10px;">
			Menyetujui,
		</div>
		<div class="control-group">
			( <?php echo $model->PegawaimenyetujuiLengkap;?> )
		</div>
	</div>
</div>

<?php 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    $urlPrint= $this->createUrl('printMengetahui',array('permintaanpenawaran_id'=>$model->permintaanpenawaran_id));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}"+$('#inforencanapen-form').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
    ?>