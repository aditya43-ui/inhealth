<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'daftarPasienPulang-form',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($modPasienYangPulang, 'no_pendaftaran'),
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
)); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
            <label for="namaPasien" class="control-label">
                <?php echo CHtml::activecheckBox($modPasienYangPulang, 'ceklis', array('id' => 'namaPasien', 'uncheckValue' => 0, 'onClick' => 'cekTanggal()', 'rel' => 'tooltip', 'data-original-title' => 'Cek untuk pencarian berdasarkan tanggal')); ?>
                Tgl. Pulang
            </label>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($modPasienYangPulang->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($modPasienYangPulang->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($modPasienYangPulang->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($modPasienYangPulang->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($modPasienYangPulang, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($modPasienYangPulang, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('No. Pendaftaran', 'no_pendaftaran', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $prefix = array(
                    0 => Params::PREFIX_RAWAT_DARURAT,
                    1 => Params::PREFIX_RAWAT_INAP,
                    2 => Params::PREFIX_RAWAT_JALAN
                );
                echo $form->dropDownList($modPasienYangPulang, 'prefix_pendaftaran', PendaftaranT::model()->getColumn($prefix), array('class' => 'numbers-only', 'style' => 'width:75px;'));
                ?>
                <?php echo $form->textField($modPasienYangPulang, 'no_pendaftaran', array('class' => 'span2 numbers-only', 'maxlength' => 10, 'placeholder' => 'No. Pendaftaran')); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($modPasienYangPulang, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 6)); ?>
        <?php echo $form->textFieldRow($modPasienYangPulang, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        <?php //echo $form->textFieldRow($modPasienYangPulang,'nama_bin',array('placeholder'=>'Alias / Nama Panggilan','class'=>'span4','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); 
        ?>
        <div class="control-group">
            <?php echo Chtml::label("Kamar", 'kamarruangan_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo  $form->dropDownList($modPasienYangPulang, 'kamarruangan_id',  CHtml::listData(KamarruanganM::model()->findAllByAttributes(array(
                    'kamarruangan_aktif' => true,
                    'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
                ), array(
                    'order' => 'kamarruangan_nokamar',
                )), 'kamarruangan_id', 'kamarDanTempatTidurPolos'), array('empty' => '-- Pilih --', 'placeholder' => 'Nama Pasien', 'onkeypress' => "return $(this).focusNextInputField(event)"));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label("Kelas Pelayanan", 'kelaspelayanan_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($modPasienYangPulang, 'kelaspelayanan_id', Chtml::listData(KelaspelayananM::model()->findAll("kelaspelayanan_aktif = TRUE ORDER BY kelaspelayanan_nama ASC"), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --'));
                ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow($modPasienYangPulang, 'carabayar_id', CHtml::listData($modPasienYangPulang->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
            'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
            'ajax' => array(
                'type' => 'POST',
                'url' => $this->createUrl('SetDropdownPenjaminPasien', array('encode' => false, 'namaModel' => get_class($modPasienYangPulang))),
                'success' => 'function(data){$("#' . CHtml::activeId($modPasienYangPulang, "penjamin_id") . '").html(data); }',
            ),
        )); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($modPasienYangPulang, 'penjamin_id', CHtml::listData($modPasienYangPulang->getPenjaminItems($modPasienYangPulang->carabayar_id), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
        <div class="control-group">
            <?php echo Chtml::label("Kasus Penyakit", 'jeniskasuspenyakit_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($modPasienYangPulang, 'jeniskasuspenyakit_id', Chtml::listData(JeniskasuspenyakitM::model()->findAll("jeniskasuspenyakit_aktif = TRUE ORDER BY jeniskasuspenyakit_nama ASC"), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'), array('empty' => '-- Pilih --'));
                ?>
            </div>
        </div>
        <?php
        $pegawai = PegawaiV::model()->findAllByAttributes(array(
            'pegawai_aktif' => true,
            'kelompokpegawai_id' => Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
        ), array(
            'order' => 'nama_pegawai',
            'condition' => 'jabatan_id <> ' . Params::JABATAN_ID_DOKTER_UMUM
        ));
        $pegawaiUmum = PegawaiV::model()->findAllByAttributes(array(
            'pegawai_aktif' => true,
            'kelompokpegawai_id' => Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
            'jabatan_id' => Params::JABATAN_ID_DOKTER_UMUM,
        ), array(
            'order' => 'nama_pegawai',
        ));
        echo $form->dropDownListRow($modPasienYangPulang, 'dokterpenerima_id', CHtml::listData($pegawaiUmum, 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --'));
        echo $form->dropDownListRow($modPasienYangPulang, 'pegawai_id', CHtml::listData($pegawai, 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --'));
        ?>
        <div class="control-group">
            <?php echo Chtml::label("Cara Keluar", 'carakeluar_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($modPasienYangPulang, 'carakeluar_id', CHtml::listData($modPasienYangPulang->getCaraKeluarItems(), 'carakeluar_id', 'carakeluar_nama'), array(
                    'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('/ActionDynamic/GetKondisiKeluar/', array('encode' => false, 'namaModel' => get_class($modPasienYangPulang))),
                        'success' => 'function(data){$("#' . CHtml::activeId($modPasienYangPulang, "kondisikeluar_id") . '").html(data); }',
                    ),
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label("Kondisi Keluar", 'kondisikeluar_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($modPasienYangPulang, 'kondisikeluar_id', array(), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
            </div>
        </div>
    </div>
</div>
<!--fieldset class="box"-->
<div class="form-actions">
    <?php //echo $form->textFieldRow($modPasienYangPulang,'no_pendaftaran',array('placeholder'=>'No. Pendaftaran','class'=>'span4','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); 
    ?>
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array(
            'title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan'
        )
    );
    echo CHtml::hiddenField('pendaftaran_id');
    echo CHtml::hiddenField('pasien_id');
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php
    $content = $this->renderPartial('../tips/informasiPasienPulang', array(), true);
    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<!--</fieldset>-->
<script>
    document.getElementById('RIPasienygPulangriV_tgl_awal_date').setAttribute("style", "display:none;");
    document.getElementById('RIPasienygPulangriV_tgl_akhir_date').setAttribute("style", "display:none;");

    function cekTanggal() {
        var checklist = $('#RIPasienygPulangriV_ceklis');
        var pilih = checklist.attr('checked');
        if (pilih) {
            document.getElementById('RIPasienygPulangriV_tgl_awal_date').setAttribute("style", "display:block;");
            document.getElementById('RIPasienygPulangriV_tgl_akhir_date').setAttribute("style", "display:block;");
        } else {
            document.getElementById('RIPasienygPulangriV_tgl_awal_date').setAttribute("style", "display:none;");
            document.getElementById('RIPasienygPulangriV_tgl_akhir_date').setAttribute("style", "display:none;");
        }
    }
</script>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Daftar Dokter',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'resizable' => false,
    ),
));
$modDokter = new RIDokterV('searchDialogDokter');
$modDokter->unsetAttributes();
if (isset($_GET['RIDokterV'])) {
    $modDokter->attributes = $_GET['RIDokterV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaiYangMengajukan-m-grid',
    'dataProvider' => $modDokter->searchDialogDokter(),
    'filter' => $modDokter,
    'template' => "{items}\n{pager}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Pegawai","class"=>"btn_small",
					"id"=>"selectPegawai",
					"onClick"=>"$(\"#' . CHtml::activeId($modPasienYangPulang, 'pegawai_id') . '\").val(\"$data->nama_pegawai\");
							$(\"#nama_pegawai\").val(\"$data->NamaLengkap\");
							$(\"#dialogDokter\").dialog(\"close\");
							return false;"
					))'
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => Chtml::activeTextField($modDokter, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'name' => 'nama_pegawai',
            'header' => 'Nama Dokter',
            'type' => 'raw',
            'value' => '$data->NamaLengkap',
            'filter' => Chtml::activeTextField($modDokter, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);
                if (!empty($j)) {
                    return $j->jabatan_nama;
                } else {
                    return '-';
                }
            },
            'filter' => Chtml::activeDropDownList($modDokter, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll('jabatan_aktif = TRUE ORDER BY jabatan_nama ASC'), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function(){'
        . '     setNumbersOnly(this);'
        . '});'
        . '$(".hurufs-only").keyup(function(){'
        . '     setHurufsOnly(this);'
        . '});'
        . '}',
));
$this->endWidget();
?>