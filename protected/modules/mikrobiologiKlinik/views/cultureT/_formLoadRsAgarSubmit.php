<?php $check = false; ?>
<div class="clear"> </div>
<div class="panel-det-rs" row-rincian-rs="0">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title"> 
                <?php $tambah = CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-plus icon-white"></i>')), array('class' => 'btn btn-green', 'type' => 'button', 'onclick' => 'tambahRs(this);return false;')); ?>
                <b> Data Brucella Agar <?= $tambah ?> </b>
            </div>
            <span style="float:right; padding: 10px">
                <?php echo CHtml::activeCheckBox($modBrucella, '[detail][' . $i . ']pilih', array('class' => 'pilihcheck', 'onclick' => 'cekverifikasi_brucella(this);')) ?>
            </span>
        </div>
        <div class="panel-body">
            <div class="control-group">
                <?php echo CHtml::label('Tanggal', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modBrucella,
                        'attribute' => '[detail][' . $i . ']tanggal',
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
            <div class="control-group">
                <?php echo CHtml::label("Brucella Agar ", '', array('class' => 'control-label')) ?>
                <div class = "controls">
                    <?php echo CHtml::activeHiddenField($modBrucella, '[detail][' . $i . ']rosella_agar_id'); ?>
                    <?php echo CHtml::activeDropDownList($modBrucella, '[detail][' . $i . ']rosella_agar', LookupM::getItems('culture'), array('empty' => '-- Pilih Brucella Agar --', 'class' => 'span3')); ?>
                    <?php // echo CHtml::activeDropDownList($modBrucella, '[detail]['.$i.']rosella_agar_morfologi', LookupM::getItems('culture_morfologi'), array('empty'=>'-- Pilih Brucella Agar Morfologi --','class'=>'span3')); ?>
                </div>
                <div class="controls" style="text-align: right;float:right;">
                    <?php echo CHtml::link('<i class="glyphicon glyphicon-minus"></i>', "javascript:;", array('class' => 'btn btn-red', 'style' => 'margin-right: 50px;', 'onclick' => 'hapusDataRs(this);')); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Status Plate", 'status_plate', array('class' => 'control-label')) ?>
                <div class = "controls">
                    <?php echo CHtml::activeTextField($modBrucella, '[detail][' . $i . ']status_plate', array('class' => 'span3')); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Upload Gambar", '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div style="max-width:100%;overflow-x: scroll;">
                        <table>
                            <tbody id="tab_rs" class="tab_rs"> 
                                <?php
                                $new = new RosellaagarGambarT();
                                $modBrucellaGambar = RosellaagarGambarT::model()->findAllByAttributes(array('rosella_agar_id' => $modBrucella->rosella_agar_id));
                                if (!empty($modBrucellaGambar)) {
                                    foreach ($modBrucellaGambar as $modRs) {
                                        $modRs->temp_file = $modRs->rosellaagar_gambar;
                                        echo $this->renderPartial('_formLoadRsAgarDet', array(
                                            'modBrucellaGambar' => $modRs,
                                            'idx' => 0,
                                            'i' => 0,
                                                ), true);
                                    }
                                } else {
                                    echo $this->renderPartial('_formLoadRsAgarDet', array(
                                        'modBrucellaGambar' => $new,
                                        'idx' => 0,
                                        'i' => 0,
                                            ), true);
                                }
                                ?>
                            </tbody> 
                        </table>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Keterangan ", '', array('class' => 'control-label')) ?>
                <div class = "controls">
                    <?php echo CHtml::activeTextArea($modBrucella, '[detail][' . $i . ']keterangan', array('class' => 'span6 wysihtml1', 'placeholder' => 'Tambahkan Keterangan Brucella Agar')); ?>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="control-group">
                        <?php echo CHtml::label('Analis', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $modBrucella->analis_nama = !empty($modBrucella->analis->nama_pegawai) ? $modBrucella->analis->nama_pegawai : '';
                            $modBrucella->analis_nip = !empty($modBrucella->analis->nomorindukpegawai) ? $modBrucella->analis->nomorindukpegawai : '';
                            echo CHtml::activeHiddenField($modBrucella, '[detail][' . $i . ']analis_id', array('readonly' => true, 'class' => 'required'));

                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $modBrucella,
                                'attribute' => '[detail][1]analis_nama',
                                'source' => 'js: function(request, response) {
                                                    $.ajax({
                                                    url: "' . $this->createUrl('/ActionAutoComplete/getAnalis') . '",
                                                    dataType: "json",
                                                    data: {
                                                        term: request.term,
                                                        ruangan_id: ' . Yii::app()->user->getState('ruangan_id') . '
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
                                            return false;
                                        }',
                                    'select' => 'js:function( event, ui ) { 
                                            setAnalisAuto($(this), ui.item);
                                            return false;
                                        }',
                                ),
                                'htmlOptions' => array(
                                    'onblur' => 'if(this.value==""){ resetAnalisRs(this); }',
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'class' => 'hurufs-only span3 analis_nama',
                                    'placeholder' => 'Ketik Nama Analis'
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogAnalisRs', 'jsFunction' => "setDialogAnalisRs(this);"),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('NIP', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modBrucella, '[detail][' . $i . ']analis_nip', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <?php if(!empty(Yii::app()->user->getState('ppds_id'))) : ?>
                        <?php 
                        $criteria1 = new CDbCriteria();
                        $criteria1->addCondition('ppds_id = '.Yii::app()->user->getState('ppds_id'));
                        $criteria1->addCondition('ppds_aktif = TRUE');
                        $criteria1->addCondition("verifikasi_status = '" . Params::VERIFIKASI_DISETUJUI . "'");
                        $cekPPDS = PpdsM::model()->find($criteria1);
                        ?>
                        <?php if(!empty($cekPPDS)) : ?>
                            <div class="control-group">
                                <?php echo CHtml::label('PPDS', '', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    $modBrucella->ppds_nama = !empty($modBrucella->ppds->ppds_nama) ? $modBrucella->ppds->ppds_nama : '';
                                    if (!empty($modBrucella->tgl_verifikasi_ppds)) {
                                        echo CHtml::activeTextField($modBrucella, '[detail][' . $i . ']ppds_nama', array('class' => 'span3 ppds_nama', 'readonly' => true));
                                    } else {
                                        $this->widget('MyJuiAutoComplete', array(
                                            'model' => $modBrucella,
                                            'attribute' => '[detail][1]ppds_nama',
                                            'source' => 'js: function(request, response) {
                                                        $.ajax({
                                                            url: "' . Yii::app()->createUrl('ActionAutoComplete/getPPDSPelayanan') . '",
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
                                                        return false;
                                                    }',
                                                'select' => 'js:function( event, ui ) { 
                                                        setPegAuto($(this), ui.item);
                                                        return false;
                                                    }',
                                            ),
                                            'htmlOptions' => array(
                                                'onblur' => 'if(this.value==""){ resetPPDSRs(this); }',
                                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                                'class' => 'hurufs-only span3 ppds_nama',
                                                'placeholder' => 'Ketik Nama PPDS'
                                            ),
                                            'tombolDialog' => array('idDialog' => 'dialogPpdsRs', 'jsFunction' => "setDialogRs(this);"),
                                        ));
                                    }
                                    echo CHtml::activeHiddenField($modBrucella, '[detail][' . $i . ']ppds_id', array('class' => 'span3 ppds_id', 'readonly' => true));
                                    ?>
                                </div>
                                <div class="control-label" style="width: 140px;">
                                    <?php
                                    if (!empty($modBrucella->tgl_verifikasi_ppds)) {
                                        echo '<span class="required"><i>Sudah Diverifikasi PPDS</i></span>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label('NIM/NIP', '', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    $modBrucella->ppds_nim = !empty($modBrucella->ppds->ppds_nim) ? $modBrucella->ppds->ppds_nim : '';
                                    echo CHtml::activeTextField($modBrucella, '[detail][' . $i . ']ppds_nim', array('class' => 'span3', 'readonly' => true));
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if(!empty(Yii::app()->user->getState('pegawai_id'))) : ?>
                        <?php 
                        $criteria = new CDbCriteria();
                        $criteria->addCondition('pegawai_id = '.Yii::app()->user->getState('pegawai_id'));
                        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
                        $criteria->addCondition("kelompokpegawai_id = '" . Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP . "'");
                        $cekDPJTM = PegawairuanganV::model()->find($criteria);
                        ?>
                        <?php if(!empty($cekDPJTM)) : ?>
                            <div class="control-group">
                                <?php echo CHtml::label('PPDS', '', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    $modBrucella->ppds_nama = !empty($modBrucella->ppds->ppds_nama) ? $modBrucella->ppds->ppds_nama : '';
                                    if (!empty($modBrucella->tgl_verifikasi_ppds)) {
                                        echo CHtml::activeTextField($modBrucella, '[detail][' . $i . ']ppds_nama', array('class' => 'span3 ppds_nama', 'readonly' => true));
                                    } else {
                                        $this->widget('MyJuiAutoComplete', array(
                                            'model' => $modBrucella,
                                            'attribute' => '[detail][1]ppds_nama',
                                            'source' => 'js: function(request, response) {
                                                        $.ajax({
                                                            url: "' . Yii::app()->createUrl('ActionAutoComplete/getPPDSPelayanan') . '",
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
                                                        return false;
                                                    }',
                                                'select' => 'js:function( event, ui ) { 
                                                        setPegAuto($(this), ui.item);
                                                        return false;
                                                    }',
                                            ),
                                            'htmlOptions' => array(
                                                'onblur' => 'if(this.value==""){ resetPPDSRs(this); }',
                                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                                'class' => 'hurufs-only span3 ppds_nama',
                                                'placeholder' => 'Ketik Nama PPDS'
                                            ),
                                            'tombolDialog' => array('idDialog' => 'dialogPpdsRs', 'jsFunction' => "setDialogRs(this);"),
                                        ));
                                    }
                                    echo CHtml::activeHiddenField($modBrucella, '[detail][' . $i . ']ppds_id', array('class' => 'span3 ppds_id', 'readonly' => true));
                                    ?>
                                </div>
                                <div class="control-label" style="width: 140px;">
                                    <?php
                                    if (!empty($modBrucella->tgl_verifikasi_ppds)) {
                                        echo '<span class="required"><i>Sudah Diverifikasi PPDS</i></span>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label('NIM/NIP', '', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    $modBrucella->ppds_nim = !empty($modBrucella->ppds->ppds_nim) ? $modBrucella->ppds->ppds_nim : '';
                                    echo CHtml::activeTextField($modBrucella, '[detail][' . $i . ']ppds_nim', array('class' => 'span3', 'readonly' => true));
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <?php if(!empty(Yii::app()->user->getState('pegawai_id'))) : ?>
                        <?php 
                        $criteria = new CDbCriteria();
                        $criteria->addCondition('pegawai_id = '.Yii::app()->user->getState('pegawai_id'));
                        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
                        $criteria->addCondition("kelompokpegawai_id = '" . Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP . "'");
                        $cekDPJTM = PegawairuanganV::model()->find($criteria);
                        ?>
                        <?php if(!empty($cekDPJTM)) : ?>
                            <div class="control-group">
                                <?php echo CHtml::label('DPJTM', '', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    $modBrucella->dpjtm_nama = !empty($modBrucella->dpjtm->nama_pegawai) ? $modBrucella->dpjtm->nama_pegawai : '';
                                    if (!empty($modBrucella->tgl_verifikasi_dpjtm)) {
                                        echo CHtml::activeTextField($modBrucella, '[detail][' . $i . ']dpjtm_nama', array('class' => 'span3 dpjtm_nama', 'readonly' => true));
                                    } else {
                                        $this->widget('MyJuiAutoComplete', array(
                                            'model' => $modBrucella,
                                            'attribute' => '[detail][1]dpjtm_nama',
                                            'source' => 'js: function(request, response) {
                                                        $.ajax({
                                                            url: "' . Yii::app()->createUrl('ActionAutoComplete/getDPJTM') . '",
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
                                                        return false;
                                                    }',
                                                'select' => 'js:function( event, ui ) { 
                                                        setPegAuto($(this), ui.item);
                                                        return false;
                                                    }',
                                            ),
                                            'htmlOptions' => array(
                                                'onblur' => 'if(this.value==""){ resetDPJTMRs(this); }',
                                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                                'class' => 'hurufs-only span3 dpjtm_nama',
                                                'placeholder' => 'Ketik Nama DPJTM'
                                            ),
                                            'tombolDialog' => array('idDialog' => 'dialogVerifikatorRs', 'jsFunction' => "setDialogRs2(this);"),
                                        ));
                                    }
                                    echo CHtml::activeHiddenField($modBrucella, '[detail][' . $i . ']dpjtm_id', array('class' => 'span3 dpjtm_id', 'readonly' => true));
                                    ?>
                                </div>
                                <div class="control-label" style="width: 140px;">
                                    <?php
                                    if (!empty($modBrucella->tgl_verifikasi_dpjtm)) {
                                        echo '<span class="required"><i>Sudah Diverifikasi DPJTM</i></span>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label('NIM/NIP', '', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    $modBrucella->dpjtm_nip = !empty($modBrucella->dpjtm->nomorindukpegawai) ? $modBrucella->dpjtm->nomorindukpegawai : '';
                                    echo CHtml::activeTextField($modBrucella, '[detail][' . $i . ']dpjtm_nip', array('class' => 'span3', 'readonly' => true));
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clear"> </div>
<script>
    $(document).ready(function () {
        generatePickerRs();
        setTimeout(function () {
            $(".wysihtml1").wysihtml5();
            formatNumberSemua();
        }, 300);
    });

    /**
     * Membuka dialog analis dan set no_row
     * @param {type} obj
     * @returns {undefined}
     */
    function setDialogAnalisRs(obj) {
        var no = $(obj).parents(".panel-det-rs").attr('row-rincian-rs');
        var row = $("#no_row").val(no);
        $("#dialogAnalisRs").dialog("open");
    }

    /**
     * Mencari data ppds berdasarkan analis_id yang dipilih melalui ajax. jika ditemukan maka set analis
     * @param {type} id
     * @returns {undefined}
     */
    function setAnalisRs(id) {
        var dialog = "#dialogAnalisRs";
        var no = $("#no_row").val();
        parent = $(dialog).attr("parent-dialog");
        obj = $("#" + parent);

        $.get('<?php echo $this->createUrl('GetAnalis'); ?>', {analis_id: id}, function (data) {
            $(".panel-det-rs").each(function () {
                if ($(this).attr('row-rincian-rs') == no) {
                    setPegAnalisRs($(this).find('input[name$="[analis_id]"]'), data[0]);
                }
            });
        }, "json");

        $(dialog).dialog("close");
    }

    /**
     * Set data analis 
     * @param {type} obj
     * @param {type} item
     * @returns {undefined}
     */
    function setPegAnalisRs(obj, item) {
        $(obj).parents(".panel-det-rs").find('input[name$="[analis_id]"]').val(item.pegawai_id);
        $(obj).parents(".panel-det-rs").find('input[name$="[analis_nama]"]').val(item.nama_pegawai);
        $(obj).parents(".panel-det-rs").find('input[name$="[analis_nip]"]').val(item.nomorindukpegawai);
    }

    /**
     * Reset field Analis
     * @param {type} obj
     * @returns {undefined}
     */
    function resetAnalisRs(obj) {
        var no = $(obj).parents(".panel-det-rs").attr('row-rincian-rs');
        var row = $("#no_row").val(no);
        $(".panel-det-rs").each(function () {
            if ($(this).attr('row-rincian-rs') == no) {
                $(this).find('input[name$="[analis_id]"]').val("");
                $(this).find('input[name$="[analis_nama]"]').val("");
                $(this).find('input[name$="[analis_nip]"]').val("");
            }
        });
    }

    /**
     * Membuka dialog dan set no_row
     * @param {type} obj
     * @returns {undefined}
     */
    function setDialogRs(obj) {
        var no = $(obj).parents(".panel-det-rs").attr('row-rincian-rs');
        var row = $("#no_row").val(no);
        $("#dialogPpdsRs").dialog("open");
    }

    /**
     * Mencari data ppds berdasarkan ppds_id yang dipilih melalui ajax. jika ditemukan maka set ppds
     * @param {type} id
     * @returns {undefined}
     */
    function setPpdsDialogRs(id) {
        var dialog = "#dialogPpdsRs";
        var no = $("#no_row").val();
        parent = $(dialog).attr("parent-dialog");
        obj = $("#" + parent);

        $.get('<?php echo $this->createUrl('GetPpds'); ?>', {ppds_id: id}, function (data) {
            $(".panel-det-rs").each(function () {
                if ($(this).attr('row-rincian-rs') == no) {
                    setPegPPDSRs($(this).find('input[name$="[ppds_id]"]'), data[0]);
                }
            });
        }, "json");

        $(dialog).dialog("close");
    }

    /**
     * Set data ppds 
     * @param {type} obj
     * @param {type} item
     * @returns {undefined}
     */
    function setPegPPDSRs(obj, item) {
        $(obj).parents(".panel-det-rs").find('input[name$="[ppds_id]"]').val(item.ppds_id);
        $(obj).parents(".panel-det-rs").find('input[name$="[ppds_nama]"]').val(item.ppds_nama);
        $(obj).parents(".panel-det-rs").find('input[name$="[ppds_nim]"]').val(item.ppds_nim);
    }

    /**
     * Reset field PPDS
     * @param {type} obj
     * @returns {undefined}
     */
    function resetPPDSRs(obj) {
        var no = $(obj).parents(".panel-det-rs").attr('row-rincian-rs');
        var row = $("#no_row").val(no);
        $(".panel-det-rs").each(function () {
            if ($(this).attr('row-rincian-rs') == no) {
                $(this).find('input[name$="[ppds_id]"]').val("");
                $(this).find('input[name$="[ppds_nama]"]').val("");
                $(this).find('input[name$="[ppds_nim]"]').val("");
            }
        });
    }

    /**
     * Membuka dialog dan set no_row
     * @param {type} obj
     * @returns {undefined}
     */
    function setDialogRs2(obj) {
        var no = $(obj).parents(".panel-det-rs").attr('row-rincian-rs');
        var row = $("#no_row").val(no);
        $("#dialogVerifikatorRs").dialog("open");
    }

    /**
     * Mencari data ppds berdasarkan pegawai_id yang dipilih melalui ajax. jika ditemukan maka set dpjtm
     * @param {type} id
     * @returns {undefined}
     */
    function setDpjtmDialogRs(id) {
        var dialog = "#dialogVerifikatorRs";
        var no = $("#no_row").val();
        parent = $(dialog).attr("parent-dialog");
        obj = $("#" + parent);

        $.get('<?php echo $this->createUrl('GetDpjtm'); ?>', {pegawai_id: id}, function (data) {
            $(".panel-det-rs").each(function () {
                if ($(this).attr('row-rincian-rs') == no) {
                    setPegDPJTMRs($(this).find('input[name$="[dpjtm_id]"]'), data[0]);
                }
            });
        }, "json");

        $(dialog).dialog("close");
    }

    /**
     * Set data ppds 
     * @param {type} obj
     * @param {type} item
     * @returns {undefined}
     */
    function setPegDPJTMRs(obj, item) {
        $(obj).parents(".panel-det-rs").find('input[name$="[dpjtm_id]"]').val(item.pegawai_id);
        $(obj).parents(".panel-det-rs").find('input[name$="[dpjtm_nama]"]').val(item.nama_pegawai);
        $(obj).parents(".panel-det-rs").find('input[name$="[dpjtm_nip]"]').val(item.nomorindukpegawai);
    }

    /**
     * Menghapus field DPJTM 
     * @param {type} obj
     * @returns {undefined}
     */
    function resetDPJTMRs(obj) {
        var no = $(obj).parents(".panel-det-rs").attr('row-rincian-rs');
        var row = $("#no_row").val(no);
        $(".panel-det-rs").each(function () {
            if ($(this).attr('row-rincian-rs') == no) {
                $(this).find('input[name$="[dpjtm_id]"]').val("");
                $(this).find('input[name$="[dpjtm_nama]"]').val("");
                $(this).find('input[name$="[dpjtm_nip]"]').val("");
            }
        });
    }


    /**
     * Generate picker
     * @returns {undefined}
     */
    function generatePickerRs() {
        var idx = 0;
        $('.panel-det-rs').each(function () {
            jQuery('#RosellaAgarT_detail_'+ idx +'_tanggal').datetimepicker(
                jQuery.extend({showMonthAfterYear: false},
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

            jQuery('input[name$="[analis_nama]"]').autocomplete({
                'showAnim': 'fold',
                'minLength': 3,
                'focus': function (event, ui) {
                    $(this).val(ui.item.nama_pegawai);
                    return false;
                },
                'select': function (event, ui) {
                    setPegAnalisRs($(this), ui.item);
                    return false;
                },
                'source': function (request, response) {
                    $.ajax({
                        url: "<?php echo Yii::app()->createUrl('ActionAutoComplete/getAnalis'); ?>",
                        dataType: "json",
                        data: {
                            term: request.term,
                        },
                        success: function (data) {
                            response(data);
                        }
                    })
                }
            });

            jQuery('input[name$="[ppds_nama]"]').autocomplete({
                'showAnim': 'fold',
                'minLength': 3,
                'focus': function (event, ui) {
                    $(this).val(ui.item.ppds_nama);
                    return false;
                },
                'select': function (event, ui) {
                    setPegPPDSRs($(this), ui.item);
                    return false;
                },
                'source': function (request, response) {
                    $.ajax({
                        url: "<?php echo Yii::app()->createUrl('ActionAutoComplete/getPPDSPelayanan'); ?>",
                        dataType: "json",
                        data: {
                            term: request.term,
                        },
                        success: function (data) {
                            response(data);
                        }
                    })
                }
            });

            jQuery('input[name$="[dpjtm_nama]"]').autocomplete({
                'showAnim': 'fold',
                'minLength': 3,
                'focus': function (event, ui) {
                    $(this).val(ui.item.nama_pegawai);
                    return false;
                },
                'select': function (event, ui) {
                    setPegDPJTMRs($(this), ui.item);
                    return false;
                },
                'source': function (request, response) {
                    $.ajax({
                        url: "<?php echo Yii::app()->createUrl('ActionAutoComplete/getDPJTM'); ?>",
                        dataType: "json",
                        data: {
                            term: request.term,
                        },
                        success: function (data) {
                            response(data);
                        }
                    })
                }
            });
        });
    }
</script>