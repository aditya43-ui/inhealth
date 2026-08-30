<?php
if (isset($_GET['caraPrint'])){
    echo $this->renderPartial('_headerPrint'); 
}
?>
<table style="width: 100%; border: none;">
    <tr>
        <td width="12%">
			<b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('nofaktur')); ?></td><td>:</td></b><td width="38%">
            <?php echo CHtml::encode(!empty($modFakturPembelian->nofaktur)?$modFakturPembelian->nofaktur : "-"); ?>
		</td>
		<td width="15%">
             <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('nopenerimaan')); ?></td><td>:</td></b><td width="35%">
            <?php echo CHtml::encode(!empty($modFakturPembelian->nopenerimaan)?$modFakturPembelian->nopenerimaan : "-"); ?>
        </td>
	</tr>
	<tr>
        <td width="12%">
            <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('tglfaktur')); ?></td><td>:</td></b><td width="38%">
            <?php echo CHtml::encode(!empty($modFakturPembelian->tglfaktur)?date("Y-m-d", strtotime($modFakturPembelian->tglfaktur)) : "-"); ?>
		</td>
		<td width="15%">
             <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('tglterima')); ?></td><td>:</td></b><td width="35%">
            <?php echo CHtml::encode(!empty($modFakturPembelian->tglterima)?date("Y-m-d", strtotime($modFakturPembelian->tglterima)):"-"); ?>
        </td>
    </tr>
	<tr>
		<td width="12%">
             <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('supplier_jenis')); ?></td><td>:</td></b><td width="38%">
            <?php echo CHtml::encode(!empty($modFakturPembelian->supplier_jenis)?$modFakturPembelian->supplier_jenis :"-"); ?>
		</td>
		<td width="15%">
             <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('instalasi_nama')); ?></td><td>:</td></b><td width="35%">
            <?php echo CHtml::encode(!empty($modFakturPembelian->instalasi_nama)?$modFakturPembelian->instalasi_nama:"-"); ?>
		</td>
	</tr>
	<tr>
		<td width="12%">
             <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('supplier_nama')); ?></td><td>:</td></b><td width="38%">
            <?php echo CHtml::encode(!empty($modFakturPembelian->supplier_nama)?$modFakturPembelian->supplier_nama : "-"); ?>
		</td>
		<td width="15%">
             <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('ruangan_nama')); ?></td><td>:</td></b><td width="35%">
            <?php echo CHtml::encode(!empty($modFakturPembelian->ruangan_nama)?$modFakturPembelian->ruangan_nama : "-"); ?>
		</td>
	</tr>
	<tr>
		<td width="12%">
             <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('supplier_alamat')); ?></td><td>:</td></b><td width="38%">
            <?php echo CHtml::encode($modFakturPembelian->getAlamatLengkap($modFakturPembelian->supplier_id)); ?>
		</td>
		<td width="15%">
             <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('pegawaipenerima_nama')); ?></td><td>:</td></b><td width="35%">
            <?php echo CHtml::encode($modFakturPembelian->getNamaLengkapPenerima($modFakturPembelian->pegawaipenerima_id)); ?>
		</td>
	</tr>
	<tr>
		<td width="12%">
             <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('supplier_kodepos')); ?></td><td>:</td></b><td width="38%">
            <?php echo CHtml::encode(!empty($modFakturPembelian->supplier_kodepos)?$modFakturPembelian->supplier_kodepos : "-"); ?>
		</td>
		<td width="15%">
             <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('asalbarang_nama')); ?></td><td>:</td></b><td width="35%">
            <?php echo CHtml::encode(!empty($modFakturPembelian->asalbarang_nama)?$modFakturPembelian->asalbarang_nama : "-"); ?>
		</td>
	</tr>
	<tr>
		<td width="12%">
             <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('supplier_telphon')); ?></td><td>:</td></b><td width="38%">
            <?php echo CHtml::encode(!empty($modFakturPembelian->supplier_telphon)?$modFakturPembelian->supplier_telphon : "-"); ?>
		</td>
		<td width="15%">
             <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('nosuratjalan')); ?></td><td>:</td></b><td width="35%">
            <?php echo CHtml::encode(!empty($modFakturPembelian->nosuratjalan)?$modFakturPembelian->nosuratjalan : "-"); ?>
		</td>
	</tr>
	<tr>
		<td width="12%">
             <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('supplier_fax')); ?></td><td>:</td></b><td width="38%">
            <?php echo CHtml::encode(!empty($modFakturPembelian->supplier_fax)?$modFakturPembelian->supplier_fax : "-"); ?>
		</td>
		<td width="15%">
             <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('tglsuratjalan')); ?></td><td>:</td></b><td width="35%">
            <?php echo CHtml::encode(!empty($modFakturPembelian->tglsuratjalan)?$modFakturPembelian->tglsuratjalan : "-"); ?>
		</td>
	</tr>
	<tr>
		<td width="12%">
             <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('supplier_npwp')); ?></td><td>:</td></b><td width="38%">
            <?php echo CHtml::encode(!empty($modFakturPembelian->supplier_npwp)?$modFakturPembelian->supplier_npwp : "-"); ?>
		</td>
		<td width="15%">
             <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('nopembelian')); ?></td><td>:</td></b><td width="35%">
            <?php echo CHtml::encode(!empty($modFakturPembelian->nopembelian)?$modFakturPembelian->nopembelian : "-"); ?>
		</td>
	</tr>
	<tr>
		<td width="12%">
             <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('supplier_norekening')); ?></td><td>:</td></b><td width="38%">
            <?php echo CHtml::encode(!empty($modFakturPembelian->supplier_norekening)?$modFakturPembelian->supplier_norekening : "-"); ?>
		</td>
		<td width="15%">
             <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('tglpembelian')); ?></td><td>:</td></b><td width="35%">
            <?php echo CHtml::encode(!empty($modFakturPembelian->tglpembelian)?$modFakturPembelian->tglpembelian : "-"); ?>
		</td>
	</tr>
	<tr>
		<td width="12%">
             <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('supplier_namabank')); ?></td><td>:</td></b><td width="38%">
            <?php echo CHtml::encode(!empty($modFakturPembelian->supplier_namabank)?$modFakturPembelian->supplier_namabank : "-"); ?>
		</td>
		<td width="15%">
             <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('tgldikirim')); ?></td><td>:</td></b><td width="35%">
            <?php echo CHtml::encode(!empty($modFakturPembelian->tgldikirim)?$modFakturPembelian->tgldikirim : "-"); ?>
		</td>
	</tr>
	<tr>
		<td width="12%">
             <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('supplier_rekatasnama')); ?></td><td>:</td></b><td width="38%">
            <?php echo CHtml::encode(!empty($modFakturPembelian->supplier_rekatasnama)?$modFakturPembelian->supplier_rekatasnama : "-"); ?>
		</td>
	</tr>
	<tr>
		<td width="15%">
             <b><?php echo CHtml::encode($modFakturPembelian->getAttributeLabel('supplier_matauang')); ?></td><td>:</td></b><td width="35%">
            <?php echo CHtml::encode(!empty($modFakturPembelian->supplier_matauang)?$modFakturPembelian->supplier_matauang : "-"); ?>
		</td>
	</tr>
</table>
<hr>
<table id="tableObatAlkes" class="table table-bordered table-condensed">
    <thead>
    <tr>
        <th>No.Urut</th>
        <th>Tanggal Jatuh Tempo</th>
        <th>Keterangan Persediaan</th>
        <th>No. Faktur Pajak</th>
        <th>Total Harga</th>
        <th>Keringanan</th>
        <th>Biaya Administrasi</th>
        <th>Harga PPh</th>
        <th>Harga PPN</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $no=1;
	echo "<tr>
			<td>".$no."</td>
			<td>".(!empty($modFakturPembelian->tgljatuhtempo)?date("Y-m-d",  strtotime($modFakturPembelian->tgljatuhtempo)):"-")."</td>  
			<td>".(!empty($modFakturPembelian->keterangan_persediaan)?$modFakturPembelian->keterangan_persediaan:"-")."</td>  
			<td>".(!empty($modFakturPembelian->nofakturpajak)?$modFakturPembelian->nofakturpajak:"-")."</td>  
			<td>Rp ".number_format($modFakturPembelian->totalharga)."</td>  
			<td>Rp ".number_format($modFakturPembelian->discount)."</td>  
			<td>Rp ".number_format($modFakturPembelian->biayaadministrasi)."</td>  
			<td>Rp ".number_format($modFakturPembelian->pajakpph)."</td>  
			<td>Rp ".number_format($modFakturPembelian->pajakppn)."</td>  
		 </tr>";  
	
    echo "</tbody><tfoot><tr>
            <td colspan='4' style='text-align:right;'> Total</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
         </tr></tfoot>";    
    ?>
</table>
<?php
	if(!isset($_GET['caraPrint'])){
		echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
	}
?>
<?php if(isset($_GET['caraPrint'])){  ?>
<table style="width: 100%; border: none;">
    <tr> 
		<td>&nbsp;</td>
        <td align="center" width="30%"><?php echo Yii::app()->user->getState('kabupaten_nama').", ".date('d M Y'); ?></td>
    </tr>
    <tr>
		<td class="tandatangan">Penerima Faktur</td>
		<td class="tandatangan">Petugas Keuangan</td>
    </tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr>
        <td class="tandatangan" style="height: 50px;">.........................</td>
        <td class="tandatangan"><?php echo Yii::app()->user->getState('nama_pegawai'); ?>
    </td></tr>
</table><br><br>
            <div style="font-size: 9pt;">&nbsp;&nbsp;&nbsp;Print Date : 
    <?php echo date('d M Y H:i:s'); ?></div>
</td></tr></table>
<?php } ?>

<script>
function print(caraPrint)
{
    var pembelianbarang_id = '<?php echo isset($modFakturPembelian->pembelianbarang_id) ? $modFakturPembelian->pembelianbarang_id : null ?>';
    window.open('<?php echo $this->createUrl('detailsFaktur'); ?>&pembelianbarang_id='+pembelianbarang_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}	
</script>

