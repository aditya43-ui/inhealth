<table id="tblDaftarAnamnesa" width="100%" class="table table-bordered table-condensed" border="2">
        <tr>
            <td colspan="2"><b>Pulmo</b></td>
        </tr>
        <tr>
            <td width="30%">Inspeksi</td>
            <td><?php echo !empty($modPemeriksaanFisik->pulmo_inspeksi) ? $modPemeriksaanFisik->pulmo_inspeksi : "-"; ?></td>
        </tr>
        <tr>
            <td>Palpasi</td>
            <td><?php echo !empty($modPemeriksaanFisik->pulmo_palpasi) ? $modPemeriksaanFisik->pulmo_palpasi : "-"; ?></td>
        </tr>
        <tr>
            <td>Perkusi</td>
            <td><?php echo !empty($modPemeriksaanFisik->pulmo_perkusi) ? $modPemeriksaanFisik->pulmo_perkusi : "-"; ?></td>
        </tr>
        <tr>
            <td>Auskultasi</td>
            <td><?php echo !empty($modPemeriksaanFisik->pulmo_auskultasi) ? $modPemeriksaanFisik->pulmo_auskultasi : "-"; ?></td>
        </tr>
</table>
