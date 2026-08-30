<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">Data Pasien</div>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-xs-6">
<!--                        <div class="control-group ">

                            <?php //echo $form->labelEx($modPPBuatJanjiPoli, 'no_rekam_medik', array('class' => 'control-label')) ?>
                            <div class="controls">

                                <input type="text" id="no_rekam_medik" class="span4" disabled="true" />          
                                <?php //echo $form->error($modPPBuatJanjiPoli, 'no_rekam_medik'); ?><?php //echo $form->error($modPasien, 'no_rekam_medik'); ?>
                            </div>

                        </div>-->

                        <div class="control-group ">
                            <?php echo $form->labelEx($modPPBuatJanjiPoli, 'rv_nama_pasien', array('class' => 'control-label')) ?>
                            <div class="controls inline">

                                <?php echo $form->textField($modPPBuatJanjiPoli, 'rv_nama_pasien', array('placeholder' => 'Nama Pasien', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>            
                               
                            </div>
                        </div>
 <?php echo $form->hiddenField($modPPBuatJanjiPoli, 'pasien_id', array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>

                        <?php //echo $form->textFieldRow($modPasien, 'nama_bin', array('onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Nama Alias'));  ?>
                        <?php echo $form->radioButtonListInlineRow($modPPBuatJanjiPoli, 'rv_jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php //echo $form->textFieldRow($modPasien, 'tempat_lahir', array('onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Tempat Lahir')); ?>

                        <div class="control-group ">
                            <?php echo $form->labelEx($modPPBuatJanjiPoli, 'rv_tgl_lahir', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modPPBuatJanjiPoli,
                                    'attribute' => 'rv_tgl_lahir',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                        //
                                        'onkeypress'=>"js:function(){setUmur(this.value);}",
                                        'onSelect'=>'js:function(){setUmur(this.value);}',
                                    ),
                                    'htmlOptions' => array('placeholder' => 'Tanggal Lahir', 'readonly' => true,'onblur'=>'setUmur(this.value);', 'class' => 'dtPicker3 span3', 'onkeypress' => "return $(this).focusNextInputField(event),"
                                    ),
                                ));
                                ?>
                                <?php //echo $form->error($modPasien, 'tanggal_lahir'); ?>
                            </div>
                        </div>

                        <div class="control-group ">
                            <?php echo $form->labelEx($modPasien, 'umur', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <input type="text" id="usia" class="span4" disabled="true" /> 
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo $form->labelEx($modPPBuatJanjiPoli, 'rv_no_telepon', array('class' => 'control-label')) ?>
                            <div class="controls inline">

                                <?php echo $form->textField($modPPBuatJanjiPoli, 'rv_no_telepon', array('placeholder' => 'No. Telepon', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'numbers-only span3')); ?>            

                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo $form->labelEx($modPPBuatJanjiPoli, 'rv_no_telepon_darurat', array('class' => 'control-label')) ?>
                            <div class="controls inline">

                                <?php echo $form->textField($modPPBuatJanjiPoli, 'rv_no_telepon_darurat', array('placeholder' => 'No. Telepon Darurat', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'numbers-only span3')); ?>            

                            </div>
                        </div>
                        <div class="control-group ">

                            <?php echo $form->labelEx($modPPBuatJanjiPoli, 'rv_email', array('class' => 'control-label')) ?>
                            <div class="controls">

                                <?php echo $form->textField($modPPBuatJanjiPoli, 'rv_email', array('placeholder' => 'Alamat Email','onblur'=>'emailCheck(this)', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4')); ?>            

                            </div>

                        </div>
                    </div>
                    <div class="col-xs-6">



                        <div class="control-group ">
                            <?php echo $form->labelEx($modPPBuatJanjiPoli, 'rv_propinsi_id', array('class' => 'control-label refreshableLocation')) ?>
                            <div class="controls">
                                <?php
                                echo $form->dropDownList($modPPBuatJanjiPoli, 'rv_propinsi_id', CHtml::listData($modPasien->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array('class' => 'form-control span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'ajax' => array('type' => 'POST',
                                        'url' => $this->createUrl('SetDropdownKabupaten', array('encode' => false, 'model_nama' => get_class($modPPBuatJanjiPoli))),
                                        'update' => "#" . CHtml::activeId($modPPBuatJanjiPoli, 'rv_kabupaten_id'),
                                    ),
                                    'onchange' => "setClearDropdownKelurahan();setClearDropdownKecamatan();",
                                    'style' => 'width:170px;'));
                                ?>
                                
                                <?php echo $form->error($modPasien, 'rv_propinsi_id'); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo $form->labelEx($modPPBuatJanjiPoli, 'rv_kabupaten_id', array('class' => 'control-label refreshableLocation')) ?>
                            <div class="controls">
                                <?php
                                echo $form->dropDownList($modPPBuatJanjiPoli, 'rv_kabupaten_id', empty($modPPBuatJanjiPoli->rv_propinsi_id) ? array() : CHtml::listData($modPasien->getKabupatenItems($modPPBuatJanjiPoli->rv_propinsi_id), 'kabupaten_id', 'kabupaten_nama'), array('class' => 'form-control span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'ajax' => array('type' => 'POST',
                                        'url' => $this->createUrl('SetDropdownKecamatan', array('encode' => false, 'model_nama' => get_class($modPPBuatJanjiPoli))),
                                        'update' => "#" . CHtml::activeId($modPPBuatJanjiPoli, 'rv_kecamatan_id'),
                                    ),
                                    'onchange' => "setClearDropdownKelurahan();",
                                    'style' => 'width:170px;'));
                                ?>
                                
                                <?php echo $form->error($modPPBuatJanjiPoli, 'rv_kabupaten_id'); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo $form->labelEx($modPPBuatJanjiPoli, 'rv_kecamatan_id', array('class' => 'control-label refreshableLocation')) ?>
                            <div class="controls">
                                <?php
                                echo $form->dropDownList($modPPBuatJanjiPoli, 'rv_kecamatan_id', empty($modPPBuatJanjiPoli->rv_kabupaten_id) ? array() : CHtml::listData($modPasien->getKecamatanItems($modPPBuatJanjiPoli->rv_kabupaten_id), 'kecamatan_id', 'kecamatan_nama'), array('class' => 'form-control span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'ajax' => array('type' => 'POST',
                                        'url' => $this->createUrl('SetDropdownKelurahan', array('encode' => false, 'model_nama' => get_class($modPPBuatJanjiPoli))),
                                        'update' => "#" . CHtml::activeId($modPPBuatJanjiPoli, 'rv_kelurahan_id'),
                                    ),
                                    'onchange' => "",
                                    'style' => 'width:170px;'));
                                ?>
                               
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo $form->labelEx($modPPBuatJanjiPoli, 'rv_kelurahan_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                             
                                <?php
                                echo $form->dropDownList($modPPBuatJanjiPoli, 'rv_kelurahan_id', empty($modPPBuatJanjiPoli->rv_kecamatan_id) ? array() : CHtml::listData($modPasien->getKelurahanItems($modPPBuatJanjiPoli->rv_kecamatan_id), 'kelurahan_id', 'kelurahan_nama'), array('empty' => '-- Pilih --', 'class' => 'form-control span3', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'style' => 'width:170px;'));
                                ?>
                               
                                <?php echo $form->error($modPasien, 'kelurahan_id'); ?>
                            </div>
                        </div>

                        
                        <div class="control-group ">
                            <?php echo $form->labelEx($modPPBuatJanjiPoli, 'rv_alamat', array('class' => 'control-label')) ?>
                            <div class="controls">
                           
                                <?php
                                    echo $form->textArea($modPPBuatJanjiPoli, 'rv_alamat', array('placeholder' => 'Alamat Pasien', 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => '')); 
                                    // echo "";
                                ?>
                               
                                <?php echo $form->error($modPasien, 'rv_alamat'); ?>
                            </div>
                        </div>
                    



                    </div>
                   
                </div>
                <div class="col-xs-12">
                        <div style='color:red;text-align:center;'>Mohon update data jika ada perubahan</div>
                    </div>                 
            </div>
        </div>  
    </div> 
</div>    
<ul class="list-inline pull-left">
    <li><button type="button" class="btn btn-default prev-step">Kembali</button></li>

</ul>
<ul class="list-inline pull-right">

    <li><button type="button" class="btn btn-primary next-step" >Lanjut</button></li> 
</ul>


<script>
/**
                * set nilai umur dari tanggal_lahir 
                * @param {type} tanggal_lahir
                * @returns {undefined} */
               function setUmur(rv_tgl_lahir)
               {
             
                   $.ajax({
                      type:'POST',
                      url:'<?php echo $this->createUrl('SetUmur'); ?>',
                      data: {tanggal_lahir : rv_tgl_lahir},//
                      dataType: "json",
                      success:function(data){
                          console.log(data.umur);
                          $("#usia").val(data.umur);
                          
                      },
                       error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                   });
               }
function emailCheck(obj){
    if (!validateEmail($(obj).val())) {
        myAlert('Format Email Tidak Valid!');
        return false;
    }
}
function validateEmail($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test( $email );
}
</script>