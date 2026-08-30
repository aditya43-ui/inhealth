<?php

$profil = ProfilrumahsakitM::model()->find();
$konfig = KonfigsystemK::model()->find();

?>
<div class="form_panel form_bpjs" style="display: none;">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Data Pasien</div>
        </div>
        <div class="panel-body">
            <div class="row-fluid">
                <div class="col-sm-6">
                    <?php echo $form->textFieldRow($modPasien, 'no_rekam_medik', array(
                        'class'=>'span3', 'readonly'=>true,
                    )); ?>
                    <?php echo $form->textFieldRow($modSep, 'nokartuasuransi', array(
                        'class'=>'span3', 'readonly'=>true,
                    )); ?>
                    <?php echo $form->textFieldRow($modPasien, 'no_identitas_pasien', array(
                        'class'=>'span3', 'readonly'=>true,
                    )); ?>
                    <?php echo $form->textFieldRow($modPasien, 'nama_pasien', array(
                        'class'=>'span3', 'readonly'=>true,
                    )); ?>
                    <?php echo $form->textFieldRow($modPasien, 'tanggal_lahir', array(
                        'class'=>'span3', 'readonly'=>true,
                    )); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo $form->textFieldRow($model, 'tgl_pendaftaran', array(
                        'class'=>'span3', 'readonly'=>true,
                    )); ?>
                    <?php echo $form->textFieldRow($model, 'ruangan_id', array(
                        'class'=>'span3', 'readonly'=>true,
                    )); ?>
                    <?php echo $form->textFieldRow($model, 'pegawai_id', array(
                        'class'=>'span3', 'readonly'=>true,
                    )); ?>
                    <?php echo $form->textFieldRow($model, 'no_urutantri', array(
                        'class'=>'span3', 'readonly'=>true,
                    )); ?>
                    <?php echo $form->textFieldRow($model, 'kode_ruangan_bpjs', array(
                        'class'=>'span3', 'readonly'=>true,
                    )); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Data SEP</div>
        </div>
        <div class="panel-body">
            <?php echo CHtml::hiddenField('data_pasien', null); ?>
            <?php echo CHtml::hiddenField('data_rujukan', null); ?>
            <?php echo $form->hiddenField($modAsuransiPasien, 'asuransipasien_id'); ?>
            <?php echo $form->hiddenField($modSep, 'jenisfaskes'); ?>
            <?php // echo $form->hiddenField($modSep, 'politujuan'); ?>
            <?php // echo $form->hiddenField($modSep, 'jenis_kunjungan'); ?>
            <?php // echo $form->hiddenField($modSep, 'flag_procedure'); ?>
            <?php // echo $form->hiddenField($modSep, 'kode_penunjang'); ?>
            <?php // echo $form->hiddenField($modSep, 'asesmen_pelayanan'); ?>
            <?php echo $form->hiddenField($model, 'buatjanjipoli_id'); ?>

            <div class="row-fluid">
                <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Cari ".$modRujukanBpjs->getAttributeLabel('no_rujukan')." <i class=\"icon-search\" onclick=\"$('#dialogNoRujukan').dialog('open'); cariDataNoRujukan();\", style=\"cursor:pointer;\" rel=\"tooltip\" title=\"klik untuk mengecek rujukan\"></i>", 'no_rujukan', array('class'=>'control-label'))?>
                        <div class="controls">
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $modRujukanBpjs,
                                'attribute' => 'no_rujukan',
                                'options' => array(
                                    'focus' => 'js:function( event, ui ) {
                                                            $(this).val("");
                                                            return false;
                                                        }',
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => 'Ketik Nomor Rujukan',
        
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'onblur' => "",
                                    'class' => 'angkahuruf-only span3'
                                ),
                            ));
                            ?>
                            <?php echo $form->error($modRujukanBpjs, 'no_rujukan'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modSep, 'politujuan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modSep, 'politujuan', 
                            CHtml::listData(SpesialissubspesialisM::model()->findAll('spesialissubspesialis_aktif = true order by spesialissubspesialis_nama asc'), 'spesialissubspesialis_kodebpjs', 'spesialissubspesialis_kodebpjs'),
                            array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modSep, 'tglsep', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $modSep->tglsep = MyFormatter::formatDateTimeForUser(empty($modSep->tglsep) ? date("Y-m-d") : date("Y-m-d", strtotime($modSep->tglsep)));
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modSep,
                                'attribute' => 'tglsep',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    //'showOn' => false,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('class' => 'dtPicker3 span3', 'onkeyup' => "return $(this).focusNextInputField(event)",),
                            )); ?>
                            <?php echo $form->error($modSep, 'tglsep'); ?>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <?php echo CHtml::label("PPK Asal Peserta <i class=\"icon-search\" onclick=\"getBpjsPPKRujukan($('#" . CHtml::activeId($modSep, "ppkrujukan") . "').val());\", style=\"cursor:pointer;\" rel='tooltip' title='klik untuk mengecek PPK Rujukan'></i>", 'ppkrujukan', array('class' => 'control-label')) ?>
                        <div class="controls">
                
                            <?php echo $form->textField($modSep, 'ppkrujukan', array('placeholder' => '', 'class' => 'span3 all-caps', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Nomor PPK Asal Peserta
                        </label>
                        <div class="controls">
                            <?php echo $form->textField($modRujukanBpjs, 'nama_perujuk', array('placeholder' => 'Nomor PPK Asal Peserta', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modAsuransiPasien, 'jenispeserta_id', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->hiddenField($modAsuransiPasien, 'jenispersertakode_bpjs'); ?>
                            <?php echo $form->textField($modAsuransiPasien, 'jenispeserta_bpjs', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("No. Telepon Peserta <span class='required'>*</span>", 'no_telpon_peserta', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modSep, 'no_telpon_peserta', array('placeholder' => 'Telepon peserta', 'class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo $form->labelEx($modSep, 'jenis_kunjungan', array('class'=>'control-label', 'label'=>'Jenis Kunjungan <span class="required">*</span>')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modSep, 'jenis_kunjungan', LookupM::getItemsUrutan('bpjs_jnskunjungan'), array(
                                'class'=>'span3', //'onchange'=>'pilihJenisKunjunganBPJS();'
                            )); ?>
                            <?php echo $form->dropDownListRow($modSep, 'flag_procedure', LookupM::getItemsUrutan('bpjs_flagprocedure'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?>
                            <?php echo $form->dropDownListRow($modSep, 'kode_penunjang', LookupM::getItemsUrutan('bpjs_kdpenunjang'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modSep, 'asesmen_pelayanan', array('class'=>'control-label', 'label'=>'Asesmen Pelayanan')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modSep, 'asesmen_pelayanan', LookupM::getItemsUrutan('bpjs_asesmenpelayanan'), array('empty'=>'-- Pilih --', 'class'=>'span3')); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <label class="control-label" for="ARRujukanbpjsT_tanggal_rujukan">
                            Tanggal Rujukan
                            <span class="required">*</span>
                        </label>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modRujukanBpjs,
                                'attribute' => 'tanggal_rujukan',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'showOn' => false,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('class' => 'dtPicker2 span3', 'onkeyup' => "return $(this).focusNextInputField(event)",),
                            )); ?>
                            <?php echo $form->error($modRujukanBpjs, 'tanggal_rujukan'); ?>
                        </div>
                    </div>
                    <div class="panel_kontrol">
                        <div class="control-group">
                            <?php echo CHtml::label("Nomor Surat Kontrol", 'Nomor Surat Kontrol', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modSep, 'no_surat', array('placeholder' => "Nomor Surat Kontrol", 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 30, 'rel' => 'tooltip', 'title' => 'Isi jika pasien dengan surat kontrol')); ?>
                                <?php echo CHtml::link("<i class='icon-search'></i>", 'javascript:void(0)', array("rel" => "tooltip", "title" => "klik untuk car Surat Kontrol Pasien", "onclick" => "cariSuratKontrol(); return true;")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("DPJP Pemberi Surat Kontrol", 'nama_dpjp', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modSep, 'nama_dpjp', array('placeholder' => "DPJP Pemberi Surat Kontrol", 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => 'Isi jika pasien dengan surat kontrol', 'onblur' => "if($(this).val()=='') $('#" . CHtml::activeId($model, 'kode_dpjp') . "').val('')")); ?>
                                <?php echo CHtml::link("<i class='icon-search'></i>", 'javascript:void(0)', array("rel" => "tooltip", "title" => "klik untuk cari DPJP", "onclick" => "setCariDPJP(); $('#dialogDpjp').dialog('open');return true;")); ?>
                                <?php echo $form->hiddenField($modSep, 'kode_dpjp', array('placeholder' => 'Dokter DPJP', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php
                        $dpjp_req = "";
                        echo CHtml::label('DPJP yang Melayani', 'nama_dpjp', array('class' => 'control-label'));
                        ?>
                        <div class="controls">
                            <?php echo $form->textField($modSep, 'dpjpygmelayani_nama', array('placeholder' => 'Dokter DPJP', 'class' => 'span3 ' . $dpjp_req, 'onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => 'Isi jika pasien dengan surat kontrol', 'onblur' => "if($(this).val()=='') $('#" . CHtml::activeId($model, 'kode_dpjp') . "').val('')")); ?>
                            <?php echo CHtml::link("<i class='icon-search'></i>", 'javascript:void(0)', array("rel" => "tooltip", "title" => "klik untuk cari DPJP", "onclick" => "setCariDPJP(); $('#dialogDpjpMelayani').dialog('open'); return true;")); ?>
                            <?php echo $form->hiddenField($modSep, 'dpjpygmelayani_kode', array('placeholder' => 'Dokter DPJP', 'class' => 'span3 ' . $dpjp_req, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('No. Sep Sebelumnya', '', array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::textField('nosep_sebelumnya', '', array('empty'=>'-- Pilih --', 'class'=>'span3', 'readonly'=>true)); ?>
                            <?php echo $form->hiddenField($modSep, 'ttd_link', array('id' => 'ttd_link')); ?>
                        </div>
                    </div>
                    <table id="tampung_gambar" width="100%"></table>
                </div>
            </div>
            <div class="form-action">
                <?php
                // echo CHtml::submitButton("Simpan dan Cetak", array(
                //     'class'=>'btn btn-primary', 
                //     'onclick' => 'tandaTangan();', 
                // )); 
                ?>
                <?php
                    echo CHtml::htmlButton(
                        'Simpan dan Cetak',
                        array(
                            'title' => 'Simpan', 
                            'class' => 'btn btn-primary', 
                            'type' => 'button', 
                            'onclick' => 'tandaTangan(); return false;', 
                            'title' => 'Simpan', 
                            'id' => 'btnSubmit'
                        )
                    );
                ?>
                <?php echo CHtml::htmlButton("Ulangi", array(
                    'class'=>'btn btn-danger',
                    'onclick'=>'refreshFormBPJS();',
                )); ?>
            </div>
        </div>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDpjp',
    'options' => array(
        'title' => 'Pencarian Dokter DPJP',
        'autoOpen' => false,
        'modal' => true,
        'width' => 960,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial('_pencarianDpjp');
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDpjpMelayani',
    'options' => array(
        'title' => 'Pencarian Dokter DPJP yang Melayani',
        'autoOpen' => false,
        'modal' => true,
        'width' => 960,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial('_pencarianDpjpMelayani');
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogNoRujukan',
    'options' => array(
        'title' => 'Pencarian Rujukan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 960,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial('_pencarianRujukan');
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog-proses-sjp',
    'options' => array(
        'title' => 'Proses SJP',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 960,
        'minHeight' => 480,
        'resizable' => false,
    ),
));
echo '<iframe id="iframeProsesSJP"  name="iframeProsesSJP" width="100%" height="550" >
</iframe>';
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogSuratKontrol',
    'options' => array(
        'title' => 'Surat Kontrol',
        'autoOpen' => false,
        'modal' => true,
        'width' => 450,
        'height' => 400,
        'resizable' => false,
    ),
)); ?>
<table width="100%" id="tab_sc">
    <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td id="sc_nama_pasien"></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td id="sc_jeniskelamin"></td>
    </tr>
    <tr>
        <td>Tanggal Lahir</td>
        <td>:</td>
        <td id="sc_tanggal_lahir"></td>
    </tr>
    <tr>
        <td>No. Surat</td>
        <td>:</td>
        <td id="sc_nosurat"></td>
    </tr>
    <tr>
        <td>Tanggal Entri</td>
        <td>:</td>
        <td id="sc_tanggal_entri"></td>
    </tr>
    <tr>
        <td>Tanggal Rencana Kontrol</td>
        <td>:</td>
        <td id="sc_tanggal_rencana"></td>
    </tr>
    <tr>
        <td>Poliklinik Tujuan</td>
        <td>:</td>
        <td id="sc_poli_tujuan"></td>
    </tr>
    <tr>
        <td>Dokter Tujuan Kontrol</td>
        <td>:</td>
        <td id="sc_dokter_kontrol"></td>
    </tr>
    <tr>
        <td>No SEP</td>
        <td>:</td>
        <td id="sc_no_sep"></td>
    </tr>
    <tr>
        <td>Tanggal SEP</td>
        <td>:</td>
        <td id="sc_tgl_sep"></td>
    </tr>
    <tr>
        <td style="color: red; font-weight: bold; text-align: center;" id="sc_status" colspan="3"></td>
    </tr>
    <tr>
        <td style="text-align: center" colspan="3">
            <?php echo CHtml::htmlButton('OK', array('class' => 'btn btn-success', 'onclick' => 'setSuratKontrol();')); ?>
        </td>
    </tr>
</table>
<?php
$this->endWidget();

?>
<?php
// Dialog untuk menambah data provinsi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogLihatImg',
    'options' => array(
        'title' => 'Lihat Resep',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 400,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<?php echo CHtml::image('', 'alt', array('id' => 'imageeResep', 'width' => '100%', 'height' => '100%')) ?>
<?php
$this->endWidget();
//========= end propinsi dialog =============================
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog-ttd',
    'options' => array(
        'title' => 'Tanda Tangan',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 700,
        'height' => 700,
        'resizable' => false,
    ),
));
echo '<div class="dialog-content"></div>';
?>
<div class="row col-sm-12" style="float: right; margin-top:320px; margin-left:100px;">
    <table id="tampung_gambar2" width="100%" ></table>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Lanjutkan', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Lanjutkan', 'class' => 'btn btn-danger', 'type' => 'button', 'id' => 'btn-lanjutkan')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')), array('class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'batalDialog("dialog-ttd");')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<script>
    function cekTandaTangan(){
        if ($("#tampung_gambar tr").length == 0){
            myAlert("Lakukan pengisian tanda tangan terlebih dahulu")
        }else{
            disableOnSubmit($('#btnSubmit')); 
            $("#daftar-mandiri-form").submit();
            return false;
        }
    }

    function tandaTangan() {
        $('#dialog-ttd').dialog("open");
        var no_surat = $("#PPSepT_no_surat").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('tandaTangan'); ?>',
            data: {
                no_surat : no_surat
            },
            dataType: "json",
            success: function(data) {
                if (data.ok == 1) {
                    $('#dialog-ttd > .dialog-content').html(data.content);
                    $('#dialog-ttd > #no_surat').html(data.no_surat);
                } else {
                    $('#dialog-ttd > .dialog-content').html('');
                    $('#dialog-ttd').dialog("close");
                    alert(data.msg);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    function refreshFormBPJS() {
        myConfirm("Anda yakin untuk mengulangi ini ?", "Peringatan", function(r) {
            if (r) {
                window.location.replace("<?php echo $this->createUrl('index'); ?>");
            }
        });
    }

    function getRujukanNoRujukan(isi, asalFaskes) {
        if (<?php echo ($konfig->isbridging == true) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }
        if (isi == "") {
            myAlert('Isi data terlebih dahulu!');
            return false;
        };

        if (typeof asalFaskes == 'undefined' || asalFaskes == null || asalFaskes == '') {
            asalFaskes = 1;
        }

        $("#PPRujukanbpjsT_no_rujukan").addClass("animation-loading");

        var aksi = 3; // 3 untuk mencari data rujukan berdasarkan Nomor rujukan
        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query=' + isi + '&query2=' + asalFaskes,
            beforeSend: function() {
                $("#content-bpjs").addClass("animation-loading");
            },
            success: function(data) {
                $("#content-bpjs").removeClass("animation-loading");
                var obj = JSON.parse(data);

                if (obj.metaData.code != 200) {
                    myAlert("Error " + obj.metaData.code + " : " + obj.metaData.message + "\nSilahkan cari/pilih nomor rujukan lagi.");
                    $("#PPRujukanbpjsT_no_rujukan").removeClass("animation-loading");
                    return false;
                }

                if (obj.response.rujukan != null) {
                    var rujukan = obj.response.rujukan;
                    var noKunjungan = rujukan.noKunjungan;
                    var tglKunjungan = rujukan.tglKunjungan;
                    var peserta = rujukan.peserta; //array
                    var provKunjungan = rujukan.provKunjungan; //array
                    var keluhan = rujukan.keluhan;
                    var diagnosa = rujukan.diagnosa; //array
                    var catatan = rujukan.catatan;
                    var pemFisikLain = rujukan.pemFisikLain;
                    var provRujukan = rujukan.provPerujuk; //array
                    var poliRujukan = rujukan.poliRujukan; //array

                    // getRujukanDari(provRujukan.kode);
                    //              getJenisPesertaBpjs(peserta.jenisPeserta.kode);
                    $("#<?php echo CHtml::activeId($modAsuransiPasien, 'jenispersertakode_bpjs') ?>").val(peserta.jenisPeserta.kode);
                    $("#<?php echo CHtml::activeId($modAsuransiPasien, 'jenispeserta_bpjs') ?>").val(peserta.jenisPeserta.keterangan);
                    $("#<?php echo CHtml::activeId($modSep, 'ppkrujukan') ?>").val(peserta.provUmum.kdProvider);

                    $("#<?php echo CHtml::activeId($modSep, 'politujuan') ?>").val(rujukan.poliRujukan.kode);

                    $("#<?php echo CHtml::activeId($modRujukanBpjs, 'no_rujukan') ?>").val(noKunjungan);
                    $("#<?php echo CHtml::activeId($modRujukanBpjs, 'nama_perujuk') ?>").val(provRujukan.nama);
                    $("#<?php echo CHtml::activeId($modRujukanBpjs, 'tanggal_rujukan') ?>").val(tglKunjungan);

                    // setRuanganDariKodeBPJS();
                    //resetDiagnosaBpjs();
                    //setDiagnosaBpjs(diagnosa.kode, diagnosa.nama);
                    $("#PPSepT_ppkrujukan").val(provRujukan.kode);
                    $("#PPAsuransipasienbpjsM_nopeserta").val(peserta.noKartu);
                    $("#PPAsuransipasienbpjsM_nokartuasuransi").val(peserta.noKartu);
                    $("#PPAsuransipasienbpjsM_namapemilikasuransi").val(peserta.nama);
                    //              $("#PPAsuransipasienbpjsM_jenispeserta_id").val(peserta.jenisPeserta.kode);
                    $("#PPAsuransipasienbpjsM_kelastanggunganasuransi_id").val(peserta.hakKelas.kode);
                
                    $("#PPSepT_jenisfaskes").val(obj.response.asalFaskes);

                    if ($("#<?php echo CHtml::activeId($model, 'buatjanjipoli_id') ?>").val().toString().trim() == "") {
                        setRuanganDariKodeBPJS(rujukan.poliRujukan.kode);
                    }
                    
                    $("#data_rujukan").val(JSON.stringify(obj.response));
                
                } else {
                    myAlert(obj.metadata.message);
                }

                $("#PPRujukanbpjsT_no_rujukan").removeClass("animation-loading");
            },
            error: function(data) {
                $("#PPRujukanbpjsT_no_rujukan").removeClass("animation-loading");
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }


    function cariSuratKontrol() {
        var isi = $("#PPSepT_no_surat").val();
        var aksi = 18;


        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query=' + isi,
            beforeSend: function() {
                $("#content-bpjs").addClass("animation-loading");
            },
            success: function(data) {
                // console.log(data);
                $("#content-bpjs").removeClass("animation-loading");
                var res = JSON.parse(data);
                console.log(res);
                if (res.response != null) {
                    data_kontrol = res.response;
                    showDialogSuratKontrol();
                } else {
                    myAlert(res.metaData.message);
                }
            },
            error: function(data) {
                $("#content-bpjs").removeClass("animation-loading");
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);

    }

    function showDialogSuratKontrol() {
        $("#tab_sc #sc_nama_pasien").html(data_kontrol.sep.peserta.nama);
        $("#tab_sc #sc_jeniskelamin").html((data_kontrol.sep.peserta.kelamin == null || data_kontrol.sep.peserta.kelamin == "") ? "-" : (data_kontrol.sep.peserta.kelamin == "L" ? "LAKI-LAKI" : "PEREMPUAN"));
        $("#tab_sc #sc_tanggal_lahir").html(data_kontrol.sep.peserta.tglLahir);
        $("#tab_sc #sc_nosurat").html(data_kontrol.noSuratKontrol);
        $("#tab_sc #sc_tanggal_entri").html(data_kontrol.tglTerbit);
        $("#tab_sc #sc_tanggal_rencana").html(data_kontrol.tglRencanaKontrol);
        $("#tab_sc #sc_poli_tujuan").html(data_kontrol.poli_tujuan);
        $("#tab_sc #sc_dokter_kontrol").html(data_kontrol.namaDokter);
        $("#tab_sc #sc_no_sep").html(data_kontrol.sep.noSep);
        $("#tab_sc #sc_tgl_sep").html(data_kontrol.sep.tglSep);

        if (data_kontrol.status_kontrol == 1) {
            $("#tab_sc #sc_status").html("Sudah melewati jadwal kontrol yang Direncanakan!");
        } else if (data_kontrol.status_kontrol == -1) {
            $("#tab_sc #sc_status").html("Belum Masuk jadwal kontrol yang Direncanakan!");
        }

        $("#dialogSuratKontrol").dialog("open");
    }

    function setSuratKontrol() {
        $("#dialogSuratKontrol").dialog("close");
        if (data_kontrol.status_kontrol != 0) {
            $("#PPSepT_no_surat").val("");
        } else {
            $("#PPSepT_nama_dpjp").val(data_kontrol.namaDokter);
            $("#PPSepT_kode_dpjp").val(data_kontrol.kodeDokter);
            $("#PPSepT_no_surat").val(data_kontrol.noSuratKontrol);
            $("#isSepManual").prop("checked", false).change();
            $("#PPSepT_nosep").val("");
            /*
            if (data_kontrol.sep.noSep) {
                $("#isSepManual").prop("checked", true).change();
                $("#PPSepT_nosep").val(data_kontrol.sep.noSep);
            }
            */
            $("#PPSepT_politujuan").val(data_kontrol.poliTujuan);
        }
    }

    function setKodeRuanganBPJS() {
        var ruangan_id = $("#PPPendaftaranT_ruangan_id").val();

        $.post('<?php echo $this->createUrl('getRuanganSpesialisBPJS') ?>', {
            ruangan_id: $(this).val(),
        }, function(data) {
            if (data.ok == 1) {
                $("#PPSepT_politujuan").val(data.kode);
            }
        }, 'json');
    }

    function pilihJenisKunjunganBPJS() {
        var jenis = $("#PPSepT_jenis_kunjungan").val();

        if (jenis == "0") {
            $("#PPSepT_flag_procedure").val(null).prop("readonly", true).prop("disabled", true);
            $("#PPSepT_kode_penunjang").val(null).prop("readonly", true).prop("disabled", true);
        } else {
            $("#PPSepT_flag_procedure").prop("readonly", false).prop("disabled", false);
            $("#PPSepT_kode_penunjang").prop("readonly", false).prop("disabled", false);
        }

        if (jenis == "2" || jenis == "0") {
            $("#PPSepT_asesmen_pelayanan").val(4);
        }
    }

    function setNoTelpBPJS() {
        $("#PPSepT_no_telpon_peserta").val($("#PPPasienM_no_mobile_pasien").val());
    }

    function setCariDPJP() {
        var kode = $("#input_klinik_tujuan :selected").data('kode');

        if (kode != null && kode != "") {
            $("#kode_spesialis_melayani").val(kode);
            cariDataDokterMelayani();
        }
    }

    function setRuanganDariKodeBPJS(ruangan) {
        var id = null;
        $("#input_klinik_tujuan option").each(function() {
            if ($(this).data("kode_bpjs") == ruangan) {
                id = $(this).prop("value");
            }
        });

        if (id != null) {
            $("#input_klinik_tujuan").val(id);
        }
    }

    $("#PPPasienM_no_mobile_pasien").on("blur", setNoTelpBPJS);
    $("#PPPendaftaranT_ruangan_id").on("change", setKodeRuanganBPJS);
    // $(document).ready(function() {
        
    // });
    function batalDialog(dialog_id) {
        if (confirm("Apakah anda yakin akan membatalkan ini ?"))
            $('#' + dialog_id).dialog("close");
    }
</script>