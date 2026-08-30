<?php $linkHalaman = CustomFunction::getUrlByMenuID(2516); ?>
<?php
$this->breadcrumbs = array(
    'Transaksi Perawatan Linen',
);
?>
<style type="text/css">
    .checkbox {
        display: inline;
        padding-left: 5px;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-hands-wash"></i> Transaksi <b>Perawatan Linen</b>
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
            $('#penerimaanlinendetail-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('penerimaanlinendetail-grid', {
                data: $(this).serialize()
            });
            return false;
        });
        ");
        ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash("success", "Data perawatan linen berhasil disimpan!");
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
                <?php $this->renderPartial($this->path_view . '_pencarianPenerimaan', array('modPenerimaanLinen' => $modPenerimaanLinen, 'modPenerimaanLinenDetail' => $modPenerimaanLinenDetail, 'instalasiTujuans' => $instalasiTujuans, 'ruanganTujuans' => $ruanganTujuans)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Data <b>Linen</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'perawatanlinen-t-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onSubmit' => 'return requiredCheck(this);', 'onkeyup' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '', 'onclick' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : ''),
                ));
                ?>
                <?php echo $this->renderPartial($this->path_view . '_rowPenerimaanLinen', array('modPenerimaanLinen' => $modPenerimaanLinen, 'modPenerimaanLinenDetail' => $modPenerimaanLinenDetail)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Perawatan</b>
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . '_form', array('form' => $form, 'modPerawatanLinen' => $modPerawatanLinen, 'instalasiTujuans' => $instalasiTujuans, 'ruanganTujuans' => $ruanganTujuans)); ?>
            </div>
        </div>
        <div class="perawatanLinenCentang" id="form-bahanmakan" style="margin-top: 17px;">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="glyphicon glyphicon-file"></i> Bahan yang Digunakan untuk Perawatan
                    </div>
                </div>
                <div class="panel-body">
                    <?php echo $this->renderPartial($this->path_view . '_formPilihBahan', array('form' => $form, 'modPerawatanLinen' => $modPerawatanLinen, 'instalasiTujuans' => $instalasiTujuans, 'ruanganTujuans' => $ruanganTujuans)); ?>
                    <br>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="entypo-credit-card"></i> Tabel <b>Bahan Perawatan</b>
                            </div>
                        </div>
                        <div class="panel-body table-responsive">
                            <table class="items table table-striped table-condensed table-bordered" id="table-detailbahan">
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
                                    if (count((array)$modPerawatanBahan) > 0) {
                                        foreach ($modPerawatanBahan as $i => $modDetail) {
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
            if (isset($_GET['perawatanlinen_id'])) {
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
                echo CHtml::link(
                    Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
                    'javascript:void(0);',
                    array('class' => 'btn btn-info', 'onclick' => "print('PRINT');return false", 'disabled' => FALSE)
                );
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
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modPenerimaanLinen' => $modPenerimaanLinen, 'modPerawatanLinen' => $modPerawatanLinen, 'modPerawatanLinenDetail' => $modPerawatanLinenDetail)); ?>
    </div>
</div>