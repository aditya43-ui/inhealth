<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-truck-loading"></i> Transaksi <b>Penerimaan Peralatan Steril</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
        $('#pencarian-form').submit(function(){
            $('#table-peralatansteril').addClass('animation-loading');
            $.fn.yiiGridView.update('table-peralatansteril', {
                data: $(this).serialize()
            });
            return false;
        });
        ");
        ?>
        <?php
        $this->breadcrumbs = array(
            'Informasi Pengajuan Sterilisasi' => Yii::app()->request->getUrlReferrer(),
            'Create',
        );
        if (!empty($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data  " . $model->penerimaansterilisasi_no . " berhasil disimpan!");
        }

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php if (isset($_GET['pengajuansterlilisasi_id'])) { ?>
                        <i class="glyphicon glyphicon-file"></i> Data <b>Pengajuan Sterilisasi</b>
                    <?php } else { ?>
                        <i class="entypo-search"></i> Data <b>Pencarian</b>
                    <?php } ?>
                </div>
            </div>
            <div class="panel-body">
                <?php
                if (isset($_GET['pengajuansterlilisasi_id'])) {
                    echo $this->renderPartial($this->path_view . '_formPencarianDisable', array(
                        'modCari' => $modCari
                    ));
                } else {
                    echo $this->renderPartial($this->path_view . '_formPencarian', array(
                        'modCari' => $modCari
                    ));
                }
                ?>
            </div>
        </div>
        <?php
        if (!empty($_GET['sukses'])) {
        ?>
            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php } ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'cspenerimaanperalatansteril-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            //'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onkeyup'=>(!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '','onclick'=>(!isset($_GET['sukses']))? 'cekDisabled(this);' : ''),
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
            'focus' => '#' . CHtml::activeId($model, 'penerimaansterilisasi_ket'),
        )); ?>

        <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->

        <?php echo $form->errorSummary($model); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Peralatan dan Linen</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial($this->path_view . '_tabelPengajuan', array('modPengDetails' => $modPengDetails)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Penerimaan</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_formPenerimaan', array('model' => $model, 'form' => $form, 'format' => $format)); ?>
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
                array('title' => 'Simpan', 'class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'onclick' => 'cekTabel();', 'type' => 'button', 'disabled' => (isset($_GET['sukses'])) ? true : false)
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl('index'),
                array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'if(!confirm("' . Yii::t('mds', 'Apakah Anda akan mengulang input data ?') . '")) return false;')
            ); ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')", 'disabled' => $disablePrint)); ?>
            <?php $content = $this->renderPartial($this->path_view . 'tips/transaksi1', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('modCari' => $modCari)); ?>