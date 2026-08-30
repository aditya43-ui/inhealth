<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('class'=>'un-integer','style'=>'width:30px','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField('row',0,array('class'=>'span1','style'=>'width:30px','readonly'=>true)); ?>
    </td>
    <td>
        <?php echo $form->hiddenField($modDiagnosa, '[ii]diagnosa_id', array('readonly'=>true)) ?>
        <?php $this->widget('MyJuiAutoComplete',array(
                    'model'=>$modDiagnosa,
                    'attribute'=>'[ii]diagnosa_kode',
                    'tombolDialog'=>array('idDialog'=>'dialog_diagnosa','jsFunction'=>"setDialogDiagnosa(this);"),
                    'htmlOptions'=>array('placeholder'=>'pilih kode diagnosa','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span2'),
        )); ?>
    </td>
    <td>
        <?php echo $form->textField($modDiagnosa, '[ii]diagnosa_nama',array('class'=>'span4','readonly'=>true)); ?>
    </td>
    <td>
        <?php
            $is_adatombolhapus = (isset($is_adatombolhapus) ? $is_adatombolhapus : false);
            echo CHtml::link('<i class="icon-plus"></i>', 'javascript:void(0);', array('onclick'=>'tambahDiagnosa();return false;','rel'=>'tooltip','title'=>'Klik untuk menambah diagnosa')).
			"<span id='iconresettrpertama'></div>";
            if($is_adatombolhapus){
                echo "&nbsp";
                echo CHtml::link("<i class=\"icon-trash\"></i>", 'javascript:void(0);', array('onclick'=>'batalDiagnosa(this);return false;'));
            }
        ?>
    </td>
</tr>

