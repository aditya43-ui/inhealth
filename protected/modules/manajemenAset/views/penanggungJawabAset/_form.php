<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sagolongan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'nama_pegawai'),
        ));
?>
<div class="row-fluid">
    <p class="help-block" style="color:#333;"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'pegawai_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegawai_id',['class'=>'pegawai_id']); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'nama_pegawai',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('/ActionAutoComplete/GetPegawai') . '",
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
                                $(this).val( ui.item.label);
                                return false;
                         }',
                         'select' => 'js:function( event, ui ) { 
                                    $("#' . CHtml::activeId($model, 'pegawai_id') . '").val(ui.item.pegawai_id);
                                    $("#' . CHtml::activeId($model, 'nama_pegawai') . '").val(ui.item.namaLengkap);
                                    return false;
                            }',
                        ),
                        'htmlOptions' => array(
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'placeholder' => "ketik nama pegawai",
                            'class' => 'span3 nama_pegawai',
                            'onblur'=>'if(this.value==""){$("#' . CHtml::activeId($model, 'pegawai_id') . '").val("")}'
                        ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawai'),
                ));
                ?>
            </div>
        </div>
        
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'lokasi_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'lokasi_id',['class'=>'lokasi_id']); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'lokasiaset_namalokasi',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('/ActionAutoComplete/GetLokasiAset') . '",
                            dataType: "json",
                            data: {
                                    term: request.term,
                                    notpj:"ya"
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
                                $(this).val( ui.item.label);
                                return false;
                         }',
                        'select' => 'js:function( event, ui ) {                             
                            
                                if (ui.item.ruangan_nama != "" && ui.item.ruangan_nama != null){
                                    $("#' . CHtml::activeId($model, 'lokasi_id') . '").val(ui.item.lokasi_id);
                                    $("#' . CHtml::activeId($model, 'lokasiaset_namalokasi') . '").val(ui.item.lokasiaset_namalokasi);
                                    $("#' . CHtml::activeId($model, 'ruangan_id') . '").val(ui.item.ruangan_id);
                                    $("#' . CHtml::activeId($model, 'ruangan_nama') . '").val(ui.item.ruangan_nama);
                                }else{
                                    $(this).val( "");
                                    toastr.warning("Ruangan pada master lokasi aset belum diset","Perhatian");
                                }
                                return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => "ketik lokasi aset",
                        'class' => 'span3 lokasiaset_namalokasi',
                        'onblur'=>'if(this.value==""){$("#' . CHtml::activeId($model, 'lokasi_id') . '").val("")}'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogLokasi'),
                ));
                ?>
            </div>
        </div>
    </div>
    <div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'ruangan_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'ruangan_id', array('readonly'=>true,'class' => 'span3 ruangan_id')); ?>
                <?php echo $form->textField($model, 'ruangan_nama', array('readonly'=>true,'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            </div>
        </div>
        <?php
        if (!$model->isNewRecord) {
            ?>
            <div class="control-group">
                <?php echo CHtml::label("", "", array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'penanggungjawabaset_aktif', array()); ?> <label>Aktif</label>
                </div>
            </div>  
            <?php
        }
        ?>		
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit',));
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), '', array('class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    ?>
    <?php echo $this->renderPartial($this->path_view . '_buttonPengaturan', ['model' => $model], true); ?>
    <?php
    $tips = array(
        '0' => 'simpan',
        '1' => 'ulang',
    );
    $content = $this->renderPartial($this->path_tips . 'detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
    ?>
</div>
<?php $this->endWidget(); ?>

<?= $this->renderPartial($this->path_view.'_dialog',['model'=>$model], true) ?>
