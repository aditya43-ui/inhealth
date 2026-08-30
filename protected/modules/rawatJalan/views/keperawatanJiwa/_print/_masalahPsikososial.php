<table class='form_predispo' style="width: 100%">
    <?php 
    $cnt = 1;
    foreach (PengkajiankeperawatanjiwaT::psikososialLabel() as $idx => $item) : ?>
    <tr>
        <td width="10"><?php echo $cnt++; ?></td>
        <td>
            <?php echo $item; ?><br>
            <?php echo $model->masalahpsikososial[$idx]; ?>
        </td>
    </tr>
    <?php endforeach; ?>
    <tr>
        <td width="10"></td>
        <td>
            <b>Masalah Keperawatan</b><br>
            <?php echo $model->masalahpsikososial_masalahkeperawatan; ?>
        </td>
    </tr>
</table>