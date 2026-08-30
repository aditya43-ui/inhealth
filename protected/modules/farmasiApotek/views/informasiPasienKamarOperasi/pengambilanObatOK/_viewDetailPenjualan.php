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
            <th>Permintaan Dosis</th>
            <th>Petugas Farmasi</th>
            <th>Jumlah</th>
            <th>Etiket</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    
    <?php foreach ($modObatAlkes as $detail) { ?>
    
    <tr>
        <td><?php echo 'R/ ' . $detail->rke ?></td>
        <td><?php echo $detail->obatalkes->obatalkes_nama ?></td>
        <td><?php echo (!empty($detail->permintaan_oa) ? $detail->permintaan_oa : '') . ' ' . (!empty($detail->satuankekuatan_oa) ? $detail->satuankekuatan_oa : '') ?></td>
        <td><?php echo $detail->pegawai->namaLengkap ?? '' ?></td>
        <td style="text-align: right"><?php echo $detail->qty_oa." ".$detail->satuankecil->satuankecil_nama ?></td>
        <td>
            <?php  echo CHtml::link('<i class="icon-form-print"></i>', '', [
                    'onclick' => "printEtiket('" . $detail->obatalkespasien_id . "', '" . $modPenjualan->penjualanresep_id ."')"
                ]); ?>
        </td>
        <td>
            <?= $detail->obatTriage->keterangan ?? '' ?>
        </td>
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
		<?php
            // print detail
            echo CHtml::htmlButton(Yii::t('mds','{icon} Print Detail',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printPenjualan("PRINT","'.$idReseptur.'")'))."&nbsp&nbsp";
            
            // nota penjualan
            echo CHtml::Link('<i class="icon-print icon-white"></i> Print Nota Penjualan', 'javascript:;', array('class' => 'btn btn-info penjualan', 'type' => 'button', 'onclick' => 'printNotaPenjualan("PRINT","'.$idReseptur.'")'));

            // nota tindakan
            echo CHtml::Link('<i class="icon-print icon-white"></i> Print Nota Tindakan', 'javascript:;', array('class' => 'btn btn-info notatindakan', 'type' => 'button', 'onclick' => 'printetiketRanap("PRINT","'.$idReseptur.'")'));

            // lembat telaah
            CHtml::Link('<i class="icon-print icon-white"></i> Lembar Telaah', 'javascript:;', array('class' => 'btn btn-info telaah', 'type' => 'button', 'onclick' => 'printTelaah("PRINT","'.$idReseptur.'")'));

            echo CHtml::Link('<i class="icon-print icon-white"></i> Print Semua Etiket', 'javascript:;', array('class' => 'btn btn-info telaah', 'type' => 'button', 'onclick' => 'printAllEtiket("PRINT","'.$idReseptur.'")'));
        ?>
	</div>
<?php } ?>

<script>
    function printPenjualan(caraPrint, penjualanresep_id) {
        window.open('<?php echo $this->createUrl('/farmasiApotek/informasiPasienKamarOperasi/DetailPenjualan'); ?>&penjualanresep_id=' + penjualanresep_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }
    function printNotaPenjualan(caraPrint, penjualanresep_id) {
        window.open('<?php echo $this->createUrl('/farmasiApotek/penjualanDariReseptur/printNotaPenjualan'); ?>&penjualanresep_id=' + penjualanresep_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }
    function printTelaah(caraPrint, penjualanresep_id) {
        window.open('<?php echo $this->createUrl('/farmasiApotek/penjualanDariReseptur/printTelaah'); ?>&penjualanresep_id=' + penjualanresep_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }
    function printetiketRanap(caraPrint, penjualanresep_id) {
        window.open('<?php echo $this->createUrl('/farmasiApotek/penjualanDariReseptur/printTindakan'); ?>&penjualanresep_id=' + penjualanresep_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }
    function printEtiket(obatalkespasien_id, penjualanresep_id) {
        window.open('<?php echo $this->createUrl('/farmasiApotek/informasiPasienTriage/printEtiket'); ?>&obatalkespasien_id=' + obatalkespasien_id + '&penjualanresep_id=' + penjualanresep_id, 'printwin', 'left=100,top=100,width=1000,height=640');
    }
    function printAllEtiket(caraPrint, penjualanresep_id) {
        window.open('<?php echo $this->createUrl('/farmasiApotek/informasiPasienTriage/printAllEtiket'); ?>&caraPrint=' + caraPrint + '&penjualanresep_id=' + penjualanresep_id, 'printwin', 'left=100,top=100,width=1000,height=640');
    }
</script>


