<style>
    .watermark
    {
       background-image: url(http://localhost/ehospitaljk/images/watermark_print.png);
       background-position: center 350px;
       background-size: 300px; /* CSS3 only, but not really necessary if you make a large enough image */
       position: absolute;
       background-repeat: no-repeat;
       width: 100%;
       margin: 0;
       z-index: 1000;
    }
    
</style>
<?php 
    if(isset($modHasilPeriksa)){
        if($modHasilPeriksa->printhasillab == '1') {echo '<div class="watermark">';} 
    }   
?>
<table style="font-family: arial;font-size: 10pt;" class="">
   <tr>
       <td colspan="5" width="100%" align="center"><h1>Hasil Pemeriksaan Fisioterapi</h1></td>
        
    </tr> 

    <tr>
        
        <td>Tanggal Pendaftaran</td>
        <td>: <?php echo $masukpenunjang2->tgl_pendaftaran; ?></td>
        <td width="20%">No. Rekam Medik</td>
        <td>: <?php echo $masukpenunjang2->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td>
        <td>: <?php echo $masukpenunjang2->no_pendaftaran; ?></td>
        <td width="20%">Nama PasienMedik</td>
        <td>: <?php echo $masukpenunjang2->nama_pasien; ?></td>
    </tr>
    <tr>
        <td>No.Masuk Penunjang</td>
        <td>: <?php echo $masukpenunjang2->no_masukpenunjang2; ?></td>
        <td width="20%">Tanggal Lahir/Umur</td>
        <td>: <?php echo $masukpenunjang2->tanggal_lahir."/".$masukpenunjang2->umur ?></td>
    </tr>
    <tr>
        <td>Tanggal Masuk Penunjang</td>
        <td>: <?php echo $masukpenunjang2->tglmasukpenunjang2; ?></td>
        <td width="20%">Jenis Kelamin</td>
        <td>: <?php echo $masukpenunjang2->jeniskelamin ?></td>
    </tr>
    <tr>
        <td>Ruangan</td>
        <td>: <?php echo $masukpenunjang2->ruangan_nama; ?></td>
        <td width="10%">Alamat</td>
        <td>: <?php echo $masukpenunjang2->alamat_pasien ?></td>
    </tr>
</table>
<div style="font-family:arial;font-size:10pt;">
    <b>
    <?php
        //echo $masukpenunjang2->no_rekam_medik . '/' . $masukpenunjang2->ruanganasal_nama . '/' . $masukpenunjang2->kelaspelayanan_nama;
    ?>
    </b>
</div>
<br>

<table border="1" class="table table-bordered datatable">
        <tr>
        <th>No.</th>
        <th>Tindakan</th>
        <th>Problematika Fisioterapi</th>
        <th>Dosis Tindakan</th>
        <th>Evaluasi</th>

    </tr>
        <?php 
        $row=1;
        foreach($detailHasil as $i=>$detail): 
            
        ?>
        <tr>
          
            <td><?php echo $row?></td>
            <td><?php echo $detail->tindakanrm->jenistindakanrm->jenistindakanrm_nama." / ".$detail->tindakanrm->daftartindakan->daftartindakan_nama   ?></td>
            <td><?php echo $detail->hasilpemeriksaanrm   ?></td>
            <td><?php echo $detail->keteranganhasilrm  ?></td>
            <td><?php echo $detail->evaluasi ?></td>
        </tr>
        <?php 
        $row++;
        endforeach; ?>
    </table>

