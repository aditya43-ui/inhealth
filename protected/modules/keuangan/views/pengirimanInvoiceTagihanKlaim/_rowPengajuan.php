<tr>
    <td>
        <?php echo CHtml::activeCheckBox($modDetail,'[ii]checklist', array('class'=>'checklist',"onclick"=>"setNol(this);")); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]pengajuanklaimpiutang_id',array()); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail,'[ii]penjamin_nama',array('onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true, 'class'=>'span3')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail,'[ii]tglpengajuanklaimanklaim',array('onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true, 'class'=>'span3')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail,'[ii]noinvoice',array('onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true, 'class'=>'span3')); ?>
    </td>
    <td>
        Rp. <?php echo CHtml::activeTextField($modDetail,'[ii]totalbayar',array('onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true, 'class'=>'span2 integer-decimal')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextArea($modDetail,'[ii]kiriminvoice_ket',array('onkeypress'=>"return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
    </td>
    <td>
        <?php echo CHtml::activeDropDownList($modDetail,'[ii]kiriminvoice_nama',LookupM::getItems('jenisekspedisi'),array('onkeypress'=>"return $(this).focusNextInputField(event);",'class'=>'span3','empty'=>'Pilih','required'=>true)); ?>
    </td>
    <td class="td_date">
        <?php $this->widget('MyDateTimePicker',array(
                'model'=>$modDetail,
                'attribute'=>'[ii]kiriminvoice_tgl',
                'mode'=>'datetime',
                'options'=> array(
                    'showOn' => false,
                    'yearRange'=> "-150:+0",
                ),
                'htmlOptions'=>array(
					'class'=>'span3',
					'onkeyup'=>"return $(this).focusNextInputField(event)",
					'style' => 'width:150px;',
                    'required'=>true
                ),
        )); ?>
    </td>
</tr>
