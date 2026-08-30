<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjkasuspenyakitdiagnosa-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#diagnosa',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
)); 
// $this->widget('bootstrap.widgets.BootAlert');
?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Nama Obat dan Alkes <span class="required">*</span>', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('obatalkes_id', '', array('readonly' => true)) ?>
                <?php $this->widget('MyJuiAutoComplete', array(
                    'name' => 'obatalkes',
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
                            $(\'#obatalkes_id\').val(ui.item.value);
                            $(\'#obatalkes\').val(ui.item.label);
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
                    'tombolDialog' => array('idDialog' => 'dialogObatalkes'),
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Jenis Formularium <span class='required'>*</span>", '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::dropDownList('jenisformularium','jenisformularium', LookupM::getItems('jenisformularium'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="controls">
                <?php  echo Chtml::checkBox('is_aktif', array('uncheckValue' => null)) ?> <label>Aktif</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="controls">
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
                ?>
                <?php
                echo CHtml::label("Jenis Penjamin <span class='required'>*</span>", '', array('class' => 'control-label'));
                echo CHtml::dropDownList('carabayar_id', 'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                    'empty' => '-- Pilih --',
                    'class' => 'span3',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('getPenjaminPasien', array('encode' => false)),
                        'success' => 'function(data){$("#penjamin_id").html(data); }',
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="controls">
                <?php
                echo CHtml::label("Penjamin <span class='required'>*</span>", '', array('class' => 'control-label'));
                echo CHtml::dropDownList('penjamin_id', 'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span3'));
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="controls">
                <?php echo CHtml::link('<i class="icon-plus icon-white"></i> Tambah', '', array('class' => 'btn btn-primary', 'onclick' => 'submitDiagnosaobat();', 'id' => 'row1-plus', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        
    </div>
</div>

<table id="tabelKasuspenyakitobat" class="table table-responsive table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th>Nama Obat dan Alkes</th>
            <th>Jenis Formularium</th>
            <th>Jenis Penjamin</th>
            <th>Penjamin</th>
            <th>Status</th>
            <th>
                <?php if (isset($_GET['id'])) {
                    $status = 'Hapus';
                } else {
                    $status = 'Batal';
                }
                echo $status ?>
            </th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

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