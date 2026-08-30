<style>
    
    
        .container {
            width: 21.5cm;
            /* border: 1px solid black; */
            margin-top: 0.2cm;
            
        }
        .box {
            /* border: 1px solid red; */
            margin-left: 0cm;
            margin-right: 0.6cm;
            /* margin-top: 0.5cm; */
        }
        table tr td {
            /* border: 1px solid green; */
            font-size: 12pt !important;
            font-family: "Courier New" !important;
            font-weight: bold;
        }
        .jarak td {
            padding: 0.9cm 0px;
        }
        .jarak2 td {
            padding: 0.6cm 0px;
        }
        .jarak3 td {
            padding: 0.3cm 0px;
        }
        .jarak4 td {
            padding: 0.4cm 0px;
        }
        .alamat {
            padding:2px 0px;
        }
</style>

<div class="box">
  <table width="100%">
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>
            <b><?= $modPasien->no_rekam_medik ?></b>
        </td>
    </tr>
    <tr class="jarak">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td width="50%">&nbsp;&nbsp;&nbsp;&nbsp;<?= $modPasien->nama_pasien ?></td>
        <td><?= $modPasien->jeniskelamin ?></td>
        <td width="25%"><?= $modPasien->tanggal_lahir ?></td>
    </tr>
    <tr class="jarak2">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3">
            <div style="padding-left: 4cm;">
                <div class="alamat">
                    <?= $modPasien->no_identitas_pasien ?> <br>
                </div>
                <div class="alamat">
                    <?= $modPasien->alamat_pasien ?> <br>
                </div>
                <div class="alamat">
                    <?= $modPasien->kelurahan->kelurahan_nama ?> <br>
                </div>
                <div class="alamat">
                    <?= $modPasien->kecamatan->kecamatan_nama ?> <br>
                </div>
                <div class="alamat">
                    <?= $modPasien->kabupaten->kabupaten_nama ?>
                </div>
            </div>
        </td>
    </tr>
    <tr class="jarak3">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="">
        <table style="width: 100%;">
                <tr>
                    <td align="center" style="width: 50%;"><?= $modPasien->agama ?></td>
                    <td align="center"><?= $modPasien->suku->suku_nama ?? '' ?></td>
                </tr>
            </table>
        </td>
        <td align="center"><span style="text-align: center;"><?= $modPasien->warga_negara ?></span></td>
        <td>&nbsp;</td>
    </tr>
    <tr class="jarak4">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="">
        <table style="width: 100%;">
                <tr>
                    <td align="center" style="width: 50%;"><?= $modPasien->statusperkawinan ?></td>
                    <td align="center"><?= $modPendaftaran->penjamin->penjamin_nama ?></td>
                </tr>
            </table>
        </td>
        <td align="center"><span style="text-align: center;"><?= $modPasien->pendidikan->pendidikan_nama ?? '' ?></span></td>
        <td align="center"><?= $modPasien->pekerjaan->pekerjaan_nama ?? '' ?></td>
    </tr>
  </table>
</div>
