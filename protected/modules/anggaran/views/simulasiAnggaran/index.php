<div class="white-container">
    <legend class="rim2">Transaksi <b>Simulasi Anggaran Pengeluaran</b></legend>
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'simulasianggaran-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event); '), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
    )); ?>
    <?php
    if (isset($_GET['sukses'])) {
        Yii::app()->user->setFlash('success', "Data simulasi anggaran berhasil disimpan!");
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $form->errorSummary($model); ?>
    <?php if (!isset($_GET['sukses'])) { ?>
        <fieldset class="box">
            <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
            <?php $this->renderPartial('_formPencarian', array('form' => $form, 'model' => $model)); ?>
        </fieldset>
    <?php } ?>

    <div class="block-tabel">
        <h6>Tabel <b>Simulasi Anggaran Pengeluaran</b></h6>
        <div class="row">
            <table class="items table table-striped table-condensed" id="table-simulasianggaranpengeluaran">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Program Kerja</th>
                        <th>Nilai Anggaran (Rp)</th>
                        <th>Kenaikan (%)</th>
                        <th>Kenaikan (Rp)</th>
                        <th>Total Nilai Anggaran (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_GET['nosimulasianggaran'])) {
                        foreach ($model as $i => $val) {
                            $val->kenaikan_rupiah = MyFormatter::formatNumberForUser($val->kenaikan_rupiah);
                            $val->total_nilaianggaran = MyFormatter::formatNumberForUser($val->total_nilaianggaran);
                            echo $this->renderPartial('_rowDetailSaved', array('model' => $val, 'i' => $i), true);
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php if (!isset($_GET['sukses'])) { ?>
            <div class="row">
                <div class="control-group">
                    <?php echo CHtml::label('Kenaikan Keseluruhan', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::textField('kenaikan_keseluruhan', '', array('class' => 'integer', 'style' => 'width:30px;')); ?> % &nbsp; &nbsp;
                        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Hitung', array('{icon}' => '<i class="icon-play icon-white"></i>')), array('class' => 'btn btn-primary btn-mini', 'type' => 'button', 'id' => 'tombolhitung', 'onclick' => 'hitungsemua();', 'onkeypress' => 'hitungsemua();')); ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="form-actions">
        <?php if (!isset($_GET['sukses'])) { ?>
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'tombolSimpan();', 'onkeypress' => 'tombolSimpan();')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl('index'),
                array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'return refreshForm(this);')
            ); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => true, 'type' => 'button')); ?>
            <?php $content = $this->renderPartial('../tips/transaksi1', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
        <?php } else { ?>
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onkeypress' => 'verifikasi();', 'disabled' => true)
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl('index'),
                array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'return refreshForm(this);')
            ); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => false, 'type' => 'button', 'onclick' => 'print(\'PRINT\')')); ?>
            <?php $content = $this->renderPartial('../tips/transaksi1', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
        <?php } ?>
    </div>
</div>

<?php $this->endWidget(); ?>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>