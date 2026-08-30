<tr>
    <td class="row_num" style="text-align: right;">
        1
    </td>
    <td>
        <?php
        echo $form->dropDownList($modDetail, "[0]jeniskomponendarah_id", CHtml::listData(JeniskomponendarahM::model()->findAll('jeniskantongdarah_aktif IS TRUE ORDER BY jeniskomponenedarah_nama'), 'jeniskomponendarah_id', 'jeniskantongdarah_singkatan'), array(
            'empty' => '-- Pilih --',
            'readonly' => false,
            'class' => 'span2 required',
            'onblur' => 'return false;',
        ));
        ?>
    </td>
    <td>
        <?php
        
        $dropDarah = LookupM::getItemsUrutan('golongandarah');
        unset($dropDarah['-']);
        
        echo $form->dropDownList($modDetail, "[0]golongandarah", $dropDarah,array(
            'empty' => '-- Pilih --',
            'readonly' => false,
            'class' => 'span2 required',
            'onblur' => 'return false;',
        ));
        ?>
    </td>
    <td>
        <?php
        echo $form->dropDownList($modDetail, "[0]rhesus", LookupM::getItems('rhesus'), array(
            'empty' => '-- Pilih --',
            'readonly' => false,
            'class' => 'span2',
            'onblur' => 'return false;',
        ));
        ?>
    </td>
    <td>
        <?php echo $form->textField($modDetail, '[0]jumlah', array('class' => 'span2 integer required', 'style' => 'text-align: right')); ?>
    </td>
    <!--<td>
        <?php
        /*$this->widget('MyDateTimePicker', array(
            'model' => $modDetail,
            'attribute' => '[0]tgl_perlu',
            'mode' => 'date',
            'options' => array(
                'dateFormat' => Params::DATE_FORMAT,
                'showOn' => false,
            ),
            'htmlOptions' => array('placeholder' => '00/00/0000', 'class' => 'tgl_perlu required', 'readonly' => true, 'style' => 'width:100px;'
            ),
        ));*/
        ?>
    </td>
    <td>
        <?php //echo $form->textField($modDetail, '[0]no_ppup', array('class' => 'span2')); ?>
    </td>-->
    <td>
        <?php echo $form->textArea($modDetail, '[0]keterangan_det', array('class' => 'span2')); ?>
    </td>
    <td style="width: 100px; text-align: center;">
        <?php
        echo CHtml::link('<i class="glyphicon glyphicon-plus"></i>', 'javascript:;', array(
            'onclick' => 'tambahDetail(this); return false;',
        ));
        ?>
        <?php
        if (empty($sendiri) || !$sendiri) {
            echo CHtml::link('<i class="glyphicon glyphicon-minus"></i>', 'javascript:;', array(
                'onclick' => 'hapusDetail(this); return false;',
            ));
        }
        ?>
    </td>
</tr>