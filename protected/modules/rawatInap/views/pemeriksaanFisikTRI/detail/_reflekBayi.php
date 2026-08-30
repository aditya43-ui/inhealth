<table id="tblDaftarAnamnesa" width="100%" class="table table-bordered table-condensed" border="2">
        <tr>
            <td colspan="2"><b>Reflek Bayi</b></td>
        </tr>
        
        <?php foreach ($modPemeriksaanFisik->reflekbayi as $label => $val): ?>
        <tr>
            <td width="30%"><?php echo $label; ?></td>
            <td><?php echo empty($val) ? "-" : $val; ?></td>
        </tr>
        <?php endforeach; ?>
</table>
