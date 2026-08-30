
    <table id="tblDaftarAnamnesa" width="100%" class="table table-bordered table-condensed" border="2">
        <tr>
            <td colspan="2"><b>Obstetri</b></td>
        </tr>
        <tr>
            <td width="30%">TFU</td>
            <td><?php echo !empty($modPemeriksaanFisik->tinggifundus_uteri) ? $modPemeriksaanFisik->tinggifundus_uteri." cm" : "-"; ?></td>
        </tr>
        <tr>
            <td>HIS</td>
            <td><?php echo !empty($modPemeriksaanFisik->obs_his) ? $modPemeriksaanFisik->obs_his : "-"; ?></td>
        </tr>
        <tr>
            <td>Posisi</td>
            <td><?php echo !empty($modPemeriksaanFisik->leher_posisijanin) ? $modPemeriksaanFisik->leher_posisijanin : "-"; ?></td>
        </tr>
        <tr>
            <td>Denyut</td>
            <td><?php echo !empty($modPemeriksaanFisik->denyutjantung_janin) ? $modPemeriksaanFisik->denyutjantung_janin."/menit" : "-"; ?></td>
        </tr>
        <tr>
            <td>Vagina Toucher</td>
            <td><?php echo !empty($modPemeriksaanFisik->obs_vaginatoucher) ? $modPemeriksaanFisik->obs_vaginatoucher : "-"; ?></td>
        </tr>
    </table>

