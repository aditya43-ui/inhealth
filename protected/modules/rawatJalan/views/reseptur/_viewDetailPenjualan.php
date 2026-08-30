<?php
if(isset($_GET['caraPrint'])){
	echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10)); 
}
?>
<table width="100%" style="margin-left:auto; margin-right:auto;">
    <tr>
        <td>No. Rekam Medik</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->no_rekam_medik); ?></td>
        <td>No. Pendaftaran</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?></td>
    </tr>
    <tr>
        <td>Nama Pasien</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?></td>
        <td nowrap>Tgl. Pendaftaran</td><td>:</td><td><?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran)); ?></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?></td>
        <td>No. Penjualan</td><td>:</td><td><?php echo CHtml::encode($modPenjualan->noresep); ?></td>
    </tr>
    <tr>
        <td>Umur</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->umur); ?></td>
        <td>Tgl. Penjualan</td><td>:</td><td><?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modPenjualan->tglpenjualan)); ?></td>
    </tr>
    <tr>
        <?php 
            $modPasienAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            $carabayar_id = !empty($modPasienAdmisi) ? $modPasienAdmisi->carabayar_id : $modPendaftaran->carabayar_id;
            $modCaraBayar = CarabayarM::model()->findByPk($carabayar_id);
            $penjamin_id = !empty($modPasienAdmisi) ? $modPasienAdmisi->penjamin_id : $modPendaftaran->penjamin_id;
            $modPenjamin = PenjaminpasienM::model()->findByPk($penjamin_id);
        ?>
            <td>
            <?= $modPendaftaran->getAttributeLabel('carabayar_id')?>/
            <?= $modPendaftaran->getAttributeLabel('penjamin_id')?>
            </td><td>:</td><td><?php echo CHtml::encode($modCaraBayar->carabayar_nama); ?> / <?php echo CHtml::encode($modPenjamin->penjamin_nama); ?></td>
            <td>Dokter</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pegawai->namaLengkap); ?></td>
    </tr>
       
</table>
<br/>
<table id="tblDaftarResep" class="table table-bordered table-condensed" border="2">
    <thead>
        <tr>
            <th>Resep</th>
            <th>Nama Obat</th>
            <!--th>Satuan</th-->
            <th>Permintaan Dosis</th>
            <th>Signa</th>
            <th <?php echo Params::HIDDEN_HARGA; ?>>Estimasi Harga Satuan</th>
            <th>Jumlah</th>
            <th <?php echo Params::HIDDEN_HARGA; ?>>Sub Total</th>
<!--            <th>&nbsp;</th>-->
        </tr>
    </thead>
    
    <?php foreach ($modObatAlkes as $detail) { ?>
    
    <tr>
        <td><?php echo 'R/ ' . $detail->rke ?></td>
        <td><?php echo $detail->obatalkes->obatalkes_nama ?></td>
        <!--td><?php // echo $detail->satuankecil->satuankecil_nama ?></td-->
        <td><?php echo (!empty($detail->permintaan_oa) ? $detail->permintaan_oa : '') . ' ' . (!empty($detail->satuankekuatan_oa) ? $detail->satuankekuatan_oa : '') ?></td>
        <td><?php echo $detail->signa_oa ?></td>
        <td style="text-align: right" <?php echo Params::HIDDEN_HARGA; ?>><?php echo MyFormatter::formatNumberForPrint($detail->hargajual_oa) ?></td>
        <td style="text-align: right"><?php echo $detail->qty_oa." ".$detail->satuankecil->satuankecil_nama ?></td>
        <td style="text-align: right" <?php echo Params::HIDDEN_HARGA; ?>><?php echo MyFormatter::formatNumberForPrint($detail->qty_oa * $detail->hargajual_oa) ?></td>
    </tr>
    <?php } ?>
	<?php $idReseptur = $modPenjualan->penjualanresep_id;  ?>
</table>


<?php
if(isset($_GET['caraPrint'])){ ?>
	<table align="RIGHT">
		<tr>
			<td>
	<div align="CENTER">
		 Dokter Pemeriksa
		<br/><br/><br/><br/>
	   ( <?php echo CHtml::encode($modPendaftaran->pegawai->nama_pegawai); ?> )
	</div>
			</td>

		</tr>
	</table>
	<table align="LEFT">
		<tr>
			<td>
	<div align="CENTER">
		 Catatan Dokter : <?php echo (isset($riwayat->catatandokterpengirim) ? CHtml::encode($riwayat->catatandokterpengirim) : ""); ?>

	</div>
			</td>

		</tr>
	</table>
<?php }else{ ?>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print Detail',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printPenjualan("PRINT","'.$idReseptur.'")'))."&nbsp&nbsp"; ?>
	</div>
<?php } ?>


