<div class="panel panel-primary"> 
<div class="panel-heading">
                                        <div class="panel-title">Tipe Pembayaran</div>
                                    </div>
                                    <div class="panel-body">
                                        <div id="tipepembayaran">
                                            <div class="control-group ">
<!--                                                <label class="control-label" style="text-align:left">Tipe Pembayaran</label>-->
                                                <?php echo $form->labelEx($modPPBuatJanjiPoli, 'carabayar_id', array('class' => 'control-label'))  ?>
                                                <div class="controls">
                                                    <?php
                                                    echo $form->dropDownList($modPPBuatJanjiPoli, 'carabayar_id', CHtml::listData($modpendaftaran->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                                        'ajax' => array('type' => 'POST',
                                                            'url' => $this->createUrl('SetDropdownPenjaminPasien', array('encode' => false, 'namaModel' => get_class($modPPBuatJanjiPoli))),
                                                            'success' => 'function(data){$("#' . CHtml::activeId($modPPBuatJanjiPoli, "penjamin_id") . '").html(data);}',
                                                        ),
                                                        'onchange' => '',
                                                        'class' => 'span3 form-control ',
                                                    ));
                                                    ?>
                                                </div>
                                            </div>

                                            <div class="control-group ">
                                                 <?php echo $form->labelEx($modPPBuatJanjiPoli, 'penjamin_id', array('class' => 'control-label'))  ?>
                                                
                                                <div class="controls">
                                                    <?php
                                                    echo $form->dropDownList($modPPBuatJanjiPoli, 'penjamin_id', CHtml::listData($modpendaftaran->getPenjaminItems($modPPBuatJanjiPoli->carabayar_id), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --',
                                                        'onchange' => '',
                                                        'onkeyup' => "return $(this).focusNextInputField(event)",
                                                        'class' => 'span3 form-control'
                                                    ));
                                                    ?>
                                                </div>
                                            </div>
                                            <?php echo $form->hiddenField($modPPBuatJanjiPoli, 'tempatbekerja_id', array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>   
                                            <div class="control-group ">
                                                <?php echo $form->labelEx($modPPBuatJanjiPoli,'tempatbekerja_id', array('class'=>'control-label refreshable')) ?>
                                                <div class="controls">
                                                    <?php echo $form->dropDownList($modPPBuatJanjiPoli,'tempatbekerja_id', CHtml::listData( TempatbekerjaM::model()->findAll('tempatbekerja_aktif=TRUE ORDER BY tempatbekerja_nama'), 'tempatbekerja_id', 'tempatbekerja_nama'),array('style' => 'width:170px;','empty'=>'-- Pilih --', 'class'=>'form-control span3', 'onkeyup'=>"return $(this).focusNextInputField(event)", "onchange"=>"cekStatusPekerjaan(this)")); ?>
                                                    <?php echo $form->hiddenField($modPPBuatJanjiPoli, 'tempatbekerja_nama', array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>  
                                                    <?php echo $form->hiddenField($modPPBuatJanjiPoli, 'jadwalpegawai_id', array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>  
                                                    <?php echo $form->hiddenField($modPPBuatJanjiPoli, 'jambooking', array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>  
                                                    
                                                </div>
                                            </div>
                                            <!--  -->
                                        </div>
                                        <ul class="list-inline pull-left">
                                            <li><button type="button" class="btn btn-default prev-step">Kembali</button></li>
                                        </ul>
                                        <ul class="list-inline pull-right">

                                            <li><button type="submit" class="btn btn-primary">Simpan</button></li>
                                        </ul>
                                    </div></div>