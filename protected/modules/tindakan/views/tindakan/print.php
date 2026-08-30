<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
</style>
<table style="width: 100%; border: none;">
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
			
                        <table class="status" width="100%">
        
        <tr>
            <td align="center" valig="middle" colspan="3">
                <b><div class="judulcontent"><?php echo $judul_print ?>  </div></b>
            </td>
        </tr>
        <tr>
            <td align="center" valig="middle" colspan="3">
                 <h4>Data Kunjungan</h4>
            </td>
        </tr>
        <tr>
            <td>No. Pendaftaran</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->no_pendaftaran; ?></td>
        </tr>
        <tr>
            <td>Nama Pasien</td>
            <td>:</td>
            <td><?php echo $modPasien->nama_pasien; ?></td>
        </tr>
        <tr>
            <td>No. Rekam Medik</td>
            <td>:</td>
            <td><?php echo $modPasien->no_rekam_medik; ?></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td><?php echo $modPasien->jeniskelamin; ?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td><?php echo $modPasien->alamat_pasien; ?></td>
        </tr>
        <tr>
            <td>Tanggal Lahir / Umur</td>
            <td>:</td>
            <td><?php echo $modPasien->tanggal_lahir; ?> / <?php echo $modPendaftaran->umur; ?></td>
        </tr>
        <tr>
            <td>Jenis Penjamin / Penjamin</td>
            <td>:</td>
            <td><?php echo isset($modPendaftaran->carabayar->carabayar_nama)?$modPendaftaran->carabayar->carabayar_nama:''; ?> / <?php echo isset($modPendaftaran->penjamin->penjamin_nama)?$modPendaftaran->penjamin->penjamin_nama:''; ?></td>
        </tr>
        <tr>
            <td>Kelas Pelayanan</td>
            <td>:</td>
            <td><?php echo isset($modPendaftaran->kelaspelayanan->kelaspelayanan_nama)?$modPendaftaran->kelaspelayanan->kelaspelayanan_nama:''; ?></td>
        </tr>
        <tr>
            <td align="center" valig="middle" colspan="3">
                 <h4>Daftar Tindakan Pasien</h4>
            </td>
        </tr>
        <tr>
            <td align="center" valig="middle" colspan="3">
                <table class="table table-bordered">
                    <thead>
                        <th>Tindakan</th>
                        <th>Pemakaian Bahan</th>
                    </thead>
                    <tbody>
                <?php foreach ($modTindakans as $i => $modTindakan) { ?>
                    <tr>
                        <td>
                            <?php echo CHtml::hiddenField("tindakan[$i][tindakanpelayanan_id]", $modTindakan->tindakanpelayanan_id,array('readonly'=>true,'class'=>'inputFormTabel lebar2')); ?>
                            <?php echo $modTindakan->tgl_tindakan; ?> <br>
                            <?php echo $modTindakan->tipePaket->tipepaket_nama; ?> <br>
                            <?php echo 'Kategori '.(isset($modTindakan->daftartindakan->kategoritindakan->kategoritindakan_nama) ? $modTindakan->daftartindakan->kategoritindakan->kategoritindakan_nama : ""); ?>,

                            <?php echo CHtml::hiddenField("tindakan[$i][daftartindakan_id]", $modTindakan->daftartindakan_id,array('readonly'=>true,'class'=>'inputFormTabel lebar2')); ?>
                          
                            <?php 
                              if ( $modTindakan->daftartindakan->daftartindakan_nama=='Perawatan Rawat Inap' and $modTindakan->create_ruangan==Params::RUANGAN_ID_PERINATOLOGI){
                                  echo 'Ruang Perinatologi';
                              }else{
                                  echo $modTindakan->daftartindakan->daftartindakan_nama;
                              }
                             ?>,
                            <?php echo $modTindakan->qty_tindakan; ?>
                            <?php echo $modTindakan->satuantindakan; ?> <br>
                            <?php //echo $modTindakan->persenCyto; ?>

                            Pemeriksa : 
                            <?php //echo CHtml::link("<i class='icon-plus-sign'></i>", '#', array('id'=>'btnAddDokter_0','onclick'=>'addDokter(this);return false;')); ?>
                            <?php echo (isset($modTindakan->dokter1->nama_pegawai) ? $modTindakan->dokter1->NamaLengkap : ""); echo (!empty($modTindakan->dokterpemeriksa1_id)) ? ',' : ''; ?></br>
                            <?php echo (isset($modTindakan->dokter2->nama_pegawai) ? $modTindakan->dokter2->nama_pegawai : ""); echo (!empty($modTindakan->dokterpemeriksa2_id)) ? ',' : ''; ?>
                            <?php echo (isset($modTindakan->dokterPendamping->nama_pegawai) ? $modTindakan->dokterPendamping->nama_pegawai : ""); echo (!empty($modTindakan->dokterpendamping_id)) ? ',' : ''; ?>
                            <?php echo (isset($modTindakan->dokterAnastesi->nama_pegawai) ? $modTindakan->dokterAnastesi->nama_pegawai : ""); echo (!empty($modTindakan->dokteranastesi_id)) ? ',' : ''; ?>
                            <?php echo (isset($modTindakan->dokterDelegasi->nama_pegawai) ? "Dokter Delegasi : ".$modTindakan->dokterDelegasi->NamaLengkap : ""); echo (!empty($modTindakan->dokterdelegasi_id)) ? ',<br>' : ''; ?>
                            <?php echo (isset($modTindakan->bidan->nama_pegawai) ? "Bidan : ".$modTindakan->bidan->NamaLengkap : ""); echo (!empty($modTindakan->bidan_id)) ? ',<br>' : ''; ?>
                            <?php echo (isset($modTindakan->suster->nama_pegawai) ? "Suster :".$modTindakan->suster->NamaLengkap : ""); echo (!empty($modTindakan->suster_id)) ? ',<br>' : ''; ?>
                            <?php echo (isset($modTindakan->perawat->nama_pegawai) ? "Perawat : ".$modTindakan->perawat->NamaLengkap : ""); echo (!empty($modTindakan->perawat_id)) ? ',<br>' : ''; ?>
                        </td>
                        <td>
                            <?php 
                                if(!empty($modViewBmhp))
                                {
                                    $this->renderPartial($this->path_view.'_listObatAlkesPasien',array('modViewBmhp'=>$modViewBmhp,'modTindakan'=>$modTindakan));
                                }
                            ?>
                        </td>
                    </tr>

                <?php } ?>
                    </tbody>
                </table>

            </td>
        </tr>

    </table>
    <div style="border: 0 solid;margin-top: 10px;text-align:center;width:200px;">
        <img style="height: 64px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modPendaftaran->pendaftaran_id; ?>&is_text=">  
        <div class="barcode-label"><?php echo $modPendaftaran->pendaftaran_id; ?></div>
    </div>
		</div>		
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
</div>

    