<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'permohonanoa-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
if(isset($_GET['sukses'])){
    if($_GET['sukses']  == 1){
        Yii::app()->user->setFlash("success","Status Approved berhasil diubah!");
    }
}
?>
<legend class="rim">Ubah Status Approved</legend>
	<p class="help-block"><?php //echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
        <?php echo $form->errorSummary($model); ?>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->labelEx($model, 'pegawaimenyetujui_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->hiddenField($model, 'pegawaimenyetujui_id',array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model'=>$model,
                        'attribute' => 'pegawaimenyetujui_nama',
//                        'value'=>$model->pegawaimenyetujui->nama_pegawai,
                        'source' => 'js: function(request, response) {
                                           $.ajax({
                                               url: "' . $this->createUrl('AutocompletePegawaiMenyetujui') . '",
                                               dataType: "json",
                                               data: {
                                                   pegawaimenyetujui_nama: request.term,
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
                                $(this).val( ui.item.label);
                                return false;
                            }',
                            'select' => 'js:function( event, ui ) {
                                $("#'.Chtml::activeId($model, 'pegawaimenyetujui_id') . '").val(ui.item.pegawai_id); 
                                return false;
                            }',
                        ),
                        'htmlOptions' => array(
                            'class'=>'pegawaimenyetujui_nama span3',
                            'placeholder'=>'Nama Pegawai Menyetujui',
                            'onkeyup'=>"return $(this).focusNextInputField(event)",
                            'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'pegawaimenyetujui_id') . '").val(""); '
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogPegawaiMenyetujui'),
                    ));
                    ?>
                </div>
            </div>
        </div>
        <br>
	<div class="form-actions">
           <?php 
                $disableSave = false;
                $disableSave = (!empty($_GET['sukses']) ? true : false);
            ?>
            <?php 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                    array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disableSave));
                 ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                    Yii::app()->createAbsoluteUrl('pendaftaranPenjadwalan/BookingkamarT/admin'), 
                    array('class' => 'btn btn-default',
                          'onclick'=>'$("#dialogUbahStatusKonfirmasiBooking").attr("src",$(this).attr("href")); window.parent.$("#dialogUbahStatusApproved").dialog("close");return false;')); ?>
	</div>

<?php $this->endWidget(); ?>
<?php 
//========= Dialog buat cari data Pegawai Menyetujui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMenyetujui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Menyetujui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>1000,
        'height'=>600,
        'resizable'=>true,
    ),
));

$modPegawaiMenyetujui = new FAPegawaiV('search');
$modPegawaiMenyetujui->unsetAttributes();
if(isset($_GET['FAPegawaiV'])) {
    $modPegawaiMenyetujui->attributes = $_GET['FAPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimenyetujui-grid',
	'dataProvider'=>$modPegawaiMenyetujui->search(),
	'filter'=>$modPegawaiMenyetujui,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($model,'pegawaimenyetujui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($model,'pegawaimenyetujui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMenyetujui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'nama_pegawai'),
                    'value'=>'$data->nama_pegawai',
                ),
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ),
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Menyetujui dialog =============================
?>