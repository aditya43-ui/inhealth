<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'pasienSayHello-form',
    'type' => 'horizontal',
    'focus' => '#',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
?>
<!--<fieldset class="box">-->
<!--<legend class="rim"><i class="entypo-search"></i> Pencarian</legend>-->
<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Pendaftaran", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($modSayHello->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($modSayHello->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($modSayHello->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($modSayHello->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($modSayHello, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($modSayHello, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($modSayHello, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($modSayHello, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($modSayHello, 'nama_bin', array('placeholder' => 'Alias / Nama Panggilan', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($modSayHello, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
    </div>
</div>
<div class="clear"></div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
    );
    echo CHtml::hiddenField('pendaftaran_id');
    echo CHtml::hiddenField('pasien_id');
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array(
        'title' => 'Ulang',
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    ));
    ?>
    <?php
    $content = $this->renderPartial('../tips/informasi', array(), true);
    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<!--</fieldset>-->
<script>
    function cekTanggal() {
        var checklist = $('#INInfopasiensayhelloV_ceklis');
        var pilih = checklist.attr('checked');
        if (pilih) {
            document.getElementById('INInfopasiensayhelloV_tgl_awal_date').setAttribute("style", "display:block;");
            document.getElementById('INInfopasiensayhelloV_tgl_akhir_date').setAttribute("style", "display:block;");
        } else {
            document.getElementById('INInfopasiensayhelloV_tgl_awal_date').setAttribute("style", "display:none;");
            document.getElementById('INInfopasiensayhelloV_tgl_akhir_date').setAttribute("style", "display:none;");
        }
    }
</script>