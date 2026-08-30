<style>
    table tr td {
            /* border: 1px solid black; */
        } 
    @media print {
        html, body {
            font-family: "Courier New", monospace !important;
            font-size: 11pt !important;
            /* font-weight: bold; */
            width: 210mm;

        }
        
      
        .norekammedik {
            margin-left: 156mm;
            /* border: 1px solid black; */
            margin-top: 27mm;
        }
        table tr td {
            /* border: 1px solid black; */
        }
        table .kosong td {
            padding-top: 2mm;
       
        }
        table .kosong-1 td {
            padding-top: 7mm;
       
        }
       
        table .kosong2 td {
            padding-top: 6mm;
       
        }
        table .kosong1 td {
            padding-top: 21mm;
       
        }
        table .penanggung td {
            padding-top:15mm;
        }
        table .nama td{
            /* border: 1px solid black; */
            /* padding-top: 5mm; */
            /* padding-bottom: 5mm; */
            padding-left: 5mm;
        }
        table .nama-ayah td{
            padding: 4mm;
        }
       
    }

</style>

<div class="norekammedik">
    <?php echo $modPasien->no_rekam_medik ?>
</div>

<table width='100%' style="margin-left: 0.5mm; margin-top:17mm">
    <tr class="kosong">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr class="nama">
        <td colspan="2" width="45%">
            <?= $modPasien->nama_pasien ?>
        </td>
        <td><?= $modPasien->jeniskelamin ?></td>
        <td width="15%">
            <span><?= $modPendaftaran->umur ?> / </span><br>
            <span><?= $modPasien->tanggal_lahir ?></span>
        </td>
        <td><?= $modPasien->agama ?></td>
    </tr>
    <tr class="kosong-1">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr class="nama">
        <td><?= $modPasien->suku->suku_nama ?? '' ?></td>
        <td ><?= $modPasien->warga_negara ?></td>
        <td ><?= $modPasien->statusperkawinan ?></td>
        <td colspan="2"> 
            <span style="padding-left:100px">
                <?= $modPendaftaran->penjamin->penjamin_nama ?>
            </span>
        </td>
    </tr>
  
    <tr class="kosong1">
        <td colspan="4"></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="4">
            <div style="padding-left: 41mm;">
                <?= $modPasien->no_identitas_pasien ?> <br>
                <?= $modPasien->alamat_pasien ?>
            </div>
        </td>
        <td></td>
    </tr>
    <tr class="kosong2">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="4">
            <div style="padding-left: 41mm;">
                <?= $modPasien->kelurahan->kelurahan_nama ?> <br>
                <?= $modPasien->kecamatan->kecamatan_nama ?> <br>
                <?= $modPasien->kabupaten->kabupaten_nama ?>
            </div>
        </td>
        <td><?= $modPasien->pendidikan->pendidikan_nama ?></td>
    </tr>
    <tr class="penanggung">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?= $modPasien->pekerjaan->pekerjaan_nama ?></td>
    </tr>
    <tr>
        <td><div style="height: 12mm;"></div>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <div style="padding-left: 41mm; height: 35mm;">
                <?= $modPendaftaran->penanggungjawab->nama_pj ?? '' ?> <br>
                <?= $modPendaftaran->penanggungjawab->alamat_pj ?? '' ?> <br><br>
                <?= $modPendaftaran->penanggungjawab->no_teleponpj ?? '' ?>
            </div>
        </td>
        <td></td>
    </tr>
    <tr class="nama-ayah">
        <td></td>
        <td colspan="3"><?= $modPasien->nama_ayah ?? '' ?></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="3"><?= $modPasien->nama_ibu ?? '' ?></td>
        <td></td>
    </tr>
</table>
