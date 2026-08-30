<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'komponendarah-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'namakomponendrh')
)); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Nama Komponen Darah', 'namakomponendrh', array('class' => 'control-label required')) ?>
            <div class="controls"><span style="margin-left:-10px" class="required">*</span>
                <?php echo $form->textField($model, 'namakomponendrh', array('placeholder' => 'Nama Komponen Darah', 'class' => 'span3', 'maxlength' => 300)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Singkatan', 'singkatan_komp', array('class' => 'control-label required')) ?>
            <div class="controls"><span style="margin-left:-10px" class="required">*</span>
                <?php echo $form->textField($model, 'singkatan_komp', array('placeholder' => 'Singkatan', 'class' => 'span3 hurufs-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 300)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", 'komponendarah_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'komponendarah_aktif', array('id' => 'aktif', 'checked' => 'komponendarah_aktif')); ?> <label for="aktif">Aktif</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Jenis Kantong Darah', 'jeniskantongdarah_id', array('class' => 'control-label required')) ?>
            <div class="controls"><span style="margin-left:-10px" class="required">*</span>
                <?php echo $form->dropdownList($model, 'jeniskantongdarah_id', CHtml::listData($model->JeniskantongdarahItems, 'jeniskantongdarah_id', 'nama_jenis'), array('empty' => '-- Pilih --', 'onkeypress' => 'return $(this).focusNextInputField(event)', 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Daftar Tindakan', 'jeniskantongdarah_id', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'daftartindakan',
                    'value' => isset($model->daftartindakan->daftartindakan_nama) ? $model->daftartindakan->daftartindakan_nama : '',
                    'source' => 'js: function(request, response) {
                               $.ajax({
                                   url: "' . $this->createUrl('AutocompleteDaftarTindakan') . '",
                                   dataType: "json",
                                   data: {
                                       daftartindakan: request.term,
                                   },
                                   success: function (data) {
                                           response(data);
                                   }
                               })
                            }',
                    'options' => array(
                        'minLength' => 4,
                        'focus' => 'js:function( event, ui ) {
                             $(this).val("");
                             return false;
                         }',
                        'select' => 'js:function( event, ui ) {
                            $(this).val( ui.item.label);
                            $("#BDKomponendarahM_daftartindakan_id").val(ui.item.value);
                            $("#daftartindakan_id").val(ui.item.daftartindakan_id);
                            return false;
                        }',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogDaftarTindakan', 'idTombol' => 'tombolDaftarTindakan'),
                    'htmlOptions' => array(
                        'class' => 'span3', 'placeholder' => 'Uraian Tindakan', 'rel' => 'tooltip', 'title' => 'Ketik Uraian Tindakan',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onclick' => 'changeSize()',
                    ),
                ));
                ?>
                <?php echo $form->error($model, 'daftartindakan_id'); ?>
                <?php echo $form->hiddenField($model, 'daftartindakan_id'); ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Komponen Darah', array('{icon}' => '<i class="entypo-folder"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success',)); ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>

<?php $this->endWidget(); ?>

<?php
/* ====================================== Widget Dialog Daftar Tindakan ====================================== */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDaftarTindakan',
    'options' => array(
        'title' => 'Daftar Tindakan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 450,
        'resizable' => false,
    ),
));
//   $a = TariftindakanperdatotalV::model()->findByAttributes(array('kelompoktindakan_id'=>28));
$modDaftarTindakan = new BDTariftindakanperdatotalV;
$modDaftarTindakan->unsetAttributes();
$modDaftarTindakan->kelompoktindakan_id = 30;
if (isset($_GET['BDTariftindakanperdatotalV'])) {
    $modDaftarTindakan->attributes = $_GET['BDTariftindakanperdatotalV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftartindakan-m-grid',
    'dataProvider' => $modDaftarTindakan->searchDialogTindakanBankDarah(),
    'filter' => $modDaftarTindakan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                        array(
                            "class"=>"btn-small",
                            "id" => "daftartindakan",
                            "onClick" => "\$(\"#BDKomponendarahM_daftartindakan_id\").val($data->daftartindakan_id);
                                          \$(\"#daftartindakan\").val(\"$data->daftartindakan_nama\");
                                          \$(\"#daftartindakan_id\").val(\"$data->daftartindakan_id\");

                                          \$(\"#dialogDaftarTindakan\").dialog(\"close\");"

                         )
                     )',
        ),
        'daftartindakan_nama',
        array(
            'name' => 'harga_tariftindakan',
            'value' => 'MyFormatter::formatNumberForPrint($data->harga_tariftindakan)',
            'filter' => false,
            'htmlOptions' => array(
                'style' => 'text-align: right;',
            )
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
/* ====================================== endWidget Dialog Daftar Tindakan ====================================== */
?>
<script type="text/javascript">
    $('#tombolDaftarTindakan').click(function() {

        window.parent.document.getElementById('frame').style = 'overflow-y:scroll;height:500px;';

    });
</script>