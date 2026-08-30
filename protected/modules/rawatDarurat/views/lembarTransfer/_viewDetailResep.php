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
        <td>Nama Pasien</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->namadepan.$modPendaftaran->pasien->nama_pasien); ?></td>
        <td nowrap>Tgl. Pendaftaran</td><td>:</td><td><?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran)); ?></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?></td>
        <td>No. Reseptur</td><td>:</td><td><?php echo CHtml::encode($modReseptur->noresep); ?></td>
    </tr>
    <tr>
        <td>Umur</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->umur); ?></td>
        <td>Tgl. Reseptur</td><td>:</td><td><?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modReseptur->tglreseptur)); ?></td>
    </tr>
    <tr>
        <td nowrap>Jenis Penjamin / Penjamin</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->carabayar->carabayar_nama); ?> / <?php echo CHtml::encode($modPendaftaran->penjamin->penjamin_nama); ?></td>
        <td>Dokter</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pegawai->namaLengkap); ?></td>
    </tr>
       
</table>
<br/>
<table id="tblDaftarResep" class="table table-bordered table-condensed" border="2">
    <thead>
        <tr>
            <th>Nama Obat</th>
            <th>Jumlah</th>
            <th>Signa Obat</th>
            <th>Cara Penggunaan</th>
<!--            <th>&nbsp;</th>-->
        </tr>
    </thead>
    
    <?php //echo print_r($modReseptur); 
//    exit(); ?>
    <?php foreach ($modDetailResep as $detail) { ?>
    
    <tr>
        <td><?php echo $detail->obatalkes->obatalkes_nama ?></td>
        <td style="text-align: right"><?php echo $detail->qty_reseptur." ".$detail->satuankecil->satuankecil_nama ?></td>
        <td><?php echo $detail->signa_reseptur; ?></td>
        <td><?php echo $detail->etiket; ?></td>
    </tr>
	<?php $idReseptur = $detail->reseptur_id;  ?>
    <?php } ?>
</table>
<br/>
<?php
if(isset($_GET['caraPrint'])){ ?>
	
<?php }else{ ?>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print Detail',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printReseptur("PRINT","'.$idReseptur.'")'))."&nbsp&nbsp"; ?>
	</div>
<?php } ?>


