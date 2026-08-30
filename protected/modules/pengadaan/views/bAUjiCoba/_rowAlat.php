<tr>
    <td>
        <?php $i = isset($i)? ($i+1) : 1 ?>
        <?php echo CHtml::textField('no_urut', $i, array('readonly' => true, 'class' => 'span1 integer', 'style' => 'width:20px;')); ?>
    </td>
    <td>
        <?php
        $this->widget('MyDateTimePicker', array(
            'model' => $model,
            'attribute' => '['.$i.']baujifungsidet_tanggal',
            'mode' => 'date',
            'options' => array(
                'dateFormat' => Params::DATE_FORMAT,
                'maxDate' => 'd',
            ),
            'htmlOptions' => array('readonly' => true, 'class' => 'span2 baujifungsidet_tanggal', 'onkeypress' => "return $(this).focusNextInputField(event)",),
        ));
        ?>
    </td>
    <td>
        <?php echo CHtml::activeHiddenField($model, '['.$i.']baujifungsidet_id',array('class'=>'span1'));?>
        <?php echo CHtml::activeHiddenField($model, '['.$i.']baujifungsi_id',array('class'=>'span1'));?>
        <?php echo CHtml::activeHiddenField($model, '['.$i.']barang_id',array('class'=>'span1'));?>
        <?php echo CHtml::activeTextField($model, '['.$i.']nama_barang',array('class'=>'span3 required', 'readonly' => true));?>
    </td>
    <td>
        <?php echo CHtml::activeTextArea($model, '['.$i.']keterangan_uji',array('class'=>'span2', 'readonly' => false));?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, '['.$i.']satuan_barang',array('class'=>'span2 required', 'readonly' => true));?>
    </td>
    <td>
        <?php echo CHtml::activeHiddenField($model, '['.$i.']jenis_barang',array('class'=>'span2', 'readonly' => true));?>
        <?php echo CHtml::activeTextField($model, '['.$i.']jumlah_barang',array('class'=>'span2 required', 'readonly' => true));?>
    </td>
    <td style="text-align: center">
        <?php echo CHtml::activeRadioButton($model, '['.$i.']islengkap', array( 'uncheckValue' => null, 'value' => 1))?>
    </td>
    <td style="text-align: center">
        <?php echo CHtml::activeRadioButton($model, '['.$i.']islengkap', array( 'uncheckValue' => null, 'value' => 0))?>
    </td>
    <td style="text-align: center">
        <?php /*echo CHtml::activeDropDownList($model,'['.$i.']hasil_uji', LookupM::getItems("hasilujicoba"),
            array('onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --', 'class' => 'span3 required'));*/ ?>
        <?php echo CHtml::activeCheckBox($model, '['.$i.']isfungsibaik', array('rel' => 'tooltip', 'title' => 'Klik jika berfungsi baik'))?>
    </td>
    <td style="text-align: center;" class="rowbutton span3 aksi">
        <?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'hapusLookup(this);return false;')); ?>
    </td>
</tr>
