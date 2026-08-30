<?php
if(isset($_GET['caraPrint'])){
	echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10)); 
}
?>
<table style="width: 100%; border: none;">
    <tr>
        <td >
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('nama_pasien')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?>
        </td>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('tgl_pendaftaran')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->tgl_pendaftaran); ?>
        </td>
    </tr><br>
    <tr>
        <td>
                <label class='control-label'><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('jeniskelamin')); ?>:</label>
                <?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?>
        </td>
        <td>
             <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('no_pendaftaran')); ?>:</label>
                <?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?>
        </td>
    </tr><br>
    <tr>
        <td>
                <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('umur')); ?>:</label>
                <?php echo CHtml::encode($modPendaftaran->umur); ?>
        </td>
        <td>
             <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('Kelas Pelayanan')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->kelaspelayanan->kelaspelayanan_nama); ?>
        </td>
    </tr><br>
    <tr>
        <td>
                <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('Jenis Penjamin / Penjamin ')); ?>:</label>
                <?php echo CHtml::encode($modPendaftaran->carabayar->carabayar_nama); ?> / <?php echo CHtml::encode($modPendaftaran->penjamin->penjamin_nama); ?>
            
        </td>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('Nama Dokter')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->pegawai->nama_pegawai); ?>
        </td>
    </tr>
       
    </table>
<br>
<table id="tblDaftarResep" class="table table-bordered table-condensed" border="2">
    <thead>
        <tr>
            <th>Nama Obat</th>
            <th>Satuan</th>
            <th>Estimasi Harga Satuan</th>
            <th>Jumlah</th>
            <th>Sub Total</th>
<!--<th>&nbsp;</th>-->
        </tr>
    </thead>
    
    <?php //echo print_r($modReseptur); 
//    exit(); ?>
    <?php foreach ($modDetailResep as $detail) { ?>
    
    <tr>
        <td><?php echo $detail->obatalkes->obatalkes_nama ?></td>
        <td><?php echo $detail->satuankecil->satuankecil_nama ?></td>
        <td><?php echo $detail->hargajual_reseptur ?></td>
        <td><?php echo $detail->qty_reseptur ?></td>
        <td><?php echo number_format($detail->qty_reseptur * $detail->hargajual_reseptur) ?></td>
    </tr>
	<?php $idReseptur = $detail->reseptur_id;  ?>
    <?php } ?>
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

