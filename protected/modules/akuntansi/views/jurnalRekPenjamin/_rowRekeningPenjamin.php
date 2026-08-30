<tr>
    <td>
        <?php
		echo CHtml::hiddenField('detail[penjaminrek_id][]', $item->penjaminrek_id,array('class' => 'penjaminrek_id'));
        echo CHtml::hiddenField('detail[rekening5_id][]', $r->rekening5_id);
        echo CHtml::hiddenField('detail[debitkredit][]', $dk);
        ?>
        <?php echo $r->kdrekening5." - ".$r->nmrekening5; ?>
    </td>	
	<td>
		<?php 			
			$status = true;		
			
			if (!empty($item->penjaminrek_id)){
				if ($item->ispembayaran == true){
					$status = true;
				}elseif ($item->ispembayaran == false){
					$status = false;
				}
			}
			
			echo CHtml::checkBox('detail[is_pilihan]['.$r->rekening5_id.$dk.']',$status,array()).'<label>Pembayaran</label>';
			
		?>
	</td>
    <td><a onclick="batalRekening(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan rekening jenis pegeluaran ini"><i class="icon-form-silang"></i></a></td>
</tr>