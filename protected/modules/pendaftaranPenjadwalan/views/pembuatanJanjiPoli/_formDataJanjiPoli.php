<div class="box" id='fieldsetPoli'>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-file"></i> Data <b>Janji Poli</b>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label("", 'byphone', array('class' => 'control-label')) ?>
                        <div class="controls inline">
                            <?php echo $form->hiddenField($model, 'pasien_id'); ?>
                            <?php echo $form->checkBox($model, 'byphone', array('id' => 'byphone', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <label for="byphone"><i class="icon-phone"></i> <?php echo $model->getAttributeLabel('byphone'); ?></label>
                            <?php echo $form->error($model, 'byphone'); ?>
                        </div>
                        <div class="controls inline">
                            <?php echo $form->checkBox($model, 'whatsapp', array('id' => 'whatsapp', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <label for="whatsapp"><i class="icon-whatsapp"></i> <?php echo $model->getAttributeLabel('whatsapp'); ?></label>
                            <?php echo $form->error($model, 'whatsapp'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPasien, 'Ruangan <span class="required">*</span> ', array('class' => 'control-label')) ?>
                        <div class="controls inline">
                            <?php
                            echo $form->dropDownList($model, 'ruangan_id', CHtml::listData($model->getRuanganItems(), 'ruangan_id', 'ruangan_nama'), array(
                                'class' => 'span3 required', 'empty' => '-- Pilih --', 'onchange' => 'listDataPasienJanjiPoli(this,"ruangan");listDokterRuangan(this.value);', //'onchange'=>"listDokterRuangan(this.value);",
                                'onkeypress' => "return $(this).focusNextInputField(event)"
                            ));
                            ?>
                            <span id="msg_ruangan" style="color:red"></span>

                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Dokter <span class="required">*</span></label>
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'pegawai_id', array(), array('class' => 'span3 required', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onchange' => 'listKuota(); listDataPasienJanjiPoli(this,"dokter");',)); ?>
                            <!-- <br><br>
                            <div class="panel_jadwal">
                            </div>
                            <br/>
                            <label>Kuota</label>
                            <?php //echo CHtml::textField('kuota_janji', "", array('placeholder' => '-', 'class' => 'kuota_janji span1', 'readonly' => true)); ?>
                            <label>Sisa</label>
                            <?php //echo CHtml::textField('sisa_kuota', "", array('placeholder' => '-', 'class' => 'sisa_kuota span1', 'readonly' => true)); ?> -->
                        </div>
                    </div>
                    <?php echo $form->textAreaRow($model, 'keteranganbuatjanji', array('placeholder' => 'Keterangan', 'rows' => 4, 'cols' => 60, 'class' => 'span4 autogrow', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'tgljadwal', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgljadwal[0]',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    // 'minDate' => '1d',
                                    //'onkeypress'=>"js:function(){hariBaru(this);}",
                                    'onSelect' => 'js:function(){AmbilHari(); listKuota();}',
                                    'sideBySide' => true,
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true,
                                    'class' => 'span3 tgl_jadwal',
                                    'placeholder' => 'Silakan pilih tanggal',
                                    'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                        </div>
                        <div class="controls">
                            <?php /*
                              $this->widget('MyDateTimePicker',array(
                              'model'=>$model,
                              'attribute'=>'jamjadwal',
                              'mode'=>'time',
                              'options'=> array(
                              //	'dateFormat'=>Params::DATE_FORMAT,
                              //	'minDate' => 'd',
                              //'onkeypress'=>"js:function(){hariBaru(this);}",
                              //'onSelect'=>'js:function(){hariBaru("jam");}',
                              'line' => true
                              ),
                              'htmlOptions'=>array('style'=>'width:100px;','readonly'=>true,'class'=>'span3',
                              'onkeypress'=>"return $(this).focusNextInputField(event)"
                              ),
                              )); */ ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'harijadwal', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'harijadwal', array(
                                'placeholder' => 'Hari akan terisi otomatis',
                                'class' => 'span3',
                                'onkeypress' => "return $(this).focusNextInputField(event);",
                                'maxlength' => 20,
                                'readonly' => TRUE
                            )); ?>
                        </div>
                        <span id="msg_harijadwal" style="color:red"></span>
                    </div>
                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="controls">
                            <?php //echo $form->dropDownList($model, 'pegawai_id', array(), array('class' => 'span3 required', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onchange' => 'listKuota(); listDataPasienJanjiPoli(this,"dokter");',)); ?>
                            <br><br>
                            <div class="panel_jadwal">
                            </div>
                            <br/>
                            <label>Kuota</label>
                            <?php echo CHtml::textField('kuota_janji', "", array('placeholder' => '-', 'class' => 'kuota_janji span1', 'readonly' => true)); ?>
                            <label>Sisa</label>
                            <?php echo CHtml::textField('sisa_kuota', "", array('placeholder' => '-', 'class' => 'sisa_kuota span1', 'readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Slot <span class="required">*</span></label> 
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'tgljadwal[1]', array(), array(
                                'empty'=>'-- Pilih --',
                                'class'=>'span3 slot_jadwal',
                                'onchange'=>'cekSlotTersedia();'
                            )); ?>
                            <?php echo $form->hiddenField($model, 'no_antrianjanji', array('class'=>'no_antrianjanji')); ?>
                        </div>
                    <div class="checkbox inline">
                    <label for="antrian">Slot Antrian</label>
                    <?php echo $form->checkBox($model, 'slotantrian', array('onkeyup' => "return $(this).focusNextInputField(event)", 'id' => 'antrian')); ?>
                    <?php // echo CHtml::activeLabel($model, 'kunjunganrumah'); 
                    ?>
                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-calendar"></i> Jadwal Dokter
            </div>
        </div>
        <div class="panel-body">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <i class="glyphicon glyphicon-file"></i> Berdasarkan Klinik
                    </h4>
                </div>
                <div id="collapseOne-2" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <span id="janjipoli-klinik">
                            <?php //echo $grid;  
                            ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="panel panel-success">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <i class="glyphicon glyphicon-file"></i> Berdasarkan Dokter
                    </h4>
                </div>
                <div id="collapseOne-1" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <span id="janjipoli-dokter">
                            <?php //echo $grid;  
                            ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>