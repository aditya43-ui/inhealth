<style>
    @media print {
        html, body {
            font-family: "Arial" !important;
            font-size: 12pt !important;
            /* font-weight: bold; */
            width: 210mm;
            height: 280mm;
            print-color-adjust: exact;

        }
        
      
        .norm {
            margin-left: 45mm;
            /* border: 1px solid red; */

        }
        .ruangan {
            margin-left: 60mm;
            width: max-content;
            /* border: 1px solid red; */

        }
        .kelas {
            margin-left: 30mm;
            text-align: right;
            float: right;
            /* border: 1px solid red; */

        }
        .norekammedik {
            /* border: 1px solid black; */
            margin-top: 10mm;
            width: 100%;
        }
        table tr td {
            /* border: 1px solid black; */
        }
        table .kosong td {
            padding-top: 6mm;
       
        }
        table .kosong-1 td {
            padding-top: 5mm;
       
        }
       
        table .kosong2 td {
            padding-top: 6mm;
       
        }
        table .kosong1 td {
            padding-top: 12mm;
       
        }
        table .penanggung td {
            /* padding-top:5mm; */
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

    table tr, table td {
        /* border: 1px solid black; */
    }
</style>
<!-- 
<div class="norekammedik">
    <span class="norm">
        
    </span>
    <span class="ruangan">
        
    </span>
    <span class="kelas">
    
    </span>
</div> -->

<table width='100%' style="margin-left: 15mm; margin-top:30mm">
    <tr>
        <td colspan="2">
            <div style="padding-left:15mm">
                <b><?= $modPasien->no_rekam_medik ?><b>
            </div>
        </td>
        <td colspan="2" width="30%;"><?= $modAdmisi->ruangan->ruangan_nama ?></td>
        <td align="center"><?= $modAdmisi->kelaspelayanan->kelaspelayanan_nama ?></td>
    </tr>
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
        <td width="20%;">
            <br>
            <span><?= $modPendaftaran->umur ?> / </span><br>
            <span><?= $modPasien->tanggal_lahir ?></span>
        </td>
        <td><?= $modPasien->agama ?></td>
    </tr>
    <tr class="kosong2">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr class="nama">
        <td width="26%"><?= $modPasien->suku->suku_nama ?? '' ?></td>
        <td><?= $modPasien->warga_negara ?></td>
        <td><?= $modPasien->statusperkawinan ?></td>
        <td colspan="2" style="text-align: right; padding-right: 50px;"><?= $modAdmisi->penjamin->penjamin_nama ?></td>
    </tr>
    <tr class="kosong-1">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="4">
            <div style="padding-left: 26mm;">
                <?= $modPasien->no_identitas_pasien ?> <br>
                <?= substr($modPasien->alamat_pasien,0,35) ?>
            </div>
        </td>
        <td></td>
    </tr>
    <tr class="kosong2">
    <td colspan="4">
            <div style="padding-left: 26mm;">
                <?= $modPasien->kelurahan->kelurahan_nama ?> <br>
                <?= $modPasien->kecamatan->kecamatan_nama ?> <br>
                <?= $modPasien->kabupaten->kabupaten_nama ?>
            </div>
        </td>
        <td valign="top"><?= $modPasien->pendidikan->pendidikan_nama ?? '' ?></td>
    </tr>
    <tr class="kosong2">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="4">
         
        </td>
        <td valign="top"></td>
    </tr>
    <tr class="penanggung">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?= $modPasien->pekerjaan->pekerjaan_nama ?></td>
    </tr>
    <tr>
        <td colspan="4">
            <div style="padding-left: 26mm; height: 25mm; padding-top:5mm">
                <?= $modPendaftaran->penanggungjawab->nama_pj ?? '' ?> <br>
                <?= $modPendaftaran->penanggungjawab->alamat_pj ?? '' ?> <br><br>
                <?= $modPendaftaran->penanggungjawab->no_teleponpj ?? '' ?>
            </div>
        </td>
        <td valign="top"></td>
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
