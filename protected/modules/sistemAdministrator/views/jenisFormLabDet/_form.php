<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sajenisformdetlab-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));
?>
<div class="row-fluid">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Jenis Form <span style="color:red">*</span>', 'jenisform_id', array('class' => 'control-label')); ?>
            <div class="controls">
        
                <?php echo $form->dropDownList($model, 'jenisform_id', CHtml::listData(JenisformM::model()->findAllByAttributes(array('jenisform_aktif' => true)), 'jenisform_id', 'jenisform_nama'), array('class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
        <?php echo $form->hiddenField($model, 'pemeriksaanlab_id'); ?>
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
                        'class'=>'required'
                    ),
                'tombolDialog' => array('idDialog' => 'dialogDiagnosa'),
                ));
                    ?>
            </div>
        </div> 
        <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="controls">
            <?php  
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('class' => 'btn btn-danger btn_submit', 'title' => 'Simpan', 'type' => 'button', 'onclick'=>'simpanJenisFormDetail();')
            ); 
            ?>
            </div>
        </div>   
    </div>
    <?php /*
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Jenis Pemeriksaan Lab', 'jenispemeriksaanlab_id', array('class' => 'control-label')); ?>
            <div class="controls">
            <?php //echo $form->dropDownList($model, 'jenispemeriksaanlab_id', LookupM::getItems('jenispemeriksaanlab_id'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onblur' => 'refreshTable();')); ?>
            <?php echo $form->dropDownList($model, 'jenispemeriksaanlab_id', CHtml::listData(JenispemeriksaanlabM::model()->findAllByAttributes(array('jenispemeriksaanlab_nama' => Params::LOOKUPTYPE_JENISPEMERIKSAANLAB_NAMA)), 'jenispemeriksaanlab_id', 'jenispemeriksaanlab_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
 
            </div>
        </div>
    </div>
    */ ?>
    <div class="col-sm-6">
            
    </div>
    
</div>

<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . 'admin2', array(
                'model' => $model,
            )); ?>
<div class="form-actions">
    <?php /* echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'title' => 'Simpan', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); */ ?>
    <?php /*
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'class' => 'btn btn-default',
            'title' => 'Ulang',
            'onclick' => 'return refreshForm(this);'
        )
    ); */
    ?>
    <?php //echo CHtml::link(Yii::t('mds','{icon} Pengaturan Jenis Pemeriksaan Lab',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jenis Form Detail', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips/tipsCreate', array(), true);
    $this->widget('UserTips', array('content' => $content));
    ?>
</div>

<script>
    function simpanJenisFormDetail() {
        $(".btn_submit").prop("disabled", true);
        $.post('<?php echo $this->createUrl('simpanDetail'); ?>', $("#sajenisformdetlab-m-form").serialize(), function(data) {
            if (data.ok == 1) {
                myAlert(data.msg);
                $("#sajenisformdetlab-m-form").get(0).reset(); 
                $.fn.yiiGridView.update("sajenisformdetlab-m-grid");
            } else {
                myAlert(data.msg);
            }
            $(".btn_submit").prop("disabled", false);
        }, 'json');
    }
</script>


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
                                    $(\"#' . CHtml::activeId($model, 'pemeriksaanlab_id') . '\").val(\'$data->pemeriksaanlab_id\');
                                    $(\"#' . CHtml::activeId($model, 'pemeriksaanlab_nama') . '\").val(\'$data->pemeriksaanlab_nama\');

                                    $(\'#dialogDiagnosa\').dialog(\'close\');
									refreshTable();
                                    return false;"))',
            'htmlOptions'=>array(
                'style'=>'width: 50px',
            ),
        ),
        array(
            'header' => 'Jenis Pemeriksaan Lab',
            'name' => 'jenispemeriksaanlab_id',
            'type' => 'raw',
            'value' => function($data) {
                return $data->jenispemeriksaan->jenispemeriksaanlab_nama ?? "-";
            },
            'filter'=>CHtml::activeDropDownList($modDiagnosaKep, 'jenispemeriksaanlab_id', CHtml::listData(
                JenispemeriksaanlabM::model()->findAll('jenispemeriksaanlab_aktif = true order by jenispemeriksaanlab_nama'),
                'jenispemeriksaanlab_id', 'jenispemeriksaanlab_nama'
            ), array(
                'empty'=>'-- Pilih --',
            )),
            'filterHtmlOptions'=>array(
                'style'=>'width: 200px;'
            ),
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
