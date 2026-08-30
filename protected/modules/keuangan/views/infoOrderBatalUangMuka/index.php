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
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
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
<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi Order Batal Uang Muka Pasien
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
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Tgl. Order Batal Uang Muka", 'tgl_rekam', array('class' => 'control-label')) ?>
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
                            <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                        <div class="control-group">
                            <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                        <div class="control-group">
                            <?php echo $form->textFieldRow($model, 'nama_pasien', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Status", "status", array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                echo $form->dropDownList($model, 'status', array(1 => 'BELUM DIVERIFIKASI', 2 => 'SUDAH DIVERIFIKASI'), array(
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
                                echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true order by instalasi_nama'), 'instalasi_id', 'instalasi_nama'), array(
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
                                if (!empty($model->instalasi_id)) {
                                    $modRuangans = RuanganM::model()->findAllByAttributes(array(
                                        'instalasi_id' => $model->instalasi_id,
                                        'ruangan_aktif' => true,
                                    ), array(
                                        'order'=>'ruangan_nama',
                                    ));
                                } else {
                                    $modRuangans = array();
                                }
                                echo $form->dropDownList($model, 'ruangan_id', ((count((array)$modRuangans) > 0) ? CHtml::listData($modRuangans, 'ruangan_id', 'ruangan_nama') : array()), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                                ?>
                            </div>
                        </div>
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
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit')); ?>
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'reset')); ?>
                    <?php
                    $content = $this->renderPartial('billingKasir.views.daftarPasien/tips/informasi2', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <strong>Order Batal Uang Muka</strong>
                </div>
            </div>
            <div class="panel-body">
                <div class="table-responsive overflow-x">
                    <?php
                    $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'pencarianpasien-grid',
                        'dataProvider' => $model->searchInformasi(),
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                        'columns' => array(
                            array(
                                'header' => 'Tgl. Order Batal Unag Muka/<br/>No. Pembayaran<br>',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->tglorderbatal) . " <br> " . $data->nouangmuka ',
                            ),
                            array(
                                'header' => 'Tgl. Pendaftaran/<br/>No. Pendaftaran<br>',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran) . " <br> " . $data->no_pendaftaran ',
                            ),
                            array(
                                'header' => 'Instalasi / Ruangan',
                                'type' => 'raw',
                                'value' => 'isset($data->instalasi_nama)?$data->ruangan_nama. " / ".$data->ruangan_nama:" - "',
                            ),
                            array(
                                'header' => 'Jenis Penjamin/<br/>Penjamin',
                                'type' => 'raw',
                                'value' => '$data->carabayar_nama."/<br/>".$data->penjamin_nama',
                            ),
                            array(
                                'header' => 'No. Rekam Medik',
                                'type' => 'raw',
                                'value' => '$data->no_rekam_medik',
                            ),
                            array(
                                'name' => 'nama_pasien',
                                'type' => 'raw',
                                'value' => '$data->nama_pasien',
                            ),
                            array(
                                'header' => 'Total Uang Muka',
                                'type' => 'raw',
                                'value' => function($data) {
                                    $str = "Rp. ".MyFormatter::formatNumberForPrint($data->jumlahuangmuka,2);
                                    /*
                                    if ($data->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR) {
                                        if ($data->jumlahuangmuka >= 2000000) {
                                            $str .= '<span class="sorot_merah">&nbsp;</span>';
                                        } else {
                                            $str .= '<span class="sorot_kuning">&nbsp;</span>';
                                        }
                                    }
                                    */
                                    return $str;
                                }, //'"Rp. ".MyFormatter::formatNumberForPrint($data->jumlahuangmuka,2)',
                                'htmlOptions' => array('style' => 'text-align: left; width:80px'),
                                'htmlOptions' => array(
                                    'style' => 'text-align: right',
                                ),
                            ),
                            
                            array(
                                'header' => 'Petugas Kasir',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    $bayar = BayaruangmukaT::model()->findByPk($data->bayaruangmuka_id);
                                    $login = LoginpemakaiK::model()->findByPk($bayar->create_loginpemakai_id);
                                    if (empty($login->pegawai_id)) return "-";
                                    $peg = PegawaiM::model()->findByPk($login->pegawai_id);
                                    return $peg->namaLengkap;
                                },
                            ),
                            array(
                                'header' => 'Verifikasi',
                                'type' => 'raw',
                                'value' => function($data) {

                                    if ($data->is_verifikasiorderbatal) {
                                        return CHtml::htmlButton('SUDAH DIBATALKAN<br/>PEMBAYARAN', array(
                                            'class'=>'btn btn-warning',
                                        ));
                                    }

                                    return CHtml::link('<i class="icon-form-check"></i>', 
                                    Yii::app()->createUrl('/billingKasir/pembatalanUangMuka/index', array(
                                        'idBayarUangMuka'=>$data->bayaruangmuka_id, 'frame'=>1
                                    ))
                                    , array(
                                        'target'=>'iframePembayaran',
                                        'onclick'=>"$('#dialogBatalUangMuka').dialog('open');",
                                        //'onclick'=>'verifikasiBatal('.$data->orderbataluangmuka_id.'); return false',
                                        'rel'=>'tooltip',
                                        'title'=>'Klik untuk verifikasi order batal uang muka',
                                    ));
                                },
                                'htmlOptions' => array(
                                    'style' => 'text-align: center',
                                ),
                            ),
                        ),
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); sorotTabel();}',
                    ));
                    ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
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

    function verifikasiBatal(id) {

        myConfirm("Anda yakin untuk verifikasi order pembatalan pembayaran deposit?", "Peringatan", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('verifikasiBatal'); ?>', {
                    orderbataluangmuka_id: id
                }, function(data) {
                    if (data.ok == 1) {
                        $.fn.yiiGridView.update("pencarianpasien-grid");
                        myAlert(data.msg);
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });

        //myConfirm("Pembatalan uang muka pasien juga akan menghapus data jurnal, apakah anda melanjutkan ?", "Peringatan", function(r) {
        //window.location.href = "<?php echo Yii::app()->controller->createUrl("pembatalanUangMuka/index") ?>&idBayarUangMuka=" + id;
        //});
    }

    function confirmPengembalian(id) {
        window.location.href = "<?php echo Yii::app()->controller->createUrl("pembatalanUangMuka/pengembalian") ?>&idBayarUangMuka=" + id;
    }

    function sorotTabel() {
        $(".sorot_merah").each(function() {
            $(this).parents("tr").addClass("row_merah");
        });
        $(".sorot_kuning").each(function() {
            $(this).parents("tr").addClass("row_kuning");
        });
    }

    $(document).ready(function() {
        sorotTabel();
    });
</script>