<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bataskarakteristik-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'lookup_type'),
));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>
<?php echo CHtml::hiddenField('norow', 0); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Jenis Tanda dan Gejala', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jenistandagejala_id', JenistandagejalaM::getDropDownJenis(), array('class' => 'span3', 'empty' => '-- Pilih --', 'onchange' => 'refreshTable()')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label('Tanda dan Gejala', 'tandagejala_daftar_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'tandagejala_daftar_id'); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'tandagejala_daftar_nama',
                    'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . $this->createUrl('AutoCompleteTandaGejala') . '",
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
                                        $(this).val( ui.item.value);
                                        return false;
                                    }',
                        'select' => 'js:function( event, ui ) { 
                                        $("#' . CHtml::activeId($model, 'tandagejala_daftar_id') . '").val(ui.item.tandagejala_daftar_id);
                                        return false;
                                    }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Tanda dan Gejala',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogTandaGejala', 'jsFunction' => 'setCeklisGejala();'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", 'jenistandagejaladaftar_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'jenistandagejaladaftar_aktif', array('checked' => 'jenistandagejaladaftar_aktif')); ?> <label>Aktif</label>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid block-tabel">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-credit-card"></i> Tabel <b>Tanda dan Gejala</b>
            </div>
        </div>
        <div class="panel-body table-responsive">
            <table id="table-gejala" class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th style="text-align: center">Tanda dan Gejala <span style="color: red">*</span></th>
                        <th style="text-align: center">Status</th>
                        <th style="text-align: center">Hapus</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
        ); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), "#", array(
        'class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = window.location.href;} ); return false;'
    ));
    ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelompok Tanda dan Gejala', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl($this->id . '/index', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
    <?php $this->widget('UserTips', array('type' => 'create')); ?>
</div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modDet' => $modDet)); ?>
<?php $this->renderPartial($this->path_view . '_dialog', array()); ?>