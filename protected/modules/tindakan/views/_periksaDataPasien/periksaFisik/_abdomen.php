<div class="span12" style="border-top: 1px solid black;">
    <table id="tblDaftarAnamnesa" width="100%">
        <tr>
            <td colspan="2"><b>Abdomen</b></td>
        </tr>
        <tr>
            <td width="30%">Inspeksi</td>
            <td><?php echo !empty($modPemeriksaanFisik->abd_inspeksi) ? $modPemeriksaanFisik->abd_inspeksi : "-"; ?></td>
        </tr>
        <tr>
            <td>Palpasi</td>
            <td>
                : <?php echo !empty($modPemeriksaanFisik->abd_palpasi) ? $modPemeriksaanFisik->abd_palpasi : "-"; ?>
                <ul>
                    <li>Leopold I : <?php echo !empty($modPemeriksaanFisik->leopold_1) ? $modPemeriksaanFisik->leopold_1 : "-"; ?></li>
                    <li>Leopold II : <?php echo !empty($modPemeriksaanFisik->leopold_2) ? $modPemeriksaanFisik->leopold_2 : "-"; ?></li>
                    <li>Leopold III : <?php echo !empty($modPemeriksaanFisik->leopold_3) ? $modPemeriksaanFisik->leopold_3 : "-"; ?></li>
                    <li>Leopold IV : <?php echo !empty($modPemeriksaanFisik->leopold_4) ? $modPemeriksaanFisik->leopold_4 : "-"; ?></li>
                </ul>
            </td>
        </tr>
        <tr>
            <td>Perkusi</td>
            <td><?php echo !empty($modPemeriksaanFisik->abd_perkusi) ? $modPemeriksaanFisik->abd_perkusi : "-"; ?></td>
        </tr>
        <tr>
            <td>Auskultasi</td>
            <td><?php echo !empty($modPemeriksaanFisik->abd_auskultasi) ? $modPemeriksaanFisik->abd_auskultasi : "-"; ?></td>
        </tr>
    </table>
</div>
