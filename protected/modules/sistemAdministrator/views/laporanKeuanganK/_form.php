<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'id'=>'laporankeuangan-m-form',
        'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)')
)); ?>
<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>

        <div class="row">
                <div class="col-sm-6">
                        <div class="control-group">
                                <?php echo $form->labelEx($model, 'menu_id', array('class' => 'control-label')); ?>
                                <div class="controls">
                                        <?php echo $form->hiddenField($model, 'menu_id'); ?>
                                        <?php
                                        $this->widget('MyJuiAutoComplete', array(
                                                'model' => $model,
                                                'attribute' => 'menu_nama',
                                                'source' => 'js: function(request, response) {
                                                                $.ajax({
                                                                        url: "' . $this->createUrl('AutocompleteMenu') . '",
                                                                        dataType: "json",
                                                                        data: {
                                                                                term: request.term
                                                                        },
                                                                        success: function (data) {
                                                                                response(data);
                                                                        }
                                                                })
                                                        }',
                                                'options' => array(
                                                'showAnim' => 'fold',
                                                'minLength' => 3,
                                                'focus' => 'js:function( event, ui ) {
                                                                $("#' . CHtml::activeId($model, 'menu_nama') . '").val( ui.item.label );
                                                                $("#' . CHtml::activeId($model, 'menu_url') . '").val( ui.item.menu_url );
                                                                return false;
                                                                }',
                                                'select' => 'js:function( event, ui ) {
                                                                $("#' . CHtml::activeId($model, 'menu_id') . '").val( ui.item.value );
                                                                $("#' . CHtml::activeId($model, 'menu_nama') . '").val( ui.item.label );
                                                                $("#' . CHtml::activeId($model, 'menu_url') . '").val( ui.item.menu_url );
                                                                return false;
                                                                }',
                                                ),
                                                'tombolDialog' => array("idDialog" => 'dlgMenu'),
                                                'htmlOptions' => array( 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                                        ));
                                        ?>
                                </div>
                        </div>
                        <div class="control-group">
                                <?php echo CHtml::label('URL <span class="required">*</span>', 'menu_url', array('class' => 'control-label required')); ?>
                                <div class="controls">
                                        <?php echo $form->textField($model, 'menu_url',array('class'=>'span3')); ?>
                                        <?php echo CHtml::link('<i class="icon-edit icon-white"></i>', 'javascript:void(0)', array('class' => 'btn btn-primary', 'onclick' => '$("#dialogUrl").dialog("open"); return false;')); ?>
                                        
                                </div>
                        </div>
                        <div class="control-group">
                                <?php echo CHtml::label('Keterangan <span class="required">*</span>', 'keterangan', array('class' => 'control-label required')); ?>
                                <div class="controls">
                                        <?php echo $form->textArea($model, 'keterangan',array('class'=>'span3')); ?>
                                </div>
                        </div>

                </div>
                <div class="col-sm-6">
                        <div style="margin-top: 20px !important; width: 150px;" class="panel panel-darkk">
                                <span class="group-title">
                                        Level Rekening
                                </span>
                                <div class="panel-body" style="padding-top:5px !important;">
                                       <?php 
                                       $konfig = KonfigsystemK::model()->find();
                                        $levelrek = (!empty($konfig->levelrekeninglast)? $konfig->levelrekeninglast : 1); 
                                        $htmlrek = "";
                                        $a = 0;
                                        for ($i = 1; $i<$levelrek; $i++){
                                                $ischeck = false;

                                                if(!empty($model->levelrek)){
                                                        $orilevelrek = explode(',',$model->levelrek);
                                                        foreach($orilevelrek as $ori){
                                                                if($ori == $i){
                                                                        $ischeck = true;      
                                                                }
                                                        }
                                                }

                                                if($a > 0){
                                                        $htmlrek .= "<br/>";     
                                                }
                                                $htmlrek .= CHtml::hiddenField('Levelrek['.$a.'][lv]',$i,array());
                                                $htmlrek .= CHtml::checkBox('Levelrek['.$a.'][ischeck]',$ischeck,array()).' '.$i;
                                                $a++;
                                        }
                                        echo $htmlrek;

                                       ?> 
                                
                                </div>
                        </div>
                </div>
        </div>

<div class="form-actions">
        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),'', array('class' => 'btn btn-default',
                'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
        <?php
                echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Konfigurasi Laporan Keuangan', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
                $content = $this->renderPartial($this->path_view.'.tips.tipsCreate',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
</div>
<?php $this->endWidget(); ?>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dlgMenu',
    'options' => array(
        'title' => 'Pencarian Menu',
        'autoOpen' => false,
        'modal' => true,
        'zIndex'=>1002,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));
?>

<?php
    $modMenu = new MenumodulK();
    $modMenu->modul_id = 26;
    $modMenu->kelmenu_id = 35;					
    if (isset($_GET['MenumodulK'])) {
        $modMenu->attributes = $_GET['MenumodulK'];	
    }
				
    $this->widget('bootstrap.widgets.BootGridView',array(
        'id'=>'menu-m-grid',
        'dataProvider'=>$modMenu->searchDialog(),
        'filter'=>$modMenu,					
        'itemsCssClass' => 'table table-bordered datatable dataTable',
        'columns'=>array(		
                array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                        "href"=>"",
                        "id" => "selectObat",
                        "onClick" => "
                                        $(\"#'.CHtml::activeId($model,'menu_id').'\").val(\"$data->menu_id\");
                                        $(\"#'.CHtml::activeId($model,'menu_nama').'\").val(\"$data->menu_nama\");
                                        $(\"#'.CHtml::activeId($model,'menu_url').'\").val(\"$data->menu_url\");
                                        $(\"#dlgMenu\").dialog(\"close\"); 
                                        return false;
                                "))',
                ),
                array(
                        'header' => 'Nama Menu',
                        'name' => 'menu_nama',
                        'value' => '$data->menu_nama'
                ),
                array(
                        'header' => 'URL Menu',
                        'name' => 'menu_url',
                        'value' => '$data->menu_url'
                ),							
            
        ),
    ));
							
$this->endWidget();
?>


<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogUrl',
    'options' => array(
        'title' => 'URL',
        'autoOpen' => false,
        'modal' => true,
    ),
));
?>

<?php echo CHtml::beginForm($this->createUrl('/sistemAdministrator/MenuModulK/GetControllers'), 'POST', array()); ?>

<div class="control-group">
    <?php echo CHtml::label('Nama Modul', 'namaModul', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::dropDownList(
            'namaModul',
            '',
            CustomFunction::getModules(),
            array(
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('/sistemAdministrator/MenuModulK/GetControllers', array('encode' => false)),
                    'update' => '#namaController'  //selector to update
                ),
                'empty'=>'-- Pilih --'
            )
        ); ?>
    </div>
</div>

<div class="control-group">
    <?php echo CHtml::label('Nama Controller', 'namaController', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::dropDownList(
            'namaController',
            '',
            array(),
            array(
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('/sistemAdministrator/MenuModulK/GetActions', array('encode' => false)),
                    'update' => '#namaAction'  //selector to update
                ),
                'empty'=>'-- Pilih --'
            )
        ); ?>
    </div>
</div>

<div class="control-group">
    <?php echo CHtml::label('Nama Action', 'namaAction', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::dropDownList('namaAction', '', array('empty'=>'-- Pilih --')); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::link(Yii::t('mds', 'Simpan'), 'javascript:void(0)', array('style' => 'color: #fff;', 'class' => 'btn btn-danger', 'onclick' => 'createURL(); return false;')); ?>
    <?php echo CHtml::link(Yii::t('mds', 'Batal'), 'javascript:void(0)', array('class' => 'btn btn-default', 'onclick' => '$("#dialogUrl").dialog("close"); return false;')); ?>
</div>
<?php echo CHtml::endForm(); ?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<script type="text/javascript">
    function createURL() {
        var url = $('#namaModul').val();
        if ($('#namaController').val() != null)
            url = url + '/' + $('#namaController').val();
        if ($('#namaAction').val() != null)
            url = url + '/' + $('#namaAction').val();

        $('#<?php echo CHtml::activeId($model,'menu_url'); ?>').val(url);
        $("#dialogUrl").dialog("close");
    }
</script>