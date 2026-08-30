    <?php 
        if(count((array)$model) > 0){
        foreach ($model as $i => $konsul) { ?>
        <tr>
			<th><?php echo CHtml::checkBox("PITindakanPelayananT[$i][cbTindakan]", false, array('class'=>'ceklis')) ?></th>
            <td><?php echo $ruangan_nama ?></td>
            <td><?php echo $konsul->daftartindakan->daftartindakan_nama ?>
			<?php echo CHtml::hiddenField("PITindakanPelayananT[$i][daftartindakan_id]", $konsul->daftartindakan_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
			<?php echo CHtml::hiddenField("PITindakanPelayananT[$i][harga_tariftindakan]", $konsul->harga_tariftindakan,array('class'=>'inputFormTabel','readonly'=>true)); ?>
			</td>
            <td><?php echo number_format($konsul->harga_tariftindakan) ?></td>
        </tr>
    <?php } ?>
    <?php }else{ ?>
        <tr>
            <td colspan="3">Data tidak ditemukan.</td>
        </tr>
    <?php } ?>

		