<?php
$sukses = null;
if (isset($_GET['sukses'])) {
    $sukses = $_GET['sukses'];
}

?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/datetime.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapegawai-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
    'focus' => '#',
)); ?>

<fieldset class="" id="tablePegawaicuti">
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Permohonan Cuti Pegawai</b>
            </div>
        </div>
        <div class="panel-body">
            <?php echo $form->errorSummary($model); ?>
            <?php
            //if($sukses > 0) {
            // Yii::app()->user->setFlash('success',"Data Cuti berhasil disimpan!");
            $this->widget('bootstrap.widgets.BootAlert');
            //   }
            ?>
            <?php
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'data-riwayat',
                'content' => array(
                    'content-datariwayat' => array(
                        'header' => '<b>Riwayat Cuti</b>',
                        'isi' => $this->renderPartial($this->path_view . '_riwayat', array('model' => $model), true),
                        'active' => false,
                    ),
                ),
            ));
            ?>
            <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                        ?></p>-->
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-user"></i> Data <b>Pegawai</b>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'nama_pegawai', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'nama_pegawai', array('readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'tempatlahir_pegawai', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                echo $form->textField($model, 'tempatlahir_pegawai', array('readonly' => true));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'tgl_lahirpegawai', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                $model->tgl_lahirpegawai = MyFormatter::formatDateTimeForUser($model->tgl_lahirpegawai);
                                echo $form->textField($model, 'tgl_lahirpegawai', array('readonly' => true));
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'jeniskelamin', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                echo $form->textField($model, 'jeniskelamin', array('readonly' => true));
                                ?>
                            </div>
                        </div>

                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'jabatan_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                $model->jabatan_id = !empty($model->jabatan_id) ? $model->jabatan->jabatan_nama : '-';
                                echo $form->textField($model, 'jabatan_id', array('readonly' => true));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="glyphicon glyphicon-file"></i> Form <b>Cuti</b>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <?php echo CHtml::hiddenField('url', $this->createUrl('', array('idPegawai' => $model->pegawai_id)), array('readonly' => TRUE)); ?>
                            <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                            <?php echo $form->hiddenField($modPegawaicuti, 'lamacuti_konfigsystem', array('readonly' => TRUE)); ?>
                            <?php echo $form->dropDownListRow($modPegawaicuti, 'jeniscuti_id', CHtml::listData($modPegawaicuti->getJeniscutiItems(), 'jeniscuti_id', 'jeniscuti_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => 'return $(this).focusNextInputField(event)')) ?>
                            <div class="control-group">
                                <?php echo CHtml::label("Tgl. Cuti", 'tglpresensi', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <div class="daterange daterange-inline input-inline setIndikator span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($modPegawaicuti->tglmulaicuti)) ?>" data-end-date="<?php echo date('d M Y', strtotime($modPegawaicuti->tglakhircuti)) ?>">
                                        <i class="entypo-calendar"></i>
                                        <span><?php echo date('d M Y', strtotime($modPegawaicuti->tglmulaicuti)) ?> - <?php echo date('d M Y', strtotime($modPegawaicuti->tglakhircuti)) ?></span>
                                        <?php
                                        $modPegawaicuti->tglmulaicuti = date('d/m/Y', strtotime($modPegawaicuti->tglmulaicuti));
                                        echo $form->hiddenField($modPegawaicuti, 'tglmulaicuti', array('class' => 'start', 'onchange' => 'cekLama();')) ?>
                                        <?php
                                        $modPegawaicuti->tglakhircuti = date('d/m/Y', strtotime($modPegawaicuti->tglakhircuti));
                                        echo $form->hiddenField($modPegawaicuti, 'tglakhircuti', array('class' => 'end', 'onchange' => 'cekLama();')) ?>
                                    </div>
                                </div>
                            </div>
                            <?php /*
                        <div class="control-group">
                            <?php echo $form->labelEx($modPegawaicuti,'tglmulaicuti',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php   
                                $this->widget('MyDateTimePicker',array(
                                    'model'=>$modPegawaicuti,
                                    'attribute'=>'tglmulaicuti',
                                    'mode'=>'date',
                                    'options'=> array(
                                        'showOn' => false,
                                        // 'maxDate' => 'd',
                                        'yearRange'=> "-150:+0",
                                    ),
                                    'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                    ),
                                )); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPegawaicuti,'tglakhircuti',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php   
                                $this->widget('MyDateTimePicker',array(
                                    'model'=>$modPegawaicuti,
                                    'attribute'=>'tglakhircuti',
                                    'mode'=>'date',
                                    'options'=> array(
                                        'showOn' => false,
                                        // 'maxDate' => 'd',
                                        'yearRange'=> "-150:+0",
                                    ),
                                    'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                    ),
                                )); ?>    
                            </div>
                        </div>
                         * 
                         */ ?>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawaicuti, 'lamacuti', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($modPegawaicuti, 'lamacuti', array('readonly' => true, 'onblur' => 'cekLama();', 'class' => 'span1', 'onkeypress' => '$(this).focusNextInputField(event)', 'style' => 'text-align:right;')) . ' hari'; ?>
                                </div>
                            </div>
                            <?php //echo $form->textFieldRow($modPegawaicuti,'noskcuti',array('class'=>'span3','onkeypress'=>'$(this).focusNextInputField(event)')) 
                            ?>

                            <div class="control-group">
                                <?php echo CHtml::label("Pemohon <span class='required'>*</span>", 'pegawai_id', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->hiddenField($modPegawaicuti, 'pegawai_id', array('readonly' => true)) ?>
                                    <?php echo $form->textField($modPegawaicuti, 'nama_pegawai', array('class' => 'span4', 'readonly' => true)) ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <?php /*
                        <div class="control-group">
                            <?php echo $form->labelEx($modPegawaicuti,'tglditetapkanskcuti',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php   
                                $this->widget('MyDateTimePicker',array(
                                    'model'=>$modPegawaicuti,
                                    'attribute'=>'tglditetapkanskcuti',
                                    'mode'=>'date',
                                    'options'=> array(
                                        'showOn' => false,
                                        // 'maxDate' => 'd',
                                        'yearRange'=> "-150:+0",
                                    ),
                                    'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                    ),
                            )); ?>    
                            </div>
                        </div>
                               * 
                               */ ?>
                            <div class="control-group">
                                <?php echo CHtml::label("Keperluan <span class='required'>*</span>", 'keperluancuti', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textArea($modPegawaicuti, 'keperluancuti', array('placeholder' => 'Keperluan', 'class' => 'required autogrow', 'onkeypress' => '$(this).focusNextInputField(event)')) ?>
                                </div>
                            </div>
                            <?php echo $form->textAreaRow($modPegawaicuti, 'keterangan', array('placeholder' => 'Keterangan', 'onkeypress' => '$(this).focusNextInputField(event)', 'class' => ' autogrow')) ?>
                            <?php

                            $cr = new CDbCriteria();
                            $cr->addCondition('pegawai_aktif = true');
                            $cr->compare('jabatan_id', array(
                                38, 39, 91, 32, 94, 95, 96, 97, 98, 99, 2, 3,
                                39, 14, 15, 11, 53, 1, 92, 93
                            ));
                            $cr->order = 'nama_pegawai';
                            $peg = PegawaiM::model()->findAll($cr);

                            //                        echo $form->dropDownListRow($modPegawaicuti,'pejabatmengetahui', CHtml::listData($peg, 'pegawai_id', 'nama_pegawai'),array('class'=>'required','empty'=>'-- Pilih --','onkeypress'=>'return $(this).focusNextInputField(event)')) 
                            ?>
                            <div class="control-group">
                                <?php echo CHtml::label("Atasan Langsung", 'pejabatmengetahui', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo CHtml::activeHiddenField($modPegawaicuti, 'pejabatmengetahui'); ?>
                                    <div style="float:left;">
                                        <?php $this->widget('MyJuiAutoComplete', array(
                                            'model' => $modPegawaicuti,
                                            'attribute' => 'pejabatmengetahui_nama',
                                            'sourceUrl' => $this->createUrl('PegawaiMengetahui'),
                                            'options' => array(
                                                'showAnim' => 'fold',
                                                'minLength' => 2,
                                                'select' => 'js:function( event, ui ) {
                                            $("#' . CHtml::activeId($modPegawaicuti, 'pejabatmengetahui') . '").val(ui.item.pegawai_id);
                                        }',
                                            ),
                                            'tombolDialog' => array('idDialog' => 'dialogPejabatMengetahui'),
                                            'htmlOptions' => array(
                                                'placeholder' => 'Atasan Langsung',
                                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                                'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modPegawaicuti, 'pejabatmengetahui') . '").val(""); ',
                                                'class' => 'span3 required', 'style' => 'float:left;'
                                            ),
                                        )); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label("Bagian Kepegawaian", '', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->hiddenField($modPegawaicuti, 'pejabatmenyetujui', array('readonly' => true)) ?>
                                    <?php echo $form->textField($modPegawaicuti, 'pejabatmenyetujui_nama', array('readonly' => true)) ?>
                                </div>
                            </div>

                            <?php // echo $form->dropDownListRow($modPegawaicuti,'pejabatmenyetujui',CHtml::listData($modPegawaicuti->getPegawaiItems(),'nama_pegawai','nama_pegawai'),array('empty'=>'-- Pilih --','onkeypress'=>'return $(this).focusNextInputField(event)')) 
                            ?>

                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <?php
                if (!isset($_GET['sukses'])) {
                    echo CHtml::htmlButton(
                        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')) :
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'submitButton', 'onclick' => 'return cekValidasiCuti();', 'onKeypress' => 'return formSubmit(this,event)')
                    );
                } else {
                    echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'id' => 'submitButton', 'disabled' => true)
                    );
                }

                ?>
                <?php echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    '#',
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl('index') . '";}); return false;'
                    )
                ); ?>
            </div>
        </div>

    </div>

</fieldset>

<?php
$this->endWidget();
$urlGetPegawaicuti = $this->createUrl('GetPegawaicuti');
$pegawai_id = $model->pegawai_id;
$js = <<< JS

function Pegawaicutidata()
{
    pegawai_id = {$pegawai_id};
    if(pegawai_id==''){
        myAlert('Anda belum memilih pegawai');
        return false;
    }else{
        $.post("${urlGetPegawaicuti}", {pegawai_id:pegawai_id,},
        function(data){
            $("#tableRiwayatPegawaicuti").children("tbody").append(data.tr);
        }, "json");
    }   
}

function ViewPegawaicuti() {
    
    if ($("#cekRiwayatPegawaicuti").is(":checked")) {
        Pegawaicutidata();
        $("#tableRiwayatPegawaicuti").slideDown(60);
    } else {
        $("#tableRiwayatPegawaicuti").children("tbody").children("tr").remove();
        $("#tableRiwayatPegawaicuti").slideUp(60);
    }
}
$(document).ready(function(){
    // Pegawaicutidata();
});
JS;
Yii::app()->clientScript->registerScript('pencatatanriwayat', $js, CClientScript::POS_HEAD);
?>
<script type="text/javascript">
    function hapus(obj) {
        myConfirm('Anda yakin akan menghapus item ini?', 'Perhatian!',
            function(r) {
                if (r) {
                    url = $(obj).attr('href');
                    $(location).attr('href', url);
                }
            });

    }

    function cekLama() {
        cekValidasiCuti();
    }

    function cekValidasiCuti() {
        var selisih = parseInt($("#<?php echo CHtml::activeId($modPegawaicuti, 'lamacuti') ?>").val());
        var lamacutisystem = parseInt($("#<?php echo CHtml::activeId($modPegawaicuti, 'lamacuti_konfigsystem') ?>").val());
        if (lamacutisystem == "") {
            lamacutisystem = 0;
        }
        var cutiPegTahunIni = <?php echo $cutiBulanSekarang; ?>;
        if (cutiPegTahunIni > 0) {
            selisih = selisih + cutiPegTahunIni;
        }

        //         console.log(selisih, lamacutisystem);
        if ((selisih > lamacutisystem) && $('#<?php echo CHtml::activeId($modPegawaicuti, 'jeniscuti_id'); ?>').val() !== '2') {
            var nama_pegawai = $("#<?php echo CHtml::activeId($model, 'nama_pegawai') ?>").val();

            myAlert("Nama Pegawai (" + nama_pegawai + ") Lama Cuti yang diajukan sudah melebihi Lama Hak Cuti, Mohon konfirmasi kebagian kepegawaian dan Bagian IT untuk merubah Lama Hak Cuti");

            return false;
        }
        return true;
    }

    function getSelisihHariCuti(awal, akhir) {
        var splitAwal = awal.split("/");
        var splitAkhir = akhir.split("/");

        var cekAwal = new Date(splitAwal[2], splitAwal[1] - 1, splitAwal[0]);
        var cekAkhir = new Date(splitAkhir[2], splitAkhir[1] - 1, splitAkhir[0]);

        var millisecondsPerDay = 1000 * 60 * 60 * 24;
        var millisBetween = cekAkhir.getTime() - cekAwal.getTime();
        var days = (millisBetween / millisecondsPerDay) + 1;


        return Math.floor(days);
    }

    function setIndikator() {
        var awal = $("#<?php echo CHtml::activeId($modPegawaicuti, 'tglmulaicuti') ?>").attr('value');
        var akhir = $("#<?php echo CHtml::activeId($modPegawaicuti, 'tglakhircuti') ?>").attr('value');
        var selisih = getSelisihHariCuti(awal, akhir);

        $("#<?php echo CHtml::activeId($modPegawaicuti, 'lamacuti') ?>").val(selisih);
        cekLama();
    }

    function getFocus() {
        $("#<?php echo CHtml::activeId($modPegawaicuti, 'keperluancuti') ?>").focus();
    }

    jQuery(document).ready(function() {
        //        jQuery("div.range_inputs").on('click', 'button.applyBtn', function() {
        //            //$("#<?php // echo CHtml::activeId($modPegawaicuti, 'lamacuti') 
                            ?>").focus();
        //            
        //        });       

        var bulanini = <?php echo $bulanIni; ?>;
        var checkCuti = <?php echo Params::CUTI_KERJA; ?>;

        var cutiPegTahunIni = <?php echo $cutiBulanSekarang; ?>;
        var lamacutisystemPeg = $("#<?php echo CHtml::activeId($modPegawaicuti, 'lamacuti_konfigsystem') ?>").val();
        if (lamacutisystemPeg == "") {
            lamacutisystemPeg = 0;
        }
        //        console.log(cutiPegTahunIni);
        if (cutiPegTahunIni > lamacutisystemPeg) {
            var nama_pegawai = $("#<?php echo CHtml::activeId($model, 'nama_pegawai') ?>").val();

            myAlert("Nama Pegawai (" + nama_pegawai + ") Lama Cuti yang diajukan sudah melebihi Lama Hak Cuti, Mohon konfirmasi kebagian kepegawaian dan Bagian IT untuk merubah Lama Hak Cuti");
        }

        if (checkCuti >= bulanini) {
            $(document).on('keyup', function(evt) {
                if (evt.keyCode == 27) {
                    //window.location.href = "<?php //echo  $this->createUrl("/kepegawaian/&modul_id=".Yii::app()->session['modul_id']);
                                                ?>";
                    location.reload();
                }
            });
            myConfirm('Maaf, Masa Anda bekerja belum mencapai lebih dari <b>' + checkCuti + ' Bulan</b>, yakin ingin melanjutkan Permohonan Cuti? ', 'Perhatian!', function(r) {
                if (r) {
                    //window.location.href = "<?php //echo  $this->createUrl("/rawatJalan/&modul_id=".Yii::app()->session['modul_id']);//$this->createUrl("/site/logout/"); 
                                                ?>";
                    //location.reload();
                } else {
                    $("body").hide();
                    //window.location.href = "<?php //echo $this->createUrl("/rawatJalan/&modul_id=".Yii::app()->session['modul_id']); 
                                                ?>";
                    //location.reload();
                }
            });
        }

        //        setInterval(function(){
        //            var awal = $("#<?php // echo CHtml::activeId($modPegawaicuti, 'tglmulaicuti') 
                                        ?>").attr('value');
        //            var akhir = $("#<?php // echo CHtml::activeId($modPegawaicuti, 'tglakhircuti') 
                                        ?>").attr('value');
        //            var selisih = getSelisihHariCuti(awal, akhir);
        //
        //            $("#<?php // echo CHtml::activeId($modPegawaicuti, 'lamacuti') 
                            ?>").val(selisih);
        //        }, 250);
    });
</script>

<?php
//========= Dialog buat cari data Pemberi Tugas =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPejabatMengetahui',
    'options' => array(
        'title' => 'Pencarian Atasan Langsung',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_KEPEGAWAIAN) {
    $classPegawai = 'PegawaiV';
    $modPegMenyetujui = new $classPegawai('search');
    $modPegMenyetujui->unsetAttributes();
} else {
    $classPegawai = 'PegawairuanganV';
    $modPegMenyetujui = new $classPegawai('search');
    $modPegMenyetujui->unsetAttributes();
    $modPegMenyetujui->ruangan_id = Yii::app()->user->getState('ruangan_id');
}

if (isset($_GET[$classPegawai])) {
    $modPegMenyetujui->attributes = $_GET[$classPegawai];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegmenyetujui-m-grid',
    'dataProvider' => $modPegMenyetujui->searchPegawaiRuangan(),
    'filter' => $modPegMenyetujui,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                "id" => "selectPegMengetahui",
                                "onClick" => "$(\"#' . CHtml::activeId($modPegawaicuti, 'pejabatmengetahui') . '\").val(\"$data->pegawai_id\");
                                              $(\"#' . CHtml::activeId($modPegawaicuti, 'pejabatmengetahui_nama') . '\").val(\"$data->namaLengkap\");
                                              $(\"#dialogPejabatMengetahui\").dialog(\"close\");    
                                              return false;
                                    "))',
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPegMenyetujui, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            }
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Pemberi Tugas dialog =============================
?>