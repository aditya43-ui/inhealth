<h3 align="center">PERSIAPAN EKSTUBASI PASIEN <?= Yii::app()->user->getState('ruangan_nama') ?></h3>

<?php
    function ceklis($st){
        $icon = '<span  style="font-family:FontAwesome;margin-left:20px;" >&#xf096;</span>';
        if ($st){
            $icon = '<span  style="font-family:FontAwesome;margin-left:20px;" >&#xf046;</span>';
        }

        return $icon;
    } 
?>

<table class="prinout w100 no-grid">
    <tr>
        <td width="10%">Nama Pasien</td>
        <td width="2%">:</td>
        <td><?= $model->nama_pasien ?></td>
        <td width="10%"></td>
        <td width="10%">DPJP</td>
        <td width="2%">:</td>
        <td><?= $model->dpjp_nama ?></td>
    </tr>
    <tr>
        <td >Diagnosa</td>
        <td >:</td>
        <td><?= $model->diagnosa_nama ?></td>
        <td ></td>
        <td >Dr. Anestesi</td>
        <td >:</td>
        <td><?= $model->dokteranestesi_nama ?></td>
    </tr>
    <tr>
        <td >Tanggal Tindakan</td>
        <td >:</td>
        <td><?= MyFormatter::formatDateTimeForUser($model->tgl_tindakan) ?></td>
        <td ></td>       
    </tr>
</table>

<table class="prinout w100 no-grid">
    <tr>
        <td>Kriteria Pasien untuk dapat di ekstubasi</td>
    </tr>
    <?php
        $kriteria = LookupM::getItemsUrutan('ekstubasi');
    
        foreach($kriteria as $key => $det){
            echo '<tr><td>'.ceklis($model->$key).' '.$det.'</td></tr>';
        }
    ?>   
</table>

<br /><br /><br />

<table class="prinout w100">
    <tr>
        <td colspan="4">
            <b>Ekstubasi dapat dilakukan apabila kriteria diatas telah terpenuhi semua</b>
        </td>
    </tr>
    <tr>
        <td oolspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td width="5%">&nbsp;</td>
        <td style="text-align: center;">Dokter Jaga</td>
        <td style="text-align: center;">Perawat Jaga</td>
        <td width="5%">&nbsp; </td>
    </tr>
    <tr>
        <td oolspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td oolspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td oolspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td style="text-align: center;">(<?= $model->dokterjaga_nama ?>)</td>
        <td style="text-align: center;">(<?= $model->perawatjaga_nama ?>)</td>
        <td>&nbsp; </td>
    </tr>
</table>