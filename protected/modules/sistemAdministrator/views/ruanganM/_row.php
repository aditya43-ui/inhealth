<tr data-row="0">
    <td>
        <?php echo CHtml::activeTextField($model,'[1]ruangan_nama',array('class'=>'inputRequire','style'=>'width: 124px;', 'onkeyup'=>"namaLain(this)",'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50,'placeholder'=>$model->getAttributeLabel('ruangan_nama'))); ?>
        <span class="required">*</span>
    </td>
    <td>
        <?php echo CHtml::activeTextField($model,'[1]ruangan_namalainnya',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50, 'placeholder'=> $model->getAttributeLabel('ruangan_namalainnya'))); ?>
    </td>
     <td>
        <?php // echo CHtml::activeTextField($model,'[1]ruangan_lokasi',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50, 'placeholder'=> $model->getAttributeLabel('ruangan_lokasi'))); ?>
        <?php echo Chtml::activeDropDownList($model,'[1]ruangan_lokasi',
              CHtml::listData($model->LokasiItems, 'lookup_value', 'lookup_name'),
              array('onkeypress'=>"return $(this).focusNextInputField(event)",
                    'empty'=>'-- Pilih Lokasi --',
                    'class'=>'span2')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($model,'[1]ruangan_singkatan',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50, 'placeholder'=> $model->getAttributeLabel('ruangan_singkatan'))); ?>
    </td>
                    <td>
        <?php echo CHtml::activeTextField($model,'[1]kode_bpjs',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50, 'placeholder'=> $model->getAttributeLabel('kode_bpjs'))); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($model,'[1]ruangan_jenispelayanan',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50, 'placeholder'=> $model->getAttributeLabel('ruangan_jenispelayanan'))); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($model,'[1]ruangan_fasilitas',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50, 'placeholder'=> $model->getAttributeLabel('ruangan_fasilitas'))); ?>
        <?php echo Chtml::activeFileField($model,'[1]ruangan_image',array('maxlength'=>254,'Hint'=>'Isi Jika Akan Menambahkan Logo','placeholder'=> $model->getAttributeLabel('ruangan_image'))); ?>
    </td>

    <td>
        <?php echo CHtml::button( '+', array('class' => 'btn btn-danger','onkeypress'=>"addRow(this);return $(this).focusNextInputField(event);",'onclick'=>'addRow(this);$(this).nextFocus()','id'=>'row1-plus')); ?>
    </td>
</tr>