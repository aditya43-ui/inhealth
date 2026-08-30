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
    <?php
        $total_tarif = 0;
        foreach ($modPeriksa as $i=>$daftartindakans){
            $nama = ROPemeriksaanRadM::model()->findByAttributes(array('daftartindakan_id'=>$daftartindakans->daftartindakan_id)); 
                                //if (count((array)$modKeluar)>0){ foreach($modKeluar as $tin){ 
          //  $keterangan = $tin->pemeriksaankeluar_ket;
          //  $lab = $tin->getPeriksaRad($tin->daftartindakan_id);
        ?>
    
    <tr>
        <!-- <td><?php //echo !empty($lab->jenispemeriksaanrad_id)?$lab->jenispemeriksaanrad->jenispemeriksaanrad_nama:'-'; ?></td> -->
        <td><?php
                foreach ($modPemeriksaan as $j => $permintaan) {
                    echo strip_tags($permintaan->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_nama) . '<br>';
                }
                ?></td>
        <td><?php echo $nama->pemeriksaanrad_nama; ?></td>
        <td>
            <?php
            foreach ($modPemeriksaan as $j => $permintaan) {
                echo $permintaan->qtypermintaan . '<br>';
            }
            ?>
        </td>
        <!-- <td><?php //echo !empty($lab)?$lab->pemeriksaanrad_nama:'-'; ?></td>
        <td><?php //echo $tin->tindakanpelayanan->qty_tindakan; ?></td> -->
    </tr>
    <?php }//}?>
</table>

<table  style="color:#333;padding:10px;text-align: left;" width="100%">	
	<tr>
		<th width="20%" valign="top">Catatan </th>
                <td width="2%" valign="top">: </td>							
                <td>  
                    <ol>
                    <?php if (!empty($keterangan)){ ?>
                        <li><?php echo $keterangan; ?></li>
                    <?php }?>
                    <ol>
                </td>							
	</tr>		
        
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