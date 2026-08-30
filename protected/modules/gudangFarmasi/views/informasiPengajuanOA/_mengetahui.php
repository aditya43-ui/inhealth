<style>
    body {
        color: black;
    }

    .border th,
    .border td {
        border: 1px solid #000;
        padding: 2px;
    }


    .table thead:first-child {
        border-top: 1px solid #000;
    }

    thead th {
        background: none;
        color: #333;
    }

    .table tbody tr:hover td,
    .table tbody tr:hover th {
        background-color: none;
    }

    .text-center {
        text-align: center !important;
    }
</style>
<?php
$hiddenData = "";
if (isset($_GET['sukses'])) {
    $hiddenData = "hidden";
    Yii::app()->user->setFlash('success', "Berhasil di Approve Oleh Manager Keuangan!");
}

$this->widget('bootstrap.widgets.BootAlert');
$model->tglpengajuanhargaoa = MyFormatter::formatDateTimeForUser($model->tglpengajuanhargaoa);
$model->pegawai_nama = $model->pegawai->namaLengkap;
?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'aprovalpengajuanharga-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
)); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Pengajuan Perubahan Harga</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <?php echo $form->hiddenField($model, 'pengajuanhargaoa_id', array()); ?>
                <?php echo $form->textFieldRow($model, 'nopengajuanhargaoa', array('readonly' => true, 'class' => 'span3')); ?>
                <?php echo $form->textFieldRow($model, 'tglpengajuanhargaoa', array('readonly' => true, 'class' => 'span3')); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'pegawai_nama', array('readonly' => true, 'class' => 'span3')); ?>
                <?php echo $form->textAreaRow($model, 'ketpengajuan', array('readonly' => true, 'rows' => 3, 'cols' => 50, 'class' => 'span3')); ?>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Perubahan Harga</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table width="100%" style='margin-left:auto; margin-right:auto;' class="items table table-bordered table-striped table-condensed">
            <thead>
                <tr>
                    <th <?php echo $hiddenData; ?> rowspan="2" style="text-align: center">Pilih</th>
                    <th rowspan="2" style="text-align: center">No.</th>
                    <th rowspan="2" style="text-align: center">Jenis</th>
                    <th rowspan="2" style="text-align: center">Nama Obat</th>
                    <th rowspan="2" style="text-align: center">Satuan</th>
                    <th colspan="6" style="text-align: center">Lama</th>
                    <th colspan="6" style="text-align: center">Baru</th>
                    <th rowspan="2" style="text-align: center">Alasan Perubahan</th>
                </tr>
                <tr>
                    <th style="text-align: center">Harga Netto</th>
                    <th style="text-align: center">Keringanan</th>
                    <th style="text-align: center">PPN</th>
                    <th style="text-align: center">HPP</th>
                    <th style="text-align: center">Margin (%)</th>
                    <th style="text-align: center">Harga Jual</th>

                    <th style="text-align: center">Harga Netto</th>
                    <th style="text-align: center">Keringanan</th>
                    <th style="text-align: center">PPN</th>
                    <th style="text-align: center">HPP</th>
                    <th style="text-align: center">Margin (%)</th>
                    <th style="text-align: center">Harga Jual</th>
                </tr>
            </thead>
            <?php
            foreach ($modDetails as $i => $modObat) {
                $satuanobat = "";
                if (!empty($modObat->satuanbesar_id)) {
                    $besar = SatuanbesarM::model()->findByPk($modObat->satuanbesar_id);
                    $satuanobat = $besar->satuanbesar_nama;
                } else if (!empty($modObat->satuankecil_id)) {
                    $kecil = SatuankecilM::model()->findByPk($modObat->satuankecil_id);
                    $satuanobat = $kecil->satuankecil_nama;
                }
            ?>
                <tr class="border">
                    <td <?php echo $hiddenData; ?> style="text-align: center">
                        <?php echo CHtml::activeHiddenField($modObat, '[' . $i . ']penghargaoadetail_id', array()); ?>
                        <?php echo CHtml::activeCheckBox($modObat, '[' . $i . ']checklist', array('class' => 'checklist')); ?>
                    </td>
                    <td><?php echo ($i + 1) . "."; ?></td>
                    <td><?php echo (isset($modObat->obatalkes->jenisobatalkes) ? $modObat->obatalkes->jenisobatalkes->jenisobatalkes_nama : "-"); ?></td>
                    <td><?php echo $modObat->obatalkes->obatalkes_nama; ?></td>
                    <td><?php echo "1 " . $satuanobat; ?></td>
                    <td><?php echo "Rp " . MyFormatter::formatNumberForPrint($modObat->harganettolama); ?></td>
                    <td><?php echo "Rp " . MyFormatter::formatNumberForPrint($modObat->diskonlama); ?></td>
                    <td><?php echo "Rp " . MyFormatter::formatNumberForPrint($modObat->ppnlama); ?></td>
                    <td><?php echo "Rp " . MyFormatter::formatNumberForPrint($modObat->hpplama); ?></td>
                    <td><?php echo MyFormatter::formatNumberForPrint($modObat->marginlama) . "%"; ?></td>
                    <td><?php echo "Rp " . MyFormatter::formatNumberForPrint($modObat->hargajuallama); ?></td>
                    <td><?php echo "Rp " . MyFormatter::formatNumberForPrint($modObat->harganettobaru); ?></td>
                    <td><?php echo "Rp " . MyFormatter::formatNumberForPrint($modObat->diskonbaru); ?></td>
                    <td><?php echo "Rp " . MyFormatter::formatNumberForPrint($modObat->ppnbaru); ?></td>
                    <td><?php echo "Rp " . MyFormatter::formatNumberForPrint($modObat->hppbaru); ?></td>
                    <td><?php echo MyFormatter::formatNumberForPrint($modObat->marginbaru) . "%"; ?></td>
                    <td><?php echo "Rp " . MyFormatter::formatNumberForPrint($modObat->hargajualbaru); ?></td>
                    <td><?php echo $modObat->alasanperubahan; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-sm-6" style="text-align:center;">
        <?php
        if (isset($_GET['sukses'])) {
            echo "<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>";
            echo "Mengetahui,<br> Manager Keuangan";
        } else {
            echo "<div class='<div class='control-group' style='margin-bottom: 50px;'>";
            echo CHtml::link(
                Yii::t('mds', ' Mengetahui'),
                $this->createUrl($this->id . '/index'),
                array(
                    'class' => 'btn btn-danger',
                    'onclick' => 'myConfirm("Apakah Anda yakin?","Perhatian!",
					function(r) {if(r) simpanApproval();} ); return false;'
                )
            );
        }
        ?>
    </div>
    <div class="control-group">
        ( <?php echo $model->pegawaimengetahui->NamaLengkap; ?> )
    </div>
</div>
<div class="col-sm-6" style="text-align:center;">
    <div class="control-group" style="margin-bottom: 57.5px;margin-top: 10px;">
    </div>
    <div class="control-group">
    </div>
</div>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function simpanApproval() {
        $('#aprovalpengajuanharga-t-form').submit();
    }
</script>