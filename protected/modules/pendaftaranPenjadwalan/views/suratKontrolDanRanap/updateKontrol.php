<?php
$form = $this->beginWidget(
    'ext.bootstrap.widgets.BootActiveForm',
    array(
        'method' => 'post',
        'type' => 'horizontal',
        'id' => 'form-update-kontrol',
        'htmlOptions' => array(
            'onKeyPress' => 'return disableKeyPress(event)'
        ),
    )
);

$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo CHtml::label('Nama Pasien', 'nomorsurat', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::label($modPendaftaran->pasien->nama_pasien, ''); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Jenis Kelamin', 'nomorsurat', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::label($modPendaftaran->pasien->jeniskelamin, ''); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Tangal Lahir', 'nomorsurat', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::label($modPendaftaran->pasien->tanggal_lahir, ''); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('No. Surat', 'nomorsurat', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField($modSurat, 'nomorsurat', array('class' => 'span3', 'readonly' => true));
                ?>
                <?php echo $form->error($modSurat, 'nomorsurat'); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('No. Surat Kontrol', 'nomorsurat_bpjs', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField($modSurat, 'nomorsurat_bpjs', array('class' => 'span3', 'readonly' => true));
                ?>
                <?php echo $form->error($modSurat, 'nomorsurat_bpjs'); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($modPendaftaran, 'tglrenkontrol', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modPendaftaran,
                    'attribute' => 'tglrenkontrol',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        // 'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('class' => 'dtPicker3 span3', 'onblur' => 'setLoadRencanaKontrol();'),
                )); ?>
                <?php echo $form->error($modPendaftaran, 'tglrenkontrol'); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($modPendaftaran, 'ruangankontrol_id', array('class' => 'control-label', 'label' => 'Poli Tujuan')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($modPendaftaran, 'ruangankontrol_id', CHtml::listData(
                    RuanganM::model()->findAllByAttributes(array(
                        'instalasi_id' => Params::INSTALASI_ID_RJ
                    ), array(
                        'condition' => 'kode_bpjs is not null',
                    )),
                    'ruangan_id',
                    'ruangan_nama'
                ), array(
                    'empty' => '-- Pilih --', 'class' => 'span3 ruangankontrol_id', 'onchange' => 'setLoadRencanaKontrol()',
                )); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Dokter Tujuan Kontrol', 'doktertujuankontrol_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($modPendaftaran, 'doktertujuankontrol_id', CHtml::listData(DokterV::model()->findAllByAttributes(array(
                    'kelompokpegawai_id' => Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
                    'ruangan_id' => Yii::app()->user->getState('ruangan_id')
                )), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3 doktertujuankontrol_id'));
                ?>
                <?php echo $form->error($modPendaftaran, 'doktertujuankontrol_id'); ?>
            </div>
        </div>

        <div class="control-group ">
            <?php echo CHtml::label('No. SEP', 'nomorsurat', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                if (!empty($modPendaftaran->pasienadmisi_id)) {
                    $modPasienadmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
                    echo $form->textField($modPasienadmisi->sepTs, 'nosep', array('class' => 'span3', 'readonly' => true));
                } else {
                    echo $form->textField($modPendaftaran->sepTs, 'nosep', array('class' => 'span3', 'readonly' => true));
                }

                ?>
                <?php echo $form->error($modPendaftaran->sepTs, 'nosep'); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Tanggal SEP', 'nomorsurat', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField($modPendaftaran->sepTs, 'tglsep', array('class' => 'span3', 'readonly' => true));
                ?>
                <?php echo $form->error($modPendaftaran->sepTs, 'tglsep'); ?>
            </div>
        </div>

    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-floppy"></i>')),
        array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
</div>

<?php $this->endWidget(); ?>

<script>
    $(document).ready(function() {
        setLoadRencanaKontrol();
        polimulti();
    });

    function setLoadRencanaKontrol() {

        var ruangan_id = $(".ruangankontrol_id").val();
        var tgl = $("#PendaftaranT_tglrenkontrol").val();
        var sep_id = <?php echo $modPendaftaran->sep_id; ?>;
        var ru = jQuery('.doktertujuankontrol_id');
        var nosep = $("#SepT_nosep").val();

        $("#PendaftaranT_doktertujuankontrol_id").addClass('animation-loading');
        $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/suratRencanaKontrol/vclaimCekRuangan'); ?>', {
            sep_id: sep_id,
            ruangan_id: ruangan_id,
            tgl: tgl,
            nosep: nosep
        }, function(data) {
            if (data.ok == 0) {
                myAlert(data.msg, "VClaim - " + data.judul);
            }
            $(".doktertujuankontrol_id").html(data.html);
            ru.multiselect('rebuild');
            $("#PendaftaranT_doktertujuankontrol_id").removeClass('animation-loading');
        }, 'json');
    }

    function polimulti() {
        var poli = jQuery('.ruangankontrol_id');
        var ru = jQuery('.doktertujuankontrol_id');

        jQuery(poli).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
        }).hide();

        jQuery(ru).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
        }).hide();
    }
</script>