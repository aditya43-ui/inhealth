<style>
    body{
        height: 13.7cm;          
        width:20cm;
        font-size:22pt;
        padding:10px;
        /**border:1px solid #333;**/
        margin-top:0.2cm;
        margin-left: 2cm;
        margin-right: 2cm;
    }
    
    .label{
        height:3.2cm;
        width:6.4cm;   
        margin-bottom: 4px;
        vertical-align: middle;
        padding-top: 35px;
        border: 1px solid #333;
        font-size:12pt;
    }
    
    
</style>

<?php 
    $modPendaftaran->tgl_pendaftaran = date('Y-m-d', strtotime($modPendaftaran->tgl_pendaftaran));
?>
<table width="100%" style="text-align:center;">
    <tr  style="text-align:center;">
        <td >
            <div class="label">
                <?php echo $modPendaftaran->pasien->no_rekam_medik; ?>
                    <br>
                <?php echo $modPendaftaran->pasien->nama_pasien; ?>
                    <br>
                <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?>
            </div>
           
        <div class="label">
                <?php echo $modPendaftaran->pasien->no_rekam_medik; ?>
                    <br>
                <?php echo $modPendaftaran->pasien->nama_pasien; ?>
                    <br>
                    <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?>
        </div>
      
        <div class="label">
                <?php echo $modPendaftaran->pasien->no_rekam_medik; ?>
                    <br>
                <?php echo $modPendaftaran->pasien->nama_pasien; ?>
                    <br>
                <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?>
        </div>
            
             <div class="label">
                <?php echo $modPendaftaran->pasien->no_rekam_medik; ?>
                    <br>
                <?php echo $modPendaftaran->pasien->nama_pasien; ?>
                    <br>
                <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?>
        </div>
        </td>
        <td>
            <div class="label">
                <?php echo $modPendaftaran->pasien->no_rekam_medik; ?>
                    <br>
                <?php echo $modPendaftaran->pasien->nama_pasien; ?>
                    <br>
                <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?>
            </div>
           
        <div class="label">
                <?php echo $modPendaftaran->pasien->no_rekam_medik; ?>
                    <br>
                <?php echo $modPendaftaran->pasien->nama_pasien; ?>
                    <br>
                    <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?>
        </div>
      
        <div class="label">
                <?php echo $modPendaftaran->pasien->no_rekam_medik; ?>
                    <br>
                <?php echo $modPendaftaran->pasien->nama_pasien; ?>
                    <br>
                <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?>
        </div>
            
             <div class="label">
                <?php echo $modPendaftaran->pasien->no_rekam_medik; ?>
                    <br>
                <?php echo $modPendaftaran->pasien->nama_pasien; ?>
                    <br>
                <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?>
        </div>
        </td>
        <td>
            <div class="label">
                <?php echo $modPendaftaran->pasien->no_rekam_medik; ?>
                    <br>
                <?php echo $modPendaftaran->pasien->nama_pasien; ?>
                    <br>
                <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?>
            </div>
           
        <div class="label">
                <?php echo $modPendaftaran->pasien->no_rekam_medik; ?>
                    <br>
                <?php echo $modPendaftaran->pasien->nama_pasien; ?>
                    <br>
                    <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?>
        </div>
      
        <div class="label">
                <?php echo $modPendaftaran->pasien->no_rekam_medik; ?>
                    <br>
                <?php echo $modPendaftaran->pasien->nama_pasien; ?>
                    <br>
                <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?>
        </div>
            
             <div class="label">
                <?php echo $modPendaftaran->pasien->no_rekam_medik; ?>
                    <br>
                <?php echo $modPendaftaran->pasien->nama_pasien; ?>
                    <br>
                <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?>
        </div>
        </td>
    </tr>
</table>