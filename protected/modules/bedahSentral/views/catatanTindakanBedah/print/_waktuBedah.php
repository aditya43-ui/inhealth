<?php

$anlokal = StatusbedahanastesilokalT::model()->findByAttributes(array(
    'pasienmasukpenunjang_id'=>$model->pasienmasukpenunjang_id,
));

if (empty($anlokal)) {
    $anlokal = new StatusbedahanastesilokalT;
}

$lama_tindakan = "-";

if (!empty($anlokal->jam_mulaitindakanbedah) && !empty($anlokal->jam_selesaitindakanbedah)) {
    $selisih = strtotime($anlokal->jam_selesaitindakanbedah) - strtotime($anlokal->jam_mulaitindakanbedah);
    $jam = floor($selisih / 3600);
    $menit = floor($selisih/60) % 60;
    $detik = $selisih % 60;
    
    $lama_tindakan = $jam." jam ".$menit." menit ".$detik." detik";
}

//var_dump($anlokal->attributes); die;

?>

<table class="tab-detail1">
    <tr>
        <td width="150">Tanggal Operasi</td>
        <td width="10">:</td>
        <td width="35%"><?php echo empty($rencana->tglrencanaoperasi) ? "-" : MyFormatter::formatDateTimeForUser($rencana->tglrencanaoperasi);?></td>
        <td width="150">Jam Mulai Tindakan</td>
        <td width="10">:</td>
        <td><?php echo empty($anlokal->jam_mulaitindakanbedah) ? "-" : $anlokal->jam_mulaitindakanbedah; ?></td>
    </tr>
    <tr>
        <td width="150">Jam Mulai Operasi</td>
        <td width="10">:</td>
        <td><?php echo empty($rencana->mulaioperasi) ? "-" : $rencana->mulaioperasi; ?></td>
        <td width="150">Jam Selesai Tindakan</td>
        <td width="10">:</td>
        <td><?php echo empty($anlokal->jam_selesaitindakanbedah) ? "-" : $anlokal->jam_selesaitindakanbedah; ?></td>
    </tr>
    <tr>
        <td width="150">Jam Selesai Operasi</td>
        <td width="10">:</td>
        <td><?php echo empty($rencana->selesaioperasi) ? "-" : $rencana->selesaioperasi; ?></td>
        <td width="150">Lama Tindakan</td>
        <td width="10">:</td>
        <td><?php echo $lama_tindakan; ?></td>
    </tr>
    <tr>
        <td width="150">Jam Mulai Anestesi</td>
        <td width="10">:</td>
        <td width="35%"><?php echo empty($anlokal->jam_mulaianestesi) ? "-" : $anlokal->jam_mulaianestesi; ?></td>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td width="150">Jam Selesai Anestesi</td>
        <td width="10">:</td>
        <td width="35%"><?php echo empty($anlokal->jam_selesaianestesi) ? "-" : $anlokal->jam_selesaianestesi; ?></td>
        <td colspan="3"></td>
    </tr>
</table>