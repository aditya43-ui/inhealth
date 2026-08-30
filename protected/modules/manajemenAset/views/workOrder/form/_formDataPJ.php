<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - menampilkan form penanggung jawab
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
                <label class="control-label">Pegawai  <span class="required">*</span></label>
                <div class="controls">
                    <?php
                            echo $form->hiddenField($model,'pj_pemeliharaan_id',array('readonly'=>true,'class'=>'required'));

                            $this->widget('MyJuiAutoComplete', array(    
                               'model'=>$model,
                               'attribute' => 'pj_pemeliharaan_nama',
                               'value' => '',                               
                                'source'=>'js: function(request, response) {
                                           $.ajax({
                                               url: "'.Yii::app()->createUrl('/ActionAutoComplete/getPegawai').'",
                                               dataType: "json",
                                               data: {
                                                   term: request.term,
                                                   is_peg_pjasset: "ya"
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
                                                    pilih(1);
                                                    setPegawai(ui.item,"auto");
                                                    return false;
                                                 }',
                               ),
                                'htmlOptions'=>array(
                                    'readonly'=>false,
                                    'placeholder'=>'Penanggung Jawab',
                                    'size'=>20,
                                    'class'=>'required',
                                    'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'pj_pemeliharaan_id') . '").val(""); ',
                                    'onkeypress'=>"return $(this).focusNextInputField(event);",
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogPegawai','idTombol'=>'tombolDPJP', 'jsFunction'=>"pilih(1);$('#judul').html('Penanggung Jawab');"),
                                
                           ));
                       ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">NIP</label>
                <div class="controls">
                    <?php echo $form->textField($model,'pj_nip',array('class'=>'','readonly'=>true)); ?>
                </div>
            </div>
                
        </div>
        
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Jabatan</label>
                <div class="controls">
                    <?php echo $form->textField($model,'pj_jabatan_nama',array('class'=>'','readonly'=>true)); ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Unit Kerja</label>
                <div class="controls">
                    <?php echo $form->textField($model,'pj_unitkerja_nama',array('class'=>'','readonly'=>true)); ?>
                </div>
            </div>
        </div>
    </div>
</div>