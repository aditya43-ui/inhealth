<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
));
?>
<?php //echo $form->textFieldRow($model,'jenisdiet_nama',array('class'=>'span3'));     
?>
<?php //echo $form->textFieldRow($model,'tipediet_nama',array('class'=>'span3'));     
?>
<?php //echo $form->textFieldRow($model,'menudiet_nama',array('class'=>'span3'));     
?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Jenis Diet', 'jjenisdiet', array('class' => "control-label")) ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('JadwalMakanM[jenisdiet_id]', '', array('readonly' => true)) ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'jenisdiet',
                    'source' => 'js: function(request, response) {
                               $.ajax({
                                   url: "' . $this->createUrl('Jenisdiet') . '",
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
                                       $("#JadwalMakanM_jenisdiet_id").val(ui.item.jenisdiet_id);
                                       $("#jenisdiet_nama").val(ui.item.jenisdiet_nama);
                                        return false;
                                    }',
                    ),
                    'htmlOptions' => array(
                        'readonly' => false,
                        'placeholder' => 'Jenis Diet',
                        'size' => 13,
                        'onkeypress' => "return $(this).focusNextInputField(event);",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogJenisdiet'),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Tipe Diet', 'ttipediet', array('class' => "control-label")) ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('JadwalMakanM[tipediet_id]', '', array('readonly' => true)) ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'tipediet',
                    'source' => 'js: function(request, response) {
                               $.ajax({
                                   url: "' . $this->createUrl('TipeDiet') . '",
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
                                       $("#JadwalMakanM_tipediet_id").val(ui.item.tipediet_id);
                                       $("#tipediet_nama").val(ui.item.tipediet_nama);
                                        return false;
                                    }',
                    ),
                    'htmlOptions' => array(
                        'readonly' => false,
                        'placeholder' => 'Tipe Diet',
                        'size' => 13,
                        'onkeypress' => "return $(this).focusNextInputField(event);",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogTipeDiet'),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Jenis Waktu', 'jjeniswaktu', array('class' => "control-label")); ?>
            <div class="controls">
                <?php echo CHtml::dropDownList('JadwalMakanM[jeniswaktu_id]', $model->jeniswaktu_id, CHtml::listData($model->getJenisWaktuItems(), 'jeniswaktu_id', 'jeniswaktu_nama'), array('empty' => '-- Pilih --')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Menu Diet', 'mmenudiet', array('class' => "control-label")) ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('JadwalMakanM[menudiet_id]', '', array('readonly' => true)) ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'menudiet',
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
                        'placeholder' => 'Menu Diet',
                        'size' => 13,
                        'onkeypress' => "return $(this).focusNextInputField(event);",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogMenuDiet'),
                ));
                ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
    Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
    array(
        'title' => 'Ulang',
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    )
); ?>
</div>

<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogJenisdiet',
    'options' => array(
        'title' => 'Pencarian Jenis Diet',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'resizable' => true,
    ),
));

$modJenisdiet = new GZJenisdietM('search');
$modJenisdiet->unsetAttributes();
if (isset($_GET['GZJenisdietM'])) {
    $modJenisdiet->attributes = $_GET['GZJenisdietM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'jenisdiet-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modJenisdiet->search(),
    'filter' => $modJenisdiet,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                            array(
                                                    "class"=>"btn-small",
                                                    "id" => "selectJenisdiet",
                                                    "onClick" => "\$(\"#JadwalMakanM_jenisdiet_id\").val($data->jenisdiet_id);
                                                                          \$(\"#jenisdiet\").val(\"$data->jenisdiet_nama\");
                                                                          \$(\"#dialogJenisdiet\").dialog(\"close\");"
                                             )
                             )',
        ),
        'jenisdiet_nama',
        'jenisdiet_namalainnya',
        'jenisdiet_keterangan',
        'jenisdiet_catatan',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
/* -------------------------------------------------------------------------- endWidget Jenisdiet ---------------------------------------------- */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogTipeDiet',
    'options' => array(
        'title' => 'Pencarian Tipe Diet',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'resizable' => true,
    ),
));

$modTipeDiet = new GZTipeDietM('search');
$modTipeDiet->unsetAttributes();
if (isset($_GET['GZTipeDietM'])) {
    $modTipeDiet->attributes = $_GET['GZTipeDietM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'tipediet-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modTipeDiet->search(),
    'filter' => $modTipeDiet,
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
                                                    "onClick" => "\$(\"#JadwalMakanM_tipediet_id\").val($data->tipediet_id);
                                                                          \$(\"#tipediet\").val(\"$data->tipediet_nama\");
                                                                          \$(\"#dialogTipeDiet\").dialog(\"close\");
                                                                          \$(\"#tableJadwalMakan\").append(\"<tr><td>tes..</td></tr>\");"
                                             )
                             )',
        ),
        'tipediet_nama',
        'tipediet_namalainnya',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
/* -------------------------------------------------------------------------- endWidget TipeDiet ---------------------------------------------- */

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