<tr>
    <td>1</td>
    <td>
        <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tglmorbiditas',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array('readonly' => true,
                    'class' => 'span3 required tanggal-diagnosis',
                    'onkeypress' => "return $(this).focusNextInputField(event)"),
            ));
        ?>
    </td>
    <td>
        <?= CHtml::activeDropDownList($model, 'kelompokdiagnosa_id', CHtml::listData(KelompokdiagnosaM::model()->findAll(), 'kelompokdiagnosa_id', 'kelompokdiagnosa_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3 required')) ?>
    </td>
    <td>
        <?= CHtml::activeDropDownList($model, 'kasusdiagnosa', CHtml::listData(LookupM::model()->findAll("lookup_type = 'kasusdiagnosa'"), 'lookup_name', 'lookup_name'), array('empty'=>'-- Pilih --', 'class'=>'span3 required')) ?>
    </td>
    <td>
        <?= CHtml::activeTextField($model, 'diagnosa_kode', array('class'=>'span3', 'disabled'=>true)) ?>
    </td>
    <td>
        <?= CHtml::activeTextField($model, 'diagnosa_nama1', array('class'=>'span3', 'disabled'=>true)) ?>
    </td>
</tr>