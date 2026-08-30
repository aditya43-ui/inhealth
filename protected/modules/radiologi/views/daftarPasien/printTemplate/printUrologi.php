<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');

echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
?>
<style>
     #header tr th {
        font-size: 10pt !important;
        font-family: Arial, Helvetica, sans-serif;
    }
    #text tr th {
        font-size: 11pt !important;
        font-family: Arial, Helvetica, sans-serif;
    }

    #text tr td p {
        font-size: 10pt !important;
        text-align: justify;
        line-height: 2;
    }
</style>
<table id="header" class="table noborder">
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
<table id="text" class="table noborder">    
    <tr>
        <th colspan="3">Ts Yth Hasil Pemeriksaan 
            <?php echo !empty($model->pemeriksaanrad->jenispemeriksaanrad_id)?$model->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_nama:'' ?> 
            <?php echo !empty($model->pemeriksaanrad_id)?$model->pemeriksaanrad->pemeriksaanrad_nama:'' ?> :
        </th>
        
    </tr>    
    <tr>
        <!-- <th width="20%">Ren Dextra</th>
        <th width="2%">:</th> -->
        <td><p><?php echo isset($hasilexpertise[0])?trim($hasilexpertise[0]):''; ?></p></td>
    </tr>
    <tr>
        <!-- <th>Ren Sinistra</th>
        <th>:</th> -->
        <td><p><?php echo isset($hasilexpertise[1])?trim($hasilexpertise[1]):''; ?></p></td>
    </tr>    
     <tr>
        <!-- <th>Buli</th>
        <th>:</th> -->
        <td><p><?php echo isset($hasilexpertise[2])?trim($hasilexpertise[2]):''; ?></p></td>
    </tr>
     <tr>
        <!-- <th>Prostat</th>
        <th>:</th> -->
        <td><p><?php echo isset($hasilexpertise[3])?($hasilexpertise[3]):''; ?></p></td>
    </tr>   
    <tr>
        <!-- <th>Kesimpulan</th>
        <th>:</th> -->
        <td><p><?php echo $model->kesimpulan_hasilrad; ?></p></td>
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

