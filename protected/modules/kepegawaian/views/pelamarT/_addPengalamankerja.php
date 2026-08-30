<?php 
    $i = (isset($i) ? $i : 'ii' );
    $no = '';
?>
    <tr>
    <td>
        <?php echo $form->textField($modPengalamankerja,'['.$i.']pengalamankerja_nourut',array('style'=>'width:20px;','value'=>$no,'readonly'=>true)) ?>
        <?php echo $form->hiddenField($modPengalamankerja,'['.$i.']pengalamankerja_id'); ?>
    </td>
    <td>
        <?php echo $form->textField($modPengalamankerja,'['.$i.']namaperusahaan',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 isDetailReq3')); ?>
    </td>
    <td>
        <?php echo $form->textField($modPengalamankerja,'['.$i.']bidangperusahaan',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 isDetailReq3')); ?>
    </td>
    <td>
        <?php echo $form->textField($modPengalamankerja,'['.$i.']jabatanterahkir',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 isDetailReq3')); ?>
    </td>
    <td class="td_date"><?php $this->widget('MyDateTimePicker',array(
                'model'=>$modPengalamankerja,
                'attribute'=>'[ii]tglmasuk',
                'mode'=>'date',
                'options'=> array(
                    'showOn' => false,
                    'yearRange'=> "-150:+0",
                ),
                'htmlOptions'=>array(
					'placeholder'=>'00/00/0000',
					'class'=>'span2 isDetailReq3',
					'onkeyup'=>"return $(this).focusNextInputField(event)",
					'style' => 'width:130px;'
                ),
        )); ?>
    </td>
    <td class="td_date"><?php $this->widget('MyDateTimePicker',array(
                'model'=>$modPengalamankerja,
                'attribute'=>'[ii]tglkeluar',
                'mode'=>'date',
                'options'=> array(
                    'showOn' => false,
                    'yearRange'=> "-150:+0",
                ),
                'htmlOptions'=>array(
					'placeholder'=>'00/00/0000',
					'class'=>'span2 isDetailReq3',
					'onkeyup'=>"return $(this).focusNextInputField(event)",
					'style' => 'width:130px;'
                ),
        )); ?>
    </td>
    <td>
        <?php echo $form->textField($modPengalamankerja,'['.$i.']lama_tahun',array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:20px')).' thn'; ?>
        <?php echo $form->textField($modPengalamankerja,'['.$i.']lama_bulan',array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:20px')).' bln'; ?>
    </td>
    <td>
        <?php echo $form->textArea($modPengalamankerja,'['.$i.']alasanberhenti',array('onkeypress'=>"(this)",'style'=>'width:50px;')); ?>
    </td>
    <td>
        <?php echo $form->textArea($modPengalamankerja,'['.$i.']keterangan',array('onkeypress'=>"(this)",'style'=>'width:50px;','class'=>'keterangan isDetailReq3')); ?>
    </td>
    <td style="width:50px;">
        <?php echo CHtml::link('<i class="icon-plus">&nbsp;</i>','javascript:void(0)',array('title'=>'Tambah data','rel'=>'tooltip','onclick'=>'tambahPengalamankerja();return false','id'=>'tambah','style'=>'cursor:pointer;')); ?>
        <?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>','javascript:void(0)',array('title'=>'Hapus data','rel'=>'tooltip','id'=>'hapus','onclick'=>'hapusPengalamankerja(this);return false','style'=>'cursor:pointer;')); ?>
    </td>
</tr>