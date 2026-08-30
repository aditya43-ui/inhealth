<?php

/**
 * - digunakan sebagai Informasi Rincian Tagihan
 * @author : Elham Budianto
 * @email : elhambudianto1@gmail.com
 * @wiki : ..
 **/
?>

<?php

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rinciantagihan-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);', 'onclick' => 'cekDisabled(this);',),
    'focus' => '#',
));
?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Rincian <b> Tagihan Pasien</b></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Data <b>Rincian Tagihan</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="control-group">
                                    <?php echo CHtml::label("No Formulir Permintaan", 'no_kantongdarah', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php echo $form->textField($model, 'no_pendaftaran', array('readonly' => true, 'class' => 'span3')) ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("No Rekam Medik", 'no_kantongdarah', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php echo $form->textField($model, 'no_rekam_medik', array('readonly' => true, 'class' => 'span3')) ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("Tgl. Penyerahan", 'nama_jenis', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php echo $form->textField($modelPenyerahan, 'tglpenyerahan', array('readonly' => true, 'class' => 'span3')) ?>
                                    </div>
                                </div>
                                <!--<div class="control-group">
                                    <?php //echo CHtml::label("No Permintaan",'tglpencatatan', array('class' => 'control-label')) 
                                    ?>
                                    <div class="controls">
                                        <?php //echo $form->textField($model,'no_permintaandarah',array('readonly' => true, 'class'=>'span3')) 
                                        ?>
                                    </div>
                                </div>-->
                                <div class="control-group">
                                    <?php echo CHtml::label("No Penyerahan", 'tglpencatatan', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php echo Chtml::textField('no_penyerahan', '-', array('readonly' => true, 'class' => 'span3')) ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("Dokter Pelaksana", 'tglpencatatan', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php echo $form->textField($modelPermintaan, 'dokter_nama', array('readonly' => true, 'class' => 'span3')) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="control-group">
                                    <?php echo CHtml::label("No. Pendaftaran", 'gol_darah', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php echo $form->textField($model, 'no_pendaftaran', array('readonly' => true, 'class' => 'span3')) ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("Tgl. Pendaftaran", 'tglpencatatan', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php echo $form->textField($model, 'tgl_pendaftaran', array('readonly' => true, 'class' => 'span3')) ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("Nama Pasien", 'tglpencatatan', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php echo $form->textField($model, 'nama_pasien', array('readonly' => true, 'class' => 'span3')) ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("Ruang Rawat", 'tglpencatatan', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php echo $form->textField($modelRuangan, 'ruangan_nama', array('readonly' => true, 'class' => 'span3')) ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("Instalasi", 'tglpencatatan', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php echo $form->textField($modelInstalasi, 'instalasi_nama', array('readonly' => true, 'class' => 'span3')) ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label('Jenis Penjamin', 'tglpencatatan', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php echo $form->textField($modelCaraBayar, 'carabayar_nama', array('readonly' => true, 'class' => 'span3')) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <table width="100%" class="table table-bordered table-condensed" border="1px" style="text-align:center; font-weight: bold" id="table-laporan">
                                <thead>
                                    <tr>
                                        <td style="text-align:center;">No</td>
                                        <td style="text-align:center;">Jenis Komponen Darah</td>
                                        <td style="text-align:center;">Golongan Darah /Rhesus</td>
                                        <td style="text-align:center;">No Kantong</td>
                                        <td style="text-align:center;">Qty</td>
                                        <td style="text-align:center;">Tarif</td>
                                        <td style="text-align:center;">Total</td>
                                        <td style="text-align:center;">Status</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($modelDetail as $details) {
                                        $uji = UjikompatibilitasT::model()->findByAttributes(array('permintaandarahdet_id' => $details->permintaandarahdet_id));
                                        if (empty($uji)) {
                                            $singkatan_komp = $details->singkatan_komp;
                                            $golongan_darah = '-';
                                            $rhesus = '-';
                                            $nomorbarcode = '-';
                                        } else {
                                            $stok = StokkantongdarahT::model()->findByPk($uji->stokkantongdarah_id);
                                            $komponen = KomponendarahM::model()->findByPk($stok->komponendarah_id);
                                            if (!empty($komponen)) {
                                                $singkatan_komp = $komponen->singkatan_komp;
                                            } else {
                                                $singkatan_komp = '-';
                                            }
                                            if (!empty($stok->golongan_darah)) {
                                                $golongan_darah = $stok->golongan_darah;
                                            } else {
                                                $golongan_darah = '-';
                                            }
                                            if (!empty($stok->rhesus)) {
                                                $rhesus = $stok->rhesus;
                                            } else {
                                                $rhesus = '-';
                                            }
                                            if (!empty($uji->nomorbarcode)) {
                                                $nomorbarcode = $uji->nomorbarcode;
                                            } else {
                                                $nomorbarcode = '-';
                                            }
                                        }
                                    ?>
                                        <tr>
                                            <td style="text-align:center;"><?php echo $i++; ?></td>
                                            <td style="text-align:center;"><?php
                                                                            echo $singkatan_komp;
                                                                            ?></td>
                                            <td style="text-align:center;"><?php
                                                                            echo $golongan_darah . '/' . $rhesus; ?></td>
                                            <td style="text-align:center;">
                                                <?php
                                                echo $nomorbarcode;
                                                ?>
                                            </td>
                                            <td style="text-align:center;"><?php echo $details['jml_kantong']; ?></td>
                                            <td style="text-align:center;"><?php echo 'Rp' . number_format($details['tarif_satuan'], 2, ',', '.'); ?></td>
                                            <td style="text-align:center;"><?php echo 'Rp' . number_format($details['jml_kantong'] * $details['tarif_satuan'], 2, ',', '.'); ?></td>
                                            <td style="text-align:center;"><?php
                                                                            $tindakan = TindakanpelayananT::model()->findByPk($details['tindakanpelayanan_id']);
                                                                            if (!empty($tindakan)) {
                                                                                if ($tindakan->tindakansudahbayar_id != NULL) {
                                                                                    echo PARAMS::STATUSBAYAR_LUNAS;
                                                                                } else {
                                                                                    echo PARAMS::STATUSBAYAR_BELUM_LUNAS;
                                                                                }
                                                                            } else {
                                                                                echo PARAMS::STATUSBAYAR_BELUM_LUNAS;
                                                                            }
                                                                            ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6" style="text-align:center;">Total Tagihan</td>
                                        <td style="text-align:center;"><?php echo 'Rp' . number_format($grand_total, 2, ',', '.'); ?></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <?php
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
                ?>
                <div class="form-actions">
                    <?php
                    //echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printPRINT(' . $model->permintaandarah_id . ');'));
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printPDF(' . $model->permintaandarah_id . ');'));
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printEXCEL(' . $model->permintaandarah_id . ');'));
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
    <script type="text/javascript">
        function printPDF(id) {
            window.open('<?php echo $urlPrint ?>&id=' + id + '&caraPrint=PDF', 'printwin', 'left=400,top=400,width=800,height=600');
        }

        function printPRINT(id) {
            window.open('<?php echo $urlPrint ?>&id=' + id + '&caraPrint=PRINT', 'printwin', 'left=400,top=400,width=800,height=600');
        }

        function printEXCEL(id) {
            window.open('<?php echo $urlPrint ?>&id=' + id + '&caraPrint=EXCEL', 'printwin', 'left=400,top=400,width=800,height=600');
        }
    </script>