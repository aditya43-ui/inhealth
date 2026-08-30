<style>
    .uang {
        text-align: right !important;
    }
</style>

<?php
echo $this->renderPartial('application.views.headerReport.headerAnggaran', array('judulLaporan' => $judulLaporan, 'deskripsi' => $deskripsi, 'colspan' => 10));

$sukses = null;
if (isset($_GET['sukses'])) {
    $sukses = $_GET['sukses'];
}
if ($sukses > 0) {
    Yii::app()->user->setFlash('success', "Status Mengetahui berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="col-sm-12">
    <table bgcolor='white' class='table' style="box-shadow:none;">
        <tr bgcolor='white'>
            <td>
                <b><?php echo CHtml::encode($modelpegawai->getAttributeLabel('nomorindukpegawai')); ?></b>
            </td>
            <td>
                : <?php echo CHtml::encode($modelpegawai->nomorindukpegawai); ?>
            </td>
            <td>
                <b><?php echo CHtml::encode($modelpegawai->getAttributeLabel('nama_pegawai')); ?></b>
            </td>
            <td>: <?php echo CHtml::encode($modelpegawai->nama_pegawai); ?></td>
            <td>
                <b><?php echo CHtml::encode($modelpegawai->getAttributeLabel('tempatlahir_pegawai')); ?></b>
            </td>
            <td>: <?php echo CHtml::encode($modelpegawai->tempatlahir_pegawai); ?></td>
        </tr>
        <tr>
            <td>
                <b><?php echo CHtml::encode($modelpegawai->getAttributeLabel('tgl_lahirpegawai')); ?></b>
            </td>
            <td>
                : <?php echo !empty($modelpegawai->tgl_lahirpegawai) ? MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($modelpegawai->tgl_lahirpegawai)))) : "-" ?>
            </td>
            <td>
                <b><?php echo CHtml::encode($modelpegawai->getAttributeLabel('jeniskelamin')); ?></b>
            </td>
            <td>: <?php echo CHtml::encode($modelpegawai->jeniskelamin); ?></td>
            <td>
                <b><?php echo CHtml::encode("Jabatan"); ?></b>
            </td>
            <td>: <?php echo CHtml::encode($modelpegawai->jabatan_nama); ?></td>

        </tr>
        <tr>
            <td>
                <b><?php echo CHtml::encode("No Rekening"); ?></b>
            </td>
            <td>
                : <?php echo CHtml::encode($modelpegawai->norekening); ?> <?php echo CHtml::encode($modelpegawai->banknorekening); ?>
            </td>
            <td>
                <b><?php echo CHtml::encode($modelpegawai->getAttributeLabel('npwp')); ?></b>
            </td>
            <td>: <?php echo CHtml::encode($modelpegawai->npwp); ?></td>
            <td>
                <b><?php echo CHtml::encode($modelpegawai->getAttributeLabel('notelp_pegawai')); ?></b>
            </td>
            <td>: <?php echo CHtml::encode($modelpegawai->notelp_pegawai); ?> <?php echo CHtml::encode($modelpegawai->nomobile_pegawai); ?></td>
        </tr>
        <tr>
            <td>
                <b><?php echo CHtml::encode($modelpegawai->getAttributeLabel('agama')); ?></b>
            </td>
            <td>: <?php echo CHtml::encode($modelpegawai->agama); ?></td>
            <td>
                <b><?php echo CHtml::encode($modelpegawai->getAttributeLabel('alamat_pegawai')); ?></b>
            </td>
            <td>: <?php echo CHtml::encode($modelpegawai->alamat_pegawai); ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>

    <div class="col-sm-6">
        <table bgcolor='white' class='table' style="box-shadow:none;">
            <tr bgcolor='white'>
                <td>
                    <b><?php echo CHtml::encode($model->getAttributeLabel('tglpenggajian')); ?></b>
                </td>
                <td>
                    : <?php echo !empty($model->tglpenggajian) ? MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($model->tglpenggajian)))) : "-" ?>
                </td>
            </tr>
            <tr>
                <td>
                    <b><?php echo CHtml::encode($model->getAttributeLabel('nopenggajian')); ?></b>
                </td>
                <td>: <?php echo CHtml::encode($model->nopenggajian); ?></td>
            </tr>
            <tr>
                <td>
                    <b><?php echo CHtml::encode($model->getAttributeLabel('keterangan')); ?></b>
                </td>
                <td>: <?php echo CHtml::encode($model->keterangan); ?></td>
            </tr>
            <tr>
                <td>
                    <b><?php echo CHtml::encode($model->getAttributeLabel('totalpajak')); ?></b>
                </td>
                <td>: <?php echo CHtml::encode($model->totalpajak); ?></td>
            </tr>
            <tr>
                <td>
                    <b><?php echo CHtml::encode($model->getAttributeLabel('penerimaanbersih')); ?></b>
                </td>
                <td>: <?php echo CHtml::encode($model->penerimaanbersih); ?></td>
            </tr>
        </table>
    </div>
    <div class="col-sm-6">
        <table id="tableObatAlkes" class="table border" bgcolor='white'>
            <thead>
                <th>Deskripsi</th>
                <th>Gaji</th>
                <th>Potongan</th>
            </thead>
            <tbody>
                <?php foreach ($kom as $item) :
                    $komdat = KomponengajiM::model()->findByPk($item->komponengaji_id);

                ?>
                    <tr bgcolor='white'>
                        <td bgcolor='white'><?php echo $komdat->komponengaji_nama; ?></td>
                        <td bgcolor='white' style="text-align: right;"><?php if (!$komdat->ispotongan) echo MyFormatter::formatNumberForPrint($item->jumlah); ?></td>
                        <td bgcolor='white' style="text-align: right;"><?php if ($komdat->ispotongan) echo MyFormatter::formatNumberForPrint($item->jumlah); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th style="text-align: right">
                        Total
                    </th>
                    <th>
                        <?php echo CHtml::encode($model->totalterima); ?>
                    </th>
                    <th>
                        <?php echo CHtml::encode($model->totalpotongan); ?>
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="clear"></div>

    <div class="col-sm-4" style="text-align:center;">
        <?php
        if (isset($_GET['sukses'])) {
            echo "<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>";
            echo "Mengetahui (RS),";
        } else {
            echo "<div class='<div class='control-group' style='margin-bottom: 50px;'>";
            if ($model->mengetahui_id == Yii::app()->user->getState('pegawai_id')) {
                echo CHtml::link(
                    Yii::t('mds', ' Mengetahui (RS)'),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'class' => 'btn btn-danger',
                        'style' => 'color: #fff !important;',
                        'onclick' => 'myConfirm("Apakah Anda yakin?","Perhatian!",
                                            function(r) {if(r) window.location = "' . $this->createUrl('ApproveMengetahui', array('penggajianpeg_id' => $model->penggajianpeg_id, 'approve' => true)) . '";} ); return false;'
                    )
                );
            } else {
                echo CHtml::link(
                    Yii::t('mds', ' Mengetahui (RS)'),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'class' => 'btn btn-danger',
                        'onclick' => 'myAlert("Maaf, Anda tidak berhak Mengapprove Pegawai Mengetahui Pengajuan Gaji ini?"); return false;'
                    )
                );
            }
        }
        ?>
    </div>
    <div class="control-group">
        ( <?php echo $model->mengetahui; ?> )
    </div>

    <div class="clear"></div>

    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
    $urlPrint = $this->createUrl('printApproveMengetahui', array('penggajianpeg_id' => $model->penggajianpeg_id));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);
    $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?>
</div>