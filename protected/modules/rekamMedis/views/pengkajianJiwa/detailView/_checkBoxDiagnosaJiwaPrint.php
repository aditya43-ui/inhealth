<?php

$ceklis = '<span class="fa fa-check-square-o"></span>';
$unceklis = '<span class="fa fa-square-o"></span>';

$data_list = CHtml::listData(DiagnosakesehatanjiwaM::model()->findAllByAttributes(array(
    'isaktif'=>true, 'jenisdiagnosa' => $jenisdiagnosa, 'kelompokdiagnosa' => $kelompokdiagnosa,
), array('order'=>'diagnosakesehatanjiwa_id')), 'diagnosakesehatanjiwa_id', 'diagnosakesehatanjiwa_nama');

?>

<tr>
    <td><?php echo $label_diagnosa; ?></td>
    <td>:</td>
    <td>
        <?php foreach ($data_list as $id => $item): ?>
        <div>
            <?php echo (!empty($diagnosa) && is_array($diagnosa) && in_array($id, $diagnosa)) ? $ceklis : $unceklis; ?>
            <?php echo $item; ?>
        </div>
        <?php endforeach; ?>
    </td>
</tr>
