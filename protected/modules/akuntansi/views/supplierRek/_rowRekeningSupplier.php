<tr>
    <td>
        <?php
		echo CHtml::hiddenField('detail[supplierrek_id][]', $item->supplierrek_id,array('class' => 'supplierrek_id'));
        echo CHtml::hiddenField('detail[rekening5_id][]', $r->rekening5_id);
        echo CHtml::hiddenField('detail[debitkredit][]', $dk);
        ?>
        <?php echo $r->kdrekening5." - ".$r->nmrekening5; ?>
    </td>
	<td>
		<?php 
			$faktur = false;
			$bayarkesupplier = false;
			
			if ($item->isfakturpembelian == true){
				//echo "Faktur Pembelian";
				//echo CHtml::hiddenField('detail[tipe_transaksi][]', 'faktur_pembelian');
				$faktur = true;
				$bayarkesupplier = false;
			}elseif ($item->isbayarkesupplier == true){
				//echo "Bayar Ke Supplier";
				//echo CHtml::hiddenField('detail[tipe_transaksi][]', 'bayar_ke_supplier');				
				$faktur = false;
				$bayarkesupplier = true;
			}
			echo CHtml::radioButton('detail[is_pilihan]['.$r->rekening5_id.$dk.']',$faktur,array('value' => 'is_fakturpembelian')).'<label>Faktur Pembelian</label>';
			echo "<br>";
			echo CHtml::radioButton('detail[is_pilihan]['.$r->rekening5_id.$dk.']',$bayarkesupplier,array('value' => 'is_bayarkesupplier')).'<label>Bayar Ke Supplier</label>';
		?>
	</td>
    <td><a onclick="batalRekening(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan rekening supplier ini"><i class="icon-form-silang"></i></a></td>
</tr>