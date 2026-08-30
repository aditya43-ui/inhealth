<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - 
* RSST-1584
*/
?>

<div class="panel panel-darkk">
    <span class="group-title">
        <i class="entypo-user"></i> Data <b>Penanggung Jawab</b>
    </span>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Pegawai</label>
                <div class="controls">
                    <?php
                            echo $form->hiddenField($model,'pj_pemeliharaan_id',array('readonly'=>true));

                            $this->widget('MyJuiAutoComplete', array(    
                               'model'=>$model,
                               'attribute' => 'pj_pemeliharaan_nama',
                               'value' => '',
                               'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/dokterPerawat'),
                               'options' => array(
                                   'showAnim' => 'fold',
                                   'minLength' => 3,
                                   'focus' => 'js:function( event, ui ) {
                                           $(this).val( ui.item.label);
                                           return false;
                                       }',
                                   'select' => 'js:function( event, ui ) {

                                                 }',
                               ),
                                'htmlOptions'=>array(
                                    'readonly'=>false,
                                    'placeholder'=>'Dokter Pemeriksa',
                                    'size'=>20,
                                    'class'=>'',
                                    'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'dpjp_id') . '").val(""); ',
                                    'onkeypress'=>"return $(this).focusNextInputField(event);",
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogDPJP','idTombol'=>'tombolDPJP'),
                           ));
                       ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">NIP</label>
                <div class="controls">
                    <?php echo $form->textField($model,'nip',array('class'=>'','readonly'=>true)); ?>
                </div>
            </div>
                
        </div>
        
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">NIP</label>
                <div class="controls">
                    <?php echo $form->textField($model,'jabatan_nama',array('class'=>'','readonly'=>true)); ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">NIP</label>
                <div class="controls">
                    <?php echo $form->textField($model,'unitkerja',array('class'=>'','readonly'=>true)); ?>
                </div>
            </div>
        </div>
    </div>
</div>