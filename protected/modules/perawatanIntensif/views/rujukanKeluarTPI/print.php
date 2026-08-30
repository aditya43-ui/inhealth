
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'colspan'=>10)); 

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
        <td <?php // $td = array(); echo $td; ?>>
            <label class='control-label'><?php echo CHtml::encode($modRujukanKeluar->getAttributeLabel('nosuratrujukan')); ?>:</label>
            <?php echo CHtml::encode($modRujukanKeluar->nosuratrujukan); ?>
        </td>
        <td>
			<label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('tgl_pendaftaran')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->tgl_pendaftaran); ?>
        </td>
    </tr><br>
    <tr>
        <td <?php // $td = array(); echo $td; ?>>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('nama_pasien')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?>
        </td>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('no_pendaftaran')); ?>:</label>
			<?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?>
        </td>
    </tr><br>
    <tr>
        <td>
			<label class='control-label'><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('jeniskelamin')); ?>:</label>
			<?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?>
        </td>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('Kelas Pelayanan')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->kelaspelayanan->kelaspelayanan_nama); ?>
        </td>
    </tr><br>
    <tr>
        <td>
			<label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('umur')); ?>:</label>
			<?php echo CHtml::encode($modPendaftaran->umur); ?>
        </td>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('Nama Dokter')); ?>:</label>
            <?php // echo CHtml::encode($modPendaftaran->pegawai->nama_pegawai); ?>
            <?php echo (isset($modPendaftaran->pegawai_id) ? $modPendaftaran->pegawai->getNamaLengkap() : ''); ?>
        </td>
    </tr><br>
    <tr>
        <td>
                <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('Jenis Penjamin / Penjamin')); ?>:</label>
                <?php echo CHtml::encode($modPendaftaran->carabayar->carabayar_nama); ?> /  <?php echo CHtml::encode($modPendaftaran->penjamin->penjamin_nama); ?>
        </td>
        <td>
            
        </td>
    </tr>
       
</table>
<br>
<table class="items table table-striped table-bordered table-condensed" id="tblInputTindakan">
    <thead>
        <tr>
            <th>Tanggal Dirujuk</th>
            <th>No. Pendaftaran</th>
            <th>Rumah Sakit Tujuan</th>
            <th>Dirujuk ke Bagian</th>
            <th>Dokter Tujuan</th>

        </tr>
    </thead>
    <?php foreach ($modRiwayatRujukanKeluar as $i => $rujukan) { ?>
    <tr>
        <td><?php echo $rujukan->tgldirujuk ?></td>
        <td><?php echo $rujukan->pendaftaran->no_pendaftaran ?></td>
        <td><?php echo $rujukan->rujukankeluar->rumahsakitrujukan ?></td>
        <td><?php echo $rujukan->dirujukkebagian ?></td>
        <td><?php echo $rujukan->kepadayth ?></td>
    </tr>
    <?php } ?>
   
</table>

<br>
<table style='margin-left:auto; margin-right:auto;' border="0" width="100%">
    <tr>
        <td width="60%">
			<table>
				<tr>
					<td>Catatan Dokter</td>
					<td>: <?php echo isset($modRujukanKeluar->catatandokterperujuk) ? $modRujukanKeluar->catatandokterperujuk : ""; ?></td>
				</tr>
				<tr>
					<td>Alasan Dirujuk</td>
					<td>: <?php echo isset($modRujukanKeluar->alasandirujuk) ? $modRujukanKeluar->alasandirujuk : ""; ?></td>
				</tr>
				<tr>
					<td>Hasil Pemeriksaan</td>
					<td>: <?php echo isset($modRujukanKeluar->hasilpemeriksaan_ruj) ? $modRujukanKeluar->hasilpemeriksaan_ruj : ""; ?></td>
				</tr>
				<tr>
					<td>Diagnosa Sementara &nbsp; </td>
					<td>: <?php echo isset($modRujukanKeluar->diagnosasementara_ruj) ? $modRujukanKeluar->diagnosasementara_ruj : ""; ?></td>
				</tr>
				<tr>
					<td>Pengobatan Rujukan</td>
					<td>: <?php echo isset($modRujukanKeluar->pengobatan_ruj) ? $modRujukanKeluar->pengobatan_ruj : ""; ?></td>
				</tr>
			</table>
            
        </td>
        <td width="10%">&nbsp;</td>
        <td>
             Dokter Pemeriksa
            <br><br><br><br>
           ( 
               <?php // echo CHtml::encode($modPendaftaran->pegawai->nama_pegawai); ?> 
               <?php echo (isset($modPendaftaran->pegawai_id) ? $modPendaftaran->pegawai->getNamaLengkap() : ''); ?>
           )
        </td>
    </tr>
</table>
