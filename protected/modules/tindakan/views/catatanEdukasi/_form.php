<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'catatanedukasi-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
    ));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>


<?php echo $this->renderPartial($this->path_view."_dataPasien", array(
    'modPendaftaran'=>$pendaftaran,'modPasien'=>$pendaftaran->pasien
), true); ?>

<?php echo $this->renderPartial($this->path_view."_riwayat", array(
    'riwayat'=>$riwayat,'pendaftaran'=>$pendaftaran,
), true); ?>


<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Tabel Catatan Edukasi</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'nomorcatatanedukasi', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->dropDownListRow($model, 'kodeprofesi', LookupM::getItemsUrutan('kodeedukator'), array('onchange'=>'setFormKodeEdukator();', 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

            </div>
            <div class="col-sm-6">
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'tgl_edukasi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_edukasi',
                            'value' => null,
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => 'span3 htpd',
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <a class="btn btn-default" onclick="$('#dialog-addphoto').dialog('open'); putarWebcam();" id="btn-addphoto" onkeyup="return $(this).focusNextInputField(event)">
                                <i class="glyphicon glyphicon-camera"></i> Ambil Foto
                            </a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo $form->hiddenField($model, 'foto_penerimaedukas', array('readonly' => true, 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                        <?php // echo $form->hiddenField($modPenjualan, 'is_ambilfoto', array('readonly' => true, 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>

                        
                            <div style="text-align: center;" id="main_foto_preview">
                                <?php $url_photopasien = (!empty($model->foto_penerimaedukas) ? $model->foto_penerimaedukas : Params::urlAmbilObatDirectory() . "no_photo.jpeg"); ?>
                                <img id="photo-preview" src="<?php echo $url_photopasien ?>" style="width: 160px;"><br>
                                
                            </div>
                    </div>
                </div>
                <?php // echo $form->textFieldRow($model, 'tgl_edukasi', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));  ?>

            </div>
        </div>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Form Catatan Edukasi A</div>
    </div>
    <div class="panel-body" id="panel_catatan_detail">

    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Form Catatan Edukasi B</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-6">
              <div class="control-group ">
                 <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
                 <div class="controls">
                     <?php
                        $kie_penjelasan = CatatanedukasibM::model()->findAllByAttributes(array('nama_edukasi'=>'Penjelasan/KIE','status'=>true),array('order'=>'urutan ASC'));
                        if(!empty($kie_penjelasan)){
                          $htmlKie = "";

                          foreach($kie_penjelasan as $i => $look){
                            $isCheck = false;
                            if($i > 0){
                              $htmlKie .= "<br/>";
                            }

                            $htmlKie .= CHtml::hiddenField('Penjelasankie['.$i.'][nama]',$look->isi_edukasi);
                            $htmlKie .= CHtml::checkBox('Penjelasankie['.$i.'][isCheck]',$isCheck).' <label>'.$look->isi_edukasi.'</label>';
                          }
                          echo $htmlKie;
                        }
                      ?>
                 </div>
              </div>
                <?php echo $form->textAreaRow($model, 'penjelasan_kie', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
            <div class="col-sm-6">
              <div class="control-group ">
                 <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
                 <div class="controls">
                     <?php
                        $evaluasi = CatatanedukasibM::model()->findAllByAttributes(array('nama_edukasi'=>'Keterangan dan Evaluasi','status'=>true),array('order'=>'urutan ASC'));
                        if(!empty($evaluasi)){
                          $htmlEvaluasi = "";

                          foreach($evaluasi as $i => $look){
                            $isCheck = false;
                            if($i > 0){
                              $htmlEvaluasi .= "<br/>";
                            }

                            $htmlEvaluasi .= CHtml::hiddenField('Evaluasiketerangan['.$i.'][nama]',$look->isi_edukasi);
                            $htmlEvaluasi .= CHtml::checkBox('Evaluasiketerangan['.$i.'][isCheck]',$isCheck).' <label>'.$look->isi_edukasi.'</label>';
                          }
                          echo $htmlEvaluasi;
                        }
                      ?>
                 </div>
              </div>
                <?php echo $form->textAreaRow($model, 'keterangan_dan_evaluasi', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Data Catatan Edukasi</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <?php echo $form->dropDownListRow($model, 'metodeedukasi', LookupM::getItemsUrutan('metodeedukasi'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                 <div class="control-group ">
                    <?php echo $form->labelEx($model, 'durasi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'durasi', array('class' => 'span1 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <label>Menit</label>
                    </div>
                 </div>

            </div>
            <div class="col-sm-6">
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'edukator_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
//                        echo $form->dropDownList($model, 'edukator_id',
//                            CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array(
//                                'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
//                                'pegawai_aktif'=>true
//                            ), array(
//                                'order'=>'nama_pegawai'
//                            )), 'pegawai_id', 'namaLengkap'),
//                            array('empty'=>'-- Pilih --', 'class' => 'span3 edukator_id', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <?php

                        echo $form->hiddenField($model, 'edukator_id', array('class'=>'edukator_id'));
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'edukator_nama',
                            'source' => 'js: function(request, response) {
                                $.ajax({
                                    url: "' . $this->createUrl('autocompleteEdukator') . '",
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
                                    $(this).val("");
                                    return false;
                                }',
                                'select' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.label);
                                    $(".edukator_id").val(ui.item.value);
                                    return false;
                                 }',
                            ),
                            'htmlOptions' => array('class' => 'custom-only span3 edukator_nama', 'placeholder' => 'Ketik Edukator',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogEdukator'),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'hubungankeluarga', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'hubungankeluarga', LookupM::getItemsUrutan('hubungankeluarga'), array(
                            'empty'=>'-- Pilih --',
                            'class'=>'span3',
                            'onchange'=>'setPilihHubungan();',
                            'id'=>'hubungankeluarga',
                        )); ?><br/>
                        <?php echo $form->textField($model, 'penerimaedukasi', array(
                            'empty'=>'-- Pilih --',
                            'class'=>'span3',
                            'id'=>'penerimaedukasi',
                        )); ?>
                    </div>
                </div>


            </div>
        </div>

    </div>
</div>

<div class="row-fluid">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')),
            $this->createUrl('create'),
            array('class' => 'btn btn-danger',
                'onclick' => 'return refreshForm(this);'));
        ?>
        <?php // echo CHtml::link(Yii::t('mds', '{icon} Pengaturan CatatanedukasiT', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
        <?php $this->widget('UserTips', array('content' => '')); ?>
    </div>
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
        'minHeight' => 250,
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


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogEdukator',
        'options' => array(
            'title' => 'Nama Edukator',
            'autoOpen' => false,
            'modal' => true,
            'width' => 860,
            'height' => 380,
            'resizable' => false,
        ),
    )
);
// echo CHtml::hiddenField('dokter_untuk',"",array('readonly'=>true));
$modPegawai = new PegawairuanganV();
$modPegawai->unsetAttributes();

$modPegawai->pegawai_aktif = true;
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');

if (isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
}

$prov = $modPegawai->search();
$prov->sort->defaultOrder = 'nama_pegawai';

$this->widget('ext.bootstrap.widgets.BootGridView',
    array(
        'id' => 'edukator-grid',
        'dataProvider' => $prov,
        'filter' => $modPegawai,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",'
                . '"onClick" => "
                    $(\'.edukator_id\').val(\'".$data->pegawai_id."\');
                    $(\'.edukator_nama\').val(\'".$data->namaLengkap."\');
                    $(\'#dialogEdukator\').dialog(\'close\');
                    return false;"))',
            ),
            //'gelardepan',
            array(
                'name' => 'nama_pegawai',
                'value' => '$data->namaLengkap',
            ),
            array(
                'name' => 'jabatan_id',
                'type' => 'raw',
                'value' => function($data) {
                    if (empty($data->jabatan_id))
                        return "-";
                    $j = JabatanM::model()->findByPk($data->jabatan_id);

                    return $j->jabatan_nama;
                },
                'filter' => CHtml::activeDropDownList($modPegawai, 'jabatan_id',
                    CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true order by jabatan_nama'), 'jabatan_id', 'jabatan_nama'),
                    array('empty' => '-- Pilih --')),
            ),
            //'gelarbelakang_nama',
            'jeniskelamin',
        // 'agama',
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )
);

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>


<script type="text/javascript">

function setFormKodeEdukator() {
    var kode = $("#CatatanedukasiT_kodeprofesi").val();

    $.post('<?php echo $this->createUrl('loadCeklisEdukator'); ?>', {kode: kode}, function(data) {
        $("#panel_catatan_detail").html(data.html);
    }, 'json');
}

function setPilihHubungan() {
    var nilai = $("#hubungankeluarga").val();

    if (nilai == "") {
        $("#penerimaedukasi").val("").prop("disabled", true);
    } else {
        $("#penerimaedukasi").val("").prop("disabled", false);

        if (nilai == "YBS") {
            $("#penerimaedukasi").val($("#PasienM_nama_pasien").val());
        }
    }
}

function printA(caraPrint) {
    window.open("<?php echo $this->createUrl('print', array('pendaftaran_id'=>$pendaftaran->pendaftaran_id)); ?>&tipe=a&caraPrint="+caraPrint,"",'location=_new, width=900px');
}

function printB(caraPrint) {
    window.open("<?php echo $this->createUrl('print', array('pendaftaran_id'=>$pendaftaran->pendaftaran_id)); ?>&tipe=b&caraPrint="+caraPrint,"",'location=_new, width=900px');
}

function hapusCatatan(obj, id) {
    myConfirm("Anda yakin untuk menghapus data ini ?", "Peringatan", function(r) {
        if (r) {
            $.post('<?php echo $this->createUrl('delete'); ?>', {
                id: id,
            }, function(data) {
                if (data.ok == 1) {
                    myAlert(data.msg);
                    $(obj).parents("tr").remove();
                } else {
                    myAlert(data.msg);
                }
            }, 'json');
        }
    });
}

$(document).ready(function() {
    setPilihHubungan();
});

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
</script>
