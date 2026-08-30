<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Pengujian SIMRS
        </div>
    </div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pengujiansimrs-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#dataForm_method',
        )); ?>

        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Method', 'dataForm_method', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::dropDownList('dataForm[method]', $dataForm['method'], array('ajaxpost' => 'Post (Ajax)', 'ajaxget' => 'Get (Ajax)'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",)) ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Interval Refresh', 'dataForm_refreshinterval', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::textField('dataForm[refreshinterval]', $dataForm['refreshinterval'], array('size' => 4, 'maxlength' => 4, 'class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event);",)) ?>
                        <label>detik (1 ~ 9999)</label>
                    </div>
                </div>


            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Pattern', 'dataForm_pattern', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::dropDownList('dataForm[pattern]', $dataForm['pattern'], array('cactiverecord' => 'CActiveRecord', 'dao' => 'Data Access Object (DAO)'), array('class' => 'span3', 'onchange' => 'setTableModel();', 'onkeypress' => "return $(this).focusNextInputField(event);",)) ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Table', 'dataForm_table_uji', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::dropDownList('dataForm[table_uji]', $dataForm['table_uji'], array('infokunjunganrj_v' => 'infokunjunganrj_v', 'tariftindakanperdaruangan_v' => 'tariftindakanperdaruangan_v', 'informasistokobatalkes_v' => 'informasistokobatalkes_v'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",)) ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Model', 'dataForm_model_uji', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::dropDownList('dataForm[model_uji]', $dataForm['model_uji'], array('InfokunjunganrjV' => 'InfokunjunganrjV', 'TariftindakanperdaruanganV' => 'TariftindakanperdaruanganV', 'InformasistokobatalkesV' => 'InformasistokobatalkesV'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",)) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div style="text-align: center;">
                <label>
                    Tips: Tekan tombol Ctrl + Shift + Q untuk menampilkan tab monitoring Firefox.
              </label>
            </div>
            <div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Mulai', array('{icon}' => '<i class="entypo-play"></i>')), array('id' => 'btn_mulai', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'mulaiPengujian();')); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Berhenti', array('{icon}' => '<i class="entypo-stop"></i>')), array('id' => 'btn_berhenti', 'class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'hentikanPengujian();')); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>

                <?php //$this->widget('UserTips',array('type'=>'create'));
                ?>
            </div>
            <div id="load_data" style="height:65px;" hidden>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php $this->renderPartial('_jsFunctions', array('dataForm' => $dataForm)); ?>