    <?php 
        if(count((array)$model) > 0){
        foreach ($model as $i => $konsul) { ?>
        <tr>
			<th><?php echo CHtml::checkBox("RITindakanPelayananT[$i][cbTindakan]", false, array('class'=>'ceklis')) ?></th>
            <td><?php echo $ruangan_nama ?></td>
            <td><?php echo $konsul->daftartindakan_nama ?>
			<?php echo CHtml::hiddenField("RITindakanPelayananT[$i][daftartindakan_id]", $konsul->daftartindakan_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
			<?php echo CHtml::hiddenField("RITindakanPelayananT[$i][harga_tariftindakan]", $konsul->harga_tariftindakan,array('class'=>'inputFormTabel','readonly'=>true)); ?>
			</td>
                        <td <?php echo Params::HIDDEN_HARGA ?> style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($konsul->harga_tariftindakan) ?></td>
        </tr>
    <?php } ?>
    <?php }else{ ?>
        <tr>
            <td colspan="3">Data tidak ditemukan.</td>
        </tr>
    <?php } ?>

		