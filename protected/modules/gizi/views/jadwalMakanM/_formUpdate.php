<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gzjadwalmakan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#menudiet',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
?>
<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->
<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php
        echo $form->dropDownListRow($model, 'jenisdiet_id', CHtml::listData($model->JenisdietItems, 'jenisdiet_id', 'jenisdiet_nama'), array('readonly' => true), array('class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',));
        ?>
        <?php
        echo $form->dropDownListRow($model, 'tipediet_id', CHtml::listData($model->TipeDietItems, 'tipediet_id', 'tipediet_nama'), array('readonly' => true), array('class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',));
        ?>
    </div>
    <div class="col-sm-6">
        <?php
        echo $form->dropDownListRow($model, 'jeniswaktu_id', CHtml::listData($model->JenisWaktuItems, 'jeniswaktu_id', 'jeniswaktu_nama'), array('readonly' => true), array('class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',));
        ?>
        <div class="control-label">Menu Diet</div>
        <?php echo CHtml::hiddenField('JadwalMakanM[menudiet_id]', $model->menudiet_id, array('readonly' => true)) ?>
        <div class="controls">
            <?php
            /* $menudiet = MenuDietM::model()->findAll();
              foreach($menudiet as $valuemenudiet):
              $returnMenuDiet[] = array(
              'label'=>$valuemenudiet->menudiet_nama,
              'value'=>$valuemenudiet->menudiet_nama,
              'id'=>$valuemenudiet->menudiet_id,);
              endforeach; */
            ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'name' => 'menudiet',
                'value' => $model->menudiet->menudiet_nama,
                'source' => 'js: function(request, response) {
                                                                       $.ajax({
                                                                           url: "' . $this->createUrl('MenuDiet') . '",
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
                    'focus' => 'js:function( event, ui )
                                                                               {
                                                                                $(this).val(ui.item.label);
                                                                                return false;
                                                                                }',
                    'select' => 'js:function( event, ui ) {
                                                                               $("#JadwalMakanM_menudiet_id").val(ui.item.menudiet_id);
                                                                                return false;
                                                                            }',
                ),
                'htmlOptions' => array(
                    'readonly' => false,
                    'size' => 13,
                ),
                'tombolDialog' => array('idDialog' => 'dialogMenuDiet'),
            ));
            ?>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'onKeyUp' => 'return formSubmit(this,event)'));
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/jadwalMakanM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jadwal Makan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('jadwalMakanM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit3d', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<?php
$jscript = <<< JSCRIPT

JSCRIPT;
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMenuDiet',
    'options' => array(
        'title' => 'Pencarian Menu Diet',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'resizable' => true,
    ),
));

$modMenuDiet = new GZMenuDietM('search');
$modMenuDiet->unsetAttributes();
if (isset($_GET['GZMenuDietM'])) {
    $modMenuDiet->attributes = $_GET['GZMenuDietM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'menudiet-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modMenuDiet->search(),
    'filter' => $modMenuDiet,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                            array(
                                                    "class"=>"btn-small",
                                                    "id" => "selectTipeDiet",
                                                    "onClick" => "\$(\"#JadwalMakanM_menudiet_id\").val($data->menudiet_id);
                                                                          \$(\"#menudiet\").val(\"$data->menudiet_nama\");
                                                                          \$(\"#dialogMenuDiet\").dialog(\"close\");"
                                             )
                             )',
        ),
        'menudiet_nama',
        'menudiet_namalain',
        'jml_porsi',
        'ukuranrumahtangga',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
/* -------------------------------------------------------------------------- endWidget MenuDiet ---------------------------------------------- */
?>