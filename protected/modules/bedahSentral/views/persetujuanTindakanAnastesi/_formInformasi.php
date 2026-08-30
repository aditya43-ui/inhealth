<div class="panel panel-success">
    <div class="panel-body">
        <br/>
        <div class="panel_form_informasi">
            <div class="col-sm-6">
                <div class="panel panel-darkk">
                    <span class="group-title">
                        Data Penerimaan Informasi/Pemberi Persetujuan
                    </span>
                    <div class="panel-body" id="info_persetujuan">
                        <div class="control-group">
                            <?php echo $form->labelEx($informasi, 'penerimainformasi_hubungandgnpasien', array('class'=>'control-label', 'label'=>'Hubungan dengan Pasien')); ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($informasi, 'penerimainformasi_hubungandgnpasien', LookupM::getItems('hubungankeluarga'), array('empty'=>'Hubungan Keluarga','onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span3 penerimainformasi_hubungandgnpasien'))?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($informasi, 'penerimainformasi_nama', array('class'=>'control-label', 'label'=>'Nama')); ?>
                            <div class="controls">
                                <?php echo $form->textField($informasi, 'penerimainformasi_nama', array('class'=>'span3')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($informasi, 'penerimainformasi_umur', array('class'=>'control-label', 'label'=>'Umur')); ?>
                            <div class="controls">
                                <?php echo $form->textField($informasi, 'penerimainformasi_umur', array('class'=>'span2 numbers-only')); ?> <label> Tahun</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($informasi, 'penerimainformasi_jeniskelamin', array('class'=>'control-label', 'label'=>'Jenis Kelamin')); ?>
                            <div class="controls">
                                <?php echo $form->radioButtonList($informasi, 'penerimainformasi_jeniskelamin', LookupM::getItems('jeniskelamin'), array('inline' => true, 'class'=>'jeniskelamin'))?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($informasi, 'penerimainformasi_alamat', array('class'=>'control-label', 'label'=>'Alamat')); ?>
                            <div class="controls">
                                <?php echo $form->textArea($informasi, 'penerimainformasi_alamat', array('class'=>'span3')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($informasi, 'penerimainformasi_jenisidentitas', array('class'=>'control-label', 'label'=>'No. Kartu Identitas')); ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($informasi, 'penerimainformasi_jenisidentitas', array('KTP'=>'KTP','SIM'=>'SIM'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"></label>
                            <div class="controls">
                                <?php echo $form->textField($informasi, 'penerimainformasi_noidentitas', array('class'=>'span3 numbers-only','maxlength'=>16,'onkeyup'=>'$("#identitas_pembuatpernyataan").val($(this).val())'))?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($informasi, 'dokterpelaksanatindakan_id', array('class'=>'control-label', 'label'=>'Dokter Pelaksana Tindakan')); ?>
                    <div class="controls">
                        <?php 
                        
                        $listDokter = DokterV::model()->findAllByAttributes(array('instalasi_id'=>Yii::app()->user->getState('instalasi_id'),'pegawai_aktif'=>true));
                        $op = array();
                        
                        foreach ($listDokter as $item) {
                            $op[$item->pegawai_id] = array(
                                'data-nama'=>$item->namaLengkap
                            );
                        }
                        
                        echo CHtml::activeDropDownList($informasi, 'dokterpelaksanatindakan_id', CHtml::listData(DokterV::model()->findAllByAttributes(array('instalasi_id'=>Yii::app()->user->getState('instalasi_id'),'pegawai_aktif'=>true), array('order'=>'pegawai_id')), 'pegawai_id','namaLengkap'), array('empty'=>'-- Pilih --','class'=>'span3 multiselect', 'options'=>$op))?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($informasi, 'pemberiinformasi_id', array('class'=>'control-label', 'label'=>'Pemberi Informasi')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeDropDownList($informasi, 'pemberiinformasi_id', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array('instalasi_id'=>Yii::app()->user->getState('instalasi_id'),'pegawai_aktif'=>true), array('order'=>'pegawai_id')), 'pegawai_id','namaLengkap'), array('empty'=>'-- Pilih --','class'=>'span3 multiselect'))?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'jenisanestesi', array('class'=>'control-label', 'label'=>'Jenis Anastesi')); ?>
                    <div class="controls">
                        <?php 
                        $anestesiUmum = JenisSuratM::model()->findByAttributes(array(
                            'is_anastesi_umum'=>true,
                            'is_anastesi_separuhbadan'=>false
                        ));
                        $anestesiBadan = JenisSuratM::model()->findByAttributes(array(
                            'is_anastesi_separuhbadan'=>true,
                            'is_anastesi_umum'=>false
                        ));
                        if (!empty($anestesiUmum)) {
                            echo '<div class="radio">'.$form->radioButton($informasi, 'jenisanestesi', array(
                                'value'=>"ANESTESI UMUM", 
                                'data-id'=>$anestesiUmum->jenissurat_id, 
                                'data-res'=>1,
                                'class'=>'jenisanastesi',
                                'uncheckValue'=>null,
                            )).'<label>'."ANESTESI UMUM".'</label></div>';
                        }
                        if (!empty($anestesiBadan)) {
                            echo '<div class="radio">'.$form->radioButton($informasi, 'jenisanestesi', array(
                                'value'=>"ANESTESI SEPARUH BADAN",
                                'data-id'=>$anestesiBadan->jenissurat_id, 
                                'data-res'=>2,
                                'class'=>'jenisanastesi',
                                'uncheckValue'=>null,
                            )).'<label>'."ANESTESI SEPARUH BADAN".'</label></div>';
                        }
                        echo $form->hiddenField($informasi, 'jenissurat_id', array('class'=>'jenissurat_id'));
                        ?>
                        <div style="padding-left: 40px">
                            <div class="radio"><?php echo $form->radioButton($informasi, 'subjenisanestesi', array('value'=>'EPIDURAL', 'class'=>'subjenisanestesi', 'uncheckValue'=>"")); ?><label>EPIDURAL</label></div>
                            <div class="radio"><?php echo $form->radioButton($informasi, 'subjenisanestesi', array('value'=>'SAB (SPINAL)', 'class'=>'subjenisanestesi', 'uncheckValue'=>"")); ?><label>SAB (SPINAL)</label></div>
                            <div class="radio"><?php echo $form->radioButton($informasi, 'subjenisanestesi', array('value'=>'BLOK PERIFER', 'class'=>'subjenisanestesi', 'uncheckValue'=>"")); ?><label>BLOK PERIFER</label></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="clear"></div>
        <div class="col-sm-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Checklist Pemberian Informasi</div>
                </div>
                <div class="panel-body" id="panel_detail_informasi">

                </div>
            </div>
        </div>
    </div>
</div>

<?php

$umur = explode(" ", $modPendaftaran->umur);

$data_ybs = array(
    'nama'=>$modPasien->nama_pasien,
    'umur'=>$umur[0],
    'jeniskelamin'=>$modPasien->jeniskelamin,
    'alamat'=>$modPasien->alamat_pasien,
    'jenis_identitas'=>$modPasien->jenisidentitas,
    'no_identitas'=>$modPasien->no_identitas_pasien,
);

?>
<script>

    var data_ybs = <?php echo CJSON::encode($data_ybs); ?>;
    var hubungan = '';
    
    function checkInputHubungan() {
        console.log("compare", hubungan, hubungan == 'YBS');
        if (hubungan == 'YBS') {
            $("#info_persetujuan :input").not('#PemberianinformasiT_penerimainformasi_hubungandgnpasien, .jeniskelamin').val("");
            $(".jeniskelamin").prop("checked", false);
        }
        
        var hub = $("#PemberianinformasiT_penerimainformasi_hubungandgnpasien").val();
        
        if (hub == 'YBS') {
            $("#PemberianinformasiT_penerimainformasi_nama").val(data_ybs.nama);
            $("#PemberianinformasiT_penerimainformasi_umur").val(data_ybs.umur);
            $(".jeniskelamin[value='" + data_ybs.jeniskelamin + "']").prop("checked", true);
            // $("#PemberianinformasiT_penerimainformasi_nama").val(data_ybs.jeniskelamin);
            $("#PemberianinformasiT_penerimainformasi_alamat").val(data_ybs.alamat);
            $("#PemberianinformasiT_penerimainformasi_jenisidentitas").val(data_ybs.jenis_identitas);
            $("#PemberianinformasiT_penerimainformasi_noidentitas").val(data_ybs.no_identitas);
        }
        
        hubungan = hub;
        console.log(hubungan);
    }
    
    
    function cekJenisAnastesi() {
        var cek = $(".jenisanastesi:checked").data('res') == 2;
        
        if (!cek) {
            $(".subjenisanestesi")
                    .prop("checked", false)
                    .prop("disabled", true);
        } else {
            $(".subjenisanestesi").prop("disabled", false);
            
        }
        
        if ($(".jenisanastesi:checked").length != 0) {
            $(".jenissurat_id").val($(".jenisanastesi:checked").data('id'));
            <?php if ($informasi->isNewRecord): ?>
            loadInformasi($(".jenisanastesi:checked").data('id'));
            <?php endif; ?>
        }
    }
    
    function loadInformasi(id) {
        $("#panel_detail_informasi").empty();
        
        $.post("<?php echo $this->createUrl('loadInformasi'); ?>", {id: id}, function(data) {
            $("#panel_detail_informasi").html(data.html);
            initInformasi(data.count);
            renderInformasi();
        }, 'json');
    }
    
    
    
    // ======== Informasi ============ //
    
    var informasi_idx = 0;
    var informasi_cnt = 0;
    var arr_progress = new Array();
    
    function initInformasi(cnt) {
        informasi_idx = 0;
        informasi_cnt = cnt;
        arr_progress = new Array();
    }
    
    function prev_informasi() {
        informasi_idx--;
        renderInformasi();
    }
    function next_informasi() {
        if ($("#ceklis_informasi_" + informasi_idx).find(".pemberianinformasi_hasil:checked").length == 0) {
            myAlert("Periksa apakah sudah dijelaskan atau belum sebelum melanjutkan");
            return false;
        }
        
        informasi_idx++;
        renderInformasi();
    }
    
    function inputCeklis(obj, idx) {
        arr_progress[idx] = $(obj).val();
    }
    
    function renderInformasi() {
        $(".panel_ceklis_informasi").hide();
        $("#ceklis_informasi_" + informasi_idx).show();
    }
    
    function validasiPenerimaInformasi() {
        var is_valid = true;
        $(".panel_form_informasi input, .panel_form_informasi select, .panel_form_informasi textarea")
                .not(".jeniskelamin, .jenisanastesi, .subjenisanestesi, input[type='hidden']")
                .each(function() {
            var v = $(this).val();
            if (v == null) {
                is_valid = false;
            } else if (v.trim() == "") {
                is_valid = false;
            }
        });
        
        if ($(".jeniskelamin:checked").length == 0) {
            is_valid = false;
        }
        if ($(".jenisanastesi:checked").length == 0) {
            is_valid = false;
        }
        if ($(".subjenisanestesi:disabled").length == 0 && $(".subjenisanestesi:checked").length == 0) {
            is_valid = false;
        }
        
        
        
        return is_valid;
    }
    
    
    // =============================== //
    
    var dp = $("<?php echo "#" . CHtml::activeId($informasi, 'dokterpelaksanatindakan_id'); ?>");
    var pi = $("<?php echo "#" . CHtml::activeId($informasi, 'pemberiinformasi_id'); ?>");

    $(document).ready(function() {
        $("#PemberianinformasiT_penerimainformasi_hubungandgnpasien").on("change", checkInputHubungan);
        $(".jenisanastesi").on("click", cekJenisAnastesi);
        
        checkInputHubungan();
        cekJenisAnastesi();

        jQuery(dp).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                console.log(element, 'data')
            }
        }).hide();

        jQuery(pi).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                console.log(element, 'data')
            }
        }).hide();
        
    });

</script>