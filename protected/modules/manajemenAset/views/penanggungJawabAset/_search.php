<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sagolongan-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class="col-sm-6">
            <div class="control-group ">
                <label class="control-label">Nama Pegawai</label>
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
                <label class="control-label">Lokasi</label>
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
                                    $("#' . CHtml::activeId($model, 'lokasi_id') . '").val(ui.item.lokasi_id);
                                    $("#' . CHtml::activeId($model, 'lokasiaset_namalokasi') . '").val(ui.item.lokasiaset_namalokasi);                                    
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
	<div class="col-sm-6">
            <div class="control-group ">
                <label class="control-label">Ruangan</label>
                <div class="controls">
                    <?php echo $form->hiddenField($model, 'ruangan_id',['class'=>'ruangan_id']); ?>
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'ruangan_nama',
                        'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('/ActionAutoComplete/getRuangan') . '",
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
                                    $("#' . CHtml::activeId($model, 'ruangan_id') . '").val(ui.item.ruangan_id);
                                    $("#' . CHtml::activeId($model, 'ruangan_nama') . '").val(ui.item.ruangan_nama);
                                    return false;
                            }',
                        ),
                        'htmlOptions' => array(
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'placeholder' => "ketik nama ruangan",
                            'class' => 'span3 ruangan_nama',
                            'onblur'=>'if(this.value==""){$("#' . CHtml::activeId($model, 'lokasi_id') . '").val("")}'
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogRuangan'),
                    ));
                    ?>
                </div>
            </div>
            
            <div class="control-group">
                <?php echo CHtml::label("","",array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->checkBox($model,'penanggungjawabaset_aktif',array('checked'=>'penanggungjawabaset_aktif')); ?> <label>Aktif</label>
                </div>
            </div>  
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
</div>
<?php 
    $this->endWidget();     
?>

<?= $this->renderPartial($this->path_view.'_dialog',['model'=>$model,'pencarian'=>'tidakkosong'], true) ?>

<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRuangan',
    'options'=>array(
        'title'=>'Daftar Ruangan',
        'autoOpen'=>false,
        'position'=>['top',20] ,
        'modal'=>true,
        'width'=>550,
        'height'=>600,
        'resizable'=>false,
    ),
));

echo $this->renderPartial($this->path_view.'grid/_grid_ruangan',['model'=>$model]);

$this->endWidget();