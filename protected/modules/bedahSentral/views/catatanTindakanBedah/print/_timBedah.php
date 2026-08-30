<table class="tab-detail1">
    <tr>
        <td width="150">Operator</td>
        <td width="10">:</td>
        <td width="35%"><?php echo (empty($rencana) || empty($rencana->dokter1)) ? "-" : ($rencana->dokter1->namaLengkap); ?></td>
        <td width="150">Perawat 1</td>
        <td width="10">:</td>
        <td><?php echo (empty($rencana) || empty($rencana->perawatsirkuler)) ? "-" : ($rencana->perawatsirkuler->namaLengkap); ?></td>
    </tr>
    <tr>
        <td>Asisten Operator</td>
        <td>:</td>
        <td><?php echo (empty($rencana) || empty($rencana->dokter2)) ? "-" : ($rencana->dokter2->namaLengkap); ?></td>
        <td>Perawat 2</td>
        <td>:</td>
        <td><?php echo (empty($rencana) || empty($rencana->bidan)) ? "-" : ($rencana->bidan->namaLengkap); ?></td>
    </tr>
</table>
