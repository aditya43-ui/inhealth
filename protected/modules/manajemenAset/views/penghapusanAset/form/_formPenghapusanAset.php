<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - form inputan pengeluaran aset
* RSST-1640
*/
?>

<div class="panel panel-success">
    <!--<span class="group-title">
        Penghapusan Aset
    </span>-->
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Penghapusan Aset
        </div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
             <div class="control-group">
                 <label class="control-label">Tanggal Penghapusan<span class="required">*</span></label>
                <div class="controls">
                    <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglpenghapusan',
                            'mode' => 'date',
                            'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('placeholder'=>'Tanggal','readonly' => true, 'class' => ' ', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            ),
                        ));
                    ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Cara<span class="required">*</span></label>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'carapenghapusan', LookupM::getItems('carapenghapusan'),array('empty' => '-- Pilih --','class'=>'required')) ?>
                </div>
            </div>
            
            <div class="control-group">
                 <label class="control-label">Pegawai Penghapusan<span class="required">*</span></label>
                 <div class="controls">
                     <?php
                            echo $form->hiddenField($model,'pegmengetahui_id',array('readonly'=>true,'class'=>'required'));

                             $this->widget('MyJuiAutoComplete', array(    
                                'model'=>$model,
                                'attribute' => 'pegmengetahui_nama',
                               'value' => '',                               
                                'source'=>'js: function(request, response) {
                                           $.ajax({
                                               url: "'.Yii::app()->createUrl('/ActionAutoComplete/DropPetugasRuangan').'",
                                               dataType: "json",
                                               data: {
                                                   term: request.term,
                                                   ruangan_id: '.Yii::app()->user->getState('ruangan_id').'
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
                                    'placeholder'=>'Pegawai Penghapusan',
                                     'size'=>20,
                                    'class'=>'required',
                                    'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'pegmengetahui_id') . '").val(""); ',
                                     'onkeypress'=>"return $(this).focusNextInputField(event);",

                                 ),
                                'tombolDialog'=>array('idDialog'=>'dialogPegawai','idTombol'=>'tombolDPJP', 'jsFunction'=>"pilih(1);$('#judul').html('Petugas Mengetahui');"),
          

                            ));

                        ?>

                 </div>
        </div>
            
        <div class="control-group">
                 <label class="control-label">Menyetujui</label>
                 <div class="controls">
                     <?php
                            echo $form->hiddenField($model,'pegmenyetujui_id',array('readonly'=>true,'class'=>''));

                             $this->widget('MyJuiAutoComplete', array(    
                                'model'=>$model,
                                'attribute' => 'pegmenyetujui_nama',
                               'value' => '',                               
                                'source'=>'js: function(request, response) {
                                           $.ajax({
                                               url: "'.Yii::app()->createUrl('/ActionAutoComplete/DropPetugasRuangan').'",
                                               dataType: "json",
                                               data: {
                                                   term: request.term,
                                                   ruangan_id: '.Yii::app()->user->getState('ruangan_id').'
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
                                                    pilih(2);
                                                    setPegawai(ui.item,"auto");
                                                    return false;
                                                  }',

                                ),
                                 'htmlOptions'=>array(
                                     'readonly'=>false,
                                    'placeholder'=>'Pegawai Menyetujui',
                                     'size'=>20,
                                    'class'=>'',
                                    'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'pegmenyetujui_id') . '").val(""); ',
                                     'onkeypress'=>"return $(this).focusNextInputField(event);",

                                 ),
                                'tombolDialog'=>array('idDialog'=>'dialogPegawai','idTombol'=>'tombolDPJP', 'jsFunction'=>"pilih(2);$('#judul').html('Petugas Menyetujui');"),
          

                            ));

                        ?>

                 </div>
        </div>
    </div>
        
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">Nomor Penghapusan<span class="required">*</span></label>
            <div class="controls">
                <?php echo $form->textField($model,'nopenghapusan',array('class'=>'required','placeholder'=>'Nomor penghapusan')) ?>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Nomor SK<span class="required">*</span></label>
            <div class="controls">
                <?php echo $form->textField($model,'no_sk_penghapusan',array('class'=>'required','placeholder'=>'Nomor SK')) ?>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Tanggal SK<span class="required">*</span></label>
           <div class="controls">
               <?php
                   $this->widget('MyDateTimePicker', array(
                       'model' => $model,
                       'attribute' => 'tgl_sk_penghapusan',
                       'mode' => 'date',
                       'options' => array(
                               'dateFormat' => Params::DATE_FORMAT,
                               'maxDate' => 'd',
                       ),
                       'htmlOptions' => array('placeholder'=>'Tanggal SK','readonly' => true, 'class' => ' ', 'onkeypress' => "return $(this).focusNextInputField(event)",
                       ),
                   ));
               ?>
           </div>
       </div>
        
        <div class="control-group">
            <label class="control-label">Keterangan</label>
            <div class="controls">
                <?php echo $form->textArea($model,'ket_penghapusan',array('placeholder'=>'Keterangan')) ?>
            </div>
        </div>
        
        <!--<div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php //echo $form->checkBox($model,'issambada') ?> <label>Masukkan SIMBADA</label>
            </div>
        </div>-->
    </div>
</div>
    
</div>
    
    