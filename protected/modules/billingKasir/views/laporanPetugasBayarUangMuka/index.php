<style>
    .row_kuning td {
        /* background-color: yellow !important; */
        background-color: #FFFDD0 !important;
    }

    .row_merah td {
        /* background-color: red !important; */
        background-color: #FCC7CF !important;
        /* color: white; */
    }
</style>

<?php $linkHalaman = CustomFunction::getUrlByMenuID(257); ?>
<?php
$this->breadcrumbs = array(
    'Laporan'
);
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>

<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Laporan Penerimaan Pembayaran Uang Muka
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'caripasien-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'focus' => '#BKInformasibayaruangmukaV',
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
                ));
                Yii::app()->clientScript->registerScript('cariPasien', "
                    $('#caripasien-form').submit(function(){
                            $.fn.yiiGridView.update('pencarianpasien-grid', {
                                    data: $(this).serialize()
                            });
                            return false;
                    });
                    ");
                ?>
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Tgl. Pembayaran Uang Muka", 'tgl_rekam', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->textFieldRow($model, 'nouangmuka', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                        <div class="control-group">
                            <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                        <div class="control-group">
                            <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                        <div class="control-group">
                            <?php echo $form->textFieldRow($model, 'nama_pasien', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                        <div class="control-group">
                            <?php echo Chtml::label("NIK", 'no_identitas_pasien', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'no_identitas_pasien', array('class' => 'span3 custom-only', 'maxlength' => 50, 'rows' => 3)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Status", "status", array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                echo $form->dropDownList($model, 'status', array(3 => 'BELUM DIBAYAR', 1 => 'SUDAH DIBAYAR', 2 => 'SUDAH DIBATALKAN'), array(
                                    'class' => 'span3',
                                    'empty' => '-- Pilih --',
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Instalasi", "instalasi_id", array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(BKInstalasiM::getItems(), 'instalasi_id', 'instalasi_nama'), array(
                                    'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($model))),
                                        'success' => 'function(data){$("#' . CHtml::activeId($model, "ruangan_id") . '").html(data);}',
                                    )
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Ruangan", "ruangan_id", array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                $modRuangans = BKRuanganM::getItems($model->instalasi_id);
                                echo $form->dropDownList($model, 'ruangan_id', ((count((array)$modRuangans) > 0) ? CHtml::listData($modRuangans, 'ruangan_id', 'ruangan_nama') : array()), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                                ?>
                            </div>
                        </div>
                        <?php /*
                        <div class="control-group">
                            <?php echo CHtml::label("Petugas Kasir", "pegawai_id", array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                echo $form->dropDownList($model, 'pegawai_id', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(
                                    array('ruangan_id' => Params::RUANGAN_ID_KASIR)
                                ), 'pegawai_id', 'namaLengkap'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                                ?>
                            </div>
                        </div>
                        */ ?>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit')); ?>
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'reset')); ?>
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'onclick'=>'printLaporan();')); ?>
                    <?php
                    $content = $this->renderPartial('billingKasir.views.daftarPasien/tips/informasi2', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>

                <?php $this->endWidget(); ?>
            </div>
        </div>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <strong>Pasien Uang Muka</strong>
                </div>
            </div>
            <div class="panel-body">
                <div class="table-responsive overflow-x">
                    <?php echo $this->renderPartial($this->path_view."_table", array('model'=>$model), true); ?>
                </div>
            </div>
        </div>
        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogBatalUangMuka',
            'options' => array(
                'title' => 'Pembatalan Uang Muka',
                'autoOpen' => false,
                'modal' => true,
                'minWidth' => 980,
                'zIndex' => 1001,
                'minHeight' => 610,
                'resizable' => true,
                'close' => "js:function(){ $.fn.yiiGridView.update('pencarianpasien-grid', {
								data: $(this).serialize()
							}); }",
            ),
        ));
        ?>
        <iframe src="" name="iframePembayaran" width="100%" height="550"></iframe>
        <?php
        $this->endWidget();
        ?>
        <?php
        $this->beginWidget(
            'zii.widgets.jui.CJuiDialog',
            array(
                'id' => 'dialogEditUangMuka',
                'options' => array(
                    'title' => 'Edit Uang Muka',
                    'autoOpen' => false,
                    'modal' => true,
                    'minWidth' => 980,
                    'zIndex' => 1001,
                    'minHeight' => 610,
                    'resizable' => true,
                ),
            )
        );
        ?>
        <iframe src="" name="iframeUangMuka" width="100%" height="550"></iframe>
        <?php
        $this->endWidget();
        ?>
        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogDetail',
            'options' => array(
                'title' => 'Rincian Pembayaran Uang Muka',
                'autoOpen' => false,
                'modal' => true,
                'minWidth' => 980,
                'zIndex' => 1001,
                'minHeight' => 610,
                'resizable' => true,
                'close' => "js:function(){ $.fn.yiiGridView.update('pencarianpasien-grid', {
								data: $(this).serialize()
							}); }",
            ),
        ));
        ?>
        <iframe src="" name="iframeDetail" width="100%" height="550"></iframe>
        <?php
        $this->endWidget();
        ?>
        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogDetailBatal',
            'options' => array(
                'title' => 'Detail Pembatalan Uang Muka',
                'autoOpen' => false,
                'modal' => true,
                'minWidth' => 1100,
                'zIndex' => 1001,
                'minHeight' => 610,
                'resizable' => true,
                'close' => "js:function(){ $.fn.yiiGridView.update('pencarianpasien-grid', {
								data: $(this).serialize()
							}); }",
            ),
        ));
        ?>
        <iframe src="" name="iframeDetailBatal" width="100%" height="550"></iframe>
        <?php
        $this->endWidget();
        ?>
    </div>
</div>
<?php //echo $this->renderPartial('_formKriteriaPencarian', array('model'=>$model,'form'=>$form),true);   
?>
<script>

    function printLaporan() {
        window.open("<?php echo $this->createUrl('print') ?>" + "&" + $("#caripasien-form").serialize(),"",'location=_new, width=640px, height=480px, left=640px, top=100px');
    }

    function confirmPengembalian(id) {
        window.location.href = "<?php echo Yii::app()->controller->createUrl("pembatalanUangMuka/pengembalian") ?>&idBayarUangMuka=" + id;
    }


</script>