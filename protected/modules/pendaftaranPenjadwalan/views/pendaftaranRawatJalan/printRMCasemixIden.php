<style>

    body {
        font-weight: bold;
    }

    .judul {
        text-align: center;

    }

    table.table-2 {
        border: 1px solid black;
    }

    td.table-2 {
        border: 1px solid black;
    }

    th.table-2 {
        border: 1px solid black;
    }

    table.table-2 {
        width: 100%;
        border-collapse: collapse;
    }

    table tr, table td {
         /* border: 1px solid transparent;  */
         line-height: 5mm;
         font-family: "Courier New" !important;
         font-size: 12pt !important;

    }

    .content-bawah {
        font-size: 10px !important;
    }

    .corner-word {
        position: absolute;
        top: 0;
        right: 0;
    }
</style>

<div class="corner-word">
    <h3><?php echo $modDaftar->carabayar->carabayar_namalainnya; ?><div style="width: 3cm;"></div></h3><br>
    <div style="text-align: center; font-size: 12pt;"><?php echo $modDaftar->no_pendaftaran; ?></div>
</div>
<div class="content-rm">
    <div class="judul">
        <h3>&nbsp;</h3>
    </div>
    <div class="form-tabel">
        <table width='100%'>
            <tr>
                <td width='1%'>&nbsp;</td>
                <td width='20%'>&nbsp;</td>
                <td width='2%'>&nbsp;</td>
                <td colspan="7">&nbsp;</td>
            </tr>
            <tr rowspan="3">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td width='20%'>&nbsp;</td>
                <td width='1%'>&nbsp;</td>
                <td width='10%'>&nbsp;</td>
                <td width='1%'>&nbsp;</td>
                <td width='10%'>&nbsp;</td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><?php echo $modPasien->no_rekam_medik ?></td>
            </tr>
            <tr>
                <td>&nbsp; </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="2"><?php echo $modPasien->nama_pasien ?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <?php $ruangan = !empty($modDaftar->pasienadmisi_id) ? $modDaftar->admisi->ruangan->ruangan_nama : $modDaftar->ruangan->ruangan_nama ?>
                <td><?php echo $ruangan ?></td>
            </tr>

            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td> &nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="2">&nbsp;</td>

            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><?php echo !empty($modDaftar->pasienadmisi_id) ? MyFormatter::formatDateTimeForUser(explode(' ', $modDaftar->pasienadmisi->tgladmisi)[0]) : ''; ?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr hidden>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp; </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><?php echo MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir) ?></td>
                <td colspan="3" style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td colspan="2">&nbsp;</td>
                <td colspan="1"></td>
            </tr>

            <tr>
                <td>&nbsp; </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="2"><?php echo $modPasien->jeniskelamin; ?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td></td>
                <td colspan="6"> &nbsp;</td>

            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp; </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td></td>
            </tr>
        </table>
    </div>

</div>