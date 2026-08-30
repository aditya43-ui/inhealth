<?php $form_antrian = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'anantrian-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>
<?php echo $form_antrian->hiddenField($modAntrian, 'antrian_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form_antrian->hiddenField($modAntrian, 'ruangan_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form_antrian->hiddenField($modAntrian, 'carabayar_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form_antrian->hiddenField($modAntrian, 'pendaftaran_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form_antrian->hiddenField($modAntrian, 'profilrs_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form_antrian->hiddenField($modAntrian, 'loket_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form_antrian->hiddenField($modAntrian, 'tglantrian', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form_antrian->hiddenField($modAntrian, 'statuspasien', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<?php echo $form_antrian->hiddenField($modAntrian, 'noantrian', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 6)); ?>
<?php echo $form_antrian->hiddenField($modAntrian, 'carabayar_loket', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<!--<div style="width: 100%; text-align: center; font-size: 30px; font-weight: bold;">-->
<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">No. Antrian</label>
        <div class="controls">
            <?php
                $this->widget('MyJuiAutoComplete', array(                    
                    'name' => 'list_no_antrian',                    
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('AutocompleteNoAntrian') . '",
                            dataType: "json",
                            data: {
                                term: request.term,
                            },
                            success: function (data) {
                            console.log(data);
                                    response(data);
                            }
                        })
                     }',
                    'options' => array(
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val( "");
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            $(this).val( ui.item.value);
                            setAntrianLoket(ui.item);
                            return false;
                        }',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogListAntrian', 'jsFunction'=>'$("#dialogListAntrian").dialog("open");refreshGridNoAntrian();'),
                    'htmlOptions' => array(
                        'placeholder' => 'No. Antrian', 'rel' => 'tooltip', 'title' => 'No. Antrian',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => "",
                        'class' => 'span2 form-control'
                    ),
                ));
            ?>
        </div>
    </div>
    <div style="margin-top: 15px;;box-sizing: border-box; width: 100%; padding: 5px 10px; text-align: center; font-size: 35px; font-weight: bold; line-height: 1.1em;">        
        <?php

        $modelAntrian = ModelantrianM::model()->findByPk($modAntrian->modelantrian_id);
        if($modAntrian->modelantrian_id == 1 ) {
            if ($modAntrian->jenis_kunjungan =='Fast Track'){
            echo CHtml::textField('txt_no_antrian', (empty($modAntrian->ruangan_id) ? "X" : $modAntrian->modelantrian->modelantrian_singkatan) . "-" . (empty($modAntrian->noantrian) ? "0000" : str_pad($modAntrian->noantrian, 3, '0', STR_PAD_LEFT)), array(
                'style'=>'width: 100%; height: 45px; text-align: center; background:red; color: #222;', 'class'=>'all-caps'
            )); 
        } else {
            echo CHtml::textField('txt_no_antrian', (empty($modAntrian->ruangan_id) ? "X" : $modAntrian->modelantrian->modelantrian_singkatan) . "-" . (empty($modAntrian->noantrian) ? "0000" : str_pad($modAntrian->noantrian, 3, '0', STR_PAD_LEFT)), array(
                'style'=>'width: 100%; height: 45px; text-align: center; background:#eee; color: #222;', 'class'=>'all-caps'
            )); 
        }
        } else if ($modAntrian->modelantrian_id == 2 ) {
            if ($modAntrian->jenis_kunjungan =='Fast Track'){
                echo CHtml::textField('txt_no_antrian', (empty($modAntrian->ruangan_id) ? "X" : $modAntrian->ruangan->ruangan_singkatan) . "-" . (empty($modAntrian->noantrian) ? "0000" : str_pad($modAntrian->noantrian, 3, '0', STR_PAD_LEFT)), array(
                    'style'=>'width: 100%; height: 45px; text-align: center; background:red; color: #222;', 'class'=>'all-caps'
                )); 
            } else {
                echo CHtml::textField('txt_no_antrian', (empty($modAntrian->ruangan_id) ? "X" : $modAntrian->ruangan->ruangan_singkatan) . "-" . (empty($modAntrian->noantrian) ? "0000" : str_pad($modAntrian->noantrian, 3, '0', STR_PAD_LEFT)), array(
                    'style'=>'width: 100%; height: 45px; text-align: center; background:#eee; color: #222;', 'class'=>'all-caps'
                )); 
            }
        } else {
            echo CHtml::textField('txt_no_antrian', (empty($modAntrian->ruangan_id) ? "X" : $modAntrian->ruangan->ruangan_singkatan) . "-" . (empty($modAntrian->noantrian) ? "0000" : str_pad($modAntrian->noantrian, 3, '0', STR_PAD_LEFT)), array(
                'style'=>'width: 100%; height: 45px; text-align: center; background: #eee; color: #222;', 'class'=>'all-caps'
            )); 
        }
        
        ?>    
    </div>
</div>

<div class="col-sm-6" style="padding: 10px;" id="listAntrian">
    <div class="control-group">
        <div class="controls">
            <?= CHtml::dropDownList('listAntrianPending', '', [],['onchange'=>'pilihNoAntrian(this)','class'=>'span3','empty'=>'List Antrian Pending']) ?>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <?= CHtml::dropDownList('listAntrianTerlambat', '', [], ['onchange'=>'pilihNoAntrian(this)','empty'=>'List Antrian Terlambat','class'=>'span3',]) ?>
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="col-sm-12" style="text-align:left;">
<!--<div class="control-group">
                <?php // echo CHtml::label('Status Panggilan', 'panggil_flaq',array('class'=>'control-label')); 
                ?>
                <div class="controls">-->
<?php
$statuspanggilan = (isset($modAntrian->antrian_id) ? (($modAntrian->panggil_flaq) ? "SUDAH" : "BELUM") : "");
echo CHtml::hiddenField('statuspanggilan', $statuspanggilan, array('class' => 'span3'));
echo $form_antrian->hiddenField($modAntrian, 'panggil_flaq', array('readonly' => true, 'class' => 'span3'));
?>
</div>
<!--</div>
            </div>-->

<?php $this->endWidget(); ?>