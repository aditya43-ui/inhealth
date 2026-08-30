<?php $linkHalaman = CustomFunction::getUrlByMenuID(1374); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class='fas fa-burn'></i> Transaksi <b>Pemusnahan Obat dan Alkes</b>
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
            'Pemusnahan Obat Alkes'
        );
        ?>
        <?php
        if (isset($_GET['sukses'])) {
            if ($_GET['sukses'] == 1) {
                Yii::app()->user->setFlash("success", "Data pemusnahan obat alkes " . $model->nopemusnahan . " berhasil disimpan!");
            } else {
                Yii::app()->user->setFlash("warning", "Terdapat obat yang dibatalkan silakan cek kembali!");
            }
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'gfpemusnahanobatalkes-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#' . CHtml::activeId($model, 'instalasiasal_id'),
        )); ?>
        <?php echo $this->renderPartial($this->path_view . '_form', array('form' => $form, 'model' => $model, 'instalasiAsals' => $instalasiAsals, 'ruanganAsals' => $ruanganAsals)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-pills"></i> Obat dan Alkes
                </div>
            </div>
            <div class="panel-body" id="form-tambahobatalkes">
                <?php if (!isset($_GET['sukses'])) { ?>
                    <!--fieldset class="box" id="form-tambahobatalkes"-->
                    <div class="row">
                        <?php
                        if (!isset($_GET['sukses'])) {
                            $this->renderPartial($this->path_view . '_formPilihObat', array('model' => $model));
                        }
                        ?>
                    </div>
                <?php } ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Obat Alkes</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="items table table-bordered table-striped table-condensed" id="table-pemusnahandetail">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Ruangan Asal</th>
                                    <th>Kategori / Nama Obat</th>
                                    <th>No. Batch</th>
                                    <th>Tanggal Kedaluwarsa </th>
                                    <th>Satuan Kecil </th>
                                    <th>Jumlah Stok</th>
                                    <th>Jumlah Pemusnahan</th>
                                    <th>Kondisi Obat</th>
                                    <th>HPP</th>
                                    <th>Harga Jual</th>
                                    <th>Subtotal</th>
                                    <th>Batal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count((array)$modDetails) > 0) {
                                    foreach ($modDetails as $i => $modPemusnahanDetail) {
                                        echo $this->renderPartial($this->path_view . '_rowPemusnahanDetail', array('modPemusnahanDetail' => $modPemusnahanDetail, 'pesan' => $pesan), true);
                                    }
                                }
                                ?>
                            <tfoot>
                                <tr>
                                    <td colspan="11">
                                        <?php
                                        if (count((array)$modDetails) > 0) {
                                            echo "Total";
                                        } else {
                                            echo "<div style=\"color:#FF0000;font-weight:bold;\">" . $pesan . "</div>";
                                        }; ?>
                                    </td>
                                    <td><?php echo CHtml::textField('total', 0, array('class' => 'span2 integer2', 'style' => 'width:90px;text-align:right;')); ?></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                            </tbody>
                        </table>
                        <!--</fieldset>-->
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php
            if (isset($_GET['pemusnahanobatalkes_id'])) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'disabled' => true, 'style' => 'cursor:not-allowed;')
                );
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT');return false", 'disabled' => FALSE));
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                );
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => TRUE, 'style' => 'cursor:not-allowed;'));
            }
            ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);'
                )
            ); ?>
            <?php
            $content = $this->renderPartial($this->path_view . 'tips/tipsPemusnahanObatAlkes', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model)); ?>