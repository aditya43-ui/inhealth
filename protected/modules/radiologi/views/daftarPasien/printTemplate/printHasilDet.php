<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');

echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
?>
<table class="table noborder">
    <tr>
        <th style="text-align:right;" colspan="3">TANGGAL : <?php echo MyFormatter::formatDateTimeForUser($model->tglpegambilanhasilrad) ?></th>
        
    </tr>
    <tr>
        <th width="20%">NAMA</th>
        <th width="2%">:</th>
        <th><?php echo $model->pasien->nama_pasien ?></th>
    </tr>
    <tr>
        <th>UMUR</th>
        <th>:</th>
        <th><?php echo CustomFunction::getUmur($model->pasien->tanggal_lahir); ?></th>
    </tr>
    <tr>
        <th>JENIS KELAMIN</th>
        <th>:</th>
        <th><?php echo $model->pasien->jeniskelamin ?></th>
    </tr>
    <tr>
        <th>ALAMAT</th>
        <th>:</th>
        <th><?php echo $model->pasien->alamat_pasien ?></th>
    </tr>    
</table>

<table class="table noborder">    	
    <tr>
        <th colspan="3">Ts Yth Hasil Pemeriksaan 
            <?php echo !empty($model->pemeriksaanrad->jenispemeriksaanrad_id)?$model->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_nama:'' ?> 
            <?php echo !empty($model->pemeriksaanrad_id)?$model->pemeriksaanrad->pemeriksaanrad_nama:'' ?> :
        </th>        
    </tr>    
	<?php
		foreach ($hasDet as $det){
	?>
			<tr>
				<th width="20%"><?php echo $det->refhasildet_nama ?></th>
				<th width="2%">:</th>
				<td><?php echo $det->hasperiksaraddet_expertise; ?></td>
			</tr>
	<?php 
		}
	?>      
    <tr>
        <th>Kesimpulan</th>
        <th>:</th>
        <td><?php echo $model->kesimpulan_hasilrad; ?></td>
    </tr>  
</table>

<table class="table noborder">    
    <tr>    
        <th width="70%"></th>        
        <th style="text-align:center;">Banyak Terima Kasih</th>
    </tr>    
    <tr>
        <th></th>
        <th style="text-align:center;">Salam Sejawat</th>
    </tr>
    <tr>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
    </tr>
    <tr>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
    </tr>
	 <tr>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
    </tr>
    <tr>
        <th>&nbsp;</th>
        <th style="text-align:center;">
			<?php 
				echo !empty($model->pasienmasukpenunjang->pegawai_id)?$model->pasienmasukpenunjang->pegawai->namaLengkap:'-'; 				
			?>
		</th>
    </tr>
	<tr>
        <th>&nbsp;</th>
        <th style="text-align:center;">
			<?php 				
				echo "NIP. ".(!empty($model->pasienmasukpenunjang->pegawai_id)?$model->pasienmasukpenunjang->pegawai->nomorindukpegawai:'-');
			?>
		</th>
    </tr>
</table>
<script>
    window.print(); 
</script>

