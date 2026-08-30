<?php
$this->breadcrumbs = array(
    'Informasi Kirim Closing Kasir ke Keuangan',
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
            <i class="entypo-info-circled"></i> Informasi <b>Kirim Closing Kasir ke Keuangan</b>
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
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Tgl. Kirim", 'tgl_kirim', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($model->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d F Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($model->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("No. Closing", '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                echo $form->textField($model, 'closingkasir_no', array('placeholder' => 'No. Closing', 'class' => 'span4'));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group" hidden>
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
                        <?php // echo $form->dropDownlistRow($model,'shift_id',Chtml::listData($model->ShiftItems, 'shift_id', 'shift_nama'),array('empty'=>'-- Pilih --','class'=>'span4')); 
                        ?>
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
                        array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset', 'onclick' => 'resetForm();')
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
                    <i class="entypo-credit-card"></i> Tabel <b>Kirim Closing Kasir ke Keuangan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div id="divSearch-form" class="table-responsive">
                    <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                        'id' => 'informasiclosingkasir-m-grid',
                        'dataProvider' => $model->searchInformasiKirim(),
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                        'replaceUrl' => 'true',
                        /*
								'mergeHeaders'=>array(
									array(
										'name'=>'<p style="margin: 0; text-align: center;">Penerimaan</p>',
										'start'=>4, 
										'end'=>5, 										
									),
									array(
										'name'=>'<p style="margin: 0; text-align: center;"></p>',
										'start'=>(Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_KASIR)?10:9, 
										'end'=>(Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_KASIR)?10:9, 
									)
								),
                                 * 
                                 */
                        'columns' => array(
                            array(
                                'name' => 'kirim_tgl',
                                'header' => 'Tanggal Kirim',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    return MyFormatter::formatDateTimeForUser($data->kirim_tgl);
                                },
                            ),
                            array(
                                'header' => 'No. Closing',
                                'name' => 'closingkasir_no',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    $val = $data->closingkasir_no;
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
                                }
                            ),
                            array(
                                'header' => 'Petugas Pengirim',
                                'name' => 'kirim_pegawai_nama',
                            ),
                            array(
                                'header' => 'Keterangan',
                                'name' => 'kirim_keterangan',
                            ),
                            array(
                                'header' => 'Setor ke Bank',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    $det = RinciansetoranbdharaT::model()->findByAttributes(array(
                                        'closingkasir_id' => $data->closingkasir_id,
                                    ));
                                    if (!empty($det)) {
                                        $setor = SetoranbdharaT::model()->findByPk($det->setoranbdhara_id);
                                        return CHtml::link('<u>' . $setor->nosetoranbdhara . '<u>', Yii::app()->createUrl('keuangan/setoranBendaharaKeBank/print', array(
                                            'id' => $setor->setoranbdhara_id,
                                            'frame' => 1,
                                        )), array(
                                            "target" => "iframeRincianSetoran2",
                                            "onclick" => '$("#dialogRincianSetoran2").dialog("open")',
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk melihat detail Setor ke Bank",
                                        ));
                                    }
                                    return CHtml::Link(
                                        '<i class="icon-form-bayar"></i>',
                                        Yii::app()->controller->createUrl(Yii::app()->controller->url_setor_bank, array("closing_id" => $data->closingkasir_id)),
                                        array(
                                            "class" => "",
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk melakukan Setor ke Bank",
                                        )
                                    );
                                },
                                'htmlOptions' => array('style' => 'text-align: center; width:120px')
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