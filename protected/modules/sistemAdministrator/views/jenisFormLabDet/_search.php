 <?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sajenisformdetlab-m-search',
    'type' => 'horizontal',
));
?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <?php echo $form->hiddenField($model, 'jenisform_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 30,)); ?>
        <div class="control-group">
            <?php echo CHtml::label('Kelompok Pemeriksaan Lab', 'pemeriksaanlab_kelompok', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jenispemeriksaanlab_kelompok', LookupM::getItemsUrutan('jenispemeriksaanlab_kelompok'), array('empty'=>'-- Pilih --', 'class'=>'span3')); ?>
            </div>
        </div> 
        <div class="control-group">
            <?php echo CHtml::label('Jenis Form <span style="color:red">*</span>', 'jenisform_id', array('class' => 'control-label')); ?>
            <div class="controls">
        
                <?php echo $form->dropDownList($model, 'jenisform_id', CHtml::listData(JenisformM::model()->findAllByAttributes(array('jenisform_aktif' => true)), 'jenisform_id', 'jenisform_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
            </div>
        </div> 
        <div class="control-group">
            <?php echo CHtml::label('Jenis Pemeriksaan <span style="color:red">*</span>', 'jenispemeriksaanlab_nama', array('class' => 'control-label')); ?>
            <div class="controls">
            <?php //echo $form->hiddenField($model, 'pemeriksaanlab_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 30,)); ?>
            <?php echo $form->dropDownList($model, 'jenispemeriksaanlab_id', CHtml::listData(JenispemeriksaanlabM::model()->findAllByAttributes(array('jenispemeriksaanlab_nama' => Params::LOOKUPTYPE_JENISPEMERIKSAANLAB_NAMA)), 'jenispemeriksaanlab_id', 'jenispemeriksaanlab_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
       </div>
        </div>  
    </div>
   <div class="col-sm-6">
     
    </div>
            <div class="control-group">
            <?php echo CHtml::label('Pemeriksaan Lab <span style="color:red">*</span>', 'pemeriksaanlab_nama', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                       $this->widget('MyJuiAutoComplete', array(
                        'model'=>$model,
                        'attribute' => 'pemeriksaanlab_nama',
                        'source' => 'js: function(request, response) {
                                           $.ajax({
                                               url: "' . Yii::app()->createUrl('ActionAutoComplete/formLabDet') . '",
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
                                           $("#pemeriksaanlab_id").val(ui.item.pemeriksaanlab_id);
                                           $("#pemeriksaanlab_nama").val(ui.item.pemeriksaanlab_nama);
                                            return false;
                                        }',

                        ),
                        'htmlOptions' => array(
                            'readonly' => false,
                            'placeholder' => 'Pemeriksaan Lab',
                            'size' => 13,
                            'class' => 'search_pemeriksaanlab_id',
                        ),
                    'tombolDialog' => array('idDialog' => 'dialogDiagnosa'),
                    ));
                        ?>
                </div>
            </div>

</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('class' => 'btn btn-primary', 'type' => 'submit', 'title' => 'Cari')
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
//========= Dialog buat cari data Rekening Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDiagnosa',
    'options' => array(
        'title' => 'Pemeriksaan Lab',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));

$modDiagnosaKep = new PemeriksaanlabM('search');
$modDiagnosaKep->unsetAttributes();
if (isset($_GET['PemeriksaanlabM'])) {
    $modDiagnosaKep->attributes = $_GET['PemeriksaanlabM'];
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
                                    $(\".search_pemeriksaanlab_id\").val(\'$data->pemeriksaanlab_nama\');

                                    $(\'#dialogDiagnosa\').dialog(\'close\');
									refreshTable();
                                    return false;"))'
        ),
    
        array(
            'header' => 'Pemeriksaan Lab Nama',
            'name' => 'pemeriksaanlab_nama',
            'value' => '$data->pemeriksaanlab_nama',
        ),
        
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>