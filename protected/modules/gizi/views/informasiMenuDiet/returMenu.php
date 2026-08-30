<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'returmenudiet-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
));
?>
<?php
if (!empty($_GET['id'])) {
?>
    <div class="alert alert-block alert-success">
        <a class="close" data-dismiss="alert">×</a>
        Data berhasil disimpan
    </div>
<?php } else {
} ?>
<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->
<?php echo $form->errorSummary($modKirim); ?>

<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::activeLabel($modKirim, 'jenispesanmenu', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo CHtml::activeTextField($modKirim, 'jenispesanmenu', array('readonly' => true))
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modKirim, 'nokirimmenu', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo CHtml::activeTextField($modKirim, 'nokirimmenu', array('readonly' => true))
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modKirim, 'tglkirimmenu', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo CHtml::activeTextField($modKirim, 'tglkirimmenu', array('readonly' => true))
            ?>
        </div>
    </div>

</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php if ($modKirim->jenispesanmenu == 'Pasien') { ?>
            <?php echo CHtml::Label('Nama Pasien', '', array('class' => 'control-label')) ?>
        <?php } else { ?>
            <?php echo CHtml::Label('Nama Tamu / Pegawai', '', array('class' => 'control-label')) ?>
        <?php } ?>
        <div class="controls">
            <?php if ($modKirim->jenispesanmenu == 'Pasien') {
                $nama = isset($modKirim->kirimmenupasien->kirimmenupasien_id) ? $modKirim->kirimmenupasien->pasien->nama_pasien : "";
            } else {
                $nama = isset($modKirim->kirimmenupegawai->kirimmenupegawai_id) ? $modKirim->kirimmenupegawai->pegawai->nama_pegawai : "";
            }
            ?>
            <?php
            echo CHtml::TextField('nama', $nama, array('readonly' => true))
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::Label('Ruangan', '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php if ($modKirim->jenispesanmenu == 'Pasien') {
                $ruangan = isset($modKirim->kirimmenupasien->kirimmenupasien_id) ? $modKirim->kirimmenupasien->ruangan->ruangan_nama : "";
            } else {
                $ruangan = isset($modKirim->kirimmenupegawai->kirimmenupegawai_id) ? $modKirim->kirimmenupegawai->ruangan->ruangan_nama : "";
            }
            ?>
            <?php
            echo CHtml::TextField('ruangan', $ruangan, array('readonly' => true))
            ?>
        </div>
    </div>

</div>
<div class="clear"></div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Daftar <b>Menu Diet</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->renderPartial('_tblReturMenu', array('modDetailKirim' => $modDetailKirim, 'modKirim' => $modKirim)); ?>

    </div>
</div>
<div class="form-actions">
    <?php
    if (!empty($_GET['id'])) {
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array(
            'class' => 'btn btn-danger',
            'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true
        ));
    } else {
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array(
            'class' => 'btn btn-danger',
            'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'
        ));
    }
    ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array('class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'closeDialog();')
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/transaksi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    function checkAll(kelas, obj) {
        if (obj.checked) {
            $('.' + kelas + '').each(function() {
                $(this).attr('checked', 'checked');
            });
        } else {
            obj.checked = false;
            $('.' + kelas + '').each(function() {
                $(this).removeAttr('checked');
            });
        }
    }

    function closeDialog() {
        window.parent.$('#dialogUbahMenu').dialog('close');
    }
</script>