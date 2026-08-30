<?php $check = false; ?>
<div class="clear"> </div>
<div id="panel-det-thigli" class="panel-det-thigli" row-rincian-thigli="0">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title"> 
                <?php $tambah = CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-plus icon-white"></i>')), array('class' => 'btn btn-green', 'type' => 'button', 'onclick' => 'tambahThigli(this);return false;')); ?>
                <b> Data Thioglikolat Broth  <?= $tambah ?> </b> 
            </div>
            <span style="float:right; padding: 10px">
                <?php // echo CHtml::activeCheckBox($modThigli, '[detail]['.$i.']pilih', array('class' => 'pilihcheck', 'onclick'=>'cekverifikasi_thigli(this);')) ?>
            </span>
        </div>
        <div class="panel-body">
            <div class="control-group">
                <?php echo CHtml::label('Tanggal', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modThigli,
                        'attribute' => '[detail]['.$i.']tanggal_thiglikolatbroth',
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
                <?php echo CHtml::label("Thioglikolat Broth ", 'manajerpelayanan_id', array('class' => 'control-label')) ?>
                <div class = "controls">
                    <?php echo CHtml::activeHiddenField($modThigli, '[detail][' . $i . ']thiglikolatbroth_id'); ?>
                    <?php echo CHtml::activeDropDownList($modThigli, '[detail][' . $i . ']thiglikolatbroth', LookupM::getItems('culture'), array('empty' => '-- Pilih Thioglikolat Broth --', 'class' => 'span3')); ?>
                </div>
                <div class="controls" style="text-align: right;float:right;">
                    <?php echo CHtml::link('<i class="glyphicon glyphicon-minus"></i>', "javascript:;", array('class' => 'btn btn-red', 'style' => 'margin-right: 50px;', 'onclick' => 'hapusDataThigli(this);')); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clear"> </div>
<script>
    $( document ).ready(function(){
        generatePickerThigli();
    });
    
    /**
     * Membuka dialog analis dan set no_row
     * @param {type} obj
     * @returns {undefined}
     */
    function setDialogAnalisTg(obj) {
        var no = $(obj).parents(".panel-det-thigli").attr('row-rincian-thigli');
        var row = $("#no_row").val(no);
        $("#dialogAnalisTg").dialog("open");
    }

    /**
     * Mencari data ppds berdasarkan analis_id yang dipilih melalui ajax. jika ditemukan maka set analis
     * @param {type} id
     * @returns {undefined}
     */
    function setAnalisTg(id) {
        var dialog = "#dialogAnalisTg";
        var no = $("#no_row").val();
        parent = $(dialog).attr("parent-dialog");
        obj = $("#" + parent);
        
        $.get('<?php echo $this->createUrl('GetAnalis'); ?>', {analis_id: id}, function (data) {
            $(".panel-det-thigli").each(function () {
                if ($(this).attr('row-rincian-thigli') == no) {
                    setPegAnalisTg($(this).find('input[name$="[analis_id]"]'), data[0]);
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
    function setPegAnalisTg(obj, item) {
        $(obj).parents(".panel-det-thigli").find('input[name$="[analis_id]"]').val(item.pegawai_id);
        $(obj).parents(".panel-det-thigli").find('input[name$="[analis_nama]"]').val(item.nama_pegawai);
        $(obj).parents(".panel-det-thigli").find('input[name$="[analis_nip]"]').val(item.nomorindukpegawai);
    }
    
    /**
     * Reset field Analis
     * @param {type} obj
     * @returns {undefined}
     */
    function resetAnalisTg(obj) {
        var no = $(obj).parents(".panel-det-thigli").attr('row-rincian-thigli');
        var row = $("#no_row").val(no);
        $(".panel-det-thigli").each(function () {
            if ($(this).attr('row-rincian-thigli') == no) {
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
    function setDialogTg(obj) {
        var no = $(obj).parents(".panel-det-thigli").attr('row-rincian-thigli');
        var row = $("#no_row").val(no);
        $("#dialogPpdsTg").dialog("open");
    }

    /**
     * Mencari data ppds berdasarkan ppds_id yang dipilih melalui ajax. jika ditemukan maka set ppds
     * @param {type} id
     * @returns {undefined}
     */
    function setPpdsDialogTg(id) {
        var dialog = "#dialogPpdsTg";
        var no = $("#no_row").val();
        parent = $(dialog).attr("parent-dialog");
        obj = $("#" + parent);
        
        $.get('<?php echo $this->createUrl('GetPpds'); ?>', {ppds_id: id}, function (data) {
            $(".panel-det-thigli").each(function () {
                if ($(this).attr('row-rincian-thigli') == no) {
                    setPegPPDSTg($(this).find('input[name$="[ppds_id]"]'), data[0]);
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
    function setPegPPDSTg(obj, item) {
        $(obj).parents(".panel-det-thigli").find('input[name$="[ppds_id]"]').val(item.ppds_id);
        $(obj).parents(".panel-det-thigli").find('input[name$="[ppds_nama]"]').val(item.ppds_nama);
        $(obj).parents(".panel-det-thigli").find('input[name$="[ppds_nim]"]').val(item.ppds_nim);
    }
    
    /**
     * Reset field PPDS
     * @param {type} obj
     * @returns {undefined}
     */
    function resetPPDSTg(obj) {
        var no = $(obj).parents(".panel-det-thigli").attr('row-rincian-thigli');
        var row = $("#no_row").val(no);
        $(".panel-det-thigli").each(function () {
            if ($(this).attr('row-rincian-thigli') == no) {
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
    function setDialogTg2(obj) {
        var no = $(obj).parents(".panel-det-thigli").attr('row-rincian-thigli');
        var row = $("#no_row").val(no);
        $("#dialogVerifikatorTg").dialog("open");
    }

    /**
     * Mencari data ppds berdasarkan pegawai_id yang dipilih melalui ajax. jika ditemukan maka set dpjtm
     * @param {type} id
     * @returns {undefined}
     */
    function setDpjtmDialogTg(id) {
        var dialog = "#dialogVerifikatorTg";
        var no = $("#no_row").val();
        parent = $(dialog).attr("parent-dialog");
        obj = $("#" + parent);
        
        $.get('<?php echo $this->createUrl('GetDpjtm'); ?>', {pegawai_id: id}, function (data) {
            $(".panel-det-thigli").each(function () {
                if ($(this).attr('row-rincian-thigli') == no) {
                    setPegDPJTMTg($(this).find('input[name$="[dpjtm_id]"]'), data[0]);
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
    function setPegDPJTMTg(obj, item) {
        $(obj).parents(".panel-det-thigli").find('input[name$="[dpjtm_id]"]').val(item.pegawai_id);
        $(obj).parents(".panel-det-thigli").find('input[name$="[dpjtm_nama]"]').val(item.nama_pegawai);
        $(obj).parents(".panel-det-thigli").find('input[name$="[dpjtm_nip]"]').val(item.nomorindukpegawai);
    }
    
    /**
     * Menghapus field DPJTM 
     * @param {type} obj
     * @returns {undefined}
     */
    function resetDPJTMTg(obj){
        var no = $(obj).parents(".panel-det-thigli").attr('row-rincian-thigli');
        var row = $("#no_row").val(no);
        $(".panel-det-thigli").each(function () {
            if ($(this).attr('row-rincian-thigli') == no) {
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
    function generatePickerThigli() {
        var idx = 0;
        $('.panel-det-thigli').each(function () {
            jQuery('#ThiglikolatbrothT_detail_'+ idx +'_tanggal_thiglikolatbroth').datetimepicker(
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
                'focus': function (event, ui){
                    $(this).val(ui.item.nama_pegawai);
                    return false;
                },
                'select': function (event, ui){
                    setPegAnalisTg($(this), ui.item);
                    return false;
                },
                'source': function (request, response){
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
                'focus': function (event, ui){
                    $(this).val(ui.item.ppds_nama);
                    return false;
                },
                'select': function (event, ui){
                    setPegPPDSTg($(this), ui.item);
                    return false;
                },
                'source': function (request, response){
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
                'focus': function (event, ui){
                    $(this).val(ui.item.nama_pegawai);
                    return false;
                },
                'select': function (event, ui){
                    setPegDPJTMTg($(this), ui.item);
                    return false;
                },
                'source': function (request, response){
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