<tr>
	<td>
		<?php echo CHtml::TextField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); ?>
	</td>
	<td>
		<?php echo CHtml::activeDropDownList($modPiutangAsuransi, '[ii]carabayar_id', CHtml::listData($modPiutangAsuransi->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --', /*'options'=>array("$modPendaftaran->carabayar_id"=>array("selected"=>"selected")),*/ 'onkeypress'=>"return $(this).focusNextInputField(event)",
                'onchange'=>'setDropDownPenjamin(this)',
								'readonly'=>false,
                'class'=>'span3',
            )); ?>
	</td>
	<td>
		<?php echo CHtml::activeDropDownList($modPiutangAsuransi, '[ii]penjamin_id', CHtml::listData($modPiutangAsuransi->getPenjaminItems($modPiutangAsuransi->carabayar_id), 'penjamin_id', 'penjamin_nama') ,
				array('readonly'=>false,
					'empty'=>'-- Pilih --', 
					// 'options'=>array("$modPendaftaran->penjamin_id"=>array("selected"=>"selected")), 
					'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 penjamin_id_multi',
					'onchange'=>'setDropDownPenjaminOnList()',
					)); ?>
	</td>
	<td>
		<?php echo CHtml::activeTextField($modPiutangAsuransi,'[ii]jmlpiutangasuransi',array('readonly'=>false,'class'=>'span2 integer-decimal jmlpiutangasuransi_multi', 'onblur'=>'setProporsionalMultiPenjaminDana();', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		<?php echo CHtml::activeHiddenField($modPiutangAsuransi,'[ii]jmltindakanasuransi',array('readonly'=>true,'class'=>'span2 integer-decimal', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		<?php echo CHtml::activeHiddenField($modPiutangAsuransi,'[ii]jmloaasuransi',array('readonly'=>true,'class'=>'span2 integer-decimal', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	</td>
	<td>
		<?php
			if(isset($firstRow)){
				echo CHtml::link("<i class='icon-plus'></i>", 'javascript:void(0)', array('onclick'=>'addRowPenjamin(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah penjamin'));
			}else{
				echo CHtml::link("<i class='icon-plus'></i>", 'javascript:void(0)', array('onclick'=>'addRowPenjamin(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah penjamin'));
				echo CHtml::link("<i class='icon-minus'></i>", 'javascript:void(0)', array('onclick'=>'batalRowPenjamin(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan penjamin'));
			}
		?>
	</td>
</tr>


