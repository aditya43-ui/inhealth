<?php 
echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
 
$sukses = null;
if(isset($_GET['sukses'])){
	$sukses = $_GET['sukses'];
}
if($sukses > 0){
	Yii::app()->user->setFlash('success',"Status menyetujui berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert'); 
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
?>
<table width="74%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td width="20%">Nomor</td>
            <td>:</td>
            <td><?php echo $model->nopermintaan; ?></td>
        </tr>
        <tr>
            <td>Lampiran</td>
            <td>:</td>
            <td></td>
        </tr>
        <tr>
            <td>Perihal</td>
            <td>:</td>
            <td>Pesanan Obat / Alat Kesehatan habis pakai rutin</td>
        </tr>
        <tr>
            <td>No. Rek</td>
            <td>:</td>
            <td></td>
        </tr>
    </table><br><br>
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Kepada Yth. <?php echo $model->supplier->supplier_nama; ?><br>
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Di  <?php echo $model->supplier->supplier_alamat; ?><br>
    Dengan hormat,<br>
    Dengan ini kami mohon pada saudara untuk dapat menyediakan obat dan alat kesehatan <?php echo $modProfilRs->nama_rumahsakit; ?>
    <br><br>
    <table width="100%" style='margin-left:auto; margin-right:auto;' >
        <thead class="border">
            <th>No.</th>
            <th>Asal Barang</th>
            <th>Kategori / Nama Obat</th>
            <th>Jumlah Kemasan (Satuan) </th>
            <th>Jumlah Pembelian</th>
            <th>Harga Netto</th>
            <th>Stok Akhir</th>
            <th>PPN</th>
            <th>PPh</th>
            <th>Keringanan (%)</th>
            <th>Keringanan Total (Rp)</th>
            <th>Minimal Stok</th>
            <th>Sub Total</th>
        </thead>
        <?php 
        $total = 0;
        $subtotal = 0;
        foreach ($modDetails as $i=>$modObat){ 
        ?>
            <tr class="border">
                <td><?php echo ($i+1)."."; ?></td>
                <td><?php echo $modObat->sumberdana->sumberdana_nama; ?></td>
                <td><?php echo (!empty($modObat->obatalkes->obatalkes_kategori) ? $modObat->obatalkes->obatalkes_kategori."/ " : "") . $modObat->obatalkes->obatalkes_nama; ?></td>
                <td><?php echo number_format($modObat->kemasanbesar); ?></td>
                <td><?php echo number_format($modObat->jmlpermintaan); ?></td>
                <td><?php echo $format->formatUang($modObat->harganettoper); ?></td>
                <td><?php echo number_format($modObat->stokakhir); ?></td>
                <td><?php echo $modObat->persenppn; ?></td>
                <td><?php echo $modObat->persenpph; ?></td>
                <td><?php echo $modObat->persendiscount; ?></td>
                <td><?php echo $format->formatUang($modObat->jmldiscount); ?></td>
                <td><?php echo number_format($modObat->minimalstok); ?></td>
                <td><?php 
                    $subtotal = ($modObat->harganettoper * $modObat->jmlpermintaan);
                    $total += $subtotal;
                    echo $format->formatUang($subtotal); ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="10" style="text-align: center;"><i>( <?php echo $format->kataterbilang($total) ?> rupiah )</i></td>
            <td colspan="2" align="center"><b>Total</b></td>
            <td  class="border"><?php echo $format->formatUang($total); ?></td>
        </tr>
    </table><br>
    Demikian Surat Pesanan ini kami buat untuk dapat dipergunakan seperlunya,<br>
    Atas perhatian dan kerja sama yang baik kami ucapkan terima kasih.<br><br>
<div class="row">
	<div class="col-sm-6" style="text-align:center;">
		&nbsp;
	</div>
	<div class="col-sm-6" style="text-align:center;">
		<div class="control-group" style="margin-bottom: 57.5px;margin-top: 10px;">
			<?php 
			if(isset($_GET['sukses'])){
				echo "<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>";
				echo isset($_GET['ditolak'])? "Ditolak," : "Menyetujui, ";
			}else{
				echo "<div class='<div class='control-group' style='margin-bottom: 50px;'>";
				echo CHtml::link(Yii::t('mds',' Menyetujui'), 
				$this->createUrl($this->id.'/index'), 
				array('class' => 'btn btn-danger',
					'onclick'=>'myConfirm("Apakah Anda yakin?","Perhatian!",
					function(r) {if(r) window.location = "'.$this->createUrl('Menyetujui',array('permintaanpembelian_id'=>$model->permintaanpembelian_id,'approve'=>true)).'";} ); return false;'));  
					echo "&nbsp";
					echo CHtml::link(Yii::t('mds',' Menolak'), 
					$this->createUrl($this->id.'/index'), 
					array('class'=>'btn btn-default',
						'onclick'=>'myConfirm("Apakah Anda yakin?","Perhatian!",
						function(r) {if(r) window.location = "'.$this->createUrl('Menyetujui',array('permintaanpembelian_id'=>$model->permintaanpembelian_id,'tolak'=>true)).'";} ); return false;'));  
			}
			?>
		</div>
	</div>
		<div class="control-group">
			( <?php echo isset($model->pegawaimenyetujui->NamaLengkap) ? $model->pegawaimenyetujui->NamaLengkap : "" ;?> )
		</div>
	</div>
</div>
<?php 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    $urlPrint= $this->createUrl('printMenyetujui',array('permintaanpembelian_id'=>$model->permintaanpembelian_id));
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