<?php
$this->breadcrumbs = array(
    'Transaksi Odontogram'
); ?>

<style>
    #btn_list_gigi>a {
        margin-right: 10px;
        margin-bottom: 10px;
        width: calc(50% - 20px);
    }

    .panel-title>* {
        color: inherit;
        font-size: inherit;
    }

    .input-append>* {
        float: left !important;
    }
</style>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-tooth"></i> Transaksi <b>Odontogram</b>
        </div>
    </div>
    <div class="panel-body">
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'odontogramdetail-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
            'focus' => '#',
        ));
        ?>
        <?php
        $this->widget('bootstrap.widgets.BootAlert');
        echo $form->errorSummary(array($modOdontogramDetail));

        $kunjungan = null;
        if (!empty($pendaftaran_id)) {
            $kunjungan = RJInfokunjunganrjV::model()->findByAttributes(array(
                'pendaftaran_id' => $pendaftaran_id,
            ));
        }

        ?>
        <?php if (!isset($_GET['frame']) || $_GET['frame'] != 1) { ?>
            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('Tgl. Pendaftaran', 'tglpendaftaran', array('class' => 'control-label')) ?>
                        <div class="controls">
                            : <span id="tglpendaftaran"><?php echo empty($kunjungan) ? "" : MyFormatter::formatDateTimeForUser($kunjungan->tgl_pendaftaran); ?></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('No. Pendaftaran', 'nopendaftaran', array('class' => 'control-label')) ?>
                        <div class="controls">
                            : <span id="nopendaftaran"><?php echo empty($kunjungan) ? "" : $kunjungan->no_pendaftaran; ?></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Tgl. Lahir / Umur', 'tgllahirumur', array('class' => 'control-label')) ?>
                        <div class="controls">
                            : <span id="tgllahirumur"><?php echo empty($kunjungan) ? "" : (MyFormatter::formatDateTimeForUser($kunjungan->tanggal_lahir) . " / " . $kunjungan->umur); ?></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Kasus Penyakit', 'jeniskasuspenyakit', array('class' => 'control-label')) ?>
                        <div class="controls">
                            : <span id="jeniskasuspenyakit"><?php echo empty($kunjungan) ? "" : $kunjungan->jeniskasuspenyakit_nama; ?></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Golongan Darah', 'goldarah', array('class' => 'control-label')) ?>
                        <div class="controls">
                            : <span id="goldarah"><?php echo empty($kunjungan) ? "" : $kunjungan->golongandarah; ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('No. Rekam Medik', 'noRekamMedik', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'name' => 'noRekamMedik',
                                'value' => empty($kunjungan) ? "" : $kunjungan->no_rekam_medik,
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
											$("#noRekamMedik").val( ui.item.value );
											return false;
										}',
                                    'select' => 'js:function( event, ui ) {
											ambilOdontogram(ui.item.pasien_id,ui.item.pendaftaran_id);
											$("#tglpendaftaran").text(ui.item.tgl_pendaftaran);
											$("#nopendaftaran").text(ui.item.no_pendaftaran);
											$("#tgllahirumur").text(ui.item.tanggal_lahir+" / "+ui.item.umur);
											$("#jeniskasuspenyakit").text(ui.item.jeniskasuspenyakit_nama);
											$("#goldarah").text(ui.item.golongandarah);
											$("#namapegawai").text(ui.item.nama_pegawai);
											$("#namapasien").text(ui.item.nama_pasien);
											$("#binbinti").text(ui.item.nama_bin);
											$("#jeniskelamin").text(ui.item.jeniskelamin);
											$("#alamat").text(ui.item.alamat_pasien);

											return false;
										}',
                                ),
                                'htmlOptions' => array('placeholder' => 'No. Rekam Medik', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 numbers-only', 'maxlength' => 6),
                                'tombolDialog' => array('idDialog' => 'dialogDaftarPasien', 'idTombol' => 'tombolPasienDialog'),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Nama Pasien', 'namapasien', array('class' => 'control-label')) ?>
                        <div class="controls">
                            : <span id="namapasien"><?php echo empty($kunjungan) ? "" : $kunjungan->nama_pasien; ?></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Nama Panggilan', 'binbinti', array('class' => 'control-label')) ?>
                        <div class="controls">
                            : <span id="binbinti"><?php echo empty($kunjungan) ? "" : $kunjungan->nama_bin; ?></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Jenis Kelamin', 'jeniskelamin', array('class' => 'control-label')) ?>
                        <div class="controls">
                            : <span id="jeniskelamin"><?php echo empty($kunjungan) ? "" : $kunjungan->jeniskelamin; ?></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Alamat', 'alamat', array('class' => 'control-label')) ?>
                        <div class="controls">
                            : <span id="alamat"><?php echo empty($kunjungan) ? "" : $kunjungan->alamat_pasien; ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <?php echo CHtml::checkBox('cex_kunjunganpasien', false, array('onkeypress' => "return $(this).focusNextInputField(event)")) ?>
                        <label for="cex_kunjunganpasien">Data Kunjungan</label>
                    </div>
                </div>
                <div class="panel-body table-responsive">
                    <div class="control-group">
                        <div id="detail_kunjungna_pasien">
                            <?php echo $this->renderPartial($this->path_view . '_tabelKunjungan', array('model' => $modOdontogramDetail)); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if (!isset($_GET['frame']) || $_GET['frame'] != 1) { ?>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="far fa-file-alt"></i> Form <b>Odontogram</b>
                    </div>
                </div>
                <div class="panel-body">
                <?php } ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($modOdontogramDetail, 'tglperiksa', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modOdontogramDetail,
                                    'attribute' => 'tglperiksa',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 realtime'),
                                ));
                                ?>
                            </div>
                        </div>
                        <?php echo $form->hiddenField($modOdontogramDetail, 'pasien_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->hiddenField($modOdontogramDetail, 'pendaftaran_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php
                        echo $form->hiddenField($modOdontogramDetail, 'pegawai_id', array(
                            'class' => 'span3',
                            'onkeypress' => "return $(this).focusNextInputField(event);"
                        ));
                        ?>
                        <div class="control-group">
                            <?php echo CHtml::label('Dokter ', 'namapegawai', array('class' => 'control-label')) ?>
                            <div class="controls">
                                : <span id="namapegawai"><?php echo $modOdontogramDetail->nama_pegawai; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->textAreaRow($modOdontogramDetail, 'catatan', array('placeholder' => 'Catatan', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>

                <div class="row" style="margin-top: 17px;">
                    <div class="col-md-6" id="btn_list_gigi">
                        <?php echo CHtml::link('Gigi Tidak Ada <i class="entypo"><span class="non">NON</span></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);addCode("N");')); ?>

                        <?php echo CHtml::link('Un-Erupted <i class="entypo"><span class="belum-erupsi">UNE</span></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);addCode("E");')); ?>

                        <?php echo CHtml::link('Partial Erupt <i class="entypo"><span class="erupsi-sebagian">PRE</span></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);addCode("S");')); ?>

                        <?php echo CHtml::link('Anomali <i class="entypo"><span class="anomali-bentuk">ANO</span></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);addCode("B");')); ?>

                        <?php echo CHtml::link('Fracture <i class="entypo"><span class="fracture">#</span></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);addCode("F");')); ?>

                        <?php echo CHtml::link('Gigi Normal <i class="entypo"><span class=""></span></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);addCode("w");')); ?>

                        <?php echo CHtml::link('Tambalan Amalgam <i class="tambalan-amalgam entypo" style="background:#333 !important;"></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);changeCode("a");')); ?>
                        <?php //echo CHtml::link('Tambalan Logam <i class="tambalan-logam entypo"></i>', 'javascript:;',array('class'=>'btn btn-default btn-icon','onclick'=>'onKlikTombol(this);changeCode("r");')); 
                        ?>

                        <?php echo CHtml::link('Tambalan Composite <i class="tambalan-composite entypo" style="background:green !important;"></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);changeCode("c");')); ?>
                        <?php //echo CHtml::link('Tambalan Non Logam <i class="tambalan-nonlogam entypo"></i>', 'javascript:;',array('class'=>'btn btn-default btn-icon','onclick'=>'onKlikTombol(this);changeCode("b");')); 
                        ?>

                        <?php echo CHtml::link('Pit dan Fissure Sealant <i class="tambalan-pit entypo" style="background:#bc8443 !important;"></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);changeCode("p");')); ?>
                        <?php //echo CHtml::link('Mahkota Logam <i class="mahkota-logam entypo"></i>', 'javascript:;',array('class'=>'btn btn-default btn-icon','onclick'=>'onKlikTombol(this);changeCode("g");')); 
                        ?>

                        <?php echo CHtml::link('Caries <i class="karies entypo"></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);changeCode("k");')); ?>
                        <?php //echo CHtml::link('Mahkota Non Logam  <i class="mahkota-nonlogam entypo"></i>', 'javascript:;',array('class'=>'btn btn-default btn-icon','onclick'=>'onKlikTombol(this);changeCode("n");')); 
                        ?>

                        <?php echo CHtml::link('Arsiran <i class="entypo arsiran"></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);changeCode("s");')); ?>

                        <?php //echo CHtml::link('Karies <i class="karies entypo"></i>', 'javascript:;',array('class'=>'btn btn-default btn-icon','onclick'=>'onKlikTombol(this);changeCode("K");')); 
                        ?>

                        <?php echo CHtml::link('First Bridge <i class="entypo bridgekiri"></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);addCode("D");')); ?>

                        <?php echo CHtml::link('Bridge <i class="entypo bridgetengah"></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);addCode("J");')); ?>

                        <?php echo CHtml::link('Last Bridge <i class="entypo bridgekanan"></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);addCode("I");')); ?>

                        <?php //echo CHtml::link('Gigi Tiruan Lepas <i class="entypo"><hr class="gigi-tiruanlepas"></i>', 'javascript:;',array('class'=>'btn btn-default btn-icon','onclick'=>'onKlikTombol(this);addCode("L");')); 
                        ?>
                        <!--<hr>-->
                        <?php echo CHtml::link('Migrasi Kiri <i class="entypo migrasikiri"></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);addCode("Q");')); ?>

                        <?php echo CHtml::link('Migrasi Kanan <i class="entypo migrasikanan"></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);addCode("W");')); ?>

                        <?php echo CHtml::link('Rotasi Kiri <i class="entypo rotasikiri"></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);addCode("U");')); ?>

                        <?php echo CHtml::link('Rotasi Kanan <i class="entypo rotasikanan"></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);addCode("C");')); ?>

                        <?php //echo CHtml::link('Sisa Akar <i class="sisa-akar entypo"></i>',  'javascript:;',array('class'=>'btn btn-default btn-icon','onclick'=>'onKlikTombol(this);addCode("A");')); 
                        ?>
                        <?php echo CHtml::link('Perawatan Saluran Akar <i class="rawat-akar entypo"></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);addCode("R");')); ?>

                        <?php echo CHtml::link('Sisa Akar <i class="sisa-akar entypo"></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);addCode("A");')); ?>

                        <?php echo CHtml::link('Non Vital <i class="entypo non-vital "></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);addCode("V");')); ?>

                        <?php echo CHtml::link('Amalgam pada Non Vital <i class="entypo amalgam-nonvital "></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);addCode("T");')); ?>

                        <?php echo CHtml::link('Full Metal Crown Gigi Vital <i class="entypo metalcrown-vital" style="border:2px solid #333 !important;"></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);addCode("M");')); ?>

                        <?php echo CHtml::link('Full Metal Crown Gigi Non Vital <i class="entypo metalcrown_nonvital "></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);addCode("G");')); ?>

                        <?php echo CHtml::link('Porcelain Crown Gigi Vital <i class="entypo porcelainvital "></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);addCode("P");')); ?>

                        <?php echo CHtml::link('Porcelain Crown Gigi Non Vital <i class="entypo porcelainnonvital "></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);addCode("O");')); ?>

                        <?php echo CHtml::link('Gigi Hilang <i class="entypo gigihilang "></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);addCode("H");')); ?>

                        <?php echo CHtml::link('Implant + Porcelain Crown <i class="entypo implantporcelain "></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);addCode("X");')); ?>

                        <?php echo CHtml::link('Partial Denture <i class="entypo partialdenture "></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);addCode("Y");')); ?>

                        <?php echo CHtml::link('Full Denture <i class="entypo fulldenture "></i>', 'javascript:;', array('class' => 'btn btn-default btn-icon', 'onclick' => 'onKlikTombol(this);addCode("Z");')); ?>

                        <?php //echo CHtml::link('Porcelain Crown Gigi Vital <i class="entypo amalgam-nonvital "></i>',  'javascript:;',array('class'=>'btn btn-default btn-icon','onclick'=>'onKlikTombol(this);addCode("M");')); 
                        ?>
                        <?php //echo CHtml::button('Sembunyikan Gigi Hilang', array('class'=>'btn btn-default span3')); 
                        ?>
                        <?php //echo CHtml::button('Hapus Tanda', array('class'=>'btn btn-default span3')); 
                        ?>
                        <?php //echo CHtml::button('Gigi Hilang', array('class'=>'btn btn-default span3','onclick'=>'onKlikTombol(this);addCode("H");')); 
                        ?>
                        <?php //echo CHtml::button('Tampilkan Gigi Hilang', array('class'=>'btn btn-default span3')); 
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <?php $this->widget('Odontogram', array('gigis' => $gigi)); ?>
                    </div>
                </div>

                <?php if (!isset($_GET['frame']) || $_GET['frame'] != 1) { ?>
                </div>
            </div>
        <?php } ?>
        <div class="form-actions">
            <?php
            // if(!empty($_GET['id'])){
            //     echo CHtml::htmlButton(Yii::t('mds', '{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')), array('class' => 'btn btn-danger','type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','disabled'=>true));
            // }else{
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
            // }
            ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->module->id . '/index'), array(
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'
            ));
            ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'onclick' => 'cetakOdontogram()')); ?>
            <?php
            $content = $this->renderPartial('rawatJalan.views.tips.transaksiPeriksaGigi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<script type="text/javascript">
    function ambilOdontogram(pasien_id, pendaftaran_id) {
        $.post('<?php echo $this->createUrl('ajaxOdontogram'); ?>', {
            pasien_id: pasien_id
        }, function(data) {
            $('#<?php echo CHtml::activeId($modOdontogramDetail, 'pasien_id') ?>').val(pasien_id);
            $('#<?php echo CHtml::activeId($modOdontogramDetail, 'pendaftaran_id') ?>').val(pendaftaran_id);
            $('#dialogDaftarPasien').dialog('close');
            for (n in data) {
                url = '<?php echo $this->createUrl('myOdontogram'); ?>&code=' + data[n] + '&a=' + n;
                $('#gram_' + n).find('input[name^=\"codeOdon\"]').val(data[n]);
                $('#gram_' + n).css('background-image', 'url(' + url + ')');
            }
        }, 'json');

        setTimeout(function() {
            $.fn.yiiGridView.update('tableKunjungan', {
                data: $("#odontogramdetail-t-form").serialize()
            });
        }, 1000);
    }

    function cetakOdontogram() {
        var pasien_id = $('#<?php echo CHtml::activeId($modOdontogramDetail, 'pasien_id'); ?>').val();
        var pendaftaran_id = $('#<?php echo CHtml::activeId($modOdontogramDetail, 'pendaftaran_id'); ?>').val();
        var src = '<?php echo $this->createUrl('cetakOdontogram'); ?>&pasien_id=' + pasien_id + '&pendaftaran_id=' + pendaftaran_id;
        $('#iframeCetakOdontogram').attr('src', src);
        $('#dialogCetakOdontogram').dialog('open');
    }
</script>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDaftarPasien',
    'options' => array(
        'title' => 'Data Kunjungan Pasien Hari Ini',
        'autoOpen' => false,
        'resizable' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
			data: $('#RJInfokunjunganrjV_statusperiksa').serialize()
		}); }",
    ),
));
$kunjunganPasien = new RJInfokunjunganrjV('searchKunjunganPasien');
//$kunjunganPasien->statusperiksa = "SEDANG PERIKSA";
// $kunjunganPasien->tgl_pendaftaran = date('Y-m-d');
if (isset($_GET['RJInfokunjunganrjV'])) {
    $kunjunganPasien->attributes = $_GET['RJInfokunjunganrjV'];
    $format = new MyFormatter();
    if (isset($_GET['RJInfokunjunganrjV']['tgl_pendataran']))
        $kunjunganPasien->tgl_pendaftaran = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_pendaftaran']);
    $kunjunganPasien->statusperiksa = $_REQUEST['RJInfokunjunganrjV']['statusperiksa'];
}

$statusperiksa = LookupM::getItems('statusperiksa');
unset($statusperiksa[Params::STATUSPERIKSA_SUDAH_PULANG]);
unset($statusperiksa[Params::STATUSPERIKSA_BATAL_PERIKSA]);

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftarpasien-v-grid',
    'dataProvider' => $kunjunganPasien->searchKunjunganPasienPolikGigi(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'filter' => $kunjunganPasien,
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                $pegawai = PegawaiM::model()->findByPk($data->pegawai_id);

                return CHtml::link("<i class='icon-form-check'></i> ", "javascript:void(0)", array(
                    "onclick" => "ambilOdontogram(" . $data->pasien_id . "," . $data->pendaftaran_id . ");
					$('#tglpendaftaran').text('" . MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran) . "');
					$('#nopendaftaran').text('" . $data->no_pendaftaran . "');
					$('#tgllahirumur').text('" . MyFormatter::formatDateTimeForUser($data->tanggal_lahir) . " / " . $data->umur . "');
					$('#jeniskasuspenyakit').text('" . $data->jeniskasuspenyakit_nama . "');
					$('#goldarah').text('" . $data->golongandarah . "');
					$('#namapegawai').text('" . $pegawai->namaLengkap . "');
					$('#namapasien').text('" . $data->nama_pasien . "');
					$('#binbinti').text('" . $data->nama_bin . "');
					$('#jeniskelamin').text('" . $data->jeniskelamin . "');
					$('#OdontogramdetailT_pegawai_id').val('" . $data->pegawai_id . "');
					$('#alamat').text('" . $data->alamat_pasien . "');",
                    "rel" => "tooltip", "title" => "Klik untuk Pemeriksaan Pasien"
                ));
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        //tgl_pendaftaran',
        array(
            'name' => 'tgl_pendaftaran',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
            'filter' => $this->widget(
                'MyDateTimePicker',
                array(
                    'model' => $kunjunganPasien,
                    'attribute' => 'tgl_pendaftaran',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT
                    ),
                    'htmlOptions' => array('readonly' => false, 'class' => 'span3 dtPicker3', 'onclick' => 'showDateTime();'),
                ),
                true
            ),
            'htmlOptions' => array('width' => '80', 'style' => 'text-align:center'),
        ),
        array(
            'header' => 'No. Pendaftaran',
            'name' => 'no_pendaftaran',
            'value' => '$data->no_pendaftaran',
            'filter' => Chtml::activeTextField($kunjunganPasien, 'no_pendaftaran', array('class' => 'angkahuruf-only', 'maxlength' => 12))
        ),
        array(
            'header' => 'No. Rekam Medik',
            'name' => 'no_rekam_medik',
            'value' => '$data->no_rekam_medik',
            'filter' => Chtml::activeTextField($kunjunganPasien, 'no_rekam_medik', array('class' => 'numbers-only', 'maxlength' => 6))
        ),
        array(
            'header' => 'Nama Pasien',
            'name' => 'nama_pasien',
            'value' => '$data->namadepan." ".$data->nama_pasien',
            'filter' => Chtml::activeTextField($kunjunganPasien, 'nama_pasien', array('class' => 'hurufs-only', 'maxlength' => 100))
        ),
        array(
            'header' => 'Alamat Pasien',
            'name' => 'alamat_pasien',
            'value' => '$data->alamat_pasien',
            'filter' => Chtml::activeTextField($kunjunganPasien, 'alamat_pasien', array('class' => 'custom-only'))
        ),
        array(
            'header' => 'Penjamin',
            'name' => 'penjamin_id',
            'value' => '$data->penjamin_nama',
            'filter' => Chtml::activeDropDownList($kunjunganPasien, 'penjamin_id', Chtml::listData(PenjaminpasienM::model()->findAll("penjamin_aktif = TRUE ORDER BY penjamin_nama ASC"), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Dokter',
            'name' => 'nama_pegawai',
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
            'filter' => Chtml::activeTextField($kunjunganPasien, 'nama_pegawai', array('class' => 'hurufs-only', 'maxlength' => 100))
        ),
        array(
            'header' => 'Jenis Kasus Penyakit',
            'name' => 'jeniskasuspenyakit_id',
            'value' => '$data->jeniskasuspenyakit_nama',
            'filter' => Chtml::activeDropDownList($kunjunganPasien, 'jeniskasuspenyakit_id', Chtml::listData(JeniskasuspenyakitM::model()->findAll("jeniskasuspenyakit_aktif = TRUE ORDER BY jeniskasuspenyakit_nama ASC"), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Status Periksa',
            'name' => 'statusperiksa',
            'type' => 'raw',
            'value' => '$data->statusperiksa',
            'filter' => CHtml::activeDropDownList($kunjunganPasien, 'statusperiksa', $statusperiksa, array('empty' => '-- Pilih --')),
            // 'filter' =>CHtml::activeDropDownList($kunjunganPasien,'statusperiksa',
            //     LookupM::getItems('statusperiksa'),array('options' => array('ANTRIAN'=>array('selected'=>true)))),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
		jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});

		jQuery(\'#RJInfokunjunganrjV_tgl_pendaftaran\').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional[\'id\'], {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
			\'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
			\'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'}));

	$(".numbers-only").keyup(function() {
		setNumbersOnly(this);
	});
	$(".angkahuruf-only").keyup(function() {
		setAngkaHuruOnly(this);
	});
	$(".hurufs-only").keyup(function() {
		setHurufsOnly(this);
	});
	}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogCetakOdontogram',
    'options' => array(
        'title' => 'Odontogram Pasien',
        'autoOpen' => false,
        'resizable' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
    ),
));
echo '<iframe src="" id="iframeCetakOdontogram" name="iframeCetakOdontogram" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<script>
    function showDateTime() {
        $("#RJInfokunjunganrjV_tgl_pendaftaran").datepicker();
    }

    $(document).ready(function() {
        <?php if (isset($_GET['pendaftaran_id'])) {
            $pendaftaran = PendaftaranT::model()->findByPk($_GET['pendaftaran_id']);
        ?>
            ambilOdontogram(<?php echo $pendaftaran->pasien_id; ?>, <?php echo $pendaftaran->pendaftaran_id; ?>);
        <?php } ?>
    });

    /*
     $( document ).ready(function(){                        
     var ruanganLogin = <?php // echo Yii::app()->user->getState('ruangan_id');  
                        ?>;
     var checkRuangan = <?php // echo Params::RUANGAN_ID_POLIK_GIGI;  
                        ?>;
     //alert("wew");
     
     if (ruanganLogin !== checkRuangan){
     $(document).on('keyup',function(evt) {
     if (evt.keyCode == 27) {
     window.location.href = "<?php echo $this->createUrl("/rawatJalan/&modul_id=" . Yii::app()->session['modul_id']); ?>";
     }
     });
     myConfirm(' Maaf Ini Hanya Digunakan Oleh Klinik Gigi dan Mulut. <br> \n\
     Silakan Login ke Klinik Gigi dan Mulut untuk Dapat Mengakses Menu ','Perhatian!',function(r){
     if (r){
     window.location.href = "<?php // echo  $this->createUrl("/rawatJalan/&modul_id=".Yii::app()->session['modul_id']);//$this->createUrl("/site/logout/");  
                                ?>";
     }else{
     window.location.href = "<?php // echo $this->createUrl("/rawatJalan/&modul_id=".Yii::app()->session['modul_id']);  
                                ?>";
     }
     });
     }
     });
     */
</script>