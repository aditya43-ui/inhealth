<?php echo $form->hiddenField($modPasienAdmisi, 'pasienadmisi_id', array('readonly' => true, 'class' => 'span4')); ?>
<?php echo $form->hiddenField($modPasienAdmisi, 'is_nonkelas', array('readonly' => true, 'class' => 'span4 is_nonkelas')); ?>
<div class="col-sm-6">
    <!--fieldset class="box"-->
    <?php
    /* if(Yii::app()->user->getState('tgltransaksimundur')){
            ?>
    <div class="control-group">
        <?php echo $form->labelEx($modPasienAdmisi,'tgladmisi', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php
                                    $modPasienAdmisi->tgladmisi = (!empty($modPasienAdmisi->tgladmisi) ? date("d/m/Y H:i:s",strtotime($modPasienAdmisi->tgladmisi)) : date("d/m/Y H:i:s"));
                                    $this->widget('MyDateTimePicker',array(
                                                                    'model'=>$modPasienAdmisi,
                                                                    'attribute'=>'tgladmisi',
                                                                    'mode'=>'datetime',
                                                                    'options'=> array(
                                                                            'showOn' => false,
                                                                            'maxDate' => 'd',
                                                                    ),
                                                                    'htmlOptions'=>array('class'=>'dtPicker3 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)",),
                                    )); 
                                    ?>
        </div>
    </div>
    <?php
            }else{ */
    echo $form->textFieldRow($modPasienAdmisi, 'tgladmisi', array('readonly' => true, 'class' => 'span4 realtime', 'onkeyup' => "return $(this).focusNextInputField(event);"));
    // }
    ?>
    <div class='control-group'>
        <?php echo CHtml::label("Catatan Tindak Lanjut", CHtml::activeId($model, 'penerimapasien'), array('class' => 'control-label required')) ?>
        <div class='controls'>
            <?php echo $form->textArea($model, 'penerimapasien', array('placeholder' => 'Catatan Tindak Lanjut', 'rows' => 2, 'cols' => 50, 'class' => 'span4 ', 'onkeyup' => "return $(this).focusNextInputField(event);", 'disabled' => true)); ?>
        </div>
    </div>
    <?php // echo $form->dropDownListRow($model,'keadaanmasuk', LookupM::getItems('keadaanmasuk'),array('empty'=>'-- Pilih --','class'=>'span4','onkeypress'=>"return $(this).focusNextInputField(event)")); 
    ?>
    <?php // echo $form->dropDownListRow($model,'transportasi', LookupM::getItems('transportasi'),array('empty'=>'-- Pilih --','class'=>'span4','onkeypress'=>"return $(this).focusNextInputField(event)")); 
    ?>


    <div class='control-group'>
        <?php echo CHtml::label("Ruangan Inap <span class='required'>*</span>", CHtml::activeId($model, 'ruangan_id'), array('class' => 'control-label required')) ?>
        <div class='controls'>
            <?php
            $ruangan = RuanganpendaftaranrawatinapV::model()->findAllByAttributes(array(
                'action' => $this->id,
            ), array('order' => 'instalasi_id, ruangan_nama ASC'));

            /*echo $form->dropDownList($modPasienAdmisi,'ruangan_id', CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama') ,
array('empty'=>'-- Pilih --',
'onchange'=>"setDropdownDokter(this.value);setDropDownKelasPelayanan(this.value);setKarcis();setAntrianRuanganAdmisi();setDropdownJeniskasuspenyakit(this.value);setEDBpjs(this.value);",
'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span4',
'ajax'=>array(
'type'=>'POST',
'url'=>$this->createUrl('SetDropdownKamarKosong',array('encode'=>false,'namaModel'=>get_class($modPasienAdmisi))),
'update'=>'#'.CHtml::activeId($modPasienAdmisi, 'kamarruangan_id'),
)));*/

            echo $form->dropDownList(
                $modPasienAdmisi,
                'ruangan_id',
                CHtml::listData(
                    RuanganpendaftaranrawatinapV::model()->findAll(array(
                        //'condition'=>$ruangan,
                        'order' => 'ruangan_nama',
                    )),
                    'ruangan_id',
                    'ruangan_nama'
                ),
                array('empty' => '-- Pilih --'),
                array(
                    'empty' => '-- Pilih --',
                    //'onchange' => "setDropdownDokter(this.value);setDropDownKelasPelayanan(this.value);setKarcis();setAntrianRuanganAdmisi();setDropdownJeniskasuspenyakit(this.value);setEDBpjs(this.value);",
                    'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span4',
                )
            );
            ?>

            <div class="checkbox inline">
                <label for="home"><i class="icon-home" style="margin:0" rel="tooltip" title="Ceklis jika Kunjungan Rumah"></i></label>
                <?php echo $form->checkBox($model, 'kunjunganrumah', array('onkeyup' => "return $(this).focusNextInputField(event)", 'id' => 'home')); ?>
                <?php // echo CHtml::activeLabel($model, 'kunjunganrumah'); 
                ?>
            </div>
            <?php echo CHtml::hiddenField('max-antrian-ruangan', 0, array('rel' => 'tooltip', 'title' => 'Maksimum Antrian Ruangan', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'width:25px;',)); ?>
        </div>
    </div>
    <div class="control-group">
        <label for="" class="control-label">Jenis Kasus Penyakit <span class="required">*</span></label>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'jeniskasuspenyakit_id', CHtml::listData($model->getJenisKasusPenyakitItems(Params::INSTALASI_ID_RI), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span4', 'empty' => '-- Pilih --')); ?>
        </div>
    </div>
    <?php echo $form->dropDownListRow(
        $modPasienAdmisi,
        'kelaspelayanan_id',
        CHtml::listData($model->getKelasPelayananItems($modPasienAdmisi->ruangan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama'),
        array(
            'empty' => '-- Pilih --',
            'onkeyup' => "return $(this).focusNextInputField(event)",
            'onchange' => "cekPerbedaanKelas();resetRawatGabung();", //setKarcis();
            'class' => 'span4',
            'ajax' => array(
                'type' => 'POST',
                'data' => array(
                    'kelaspelayanan_id' => 'js:this.value',
                    'ruangan_id' => 'js:$("#' . CHtml::activeId($modPasienAdmisi, 'ruangan_id') . '").val()'
                ),
                'url' => $this->createUrl('SetDropdownKamarKosong', array('encode' => false, 'namaModel' => get_class($modPasienAdmisi))),
                'update' => '#' . CHtml::activeId($modPasienAdmisi, 'kamarruangan_id'),
            )
        )
    ); ?>
    <div class="control-group">
        <?php echo $form->labelEx($modPasienAdmisi, 'kamarruangan_id', array(
            'class' => 'control-label required',
            'label' => 'Kamar <span class="required">*</span>'
        )); ?>
        <?php //echo CHtml::label("Kamar <span class='required'>*</span>", CHtml::activeId($modPasienAdmisi, 'kamarruangan_id'), array('class' => 'control-label required')); 
        ?>
        <?php //echo $form->LabelEx($modPasienAdmisi, 'kamarruangan_id', array('class' => 'control-label')); 
        ?>
        <div class='controls'>
            <?php echo $form->dropDownList(
                $modPasienAdmisi,
                'kamarruangan_id',
                !empty($modPasienAdmisi->ruangan_id) ? CHtml::listData(KamarruanganM::model()->findAllByAttributes(array('ruangan_id' => $modPasienAdmisi->ruangan_id, 'kamarruangan_status' => true), array('order' => 'kamarruangan_id')), 'kamarruangan_id', 'kamarruangan_id') : array(),
                array(
                    'empty' => '-- Pilih --',
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'class' => 'span2',
                    'onchange' => '' . (($modPasien->cekinap == 'rjrd') ? 'cekStKamar(this);' : 'cekStKamarRI(this);')
                    //setKelasPelayananIbuBayi(this.value);
                )
            ); ?>
            <?php //$form->checkBox($modPasienAdmisi, 'rawatgabung', array('onchange' => 'setRuanganRawatGabung(this.value)', 'onkeypress' => "return $(this).focusNextInputField(event)")); 
            ?>
            <?php echo $form->checkBox($modPasienAdmisi, 'is_titipan', array('onclick' => 'pasienTitipan()', 'uncheckValue' => null, 'class' => 'istitipan')); ?>
            <?php //echo $form->hiddenField($modPasienAdmisi, 'is_titipan', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'is_titipan')); 
            ?>
            <?php echo $form->LabelEx($modPasienAdmisi, 'is_titipan'); ?>
        </div>
    </div>

    <div class="control-group hide">
        <?php echo $form->labelEx($modPasienAdmisi, 'dokterpenerima_id', array(
            'class' => 'control-label required',
            'label' => 'Dokter Penerima <span class="required">*</span>'
        )); ?>
        <div class="controls">
            <?php
            echo $form->hiddenField($modPasienAdmisi, 'dokterpenerima_id', array('id' => 'dokterpenerima_id'));
            $this->widget('MyJuiAutoComplete', array(
                'name' => 'dokterpenerima',
                'source' => 'js: function(request, response) {
                                $.ajax({
                                url: "' . $this->createUrl('getDokterPenerima') . '",
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
                                 $("#dokterpenerima_id").val(ui.item.value); 
                                 return false;
                             }',
                ),
                'tombolDialog' => array(
                    'idDialog' => 'dialogDokterUmum',
                    'jsFunction' => 'dokter_id = "#dokterpenerima_id"; dokter_label = "#dokterpenerima"; $("#dialogDokterUmum").dialog("open")',
                ),
                'htmlOptions' => array(
                    "class" => 'span4',
                    'placeholder' => 'Dokter Penerima'
                ),
            ));
            ?>
        </div>
    </div>


    <div class="control-group">
        <?php echo $form->labelEx($modPasienAdmisi, 'pegawai_id', array('class' => 'control-label', 'label' => 'DPJP')); ?>
        <div class="controls">
            <?php
            echo $form->hiddenField($modPasienAdmisi, 'pegawai_id', array('id' => 'dpjp1_id'));
            $this->widget('MyJuiAutoComplete', array(
                'name' => 'dpjp1',
                'source' => 'js: function(request, response) {
                                $.ajax({
                                url: "' . $this->createUrl('getDokterDPJP') . '",
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
                                 $("#dpjp1_id").val(ui.item.value); 
                                 return false;
                             }',
                ),
                'tombolDialog' => array(
                    'idDialog' => 'dialogDokterDPJP',
                    'jsFunction' => 'admisi_dokter_id = "#dpjp1_id"; admisi_dokter_label = "#dpjp1"; $("#dialogDokterDPJP").dialog("open")',
                ),
                'htmlOptions' => array(
                    "class" => 'span4',
                    'placeholder' => 'DPJP'
                ),
            ));
            ?>

            <?php // echo $form->dropDownList($modPasienAdmisi,'pegawai_id', CHtml::listData($model->getDokterItems($modPasienAdmisi->ruangan_id), 'pegawai_id', 'namaLengkap') ,array('onchange'=>'setAntrianDokterAdmisi();','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span4')); 
            ?>
            <?php // echo CHtml::hiddenField('max-antrian-dokter',0, array('rel'=>'tooltip','title'=>'Maksimum Antrian Dokter','readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'width:25px;','value'=>0)); 
            ?>
        </div>
    </div>


    <div class="control-group hide">
        <?php echo $form->labelEx($modPasienAdmisi, 'dpjp2_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            echo $form->hiddenField($modPasienAdmisi, 'dpjp2_id', array('id' => 'dpjp2_id'));
            $this->widget('MyJuiAutoComplete', array(
                'name' => 'dpjp2',
                'source' => 'js: function(request, response) {
                                $.ajax({
                                url: "' . $this->createUrl('getDokterDPJP') . '",
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
                                 $("#dpjp2_id").val(ui.item.value); 
                                 return false;
                             }',
                ),
                'tombolDialog' => array(
                    'idDialog' => 'dialogDokterDPJP',
                    'jsFunction' => 'admisi_dokter_id = "#dpjp2_id"; admisi_dokter_label = "#dpjp2"; $("#dialogDokterDPJP").dialog("open")',
                ),
                'htmlOptions' => array(
                    "class" => 'span4',
                    'placeholder' => 'DPJP 2'
                ),
            ));
            ?>
        </div>
    </div>
    <div class="control-group hide">
        <?php echo $form->labelEx($modPasienAdmisi, 'dpjp3_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            echo $form->hiddenField($modPasienAdmisi, 'dpjp3_id', array('id' => 'dpjp3_id'));
            $this->widget('MyJuiAutoComplete', array(
                'name' => 'dpjp3',
                'source' => 'js: function(request, response) {
                                $.ajax({
                                url: "' . $this->createUrl('getDokterDPJP') . '",
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
                                 $("#dpjp3_id").val(ui.item.value); 
                                 return false;
                             }',
                ),
                'tombolDialog' => array(
                    'idDialog' => 'dialogDokterDPJP',
                    'jsFunction' => 'admisi_dokter_id = "#dpjp3_id"; admisi_dokter_label = "#dpjp3"; $("#dialogDokterDPJP").dialog("open")',
                ),
                'htmlOptions' => array(
                    "class" => 'span4',
                    'placeholder' => 'DPJP 3'
                ),
            ));
            ?>
        </div>
    </div>
    <div class="control-group hide">
        <?php echo $form->labelEx($modPasienAdmisi, 'dpjp4_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            echo $form->hiddenField($modPasienAdmisi, 'dpjp4_id', array('id' => 'dpjp4_id'));
            $this->widget('MyJuiAutoComplete', array(
                'name' => 'dpjp4',
                'source' => 'js: function(request, response) {
                                $.ajax({
                                url: "' . $this->createUrl('getDokterDPJP') . '",
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
                                 $("#dpjp4_id").val(ui.item.value); 
                                 return false;
                             }',
                ),
                'tombolDialog' => array(
                    'idDialog' => 'dialogDokterDPJP',
                    'jsFunction' => 'admisi_dokter_id = "#dpjp4_id"; admisi_dokter_label = "#dpjp4"; $("#dialogDokterDPJP").dialog("open")',
                ),
                'htmlOptions' => array(
                    "class" => 'span4',
                    'placeholder' => 'DPJP 4'
                ),
            ));
            ?>
        </div>
    </div>

    <div class="control-group hide">
        <?php echo $form->labelEx($modPasienAdmisi, 'dpjp5_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            echo $form->hiddenField($modPasienAdmisi, 'dpjp5_id', array('id' => 'dpjp5_id'));
            $this->widget('MyJuiAutoComplete', array(
                'name' => 'dpjp5',
                'source' => 'js: function(request, response) {
                                $.ajax({
                                url: "' . $this->createUrl('getDokterDPJP') . '",
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
                                 $("#dpjp5_id").val(ui.item.value); 
                                 return false;
                             }',
                ),
                'tombolDialog' => array(
                    'idDialog' => 'dialogDokterDPJP',
                    'jsFunction' => 'admisi_dokter_id = "#dpjp5_id"; admisi_dokter_label = "#dpjp5"; $("#dialogDokterDPJP").dialog("open")',
                ),
                'htmlOptions' => array(
                    "class" => 'span4',
                    'placeholder' => 'DPJP 5'
                ),
            ));
            ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($modPasienAdmisi, 'carabayar_id', array('class' => 'control-label refreshable')) ?>
        <div class="controls">
            <?php
            echo $form->dropDownList($modPasienAdmisi, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                'class' => 'form-control span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                'style' => 'width:170px;',
                // 'onchange' => 'bpjsManual();'
            ));
            ?>
            <?php /*  >> echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>',
                array('class'=>'btn btn-primary','onclick'=>"{addPropinsi(); $('#dialog-addpropinsi').dialog('open');}",
                'id'=>'btn-addpropinsi','onkeyup'=>"return $(this).focusNextInputField(event)",
                'rel'=>'tooltip','title'=>'Klik untuk menambah '.$modPasien->getAttributeLabel('propinsi_id'))) */ ?>
            <?php echo $form->error($modPasienAdmisi, 'carabayar_id'); ?>
        </div>
        <div class="controls cekBPJS hidden">
            <?php echo $form->checkBox($model, 'is_bpjs_manual', array('onclick' => 'bpjsManual()', 'uncheckValue' => null, 'class' => 'permanent')) . "Non Bridging BPJS"; ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($modPasienAdmisi, 'penjamin_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo $form->dropDownList($modPasienAdmisi, 'penjamin_id', empty($model->carabayar_id) ? array() : CHtml::listData($modPasien->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'), array(
                'class' => 'form-control span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                'style' => 'width:170px;'
            ));
            ?>
            <?php echo $form->error($modPasienAdmisi, 'penjamin_id'); ?>
        </div>
    </div>
    <!-- <div class="control-group">
        <?php //echo $form->labelEx($modPasienAdmisi, 'carabayar_id', array('class' => 'control-label refreshable')); 
        ?>
        <div class="controls">
            <?php //echo $form->dropDownList($modPasienAdmisi, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
            //     'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
            //     'ajax' => array(
            //         'type' => 'POST',
            //         'url' => $this->createUrl('SetDropdownPenjaminPasien', array('encode' => false, 'namaModel' => get_class($modPasienAdmisi))),
            //         //                                                        'update'=>'#'.CHtml::activeId($model, 'penjamin_id'),  //DIHIDE KARENA DIGANTIKAN DENGAN 'success'
            //         'success' => 'function(data){$("#' . CHtml::activeId($modPasienAdmisi, "penjamin_id") . '").html(data);setKarcis(); cekPilihSatu($("#' . CHtml::activeId($modPasienAdmisi, "penjamin_id") . '"));}',
            //     ),
            //     'onchange' => 'setFormAsuransi(this.value); cekCaraBayarBadak(this.value);showUmumBpjs(this.value);setKelasTanggunganDrop();',
            //     'class' => 'span4',
            // )); 
            ?>
        </div>
    </div> -->

    <?php //echo $form->dropDownListRow($modPasienAdmisi, 'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onchange' => 'setKarcis(); setNamaAsuransiDariPenjamin(this); setAsuransiBadakAdmisi(this.value); cekValiditasPenjaminAdmisi(this.value); setFormAsuransiInhealth(this.value);', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span4')); 
    ?>
    <?php echo $form->textAreaRow($model, 'keterangan_pendaftaran', array('placeholder' => 'Catatan Khusus Pendaftaran', 'rows' => 2, 'cols' => 50, 'class' => 'span4 ', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    <div class="control-group" style="display:none;" id="isumumbpjs">
        <?php echo CHtml::label("", 'isumumbpjs', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->checkBox($model, 'isumumkebpjs', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            <label><?php echo $model->getAttributeLabel('isumumkebpjs'); ?></label>
        </div>
    </div>
    <!--</fieldset>-->




</div>


<?php
//=============================== Dialog DPJP =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogDokterDPJP',
        'options' => array(
            'title' => 'Dokter PJP',
            'autoOpen' => false,
            'width' => 840,
            'height' => 420,
            'resizable' => true,
        ),
    )
);

$format = new MyFormatter();
$modDPJP = new PegawaiV('search');
$modDPJP->unsetAttributes();
if (isset($_GET['PegawaiV'])) {
    $modDPJP->attributes = $_GET['PegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialog-dpjp-m-grid',
    'dataProvider' => $modDPJP->searchDokter(),
    'filter' => $modDPJP,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::Link('<i class="icon-form-check"></i>', "#", array(
                    "class" => "btn-small",
                    "onclick" => " setDokterAdmisi('" . $data->namaLengkap . "'," . $data->pegawai_id . "); return false; "
                ));
            },
        ),
        array(
            'name' => 'nama_pegawai',
            // 'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//=============================== END DPJP =======================================
?>


<?php
//=============================== Dialog Dokter Umum =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogDokterUmum',
        'options' => array(
            'title' => 'Dokter Penerima',
            'autoOpen' => false,
            'width' => 840,
            'height' => 420,
            'resizable' => true,
        ),
    )
);

$format = new MyFormatter();
$modDokUmum = new PegawaiV('search');
$modDokUmum->unsetAttributes();
if (isset($_GET['PegawaiV'])) {
    $modDokUmum->attributes = $_GET['PegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialog-dokter-umum-m-grid',
    'dataProvider' => $modDokUmum->searchDokter(),
    'filter' => $modDokUmum,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::Link('<i class="icon-form-check"></i>', "#", array(
                    "class" => "btn-small",
                    "onclick" => "
									setDokter('" . $data->namaLengkap . "'," . $data->pegawai_id . ");
                                    return false;
								"
                ));
            },
        ),
        array(
            'name' => 'nama_pegawai',
            //'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//=============================== END Dialog Dokter Umum =======================================
?>

<script>
    var admisi_dokter_id;
    var admisi_dokter_label;

    function setDokterAdmisi(label, value) {
        $(admisi_dokter_id).val(value);
        $(admisi_dokter_label).val(label);
        $("#dialogDokterUmum").dialog("close");
        $("#dialogDokterDPJP").dialog("close");
    }

    function setDokter(label, value) {
        $("#dokterpenerima_id").val(value);
        $("#dokterpenerima").val(label);
        $("#dialogDokterUmum").dialog("close");
        $("#dialogDokterDPJP").dialog("close");
    }
</script>