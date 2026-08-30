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
        height: 32px;
    }
    .diagnosa td{
        height: 200px;
    }
</style>
<?php echo $this->renderPartial('_headerPrint'); ?>

<table width="100%" border="1">
    <tr>
        <td style="width:20%">SMF</td>
        <td style="width:30%"><?php echo $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama; ?></td>
        <td style="width:20%">NO. RM</td>
        <td style="width:30%"><?php echo $modPasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Nama</td>
        <td style="width:30%"><?php echo $modPasien->nama_pasien; ?></td>
        <td style="width:20%">UMUR</td>
        <td style="width:30%"><?php echo CustomFunction::hitungUmur($modPasien->tanggal_lahir); ?></td>
    </tr>
    <tr>
        <td style="width:20%">Tgl. Diagnosa</td>
        <td style="width:20%"><?php echo isset($modMorbiditas->tglmorbiditas) ? MyFormatter::formatDateTimeId($modMorbiditas->tglmorbiditas) : ""; ?></td>
        <td style="width:20%">Ruangan</td>
        <td style="width:20%"><?php echo $modPendaftaran->ruangan->ruangan_nama; ?></td>
    </tr>
</table>
<table width="100%" class="content" style="border: none;">
    <tr>
        <td align="center" valign="middle" colspan="3" style="font-weight:bold">DIAGNOSA</td>
    </tr>
    <tr>
        <th>Kelompok Diagnosa</th>
        <th>Nama Diagnosa</th>
        <th>Kode</th>
    </tr>
    <tr class="diagnosa">
        <td>Diagnosa Masuk</td>
        <td><ul>
            <?php
                foreach ($listMorbiditas as $i => $data) {
                    if($data->kelompokdiagnosa_id==1){
                        echo "<li>".$data->diagnosa->diagnosa_nama.'</li>';
                    }
                }
            ?>
        </ul></td>
        <td><ul>
            <?php
                foreach ($listMorbiditas as $i => $data) {
                    if($data->kelompokdiagnosa_id==1){
                        echo "<li>".$data->diagnosa->diagnosa_kode.'</li>';
                    }
                }
            ?>
        </ul></td>
    </tr>
    <tr class="diagnosa">
        <td>Diagnosa Utama</td>
        <td><ul>
            <?php
                foreach ($listMorbiditas as $i => $data) {
                    if($data->kelompokdiagnosa_id==2){
                        echo "<li>".$data->diagnosa->diagnosa_nama.'</li>';
                    }
                }
            ?>
        </ul></td>
        <td><ul>
            <?php
                foreach ($listMorbiditas as $i => $data) {
                    if($data->kelompokdiagnosa_id==2){
                        echo "<li>".$data->diagnosa->diagnosa_kode.'</li>';
                    }
                }
            ?>
        </ul></td>
    </tr>
    <tr class="diagnosa">
        <td>Diagnosa Tambahan</td>
        <td><ul>
            <?php
                foreach ($listMorbiditas as $i => $data) {
                    if($data->kelompokdiagnosa_id==3){
                        echo "<li>".$data->diagnosa->diagnosa_nama.'</li>';
                    }
                }
            ?>
        </ul></td>
        <td><ul>
            <?php
                foreach ($listMorbiditas as $i => $data) {
                    if($data->kelompokdiagnosa_id==3){
                        echo "<li>".$data->diagnosa->diagnosa_kode.'</li>';
                    }
                }
            ?>
        </ul></td>
    </tr>
</table>
<table style="width: 100%; border: none;">
    <tr>
        <td colspan="9">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3" align="center" valign="middle">Pasien / Keluarga pasien</td>
        <td colspan="3"></td>
        <td colspan="3" align="center" valign="middle">
			<?php $tglmorbiditas = isset($modMorbiditas->tglmorbiditas) ? MyFormatter::formatDateTimeId($modMorbiditas->tglmorbiditas) : ""; ?>
			<?php echo Yii::app()->user->getState('kabupaten_nama').", ".$tglmorbiditas."<br>Dokter Pemeriksa"; ?>
		</td>
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
        <td colspan="3" align="center" valign="middle"><?php echo (isset($modPendaftaran->pegawai->gelardepan)?$modPendaftaran->pegawai->gelardepan:'').' '.$modPendaftaran->pegawai->nama_pegawai.' '.(isset($modPendaftaran->pegawai->gelarbelakang_nama)?$modPendaftaran->pegawai->gelarbelakang_nama:''); ?></td>
    </tr>

</table>
