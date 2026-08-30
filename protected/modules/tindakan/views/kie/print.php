<style>
    .footer{
        margin-top: 15%;
    }
</style>


<table width="100%">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
			    <div class="judulcontent">Komunikasi Informasi dan Edukasi</div>
                <hr>
               <table width="100%" border="1">
                    <tr>
                        <td><b>Nama Pasien</b></td>
                        <!-- <td>:</td> -->
                        <td><?php echo $modPendaftaran->pasien->nama_pasien; ?></td>
                         <td><b>Tanggal Pendaftaran</b></td>
                        <td><?php echo $modPendaftaran->tgl_pendaftaran;?></td>
                    </tr>
                     <tr>
                        <td><b>Jenis Kelamin</b></td>
                        <td><?php echo $modPendaftaran->pasien->jeniskelamin;?></td>
                        <td><b>No Pendaftaran</b></td>
                        <td><?php echo $modPendaftaran->no_pendaftaran; ?></td>
                    </tr>
                    <tr>
                        <td><b>Umur</b></td>
                        <td><?php echo $modPendaftaran->umur;?></td>
                        <td><b>Kelas Pelayanan</b></td>
                        <td><?php echo $modPendaftaran->kelaspelayanan->kelaspelayanan_nama; ?></td>
                    </tr>
                    <tr>
                        <td><b>Cara Pembayaran/Penjamin</b></td>
                        <td><?php echo $modPendaftaran->carabayar->carabayar_nama . "/" . $modPendaftaran->penjamin->penjamin_nama; ?></td>
                        <td><b>Dokter</b></td>
                        <td><?php echo $modPendaftaran->dokter->getNamaLengkap(); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
</table>

<br><br><br>
<b>Daftar Komunikasi Informasi dan Edukasi</b><br>             
<?php
$result = array();
foreach ($modListKie as $l) {
    $result[$l['jeniskie']]['jeniskie'] = $l['jeniskie'];
    $result[$l['jeniskie']]['listkie_nama'] = $l['listkie_nama'];
    $result[$l['jeniskie']]['detail'][] = array(
        'jeniskie' => $l['jeniskie'],
        'listkie_id' => $l['listkie_id'],
        'listkie_nama' => $l['listkie_nama'],
        'ada' => 0,

    );
}
?>
<table>
<?php foreach($result as $k => $v){?>
    <tr>
        <td>&#x2611; <?php echo $k ?> : </td>      
    </tr>
    <tr><td>&nbsp;</td></tr>
    <?php
                
                foreach($v['detail'] as $det) { 
                foreach($modDetails as $k => $d){ ?>
                <tr>
                    <td>
                        <!-- <dl> -->
                            <?php if($d->listkie_id == $det['listkie_id']){
                                echo "<dd>&#10004;  ".$det['listkie_nama']."</dd>";
                            }?>
                        <!-- </dl> -->
                   
                    </td>
                </tr>
                <?php } } ?>
                    <?php } ?>
                </div>
            </td>
        </tr>
    </tbody>
</table>


    <table class="footer" width="100%">
        <tr>
            <td width="50%">
                <p style="text-align:center;">Pemberi Informasi</p>
                    <br/><br/><br/><br/>
                    <p style="text-align:center;">( <?php echo CHtml::encode($model->pegawai->getNamaLengkap()); ?> )</p>
            </td>
            <td width="50%">
                <p style="text-align:center;">Penerima Informasi</p>
                    <br/><br/><br/><br/>
                    <p style="text-align:center;">( <?php echo CHtml::encode($model->pasien->nama_pasien); ?> )</p>
            </td>
        </tr>
    </table>
