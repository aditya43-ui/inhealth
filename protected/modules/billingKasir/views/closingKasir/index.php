<?php $linkHalaman = CustomFunction::getUrlByMenuID(1135); ?>
<?php
$this->breadcrumbs = array(
    'Closing Kasir',
); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Closing <b>Kasir</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
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
                <?php $this->renderPartial('_search', array('model' => $model, 'mBuktBayar' => $mBuktBayar,)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-info-circled"></i> Informasi <b>Pembayaran</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $form = $this->beginWidget(
                    'ext.bootstrap.widgets.BootActiveForm',
                    array(
                        'action' => Yii::app()->createUrl($this->route),
                        'method' => 'POST',
                        'type' => 'horizontal',
                        'id' => 'formClosing',
                        'focus' => '#BKTandabuktibayarT_ruangan_id',
                        'htmlOptions' => array(
                            'enctype' => 'multipart/form-data',
                            'onKeyPress' => 'return disableKeyPress(event)',
                            'onsubmit' => 'return cekValidasi(this);'
                        ),
                    )
                );
                ?>
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php
                $this->renderPartial(
                    '_table',
                    array(
                        'mBuktBayar' => $mBuktBayar,
                        'mBuktiKeluar' => $mBuktiKeluar,
                        'form' => $form,
                    )
                );
                ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Penutupan</b>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $this->renderPartial(
                    '_formClosing',
                    array(
                        'model' => $model,
                        'informasi' => $informasi,
                        'rPenerimaanUmum' => $rPenerimaanUmum,
                        'rPengeluaranUmum' => $rPengeluaranUmum,
                        'rPecahanUang' => $rPecahanUang,
                        'mSetorBank' => $mSetorBank,
                        'form' => $form,
                        'format' => $format,
                        'id' => $id,
                    )
                );
                ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogRincianTagihan',
            'options' => array(
                'title' => 'Rincian',
                'autoOpen' => false,
                'modal' => true,
                'minWidth' => 1024,
                'height' => 400,
                'resizable' => true,
            ),
        ));
        ?>
        <iframe src="" name="iframeRincianTagihan" style="width: 100%; height: 98%;"></iframe>
        <?php
        $this->endWidget();
        ?>