<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Data Kunjungan</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group">
                    <label class="control-label">Tgl.Pendaftaran</label>
                    <div class="controls">
                        <?php //CHtml::activeTextField($model, 'tglkonsulpoli', ['class' => 'span3']); ?>
                        <?php   
                        $this->widget('MyDateTimePicker',array(
                                'model'=>$model,
                                'attribute'=>'tglmasukpenunjang',
                                'mode'=>'datetime',
                                'options'=> array(
                                        'dateFormat'=>'yy-mm-dd',
//                                        'minDate' => 'd',
                                        'yearRange'=> "-60:+0",
                                ),
                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3 dtmask span3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                ),
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
        <?php echo CHtml::label('Shift <span class="required">*</span>', 'shift_id', array('class' => 'control-label required')) ?> 
        <div class='controls'>
            <?php
            echo $form->dropDownList($model, 'shift_id', CHtml::listData(ShiftHdM::model()->findAllByAttributes(array('shift_hd_aktif' => true)), 'shift_hd_id', 'shift_hd_nama'), array('empty' => '-- Pilih --',
                'onkeypress' => "return $(this).focusNextInputField(event)",
                'class' => 'span3 required',
            ));
            ?>
        </div>
    </div> 
                <div class='control-group'>
                    <?php echo CHtml::label("Ruangan <span class='required'>*</span>", CHtml::activeId($model, 'ruangan_id'), array('class' => 'control-label required')) ?>                                   
                    <div class='controls'>
                        <?php
                        echo $form->dropDownList($model, 'ruangan_id', CHtml::listData(RuanganhemodialisaV::model()->findAll(" instalasi_id = ".$modPasienrujukan->instalasi_id." "), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --',
                            'onchange' => "setDropdownDokter(this.value);setDropdownJeniskasuspenyakit(this.value);setDropDownKelasPelayanan(this.value);",
                            'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3',
                        ));
                        ?>
                    </div>
                </div> 
                <!-- <div class='control-group'>
                    <label class="control-label required">Kelas Pelayanan <span class="required">*</span></label>                                  
                    <div class='controls'>
                         <?php // echo $form->dropDownList($model, 'kelaspelayanan_id', CHtml::listData($model->getKelasPelayananItems($model->ruangan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => "updateKamarByKelasLantai(true)", 'class' => 'span3')); ?>
                    </div>
                </div>  -->
                <?php //echo $form->dropDownListRow($model, 'kelaspelayanan_id', CHtml::listData($model->getKelasPelayananItems($model->ruangan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => "updateKamarByKelasLantai(true)", 'class' => 'span3')); ?>
                <!-- <div class="control-group">
                    <?php // echo CHtml::label('Lantai', 'lantai_hd', array('class' => 'control-label')) ?> 
                    <div class='controls'>
                        <?php
                        // echo $form->dropDownList($model, 'lantai_hd', CHtml::listData(LookupM::model()->findAll("lookup_type = 'lantai_ruangan_hd' AND lookup_aktif IS TRUE"), 'lookup_name', 'lookup_name'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'onchange' => "updateKamarByKelasLantai(true)",
                        // ));
                        ?>
                    </div>
                </div> -->
                <div class="control-group">
                    <?php echo CHtml::label('Bed <span class="required">*</span>', 'kamarruangan_id', array('class' => 'control-label')) ?> 
                    <div class='controls'>
                        <?php
                        echo $form->dropDownList($model, 'kamarruangan_id', !empty($model->ruangan_id) ? CHtml::listData(KamarruanganM::model()->findAllByAttributes(array('ruangan_id' => Yii::app()->user->getState('ruangan_id')), ['order' => 'kamarruangan_nobed::integer asc']), 'kamarruangan_id', 'KamarDanTempatTidurInUseHemodialisa') : array(), array('empty' => '-- Pilih --',
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'class' => 'span3',
                            'onchange' => 'cekKamarKosong(this)'
                        ));
                        ?>
                    </div>
                </div>
                
                <!-- <div class="control-group">
                    <?php // echo CHtml::label('Jenis Tindakan <span class="required">*</span>', 'jenis_tindakan', array('class' => 'control-label')) ?> 
                    <div class='controls'>
                        <?php // echo $form->dropDownList($model, 'jeniskasuspenyakit_id', CHtml::listData($model->getJenisKasusPenyakitItems($model->ruangan_id), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required')); ?> 
                    </div>
                </div> -->
                <div class="control-group">
                    <label class="control-label required">DPJP <span class="required">*</span></label>
                    <div class="controls">
                         <?php
//                        echo CHtml::activeHiddenField($model, 'pegawaikonsul_id', []);
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'nama_pegawai',
                            'source' => 'js: function(request, response) {
                                            var ruangan_id = $("#' . CHtml::activeId($model, 'ruangan_id') . '").val();
                                                $.ajax({
                                                        url: "' . $this->createUrl('AutocompleteDokter') . '",
                                                        dataType: "json",
                                                        data: {
                                                                nama_pegawai: request.term,
                                                                ruangan_id: ruangan_id,
                                                        },
                                                        success: function (data) {
                                                                        response(data);
                                                        }
                                                })
                                        }',
                            'options' => array(
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
								 $(this).val( "");
								 return false;
							 }',
                                'select' => 'js:function( event, ui ) {
                                                $(this).val(ui.item.value);
                                                $("#' . CHtml::activeId($model, 'pegawaikonsul_id') . '").val(ui.item.pegawai_id);
                                                $("#' . CHtml::activeId($model, 'nama_pegawai') . '").val(ui.item.nama_pegawai);
                                                return false;
                                            }',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogDPJP'),
                            'htmlOptions' => array('class' => 'span3', 'placeholder' => 'Ketik Nama Dokter', 'rel' => 'tooltip', 'title' => 'Ketik Nama Dokter',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => "",),
                        ));
                        ?>                                    
                        <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                    </div> 
                </div>
            </div>
            <div class="span6">
                <div class="control-group ">
                    <?php echo CHtml::label('Jadwal Selanjutnya','tanggal', array('class'=>'control-label')) ?>
                   <div class="controls">
                           <?php   
                           (isset($model->waktu_prescription)) ? $model->waktu_prescription : date('d-m-Y');
                           
                           $this->widget('MyDateTimePicker',array(
                                   'model'=>$modJadwalhemodialisa,
                                   'attribute'=>'jadwalhemodialisa_tgl_ke',
                                   'mode'=>'date',
                                   'options'=> array(
                                           'dateFormat'=>'yy-mm-dd',
                                           'minDate' => 'd',
                                           'yearRange'=> "-60:+0",
                                           'onSelect'=>'js:function(){hariBaru(); return false;}',
                                   ),
                                   'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3 span3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                   ),
                           )); 
                           ?>		
                           <?php echo $form->hiddenField($modJadwalhemodialisa, 'jadwalhemodialisa_hari', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                   </div>
               </div>
                <div class="control-group">
                    <?php echo CHtml::label('Shift Selanjutnya', 'shift_id', array('class' => 'control-label')) ?> 
                    <div class='controls'>
                        <?php
                        echo $form->dropDownList($modJadwalhemodialisa, 'shift_id', CHtml::listData(ShiftHdM::model()->findAllByAttributes(array('shift_hd_aktif' => true)), 'shift_hd_id', 'shift_hd_nama'), array('empty' => '-- Pilih --',
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'class' => 'span3',
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Keterangan</label>
                    <div class="controls"><?= $form->textArea($model,'keterangan_hd', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'', 'style'=>'width:285px; height: 100px'));?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function cekKamarKosong(obj) {
        var kamarruangan = $(obj).find("option:selected").text();
        
        var split = kamarruangan.split(" --- ");
        
        console.log(split);
        // if (typeof split[1] !== "undefined"){
        //     myAlert(split[0]+' Masih Digunakan oleh '+split[1]);
        //     $(obj).val('');
        //     return false;
        // }
        
    }
</script>