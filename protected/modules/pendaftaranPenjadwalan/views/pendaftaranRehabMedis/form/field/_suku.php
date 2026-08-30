
 <div class="control-group ">
    <?php echo $form->labelEx($model, 'suku_id', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo $form->dropDownList($model, 'suku_id', CHtml::listData(SukuM::model()->findAll('suku_aktif IS TRUE ORDER BY suku_nama'),'suku_id', 'suku_nama'), array('style' => 'width:170px;', 'class' => 'span3 suku_id', 'empty' => '-- Pilih --')); ?>
    </div>
</div>
<?php

$jscript = <<< JS
    //mengubah dropdown menjadi dropdown dengan pencarian
    jQuery($(".suku_id")).multiselect({            
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '180px',
            enableCaseInsensitiveFiltering: true
    }).hide();	
JS;

Yii::app()->clientScript->registerScript('daftar-suku-ready', $jscript, CClientScript::POS_READY);
