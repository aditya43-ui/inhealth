<?php

/**
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @website <piiindonesia.co.id>
 * 
 * Form Assessment Perawat Pasien.
 * 
 * - Panel PIE diambil dari Master masalahkeperawatan_m dan tindakankeperawatan_m
 * - Panel Pemberian Obat diambil dari Obat Alkes yang sudah ditransaksikan oleh Pasien sebelum Tindak Lanjut.
 *      + Kolom Diperiksa Oleh diambil dari Dokter Pemeriksa Pendaftaran.
 *      + Kolom Diberikan oleh diambil dari Pegawai Reseptur.
 * - Panel Pemberian Obat diambil dari Tindakan yang sudah ditransaksikan oleh Pasien sebelum Tindak Lanjut.
 * - Input tindak lanjut, diupdate ketika transaksi.
 * - Edukasi Kesehatan Pasien bersifat multiselect+filter.
 * 
 */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-multiselect/js/bootstrap-multiselect.js', CClientScript::POS_HEAD);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Asesmen Pasien
        </div>
    </div>
    <div class="panel-body">
        <?php

        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'asesmen-perawat-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)',
                'onsubmit' => 'return cekValidasi();'
            ),
        ));
        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Dokumentasi Keperawatan
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-condensed table-striped" width="100%">
                    <thead>
                        <tr>
                            <td>MASALAH KEPERAWATAN</td>
                            <td>TINDAKAN KEPERAWATAN</td>
                            <td>EVALUASI KEPERAWATAN</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $first = true;
                        foreach ($masalahKeperawatan as $item) : ?>
                            <tr>
                                <td>
                                    <?php
                                    foreach ($item['masalah'] as $masalah) {
                                        $checked = false;
                                        if (!empty($model->masalah)) {
                                            $checked = !empty($model->masalah[$masalah['masalahkeperawatan_id']]);
                                        }

                                        echo CHtml::checkbox('pie[masalah][' . $masalah['masalahkeperawatan_id'] . ']', $checked) .
                                            $masalah['masalahkeperawatan_nama'] . '<br>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    foreach ($item['tindakan'] as $tindakan) {
                                        $checked = false;
                                        if (!empty($model->tindakan)) {
                                            $checked = !empty($model->tindakan[$tindakan['tindakankeperawatan_id']]);
                                        }

                                        echo CHtml::checkbox('pie[tindakan][' . $tindakan['tindakankeperawatan_id'] . ']', $checked) .
                                            $tindakan['tindakankeperawatan_nama'] . '<br>';
                                    }
                                    ?>
                                </td>
                                <?php if ($first) :
                                    $first = false;
                                ?>
                                    <td rowspan="<?php echo count((array)$masalahKeperawatan); ?>">
                                        <b>Subjective</b>
                                        <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'evaluasiaskep_subjektif', 'toolbar' => 'mini', 'height' => '200px')) ?>
                                        <br>
                                        <b>Objective</b>
                                        <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'evaluasiaskep_objektif', 'toolbar' => 'mini', 'height' => '200px')) ?>
                                        <br>
                                        <b>Assessment</b>
                                        <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'evaluasiaskep_assessment', 'toolbar' => 'mini', 'height' => '200px')) ?>
                                        <br>
                                        <b>Planning</b>
                                        <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'evaluasiaskep_planning', 'toolbar' => 'mini', 'height' => '200px')) ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>



        <?php echo $this->renderPartial($this->path_view.'_terapi', array('pendaftaran' => $pendaftaran, 'terapi' => $terapi)); ?>
        <?php echo $this->renderPartial($this->path_view.'_tindakan', array('pendaftaran' => $pendaftaran, 'modTindakan' => $modTindakan)); ?>
        <?php echo $this->renderPartial($this->path_view.'_tindaklanjut', array('pendaftaran' => $pendaftaran, 'model' => $model)); ?>



        <div class="form-actions">
            <?php
            if ($model->isNewRecord) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'enabled' => true));
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false;", 'disabled' => 'true', 'style' => 'cursor:not-allowed;'));
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'onclick' => "", 'disabled' => false));
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printAsesmen();return false", 'enabled' => 'true'));
            }
            ?>
            <?php
            $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
            $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
            ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>

<?php echo $this->renderPartial($this->path_view.'_dialog', array(), true); ?>

<script>
    function cekValidasi() {
        if (periksaInputTerakhirTerapi()) {
            myAlert('Lengkapi isian yang kosong pada baris terapi sebelum submit.');
            return false;
        }

        if (periksaInputTerakhirTindakan()) {
            myAlert('Lengkapi isian yang kosong pada baris tindakan sebelum Anda menambahkan data baru.');
            return false;
        }

        return true;
    }

    jQuery("#edukasipasien").multiselect({
        includeSelectAllOption: true,
        buttonClass: "form-control",
        maxHeight: 300,
        buttonWidth: '182px',
        enableCaseInsensitiveFiltering: true
    }).hide();

    /**
     * print status
     */
    function printAsesmen() {
        window.open('<?php echo $this->createUrl('print', array('id' => $model->asesmenpasienigd_id)); ?>', 'printwin', 'left=100,top=100,width=793,height=1122,scrollbars=yes');
    }

    function removeRowTindakan(obj) {
        myConfirm("Anda yakin untuk menghapus baris ini?", "Peringatan", function(r) {
            if (r) {
                $(obj).parents("tr").remove();
            }
        });
    }
</script>