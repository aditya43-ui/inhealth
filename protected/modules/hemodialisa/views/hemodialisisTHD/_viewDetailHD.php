<table width="100%" >
    <tr>
        <td >
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('nama_pasien')); ?>:</label>
			<?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?>
        </td>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('tgl_pendaftaran')); ?>:</label>
			<?php echo CHtml::encode($modPendaftaran->tgl_pendaftaran); ?>
        </td>
    </tr><br/>
    <tr>
        <td>
			<label class='control-label'><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('jeniskelamin')); ?>:</label>
			<?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?>
        </td>
        <td>
			<label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('no_pendaftaran')); ?>:</label>
			<?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?>
        </td>
    </tr><br/>
    <tr>
        <td>
			<label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('umur')); ?>:</label>
			<?php echo CHtml::encode($modPendaftaran->umur); ?>
        </td>
        <td>
			<label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('Kelas Pelayanan')); ?>:</label>
			<?php 
			//echo CHtml::encode($modPendaftaran->kelaspelayanan_id); 
			$kelaspelayanan = KelaspelayananM::model()->findByPk($modPendaftaran->kelaspelayanan_id);
			echo $kelaspelayanan->kelaspelayanan_nama;
			?>
        </td>
    </tr><br/>
    <tr>
        <td>
			<label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('Jenis Penjamin / Penjamin ')); ?>:</label>
			<?php 
			//echo CHtml::encode($modPendaftaran->carabayar_id); 
			$carabayar = CarabayarM::model()->findByPk($modPendaftaran->carabayar_id);
			echo $carabayar->carabayar_nama;
			?> / <?php echo CHtml::encode($modPendaftaran->penjamin->penjamin_nama); ?>

        </td>
    </tr> 
</table>
<table width="100%" class="table table-bordered">
	<tr>
		<td width="25%"><b>Jenis Hemodialisa</b></td>
		<td width="25%">
			<?php
			$jenisHD = JenishdM::model()->findByPk($modHemodialisa->jenishd_id);
			echo $jenisHD->jenishd_nama;
			?>
		</td>
		<td width="25%"><b>Akses Vaskular</b></td>
		<td width="25%">
			<?php
			$vaskular = AksesvaskularM::model()->findByPk($modHemodialisa->aksesvaskular_id);
			echo $vaskular->aksesvaskular_nama;
			?>
		</td>
	</tr>
</table>
<table width="100%" class="table table-bordered">
	<tr>
		<td width="25%"><b>Jenis Dialiser</b></td>
		<td width="25%">
			<?php
			$dialiser = JenisdialisatM::model()->findByPk($modHemodialisa->jenisdialisat_id);
			echo $dialiser->jenisdialisat_nama;
			?>
		</td>
		<td width="25%"><b>Penggunaan Dialiser Ke</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->dialiserke;
			?>
		</td>
	</tr>
	<tr>
		<td width="25%"><b>Tanggal Dialiser</b></td>
		<td width="25%">
			<?php
			echo MyFormatter::formatDateTimeForUser($modHemodialisa->periksahd_tgl);
			?>
		</td>
		<td width="25%"><b>Perawat</b></td>
		<td width="25%">
			<?php
			$perawat = PegawaiM::model()->findByPk($modHemodialisa->pegawai_id);
			echo (isset($perawat->nama_pegawai))? $perawat->nama_pegawai : "";
			?>
		</td>
	</tr>
</table>
<table width="100%" class="table table-bordered">
	<tr>
		<td width="25%"><b>Aliran Darah (QB)</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->kec_darah_qb;
			?>
			ml/Menit
		</td>
		<td width="25%"><b>Aliran Dialisat (QD)</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->kec_dialisat_qd;
			?>
			ml/Menit
		</td>
	</tr>
</table>
<table width="100%" class="table table-bordered">
	<tr>
		<td width="25%"><b>Dosis Awal</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->heparin_dosisawal;
			?>
		</td>
		<td width="25%"><b>Kontinyu</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->heparin_continyu;
			?>
		</td>
	</tr>
	<tr>
		<td width="25%"><b>LMWH</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->heparin_lmwh;
			?>
		</td>
		<td width="25%"><b>Tampa Heparin</b></td>
		<td width="25%">
			<?php
			$modHemodialisa->tanpaheparin_nama = !empty($modHemodialisa->tanpaheparin_nama) ? $modHemodialisa->tanpaheparin_nama : "-";
			echo $modHemodialisa->tanpaheparin_nama." : ".$modHemodialisa->tanpaheparin_jml;
			?>
		</td>
	</tr>
	<tr>
		<td width="25%"><b>Intermiten</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->heparin_intermiten;
			?>
		</td>
	</tr>
</table>
<table width="100%" class="table table-bordered">
	<tr>
		<td width="25%"><b>BB Pra Hemodialisa</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->bb_pra_hd_kg;
			?>
			Kg
		</td>
		<td width="25%"><b>BB Post Hemodialisa</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->bb_post_hd_kg;
			?>
			Kg
		</td>
	</tr>
	<tr>
		<td width="25%"><b>BB Kering</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->bb_kering_kg;
			?>
			Kg
		</td>
	</tr>
</table>
<table width="100%" class="table table-bordered">
	<tr>
		<td width="25%"><b>Ultrafiltrasi</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->ultrafiltrasi_mode;
			?>
		</td>
		<td width="25%"><b>Natrium</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->natrium_mode;
			?>
		</td>
	</tr>
	<tr>
		<td width="25%"><b>Bicarbonat</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->bicarbonat_mode;
			?>
		</td>
	</tr>
</table>
<table width="100%" class="table table-bordered">
	<tr>
		<td width="25%"><b>Hemapo</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->obat_hemapo." ".$modHemodialisa->obat_hemapo_stn;
			?>
		</td>
		<td width="25%"><b>Epodion</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->obat_epodion." ".$modHemodialisa->obat_epodion_stn;
			?>
		</td>
	</tr>
	<tr>
		<td width="25%"><b>Recormon</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->obat_recormon." ".$modHemodialisa->obat_recormon_stn;
			?>
		</td>
		<td width="25%"><b>Prep Besi</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->injeksi_preb_besi." ".$modHemodialisa->injeksi_preb_besi_stn;
			?>
		</td>
	</tr>
	<tr>
		<td width="25%"><b>Eprex</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->obat_eprex." ".$modHemodialisa->obat_eprex_stn;
			?>
		</td>
		<td width="25%"><b>Asam Amino</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->injeksi_asamamir." ".$modHemodialisa->injeksi_asamamir_stn;
			?>
		</td>
	</tr>
	<tr>
		<td width="25%"><b>Epotrex</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->obat_epotrex." ".$modHemodialisa->obat_epotrex_stn;
			?>
		</td>
	</tr>
</table>
<table width="100%" class="table table-bordered">
	<tr>
		<td width="25%"><b>Jenis Transfusi Darah</b></td>
		<td width="25%">
			<?php
			if(!empty($modHemodialisa->jenistransfusi_id)){
				$transfusi = JenistransfusiM::model()->findByPk($modHemodialisa->jenistransfusi_id);
				echo $transfusi->jenistransfusi_nama;
			}else{
				echo "-";
			}
			?>
		</td>
		<td width="25%"><b>Jumlah Labu</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->jmllabudarah;
			?>
		</td>
	</tr>
</table>
<table width="100%" class="table table-bordered">
	<tr>
		<td style="text-align: center"><b>Penyulit</b></td>
	</tr>
	<tr>
		<td>
			<?php
			$penyulit = explode(" ,", $modHemodialisa->periksahd_penyulit);
			foreach ($penyulit as $value){
				echo " -".$value;
				echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			}
			?>
		</td>
	</tr>
</table>
<table width="100%" class="table table-bordered">
	<tr>
		<td width="25%"><b>Predialysis BUN</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->pre_dialisis_bun;
			?>
			mg/dl
		</td>
		<td width="25%"><b>Urea Reduction Ratio</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->adekuasi_urr;
			?>
			%
		</td>
	</tr>
	<tr>
		<td width="25%"><b>Postdialysis BUN</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->post_dialisis_bun;
			?>
			mg/dl
		</td>
		<td width="25%"><b>Kt/ V</b></td>
		<td width="25%">
			<?php
			echo $modHemodialisa->adekuasi_kt_v;
			?>
		</td>
	</tr>
</table>
<table>
	<tr>
		<td><?php echo CHtml::link(Yii::t('mds', '{icon} Print Detail', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printHD();return false")); ?></td>
	</tr>
</table>

<script type="text/javascript">
    function printHD()
	{
		window.open('<?php echo $this->createUrl('printHemodialisa',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'periksahd_id'=>$modHemodialisa->periksahd_id)); ?>','printwin','left=100,top=100,width=640,height=480');
	}
</script>