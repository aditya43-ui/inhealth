<?php

/**
 * view ini digunakan untuk memlilih daftar kendaraan
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
?>
<div class="col-sm-6">
    <!--<div class="control-group">
        <?php // echo CHtml::activeLabel($modPemakaian, 'norekammedis', array('class' => 'control-label')); 
        ?>
        <div class="controls">
            <?php // echo $form->textField($modPemakaian,'norekammedis',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); 
            ?>
        </div>
    </div>-->
    <?php // echo $form->textFieldRow($modPemakaian,'noidentitas',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); 
    ?>
    <?php // echo $form->textFieldRow($modPemakaian,'namapasien',array('class'=>'span3 reqPasien', 'onchange'=>'clearDataPasien();' ,'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); 
    ?>

    <?php echo CHtml::activeHiddenField($modPemakaian, 'pasien_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    <?php echo CHtml::activeHiddenField($modPemakaian, 'pendaftaran_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    <?php echo CHtml::activeHiddenField($modPemakaian, 'pesanambulans_t', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

    <?php echo $form->textFieldRow($modPemakaian, 'tempattujuan', array('placeholder' => 'Tempat Tujuan', 'class' => 'span3 reqPasien', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
    <?php echo $form->textAreaRow($modPemakaian, 'alamattujuan', array('placeholder' => 'Alamat Tujuan', 'class' => 'span3 reqPasien', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modPemakaian, 'longitude', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($modPemakaian, 'longitude', array('placeholder' => 'Longitude', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            <?php echo CHtml::htmlButton(
                '<i class="entypo-search"></i>',
                array(
                    //						  'onclick'=>'$("#dialogLongitudeLatitude").dialog("open");return false;',
                    'class' => 'btn btn-primary',
                    'rel' => "tooltip",
                    'id' => 'yw1',
                    'title' => "Klik untuk mencari Longitude & Latitude",
                )
            ); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($modPemakaian, 'latitude', array('placeholder' => 'Latitude', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
    <?php echo $form->textFieldRow($modPemakaian, 'kelurahan_nama', array('placeholder' => 'Kelurahan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
    <div class="control-group">
        <?php echo $form->labelEx($modPemakaian, 'rt_rw', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($modPemakaian, 'rt', array('placeholder' => 'RT', 'class' => 'span1 numbers-only reqPasien', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 3)); ?> /
            <?php echo $form->textField($modPemakaian, 'rw', array('placeholder' => 'RW', 'class' => 'span1 numbers-only reqPasien', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 3)); ?>
            <?php echo $form->error($modPemakaian, 'rt_rw'); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($modPemakaian, 'nomobile', array('placeholder' => 'No. Handphone', 'class' => 'span3 numbers-only reqPasien', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
    <?php // echo $form->textFieldRow($modPemakaian,'notelepon',array('class'=>'span3 numbers-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); 
    ?>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modPemakaian, 'Penanggung Jawab', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($modPemakaian, 'namapj', array('placeholder' => 'Penanggung Jawab', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        </div>
    </div>
    <?php echo $form->dropDownListRow($modPemakaian, 'hubunganpj', LookupM::getItems('hubungankeluarga'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'empty' => '-- Pilih --')); ?>
    <?php echo $form->textAreaRow($modPemakaian, 'alamatpj', array('placeholder' => 'Alamat Penanggung Jawab', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textAreaRow($modPemakaian, 'untukkeperluan', array('placeholder' => 'Untuk Keperluan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
</div>

<div class="col-sm-6">
    <div class="control-group">
        <?php echo $form->labelEx($modPemakaian, 'supir_id', array('class' => 'control-label')) ?>
        <div class="controls ubah">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modPemakaian,
                'attribute' => 'supir_nama',
                'value' => $modPemakaian->supir_nama,
                'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompleteNamaSupir') . '",
                                                   dataType: "json",
                                                   data: {
                                                       supir_nama: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                'options' => array(
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                                             $(this).val("");
                                             return false;
                                         }',
                    'select' => 'js:function( event, ui ) {
                                            $(this).val(ui.item.value);
                                            $("#AMPemakaianambulansT_supir_id").val(ui.item.pegawai_id);
                                            return false;
                                        }',
                ),
                'tombolDialog' => array('idDialog' => 'dialogSupir'),
                'htmlOptions' => array(
                    'class' => '', 'placeholder' => 'Nama Supir', 'rel' => 'tooltip', 'title' => '"Ketik Nama Supir" / klik icon untuk mencari data supir', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'onblur' => 'if(this.value===""){ $("#' . CHtml::activeId($modPemakaian, 'supir_id') . '").val(""); }'
                ),
            ));
            ?>
            <?php echo $form->error($modPemakaian, 'supir_id'); ?>
            <?php echo $form->hiddenField($modPemakaian, 'supir_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php // echo $form->labelEx($modPemakaian,'pelaksana_id', array('class'=>'control-label')) 
        ?>
        <?php echo CHtml::Label('Pendamping 1', 'Pendamping', array('class' => 'control-label')); ?>
        <div class="controls ubah">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modPemakaian,
                'attribute' => 'pelaksana_nama',
                'value' => $modPemakaian->pelaksana_nama,
                'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompleteNamaSupir') . '",
                                                   dataType: "json",
                                                   data: {
                                                       supir_nama: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                'options' => array(
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                                             $(this).val("");
                                             return false;
                                         }',
                    'select' => 'js:function( event, ui ) {
                                            $(this).val(ui.item.value);
                                            $("#AMPemakaianambulansT_pelaksana_id").val(ui.item.pegawai_id);
                                            return false;
                                        }',
                ),
                'tombolDialog' => array('idDialog' => 'dialogPelaksana'),
                'htmlOptions' => array(
                    'placeholder' => 'Nama Pendamping', 'rel' => 'tooltip', 'title' => '"Ketik Nama Pendamping" / klik icon untuk mencari data pendamping', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'onblur' => 'if(this.value === ""){ $("#' . CHtml::activeId($modPemakaian, 'pelaksana_id') . '").val(""); }'
                ),
            ));
            ?>
            <?php echo $form->error($modPemakaian, 'pelaksana_id'); ?>
            <?php echo $form->hiddenField($modPemakaian, 'pelaksana_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php // echo $form->labelEx($modPemakaian,'pelaksana_id', array('class'=>'control-label')) 
        ?>
        <?php echo CHtml::Label('Dokter Pendamping', 'Dokter Pendamping', array('class' => 'control-label')); ?>
        <div class="controls ubah">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modPemakaian,
                'attribute' => 'pendampingdokter_nama',
                'value' => $modPemakaian->pendampingdokter_nama,
                'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompleteDokter') . '",
                                                   dataType: "json",
                                                   data: {
                                                       supir_nama: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                'options' => array(
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                                             $(this).val("");
                                             return false;
                                         }',
                    'select' => 'js:function( event, ui ) {
                                            $(this).val(ui.item.value);
                                            $("#AMPemakaianambulansT_dokterpendampingambulance_id").val(ui.item.pegawai_id);
                                            return false;
                                        }',
                ),
                'tombolDialog' => array('idDialog' => 'dialogDokPendamping'),
                'htmlOptions' => array(
                    'placeholder' => 'Nama Dokter Pendamping', 'rel' => 'tooltip', 'title' => '"Ketik Nama Dokter Pendamping" / klik icon untuk mencari data dokter pendamping', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'onblur' => 'if(this.value === ""){ $("#' . CHtml::activeId($modPemakaian, 'dokterpendampingambulance_id') . '").val(""); }'
                ),
            ));
            ?>
            <?php echo $form->error($modPemakaian, 'dokterpendampingambulance_id'); ?>
            <?php echo $form->hiddenField($modPemakaian, 'dokterpendampingambulance_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php // echo $form->labelEx($modPemakaian,'paramedis1_id', array('class'=>'control-label')) 
        ?>
        <?php echo CHtml::Label('Dokter', 'Dokter', array('class' => 'control-label')); ?>
        <div class="controls ubah">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modPemakaian,
                'attribute' => 'paramedis1_nama',
                'value' => $modPemakaian->paramedis1_nama,
                'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompleteDokter') . '",
                                                   dataType: "json",
                                                   data: {
                                                       paramedis_nama: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                'options' => array(
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                    'select' => 'js:function( event, ui ) {
                                            $(this).val( ui.item.value);
                                            $("#AMPemakaianambulansT_paramedis1_id").val(ui.item.pegawai_id);
                                            return false;
                                        }',
                ),
                'tombolDialog' => array('idDialog' => 'dialogParamedis1'),
                'htmlOptions' => array(
                    'placeholder' => 'Nama Dokter', 'rel' => 'tooltip', 'title' => 'Ketik nama dokter / klik icon untuk mencari data dokter',
                    'onkeyup' => "return $(this).focusNextInputField(event)",
                    'onblur' => 'if(this.value===""){ $("#' . CHtml::activeId($modPemakaian, 'paramedis1_id') . '").val(""); }',
                ),
            ));

            ?>
            <?php echo $form->error($modPemakaian, 'paramedis1_id'); ?>
            <?php echo $form->hiddenField($modPemakaian, 'paramedis1_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php // echo $form->labelEx($modPemakaian,'paramedis2_id', array('class'=>'control-label')) 
        ?>
        <?php echo CHtml::Label('Pendamping 2', 'Paramedis', array('class' => 'control-label')); ?>
        <div class="controls ubah">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modPemakaian,
                'attribute' => 'paramedis2_nama',
                'value' => $modPemakaian->paramedis2_nama,
                'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompleteParamedis') . '",
                                                   dataType: "json",
                                                   data: {
                                                       paramedis_nama: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                'options' => array(
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                                             $(this).val("");
                                             return false;
                                         }',
                    'select' => 'js:function( event, ui ) {
                                            $(this).val(ui.item.value);
                                            $("#AMPemakaianambulansT_paramedis2_id").val(ui.item.pegawai_id);
                                            return false;
                                        }',
                ),
                'tombolDialog' => array('idDialog' => 'dialogParamedis2'),
                'htmlOptions' => array(
                    'placeholder' => 'Nama Paramedis', 'rel' => 'tooltip', 'title' => '"Ketik Nama Paramedis", untuk mencari nama paramedis', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'onblur' => 'if(this.value === "") { $("#' . CHtml::activeId($modPemakaian, 'paramedis2_id') . '").val(""); } '
                ),
            ));
            ?>
            <?php echo $form->error($modPemakaian, 'paramedis2_id'); ?>
            <?php echo $form->hiddenField($modPemakaian, 'paramedis2_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modPemakaian, 'Tanggal Pemakaian', array('class' => 'control-label')); ?>
        <div class="controls ">
            <?php $modPemakaian->tglpemakaianambulans = $format->formatDateTimeForUser($modPemakaian->tglpemakaianambulans); ?>
            <?php $this->widget('MyDateTimePicker', array(
                'model' => $modPemakaian,
                'attribute' => 'tglpemakaianambulans',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    //'minDate' => 'd',
                ),
                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2-5'),
            ));
            ?>
        </div>
    </div>
    <div class="control-group " hidden>
        <?php echo CHtml::activeLabel($modPemakaian, 'Tanggal Kembali', array('class' => 'control-label')); ?>
        <div class="controls ubah">
            <?php $this->widget('MyDateTimePicker', array(
                'model' => $modPemakaian,
                'attribute' => 'tglkembaliambulans',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'minDate' => 'd',
                ),
                'htmlOptions' => array('readonly' => false, 'class' => 'dtPicker2-5'),
            ));
            ?>
        </div>
    </div>

</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::activeLabel($modPemakaian, 'Ruangan <span style=color:red>*</span>', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::dropDownList(
                'instalasi',
                $instalasi,
                CHtml::listData($modInstalasi, 'instalasi_id', 'instalasi_nama'),
                array(
                    'empty' => '-- Instalasi --',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' =>  CController::createUrl('dynamicRuangan'),
                        'update' => '#AMPemakaianambulansT_ruangan_id',
                    ), 'class' => 'span2'
                )
            ); ?>
            <?php echo CHtml::activeDropDownList($modPemakaian, 'ruangan_id',  CHtml::listData(RuanganM::model()->getRuanganByInstalasi($instalasi), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Ruangan --', 'class' => 'span2')); ?>
        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="fas fa-ambulance"></i> Kendaraan
            </div>
        </div>
        <div class="panel-body">
            <div class="control-group">
                <?php echo $form->labelEx($modPemakaian, 'mobilambulans_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $modPemakaian,
                        'attribute' => 'mobilambulans_nama',
                        'value' => $modPemakaian->mobilambulans_nama,
                        'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('AutocompleteKendaraan') . '",
                                dataType: "json",
                                data: {
                                    mobilambulans_kode: request.term,
                                },
                                success: function (data) {
                                        response(data);
                                }
                            })
                        }',
                        'options' => array(
                            'minLength' => 3,
                            'focus' => 'js:function( event, ui ) {
                                        $(this).val( "");
                                        return false;
                                    }',
                            'select' => 'js:function( event, ui ) {
                                    //$(this).val( ui.item.label);
                                    //$("#AMPemakaianambulansT_mobilambulans_id").val(ui.item.mobilambulans_id);
                                    //$("#AMPemakaianambulansT_tipekendaraan").val(ui.item.tipekendaraan);
                                    inputKendaraan(ui.item.mobilambulans_id,ui.item.nopolisi,ui.item.jeniskendaraan,ui.item.mobilambulans_kode,ui.item.kmterakhirkend,ui.item.isibbmliter,ui.item.tipekendaraan);
                                    return false;
                                }',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogKendaraan'),
                        'htmlOptions' => array(
                            'placeholder' => 'kode kendaraan', 'class' => 'span3 all-caps', 'rel' => 'tooltip', 'title' => 'Ketik kode kendaraan / klik icon untuk mencari data kendaraan',
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'onblur' => 'if(this.value === "") { $("#' . CHtml::activeId($modPemakaian, 'mobilambulans_id') . '").val("") }',
                        ),
                    ));

                    ?>
                    <?php echo $form->error($modPemakaian, 'mobilambulans_id'); ?>
                    <?php echo $form->hiddenField($modPemakaian, 'mobilambulans_id', array('readonly' => true, 'class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                </div>

            </div>
            <?php /*
            <div class="control-group">
                <?php echo CHtml::label("Tipe Kendaraan", 'tipekendaraan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->hiddenField($modPemakaian,'jeniskendaraan',array('readonly' => true)); ?>
                    <?php echo $form->textField($modPemakaian,'tipekendaraan',array('readonly' => true)); ?>
                </div>
            </div>
             * 
             */ ?>
            <div class="control-group">
                <?php echo $form->labelEx($modPemakaian, 'kmawal', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modPemakaian, 'kmawal', array('placeholder' => '00', 'readonly' => false, 'class' => 'span1 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->error($modPemakaian, 'kmawal'); ?> <span style="font-size:11px;"><?php // echo $modPemakaian->getAttributeLabel('kmakhir'); 
                                                                                                        ?></span>
                    <?php // echo $form->textField($modPemakaian,'kmakhir',array('class'=>'span1 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php // echo $form->error($modPemakaian, 'kmakhir'); 
                    ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($modPemakaian, 'jmlbbmliter', array('placeholder' => '00', 'class' => 'span1 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
<?php
$this->widget('ext.LocationPicker2.CoordinatePicker', array(
    'model' => $modPemakaian,
    'latitudeAttribute' => 'latitude',
    'longitudeAttribute' => 'longitude',
    //optional settings
    'editZoom' => 12,
    'pickZoom' => 7,
    'defaultLatitude' => $latitude,
    'defaultLongitude' => $longitude,
));
?>