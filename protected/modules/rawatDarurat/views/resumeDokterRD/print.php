<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
        font-size: 8pt !important;
        height: 24px;
        padding-left:10px;
    }
    body{
        width: 21.7cm;
    }
    .content td{
        height: 12px;
    }
    .diagnosa td{
        height: 50px;
    }
</style>
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td width="25%" align="center">
            <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " style="max-width: 80px; width:80px;"/>
        </td>
        <td align="left">
            <div>
                <b><?php echo strtoupper($modProfilRs->namakepemilikanrs); ?></b>
                <!--<b>PEMERINTAH PROPINSI <?php // echo strtoupper($modProfilRs->propinsi->propinsi_nama); ?></b>-->
            </div>
            <div>
                <b><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></b>
            </div>
            <div>
                <?php echo $modProfilRs->alamatlokasi_rumahsakit; ?>. Telp. <?php echo $modProfilRs->no_telp_profilrs; ?> Fax.  / <?php echo $modProfilRs->no_faksimili." - ".$modProfilRs->kabupaten->kabupaten_nama; ?>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="border-bottom: 2px solid #000000">&nbsp;</td>
    </tr>
</table>

<table width="100%" border="1">
    <tr>
        <td style="width:20%">Nama Pasien</td>
        <td style="width:30%"><?php // echo isset($modPendaftaran->jeniskasuspenyakit_id)?$modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama:''; ?></td>
        <td style="width:20%">No MR</td>
        <td style="width:30%"><?php // echo $modPasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td style="width:20%">I/A dari </td>
        <td style="width:30%"><?php // echo $modPasien->nama_pasien; ?></td>
        <td style="width:20%">Dokter Pemgirim</td>
        <td style="width:30%"><?php // echo CustomFunction::hitungUmur($modPasien->tanggal_lahir); ?></td>
    </tr>
    <tr>
        <td style="width:20%">Tanggal Lahir</td>
        <td style="width:20%"></td>
        <td style="width:20%"></td>
        <td style="width:20%"></td>
    </tr>
    <tr>
        <td style="width:20%">Tanggal Masuk RS</td>
        <td style="width:20%"></td>
        <td style="width:20%">Tanggal Keluar RS</td>
        <td style="width:20%"></td>
    </tr>
</table>
<table width="100%" class="content" style="border: none;">
    <tr>
        <td align="center" valign="middle" colspan="3" style="font-weight:bold"></td>
    </tr>
<!--<tr>
        <th>Kelompok Diagnosa</th>
        <th>Nama Diagnosa</th>
        <th>Kode</th>
    </tr>-->
    <tr class="diagnosa">
        <td width="30%">Ikhtisar Klinik Singkat</td>
        <td><ul>- Bla bla bla
            <?php
//                foreach ($listMorbiditas as $i => $data) {
//                    if($data->kelompokdiagnosa_id==1){
//                        echo "<li>".$data->diagnosa->diagnosa_nama.'</li>';
//                    }
//                }
            ?>
        </ul></td>
    </tr>
    <tr class="diagnosa">
        <td>Diagnosa kelainan pada pemeriksaan fisik <i>(Pemeriksaan Fisik / Lab / Radiologi)</i></td>
        <td><ul>- Bla bla bla
            <?php
//                foreach ($listMorbiditas as $i => $data) {
//                    if($data->kelompokdiagnosa_id==2){
//                        echo "<li>".$data->diagnosa->diagnosa_nama.'</li>';
//                    }
//                }
            ?>
        </ul></td>
        
    </tr>
    <tr class="diagnosa">
        <td>Diagnosa Sementara</td>
        <td><ul>- Bla bla bla
        </ul></td>
    </tr>
    <tr class="diagnosa">
        <td>Pengobatan Sementara yang diberikan</td>
        <td><ul>- Bla bla bla
        </ul></td>
    </tr>
    <tr class="diagnosa">
        <td>Diagnosa Akhir</td>
        <td><ul>- Bla bla bla
        </ul></td>
    </tr>
    <tr class="diagnosa">
        <td>Obat yang diberikan saat pulang</td>
        <td><ul>- Bla bla bla
        </ul></td>
    </tr>
    <tr class="diagnosa">
        <td>Saran</td>
        <td><ul>- Bla bla bla
        </ul></td>
    </tr>
</table>
<table style="width: 100%; border: none;">
    <tr>
        <td colspan="9">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3" align="center" valign="middle"></td>
        <td colspan="3"></td>
        <td colspan="3" align="center" valign="middle"><?php // echo Yii::app()->user->getState('kabupaten_nama').", ".MyFormatter::formatDateTimeId(date('Y-m-d',strtotime($modMorbiditas->tglmorbiditas   ))); ?><br></td>
        <td colspan="3" align="center" valign="middle"><?php echo "Bandung, ".MyFormatter::formatDateTimeId(date('Y-m-d',strtotime('1945-08-17'))); ?><br>Dokter yang merawat,</td>
    </tr>
    <tr>
        <td colspan="9">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="9">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="9">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3" align="center" valign="middle"></td>
        <td colspan="3"></td>
        <td colspan="3" align="center" valign="middle"></td>
        <td colspan="3" align="center" valign="middle"><?php echo (isset($modPendaftaran->pegawai->gelardepan)?$modPendaftaran->pegawai->gelardepan:'').' '.$modPendaftaran->pegawai->nama_pegawai.' '.(isset($modPendaftaran->pegawai->gelarbelakang_nama)?$modPendaftaran->pegawai->gelarbelakang_nama:''); ?></td>
    </tr>

</table>
