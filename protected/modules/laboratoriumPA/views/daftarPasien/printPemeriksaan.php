<?php
/**
*  
*
* - digunakan untuk menampilkan format prinout pemeriksaan
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');

echo $this->renderPartial('application.views.headerReport.headerDefault',array('colspan'=>3));      
?>
<table  style="color:#333;padding:10px;text-align: left;" width="100%">	
	<tr>
		<th width="20%">Tanggal</th>
                <td>: <?php echo MyFormatter::formatDateTimeForUser(date('Y-m-d')); ?></td>							
	</tr>		
        <tr>
		<th>No Permintaan</th>
                <td>: <?php echo $modKunjungan->no_pendaftaran; ?></td>							
	</tr>		
        <tr>
		<th>No RM</th>
                <td>: <?php echo $modKunjungan->no_rekam_medik; ?></td>							
	</tr>
        <tr>
		<th>Nama Pasien</th>
                <td>: <?php echo $modKunjungan->namadepan." ".$modKunjungan->nama_pasien; ?></td>							
	</tr>
        <tr>
		<th>Jenis Kelamin</th>
                <td>: <?php echo $modKunjungan->jeniskelamin; ?></td>							
	</tr>
        <tr>
		<th>Tanggal Lahir/Umur</th>
                <td>: <?php echo MyFormatter::formatDateTimeForUser($modKunjungan->tanggal_lahir)."/".CustomFunction::getUmur($modKunjungan->tanggal_lahir); ?></td>							
	</tr>
</table>
<p>&nbsp;</p>
<table class="table border">
    <tr>
        <th width= "33%">Jenis Pemeriksaan</th>
        <th width= "33%">Pemeriksaan</th>
        <th width= "33%">Jumlah</th>        
    </tr>
    <?php if (count($modPeriksa)>0){ foreach($modPeriksa as $tin){ 
            $lab = $tin->getPeriksaLab($tin->daftartindakan_id);
        ?>
    <tr>
        <td><?php echo !empty($lab->jenispemeriksaanlab_id)?$lab->jenispemeriksaan->jenispemeriksaanlab_nama:'-'; ?></td>
        <td><?php echo !empty($lab)?$lab->pemeriksaanlab_nama:'-'; ?></td>
        <td><?php echo $tin->qty_tindakan; ?></td>
    </tr>
    <?php }}?>
</table>

<p>&nbsp;</p>
<table class="table border">
    <thead>
        <tr>
            <th width= "33%">Jenis Spesimen</th>
            <th width= "33%">No Spesimen</th>
            <th width= "33%">Jumlah</th>        
            <th width= "33%">Keterangan</th>        
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($modSample)) {
             foreach ($modSample as $sam){ ?>
        <tr>
            <td><?php echo $sam->samplelab->samplelab_nama; ?></td>
            <td><?php echo $sam->no_pengambilansample; ?></td>
            <td><?php echo $sam->jmlpengambilansample; ?></td>
            <td><?php echo $sam->keterangansample; ?></td>
        </tr>
             <?php }
        }?>
    </tbody>
    
</table>

<table  style="color:#333;padding:10px;text-align: center;" width="100%">	
	<tr>
		<td width="70%"></td>                					
                <td>Dokter Penanggung Jawab</td>							
	</tr>		
        <tr>
		<td>&nbsp;</td>                					
                <td>&nbsp;</td>							
	</tr>
        <tr>
		<td>&nbsp;</td>                					
                <td>&nbsp;</td>							
	</tr>
        <tr>
		<td>&nbsp;</td>                					
                <td>&nbsp;</td>							
	</tr>
        <tr>
		<td>&nbsp;</td>                					
                <td>&nbsp;</td>							
	</tr>
        <tr>
		<td></td>                					
                <td><?php echo $modKunjungan->getNamaLengkapDokter($modKunjungan->pegawai_id); ?></td>							
	</tr>
        
</table>