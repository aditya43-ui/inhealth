<table id="table_riwayattindakan" class="table table-condensed table-striped">
	<thead>
        <th>No.</th>
        <th>Ruangan</th>
        <th>Tanggal Rencana Tindakan</th>
        <th width="30%">Rencana Tindakan/<br>Pemeriksa</th>
		<th>Keterangan</th>
        <th>Jumlah</th>
        <th>Satuan</th>
        <th>Jumlah Tarif</th>
    </thead>
    <tbody>
        <?php 
        if(count((array)$modRiwayatTindakans) > 0){
            foreach ($modRiwayatTindakans AS $i => $tindakan){
        ?>
            <tr>
                <td>
                    <?php echo ($i + 1); ?>
                </td>
                <td><?php echo ($tindakan->ruangan->ruangan_nama); ?></td>
                <td><?php echo ($format->formatDateTimeForUser($tindakan->tglrencanatindakan)); ?></td>
                <td>
                    <?php echo ($tindakan->daftartindakan->kategoritindakan_nama)."-".($tindakan->daftartindakan->daftartindakan_nama)." ( Ket: ".$tindakan->keteranganrentinda." )"; ?><br>
                </td>
                <td>
                    <?php echo $tindakan->keteranganrentinda; ?><br>
                </td>
                <td><?php echo CHtml::textField('riwayatTindakan['.$i.'][qty_tindakan]',$tindakan->qty_rentindakan,array('readonly'=>true,'class'=>'integer','style'=>'width:30px;')); ?></td>
                <td><?php echo ($tindakan->satuanrenctinda); ?></td>
                <td><?php echo CHtml::textField('riwayatTindakan['.$i.'][jumlah_tarif]',$format->formatNumberForUser($tindakan->qty_rentindakan*$tindakan->tarifsatuan),array('readonly'=>true,'class'=>'integer','style'=>'width:100px;')); ?></td>
            </tr>
        <?php
            }
        } 
        ?>
    </tbody>
</table>

