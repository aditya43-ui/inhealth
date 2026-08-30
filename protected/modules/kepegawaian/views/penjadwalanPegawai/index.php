<?php $linkHalaman = CustomFunction::getUrlByMenuID(3353); ?>
<style>
    .red {
        background: #c11d03 !important;
        color: #fff !important;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Penjadwalan Pegawai</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Transaksi Penjadwalan Pegawai',
        );
        $sukses = null;
        if (isset($_GET['sukses'])) {
            $sukses = $_GET['sukses'];
        }
        if ($sukses > 0) {
            Yii::app()->user->setFlash('success', "Data Penjadwalan Pegawai " . $model->no_pembuatanjadwal . " berhasil disimpan!");
            $this->widget('bootstrap.widgets.BootAlert');
        }
        ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'kppenjadwalan-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#',
        )); ?>
        <?php echo $form->errorSummary($model); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Form <b>Tambah Penjadwalan</b>
                </div>
            </div>
            <div class="panel-body">
                <fieldset class="" id="datapenjadwalan">
                    <?php $this->renderPartial('_dataPenjadwalan', array('dis' => $dis, 'form' => $form, 'model' => $model, 'instalasiAsal' => $instalasiAsal, 'ruanganAsal' => $ruanganAsal)); ?>
                </fieldset>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Penjadwalan Pegawai</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('_shiftPegawaiBaru', array('form' => $form, 'model' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Form <b>Penjadwalan Pegawai</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_dataTambahan', array('form' => $form, 'model' => $model)); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'onclick' => 'cekValidasi(this);', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan')
            ); ?>
            <?php if (!isset($_GET['frame'])) {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'class' => 'btn btn-default',
                        'title' => 'Ulang',
                        'onclick' => 'return refreshForm(this);'
                    )
                );
            } ?>
            <?php
            $content = $this->renderPartial($this->path_view . '/tips', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modPenjadwalanDetail' => $modPenjadwalanDetail)); ?>