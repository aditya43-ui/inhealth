<?php

$det = $skor;

?>

<table class="table table-bordered table-condensed" id="tab_skor">
    <thead>
        <tr>
            <th>Parameter</th>
            <th>Penilaian</th>
            <th>Skor</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $det->getAttributeLabel('aktivitas_penilaian'); ?></td>
            <td><?php echo $det->aktivitas_penilaian; ?></td>
            <td><?php echo $det->aktivitas_skor; ?></td>
        </tr>
        <tr>
            <td><?php echo $det->getAttributeLabel('sirkulasi_penilaian'); ?></td>
            <td><?php echo $det->sirkulasi_penilaian; ?></td>
            <td><?php echo $det->sirkulasi_skor; ?></td>
        </tr>
        <tr>
            <td><?php echo $det->getAttributeLabel('pernapasan_penilaian'); ?></td>
            <td><?php echo $det->pernapasan_penilaian; ?></td>
            <td><?php echo $det->pernapasan_skor; ?></td>
        </tr>
        <tr>
            <td><?php echo $det->getAttributeLabel('kesadaran_penilaian'); ?></td>
            <td><?php echo $det->kesadaran_penilaian; ?></td>
            <td><?php echo $det->kesadaran_skor; ?></td>
        </tr>
        <tr>
            <td><?php echo $det->getAttributeLabel('warnakulit_penilaian'); ?></td>
            <td><?php echo $det->warnakulit_penilaian; ?></td>
            <td><?php echo $det->warnakulit_skor; ?></td>
        </tr>
        <tr>
            <td colspan="2">Total Skor</td>
            <td><?php echo $model->totalskor_aldrettekeluarrpulih; ?></td>
        </tr>
    </tbody>
</table>