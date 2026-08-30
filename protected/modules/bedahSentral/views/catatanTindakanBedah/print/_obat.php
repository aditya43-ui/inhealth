<?php

$mod = BedahanastesilokalIntraopT::model()->findAllByAttributes(array(
    'pasienmasukpenunjang_id'=>$model->pasienmasukpenunjang_id
));

$mod_arr = array();

foreach ($mod as $item) {
    $mod_arr_p = BedahanastesilokalMedikasiintraopT::model()->findAllByAttributes(array(
        'bedahanastesilokal_intraop_id'=>$item->bedahanastesilokal_intraop_id,
    ));
    
    $mod_arr = array_merge($mod_arr, $mod_arr_p);
    
}
?>

<table class="tab-detail2">
    <thead>
        <tr>
            <th>Nama Obat</th>
            <th>Dosis</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($mod_arr as $item): ?>
        <tr>
            <td><?php echo empty($item->obatalkes) ? "-" : $item->obatalkes->obatalkes_nama; ?></td>
            <td><?php echo $item->obatalkes_dosis; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>