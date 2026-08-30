<table class='form_predispo'>
    <tr>
        <td width='10'>1.</td>
        <td width='150'>Tanda Vital</td>
        <td width="10">:</td>
        <td>
            TD: <?php echo $model->fisik_tandavital['td']; ?>,&nbsp;&nbsp;
            N: <?php echo $model->fisik_tandavital['n']; ?>,&nbsp;&nbsp;
            S: <?php echo $model->fisik_tandavital['s']; ?>,&nbsp;&nbsp;
            P: <?php echo $model->fisik_tandavital['p']; ?>
        </td>
    </tr>
    <tr>
        <td>2</td>
        <td>Ukur</td>
        <td>:</td>
        <td>
            TB: <?php echo $model->fisik_tinggibadan; ?>,&nbsp;&nbsp;
            BB: <?php echo $model->fisik_beratbadan; ?>
        </td>
    </tr>
    <tr>
        <td>3</td>
        <td>Keluhan Fisik</td>
        <td>:</td>
        <td><?php echo $model->fisik_keluhan ? "Ya" : "Tidak"; ?></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="3"><b>Jelaskan</b><br>
            <?php echo empty($model->fisik_penjelasan) ? "-" : $model->fisik_penjelasan; ?>
        </td>
        <td>
        </td>
    </tr>
    <tr>
        <td></td>
        <td colspan="3"><b>Masalah Keperawatan</b><br>
            <?php echo empty($model->fisik_masalahkeperawatan) ? "-" : $model->fisik_masalahkeperawatan; ?>
        </td>
        <td>
        </td>
    </tr>
</table>