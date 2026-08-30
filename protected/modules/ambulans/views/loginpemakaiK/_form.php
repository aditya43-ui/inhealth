
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'loginpemakai-k-form',
	'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
                'method'=>'POST',
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

        <table>
    <thead>
        <tr>
            <td><?php echo $form->errorSummary($model); ?></td></tr>
        <tr>
<!--<td>Pegawai</td>-->
            <td>  
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'pegawai_id', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php 
               echo CHtml::activeHiddenField($model, 'pegawai_id');
                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                    'name'=>'SAPegawaiM[nama_pegawai]',
                                    'value'=>$model->pegawai_id,
                                    'source'=>'js: function(request, response) {
                                                   $.ajax({
                                                       url: "'.Yii::app()->createUrl('ActionAutoComplete/Pegawai').'",
                                                       dataType: "json",
                                                       data: {
                                                           term: request.term,
                                                       },
                                                       success: function (data) {
                                                               response(data);
                                                       }
                                                   })
                                                }',
                                     'options'=>array(
                                           'showAnim'=>'fold',
                                           'minLength' => 3,
                                           'focus'=> 'js:function( event, ui ) {
                                                $(this).val(ui.item.value);
                                                return false;
                                            }',
                                           'select'=>'js:function( event, ui ) {
                                                $("#'.CHtml::activeId($model, 'pegawai_id').'").val(ui.item.pegawai_id)
                                                return false;
                                            }',
                                    ),
                                )); ?>
            <?php echo CHtml::htmlButton('<i class="entypo-search"></i>',
                            array('onclick'=>'$("#dialogPegawai").dialog("open");return false;',
                                  'class' => 'btn btn-danger',
                                  'onkeypress'=>"return $(this).focusNextInputField(event)",
                                  'rel'=>"tooltip",
                                  'title'=>"Klik untuk mencari pegawai",)); ?>
            <?php 
            // Dialog buat nambah data pegawai =========================
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
                'id'=>'dialogPegawai',
                'options'=>array(
                    'title'=>'Menambah data Pegawai',
                    'autoOpen'=>false,
                    'modal'=>true,
                    'minWidth'=>800,
                    'minHeight'=>500,
                    'resizable'=>false,
                ),
        ));

            $modPegawai =new AMPegawaiM('searchDialog');
            $this->widget('ext.bootstrap.widgets.BootGridView',array( 
                'id'=>'sapegawai-m-grid', 
                'dataProvider'=>$modPegawai->search('searchDialog'), 
                'filter'=>$modPegawai, 
                'template'=>"{summary}\n{items}\n{pager}", 
                'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
                'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'',
            
                        'value'=>'CHtml::link("<i class=\"icon-form-check\"></i>","#", array("id" => "selectPegawai",
                                                      "onClick"=>"
                                                        $(\"#idPegawai\").val(\"$data->pegawai_id\");
                                                        $(\"#'.CHtml::activeId($model,'pegawai_id').'\").val(\"$data->pegawai_id\");
                                                        $(\"#SAPegawaiM_nama_pegawai\").val(\"$data->nama_pegawai\");
                                                        $(\"#dialogPegawai\").dialog(\"close\");    
                                                        "
                                                 ))',
                    ), 
               ////'pegawai_id',
//                array( 
//                        'name'=>'pegawai_id', 
//                        'value'=>'$data->pegawai_id', 
//                        'filter'=>false, 
//                ),
                'nomorindukpegawai',
                'gelardepan',
                'nama_pegawai', 
                'jeniskelamin',                    
                'tempatlahir_pegawai',
                'tgl_lahirpegawai',
                'alamat_pegawai',
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                )); ?>

                <?php $this->endWidget(); ?>
                    </div>
                </div>
            
            </td>
                
         
            
        </tr>
        <tr>
            <td>            <?php  
                        echo $form->errorSummary($model); 
                        echo $form->textFieldRow($model,'nama_pemakai',array('onkeyup'=>'nospaces(this);','hint'=>$model->getAttributeLabel('nama_pemakai').' tidak boleh menggunakan "spasi"','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>20)); 
                        echo $form->passwordFieldRow($model,'new_password',array('class'=>'span3',  'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>200)); 
                        echo $form->passwordFieldRow($model,'new_password_repeat',array('class'=>'span3',  'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>200)); 
            ?>
        <div class="control-group">
            <?php echo $form->labelex($model,'ruangan',array('class'=>'control-label required')) ?>
            <div class="controls">
                <?php 
                                                                   
                        $this->widget('application.extensions.emultiselect.EMultiSelect',
                              array('sortable'=>true, 'searchable'=>true)
                        );
                        echo CHtml::dropDownList(
                            'ruangan_id[]',
                            '',
                            CHtml::listData(RuanganM::model()->findAll(array('order'=>'ruangan_nama')), 'ruangan_id', 'ruangan_nama'),
                            array('multiple'=>'multiple','key'=>'ruangan_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                        );
                ?>
                <?php echo $form->error($model,'ruangan') ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelex($model,'modul',array('class'=>'control-label required')) ?>
            <div class="controls">
                <?php 
                                                                   
                        $this->widget('application.extensions.emultiselect.EMultiSelect',
                              array('sortable'=>true, 'searchable'=>true)
                        );
                        echo CHtml::dropDownList(
                            'modul_id[]',
                            '',
                            CHtml::listData(ModulK::model()->findAll(array('order'=>'modul_nama')), 'modul_id', 'modul_nama'),
                            array('multiple'=>'multiple','key'=>'modul_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                        );
                ?>
                <?php echo $form->error($model,'modul') ?>
            </div>
        </div>
            <div class="form-actions">
                        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                             Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                              array('class' => 'btn btn-danger', 'type'=>'submit','id'=>'submitButton','onKeypress'=>'return formSubmit(this,event)')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                                              Yii::app()->createUrl($this->module->id.'/'.loginpemakaiK.'/admin'), 
                                                              array('class' => 'btn btn-default','onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
            </div>

<?php $this->endWidget(); ?></td>
        </tr>
    </thead>
</table>        
               

<?php

$js = <<< JSCRIPT
   kosongkanPassword();
       
   function kosongkanPassword(){
        $('#LoginpemakaiK_new_password').val('');
        $('#LoginpemakaiK_new_password_repeat').val('');
   }

JSCRIPT;

Yii::app()->clientScript->registerScript('kosongkanPassword', $js, CClientScript::POS_READY);

 ?>

<script type="text/javascript">
function nospaces(t){
    if(t.value.match(/\s/g)){
        myAlert('Maaf, inputan tidak diperbolehkan menggunakan spasi');
        t.value=t.value.replace(/\s/g,'');
    }
}
</script>
