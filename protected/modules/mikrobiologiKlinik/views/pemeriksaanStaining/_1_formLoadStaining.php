<div class="panel-det-staining" row-rincian-staining="0">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title"> 
                <?php $tambah = CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-plus icon-white"></i>')), array('class' => 'btn btn-green', 'type' => 'button', 'onclick' => 'tambahStaining();return false;')); ?>
                <?php $kurang = CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-minus icon-white"></i>')), array('style' => 'float: right', 'class' => 'btn btn-red', 'type' => 'button', 'onclick' => 'hapusBarisStaining(this); return false;')); ?>

                <b> Data Staining &nbsp;&nbsp;&nbsp;<?= $tambah ?> 
                </b> 
            </div>
        </div>
        <div class="panel-body">
            <?php echo CHtml::hiddenField('id_count', ($i)); ?>
            <?php echo $kurang ?>
            <br>
            <div class="control-group">
                <?php echo CHtml::label('Tanggal', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $modStainingGambar->tanggal_staining = date('d M Y H:i:s');
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modStainingGambar,
                        'attribute' => '[detail][' . $i . ']tanggal_staining',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('class' => 'dtPicker3 span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group" border="1">
                <label class="control-label"> Upload Gambar</label>
                <div class="controls">
                    <?php echo CHtml::activeFileField($modStainingGambar, '[detail][' . $i . ']gambar', array('class' => !empty($modStaining->staining_id) ? 'input-gambar-staining' : 'input-gambar-staining required', 'Hint' => 'Isi Jika Akan Menambahkan Gambar', 'onchange' => 'checkGambarBlood(this);',)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> </label>

                <div class="controls">
                    <?php
                    if (empty($modStainingGambar->temp_file)) {
                        $img = "";
                    } else {
                        if (file_exists(Params::pathDokBloodAgarDirectory() . $modStainingGambar->bloodagar_gambar)) {
                            $img = Params::urlDokBloodAgarDirectory() . $modStainingGambar->bloodagar_gambar;
                        } else {
                            $img = Params::urlDokBloodAgarDirectory() . "no_photo.jpeg";
                        }
                    }
                    ?>
                    <img class='gambar-prev' id="output_<?= ($i + 1) ?>" src="<?= $img ?>" height="200" width="200"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"> Pemeriksaan </label>
                <div class="controls">
                    <?php echo CHtml::hiddenField('no_urut', 0, array('readonly' => true, 'class' => 'span1 integer2',)); ?>
                    <?php
                    echo CHtml::activeHiddenField($modStainingGambar, '[detail][' . $i . ']daftartindakan_id', array('class' => 'daftartindakan_id span3', 'readonly' => true));
                    echo CHtml::activeTextField($modStainingGambar, '[detail][' . $i . ']pemeriksaanlab_nama', array('class' => 'span3', 'readonly' => true));
                    echo CHtml::activeHiddenField($modStainingGambar, '[detail][' . $i . ']status_gambar', array('class' => 'span3 status_gambar', 'readonly' => true));
                    ?>
                </div>
            </div>
            
            <div class="form-pemeriksaannya">
                <?php
                $modStainingDet = new MKStainingdetT();
                $this->renderPartial('_2_formPemeriksaan', array('modStainingGambar' => $modStainingGambar, 'modStainingDet' => $modStainingDet, 'i' => 1, 'j' => 1));
                ?>
            </div>
            
            <div class="col-md-12">
                <div class="control-group">
                    <?php echo CHtml::label("Analis <span class='required'>*</span>", 'manajerpelayanan_id', array('class' => 'control-label')) ?>
                    <div class = "controls">
                        <?php echo CHtml::activeHiddenField($modStainingGambar, '[detail][' . $i . ']analis_id', array('class' => 'span3 required', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modStainingGambar,
                            'attribute' => '[detail][' . $i . ']analis_nama',
                            'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('autoCompleteAnalis') . '",
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
                                'select' => 'js:function( event, ui ) {
                                    $(this).val( ui.item.nama_pegawai );
                                    $("#' . CHtml::activeId($modStainingGambar, 'analis_id') . '").val( ui.item.pegawai_id );
                                    $("#analis_nip").val( ui.item.nomorindukpegawai );
                                    return false;
                                }',
                            ),
                            'htmlOptions' => array('onblur' => 'if(this.value==""){ resetAnalis(this); }','onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'placeholder' => 'Ketikkan Nama Pegawai'),
                            'tombolDialog' => array('idDialog' => 'dialogAnalis', 'idTombol' => 'tombol1','jsFunction' => "setDialogAnalis(this);"),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("NIM / NIP", 'analis_nip', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('analis_nip', $modStainingGambar->analis_nip, array('readonly' => true, 'class' => 'span3 analis_nip', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
            <hr>
            <div class = "col-sm-6">
                <?php if (!empty(Yii::app()->user->getState('ppds_id'))) : ?>
                    <?php
                    $criteria1 = new CDbCriteria();
                    $criteria1->addCondition('ppds_id = ' . Yii::app()->user->getState('ppds_id'));
                    $criteria1->addCondition('ppds_aktif = TRUE');
                    $criteria1->addCondition("verifikasi_status = '" . Params::VERIFIKASI_DISETUJUI . "'");
                    $cekPPDS = PpdsM::model()->find($criteria1);
                    ?>
                    <?php if (!empty($cekPPDS)) : ?>
                        <div class="control-group">
                            <?php echo CHtml::label("PPDS <span class='required'>*</span>", 'manajerpelayanan_id', array('class' => 'control-label')) ?>
                            <div class="controls field-ppds">
                                <?php echo CHtml::activeHiddenField($modStainingGambar, '[detail][' . $i . ']ppds_id', array('class' => 'span3 required', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $modStainingGambar,
                                    'attribute' => '[detail][' . $i . ']ppds_nama',
                                    'source' => 'js: function(request, response) {
                                            $.ajax({
                                                url: "' . $this->createUrl('autoCompletePegawai') . '",
                                                dataType: "json",
                                                data: {
                                                    term: request.term,
                                                    kelompokpegawai_id: ' . Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP . ',
                                                },
                                                success: function (data) {
                                                    response(data);
                                                }
                                            })
                                        }',
                                    'options' => array(
                                        'showAnim' => 'fold',
                                        'minLength' => 3,
                                        'select' => 'js:function( event, ui ) {
                                                $(this).val( ui.item.nama_pegawai );
                                                $("#' . CHtml::activeId($modStaining, '[1]verifikator_id') . '").val( ui.item.pegawai_id );
                                                $("#verifikator_nip").val( ui.item.nomorindukpegawai );
                                                return false;
                                            }',
                                    ),
                                    'htmlOptions' => array(
                                        'onblur' => 'if(this.value==""){ resetPPDSBl(this); }',
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'class' => 'ppds_nama span3 required',
                                        'placeholder' => 'Ketikkan Nama PPDS'),
                                    'tombolDialog' => array('jsFunction' => "setDialogPPDS(this);", 'idDialog' => 'dialogPPDS',),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("NIM / NIP", 'verifikator_nip', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($modStainingGambar, '[detail][' . $i . ']ppds_nim', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (!empty(Yii::app()->user->getState('pegawai_id'))) : ?>
                    <?php
                    $criteria = new CDbCriteria();
                    $criteria->addCondition('pegawai_id = ' . Yii::app()->user->getState('pegawai_id'));
                    $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
                    $criteria->addCondition("kelompokpegawai_id = '" . Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP . "'");
                    $cekDPJTM = PegawairuanganV::model()->find($criteria);
                    ?>
                    <?php if (!empty($cekDPJTM)) : ?>
                        <div class="control-group">
                            <?php echo CHtml::label("PPDS <span class='required'>*</span>", 'manajerpelayanan_id', array('class' => 'control-label')) ?>
                            <div class="controls field-ppds">
                                <?php echo CHtml::activeHiddenField($modStainingGambar, '[detail][' . $i . ']ppds_id', array('class' => 'span3 required', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $modStainingGambar,
                                    'attribute' => '[detail][' . $i . ']ppds_nama',
                                    'source' => 'js: function(request, response) {
                                                        $.ajax({
                                                            url: "' . $this->createUrl('autoCompletePegawai') . '",
                                                            dataType: "json",
                                                            data: {
                                                                term: request.term,
                                                                kelompokpegawai_id: ' . Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP . ',
                                                            },
                                                            success: function (data) {
                                                                response(data);
                                                            }
                                                        })
                                                    }',
                                    'options' => array(
                                        'showAnim' => 'fold',
                                        'minLength' => 3,
                                        'select' => 'js:function( event, ui ) {
                                                            $(this).val( ui.item.nama_pegawai );
                                                            $("#' . CHtml::activeId($modStaining, '[1]verifikator_id') . '").val( ui.item.pegawai_id );
                                                            $("#verifikator_nip").val( ui.item.nomorindukpegawai );
                                                            return false;
                                                        }',
                                    ),
                                    'htmlOptions' => array(
                                        'onblur' => 'if(this.value==""){ resetPPDSBl(this); }',
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'class' => 'ppds_nama span3 required',
                                        'placeholder' => 'Ketikkan Nama PPDS'),
                                    'tombolDialog' => array('jsFunction' => "setDialogPPDS(this);", 'idDialog' => 'dialogPPDS',),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("NIM / NIP", 'verifikator_nip', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($modStainingGambar, '[detail][' . $i . ']ppds_nim', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class = "col-sm-6">
                <?php if (!empty(Yii::app()->user->getState('pegawai_id'))) : ?>
                    <?php
                    $criteria = new CDbCriteria();
                    $criteria->addCondition('pegawai_id = ' . Yii::app()->user->getState('pegawai_id'));
                    $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
                    $criteria->addCondition("kelompokpegawai_id = '" . Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP . "'");
                    $cekDPJTM = PegawairuanganV::model()->find($criteria);
                    ?>
                    <?php if (!empty($cekDPJTM)) : ?>
                        <div class="control-group">
                            <?php echo CHtml::label("DPJTM <span class='required'>*</span>", 'manajerpelayanan_id', array('class' => 'control-label')) ?>
                            <div class = "controls">
                                <?php echo CHtml::activeHiddenField($modStainingGambar, '[detail][' . $i . ']dpjtm_id', array('class' => 'span3 required', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $modStainingGambar,
                                    'attribute' => '[detail][' . $i . ']dpjtm_nama',
                                    'source' => 'js: function(request, response) {
                                            $.ajax({
                                                url: "' . $this->createUrl('autoCompletePegawai') . '",
                                                dataType: "json",
                                                data: {
                                                    term: request.term,
                                                    kelompokpegawai_id: ' . Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP . ',
                                                },
                                                success: function (data) {
                                                    response(data);
                                                }
                                            })
                                        }',
                                    'options' => array(
                                        'showAnim' => 'fold',
                                        'minLength' => 3,
                                        'select' => 'js:function( event, ui ) {
                                                $(this).val( ui.item.nama_pegawai );
                                                $("#' . CHtml::activeId($modStaining, '[1]verifikator_id') . '").val( ui.item.pegawai_id );
                                                $("#verifikator_nip").val( ui.item.nomorindukpegawai );
                                                return false;
                                            }',
                                    ),
                                    'htmlOptions' => array(
                                        'onblur' => 'if(this.value==""){ resetDPJTMBl(this); }',
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'class' => 'span3 required',
                                        'placeholder' => 'Ketikkan Nama Pegawai'),
                                    'tombolDialog' => array('jsFunction' => "setDialogDPJTM(this);", 'idDialog' => 'tombol1'),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("NIM / NIP", 'verifikator_nip', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($modStainingGambar, '[detail][' . $i . ']dpjtm_nip', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        generatePickerStaining();
        setTimeout(function () {
            $(".wysihtml1").wysihtml5();
            formatNumberSemua();
        }, 300);
    });

    /**
     * Generate picker
     * @returns {undefined}
     */
    function generatePickerStaining() {
        var idx = 1;
        $('.panel-det-staining').each(function () {
            console.log($('#MKStainingGambarT_detail_' + idx + '_tanggal_staining').val());
            jQuery('#MKStainingGambarT_detail_' + idx + '_tanggal_staining').datetimepicker(
                jQuery.extend(
                    {showMonthAfterYear: false},
                    jQuery.datepicker.regional['id'], {
                        'dateFormat': 'dd M yy', 
                        'timeText': 'Waktu', 
                        'hourText': 'Jam',
                        'minuteText': 'Menit', 
                        'secondText': 'Detik', 
                        'showSecond': true, 
                        'timeOnlyTitle': 'Pilih   Waktu', 
                        'timeFormat': 'hh:mm:ss', 
                        'changeYear': true, 
                        'changeMonth': true, 
                        'showAnim': 'fold'
                    }
                )
            );
            idx++;
        });
    }
</script>