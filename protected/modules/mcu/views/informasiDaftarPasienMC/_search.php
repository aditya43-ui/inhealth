<?php

/**
 * view ini digunakan untuk menampilkan form - form pencarian data
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'caripasien-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'no_pendaftaran'),
    'htmlOptions' => array(),
)); ?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <table style="width: 100%; border: none;">
            <tr>
                <td>
                    <div class="control-group">
                        <?php echo CHtml::label("Tgl. Rencana Periksa", 'tglrenkontrol', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                                <i class="entypo-calendar"></i>
                                <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                                <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label(CHtml::activeCheckBox($model, 'ceklis') . " Tgl. Pendaftaran", 'tgl_pendaftaran', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <div class="daterange daterange-inline input-inline kondisi span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal_pendaftar)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir_pendaftar)) ?>">
                                <i class="entypo-calendar"></i>
                                <span><?php echo date('d M Y', strtotime($model->tgl_awal_pendaftar)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir_pendaftar)) ?></span>
                                <?php echo $form->hiddenField($model, 'tgl_awal_pendaftar', array('class' => 'start')) ?>
                                <?php echo $form->hiddenField($model, 'tgl_akhir_pendaftar', array('class' => 'end')) ?>
                            </div>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4', 'maxlength' => 20)); ?>
                    <div class="control-group " hidden>
                        <label for="namaPasien" class="control-label">
                            Poliklinik
                        </label>
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'ruangan_id', CHtml::listData($model->getRuanganItems(Params::INSTALASI_ID_RJ), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Kelas Pelayanan</label>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($model, 'kelaspelayanan_id', CHtml::listData(MCPendaftaranT::getKelasPelayananItemsMCU(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                            ?>
                        </div>
                    </div>
                </td>
                <td>
                    <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4 numbers-only', 'maxlength' => 8)); ?>
                    <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'maxlength' => 50)); ?>
                    <?php echo $form->dropDownListRow($model, 'statusperiksa', LookupM::getItems('statusperiksa'), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>
                    <div class="control-group">
                        <label for="namaPasien" class="control-label">
                            Dokter Penanggung Jawab
                        </label>
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'pegawai_id', CHtml::listData(MCPendaftaranT::model()->getDokterItems($model->ruangan_id), 'pegawai_id', 'namaLengkap'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            );
            ?>
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
            ); ?>
            <?php
            $content = $this->renderPartial('../tips/informasiRJ', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<script>
    function control(obj) {
        if ($(obj).is(":checked")) {
            //$("#MCInfokunjunganmcuV_tgl_awal_pendaftar").prop("disabled", true);
            $("#MCInfokunjunganmcuV_tgl_awal_pendaftar").prop('disabled', true);
            $("#MCInfokunjunganmcuV_tgl_akhir_pendaftar").prop('disabled', true);
        }
    }
    // function control(){
    //     document.getElemenById("MCInfokunjunganmcuV_tgl_awal_pendaftar").disabled=true;
    //     document.getElemenById("MCInfokunjunganmcuV_tgl_akhir_pendaftar").disabled=true;
    // }
    $("input[type=checkbox]").on("change", function(evt) {
                var MCInfokunjunganmcuV_tgl_awal_pendaftar = $('input[id=MCInfokunjunganmcuV_tgl_awal_pendaftar]:checked');
                $("#MCInfokunjunganmcuV_tgl_awal_pendaftar").prop('disabled', true);
            }
</script>