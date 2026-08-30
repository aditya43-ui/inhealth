<style>
    .yellow td {
        background-color: yellow !important;
    }

    .integer-decimal-global{
        text-align: right;
    }
</style>

<?php
$this->breadcrumbs = array(
    'Mutasi Obat Alkes',
);

$arrMenu = array();
$this->menu = $arrMenu;
Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
                $('.search-form').toggle();				
                return false;
        });
        $('.search-form form').submit(function(){
                $.fn.yiiGridView.update('pemakaianbahp-form', {
                        data: $(this).serialize()
                });
                return false;
        });
    ");

if (isset($_GET['pesanobatalkes_id'])) {
    $arrMenu['Informasi Pemesanan Obat Alkes Masuk'] = $this->getReferrer();
}
$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class='fas fa-hand-holding-medical'></i> Mutasi <b>Obat Alkes</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        if (isset($_GET['sukses'])) {
            if ($_GET['sukses'] == 1) {
                Yii::app()->user->setFlash("success", "Data mutasi " . $model->nomutasioa . " berhasil disimpan!");
            } else {
                Yii::app()->user->setFlash("warning", "Terdapat obat yang dibatalkan silakan cek kembali!");
            }
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'gfmutasioaruangan-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#' . CHtml::activeId($model, 'instalasitujuan_id'),
        )); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <div class="search-form">
                    <?php echo $this->renderPartial($this->path_view . '_form', array('form' => $form, 'model' => $model, 'instalasiTujuans' => $instalasiTujuans, 'ruanganTujuans' => $ruanganTujuans, 'modPemesanan' => $modPemesanan)); ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class='fas fa-pills'></i> Detail <b>Obat dan Alkes</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="search-form">
                    <?php if (!isset($_GET['sukses'])) { ?>
                        <?php
                        if (!isset($_GET['sukses'])) {
                            $this->renderPartial($this->path_oa . '_formPilihObat', array('form' => $form, 'model' => $model));
                        }
                        ?>
                </div>
                <div class="panel panel-success" style="margin: 0 !important;">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Mutasi Obat dan Alkes</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="items table table-bordered table-striped datatable" id="table-mutasidetail">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th hidden>Asal Barang</th>
                                    <th>Kategori / Nama Obat</th>
                                    <th hidden>Tanggal Terima Gudang </th>
                                    <th>Tanggal Kedaluwarsa </th>
                                    <!--th>Satuan Kecil </th-->
                                    <th>Jumlah<br>Stok</th>
                                    <th>Jumlah<br>Pesan</th>
                                    <th>Jumlah<br>Mutasi</th>
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
                                        echo $this->renderPartial($this->path_view . '_rowMutasiDetail', array('modMutasiDetail' => $modMutasiDetail, 'pesan' => $pesan), true);
                                    }
                                }
                                ?>
                            <tfoot>
                                <tr>
                                    <td colspan="8">
                                        <?php if (count((array)$modDetails) > 0) {
                                            echo "Total";
                                        } else {
                                            echo "<div style=\"color:#FF0000;font-weight:bold;\">" . $pesan . "</div>";
                                        }; ?>
                                    </td>
                                    <td><?php echo CHtml::textField('total', 0, array('class' => 'span2 integer-decimal-global', 'style' => 'width:90px;', 'readonly' => true)) ?></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                            </tbody>
                        </table>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <?php
            if (isset($_GET['mutasioaruangan_id'])) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array(
                        'onclick' => 'cekValidasi();',
                        'class' => 'btn btn-default',
                        'title' => 'Simpan',
                        'type' => 'button',
                        'disabled' => true,
                        'style' => 'cursor:not-allowed;'
                    )
                );
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT');return false", 'disabled' => FALSE));
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array(
                        'onclick' => 'cekValidasi();',
                        'class' => 'btn btn-danger',
                        'title' => 'Simpan',
                        'type' => 'button',
                        'onKeypress' => 'return formSubmit(this,event)'
                    )
                );
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => TRUE, 'style' => 'cursor:not-allowed;'));
            }
            ?>
            <?php
            if (!$this->getReferrer()) {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'class' => 'btn btn-default',
                        'title' => 'Ulang',
                        //								'onclick'=>'if(!confirm("Apakah Anda ingin mengulang ini ?")) return false;'));
                        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index') . '";}); return false;'
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
            $content = $this->renderPartial($this->path_view . 'tips/tipsMutasiObatAlkes', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>

<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modelPesanObat' => $modelPesanObat)); ?>