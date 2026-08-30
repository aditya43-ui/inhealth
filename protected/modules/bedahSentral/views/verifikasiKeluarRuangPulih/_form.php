<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'verifikasi-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));

$pegawai_login = Yii::app()->user->getState('pegawai_id');

$is_dokter = $verifikasi->dokteranastesi_id == $pegawai_login && !$verifikasi->verifikasidokteranastesi_status;
$is_perawat = $verifikasi->perawatanastesi_id == $pegawai_login && $verifikasi->verifikasidokteranastesi_status && !$verifikasi->verifikasiperawatanastesi_status;
$is_ruangan = $verifikasi->verifikasidokteranastesi_status && $verifikasi->verifikasiperawatanastesi_status && !$verifikasi->serahterima_status;

//var_dump($is_dokter); die;
//var_dump($verifikasi->attributes); die;
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-check"></i> Verifikasi Keluar Ruang Pulih & Serah Terima Pasien
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Item Serah Terima</th>
                    <th>Catatan Perawat Ruang Pulih</th>
                    <th>Verifikasi Dokter Anestesiologi</th>
                    <th>Verifikasi Perawat Anestesiologi</th>
                    <th>Serah Terima dengan Perawat Ruangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Jaringan</td>
                    <td><?php
                        echo $verifikasi->isjaringan;
                        if ($verifikasi->isjaringan == "Ada" && !empty($verifikasi->jenisjaringan)) {
                            echo ", " . $verifikasi->jenisjaringan;
                        }
                        ?></td>
                    <td>
                        <?php echo $form->radioButtonList($verifikasi, 'verifikasidokteranastesi_isjaringan_dan_jenis', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'class' => 'verifikasidokteranastesi_isjaringan_dan_jenis', 'disabled' => !$is_dokter)); ?>
                    </td>
                    <td>
                        <?php echo $form->radioButtonList($verifikasi, 'verifikasiperawatanastesi_isjaringan_dan_jenis', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'class' => 'verifikasidokteranastesi_isjaringan_dan_jenis', 'disabled' => !$is_perawat)); ?>
                    </td>
                    <td>
                        <?php echo $form->radioButtonList($verifikasi, 'serahterima_isjaringan_dan_jenis', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'class' => 'serahterima_isjaringan_dan_jenis', 'disabled' => !$is_ruangan)); ?>
                    </td>
                </tr>
                <tr>
                    <td>Form PA</td>
                    <td><?php echo $verifikasi->isformulir_pa;
                        ?></td>
                    <td>
                        <?php echo $form->radioButtonList($verifikasi, 'verifikasidokteranastesi_isformulirpa_danjumlah', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'class' => 'verifikasidokteranastesi_isformulirpa_danjumlah', 'disabled' => !$is_dokter)); ?>
                    </td>
                    <td>
                        <?php echo $form->radioButtonList($verifikasi, 'verifikasiperawatanastesi_isformulirpa_danjumlah', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'class' => 'verifikasiperawatanastesi_isformulirpa_danjumlah', 'disabled' => !$is_perawat)); ?>
                    </td>
                    <td>
                        <?php echo $form->radioButtonList($verifikasi, 'serahterima_isformulirpa_danjumlah', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'class' => 'serahterima_isformulirpa_danjumlah', 'disabled' => !$is_ruangan)); ?>
                    </td>
                </tr>
                <tr>
                    <td>RO</td>
                    <td><?php
                        echo $verifikasi->islembar_ro;
                        if ($verifikasi->islembar_ro == "Ada" && !empty($verifikasi->islembar_ro_jumlah)) {
                            echo ", " . $verifikasi->islembar_ro_jumlah . " lembar";
                        }
                        ?></td>
                    <td>
                        <?php echo $form->radioButtonList($verifikasi, 'verifikasidokteranastesi_islembarro_danjumlah', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'class' => 'verifikasidokteranastesi_islembarro_danjumlah', 'disabled' => !$is_dokter)); ?>
                    </td>
                    <td>
                        <?php echo $form->radioButtonList($verifikasi, 'verifikasiperawatanastesi_islembarro_danjumlah', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'class' => 'verifikasiperawatanastesi_islembarro_danjumlah', 'disabled' => !$is_perawat)); ?>
                    </td>
                    <td>
                        <?php echo $form->radioButtonList($verifikasi, 'serahterima_islembarro_danjumlah', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'class' => 'serahterima_islembarro_danjumlah', 'disabled' => !$is_ruangan)); ?>
                    </td>
                </tr>
                <tr>
                    <td>Lain-Lain</td>
                    <td><?php echo $verifikasi->verifikasiserahterima_lainlain; ?></td>
                    <td>
                        <?php echo $form->radioButtonList($verifikasi, 'verifikasidokteranastesi_islainlain', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'class' => 'verifikasidokteranastesi_islainlain', 'disabled' => !$is_dokter)); ?>
                    </td>
                    <td>
                        <?php echo $form->radioButtonList($verifikasi, 'verifikasiperawatanastesi_islainlain', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'class' => 'verifikasiperawatanastesi_islainlain', 'disabled' => !$is_perawat)); ?>
                    </td>
                    <td>
                        <?php echo $form->radioButtonList($verifikasi, 'serahterima_islainlain', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'class' => 'serahterima_islainlain', 'disabled' => !$is_ruangan)); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Nama</td>
                    <td><?php echo empty($verifikasi->dokteranastesi) ? "-" : $verifikasi->dokteranastesi->namaLengkap; ?></td>
                    <td><?php echo empty($verifikasi->perawatanastesi) ? "-" : $verifikasi->perawatanastesi->namaLengkap; ?></td>
                    <td><?php echo $form->dropDownList($verifikasi, 'perawatruanganpenerima_id', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array(
                            'ruangan_id' => $model->tindaklanjutpasien_ruanganrawat_id,
                            'kelompokpegawai_id' => Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN
                        ), array('order' => 'nama_pegawai')), 'pegawai_id', 'namaLengkap'), array(
                            'empty' => '-- Pilih --', 'disabled' => !$is_ruangan
                        )); ?></td>
                </tr>
                <tr>
                    <td colspan="2">Jam Verifikasi / Serah Terima Pasien</td>
                    <td>
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $verifikasi,
                            'attribute' => 'verifikasidokteranastesi_jam',
                            'mode' => 'time',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'span2 verifikasidokteranastesi_jam', 'onclick' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </td>
                    <td>
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $verifikasi,
                            'attribute' => 'verifikasiperawatanastesi_jam',
                            'mode' => 'time',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'span2 verifikasiperawatanastesi_jam', 'onclick' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </td>
                    <td>
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $verifikasi,
                            'attribute' => 'serahterima_jam',
                            'mode' => 'time',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'span2 serahterima_jam', 'onclick' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Status Verifikasi & Serah Terima</td>
                    <td><?php echo CHtml::htmlButton($verifikasi->verifikasidokteranastesi_status ? "Sudah Diverifikasi" : "Belum Diverifikasi", array('class' => 'btn ' . ($verifikasi->verifikasidokteranastesi_status ? "btn-success" : "btn-danger"))); ?></td>
                    <td><?php echo CHtml::htmlButton($verifikasi->verifikasiperawatanastesi_status ? "Sudah Diverifikasi" : "Belum Diverifikasi", array('class' => 'btn ' . ($verifikasi->verifikasiperawatanastesi_status ? "btn-success" : "btn-danger"))); ?></td>
                    <td><?php echo CHtml::htmlButton($verifikasi->serahterima_status ? "Sudah Serah Terima" : "Belum Serah Terima", array('class' => 'btn ' . ($verifikasi->serahterima_status ? "btn-success" : "btn-danger"))); ?></td>
                </tr>
                <tr>
                    <td colspan="2">Catatan</td>
                    <td><?php echo $form->textArea($verifikasi, 'verifikasidokteranastesi_catatan', array('rows' => 4, 'disabled' => !$is_dokter)); ?></td>
                    <td><?php echo $form->textArea($verifikasi, 'verifikasiperawatanastesi_catatan', array('rows' => 4, 'disabled' => !$is_perawat)); ?></td>
                    <td><?php echo $form->textArea($verifikasi, 'serahterima_catatan', array('rows' => 4, 'disabled' => !$is_ruangan)); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('index', array('pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id)),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    );
    ?>
    <?php // echo CHtml::link(Yii::t('mds', '{icon} Pengaturan PasienruangpulihT', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
    ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>

<?php $this->endWidget(); ?>