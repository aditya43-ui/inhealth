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
                            <?php echo $form->labelEx($informasi, 'penerimainformasi_hubungandgnpasien', array('class' => 'control-label', 'label' => 'Hubungan dengan Pasien'));

                            ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($informasi, 'penerimainformasi_hubungandgnpasien', LookupM::getItems('hubungankeluarga'), array('empty' => 'Hubungan Keluarga', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 penerimainformasi_hubungandgnpasien')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php //echo $form->labelEx($informasi, 'penerimainformasi_nama', array('class' => 'control-label', 'label' => 'Nama')); 

                            echo CHtml::label("Nama <span class='required'>*</span>",'penerimainformasi_nama', array('class'=>'control-label required'))
                            
                            ?>
                            <div class="controls">
                                <?php echo $form->textField($informasi, 'penerimainformasi_nama', array('class' => 'span3')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($informasi, 'penerimainformasi_umur', array('class' => 'control-label', 'label' => 'Umur')); ?>
                            <div class="controls">
                                <?php echo $form->textField($informasi, 'penerimainformasi_umur', array('class' => 'span2 numbers-only')); ?> <label> Tahun</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($informasi, 'penerimainformasi_jeniskelamin', array('class' => 'control-label', 'label' => 'Jenis Kelamin')); ?>
                            <div class="controls">
                                <?php echo $form->radioButtonList($informasi, 'penerimainformasi_jeniskelamin', LookupM::getItems('jeniskelamin'), array('inline' => true, 'class' => 'jeniskelamin')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($informasi, 'penerimainformasi_alamat', array('class' => 'control-label', 'label' => 'Alamat')); ?>
                            <div class="controls">
                                <?php echo $form->textArea($informasi, 'penerimainformasi_alamat', array('class' => 'span3')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php //echo $form->labelEx($informasi, 'penerimainformasi_jenisidentitas', array('class' => 'control-label', 'label' => 'No. Kartu Identitas')); ?>
                            <?php 
                            echo CHtml::label("No Kartu <span class='required'>*</span>",'penerimainformasi_jenisidentitas', array('class'=>'control-label required'))
                            
                            ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($informasi, 'penerimainformasi_jenisidentitas', array('KTP' => 'KTP', 'SIM' => 'SIM'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"></label>
                            <div class="controls">
                                <?php echo $form->textField($informasi, 'penerimainformasi_noidentitas', array('class' => 'span3 numbers-only', 'maxlength' => 16, 'onkeyup' => '$("#identitas_pembuatpernyataan").val($(this).val())')) ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($informasi, 'dokterpelaksanatindakan_id', array('class' => 'control-label', 'label' => 'Dokter Pelaksanan Tindakan')); ?>
                    <div class="controls">
                        <?php
                        $listDokter = DokterV::model()->findAllByAttributes(array('ruangan_id' => Yii::app()->user->getState('ruangan_id'), 'pegawai_aktif' => true));
                        $op = array();

                        foreach ($listDokter as $item) {
                            $op[$item->pegawai_id] = array(
                                'data-nama' => $item->namaLengkap
                            );
                        }

                        echo CHtml::activeDropDownList($informasi, 'dokterpelaksanatindakan_id', CHtml::listData(DokterV::model()->findAllByAttributes(array('ruangan_id' => Yii::app()->user->getState('ruangan_id'), 'pegawai_aktif' => true), array('order' => 'pegawai_id')), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3', 'options' => $op))
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php //echo $form->labelEx($informasi, 'pemberiinformasi_id', array('class' => 'control-label', 'label' => 'Pemberi Informasi')); ?>
                    <?php 
                        echo CHtml::label("Pemberi Informasi <span class='required'>*</span>",'pemberiinformasi_id', array('class'=>'control-label required'))
                            
                    ?>
                    <div class="controls">
                        <?php echo CHtml::activeDropDownList($informasi, 'pemberiinformasi_id', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array('ruangan_id' => Yii::app()->user->getState('ruangan_id'), 'pegawai_aktif' => true), array('order' => 'pegawai_id')), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3')) ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($informasi, 'jenissurat_id', array('class' => 'control-label', 'label' => 'Jenis Surat')); ?>
                    <div class="controls">
                        <?php
                        
                        $jenissurat = JenisSuratM::model()->findAllByAttributes(array(
                                            'jenissurat_aktif' => true,
                                                ), array(
                                            'condition' => "(is_surat_tindakan_dokter = true or is_surat_tindakan_transfusiresiko = true) and lower(jenissurat_nama) ilike '%".strtolower($model->jenissurat)."%'"
                                        ));
                        
                        $op = array();
                        foreach ($jenissurat as $item) {
                            $op[$item->jenissurat_id] = array(
                                'data-dokter'=>$item->is_surat_tindakan_dokter ? 1 : 0,
                                'data-resikotransfusi'=>$item->is_surat_tindakan_transfusiresiko ? 1 : 0,
                            );
                        }
                        
                        echo $form->dropDownList($informasi, 'jenissurat_id', CHtml::listData($jenissurat, 'jenissurat_id', 'jenissurat_nama'), array(
                                            'empty'=>'-- Pilih --', 'class'=>'jenissurat_id', 'options'=>$op,
                                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($informasi, 'daftartindakan_id', array('class' => 'control-label', 'label' => 'Tindakan')); ?>
                    <div class="controls">
                        <?php
                        echo $form->hiddenField($informasi, 'daftartindakan_id', array('class' => 'daftartindakan_id'));
                        
                        $daftartindakan_nama = null;
                        if (!empty($informasi->daftartindakan_id)) {
                            $dat = DaftartindakanM::model()->findByPk($informasi->daftartindakan_id);
                            $daftartindakan_nama = $dat->daftartindakan_nama;
                        }
                        
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'daftartindakanNama',
                            'value' => $daftartindakan_nama,
                            'source' => 'js: function(request, response) {
                                           $.ajax({
                                               url: "' . $this->createUrl('daftarTindakan') . '",
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
                                    setTindakan(ui.item.value, ui.item.daftartindakan_nama);
                                    return false;
                                }',
                            ),
                            'tombolDialog' => array("tombolDialog"=>"btnTindakan", "idDialog" => 'dialogTindakan'),
                            'htmlOptions' => array('class' => 'daftartindakan_nama', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                        ));
                        ?>
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
    'nama' => $modPasien->nama_pasien,
    'umur' => $umur[0],
    'jeniskelamin' => $modPasien->jeniskelamin,
    'alamat' => $modPasien->alamat_pasien,
    'jenis_identitas' => $modPasien->jenisidentitas,
    'no_identitas' => $modPasien->no_identitas_pasien,
);
?>





<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogTindakan',
    'options'=>array(
        'title'=>'Daftar Tindakan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>440,
        'resizable'=>false,
    ),
));


$modTindakan = new DaftartindakanM('searchTindakan');
$modTindakan->unsetAttributes();
$modTindakan->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['DaftartindakanM'])) {
    $modTindakan->attributes = $_GET['DaftartindakanM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'tindakan-grid',
    'dataProvider' => $modTindakan->searchTindakanRuangan(),
    'filter' => $modTindakan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectTindakan",
                                        "onClick" => "
                                            setTindakan($data->daftartindakan_id, \"$data->daftartindakan_nama\");
                                            $(\"#dialogTindakan\").dialog(\"close\");
                                        "))',
        ),
        array(
            'name' => 'kategoritindakan_nama',
            'value' => '$data->kategoritindakan_nama',
            'type' => 'raw',
        ),
        array(
            'name' => 'daftartindakan_kode',
            'value' => '$data->daftartindakan_kode',
            'type' => 'raw',
        ),
        array(
            'name' => 'daftartindakan_nama',
            'value' => '$data->daftartindakan_nama',
            'type' => 'raw',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();

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


    function setTindakan(id, nama) {
        $(".daftartindakan_id").val(id);
        $(".daftartindakan_nama").val(nama);
    }

    
    function cekJenisSurat() {
        
        var val = parseInt($(".jenissurat_id").val());

        if (isNaN(val)) {
            return false;
        }
        
        <?php if ($informasi->isNewRecord): ?>
            loadInformasi(val);
        <?php endif; ?>
    }

    function loadInformasi(id) {
        $("#panel_detail_informasi").empty();

        $.post("<?php echo $this->createUrl('loadInformasi'); ?>", {id: id}, function (data) {
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
        // $(".panel_form_informasi input, .panel_form_informasi select, .panel_form_informasi textarea")
        //         .not(".jeniskelamin, .jenisanastesi, input[type='hidden']")
        //         .each(function () {
        //             var v = $(this).val();
        //             if (v == null) {
        //                 is_valid = false;
        //             } else if (v.trim() == "") {
        //                 is_valid = false;
        //             }
        //         });

        if ($("#PemberianinformasiT_penerimainformasi_nama").val() == 0) {
            is_valid = false;
        }
        if ($("#PemberianinformasiT_penerimainformasi_jenisidentitas").val() == 0) {
            is_valid = false;
        }
        if ($("#PemberianinformasiT_penerimainformasi_noidentitas").val() == 0) {
            is_valid = false;
        }
        if ($("#PemberianinformasiT_pemberiinformasi_id").val() == 0) {
            is_valid = false;
        }

        // if ($(".jeniskelamin:checked").length == 0) {
        //     is_valid = false;
        // }



        return is_valid;
    }


    // =============================== //


    $(document).ready(function () {
        $("#PemberianinformasiT_penerimainformasi_hubungandgnpasien").on("change", checkInputHubungan);
        $(".jenissurat_id").on("change", cekJenisSurat);
        //$(".jenisanastesi").on("click", cekJenisAnastesi);

        checkInputHubungan();
        cekJenisSurat();
    });

</script>