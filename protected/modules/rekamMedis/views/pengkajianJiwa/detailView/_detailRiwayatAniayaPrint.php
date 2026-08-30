<?php

$ceklis = '<span class="fa fa-check-square-o"></span>';
$unceklis = '<span class="fa fa-square-o"></span>';

?>

<div>
    <?php echo $model->$attribute_aniaya ? $ceklis : $unceklis ?>
    <?php echo $label_aniaya; ?>
    <?php if ($model->$attribute_aniaya): ?>
    <table class="tab_detail tab_aniaya">
        <thead>
            <tr>
                <th>No.</th>
                <th>Sebagai</th>
                <th>Usia</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $aniaya = RiwayataniayaT::model()->findAllByAttributes(array(
                'askepkesehatanjiwa_id'=>$model->askepkesehatanjiwa_id,
                'jenisaniaaya'=>$jenisaniaya,
            ));
            
            foreach ($aniaya as $idx => $item): ?>
            <tr>
                <td><?php echo $idx + 1; ?></td>
                <td><?php echo $item->pasiensebagai; ?></td>
                <td><?php echo $item->usiatext; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>