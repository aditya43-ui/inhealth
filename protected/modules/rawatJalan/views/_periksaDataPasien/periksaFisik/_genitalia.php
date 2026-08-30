<div class="span12" style="border-top: 1px solid black;">
    <table id="tblDaftarAnamnesa" width="100%">
        <tr>
            <td colspan="2"><b>Genitalia / Dubur</b></td>
        </tr>
        <tr>
            <td width="30%">Inspeksi</td>
            <td><?php echo !empty($modPemeriksaanFisik->genitalia_inspeksi) ? $modPemeriksaanFisik->genitalia_inspeksi : "-"; ?></td>
        </tr>
        <tr>
            <td>Palpasi</td>
            <td><?php echo !empty($modPemeriksaanFisik->genitalia_palpasi) ? $modPemeriksaanFisik->genitalia_palpasi : "-"; ?></td>
        </tr>
    </table>
</div>
