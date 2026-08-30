<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'daftarPasienPulang-form',
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#' . CHtml::activeId($modPasienYangPulang, 'no_pendaftaran'),
));
?>
<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Pulang", 'tgl_rekam', array('class' => 'control-label')) ?>
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
        <?php echo $form->dropDownListRow($modPasienYangPulang, 'carabayar_id', CHtml::listData($modPasienYangPulang->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
            'class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
            'ajax' => array(
                'type' => 'POST',
                'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien', array('encode' => false, 'namaModel' => 'RDPendaftaran')),
                'update' => '#' . CHtml::activeId($modPasienYangPulang, 'penjamin_id') . ''  //selector to update
            ),
        )); ?>
        <?php echo $form->dropDownListRow(
            $modPasienYangPulang,
            'penjamin_id',
            CHtml::listData($modPasienYangPulang->getPenjaminItems($modPasienYangPulang->carabayar_id), 'penjamin_id', 'penjamin_nama'),
            array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)
        ); ?>
        <?php echo $form->dropDownListRow(
            $modPasienYangPulang,
            'pegawai_id',
            CHtml::listData(DokterV::model()->findAllByAttributes(array(
                'instalasi_id' => Params::INSTALASI_ID_RD,
            ), array(
                'order' => 'nama_pegawai asc'
            )), 'pegawai_id', 'namaLengkap'),
            array('class' => 'span4', 'empty' => '-- Pilih --')
        );
        ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo Chtml::label("No. Pendaftaran", 'no_pendaftaran', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $prefix = array(
                    0 => Params::PREFIX_RAWAT_DARURAT,
                );
                echo $form->dropDownList($modPasienYangPulang, 'prefix_pendaftaran', PendaftaranT::model()->getColumn($prefix), array('class' => 'numbers-only', 'style' => 'width:75px;'));
                ?>
                <?php echo $form->textField($modPasienYangPulang, 'no_pendaftaran', array('class' => 'span2 numbers-only', 'maxlength' => 10, 'placeholder' => 'No. Pendaftaran')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($modPasienYangPulang, 'no_rekam_medik', array('class' => 'span4 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => 'no.rekam medik')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($modPasienYangPulang, 'nama_pasien', array('class' => 'span4 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => 'Nama Pasien')); ?>
    </div>
</div>
<?php
echo CHtml::htmlButton(
    Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
    array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
);
//	echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),
//                                                array('class' => 'btn btn-danger', 'type'=>'submit','id'=>'btn_simpan',
//                                                    'ajax' => array(
//                                                     'type' => 'GET', 
//                                                     'url' => array("/".$this->route), 
//                                                     'update' => '#daftarPasienPulang-grid',
//                                                     'beforeSend' => 'function(){
//                                                                          $("#daftarPasienPulang-grid").addClass("animation-loading");
//                                                                      }',
//                                                     'complete' => 'function(){
//                                                                          $("#daftarPasienPulang-grid").removeClass("animation-loading");
//                                                                      }',
//                                                 ))); 
echo CHtml::hiddenField('pendaftaran_id');
echo CHtml::hiddenField('pasien_id');
?>
<?php
echo CHtml::link(
    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
    Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/index'),
    array(
        'title' => 'Ulang',
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    )
);
?>
<?php
$content = $this->renderPartial('../tips/informasi', array(), true);
$this->widget('UserTips', array('type' => 'admin', 'content' => $content));
?>
<?php //echo $form->textFieldRow($modPasienYangPulang,'no_pendaftaran',array('class'=>'span4','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>'no.pendaftaran')); 
?>
<?php //echo $form->textFieldRow($modPasienYangPulang,'nama_bin',array('class'=>'span4','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>'nama bin')); 
?>
<?php //echo $form->textFieldRow($modPasienYangPulang,'keterangan_kamar',array('class'=>'span4','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>'keterangan kamar.')); 
?>
<?php $this->endWidget(); ?>
<script>
    document.getElementById('RDPasienpulangrddanriV_tgl_awal_date').setAttribute("style", "display:block;");
    document.getElementById('RDPasienpulangrddanriV_tgl_akhir_date').setAttribute("style", "display:block;");

    function cekTanggal() {
        var checklist = $('#RDPasienpulangrddanriV_ceklis');
        var pilih = checklist.attr('checked');
        if (pilih) {
            document.getElementById('RDPasienpulangrddanriV_tgl_awal_date').setAttribute("style", "display:block;");
            document.getElementById('RDPasienpulangrddanriV_tgl_akhir_date').setAttribute("style", "display:block;");
        } else {
            document.getElementById('RDPasienpulangrddanriV_tgl_awal_date').setAttribute("style", "display:none;");
            document.getElementById('RDPasienpulangrddanriV_tgl_akhir_date').setAttribute("style", "display:none;");
        }
    }
</script>