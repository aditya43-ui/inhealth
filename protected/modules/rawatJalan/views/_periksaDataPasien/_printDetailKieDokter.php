<style>
    .footer{
        margin-top: 15%;
    }
</style>

<?php

    // $modPenjualanObat = RJPenjualanresepT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)); 
    // $modObatAlkes = RJObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id' => $modPenjualanObat->penjualanresep_id)); 

?>

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
			    <div class="judulcontent">Lembar Kie Dokter</div>
                <hr>

                <br><br><br>
               <table width="100%" border="1">
                    <tr>
                        <th class="tg-0lax"><b>Nama Pasien</b></th>
                        <th class="tg-0lax"><?php echo $modPendaftaran->pasien->nama_pasien; ?></th>
                        <th class="tg-0lax"><b>Tanggal Pendaftaran</b></th>
                        <th class="tg-0lax"><?php echo $modPendaftaran->tgl_pendaftaran;?></th>
                    </tr>
                    
                    <tr>
                        <td class="tg-0lax"><b>Jenis Kelamin</b></td>
                        <td class="tg-0lax"><?php echo $modPendaftaran->pasien->jeniskelamin;?></td>
                        <td class="tg-0lax"><b>No Pendaftaran</b></td>
                        <td class="tg-0lax"><?php echo $modPendaftaran->no_pendaftaran; ?></td>
                    </tr>
                    <tr>
                        <td class="tg-0lax"><b>Umur</b></td>
                        <td class="tg-0lax"><?php echo $modPendaftaran->umur;?></td>
                        <td class="tg-0lax"><b>Kelas Pelayanan</b></td>
                        <td class="tg-0lax"><?php echo $modPendaftaran->kelaspelayanan->kelaspelayanan_nama; ?></td>
                    </tr>
                    <tr>
                        <td class="tg-0lax"><b>Cara Pembayaran/Penjamin</b></td>
                        <td class="tg-0lax"><?php echo $modPendaftaran->carabayar->carabayar_nama . "/" . $modPendaftaran->penjamin->penjamin_nama; ?></td>
                        <!-- <td class="tg-0lax" rowspan="2"><b>Petugas Farmasi</b></td>
                        <td class="tg-0lax" rowspan="2"><?php //echo (!empty($modPenjualanObat->pegawai_id) ? $modPenjualanObat->pegawai->nama_pegawai : "-"); ?></td> -->
                    </tr>
                    
                    <tr>
                        <!-- <td class="tg-0lax"><b>No Resep</b></td>
                        <td class="tg-0lax"><?php //echo (!empty($modPenjualanObat->noresep) ? $modPenjualanObat->noresep : "-"); ?></td> -->
                    </tr>
                </table>
            </td>
        </tr>
</table>

<br><br><br>
<!-- tambahkan table -->



<b>Daftar Komunikasi Informasi dan Edukasi</b><br><br>            
<?php
$modListKie = ListkieM::model()->findAll("jeniskie = 'Dokter'");
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
    <?php //echo CJSON::encode($k); ?>
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
                    <p style="text-align:center;">( <?php echo CHtml::encode($modKie->pegawai->getNamaLengkap()); ?> )</p>
            </td>
            <td width="50%">
                <p style="text-align:center;">Penerima Informasi</p>
                    <br/><br/><br/><br/>
                    <p style="text-align:center;">( <?php echo CHtml::encode($modKie->pasien->nama_pasien); ?> )</p>
            </td>
        </tr>
    </table>
