<?php
$this->breadcrumbs = array(
    'Setoran Ke Bank' => array('/keuangan/setoranBendaharaKeBank'),
    'Informasi',
);
Yii::app()->clientScript->registerScript('search', "
$('#informasi-search').submit(function(){
    $('#informasi-grid').addClass('animation-loading');
    $.fn.yiiGridView.update('informasi-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Setoran ke Bank</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'id' => 'informasi-search',
            'type' => 'horizontal',
        ));
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label("Tgl disetor", '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($model->tgl_akhir)) ?>">
                                <i class="entypo-calendar"></i>
                                <span><?php echo date('d F Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($model->tgl_akhir)) ?></span>
                                <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                            </div>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($model, 'nosetoranbdhara'); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo $form->textFieldRow($model, 'nostruksetor'); ?>
                    <?php
                    $bankMod = BankM::model()->findAll('bank_aktif = true order by namabank');
                    $bankData = CHtml::listData($bankMod, 'namabank', 'namabank');
                    echo $form->dropDownListRow($model, 'namabank', $bankData, array('empty' => '-- Pilih --')); ?>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                    ); ?>
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'reset')) . " "; ?>
                    <?php
                    $content = $this->renderPartial($this->path_view . 'tips', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Setoran ke Bank</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasi-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'Tgl. Disetor/<br>No. Disetor',
                            'name' => 'nosetoranbdhara',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link(
                                    '<u>' . MyFormatter::formatDateTimeForUser($data->tglsetoranbdhara) . '<br>' . $data->nosetoranbdhara . '</u>',
                                    $this->createUrl('print', array('id' => $data->setoranbdhara_id, 'frame' => 1)),
                                    array(
                                        'target' => 'iframeDetail',
                                        'onclick' => '$("#dialogDetail").dialog("open");',
                                        'data-toggle' => 'tooltip',
                                        'title' => "Klik untuk melihat detail Setoran",
                                    )
                                );
                            }
                        ),
                        array(
                            'header' => 'Rincian<br>Setoran',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link(
                                    '<i class="entypo-doc-text"></i>',
                                    $this->createUrl('rincianSetoran', array('id' => $data->setoranbdhara_id, 'frame' => 1)),
                                    array(
                                        'target' => 'iframeDetail',
                                        'onclick' => '$("#dialogDetail").dialog("open");',
                                        'data-toggle' => 'tooltip',
                                        'title' => "Klik untuk melihat rincian Setoran",
                                    )
                                );
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                        ),
                        array(
                            'name' => 'nostruksetor'
                        ),
                        array(
                            'name' => 'norekening'
                        ),
                        array(
                            'name' => 'namabank'
                        ),
                        array(
                            'name' => 'atasnama'
                        ),
                        array(
                            'name' => 'jumlahsetoran',
                            'value' => 'MyFormatter::formatNumberForPrint($data->jumlahsetoran);',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;',
                            ),
                        ),
                        array(
                            'name' => 'pegawai_id',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (empty($data->pegawai_id)) {
                                    return "-";
                                } else {
                                    $dat1 = PegawaiM::model()->findByPk($data->pegawai_id);
                                    if (!empty($dat1)) {
                                        return $dat1->namaLengkap;
                                    }
                                    //return $dat->pegawai_id;
                                    //return $peg->namaLengkap;
                                }
                            }
                        ),
                        array(
                            'name' => 'mengetahui_id',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (empty($data->mengetahui_id)) {
                                    return "-";
                                } else {
                                    $dat = PegawaiM::model()->findByPk($data->mengetahui_id);
                                    if (!empty($dat)) {
                                        return $dat->namaLengkap;
                                    }
                                }
                            }
                            //return $peg->namaLengkap;
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Setoran ke Bank',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1024,
        'minHeight' => 400,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeDetail" width="100%" height="550" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>