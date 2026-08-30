<style>
.judul-ab {
    font-weight: bold;
}

.inp-ab {
    margin-left: 20px;
}

.space-ab1 {
    margin-left: 20px;
    margin-right: 20px;
}

.space-ab2 {
    margin-left: 20px;
    margin-right: 20px;
}
</style>

<?php echo $form->errorSummary($viralload); ?>


<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-book"></i> &nbsp;<b>Pemeriksaan PCR-HIV Viral Load</b>
            <?php // echo $form->hiddenField($viralload, 'pemeriksaanpewarnaan_id', array('class' => '', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
        </div>
    </div>
    <div class="panel-body" id="">
        <div class="row row-fluid">
            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">Dokter Lab 1 <span class="required">*</span></label>
                    <div class="controls">
                        <?php
                            echo $form->dropDownList($viralload, 'pegawai_id', CHtml::listData(PegawairuanganV::model()->findAll(' ruangan_id = 1131 and kelompokpegawai_id = 1 '), 'pegawai_id', 'namaLengkap'), array(
                                'empty' => '-- Pilih --', 'class' => 'span4 required',
                            ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Dokter Lab 2</label>
                    <div class="controls">
                        <?php
                            echo $form->dropDownList($viralload, 'dpjp_id', CHtml::listData(PegawairuanganV::model()->findAll(' ruangan_id = 1131 and kelompokpegawai_id = 1 '), 'pegawai_id', 'namaLengkap'), array(
                                'empty' => '-- Pilih --', 'class' => 'span4',
                            ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Analis</label>
                    <div class="controls">
                        <?php
                            echo $form->dropDownList($viralload, 'perawat_id', CHtml::listData(PegawairuanganV::model()->findAll(' ruangan_id = 1131 and kelompokpegawai_id in (2, 20) '), 'pegawai_id', 'namaLengkap'), array(
                                'empty' => '-- Pilih --', 'class' => 'span4',
                            ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">Tanggal Pemeriksaan <span class="required">*</span></label>
                    <div class="controls">
                        <?php
                    
                            $this->widget('MyDateTimePicker', array(
                                'model' => $viralload,
                                'attribute' => 'tgl_pemeriksaan',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array('class' => 'dtPicker3 span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));

                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Jenis Pemeriksaan </label>
                    <div class="controls">
                        <?php echo $form->textField($viralload, 'jenis_pemeriksaan', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
        </div><br>
        <div class="row row-fluid">
            <div class="col-sm-12">
                <table class="table table-stripped table-bordered">
                    <thead>
                        <tr>
                            <th>No. </th>
                            <th>Parameter</th>
                            <th>Hasil</th>
                            <th>Satuan</th>
                            <th>Nilai Rujukan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: center;">1.</td>
                            <td style="text-align: center;">PCR-RNA HIV</td>
                            <td><?php echo $form->dropDownList($viralload, 'hasil_pcr_vl', LookupM::getItemsUrutan('hasil_pcr_vl'), array('disabled' => false, 'empty' => '-- Pilih --', 'class' => 'hasilPemeriksaan')); ?>
                            </td>
                            <td style="text-align: center;">copies/mL</td>
                            <td style="text-align: center;">40-10.000.000</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">2.</td>
                            <td style="text-align: center;">LOG</td>
                            <td><?php echo $form->dropDownList($viralload, 'hasil_log_vl', LookupM::getItemsUrutan('hasil_log_vl'), array('disabled' => false, 'empty' => '-- Pilih --', 'class' => 'hasilPemeriksaan')); ?>
                            </td>
                            <td style="text-align: center;">LOG</td>
                            <td style="text-align: center;">1.6-7</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="form-actions">
        <?php

            if (!isset($_GET['sukses'])) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit'));
                echo "&nbsp;";
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                echo "&nbsp;";
            }       
                
            if (!isset($_GET['pemeriksaanviralload_id'])) {
                echo CHtml::link(Yii::t('mds', '{icon} Print Viral Load', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info', 'onclick' => "return false"));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print Viral Load', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printViralLoad();return false"));
            }
            
            $content = $this->renderPartial('akuntansi.views.tips.tipsaddedit3a', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                
        ?>
    </div>
</div>

<script>
function printViralLoad() {
    console.log('idne gak eroh');
    window.open(
        '<?php echo $this->createUrl('printViralLoad', array('pemeriksaanviralload_id' => $viralload->pemeriksaanviralload_id)); ?>',
        'printwin', 'left=100,top=100,width=720,height=960');
}

$(document).ready(function() {

    var dokterlab_1  = jQuery('#<?php echo CHtml::activeId($viralload, 'pegawai_id') ?>');
    var dokterlab_2  = jQuery('#<?php echo CHtml::activeId($viralload, 'dpjp_id') ?>');
    var petugas  = jQuery('#<?php echo CHtml::activeId($viralload, 'perawat_id') ?>');

    jQuery(dokterlab_1).multiselect({
        includeSelectAllOption: true,
        buttonClass: "form-control",
        maxHeight: 300,
        buttonWidth: '240px',
        enableCaseInsensitiveFiltering: true
    }).hide();

    jQuery(dokterlab_2).multiselect({
        includeSelectAllOption: true,
        buttonClass: "form-control",
        maxHeight: 300,
        buttonWidth: '240px',
        enableCaseInsensitiveFiltering: true
    }).hide();

    jQuery(petugas).multiselect({
        includeSelectAllOption: true,
        buttonClass: "form-control",
        maxHeight: 300,
        buttonWidth: '240px',
        enableCaseInsensitiveFiltering: true
    }).hide();

});


</script>