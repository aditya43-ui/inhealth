
<style>
    @media print {
        .pagbr {
            height: 0.25cm;
        }
    }
    
</style>
<table class="status" >

    <?php  
        $value=$modKunjungan; 
          foreach($modSpesimen as $spesimen){ 
    ?>

        <tr>
            <td width="130">No. Registrasi</td>
            <td>:</td>
            <td><strong><?php echo $value->no_pendaftaran ?></strong></td>
        </tr>
        <tr>
            <td>Tanggal Registrasi</td>
            <td>:</td>
            <td><?php echo date('d/m/Y H:i:s', strtotime($value->tgl_pendaftaran)); ?></td>
        </tr>
        <tr>
            <td>Spesimen ID</td>
            <td>:</td>
            <td><?php echo $spesimen->no_spesimen; ?></td>
        </tr>
        <tr>
            <td>No. Rekam Medis</td>
            <td>:</td>
            <td><?php echo $value->no_rekam_medik; ?></td>
        </tr>
        <tr>
            <td>Nama Pasien</td>
            <td>:</td>
            <td><?php echo $value->namadepan . $value->nama_pasien . (!empty($value->nama_bin) ? " (" . $value->nama_bin . ")" : ""); ?></td>
        </tr>

        <tr>
            <td>Tanggal Lahir / Umur</td>
            <td>:</td>
            <td><?php echo date('d/m/Y', strtotime($value->tanggal_lahir)); ?> / <?php
                $umur = CustomFunction::getUmur($value->tanggal_lahir);
                $data = explode(" ", $umur);
                echo $data[0] . " Thn";
                ?></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td><?php echo $value->jeniskelamin; ?></td>
        </tr>
       
        <tr>
            <td>Jenis Penjamin / Penjamin</td>
            <td>:</td>
            <td><?php echo $value->carabayar_nama; ?>/<?php echo $value->penjamin_nama; ?></td>
        </tr>
        <tr>
            <td>Instalasi Asal</td>
            <td>:</td>
            <td><?php echo $value->instalasi_nama; ?></td>
        </tr>
        <tr>
            <td>Ruangan Asal</td>
            <td>:</td>
            <td><?php echo $value->ruangan_nama; ?></td>
        </tr>
        <tr>
            <td>Dokter</td>
            <td>:</td>
            <td>
                <?php 
                    
                    $modPenilaian = MKPenialianKelayakanSpesimenT::model()->findByAttributes(array('pasienkirimkeunitlain_id'=>$value->pasienkirimkeunitlain_id));
                    if(!empty($modPenilaian->penilaian_kelayakan_spesimen_id)){
                        echo !empty($modPenilaian->manajerpelayanan_id)? PegawaiM::model()->findByPk($modPenilaian->dpjtm_id)->namaLengkap : "";
                    }    
                   
                ?>
            </td>
        </tr>
        <tr>
            <td>Diaognosa</td>
            <td>:</td>
            <td>
                <?php
                $modDiagnosa = PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $value->pendaftaran_id, 'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA), array('order' => 'pasienmorbiditas_id'));
                if (!empty($modDiagnosa->diagnosa_id)) {
                    $diagnosa = DiagnosaM::model()->findByPk($modDiagnosa->diagnosa_id);
                    echo $diagnosa->diagnosa_nama;
                } else {
                    echo "-";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td><?php echo $value->alamat_pasien; ?></td>
        </tr>
        <tr>
            <?php
            $modUser = LoginpemakaiK::model()->findByPK(Yii::app()->user->id);
            $cekPegawai = PegawaiM::model()->findByPk($modUser->pegawai_id);
            ?>
            <td>Operator</td>
            <td>:</td>
            <td><?php echo isset($cekPegawai->namaLengkap) ? $cekPegawai->namaLengkap : "-"; ?></td>
        </tr>
        
        <tr>
            <td colspan="3" align="center">
                <br/>
                <div align="center" valign="middle"><strong><u>Daftar Pemeriksaan</u></strong></div>
                <table border="1" style="margin-top: 10px;text-align:center;width:360px;">
                    <thead>
                    <td><strong>No.</strong></td>
                    <td><strong>Kultur</strong></td>
                    <td><strong>Qty</strong></td>
                    </thead>
                    <?php
                    $modtindakan= TindakanpelayananT::model()->findByPk($spesimen->tindakanpelayanan_id);
                    $modPermintaan = PermintaankepenunjangT::model()->findAllByAttributes(array('pasienkirimkeunitlain_id' => $value->pasienkirimkeunitlain_id,'daftartindakan_id'=>$modtindakan->daftartindakan_id));
                    foreach ($modPermintaan as $i => $permintaanpenunjang) {
                        ?>
                        <tr>
                            <td><?php echo ($i + 1) . "."; ?></td>
                            <td><?php echo $permintaanpenunjang->pemeriksaanlab->pemeriksaanlab_nama; ?></td>
                            <td><?php echo $permintaanpenunjang->qtypermintaan ?></td>
                            
                        </tr>
                     <?php } ?>
                    

                </table>
            </td>
        </tr>
        <tr  class="page-break">
            <td></td>
        </tr>
        
        <?php
          }
        
        ?>

</table>



