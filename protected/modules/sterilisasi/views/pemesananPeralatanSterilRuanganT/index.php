<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class='fas fa-toolbox'></i> Transaksi <b>Pemesanan Peralatan Steril</b>
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
            'Transaksi Pemesanan Peralatan Steril Ruangan',
        );
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php
        if (!empty($_GET['sukses'])) {
        ?>
            <?php
            echo Yii::app()->user->setFlash('success', "Data Pemesanan Peralatan Steril berhasil disimpan!");
            $this->widget('bootstrap.widgets.BootAlert');
            ?>
        <?php } ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'cspesanperalatansteril-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#' . CHtml::activeId($model, 'pesanperlinensteril_ket'),
        ));
        ?>
        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <?php echo $form->errorSummary($model); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class='far fa-file-alt'></i> Data <b>Pemesanan</b>
                </div>
            </div>
            <div class="panel-body">
                <?php
                echo $this->renderPartial($this->path_view . '_formPemesanan', array(
                    'model' => $model, 'form' => $form, 'format' => $format, 'ruangan_id' => $ruangan_id, 'ruangan_cssd' => $ruangan_cssd
                ));
                ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class='fas fa-tools'></i> Detail <b>Peralatan dan Linen</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_formPeralatan', array('model' => $model, 'form' => $form,)); ?>
                <div class="overflow-x">
                    <table class="table table-striped table-condensed table-bordered" id="table-linen">
                        <thead>
                            <tr>
                                <th>No. </th>
                                <th>Nama Peralatan dan Linen</th>
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
                array('onclick' => 'cekTabel();', 'class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'title' => 'Simpan', 'type' => 'button', 'disabled' => (isset($_GET['sukses'])) ? true : false)
            ); ?>
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index') . '";}); return false;'
                )
            );
            ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')", 'disabled' => $disablePrint)); ?>
            <?php
            $content = $this->renderPartial($this->path_view . 'tips/transaksi1', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model)); ?>