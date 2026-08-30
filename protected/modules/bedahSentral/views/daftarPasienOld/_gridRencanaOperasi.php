<tr id="operasi_<?php echo $rencanaOperasi->rencanaoperasi_id; ?>">
    <td>
        <?php
            $idx = 99;
            echo CHtml::checkBox('BSTindakanPelayananT['.$idx.'][ceklis]',true,
                array(
                    'value'=>$idx,
                    'id'=>'BSTindakanPelayananT_'.$idx.'_ceklis',
                    'class'=>'ceklis'
                )
            );
        ?>
    </td>
    <td>
        <?php   
            $this->widget('MyDateTimePicker',
                array(
                    'name'=>'BSTindakanPelayananT['.$idx.'][mulaioperasi]',
                    'value'=>$rencanaOperasi->mulaioperasi,
                    'mode'=>'datetime',
                    'options'=> array(
                        'dateFormat'=>Params::DATE_FORMAT,
                    ),
                    'htmlOptions'=>array(
                        'readonly'=>true,
                        'class'=>'dtPicker3',
                        'onkeypress'=>"return $(this).focusNextInputField(event)",
                        'style'=>'width:110px;'
                    ),
                )
            );
        ?>
    </td>
    <td>
        <?php   
            $this->widget('MyDateTimePicker',
                array(
                    'name'=>'BSTindakanPelayananT['.$idx.'][selesaioperasi]',
                    'value'=>$rencanaOperasi->selesaioperasi,
                    'mode'=>'datetime',
                    'options'=> array(
                        'dateFormat'=>Params::DATE_FORMAT,
                    ),
                    'htmlOptions'=>array(
                        'readonly'=>true,
                        'class'=>'dtPicker3',
                        'onkeypress'=>"return $(this).focusNextInputField(event)",
                        'style'=>'width:110px;'
                    ),
                )
            ); 
        ?>
    </td>
    <td style="display:none;">
        <?php
            echo CHtml::dropDownList('BSTindakanPelayananT['.$idx.'][golonganoperasi_id]', $rencanaOperasi->golonganoperasi_id,
                CHtml::listData(GolonganoperasiM::model()->getAll(), 'golonganoperasi_id', 'golonganoperasi_nama'),
                array(
                    'class'=>'inputFormTabel span2',
                    'empty'=>'-- Pilih --'
                )
            );
        ?>
    </td>
    <td>
        <?php
            echo $data['nama_operasi'];
            echo CHtml::hiddenField("BSTindakanPelayananT[".$idx."][daftartindakan_nama]",
                $data['nama_operasi'],
                array(
                    'class'=>'inputFormTabel',
                    'readonly'=>true
                )
            );            
            echo CHtml::hiddenField("BSTindakanPelayananT[".$idx."][daftartindakan_id]",
                $tindakanPelayananT->daftartindakan_id,
                array(
                    'class'=>'inputFormTabel',
                    'readonly'=>true
                )
            );
            echo CHtml::hiddenField("BSTindakanPelayananT[".$idx."][rencanaoperasi_id]",
                $rencanaOperasi->rencanaoperasi_id,
                array(
                    'class'=>'inputFormTabel span2',
                    'readonly'=>true
                )
            );
//            is_operasi TIDAK DIGUNAKAN DI CONTROLLER
//            echo CHtml::hiddenField('BSTindakanPelayananT['.$idx.'][is_operasi]',
//                $data['is_operasi'],
//                array(
//                    'class'=>'inputFormTabel span2',
//                    'readonly'=>true
//                )
//            );
            echo CHtml::hiddenField('BSTindakanPelayananT['.$idx.'][is_operasibersama]',
                ($rencanaOperasi->is_operasibersama) ? 1:0,
                array(
                    'class'=>'inputFormTabel span2',
                    'readonly'=>true
                )
            );
            echo CHtml::hiddenField('BSTindakanPelayananT['.$idx.'][operasi_id]',
                $rencanaOperasi->operasi_id,
                array(
                    'class'=>'inputFormTabel span2',
                    'readonly'=>true
                )                                        
            );
            echo CHtml::hiddenField('BSTindakanPelayananT['.$idx.'][tindakanpelayanan_id]',
                $rencanaOperasi->tindakanpelayanan_id,
                array(
                    'class'=>'inputFormTabel span2',
                    'readonly'=>true
                )                                        
            );
        ?>
    </td>
	<td>
		<?php
			echo CHtml::textField("BSTindakanPelayananT[".$idx."][qty_tindakan]",
				$tindakanPelayananT->qty_tindakan,
				array(
					'class'=>'inputFormTabel span2 integer2',
                    'onblur'=>'hitungTotalRencana();',
				)
			);
		?>
	</td>
    <td>
        <?php
            echo CHtml::textField("BSTindakanPelayananT[".$idx."][tarif_tindakan]",
                number_format($tindakanPelayananT->tarif_tindakan),
                array(
                    'class'=>'inputFormTabel span2 integer2',
                    'readonly'=>true
                )
            );
            echo CHtml::hiddenField("BSTindakanPelayananT[".$idx."][tarif_satuan]",
                number_format($tindakanPelayananT->tarif_satuan),
                array(
                    'class'=>'inputFormTabel span2 integer2',
                    'readonly'=>true
                )
            );
//            TARIF CYTO DINONAKTIFKAN KARENA DIBUAT TINDAKAN YANG BERBEDA
//            echo CHtml::hiddenField("BSTindakanPelayananT[".$idx."][tarifcyto_tindakan]", 
////                $tindakanPelayananT->tarifcyto_tindakan,
//                0,
//                array(
//                    'class'=>'inputFormTabel span2 integer2'
//                )
//            );
        ?>
    </td>
    <td>
        <?php 
        echo CHtml::hiddenField('BSTindakanPelayananT['.$idx.'][typeanastesi_id_sebelum]', (isset($rencanaOperasi->pasienanastesi_id)) ? $rencanaOperasi->pasienanastesi->typeanastesi_id : null, array('readonly'=>true)); 
        echo CHtml::dropDownList('BSTindakanPelayananT['.$idx.'][typeanastesi_id]', null, //nilai di load dengan javascript
    //                                TypeAnastesiM::getItems(), //DISET NULL KARENA HARUS PILIH JENIS & ANASTESI DULU
                array(),
                array('disabled'=>false,'class'=>'inputFormTabel labar3 typeanastesi','style'=>'width:150px;','empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",));
        ?>
    </td>
    <td>
        <?php
            echo CHtml::dropDownList('BSTindakanPelayananT['.$idx.'][cyto_tindakan]', 0,
                array(
                    1=>'Ya',
                    0=>'Tidak'
                ),
                array(
                    'class'=>'inputFormTabel span2',
                    'onchange'=>'hitungCyto('.$idx.',this.value)'
                )
            );
        ?>
        <?php
            echo CHtml::hiddenField("BSTindakanPelayananT[".$idx."][persencyto_tind]", 0,
                array(
                    'class'=>'inputFormTabel span2 integer2',
                    'readonly'=>true
                )
            );
        ?>
    </td>
    <td>
        <?php
            echo CHtml::textField("BSTindakanPelayananT[".$idx."][tarif_cyto]", 0,
                array(
                    'class'=>'inputFormTabel span2 integer2'
                )
            );
        ?>
    </td>
	<td>
		<?php
			echo CHtml::textField("BSTindakanPelayananT[".$idx."][tarif_tindakan]", 0,
				array(
					'class'=>'inputFormTabel span2 integer2',
                    'readonly'=>true
                )
			);
		?>
	</td>
    <td>
        <?php
            echo CHtml::dropDownList('BSTindakanPelayananT['.$idx.'][statusoperasi]',$rencanaOperasi->statusoperasi,
                LookupM::getItems('statusoperasi'),  
                array(
                    'class'=>'inputFormTabel lebar4',
                    'empty'=>'-- Pilih --',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",
					'disabled'=>true
                )
            );
        ?>
    </td>
    <td style="display: none;">
        <?php
            echo CHtml::dropDownList('BSTindakanPelayananT['.$idx.'][jenisPenyulit]', '',
                LookupM::getItems('jenis_penyulit'),
                array(
                    'class'=>'inputFormTabel span2',
                    'empty'=>'-- Pilih --',
                    'onkeypress'=>"return $(this).focusNextInputField(event)"
                )
            );
        ?>
    </td>    
    <td style="text-align:center;">
        <?php
            echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'hapusRowTindakan(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menghapus item')); 
        ?>
    </td>
</tr>