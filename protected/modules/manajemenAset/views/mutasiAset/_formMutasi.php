<?php
/**
 * Terdiri dari field mutasi aset.
 * 
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * 
 */

echo CHtml::hiddenField('jenis','');
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><i class="glyphicon glyphicon-file"></i> Mutasi</div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->label($model, 'tglmutasiaset', array(
                    'class'=>'control-label'
                )); ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tglmutasiaset',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            // 'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                    ));
                    ?>
                </div>
            </div>
            
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'lokasiasal_id', array('class' => ' control-label')); ?>
                <div class="controls">
                     <?php 
                    
                    echo $form->hiddenField($model, 'lokasiasal_id',['class'=>'lokasiasal_id required']); 
                    
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,                                        
                        'attribute' => 'lokasiasal_nama',
                        'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('/actionAutoComplete/GetLokasiAset') . '",
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
                                    setLokasi(ui.item,"asal")
                                    return false;
                            }',
                        ),
                        'htmlOptions' => array(
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'placeholder' => "Ketik Nama lokasi asal aset ",
                            'class' => ' lokasiasal_nama required',
                            'onblur'=>'if(this.value==""){$("#' . CHtml::activeId($model, 'lokasiasal_id') . '").val("")}'
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogLokasi','jsFunction'=>'$("#dialogLokasi").dialog("open");setJenis("asal")'),    
                    ));
                    ?>
                </div>
            </div>
            
            <div class="control-group ">
                    <?php echo $form->labelEx($model, 'ruanganasal_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?= $form->hiddenField($model,'ruanganasal_id',['class'=>'required span3 ruanganasal_id','readonly'=>true]) ?>
                    <?= $form->textField($model,'ruanganasal_nama',['class'=>'required  ruanganasal_nama','readonly'=>true]) ?>
                </div>
            </div>
            
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'pegmenyerahkan_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                        echo $form->hiddenField($model, 'pegmenyerahkan_id');
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'pegmenyerahkan_nama',
                            'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . Yii::app()->createUrl('ActionAutoComplete/DropPetugasRuangan') . '",
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
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                    $(this).val( ui.item.nama_pegawai);
                                    return false;
                                }',
                                'select' => 'js:function( event, ui ) {
                                    $("#' . Chtml::activeId($model, 'pegmenyerahkan_id') . '").val(ui.item.pegawai_id); 
                                    return false;
                                }',
                            ),
                            'htmlOptions' => array(
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'placeholder' => 'Ketik nama Pegawai yang Menyerahkan',
                                'class' => ' required hurufs-only'
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPegawaiMenyerahkan'),
                        ));
                    ?>

                    <?php echo $form->error($model, 'pegmenyerahkan_id'); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->label($model, 'nomutasiaset', array(
                    'class'=>'control-label'
                )); ?>
                <div class="controls">
                    <?php
                    echo $form->textField($model, 'nomutasiaset', array(
                        'readonly'=>true,
                    ));
                    ?>
                </div>
            </div>
            
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'lokasitujuan_id', array('class' => ' control-label')); ?>
                <div class="controls">
                     <?php 
                    
                    echo $form->hiddenField($model, 'lokasitujuan_id',['class'=>'lokasitujuan_id required']); 
                    
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,                                        
                        'attribute' => 'lokasitujuan_nama',
                        'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('/actionAutoComplete/GetLokasiAset') . '",
                                dataType: "json",
                                data: {
                                    term: request.term,      
                                    notpj: "ya"
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
                                    setLokasi(ui.item,"tujuan")
                                    return false;
                            }',
                        ),
                        'htmlOptions' => array(
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'placeholder' => "Ketik Nama lokasi tujuan aset ",
                            'class' => ' lokasitujuan_nama required',
                            'onblur'=>'if(this.value==""){$("#' . CHtml::activeId($model, 'lokasitujuan_id') . '").val("")}'
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogLokasi','jsFunction'=>'$("#dialogLokasi").dialog("open");setJenis("tujuan")'),    
                    ));
                    ?>
                </div>
            </div>
            
            <div class="control-group ">
                    <?php echo $form->labelEx($model, 'ruangantujuan_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?= $form->hiddenField($model,'ruangantujuan_id',['class'=>'required span3 ruangantujuan_id','readonly'=>true]) ?>
                    <?= $form->textField($model,'ruangantujuan_nama',['class'=>'required  ruangantujuan_nama','readonly'=>true]) ?>
                </div>
            </div>
            
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'pegpenerima_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    
                        echo $form->hiddenField($model, 'pegpenerima_id');
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'pegpenerima_nama',
                            'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . Yii::app()->createUrl('ActionAutoComplete/DropPetugasRuangan') . '",
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
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                    $(this).val( ui.item.nama_pegawai);
                                    return false;
                                }',
                                'select' => 'js:function( event, ui ) {
                                    $("#' . Chtml::activeId($model, 'pegpenerima_id') . '").val(ui.item.pegawai_id); 
                                    return false;
                                }',
                            ),
                            'htmlOptions' => array(
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'placeholder' => 'Ketik nama Pegawai yang Menyerahkan',
                                'class' => ' required hurufs-only'
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPegawaiTerima'),
                        ));
                    ?>

                    <?php echo $form->error($model, 'pegpenerima_id'); ?>
                </div>
            </div>
        </div>
        
    </div>
</div>




