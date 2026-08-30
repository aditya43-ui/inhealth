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
        <td nowrap>Tgl. Pendaftaran</td><td>:</td><td><?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran)); ?></td>
        <td>Nama Pasien</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?></td>
        <td>Umur</td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->umur); ?></td>
    </tr>
    <tr>
        <td nowrap>  
            <?= $modPendaftaran->getAttributeLabel('carabayar_id')?>/
            <?= $modPendaftaran->getAttributeLabel('penjamin_id')?>
        </td><td>:</td><td><?php echo CHtml::encode($modPendaftaran->carabayar->carabayar_nama); ?> / <?php echo CHtml::encode($modPendaftaran->penjamin->penjamin_nama); ?></td>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td colspan="6"></td>
    </tr>
</table>
<br/>
<table id="tblDaftarDiagnosa" class="table table-bordered table-condensed" border="2">
    <thead>
        <tr>
            <th width="50">No.</th>
            <!-- <th width="100">Tanggal</th> -->
            <th>Tanggal Diagnosis</th>
            <th width="100">Kelompok Diagnosis</th>
            <th width="50">Kode ICD-X</th>
            <th>Nama ICD-X</th>
            <th>Nama lain ICD-X</th>
            <th>Kasus Diagnosa</th>
            <th>Status Diagnosa</th>
            <th>Dokter</th>
            <th width="100">PPDS</th>
            <th width="100">Ruangan</th>
            <th>Dasar Diagnosa</th>
        </tr>
    </thead>
    
    <?php 
    $i = 1;
    if (count((array)$modDiagnosa) > 0) {
        foreach ($modDiagnosa as $detail) {?>
        <tr>
            <td><?php echo $i ?></td>
            <td hidden><?php echo MyFormatter::formatDateTimeForUser($detail->create_time) ?></td>
            <td><?= MyFormatter::formatDateTimeForUser($detail->tglmorbiditas) ?></td>
            <td><?php echo $detail->kelompokdiagnosa->kelompokdiagnosa_nama ?></td>
            <td><?php echo $detail->diagnosa->diagnosa_kode ?></td>
            <td><?php echo $detail->diagnosa->diagnosa_nama ?></td>
            <td><?php echo $detail->diagnosa->diagnosa_namalainnya ?></td>
            <td><?= $detail->kasusdiagnosa ?></td>
            <td><?= $detail->statusdiagnosapasien ?></td>
            <td><?= $detail->pegawai->namaLengkap ?></td>
            <td><?= $detail->ppds->ppds_nama ?? '' ?></td>
            <td><?= $detail->ruangan->ruangan_nama ?? '' ?></td>
            <td><?= $detail->ket_diagnosa ?></td>
        </tr>
        <?php 
        $i++;
        } 
    }else{ ?>
        <tr id="is_kosong">
            <td align="center" colspan="5">Data tidak ditemukan</td>
        </tr>
    <?php } ?>
	<?php $pendaftaran_id = $modPendaftaran->pendaftaran_id;  ?>
</table>
<br/>
<table id="tblDaftarDiagnosaIX" class="table table-bordered table-condensed" border="2">
    <thead>
        <tr>
            <th width="50">No.</th>
            <th width="100">Tanggal Diagnosis</th>
            <th width="100">Kelompok Diagnosis</th>
            <th width="50">Kode ICD 9</th>
            <th>Nama ICD 9</th>
            <th>Nama lain ICD 9</th>
            <th>Dokter</th>
            <th width="100">Ruangan</th>
            <th>Dasar Tindakan</th>
        </tr>
    </thead>
    
    <?php 
    $i = 1;
    if (count((array)$modDiagnosaIX) > 0) {
        foreach ($modDiagnosaIX as $detail) {?>
        <tr>
            <td><?php echo $i ?></td>
            <td><?php echo MyFormatter::formatDateTimeForUser($detail->create_time) ?></td>
            <td><?php echo $detail->kelompokdiagnosa->kelompokdiagnosa_nama ?? "-" ?></td>
            <td><?php echo $detail->diagnosatindakan->diagnosaicdix_kode ?></td>
            <td><?php echo $detail->diagnosatindakan->diagnosaicdix_nama ?></td>
            <td><?php echo $detail->diagnosatindakan->diagnosaicdix_namalainnya ?></td>
            <td><?= $detail->pegawai->namaLengkap ?></td>
            <td>
                <?php
                    echo $detail->ruangan->ruangan_nama ?? '';
                    ?> 
            </td>
            <td><?php echo $detail->keterangan ?></td>
            
        </tr>
        <?php 
        $i++;
        }
    }else{ ?>
        <tr id="is_kosong">
            <td align="center" colspan="5">Data tidak ditemukan</td>
        </tr>
    <?php } ?>
	<?php $pendaftaran_id = $modPendaftaran->pendaftaran_id;  ?>
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

<?php }else{ ?>
	<!-- <div class="form-actions">
		<?php //echo CHtml::htmlButton(Yii::t('mds','{icon} Print Detail',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print("PRINT","'.$pendaftaran_id.'")'))."&nbsp&nbsp"; ?>
	</div> -->
<?php } ?>


