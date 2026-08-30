<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjkasuspenyakitdiagnosa-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#diagnosa',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Nama Obat dan Alkes <span class="required">*</span>', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'obatalkes_id', array('class' => 'span3', 'maxlength' => 50)); ?>
                <?php $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'obatalkes',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . Yii::app()->createUrl('ActionAutoComplete/ObatAlkes') . '",
                            dataType: "json",
                            data: {
                                term: request.term,
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val(ui.item.label);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            $(\'#FAFormulariumobatM_obatalkes_id\').val(ui.item.value);
                            $(\'#FAFormulariumobatM_obatalkes\').val(ui.item.label);
                            submitDiagnosaobat();
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'readonly' => false,
                        'placeholder' => 'Obat Alkes',
                        'size' => 13,
                        'class' => 'span3',
                        'onkeypress' => "return $(this).focusNextInputField(event);",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogObatalkesUpdate'),
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Jenis Formularium <span class='required'>*</span>", '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jenisformularium', LookupM::getItems('jenisformularium'), array('empty' => '-- Pilih --', 'class' => 'required')); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="controls">
                <?php  echo Chtml::activeCheckBox($model, 'is_aktif', array('uncheckValue' => null)) ?> <label>Aktif</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php
            $carabayar = CarabayarM::model()->findAll(array(
                'condition' => 'carabayar_aktif = true',
                'order' => 'carabayar_nama ASC',
            ));
            foreach ($carabayar as $idx => $item) {
                $penjamins = PenjaminpasienM::model()->findByAttributes(
                    array(
                        'carabayar_id' => $item->carabayar_id,
                        'penjamin_aktif' => true,
                    ),
                    array('order' => 'penjamin_nama ASC')
                );
                if (empty($penjamins)) unset($carabayar[$idx]);
            }
            $penjamin = PenjaminpasienM::model()->findAll(array(
                'condition' => 'penjamin_aktif = true',
                'order' => 'penjamin_nama',
            ));
            echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                'empty' => '-- Pilih --',
                'class' => 'span3',
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                    'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data); }',
                ),
            ));
            echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span3'));
            ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'onKeypress' => 'return formSubmit(this,event)')
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/FormulariumobatM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Master Master Formularium Obat', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('FormulariumobatM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    );
    ?>
    <?php
    $content = $this->renderPartial($this->path_tips . 'tipsaddedit3', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunction', array('model' => $model)); ?>
<?php $this->renderPartial($this->path_view . '_dialog', array('model' => $model)); ?>