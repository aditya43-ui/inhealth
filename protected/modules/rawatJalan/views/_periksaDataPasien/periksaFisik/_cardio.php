<div class="span12" style="border-top: 1px solid black;">
    <table id="tblDaftarAnamnesa" width="100%">
        <tr>
            <td colspan="2"><b>Cardio</b></td>
        </tr>
        <tr>
            <td width="30%">Inspeksi</td>
            <td><?php echo !empty($modPemeriksaanFisik->cardio_inspeksi) ? $modPemeriksaanFisik->cardio_inspeksi : "-"; ?></td>
        </tr>
        <tr>
            <td>Palpasi</td>
            <td><?php echo !empty($modPemeriksaanFisik->cardio_palpasi) ? $modPemeriksaanFisik->cardio_palpasi : "-"; ?></td>
        </tr>
        <tr>
            <td>Perkusi</td>
            <td><?php echo !empty($modPemeriksaanFisik->cardio_perkusi) ? $modPemeriksaanFisik->cardio_perkusi : "-"; ?></td>
        </tr>
        <tr>
            <td>Auskultasi</td>
            <td><?php echo !empty($modPemeriksaanFisik->cardio_auskultasi) ? $modPemeriksaanFisik->cardio_auskultasi : "-"; ?></td>
        </tr>
    </table>
</div>
