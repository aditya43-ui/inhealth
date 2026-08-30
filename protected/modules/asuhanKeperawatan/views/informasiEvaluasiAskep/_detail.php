<style>
    legend {
        margin-bottom: 10px;
    }
</style>

<table style="width: 100%; border: none;">
    <tr>
        <td style="width: 13%;">
            <p>No. Evaluasi</p>
        </td>
        <td style="width: 20%;">
            <p>: <?php echo isset($model->no_evaluasi) ? $model->no_evaluasi : "-"; ?></p>
        </td>
        <td style="width: 13%;">
            <p>Tgl. Evaluasi</p>
        </td>
        <td style="width: 20%;">
            <p>: <?php echo isset($model->evaluasiaskep_tgl) ? MyFormatter::FormatDateTimeForUser($model->evaluasiaskep_tgl) : "-"; ?></p>
        </td>
        <td style="width: 13%;">
            <p>Nama Perawat</p>
        </td>
        <td style="width: 20%;">
            <p>: <?php echo isset($model->nama_pegawai) ? $model->nama_pegawai : "-"; ?></p>
        </td>
    </tr>
</table>

<fieldset class="box">
    <legend class="rim">Data Implementasi</legend>
    <table style="width: 100%; border: none;">
        <tr>
            <td style="width: 13%;">
                <p>No. Implementasi</p>
            </td>
            <td style="width: 20%;">
                <p>: <?php echo isset($modImpl->no_implementasi) ? $modImpl->no_implementasi : "-"; ?></p>
            </td>
            <td style="width: 13%;">
                <p>Tgl. Implementasi</p>
            </td>
            <td style="width: 20%;">
                <p>: <?php echo isset($modImpl->implementasiaskep_tgl) ? MyFormatter::FormatDateTimeForUser($modImpl->implementasiaskep_tgl) : "-"; ?></p>
            </td>
            <td style="width: 13%;">
                <p>Nama Perawat</p>
            </td>
            <td style="width: 20%;">
                <p>: <?php echo isset($modImpl->nama_pegawai) ? $modImpl->nama_pegawai : "-"; ?></p>
            </td>
        </tr>
    </table>
</fieldset>

<fieldset class="box">
    <legend class="rim">Identitas Pasien</legend>
    <table style="width: 100%; border: none;">
        <tr>
            <td style="width: 13%;">
                <p>No. Pendaftaran</p>
            </td>
            <td style="width: 20%;">
                <p>: <?php echo isset($modPendaftaran->no_pendaftaran) ? $modPendaftaran->no_pendaftaran : "-"; ?></p>
            </td>
            <td style="width: 13%;">
                <p>Nama Pasien</p>
            </td>
            <td style="width: 20%;">
                <p>: <?php echo isset($modPasien->nama_pasien) ? $modPasien->nama_pasien : "-"; ?></p>
            </td>
            <td style="width: 13%;">
                <p>Ruangan</p>
            </td>
            <td style="width: 20%;">
                <p>: <?php echo isset($model->ruangan_nama) ? $model->ruangan_nama : "-" ?></p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Tgl. Pendaftaran</p>
            </td>
            <td>
                <p>: <?php echo isset($modPendaftaran->tgl_pendaftaran) ? MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran) : "-"; ?></p>
            </td>
            <td>
                <p>Umur</p>
            </td>
            <td>
                <p>: <?php echo isset($modPendaftaran->umur) ? $modPendaftaran->umur : "-"; ?></p>
            </td>
            <td>
                <p>Kelas</p>
            </td>
            <td>
                <p>: <?php echo (isset($model->kelaspelayanan_nama) ? $model->kelaspelayanan_nama : $model->getKelasPelayanan($modPendaftaran->pendaftaran_id)) ?></p>
            </td>
        </tr>
        <tr>
            <td>
                <p>No. Rekam Medik</p>
            </td>
            <td>
                <p>: <?php echo isset($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : "-"; ?></p>
            </td>
            <td>
                <p>Diagnosa Medik</p>
            </td>
            <td>
                <p>: <?php echo (isset($modPendaftaran->diagnosa_nama) ? $modPendaftaran->diagnosa_nama : $model->getDiagnosaMedis($modPasien->pasien_id, $modPendaftaran->pendaftaran_id)); ?></p>
            </td>
            <td>
                <p>No. Kamar/Bed</p>
            </td>
            <td>
                <p>: <?php echo (isset($model->kamarruangan_nokamar) ? $model->kamarruangan_nokamar : $model->getNoKamar($modPendaftaran->pendaftaran_id)) . ' / ' . (isset($model->kamarruangan_nobed) ? $model->kamarruangan_nobed : $model->getNoBed($modPendaftaran->pendaftaran_id)); ?></p>
            </td>
        </tr>
    </table>
</fieldset>

<fieldset class="box">
    <legend class="rim">Evaluasi Keperawatan</legend>
    <?php
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'evaluasi-grid',
        'enableSorting' => false,
        'template' => "{items}",
        'dataProvider' => $modDetail,
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Diagnosa Keperawatan',
                'name' => 'diagnosakep_nama',
                'type' => 'raw',
                'value' => '$data->diagnosakep->diagnosakep_nama'
            ),
            array(
                'header' => 'Subjektif',
                'name' => 'evaluasiaskepdet_subjektif',
                'type' => 'raw',
                'value' => '$data->evaluasiaskepdet_subjektif'
            ),
            array(
                'header' => 'Objektif',
                'name' => 'evaluasiaskepdet_objektif',
                'type' => 'raw',
                'value' => '$data->evaluasiaskepdet_objektif'
            ),
            array(
                'header' => 'Assessment',
                'name' => 'evaluasiaskepdet_assessment',
                'type' => 'raw',
                'value' => '$data->evaluasiaskepdet_assessment'
            ),
            array(
                'header' => 'Planning',
                'name' => 'evaluasiaskepdet_planning',
                'type' => 'raw',
                'value' => '$data->evaluasiaskepdet_planning'
            ),
            array(
                'header' => 'Hasil',
                'name' => 'evaluasiaskepdet_hasil',
                'type' => 'raw',
                'value' => '$data->evaluasiaskepdet_hasil'
            )
        ),
        'afterAjaxUpdate' => 'function(id, data){
                jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                $("table").find("input[type=text]").each(function(){
                    cekForm(this);
                })
                 $("table").find("select").each(function(){
                    cekForm(this);
                })
            }',
    ));
    ?>
</fieldset>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
    ?>
    <?php
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printDetail');
    $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

    $js = <<< JSCRIPT

function print(caraPrint)
{
    window.open("${urlPrint}/&evaluasiaskep_id="+$model->evaluasiaskep_id+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?>
</div>