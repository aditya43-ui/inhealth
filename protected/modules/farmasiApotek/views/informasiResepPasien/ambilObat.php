<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/literallycanvas/css/literallycanvas.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/react/build/react-with-addons.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/literallycanvas/js/literallycanvas-core.min.js'); ?>
<style>
    .form-horizontal .checkbox {
        clear: both;
        padding: 0 0 0 20px;
        margin-left: 5px;
    }

    .form-horizontal .checkbox label {
        margin: 0;
    }
    
</style>
<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Penyerahan <strong>Obat Pasien</strong></div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'hasil-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => false,
            'type' => 'horizontal',
            'focus' => '#',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
        ?>
    <div class="panel panel-success panel-shadow">
        <div class="panel-heading">
            <div class="panel-title">Data Pasien</div>
        </div>
        <div class="panel-body row-fluid">
            <?php
            if (isset($_GET['sukses'])) {
                Yii::app()->user->setFlash('success', '<strong>Berhasil </strong> Data berhasil disimpan');
        
            $this->widget('bootstrap.widgets.BootAlert');
            $this->renderPartial('_ringkasDataPasien', array('modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran, 'modPenjualan'=>$modPenjualan));
            echo $form->errorSummary(array($modPenjualan));
        }
            ?>
        </div>
    </div>
    <div class="panel panel-success panel-shadow">
        <div class="panel-heading">
            <div class="panel-title">Data Obat</div>
        </div>
        <div class="panel-body row-fluid">
            <?php $this->renderPartial('_dataObat', array('kerangkaLooping'=>$kerangkaLooping));?>
        </div>
    </div>
    <div class="panel panel-success panel-shadow">
        <div class="panel-heading">
            <div class="panel-title">Penyerahan Obat</div>
        </div>
        <div class="panel-body">
            <!-- <p class="help-block"><?php //echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p> -->
            <div class="row">
                <div class="col-sm-5">
                    <div class="control-group">
                        <?php $modPenjualan->tglpenyerahan = $format->formatDateTimeId(date('Y-m-d H:i:s')); ?>
                        <?php echo $form->labelEx($modPenjualan, 'tglpenyerahan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget(
                                'MyDateTimePicker',
                                array(
                                    'model' => $modPenjualan,
                                    'attribute' => 'tglpenyerahan',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        //                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'class' => 'dtPicker3 span3',
                                        'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                )
                            );
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->checkBox($modPenjualan, 'is_sendiri', array('readonly' => false, 'onclick' => 'setEnableForm("dirisendiri")')); ?><label for="FAPenjualanResepT_is_sendiri" style="font-size: 8pt">Pilih jika diri sendiri</label>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->checkBox($modPenjualan, 'isdiserahkan_ke_petugas_ruangan', array('readonly' => false, 'onclick' => 'setEnableForm("petugasruangan")')); ?><label for="FAPenjualanResepT_isdiserahkan_ke_petugas_ruangan" style="font-size: 8pt">Pilih jika diserahkan ke petugas ruangan</label>
                        </div>
                    </div>

                    <div class="form-diri-sendiri">                    
                        <?php echo $form->textFieldRow($modPenjualan, 'namapenerimaobat', array('placeholder' => 'Nama Penerima Obat', 'class' => 'span3 namapenerimaobat', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                    
                    <div class="form-petugas-ruangan hide">
                        <?php echo $form->hiddenField($modPenjualan, 'namapenerimaobat', array('placeholder' => 'Nama Penerima Obat', 'class' => 'span3 namapenerimaobat', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->dropDownListRow($modPenjualan, 'pegpenyerahan_id', CHtml::listData(PegawaiV::model()->findAll(" pegawai_aktif = true ORDER BY nama_pegawai ASC "), 'pegawai_id', 'namaLengkap'), array('empty'=>'-- Pilih --', 'class' => 'span3 permanent', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>    
                    </div>
                    <?php echo $form->textFieldRow($modPenjualan, 'notelppenerimaobat', array('placeholder' => 'No Telp Penerima Obat', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    
                    <div class="control-group">
                        <?php echo $form->labelEx($modPenjualan, 'penelaahanobat', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <div>
                            <?php

                            $telaahobat =  ['Benar Pasien' => 'Benar Pasien', 'Benar Obat' => 'Benar Obat', 'Benar Dosis' => 'Benar Dosis',
                            'Benar Rute' => 'Benar Rute', 'Benar Waktu' => 'Benar Waktu'];

                            echo CHtml::checkBox('penelaahanobat_pilih_semua', false, array(
                                'class'=>'penelaahanobat_pilih_semua', 'onclick'=>'set_penelaahanobat_pilih_semua();'
                            )).CHtml::label('Pilih Semua', 'penelaahanobat_pilih_semua', array());
                            ?></div>

                            <?php echo $form->checkBoxList(
                                $modPenjualan,
                                'penelaahanobat',
                                $telaahobat,
                                array(
                                    'template' => '<div>{input}{label}</div>',
                                    // 'readonly' => true, 
                                    'class' => 'penelaah_item required',
                                    'onkeypress' => "return $(this).focusNextInputField(event);")
                            ); ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo $form->labelEx($modPenjualan, 'kiepenyerahan', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <div>
                            <?php

                            $kieobat =  ['Nama dan Bentuk Obat' => 'Nama dan Bentuk Obat', 'Tujuan Penyerahan Obat' => 'Tujuan Penyerahan Obat',
                             'Dosis Obat' => 'Dosis Obat', 
                            'Cara Menyimpan Obat' => 'Cara Menyimpan Obat', 'Cara Menggunakan Obat' => 'Cara Menggunakan Obat', 'Efek Samping Obat' => 'Efek Samping Obat',
                            'Lama Penggunaan Obat' => 'Lama Penggunaan Obat', 'Langkah Jika Terjadi ESO' => 'Langkah Jika Terjadi ESO'];

                            echo CHtml::checkBox('kie_pilih_semua', false, array(
                                'class'=>'kie_pilih_semua', 'onclick'=>'set_kie_pilih_semua();'
                            )).CHtml::label('Pilih Semua', 'kie_pilih_semua', array());
                            ?></div>
                            
                            <?php 

                            echo $form->checkBoxList(
                                $modPenjualan,
                                'kiepenyerahan',
                                $kieobat,
                                array(
                                    'template' => '<div>{input}{label}</div>',
                                    // 'readonly' => true, 
                                    'class' => 'kie_item required',
                                    'onkeypress' => "return $(this).focusNextInputField(event);")
                            );
                             ?>
                        </div>
                    </div>

                    

                    
                </div>
                <div class="col-sm-7">
                    <?php echo $form->textAreaRow($modPenjualan, 'ketpenyerahan', array('placeholder' => 'Keterangan Penyerahan', 'rows' => 4, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($modPenjualan, 'namaygmenyerahkan', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <br>
                    <?php echo $form->textFieldRow($modPenjualan, 'menerimaobatinformasi', array('class' => 'span3',  'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($modPenjualan, 'petugasfarmasi', array('class' => 'span3',  'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($modPenjualan, 'disetuju', array('class' => 'span3',  'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo CHtml::label('Hargai', 'harga_id', array('class' => 'control-label')); ?>
                    <?php echo CHtml::label('Teknik', 'teknik_id', array('class' => 'control-label')); ?>
                    <?php echo CHtml::label('Kemas', 'kemas_id', array('class' => 'control-label')); ?>
                    <?php echo CHtml::label('Penyerahan', 'penyerahan_id', array('class' => 'control-label')); ?>
                    <tr>
                        <?php $dokter = PegawaiM::model()->findAll();?>
                        <td><?php echo $form->dropDownList($modPenjualan, 'harga_id', CHtml::listData($dokter, 'pegawai_id', 'namaLengkap'), array('class' => 'span1', 'empty' =>"-- Pilih --", 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>&emsp;&emsp;&emsp;&emsp;</td>
                        <td><?php echo $form->dropDownList($modPenjualan, 'teknik_id', PegawairuanganV::getDropPegawai(Yii::app()->user->getState('ruangan_id')), array('class' => 'span1', 'empty' =>"-- Pilih --", 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</td>
                        <td><?php echo $form->dropDownList($modPenjualan, 'kemas_id', PegawairuanganV::getDropPegawai(Yii::app()->user->getState('ruangan_id')), array('class' => 'span1', 'empty' =>"-- Pilih --", 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</td>
                        <td><?php echo $form->dropDownList($modPenjualan, 'penyerahan_id', PegawairuanganV::getDropPegawai(Yii::app()->user->getState('ruangan_id')), array('class' => 'span1', 'empty' => "-- Pilih --", 'onkeyup' => "return $(this).focusNextInputField(event)")); ?> </td>
                    </tr>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                <?php echo $form->hiddenField($modPenjualan, 'ttdpenyerahan', array('class' => 'ttdpenyerahan')); ?>
                    <?php if (empty($modPenjualan->ttdpenyerahan)) : ?>
                        <div class="row-fluid" style="margin: auto;">
                            <div style="width: 300px;">
                                <div class="literally images-in-drawing"></div>
                                <!-- <button class="col-xs-3" id="ttd">Simpan</button> -->
                                <a class="tooltip-primary btn" data-toggle="tooltip" data-placement="top" title="" data-original-title="icon ini untuk menyimpam file gambar yang sudah dibuat" href="javascript:void(0);" id="ttd" data-rel="reload">Simpan Tanda Tangan</a>
                                <a class="tooltip-primary btn btn-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="icon ini untuk mengembalikan perubahan bidang gambar ke awal" href="javascript:void(0);" id="clear-lc2" data-rel="reload">Ulang</a>
                            </div>
                        </div>
                    <?php else : ?>
                        <?php echo CHtml::image($modPenjualan->ttdpenyerahan, null, array('width' => 300)); ?>
                    <?php endif ?>
                </div>
                <div class="col-sm-7">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a class="btn btn-default" onclick="$('#dialog-addphoto').dialog('open'); putarWebcam();" id="btn-addphoto" onkeyup="return $(this).focusNextInputField(event)">
                                    <i class="glyphicon glyphicon-camera"></i> Ambil Foto
                                </a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php echo $form->hiddenField($modPenjualan, 'fotopenyerahanobat', array('readonly' => true, 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                            <?php // echo $form->hiddenField($modPenjualan, 'is_ambilfoto', array('readonly' => true, 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                            
                                <div style="text-align: center;" id="main_foto_preview">
                                    <?php $url_photopasien = (!empty($modPenjualan->fotopenyerahanobat) ? $modPenjualan->fotopenyerahanobat : Params::urlAmbilObatDirectory() . "no_photo.jpeg"); ?>
                                    <img id="photo-preview" src="<?php echo $url_photopasien ?>" style="width: 160px;"><br>
                                    
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class='form-actions'>
        <?php
            $disable = '';
            if (isset($_GET['sukses'])) {
                $disable = 'disabled';
            }
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array(
                    'title' => 'Simpan',
                    'class' => 'btn btn-danger', 'type' => 'submit',
                    'id' => 'btn_simpan', $disable => $disable
                )
            );
        ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl('index'),
            array('title' => 'Ulang', 'class' => 'btn btn-default')
        ); ?>
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Print Resep', array('{icon}' => '<i class="entypo-print"></i>')),
            array(
                'class' => 'btn btn-info', 'type' => 'button',
                'id' => 'btn_print',
                'onclick' => 'cetakResepAmbilObat();',
            )
        );
        ?>
    </div>
<?php
//================= dialog webcam =====================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog-addphoto',
    'options' => array(
        'title' => 'Ambil Foto',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 360,
        'minHeight' => 100,
        'resizable' => false,
    ),
));
?>

<div id="dialog-content" style="text-align: center;">
    <div id="container_webcam" style="overflow: hidden; width: 320px; display: inline-block; margin-top: 10px;">
        <video id="cam-preview" style="margin-left: -160px;"></video>
    </div>
    <br>
    <?php // echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-cog icon-white"></i>')),array('rel'=>'tooltip','title'=>'Konfigurasi Kamera','class'=>'btn-primary', 'type'=>'button', 'onclick'=>'webcam.configure();','style'=>'font-size:10px; width:32px; height:24px;'));
    ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Ambil', array('{icon}' => '<i class="entypo-camera"></i>')), array('id' => 'btn_ambil_gambar', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'ambilGambar();', 'style' => 'font-size:10px; width:80px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="icon-download-alt icon-white"></i>')), array('id' => 'btn_simpan_gambar', 'disabled' => true, 'class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'simpanGambar();', 'style' => 'font-size:10px; width:80px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('id' => 'btn_ulang_gambar', 'class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'ulangGambar();', 'style' => 'font-size:10px; width:76px; height:24px;')); ?>
    <div id="upload_results" style="background-color:#eee; margin-top:10px"></div>
</div>
<?php $this->endWidget(); ?>

<?php $this->endWidget(); ?>


<script type="text/javascript">
    
    function cetakResepAmbilObat() {
        window.open("<?php echo $this->createUrl('printResep', array('penjualan_id'=>$modPenjualan->penjualanresep_id)) ?>&caraPrint=PRINT","",'location=_new, width=900px');
    }
    // function setEnableForm() {
    //     if (document.getElementById("FAPenjualanResepT_is_sendiri").checked) {
    //         $('#FAPenjualanResepT_namapenerimaobat').val($("#PasienM_nama_pasien").val());
    //         $('#FAPenjualanResepT_notelppenerimaobat').val($("#PasienM_no_mobile_pasien").val());
    //     } else {
    //         $('#FAPenjualanResepT_namapenerimaobat').val('');
    //         $('#FAPenjualanResepT_notelppenerimaobat').val('');
    //     }
    // }
    $(document).ready(function() {
        setEnableForm('load'); 
       
        jQuery($("#<?= CHtml::activeId($modPenjualan, 'pegpenyerahan_id') ?>")).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {				
                var select  = $('#<?php echo CHtml::activeId($modPenjualan, 'pegpenyerahan_id') ?>').val();
                
                $.ajax({
                    type:'POST',
                    url:'<?php echo $this->createUrl('setPetugasPenyerahan'); ?>',
                    data:{id:select},
                    dataType: "json",
                    success:function(data){
                        $("#FAPenjualanResepT_notelppenerimaobat").val(data.nomobile_pegawai);
                        $(".namapenerimaobat").val(data.namaLengkap);
                    },
                    error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                });
            },
            
        }).hide();

        var lc2 = LC.init(document.getElementsByClassName('literally images-in-drawing')[0]);
        $("#clear-lc2").click(function() {
            lc2.clear();
        });
        $("#ttd").click(function() {
            // alert("coba");
            // var lc2 = LC.init(document.getElementsByClassName('literally images-in-drawing')[0]);
            var image = lc2.getImage({
                scale: 1,
                margin: {
                    top: 10,
                    right: 10,
                    bottom: 10,
                    left: 10
                }
            }).toDataURL();
            // console.log(image)
            $('.ttdpenyerahan').val(image);
            // console.log($('#SuratpersetujuantmT_meyetujuittd').val())
        });

        $('#FAPenjualanResepT_kiepenyerahan_0').click(function() {
            var checked = $(this).prop('checked');
            $('.checkbox').find('input:checkbox').prop('checked', checked);
        });
    });
    function set_kie_pilih_semua() {
        $(".kie_item").prop("checked", $(".kie_pilih_semua").is(":checked"));
    }
    function set_penelaahanobat_pilih_semua() {
        $(".penelaah_item").prop("checked", $(".penelaahanobat_pilih_semua").is(":checked"));
    }

    function cetakResepAmbilObat() {
        window.open("<?php echo $this->createUrl('printResep', array('penjualan_id'=>$modPenjualan->penjualanresep_id)) ?>&caraPrint=PRINT","",'location=_new, width=900px');
    }


    <?php
    $random = rand(0000000000000000, 9999999999999999);
    ?>

    var video_pasien = null;
    var video_canvas = null;
    var temp_img = null;

    function putarWebcam() {
        ulangGambar();
    }

    /**
     * ambil gambar pada webcam
     * @returns {Boolean}
     */
    function ambilGambar() {
        video_pasien.pause();

        var img = document.createElement('img_webcam');
        var context;
        var width = container_webcam.offsetWidth;
        var height = container_webcam.offsetHeight;

        video_canvas = document.createElement("canvas");
        video_canvas.width = width;
        video_canvas.height = height;

        context = video_canvas.getContext('2d');
        context.drawImage(video_pasien, -157, 0);

        temp_img = video_canvas.toDataURL('image/png');

        $("#btn_ambil_gambar").prop("disabled", true);
        $("#btn_simpan_gambar").prop("disabled", false);
        $("#btn_ulang_gambar").prop("disabled", false);
    }
    /**
     * menyimpan / meng-upload gambar
     * @returns {undefined}
     */
    function simpanGambar() {
        $("#btn_simpan_gambar").attr("disabled", true);
        $("#FAPenjualanResepT_fotopenyerahanobat").val(temp_img);
        // $("#is_ambilfoto").val(1);
        $("#photo-preview").prop("src", temp_img);

        temp_img = null;
        $("#dialog-addphoto").dialog("close");

    }
    /**
     * mengulang pengambilan gambar
     * @returns {undefined}
     */
    function ulangGambar() {
        temp_img = null;
        video_pasien.play();
        $("#btn_ambil_gambar").prop("disabled", false);
        $("#btn_simpan_gambar").prop("disabled", true);
        $("#btn_ulang_gambar").prop("disabled", true);

    }

    function handleVideo(stream) {
        video_pasien.srcObject = stream;
    }

    function videoError(e) {
        // alert("Fungsi Foto pasien di-nonaktifkan.");
    }



    function hapusFoto() {
        $("#con_foto_scan").empty();
    }


    $(document).ready(function() {

        $("#btn-hapusphoto").hide();
        /**
         * set webcam
         * @returns {Boolean}
         */
        <?php if (!isset($_GET['sukses'])) { ?>

            video_pasien = document.querySelector("#cam-preview");
            navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;

            if (navigator.getUserMedia) {
                // jalankan fungsi handleVideo, dan videoError jika izin ditolak
                navigator.getUserMedia({
                    video: true
                }, handleVideo, videoError);
            }
        <?php } ?>

    });

    function setEnableForm(jenis = '') {
        const isdirisendiri = $("#FAPenjualanResepT_is_sendiri").prop("checked");
        const ispetugasruangan = $("#FAPenjualanResepT_isdiserahkan_ke_petugas_ruangan").prop("checked");
        
        if (jenis != 'load'){
            $('#FAPenjualanResepT_namapenerimaobat').val("");
            $('#FAPenjualanResepT_notelppenerimaobat').val("");
            $('#FAPenjualanResepT_pegpenyerahan_id').val('');                
        }
        
        $("#FAPenjualanResepT_is_sendiri").removeAttr("disabled");
        $("#FAPenjualanResepT_isdiserahkan_ke_petugas_ruangan").removeAttr("disabled");
        
        $(".form-diri-sendiri, .form-petugas-ruangan").addClass("hide").find("input, select:not(.permanent)").attr("disabled", true);        
        if (isdirisendiri) {
            $('#FAPenjualanResepT_namapenerimaobat').val($(".nama_penerima").val());
            $('#FAPenjualanResepT_notelppenerimaobat').val($("#PasienM_no_mobile_pasien").val());
        
            
            $("#FAPenjualanResepT_isdiserahkan_ke_petugas_ruangan").attr("disabled", true);
            
            $(".form-diri-sendiri").removeClass("hide").find("input").removeAttr("disabled");        
        } else if(ispetugasruangan){            
                        
            $("#FAPenjualanResepT_is_sendiri").attr("disabled", true);
            
            $(".form-petugas-ruangan").removeClass("hide").find("input, select:not(.permanent)").removeAttr("disabled");                                
        }else{
            $(".form-diri-sendiri").removeClass("hide").find("input").removeAttr("disabled");        
        }
    }
</script>