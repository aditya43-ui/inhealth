<?php
/**
 * Form untuk menginput transaksi kantong darah pendonor
 * Ditempatkan pada tabulasi Obeservasi Donor Darah
 * 
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @author Andyka Putra <andykaputra@.com>
 */
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Pencatatan Kantong Darah</div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Pencatatan Kantong Darah</div>
            </div>
            <div class="panel-body">
                <?php
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'kantongdarah-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
                ));
                ?>
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?> 
                <div class="col-sm-12">
                    <div class="control-group ">
                        <?php echo CHtml::label('Cari Donor', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php 
                            echo $form->hiddenField($modPendonor, 'pendonor_id', array('readonly' => true, 'class'=>'donorid reset')); 
                            echo CHtml::hiddenField("sudahAdaPegawai",'');
                            $this->widget('MyJuiAutoComplete', array(
                                'name' => 'no_lengkap',
                                'source' => 'js: function(request, response) {
                                   $.ajax({
                                       url: "' . $this->createUrl('AutocompletePendonor') . '",
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
                                    'focus' => 'js:function( event, ui ) {
                                                    $(this).val( ui.item.label);
                                                    return false;
                                                }',
                                    'select' => 'js:function( event, ui ) {
                                                    $("#' . Chtml::activeId($model, 'pendonor_id') . '").val(ui.item.pendonor_id); 
                                                    return false;
                                                }',
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => 'Ketik Nomor Donor Lama',
                                    'class' => 'span3 donornama',
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogPendonor'),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="box-seleksidonor" hidden>
                        <?php 
                            $this->renderPartial('seleksiDonor/_index', [
                                'modSeleksi' => $modSeleksi,
                                'form' => $form,
                                'modPendonor' => $modPendonor
                            ]);
                        ?>
                    </div>   
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <label class="control-label">Pilih Tahun</label>
                        <div class="controls">
                            <?php 
                            echo CHtml::dropDownList('KantongdarahT[tahun]',date('Y'), CustomFunction::getTahun(0,10), array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Pilih Bulan", "", array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            if(!empty($_GET['bulan'])){
                                $model->bulan = $_GET['bulan'];
                            }
                            echo $form->dropDownList($model, 'bulan', 
                                    array('01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni',
                                          '07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember'), array('empty' => '-- Pilih --'));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <label class="control-label">No. Kantong Pabrik <span class="required">*</span></label>
                        <div class="controls">
                            <?php echo $form->textField($model, 'no_kantongpabrik', ['class' => 'required']) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Jenis Kantong Darah <span class='required'>*</span>", "", array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($model, 'jeniskantongdarah_id', CHtml::listData(JeniskantongdarahM::model()->findAllByAttributes(array('jeniskantongdarah_aktif' => true)), 'jeniskantongdarah_id', 'nama_jenis'), array(
                                'id' => 'jeniskantongdarah_id',
                                'empty' => '-- Pilih --',
                                'onchange' => 'pilihJenisKantongDarah();',
                                'class' => 'required'
                                    )
                            );
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Jenis Komponen Darah", "", array('class' => 'control-label')); ?>
                        <div class="controls komponen">
                            <?php
                            foreach ($models as $model) {
                                $kom = KomponendarahM::model()->findByPk($model->komponendarah_id);
                                echo CHtml::textField('komponen[' . $model->komponendarah_id . ']kode', $kom->singkatan_komp, array(
                                    'class' => 'span1',
                                    'readonly' => true,
                                ));
                                echo CHtml::textField('komponen[' . $model->komponendarah_id . ']no', substr($model->no_kantongdarah, strlen($kom->singkatan_komp)), array(
                                    'class' => 'span2',
                                    'readonly' => true,
                                ));
                                echo "<br/>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php CHtml::label("Jumlah Input", "", array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php 
                                if(!empty($_GET['jml_input'])){
                                    $model->jml_input = $_GET['jml_input'];
                                }
                                echo $form->hiddenField($model, 'jml_input', array('empty' => '-- Pilih --','onchange' => 'pilihJenisKantongDarah();',)); 
                            ?>
                        </div>
                    </div>
                    <?php
                    $sample = '-- Otomatis --';
                    $utama = '-- Otomatis --';
                    $imltd = '-- Otomatis --';

                    if (!empty($model->kantongdarah_id)) {
                        $sample = $model->nomorbarcode_sample;
                        $utama = $model->nomorbarcode_utama;
                        $imltd = $model->nomorbarcode_sample_imltd;
                    }
                    ?>
                </div>
                <div class="clear"></div>
                <hr/>
                <div class="col-sm-6">
                    <div class="control-group ">
                        <?php echo $form->labelEx($model, 'tglpencatatan', array('class' => 'control-label', 'label' => 'Tgl. Pencatatan')); ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglpencatatan',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'tglpencatatan'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group ">
                        <?php echo Chtml::label("Petugas <font style='color:red'>*</font>", 'petugaspencatat_id', array('class' => 'control-label'));
                        ?>
                        <div class="controls">
                            <?php
                            $modLogin = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
                            $nama = '';
                            if (isset($modLogin)) {
                                $modPegawai = PegawaiM::model()->findByPk($modLogin->pegawai_id);
                                if (isset($modPegawai)) {
                                    $model->petugaspencatat_id = $modPegawai->pegawai_id;
                                    $nama = $modPegawai->nama_pegawai;
                                }
                            }

                            echo $form->hiddenField($model, 'petugaspencatat_id', array('class' => 'required', 'readonly' => true));
                            echo CHtml::textField('pegawai', $nama, array('class' => 'required', 'readonly' => true)); 
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Nama DPJP <span class="required">*</span>', '', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->hiddenField($modSeleksi, 'dpjpkuesioner_id', array('class' => 'required')) ?>
                           
                            <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $modSeleksi,
                                    'attribute' => 'dpjpkuesioner_nama',
                                    'source' => 'js: function(request, response) {
                                                    $.ajax({
                                                        url: "' . $this->createUrl('AutocompleteDpjp') . '",
                                                        dataType: "json",
                                                        data: {
                                                            term: request.term,
                                                            ruangan_id:' . Yii::app()->user->getState('ruangan_id') . '
                                                        },
                                                        success: function (data) {
                                                            response(data);
                                                        }
                                                    })
                                                }',
                                    'options' => array(
                                        'showAnim' => 'fold',
                                        'minLength' => 3,
                                        'focus' => 'js:function( event, ui ) {
                                                                $(this).val("");
                                                                return false;
                                                            }',
                                        'select' => 'js:function( event, ui ) {
                                                        $(this).val(ui.item.label);
                                                        $("#' . CHtml::activeId($modSeleksi, 'dpjpkuesioner_id') . '").val(ui.item.pegawai_id);
                                                        return false;
                                                }',
                                    ),
                                    'htmlOptions' => array(
                                        'onkeyup' => "return $(this).focusNextInputField(event)",
                                        'class' => 'span3 required',
                                        'onblur' => 'if(this.value == "") $("#' . CHtml::activeId($modSeleksi, 'dpjpkuesioner_id') . '").val(""); '
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogDPJP'),
                                ));?>
                            
                          
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form-actions">
                    <?php
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array(
                        'class' => 'btn btn-primary ' . (!$model->isNewRecord ? '' : 'submit'),
                        'disabled' => !$model->isNewRecord,
                        'type' => 'submit',
                        'onclick' => 'formSubmit(this,event);',
                        'onkeypress' => 'formSubmit(this,event);'));
                    echo "&nbsp;";
                    if (!isset($_GET['frame'])) {
                        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index', array()), array('class' => 'btn btn-danger',
                            'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index', array()) . '";}); return false;'));
                        echo "&nbsp;";
                    }
                    echo CHtml::link(Yii::t('mds', '{icon} Print Barcode', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('disabled' => $model->isNewRecord, 'class' => 'btn btn-info', 'onclick' => "printBarcodeLab();return false"));
                    echo "&nbsp;";
                    CHtml::link(Yii::t('mds', '{icon} Print Barcode Komponen', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('disabled' => $model->isNewRecord, 'class' => 'btn btn-info', 'onclick' => "printBarcodeKomponen();return false"));
                    ?> 
                </div>

                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>

<?php $this->renderPartial('dialog/_dialogDaftarPendonor'); ?>
<?php $this->renderPartial('dialog/_dialogDPJP'); ?>
<?php 
    $this->renderPartial('seleksiDonor/_jsFunctions', [
        'modPendonor' => $modPendonor
    ]); 
?>
<?php
//========= Dialog buat cari Petugas ==========
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPetugas',
    'options' => array(
        'title' => 'Daftar Petugas Koreksi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'resizable' => false,
    ),
));

$modPegawai = new PegawairuanganV();
$modPegawai->unsetAttributes();
if (isset($_GET['PegawairuanganV']))
    $modPegawai->attributes = $_GET['PegawairuanganV'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'petugassample-m-grid',
    'dataProvider' => $modPegawai->searchPegawaiBankDarah(),
    'filter' => $modPegawai,
    'template' => "{items}\n{pager}",
    //    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'pegawai_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                        "id" => "selectBahan",
                        "onClick" => "
                                $(\'#' . Chtml::activeId($model, 'petugaskoreksi_id') . '\').val(\'$data->pegawai_id\');	
                                $(\'#' . Chtml::activeId($model, 'petugaskoreksi_nama') . '\').val(\'$data->NamaLengkap\');
                                $(\'#dialogPetugas\').dialog(\'close\');
                                return false;"))',
        ),
        array(
            'header' => 'NIP',
            'filter' => CHtml::activeTextField($modPegawai, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawai, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function($data) {
                $hasil = '';
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    $hasil = $j->jabatan_nama;
                }
                return $hasil;
            },
            'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= Dialog buat cari Petugas ==========
?>
<?php
/* ====================================== Widget Dialog PPDS ====================================== */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPPDS',
    'options' => array(
        'title' => 'Daftar PPDS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 600,
        'resizable' => false,
    ),
));
$modPPDS = new PpdsM('searchDialog');
$modPPDS->unsetAttributes();
$modPPDS->ppds_aktif = true;
if (isset($_GET['PpdsM'])) {
    $modPPDS->attributes = $_GET['PpdsM'];
    $modPPDS->programstudi_nama = $_GET['PpdsM']['programstudi_nama'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ppds-m-grid',
    'dataProvider' => $modPPDS->searchDialog(),
    'filter' => $modPPDS,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                        "id" => "selectBahan",
                        "onClick" => "
                                $(\'#' . Chtml::activeId($model, 'ppds_id') . '\').val(\'$data->ppds_id\');	
                                $(\'#' . Chtml::activeId($model, 'ppds_nama') . '\').val(\'$data->ppds_nama\');
                                $(\'#dialogPPDS\').dialog(\'close\');
                                return false;"))',
        ),
        array(
            'header' => 'NIM',
            'name' => 'ppds_nim'
        ),
        array(
            'header' => 'Nama PPDS',
            'name' => 'ppds_nama'
        ),
        array(
            'header' => 'Program Studi',
            'value' => '$data->programstudi->programstudi_nama',
            'filter' => Chtml::activeTextField($modPPDS, 'programstudi_nama')
        ),
        array(
            'header' => 'Tahap',
            'name' => 'ppds_tahap',
            'filter' => Chtml::activeTextField($modPPDS, 'ppds_tahap')
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
/* ====================================== endWidget Dialog Pegawai ====================================== */
?>
<?php
//========= Dialog buat cari Petugas ==========
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Daftar Dokter',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'resizable' => false,
    ),
));

$modPegawai = new PegawairuanganV('searchDokter');
$modPegawai->unsetAttributes();
if (isset($_GET['PegawairuanganV']))
    $modPegawai->attributes = $_GET['PegawairuanganV'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dokter-m-grid',
    'dataProvider' => $modPegawai->searchDokter(),
    'filter' => $modPegawai,
    'template' => "{items}\n{pager}",
    //    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'pegawai_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                        "id" => "selectBahan",
                        "onClick" => "
                            $(\'#' . Chtml::activeId($model, 'dpjp_id') . '\').val(\'$data->pegawai_id\');	
                            $(\'#dpjp_nama\').val(\'$data->NamaLengkap\');
                            $(\'#dialogDokter\').dialog(\'close\');
                            return false;"))',
        ),
        array(
            'header' => 'NIP',
            'filter' => CHtml::activeTextField($modPegawai, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawai, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function($data) {
                $hasil = '';
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    $hasil = $j->jabatan_nama;
                }
                return $hasil;
            },
            'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= Dialog buat cari Petugas ==========
?>
<script>

    function ubahDialog() {
        if ($('#cek_ppds').is(':checked')) {
            $("#petugaskoreksi").hide();
            $("#KantongdarahT_petugaskoreksi_id").val("");
            $("#KantongdarahT_petugaskoreksi_nama").val("");
            $("#KantongdarahT_petugaskoreksi_id").removeClass("required");
            $("#KantongdarahT_ppds_id").addClass("required");
            $("#ppds").show();
        } else {
            $("#ppds").hide();
            $("#KantongdarahT_ppds_id").val("");
            $("#KantongdarahT_ppds_nama").val("");
            $("#KantongdarahT_ppds_id").removeClass("required");
            $("#KantongdarahT_petugaskoreksi_id").addClass("required");
            $("#petugaskoreksi").show();
        }
    }

    function setPPDS(data) {
        $("#BDSeleksipendonorT_ppds_id").val(data.ppds_id);
        $("#BDSeleksipendonorT_ppds_nama").val(data.ppds_nama);
    }

    function printBarcodeLab()
    {
        window.open('<?php echo $this->createUrl('PrintBarcode', array('kantongdarah_id' => $model->kantongdarah_id, 'bulan' => isset($_GET['bulan'])?$_GET['bulan']:null, 'jml_input' => isset($_GET['jml_input'])?$_GET['jml_input']:null)); ?>', 'printwin', 'left=100,top=100,width=480,height=640');
    }

    function printBarcodeKomponen()
    {
        window.open('<?php echo $this->createUrl('PrintBarcodeKomponen', array('kantongdarah_id' => $model->kantongdarah_id, 'bulan' => isset($_GET['bulan'])?$_GET['bulan']:null, 'jml_input' => isset($_GET['jml_input'])?$_GET['jml_input']:null)); ?>', 'printwin', 'left=100,top=100,width=480,height=640');
    }
    function pilihJenisKantongDarah() {
        var id = $("#jeniskantongdarah_id").val();
        var jml_input = $("#KantongdarahT_jml_input").val();
        $.post('<?php echo $this->createUrl('getJenisKantongDarah'); ?>', {
                id: id, jml_input:jml_input
            },
            function (data) {
                $(".komponen").html(data.html);
            },
        'json');
    }

    $(document).ready(function () {
        ubahDialog();
    });
</script>