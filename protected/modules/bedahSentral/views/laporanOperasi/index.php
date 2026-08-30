<?php
$this->breadcrumbs = array(
    'Laporan Operasi',
);

$this->widget('bootstrap.widgets.BootAlert');

$dropKelompok = CHtml::listData(KelompokdiagnosaM::model()->findAll("kelompokdiagnosa_aktif = TRUE"), "kelompokdiagnosa_id", "kelompokdiagnosa_nama");
?>
<style>
    tr.tandain{
        background: yellow !Important;
    }
</style>
<script type="text/javascript">
    var id_diagnosax = new Array();
</script>
<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Laporan Operasi</div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">Riwayat Laporan Operasi</div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . "_riwayat", array('modPendaftaran' => $modPendaftaran), true); ?>
            </div>
        </div>


        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'laporanoperasi-frm',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this)')
        ));
        ?>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">Informasi Bedah</div>
            </div>
            <div class="panel-body">
                <?php echo CHtml::activeHiddenField($model, 'pendaftaran_id'); ?>
                <?php echo CHtml::activeHiddenField($model, 'pasienadmisi_id'); ?>
                <?php echo CHtml::activeHiddenField($model, 'pasien_id'); ?>
                <?php echo CHtml::activeHiddenField($model, 'pasienmasukpenunjang_id'); ?>
                <?php echo CHtml::activeHiddenField($model, 'rencanaoperasi_id'); ?>

                <div class="row">
                    <div class="col-sm-6">
                        
                        <div class="control-group ">
                            <?php echo CHtml::label('Permintaan Operasi', 'operasi_id', array('class' => 'control-label required')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'pasienmasukpenunjang_id', $model->dropListPasienKirimByPasien(), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);",'onchange'=>"loadDataPenunjang(this)")); ?>
                            </div>
                        </div>
                        
                        <div class="control-group ">
                            <?php echo CHtml::label('Pilih Operasi <span class="required">*</span>', 'operasi_id', array('class' => 'control-label required')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'operasi_id', $listDataOperasi, array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group hide">
                            <?php echo CHtml::label('Jenis Operasi', 'is_cyto', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->radioButtonList($model, 'is_cyto', array(1 => "Cito", 0 => "Elektif"), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group hide">
                            <?php echo CHtml::label('Golongan Operasi', 'golonganoperasi_keterangan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'golonganoperasi_keterangan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo CHtml::label('Dokter Bedah <span class="required">*</span>', 'dokterbedah', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?= $form->dropDownList($model, 'dokterpelaksana_id', $model->dropListDoterBedah(),['empty'=>'-- Pilih --', 'class'=>'required']) ?>
                            </div>
                        </div>                       
                        <div class="control-group ">
                            <?php echo CHtml::label('Asisten Bedah', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo CHtml::textField('asistenbedah', '', array('class' => 'span3 asistenbedah', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo CHtml::textField('asistenbedah_2', '', array('class' => 'span3 asistenbedah_2', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo CHtml::label('Dokter Anestesi', 'tgl_sbar', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo CHtml::textField('dokteranestesi','', array('class' => 'span3 dokteranestesi', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo CHtml::label('Perawat Instrumen', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo CHtml::textField('perawat_instrumen', '', array('class' => 'span3 perawat_instrumen', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo CHtml::label('Jenis Anestesi', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->radioButtonList($model, 'jenis_anestesi', CHtml::listData(LookupM::model()->findAll("lookup_type = 'jenisanestesi'"), 'lookup_value', 'lookup_name'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group ">
                            <?php echo CHtml::label('Tanggal Operasi', 'tglrencanoeprasi', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tglrencanoeprasi',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'class' => 'span3 tglrencanoeprasi',
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo CHtml::label('Dikirim untuk pemeriksaan', 'is_dikirimpemeriksaan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->radioButtonList($model, 'is_dikirimpemeriksaan', array(1 => "Ya", 0 => "Tidak"), array('class' => 'is_dikirimpemeriksaan', 'onchange' => 'setChangeKirim();', 'uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo CHtml::label('', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->radioButtonList($model, 'kirimpemeriksaanket', array("PA" => "PA", "VC" => "VC", "Kultur" => "Kultur", "Analisa" => "Analisa"), array('class' => 'kirimpemeriksaanket', 'uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo CHtml::label('Jaringan yang di eksisi/insisi', 'jaringan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'jaringan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo CHtml::label('Drain/ Tampon', 'drain', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'drain', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo CHtml::label('Alat Implan', 'alatimplan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'alatimplan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo CHtml::label('Perdarahan', 'perdarahan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'perdarahan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">Diagnosa</div>
            </div>
            <div class="panel-body">
                <?php /*
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Diagnosa (ICD X)</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th>Tgl. Diagnosa</th>
                                    <th>Kelompok Diagnosa</th>
                                    <th>Dokter</th>
                                    <th>Klasifikasi Diagnosa</th>
                                    <th>Kode</th>
                                    <th>Nama Diagnosa</th>
                                    <th>Nama Lain</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pasienmobiditas)) {
                                    foreach ($pasienmobiditas as $pm) {
                                ?>
                                        <tr>
                                            <td><?php echo MyFormatter::formatDateTimeForDb($pm->tglmorbiditas); ?></td>
                                            <td><?php echo (!empty($pm->kelompokdiagnosa) ? $pm->kelompokdiagnosa->kelompokdiagnosa_nama : ""); ?></td>
                                            <td>
                                                <?php
                                                if (!empty($pm->pegawai_id)) {
                                                    echo PegawaiM::model()->findByPk($pm->pegawai_id)->nama_pegawai;
                                                } else {
                                                    echo "-";
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo (!empty($pm->diagnosa) ? (!empty($pm->diagnosa->klasifikasidiagnosa) ? $pm->diagnosa->klasifikasidiagnosa->klasifikasidiagnosa_nama : "") : ""); ?></td>
                                            <td><?php echo (!empty($pm->diagnosa) ? $pm->diagnosa->diagnosa_kode : ""); ?></td>
                                            <td><?php echo (!empty($pm->diagnosa) ? $pm->diagnosa->diagnosa_nama : ""); ?></td>
                                            <td><?php echo (!empty($pm->diagnosa) ? $pm->diagnosa->diagnosa_namalainnya : ""); ?></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="7">Tidak Ditemukan!</td></tr>';
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                */ ?>
                <br/>
                                
                <?php
                    $this->renderPartial('bedahSentral.views.laporanOperasi/diagnosa-x/_form',
                        array(                         
                            'modMorbiditas'=>$modMorbiditas,
                            'model'=>$model,
                            'dropKelompok'=>$dropKelompok
                        )
                    );
                ?>
                <br/>
                <?php
                $this->renderPartial(
                    $this->path_view . '_gridDiagnosaICDIX',
                    array(
                        'form' => $form,                        
                        'modPasienIcd9'=>$modPasienIcd9,
                        'model'=>$model,
                        'modPendaftaran'=>$modPendaftaran,                        
                    )
                );
                ?>
            </div>
        </div>

        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">Laporan Operasi</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="control-group ">
                            <?php echo CHtml::label('Persiapan Operasi (Profilaksis, inform consent)', 'persiapanoperasi', array('class' => 'control-label', 'style' => 'width: 290px')) ?>
                            <div class="controls" style="width: 70%">
                                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'persiapanoperasi', 'toolbar' => 'mini', 'height' => '200px')) ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo CHtml::label('Posisi Pasien', 'posisipasien', array('class' => 'control-label', 'style' => 'width: 290px')) ?>
                            <div class="controls" style="width: 70%">
                                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'posisipasien', 'toolbar' => 'mini', 'height' => '200px')) ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo CHtml::label('Desinfeksi', 'desinfeksi', array('class' => 'control-label', 'style' => 'width: 290px')) ?>
                            <div class="controls" style="width: 70%">
                                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'desinfeksi', 'toolbar' => 'mini', 'height' => '200px')) ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo CHtml::label('Insisi Kulit dan pembukaan lapangan operasi', 'insisikulit', array('class' => 'control-label', 'style' => 'width: 290px')) ?>
                            <div class="controls" style="width: 70%">
                                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'insisikulit', 'toolbar' => 'mini', 'height' => '200px')) ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo CHtml::label('Pendapatan pada eksplorasi', 'pendapataneksplorasi', array('class' => 'control-label', 'style' => 'width: 290px')) ?>
                            <div class="controls" style="width: 70%">
                                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'pendapataneksplorasi', 'toolbar' => 'mini', 'height' => '200px')) ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo CHtml::label('Deskripsi/ uraian operasi', 'deskripsioeprasi', array('class' => 'control-label', 'style' => 'width: 290px')) ?>
                            <div class="controls" style="width: 70%">
                                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'deskripsioeprasi', 'toolbar' => 'mini', 'height' => '200px')) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')),
                array('class' => 'btn btn-primary', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'onclick'=>'cekForm();')
            ); ?>

            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')),
                $this->createUrl($this->module->id . '/Index', array('pendaftaran_id' => $_GET['pendaftaran_id'], 'type' => !empty($_GET['type']) ? $_GET['type'] : "", 'frame' => $_GET['frame'])),
                array(
                    'class' => 'btn btn-danger',
                    'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('#') . '";} ); return false;'
                )
            );

            $this->widget('UserTips', array('type' => 'transaksi', 'content' => 'penjelasan transaksi'));
            ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model)); ?>
<?php $this->renderPartial('rekamMedis.views.resumeMedis/_dialog', array('modMorbi' => $modMorbiditas, 'dropKelompok'=>$dropKelompok, 'modMorbiIx'=>$modPasienIcd9,)); ?>