<?php $linkHalaman = CustomFunction::getUrlByMenuID(940); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Closing Kasir',
);
Yii::app()->clientScript->registerScript('search', "
    $('#informasiclosingkasir-t-search').submit(function(){
        $('#informasiclosingkasir-m-grid').addClass('animation-loading');
        $.fn.yiiGridView.update('informasiclosingkasir-m-grid', {
                data: $(this).serialize()
        });
        return false;
    });
");
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'informasiclosingkasir-t-search',
    'type' => 'horizontal',
    'focus' => '#BKInformasiclosingkasirV_nama_pegawai'
));
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Closing Kasir</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="control-group">
                            <?php echo CHtml::label("Tgl. Closing", 'tgl_rekam', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($model->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d F Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($model->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("No. Closing", '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                echo $form->textField($model, 'closingkasir_no', array('placeholder' => 'No. Closing', 'class' => 'span4'));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Kasir", '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                $peg = CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array(
                                    'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
                                )), 'pegawai_id', 'namaLengkap');
                                echo $form->dropDownList($model, 'pegawai_id', $peg, array('empty' => '-- Pilih --', 'class' => 'span4'));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->dropDownlistRow($model, 'shift_id', Chtml::listData(ShiftM::model()->getShiftRuangan(Params::RUANGAN_ID_KASIR), 'shift_id', 'shiftJam'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
                        <div class="control-group">
                            <?php echo CHtml::label("Status Setor", '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'status_setor', array(1 => 'BELUM SETOR', 2 => 'SUDAH SETOR'), array('empty' => '-- Pilih --', 'class' => 'span4'));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                    ); ?>
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        array(
                            'title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                        )
                    ); ?>
                    <?php
                    $content = $this->renderPartial($this->path_view . 'tips/informasi', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Closing Kasir</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div id="divSearch-form">
                    <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                        'id' => 'informasiclosingkasir-m-grid',
                        'dataProvider' => $model->searchInformasi(),
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                        'columns' => array(
                            array(
                                'name' => 'tglclosingkasir',
                                'header' => 'Tanggal Closing Kasir/<br>No. Closing Kasir',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    $val = $data->tglclosingkasir . "/<br>" . $data->closingkasir_no;
                                    return CHtml::link(
                                        '<u>' . $val . '</u>',
                                        Yii::app()->controller->createUrl(Yii::app()->controller->id . "/Rincian", array("idClosing" => $data->closingkasir_id)),
                                        array(
                                            "class" => "",
                                            "target" => "iframeRincianClosing",
                                            "onclick" => "$(\"#dialogRincianClosing\").dialog(\"open\");",
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk melihat Rincian Closing",
                                        )
                                    );
                                },
                            ),
                            'shift_nama',
                            array(
                                'name' => 'closingdari',
                                'header' => 'Periode Closing',
                                'type' => 'raw',
                                'value' => '$data->closingdari." sd.<br> ".$data->sampaidengan',
                            ),
                            array(
                                'header' => 'Saldo Awal <br>(Rp)',
                                'name' => 'closingsaldoawal',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatNumberForPrint($data->closingsaldoawal)',
                                'htmlOptions' => array('style' => 'text-align: right'),
                            ),
                            array(
                                'header' => 'Uang Muka <br>(Rp)',
                                'name' => 'terimauangmuka',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatNumberForPrint($data->terimauangmuka)',
                                'htmlOptions' => array('style' => 'text-align: right'),
                            ),
                            array(
                                'header' => 'Total Retur <br>(Rp)',
                                'type' => 'raw',
                                'value' => '(!empty($data->jumlahreturoa)?MyFormatter::formatNumberForPrint($data->jumlahreturoa):"0")',
                                'htmlOptions' => array('style' => 'text-align: right'),
                            ),
                            array(
                                'header' => 'Piutang <br>(Rp)',
                                'name' => 'piutang',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatNumberForPrint($data->piutang)',
                                'htmlOptions' => array('style' => 'text-align: right'),
                            ),
                            array(
                                'header' => 'Tunai <br>(Rp)',
                                'type' => 'raw',
                                'value' => '(!empty($data->jumlahtunai)?MyFormatter::formatNumberForPrint($data->jumlahtunai):"0")',
                                'htmlOptions' => array('style' => 'text-align: right'),
                            ),
                            array(
                                'header' => 'Non Tunai <br>(Rp)',
                                'type' => 'raw',
                                'value' => '(!empty($data->jumlahnontunai)?MyFormatter::formatNumberForPrint($data->jumlahnontunai):"0")',
                                'htmlOptions' => array('style' => 'text-align: right'),
                            ),
                            array(
                                'header' => 'Jumlah Closing <br>(Rp)',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatNumberForPrint($data->terimauangpelayanan)',
                                'htmlOptions' => array('style' => 'text-align: right'),
                            ),
                            array(
                                'header' => 'Kirim',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    if ($data->is_kirim) {
                                        return MyFormatter::formatDateTimeForuser($data->kirim_tgl);
                                    }
                                    return CHtml::Link(
                                        '<i class="icon-form-ubah"></i>',
                                        '#',
                                        array(
                                            "class" => "",
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk kirim closing ke Keuangan",
                                            "onclick" => "setDialogKirimClosingKeKeuangan(" . CJSON::encode($data->attributes) . "); return false;",
                                        )
                                    );
                                },
                                'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            ),
                            /*
									array(
										'header'=>'Setor ke Bank',
										'type'=>'raw',
                                        'value'=>function($data) {
                                            $det = RinciansetoranbdharaT::model()->findByAttributes(array(
                                                'closingkasir_id'=>$data->closingkasir_id,
                                            ));
                                            if (!empty($det)) {
                                                $setor = SetoranbdharaT::model()->findByPk($det->setoranbdhara_id);
                                                return CHtml::link('<u>'.$setor->nosetoranbdhara.'<u>', Yii::app()->createUrl('keuangan/setoranBendaharaKeBank/print', array(
                                                    'id'=>$setor->setoranbdhara_id,
                                                    'frame'=>1,
                                                )), array(
                                                    "target"=>"iframeRincianSetoran2",
                                                    "onclick"=>'$("#dialogRincianSetoran2").dialog("open")',
                                                    "rel"=>"tooltip",
                                                    "title"=>"Klik untuk melihat detail Setor ke Bank",
                                                ));
                                            }
                                            return CHtml::Link('<i class="icon-form-bayar"></i>',Yii::app()->controller->createUrl("setoranBendaharaKeBankBK/index",array("closing_id"=>$data->closingkasir_id)),
                                            array("class"=>"", 
                                                  "rel"=>"tooltip",
                                                  "title"=>"Klik untuk melakukan Setor ke Bank",
                                            ));
                                        },
										'htmlOptions'=>array('style'=>'text-align: center; width:120px')
									),
                                     * 
                                     */
                            array(
                                'header' => 'Batal',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    if ($data->is_kirim) {
                                        return "SUDAH DIKIRIM";
                                    }
                                    $det = RinciansetoranbdharaT::model()->findByAttributes(array(
                                        'closingkasir_id' => $data->closingkasir_id,
                                    ));
                                    if (!empty($det)) return "SUDAH DISETOR";
                                    return CHtml::Link(
                                        '<i class="icon-form-silang"></i>',
                                        Yii::app()->controller->createUrl("ClosingKasir/Batalclosing", array("idClosing" => $data->closingkasir_id)),
                                        array(
                                            "class" => "",
                                            "target" => "iframeBatalClosing",
                                            "onclick" => '
																	if (confirm("Anda yakin untuk membatalkan closing?")) {
																		$("#dialogBatalClosing").dialog("open"), refreshTable();
																		return true;
																	} else {
																		return false;
																	}
																	',
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk membatalkan Closing Kasir",
                                        )
                                    );
                                },
                                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                'visible' => (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_KASIR) ? true : false
                            ),
                            array(
                                'header' => 'Petugas Kasir',
                                'name' => 'nama_pegawai',
                            ),
                        ),
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                    )); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<script>
    function resetForm() {
        window.open("<?php echo $this->createUrl("/" . $this->route); ?>", "_self");
    }
    // Fungsi untuk merefresh table grid, setelah row dibatal kan table harus direfresh agar data terupdate
    function refreshTable() {
        var delay = 2000; //2 seconds
        setTimeout(function() {
            $('#informasiclosingkasir-m-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('informasiclosingkasir-m-grid', {
                data: $(this).serialize()
            });
            return false;
        }, delay);
    }
</script>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRincianSetoran',
    'options' => array(
        'title' => 'Rincian Setoran Ke Bank',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 480,
        'height' => 360,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeRincianSetoran" width="100%" height="320"></iframe>
<?php
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRincianSetoran2',
    'options' => array(
        'title' => 'Rincian Setoran Ke Bank',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1000,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeRincianSetoran2" width="100%" height="450"></iframe>
<?php
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRincianClosing',
    'options' => array(
        'title' => 'Rincian Closing Kasir',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1000,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeRincianClosing" width="100%" height="460"></iframe>
<?php
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogBatalClosing',
    'options' => array(
        'title' => 'Batal Closing',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 480,
        'height' => 300,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeBatalClosing" width="100%" height="256"></iframe>
<?php
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogKirim',
    'options' => array(
        'title' => 'Kirim Closing ke Keuangan',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 480,
        'height' => 220,
        'resizable' => true,
    ),
));
$formKirim = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => '#',
    'id' => 'formKirim',
    'type' => 'horizontal',
));
?>
<div class="col-sm-12">
    <div class="control-group">
        <label class="control-label">Tgl. Closing Kasir</label>
        <div class="controls">
            <?php echo CHtml::textField('form_kirim[tgl_closing]', '', array('readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">No. Closing Kasir</label>
        <div class="controls">
            <?php echo CHtml::hiddenField('form_kirim[closingkasir_id]'); ?>
            <?php echo CHtml::textField('form_kirim[no_closing]', '', array('readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Keterangan <span class="required">*</span></label>
        <div class="controls">
            <?php echo CHtml::textArea('form_kirim[keterangan]', '', array('readonly' => false, 'placeholder' => 'Keterangan',)); ?>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton('<i class="entypo-check"></i> Simpan', array('id' => 'form_kirim_simpan', 'class' => 'btn btn-primary', 'onclick' => 'kirimClosingKeKeuangan();')); ?>
    </div>
</div>
<?php
$this->endWidget();
$this->endWidget();
?>
<script>
    function setDialogKirimClosingKeKeuangan(data) {
        $("#dialogKirim").dialog("open");
        $("#form_kirim_simpan").prop("disabled", false);
        $("#dialogKirim :input").val("");
        $("#dialogKirim #form_kirim_closingkasir_id").val(data.closingkasir_id);
        $("#dialogKirim #form_kirim_no_closing").val(data.closingkasir_no);
        $("#dialogKirim #form_kirim_tgl_closing").val(data.tglclosingkasir);
    }

    function kirimClosingKeKeuangan() {
        var str = $("#form_kirim_keterangan").val();
        if (str.trim() == "") {
            myAlert("Keterangan harus diisi.");
            return false;
        }
        $("#form_kirim_simpan").prop("disabled", true);
        $.post('<?php echo $this->createUrl('kirimClosingKeKeuangan'); ?>', $("#formKirim").serialize(), function(data) {
            if (data.ok == 1) {
                myAlert(data.msg);
            } else {
                myAlert(data.msg);
            }
            $("#dialogKirim").dialog("close");
            $("#dialogKirim :input").val("");
            $.fn.yiiGridView.update("informasiclosingkasir-m-grid");
        }, 'json');
    }
</script>