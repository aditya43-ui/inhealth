<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-shopping-cart"></i> Transaksi <b>Pengajuan Perawatan Linen</b>
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
            'Transaksi Pengajuan Perawatan',
        );
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php
        if (!empty($_GET['sukses'])) {
        ?>
            <?php echo Yii::app()->user->setFlash('success', "Data Pengajuan Perawatan " . $model->pengperawatanlinen_no . " berhasil disimpan!");
            $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php } ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'lapengajuanperawatan-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'unformatNumbers(); '),
            'focus' => '#',
        )); ?>
        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <?php echo $form->errorSummary($model); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="far fa-file-alt"></i> Data <b>Pengajuan Perawatan Linen</b>
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . '_formPengajuan', array(
                    'model' => $model, 'form' => $form, 'format' => $format
                )); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-scroll"></i> Linen
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_formLinen', array('model' => $model, 'form' => $form,)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Linen</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <table class="table table-striped table-condensed" id="table-linen">
                    <thead>
                        <tr>
                            <th>No. </th>
                            <th>No. Register Linen</th>
                            <th>Nama Linen</th>
                            <th>Nama Barang</th>
                            <th>Jenis Perawatan</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>Batal</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="form-actions">
            <?php
            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
            $disableSave = false;
            $disableSave = (!empty($_GET['id'])) ? true : (($sukses > 0) ? true : false);
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'submit', 'disabled' => (isset($_GET['sukses'])) ? true : false)
            ); ?>
            <?php
            echo CHtml::link(
                Yii::t(
                    'mds',
                    '{icon} Reset',
                    array('{icon}' => '<i class="entypo-arrows-ccw"></i>')
                ),
                Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                array(
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            );
            ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')", 'disabled' => $disablePrint)); ?>
            <?php $content = $this->renderPartial($this->path_view . 'tips/transaksi1', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model)); ?>
<?php
Yii::app()->clientScript->registerScript('onready', '
	$("form").submit(function(){
		pesan = false;
        if ($(".cancel").length < 1){
            myAlert("Data Line Harus Diisi");
            noregisterlinen.focus();
            return false;
        }
    }
);
', CClientScript::POS_READY); ?>