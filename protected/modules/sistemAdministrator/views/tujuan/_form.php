<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sarekeningcolumn-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="control-group">
        <?php echo Chtml::label('Luaran Keperawatan', 'luarankeperawatan_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->hiddenField($model, 'luarankeperawatan_id'); ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'luarankeperawatan_nama',
                'source' => 'js: function(request, response) {
                                $.ajax({
                                        url: "' . $this->createUrl('AutoCompleteLuaranKeperawatan') . '",
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
                                    $("#' . CHtml::activeId($model, 'luarankeperawatan_id') . '").val(ui.item.luarankeperawatan_id);
                                    return false;
                                }',
                ),
                'htmlOptions' => array(
                    'placeholder' => 'Nama Luaran Keperawatan',
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                ),
                'tombolDialog' => array('idDialog' => 'dialogDiagnosa'),
            ));
            ?>
        </div>
    </div>
    <div class='control-group'>
        <?php echo $form->labelEx($model, 'tujuan_nama', array('class' => 'control-label', 'label'=>'Ekspektasi Nama')) ?>
        <div class="controls">
            <?php echo $form->textField($model, 'tujuan_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
        </div>
    </div> 

    <div class='control-group'>
        <?php echo $form->labelEx($model, 'tujuan_aktif', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->checkBox($model, 'tujuan_aktif', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div> 
</div>
<div class="row">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
        ); ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('create'), array('class' => 'btn btn-danger',
            'onclick' => 'return refreshForm(this);'));
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Ekspektasi', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
        <?php
        $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
//========= Dialog buat cari data Rekening Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDiagnosa',
    'options' => array(
        'title' => 'Luaran Keperawatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));

$modDiagnosaKep = new LuarankeperawatanM('search');
$modDiagnosaKep->unsetAttributes();
if (isset($_GET['LuarankeperawatanM'])) {
    $modDiagnosaKep->attributes = $_GET['LuarankeperawatanM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'diagnosakep-m-grid',
    'dataProvider' => $modDiagnosaKep->search(),
    'filter' => $modDiagnosaKep,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
                        "#",
                        array(
                            "class"=>"btn-small", 
                            "id" => "selectDiagnosa",
                            "onClick" => "
                            $(\"#' . CHtml::activeId($model, 'luarankeperawatan_id') . '\").val(\'$data->luarankeperawatan_id\');
                            $(\"#' . CHtml::activeId($model, 'luarankeperawatan_nama') . '\").val(\'$data->luarankeperawatan_nama\');

                            $(\'#dialogDiagnosa\').dialog(\'close\');
                            return false;"))'
        ),
        array(
            'header' => 'Kode Luaran Keperawatan',
            'name' => 'luarankeperawatan_kode',
            'value' => '$data->luarankeperawatan_kode',
        ),
        array(
            'header' => 'Luaran Keperawatan',
            'type' => 'raw',
            'name' => 'luarankeperawatan_nama',
            'value' => '$data->luarankeperawatan_nama',
        ),
        array(
            'header' => 'Deskripsi',
            'name' => 'luarankeperawatan_deskripsi',
            'value' => '$data->luarankeperawatan_deskripsi',
        ),
        array(
            'header' => 'Status',
            'value' => '($data->luarankeperawatan_aktif == TRUE) ? "Aktif" : "Tidak Aktif"',
            'filter' => CHtml::dropDownList(
                    'luarankeperawatan_aktif', $modDiagnosaKep->luarankeperawatan_aktif, array('1' => 'Aktif',
                '0' => 'Tidak Aktif',), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<script type="text/javascript">
    function cek(obj) {
        if ($(obj).is(':checked')) {
            $(obj).parents("tr").find("input[name$='[tujuan_aktif]']").val(1);
        } else {
            $(obj).parents("tr").find("input[name$='[tujuan_aktif]']").val(0);
        }
    }
</script>