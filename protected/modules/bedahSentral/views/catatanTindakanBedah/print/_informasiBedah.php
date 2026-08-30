<?php

$mod = BedahanastesilokalpasienT::model()->findByAttributes(array(
    'pasienmasukpenunjang_id'=>$model->pasienmasukpenunjang_id,
));

$postop = BedahanastesilokalPostopT::model()->findByAttributes(array(
    'pasienmasukpenunjang_id'=>$model->pasienmasukpenunjang_id,
));

$signout = OperasisignoutT::model()->findByAttributes(array(
    'pasienmasukpenunjang_id'=>$model->pasienmasukpenunjang_id,
));

    
    
$posisi = "-";
if (!empty($mod)) {
    if ($mod->posisipasien != "Lainnya") {
        $posisi = $mod->posisipasien;
    } else {
        $posisi = $mod->posisipasien_lainnya;
    }
}

?>

<table class="tab-detail1">
    <tr>
        <td width="150">Operasi yang dilakukan</td>
        <td width="10">:</td>
        <td width="35%"><?php 
        
        if (empty($rencana)) {
            echo "-";
        } else {
            echo (empty($rencana->operasi->kegiatanoperasi->kegiatanoperasi_nama) ? "-" : $rencana->operasi->kegiatanoperasi->kegiatanoperasi_nama)." - ";
            echo (empty($rencana->operasi->daftartindakan) ? "-" : $rencana->operasi->daftartindakan->daftartindakan_nama)." - ";
        }
        
        ?></td>
        <td width="150">Diagnosa Pra operasi</td>
        <td width="10">:</td>
        <td><?php echo empty($diagnosa) ? "-" : ($diagnosa->diagnosa->diagnosa_kode." - ".$diagnosa->diagnosa->diagnosa_nama) ?></td>
    </tr>
    <tr>
        <td width="150">Sifat Tindakan</td>
        <td width="10">:</td>
        <td width="35%"><?php echo empty($rencana) ? "-" : ($rencana->is_cyto ? "CYTO" : "ELEKTIF"); ?></td>
        <td width="150">Diagnosa Post Operasi</td>
        <td width="10">:</td>
        <td><?php echo empty($signout) ? "-" : $signout->signout_diagnosapostop; ?></td>
    </tr>
    <tr>
        <td width="150">Alergi</td>
        <td width="10">:</td>
        <td width="35%"><?php echo empty($anamnesa) ? "-" : $anamnesa->riwayatalergiobat; ?></td>
        <td width="150">Pendarahan</td>
        <td width="10">:</td>
        <td><?php echo empty($postop) ? "-" : $postop->perdarahan_jml; ?> cc</td>
    </tr>
    <tr>
        <td width="150">Posisi Pasien</td>
        <td width="10">:</td>
        <td width="35%"><?php echo $posisi; ?></td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td width="150">Rencana Operasi</td>
        <td width="10">:</td>
        <td width="35%"><?php echo empty($mod->rencanaoperasipasien) ? "-" : $mod->rencanaoperasipasien; ?></td>
        <td colspan="2"></td>
    </tr>
</table>
