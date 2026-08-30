<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pemakaian Obat Ruangan',
);
Yii::app()->clientScript->registerScript('cariPasien', "
    $('#pemakaianbahan-form').submit(function(){
        $.fn.yiiGridView.update('pemakaianbahan-grid', {
            data: $(this).serialize()
        });
        return false;
    });
"); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pemakaianbahan-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'method' => 'get',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pemakaian Obat & Alkes Ruangan</b>
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
                            <?php echo CHtml::label("Tanggal", 'tgl_rekam', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tglAwal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tglAkhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d M Y', strtotime($model->tglAwal)) ?> - <?php echo date('d M Y', strtotime($model->tglAkhir)) ?></span>
                                    <?php echo $form->hiddenField($model, 'tglAwal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($model, 'tglAkhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('No. Pemakaian Obat', 'nopemakaian_obat', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'nopemakaian_obat', array('placeholder' => 'No. Pemakaian Obat', 'class' => 'span4 angkahuruf-only')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Pegawai', 'pegawai_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList(
                                    $model,
                                    'pegawai_id',
                                    CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array(
                                        'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
                                        'pegawai_aktif' => true,
                                    ), array(
                                        'order' => 'nama_pegawai',
                                    )), 'pegawai_id', 'namaLengkap'),
                                    array('empty' => '-- Pilih --', 'class' => 'span4')
                                ); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                    ); ?>
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset', 'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = window.location.href;} ); return false;')
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
                    <i class="entypo-credit-card"></i> Tabel <b>Pemakaian Obat Ruangan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'pemakaianbahan-grid',
                    'dataProvider' => $model->searchPemakaian(),
                    //        'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'name' => 'tglpemakaianobat',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpemakaianobat)',
                        ),
                        array(
                            'name' => 'nopemakaian_obat',
                        ),
                        array(
                            'header' => 'Pegawai',
                            'name' => 'pegawai.pegawai_nama',
                            'type' => 'raw',
                            'value' => '$data->pegawai->namaLengkap',
                        ),
                        array(
                            'name' => 'untukkeperluan_obat',
                        ),
                        array(
                            'header' => 'Detail',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link(
                                    '<i class="icon-form-detail"></i>',
                                    $this->createUrl('detail', array('id' => $data->pemakaianobat_id)),
                                    array(
                                        'target' => 'iframeDetail',
                                        'onclick' => '$("#dialogDetail").dialog("open");',
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk melihat detail pemakaian obat",
                                    )
                                );
                            },
                            'htmlOptions' => array('style' => 'text-align: center'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
// Dialog untuk menambah data provinsi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Pemakaian Obat Ruangan',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="iframeDetail" width="100%" height="450"></iframe>
<?php
$this->endWidget();
//========= end propinsi dialog =============================
?>