<style>
    .uang {
        text-align: right !important;
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
//echo "No. Rencana : <b>".$model->noperencnaan."</b>";
?>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
        <tr>
            <td style="width:150px"><h4>No. Rencana</h4></td>
            <td style="width:10px"><h4>:</h4></td>
            <td><h4><?php echo $model->noperencnaan; ?></h4></td>
            
            <td style="width:150px"><h4>Sumber Dana</h4></td>
            <td style="width:10px"><h4>:</h4></td>
            <td><h4><?php echo (!empty($model->sumberdana_id)?$model->sumberdana->sumberdana_nama:""); ?></h4></td>
        </tr>
        <tr>
            <td><h4>Tanggal Rencana : </h4></td>
             <td><h4>:</h4></td>
            <td><h4><?php echo MyFormatter::formatDateTimeForUser($model->tglperencanaan); ?></h4></td>
        </tr>
        
    </table><br/>
<table class="items table table-striped table-condensed" id="table-rencanaanggaranpenerimaan">
	<thead>
		<tr>
			<th>No.</th>
			<th>Jenis</th>
			<th>Nama Obat</th>
                        <th>Tgl. Kadaluarsa</th>
			<th>Jumlah yang Harus Diorder</th>
                        <!-- <th>Maksimal Stok</th> -->
			<th>Stok Akhir</th>
			<th>Jumlah Kemasan (Satuan)</th>
			<th>Jumlah Kebutuhan</th>
			<th>HPP</th>
                        <th>VEN</th>
                        <th>ABC</th>
			<th>Sub Total</th>
			
		</tr>
	</thead>
	<tbody>
		<?php 
		$total = 0;
        $subtotal = 0;
		foreach($modDetails as $i => $modDetail){
                    $oa = ObatalkesM::model()->findByPk($modDetail->obatalkes_id);
                    $sat = !empty($modDetail->satuankecil_id)?$modDetail->satuankecil->satuankecil_nama:$modDetail->satuanbesar->satuanbesar_nama;
                    $kecil = $oa->satuankecil->satuankecil_nama;
                    $modLookup = ADLookupM::model()->findByAttributes(array('lookup_value'=>$modDetail->obatalkes->ven));
		?>
		<tr>
				<td><?php echo $i+1; echo ". "; ?></td>
                                <td><?php echo empty($oa->jenisobatalkes_id)?"-":$oa->jenisobatalkes->jenisobatalkes_nama; ?></td>
                                <td><?php echo $oa->obatalkes_nama; ?></td>
                                <td><?php echo MyFormatter::formatDateTimeForUser($oa->tglkadaluarsa); ?></td>
                                <td class="uang"><?php echo $modDetail->jmlharusorder." ".$kecil; ?></td>
                                <td class="uang" hidden><?php echo $modDetail->maksimalstok." ".$kecil; ?></td>
                                <td class="uang"><?php echo $modDetail->stokakhir." ".$kecil; ?></td>
                                <td class="uang"><?php echo $modDetail->kemasanbesar." ".$kecil; ?></td>
                                <td class="uang"><?php echo $modDetail->jmlpermintaan." ".$sat; ?></td>
                                <td class="uang"><?php echo (Params::cekHiddenHargaGudangFarmasi()==true)? $format->formatNumberForPrint($modDetail->harganettorenc):"Hidden"; ?></td>
                                <td><?php echo isset($modLookup->lookup_name) ? $modLookup->lookup_name : "-"; ?></td>
                                <td><?php echo $modDetail->kategori_abc; ?></td>
				<td class="uang">
					<?php
                    if (!empty($modDetail->satuankecil_id)) {
                        $subtotal = $modDetail->harganettorenc * $modDetail->jmlpermintaan;
                    } else {
                        $subtotal = $modDetail->harganettorenc * $modDetail->jmlpermintaan * $modDetail->kemasanbesar;
                    }
                    // $subtotal = ($modDetail->harganettorenc * $modDetail->jmlpermintaan);
                    $total += $subtotal;
                    echo (Params::cekHiddenHargaGudangFarmasi()==true)?$format->formatNumberForPrint($subtotal):"Hidden"; ?>
				</td>
		</tr>
		<?php } ?>
		<tfoot>
			<tr>
				<td colspan="12" style="text-align:right;">Total Anggaran</td>
				<td class="uang"><b>
					<?php echo (Params::cekHiddenHargaGudangFarmasi()==true)?$format->formatNumberForPrint($total):"Hidden";?>
				</b></td>
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
					function(r) {if(r) window.location = "'.$this->createUrl('Mengetahui',array('rencanakebfarmasi_id'=>$model->rencanakebfarmasi_id,'approve'=>true)).'";} ); return false;'));  
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
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-success', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    $urlPrint= $this->createUrl('printMengetahui',array('rencanakebfarmasi_id'=>$model->rencanakebfarmasi_id));
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