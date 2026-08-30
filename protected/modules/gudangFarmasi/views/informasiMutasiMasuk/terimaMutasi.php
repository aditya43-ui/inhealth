<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Mutasi Obat Alkes</b>
        </div>
    </div>
    <div class="panel-body">
        <?php

        $menuArr = array();
        if (isset($_GET['mutasioaruangan_id'])) {
            $arrMenu['Informasi Mutasi Obat Alkes Masuk'] = $this->getReferrer();
        }

        $arrMenu[] = "Terima Mutasi Obat Alkes";

        $this->breadcrumbs = $arrMenu;
        ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash("success", "Data terima mutasi obat alkes berhasil disimpan!");
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'terimamutasiobat-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#' . CHtml::activeId($model, 'instalasitujuan_id'),
        )); ?>

        <?php echo $this->renderPartial($this->path_view . '_form', array('form' => $form, 'model' => $model, 'instalasiTujuans' => $instalasiTujuans, 'ruanganTujuans' => $ruanganTujuans, 'modMutasiRuangan' => $modMutasiRuangan)); ?>

        <?php if (!isset($_GET['sukses']) && (!isset($_GET['mutasioaruangan_id']))) { ?>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class='fas fa-tablets'></i> Obat dan Alkes
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row box">
                        <?php
                        if (!isset($_GET['sukses'])) {
                            $this->renderPartial($this->path_view . '_formPilihObat');
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Obat dan Alkes</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <table class="items table table-striped table-bordered table-condensed" id="table-mutasidetail">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Asal Barang</th>
                            <th>Kategori / Nama Obat</th>
                            <th>Tanggal Kedaluwarsa </th>
                            <th hidden>Satuan Kecil </th>
                            <th>Jumlah Mutasi</th>
                            <th>Jumlah Terima</th>
                            <th>HPP</th>
                            <th>Harga Jual</th>
                            <th>Sub Total Netto</th>
                            <th>Batal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count((array)$modDetails) > 0) {
                            foreach ($modDetails as $i => $modMutasiDetail) {
                                echo $this->renderPartial($this->path_view . '_rowMutasiDetail', array('modMutasiDetail' => $modMutasiDetail));
                            }
                        }
                        ?>
                    <tfoot>
                        <tr>
                            <td colspan="8" style="text-align:right;">Total</td>
                            <td><?php echo CHtml::textField('total', 0, array('readonly' => true, 'class' => 'span2 integer2', 'style' => 'width:80px;')); ?></td>
                            <td></td>
                        </tr>
                    </tfoot>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="form-actions">
            <?php
            if (isset($_GET['terimamutasi_id'])) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')", 'disabled' => FALSE));
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => TRUE, 'style' => 'cursor:not-allowed;'));
            }
            ?>
            <?php

            if (!$this->getReferrer()) {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index&mutasioaruangan_id=' . $_GET['mutasioaruangan_id']),
                    array(
                        'class' => 'btn btn-default',
                        'onclick' => 'return refreshForm(this);'
                    )
                );
            } else {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="entypo-back"></i>')),
                    // $this->createUrl($this->id.'/'.$this->action->id.'&pendaftaran_id='.$_GET['pendaftaran_id'].'&pasienadmisi_id='.$_GET['pasienadmisi_id']), 
                    $this->getReferrer(),
                    array('class' => 'btn btn-danger')
                );
            }
            ?>

            <?php
            $content = $this->renderPartial($this->path_view . 'tips/tipsTerimaMutasiObatAlkes', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>

        <?php $this->endWidget(); ?>

    </div>
</div>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modMutasiRuangan' => $modMutasiRuangan)); ?>