<?php
$mod = BedahanastesilokalPostopT::model()->findByAttributes(array(
    'pasienmasukpenunjang_id'=>$model->pasienmasukpenunjang_id,
));

if (empty($mod)) {
    $mod = new BedahanastesilokalPostopT;
}

//var_dump($mod->attributes); die;
?>
<table class="tab-detail1">
    <tr>
        <td width="150">Tekanan Darah</td>
        <td width="10">:</td>
        <td width="35%"><?php echo empty($mod->td_systolic) ? "-" : $mod->td_systolic ?>/<?php echo empty($mod->td_dyastolic) ? "-" : $mod->td_dyastolic ?> mmHg</td>
        <td width="150">HB</td>
        <td width="10">:</td>
        <td><?php echo empty($mod->hb_nilai) ? "-" : $mod->hb_nilai; ?> mg/dl</td>
    </tr>
    <tr>
        <td width="150">Suhu</td>
        <td width="10">:</td>
        <td width="35%"><?php echo empty($mod->suhubadan) ? "-" : $mod->suhubadan; ?> &deg;C</td>
        <td width="150">RR</td>
        <td width="10">:</td>
        <td><?php echo empty($mod->respirationrate) ? "-" : $mod->respirationrate; ?> x/menit</td>
    </tr>
    <tr>
        <td width="150">HT</td>
        <td width="10">:</td>
        <td width="35%"><?php echo empty($mod->ht_nilai) ? "-" : $mod->ht_nilai; ?></td>
        <td width="150">BB</td>
        <td width="10">:</td>
        <td><?php echo empty($mod->beratbadan) ? "-" : $mod->beratbadan; ?> Kg</td>
    </tr>
</table>

