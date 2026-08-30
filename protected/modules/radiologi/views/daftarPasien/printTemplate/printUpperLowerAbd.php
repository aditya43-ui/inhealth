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

<?php $hasilexpertise = explode("{{pisah}}",$model->hasilexpertise); ?>
<table class="table noborder">    
    <tr>
        <th colspan="3">Ts Yth Hasil Pemeriksaan 
            <?php echo !empty($model->pemeriksaanrad->jenispemeriksaanrad_id)?$model->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_nama:'' ?> 
            <?php echo !empty($model->pemeriksaanrad_id)?$model->pemeriksaanrad->pemeriksaanrad_nama:'' ?> :
        </th>
        
    </tr>   
    <tr>
        <th width="20%">Hepar</th>
        <th width="2%">:</th>
        <td><?php echo isset($hasilexpertise[0])?$hasilexpertise[0]:''; ?></td>
    </tr>
    <tr>
        <th>Lien</th>
        <th>:</th>
        <td><?php echo isset($hasilexpertise[1])?$hasilexpertise[1]:''; ?></td>
    </tr>    
     <tr>
        <th>Pancreas</th>
        <th>:</th>
        <td><?php echo isset($hasilexpertise[2])?$hasilexpertise[2]:''; ?></td>
    </tr>
     <tr>
        <th>GB</th>
        <th>:</th>
        <td><?php echo isset($hasilexpertise[3])?$hasilexpertise[3]:''; ?></td>
    </tr>
     <tr>
        <th>Ren Dextra</th>
        <th>:</th>
        <td><?php echo isset($hasilexpertise[4])?$hasilexpertise[4]:''; ?></td>
    </tr>
     <tr>
        <th>Ren Sinistra</th>
        <th>:</th>
        <td><?php echo isset($hasilexpertise[5])?$hasilexpertise[5]:''; ?></td>
    </tr>
     <tr>
        <th>Buli</th>
        <th>:</th>
        <td><?php echo isset($hasilexpertise[6])?$hasilexpertise[6]:''; ?></td>
    </tr>
     <tr>
        <th>Prostat</th>
        <th>:</th>
        <td><?php echo isset($hasilexpertise[7])?$hasilexpertise[7]:''; ?></td>
    </tr>  
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

