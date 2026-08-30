<?php $linkHalaman = CustomFunction::getUrlByMenuID(2512); ?>
<?php
$this->breadcrumbs = array(
    // 'Informasi Penerimaan Linen' => Yii::app()->request->getUrlReferrer(),
    'Transaksi Pencucian Linen',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-soap"></i> Transaksi <b>Pencucian Linen</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
        $('#pencarian-form').submit(function(){
            $('#penerimaanpengeluaran-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('penerimaanpengeluaran-grid', {
                data: $(this).serialize()
            });
            return false;
        });
        ");
        ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash("success", "Data pencucian linen berhasil disimpan!");
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Penerimaan Linen
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_pencarian', array('modInfoPencucian' => $modInfoPencucian, 'instalasiTujuans' => $instalasiTujuans, 'ruanganTujuans' => $ruanganTujuans)); ?>
            </div>
        </div>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pencucianlinen-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
        ));
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Data <b>Linen</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php echo $this->renderPartial($this->path_view . '_rowLinen', array('modPencucianLinen' => $modPencucianLinen, 'modPencucianLinenDetail' => $modPencucianLinen, 'modPencucianBahan' => $modPencucianBahan, 'modInfoPencucian' => $modInfoPencucian)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pencucian</b>
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . '_form', array('form' => $form, 'modPencucianLinen' => $modPencucianLinen, 'modPencucianLinenDetail' => $modPencucianLinenDetail, 'modPencucianBahan' => $modPencucianBahan, 'instalasiTujuans' => $instalasiTujuans, 'ruanganTujuans' => $ruanganTujuans)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Bahan yang Digunakan untuk Dekontaminasi dan Pencucian
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . '_formPilihBahan', array('form' => $form, 'modPencucianLinen' => $modPencucianLinen, 'instalasiTujuans' => $instalasiTujuans, 'ruanganTujuans' => $ruanganTujuans)); ?>
                <br>
                <div class="block-tabel">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="entypo-credit-card"></i> Tabel <b>Bahan</b>
                            </div>
                        </div>
                        <div class="panel-body table-responsive">
                            <table class="items table table-striped table-condensed" id="table-detailbahan">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Bahan</th>
                                        <th>Jumlah Bahan</th>
                                        <th>Satuan</th>
                                        <th>Batal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (count((array)$modPencucianBahan) > 0) {
                                        foreach ($modPencucianBahan as $i => $modDetail) {
                                            echo $this->renderPartial($this->path_view . '_rowBahanLinen', array('modDetail' => $modDetail));
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php
            if (isset($_GET['pencucianlinen_id'])) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'disabled' => true, 'style' => 'cursor:not-allowed;')
                );
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'return refreshForm(this);'
                    )
                );
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT');return false", 'disabled' => FALSE));
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'button', 'onKeypress' => 'validasiCek();', 'onclick' => 'validasiCek();', 'disabled' => (isset($_GET['sukses'])) ? true : false)
                );
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'return refreshForm(this);'
                    )
                );
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => TRUE, 'style' => 'cursor:not-allowed;'));
            }
            ?>
            <?php
            $content = $this->renderPartial($this->path_view . 'tips/tipsPerawatanLinen', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modPencucianLinen' => $modPencucianLinen, 'modPencucianLinenDetail' => $modPencucianLinen, 'modPencucianBahan' => $modPencucianBahan, 'modInfoPencucian' => $modInfoPencucian)); ?>
    </div>
</div>