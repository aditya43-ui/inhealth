<?php
if(isset($_GET['caraPrint'])){
	echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10)); 
}

$style = 'margin-left:auto; margin-right:auto;';
if (isset($caraPrint)){
    if ($caraPrint == "EXCEL")
        $style = "cellpadding='10',cellspasing='6', width='100%'";
//            $td = "width='100%'";
} else{
    $style = "style='margin-left:auto; margin-right:auto;'";
//        $td ='';
}

?>


<table width="100%" <?php echo $style; ?>>
    <tr>
        <td><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('no_rekam_medik')); ?></td>
        <td>:</td>
        <td><?php echo CHtml::encode($modPendaftaran->pasien->no_rekam_medik); ?></td>
        
        <td>No. Pendaftaran</td>
        <td>:</td>
        <td><?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?></td>
    </tr>
    <tr>
        <td><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('nama_pasien')); ?></td>
        <td>:</td>
        <td><?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?></td>
        
        
        <td>Tgl. Pendaftaran</td>
        <td>:</td>
        <td><?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran)); ?></td>
    </tr>
    <tr>
        
        <td><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('jeniskelamin')); ?></td>
        <td>:</td>
        <td><?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?></td>
        
        <td>No. Reseptur</td><td>:</td><td><?php echo CHtml::encode($modReseptur->noresep); ?></td>
        
    </tr>
    
    <tr>
        
        <td><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('umur')); ?></td>
        <td>:</td>
        <td><?php echo CHtml::encode($modPendaftaran->umur); ?></td>
 
        <td>Tgl. Reseptur</td><td>:</td><td><?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modReseptur->tglreseptur)); ?></td>
        
    </tr>
    
    <tr>
        <td><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('Jenis Penjamin / Penjamin ')); ?></td>
        <td>:</td>
        <td><?php echo CHtml::encode($modPendaftaran->carabayar->carabayar_nama); ?> / <?php echo CHtml::encode($modPendaftaran->penjamin->penjamin_nama); ?></td>
        
        <td><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('Kelas Pelayanan')); ?></td>
        <td>:</td>
        <td><?php echo CHtml::encode($modPendaftaran->kelaspelayanan->kelaspelayanan_nama); ?></td>
        
    </tr>
    
    <tr>
        <td colspan="3">&nbsp;</td>
        
        <td><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('Dokter')); ?></td>
        <td>:</td>
        <td><?php echo CHtml::encode($modPendaftaran->pegawai->nama_pegawai); ?></td>
    </tr>
       
    </table>
<br>
<table id="tblDaftarResep" class="table" border="1" style="box-shadow: none;">
    <thead>
        <tr>
            <th>Nama Obat</th>
            <!--th>Satuan</th-->
            <th  <?php //echo Params::HIDDEN_HARGA; ?>>Estimasi Harga Satuan</th>
            <th>Jumlah</th>
            <th  <?php //echo Params::HIDDEN_HARGA; ?>>Sub Total</th>
<!--<th>&nbsp;</th>-->
        </tr>
    </thead>
    <tbody>
    <?php //echo print_r($modReseptur); 
//    exit(); ?>
    <?php // foreach ($modReseptur as $i => $reseptur) { ?>
    <?php //   $details = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id'=>$reseptur->reseptur_id));
        $total = 0;
        foreach ($modDetailResep as $detail) {
            $total += $detail->qty_reseptur * $detail->hargasatuan_reseptur;
            
            ?>
    <tr>
        <td><?php echo $detail->obatalkes->obatalkes_nama ?></td>
        <!--td><?php //echo $detail->satuankecil->satuankecil_nama ?></td-->
        <td <?php //echo Params::HIDDEN_HARGA; ?> style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($detail->hargasatuan_reseptur) ?></td>
        <td style="text-align: right"><?php echo number_format($detail->qty_reseptur, 2, ",", "")." ".$detail->satuankecil->satuankecil_nama ?></td>
        <td <?php //echo Params::HIDDEN_HARGA; ?> style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($detail->qty_reseptur * $detail->hargasatuan_reseptur) ?></td>
    </tr>
    <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3">Total</td>
            <td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($total); ?></td>
        </tr>
    </tfoot>
</table>
<br>
<?php
if(isset($_GET['caraPrint'])){ ?>
	<table align="RIGHT">
		<tr>
			<td>
	<div style="text-align: center;">
		 Dokter Pemeriksa
		<br><br><br><br>
	   ( <?php echo CHtml::encode($modPendaftaran->pegawai->nama_pegawai); ?> )
	</div>
			</td>

		</tr>
	</table>
	<table align="LEFT">
		<tr>
			<td>
	<div style="text-align: center;">
		 Catatan Dokter : <?php echo (isset($riwayat->catatandokterpengirim) ? CHtml::encode($riwayat->catatandokterpengirim) : ""); ?>

	</div>
			</td>

		</tr>
	</table>
<?php }else{ ?>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print Detail',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print("PRINT","'.$idReseptur.'")')); ?>
	</div>
<?php } ?>

