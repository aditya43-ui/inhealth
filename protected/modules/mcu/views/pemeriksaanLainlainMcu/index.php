<?php
$this->breadcrumbs = array(
    'Mcu',
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data Pemeriksaan Lain-lain berhasil disimpan");
}
$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'periksaanlainlain-mcu-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
)); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pemeriksaan Lain-lain
        </div>
    </div>
    <div class="panel-body">
        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'form-riwayat',
            'content' => array(
                'content-riwayat' => array(
                    'header' => '<b>Riwayat Pemeriksaan Lain-lain</b>',
                    'isi' => $this->renderPartial($this->path_view . '_formRiwayat', array(
                        'form' => $form,
                        'modMcuPemeriksaanlainlain' => $modMcuPemeriksaanlainlain,
                        'modMcuPemeriksaanlainlainRiwayat' => $modMcuPemeriksaanlainlainRiwayat,
                        'format' => $format,
                        'modPendaftaran' => $modPendaftaran
                    ), true),
                    'active' => false,
                ),
            ),
        )); ?>
        <div class="panel-body">
            <div style="float:right;margin-bottom:0px">
                <?php
                echo CHtml::link(
                    Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                    $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id'] . '&baru="baru"'),
                    array(
                        'class' => 'btn btn-default',
                        'onclick' => 'return tambahbaru(this);',
                        "rel" => "tooltip",
                        "title" => "Klik untuk tambah data baru"
                    )
                ); ?>
            </div>
        </div>
        <div class="panel-body">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Tgl. Pemeriksaan', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $modMcuPemeriksaanlainlain->tgl_pemeriksaan = $format->formatDateTimeForUser($modMcuPemeriksaanlainlain->tgl_pemeriksaan);
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modMcuPemeriksaanlainlain,
                            'attribute' => 'tgl_pemeriksaan',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,

                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'class' => 'span2',
                                'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Dokter', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeHiddenField($modMcuPemeriksaanlainlain, 'dokterpemeriksa_id'); ?>
                        <?php echo CHtml::textField('nama_pegawai', empty($modMcuPemeriksaanlainlain->dokterpemeriksa) ? "" : $modMcuPemeriksaanlainlain->dokterpemeriksa->namaLengkap, array('readonly' => true)); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->renderPartial($this->path_view . '_formPemeriksaanLainlain', array(
            'form' => $form,
            'modMcuPemeriksaanlainlain' => $modMcuPemeriksaanlainlain,
            'modMcuPemeriksaanlainlainRiwayat' => $modMcuPemeriksaanlainlainRiwayat,
            'format' => $format,
            'modPendaftaran' => $modPendaftaran
        )); ?>

    </div>
</div>
<div class="form-actions">
    <?php
    $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
    $disableSave = false;
    $disableSave = (!empty($_GET['id'])) ? true : (($sukses > 0) ? true : false);
    ?>
    <?php $disablePrint = ($disableSave) ? false : true; ?>
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'disabled' => $disableSave)); //formSubmit(this,event)        
    ?>
    <?php if (!isset($_GET['frame'])) {
        echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id']),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'return refreshForm(this);'
            )
        );
    } ?>
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => $disablePrint, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
    ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips/tipsTreadmill', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array(
    'modMcuPemeriksaanlainlain' => $modMcuPemeriksaanlainlain,
    'modMcuPemeriksaanlainlainRiwayat' => $modMcuPemeriksaanlainlainRiwayat,
    'format' => $format,
    'modPendaftaran' => $modPendaftaran
)); ?>