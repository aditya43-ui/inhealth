<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'id' => 'riwayat-sep-search',
            'type' => 'horizontal',
        )); ?>
        <div class="row-fluid">
            <div class="col-sm-6">
                <?php /*
                <div class="control-group">
                    <label class="control-label">Pilih</label>
                    <div class="controls">
                        <?php echo CHtml::radioButtonList('cari[jenis]', 1, array(
                            1 => "Rujukan",
                            2 => "Rujukan Manual/IGD",
                        ), array('onclick'=>'pilihRujukan();', 'class'=>'jenisrujukan')); ?>
                    </div>
                </div>
                */ ?>
                <?php /*
                <div class="control-group">
                    <label class="control-label">Tgl Sep</label>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                                'name' => 'cari[tgl_sep]',
                                'value' => MyFormatter::formatDateTimeForUser(date('Y-m-d')),
                                'mode' => 'date',
                                'options' => array(
                                        'dateFormat' => "yy-mm-dd",
                                        'showOn' => false,
                                        'maxDate' => 'd',
                                        'yearRange' => "-150:+0",
                                ),
                                'htmlOptions' => array(
                                        'placeholder' => '00/00/0000 00:00:00', 'class' => 'dtPicker2 span2 datetime required', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                ),
                        )); ?>
                    </div>
                </div>
                */ ?>
                <div class="search_rujukan rujukan_manual">
                    <div class="control-group">
                        <label class="control-label">Nomor</label>
                        <div class="controls">
                            <?php echo CHtml::textField('cari[nomor]', null, array('class'=>'span3')) ?>
                        </div>
                        <div class="controls">
                            <?php echo CHtml::radioButtonList('cari[jnsnomor]', 1, array(
                                1=>'BPJS', 2=>'NIK'
                            )) ?>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="col-sm-6">
                <div class="search_rujukan rujukan">
                    <div class="control-group hidden">
                        <label class="control-label">Faskes</label>
                        <div class="controls">
                            <?php echo CHtml::dropDownList('cari[jnsrujukan]', null, array(
                                '1' => 'Faskes Tingkat 1', '2' => 'Faskes Tingkat 2'
                            ), array('empty'=>'-- Pilih --', 'class'=>'span3')) ?>
                        </div>
                    </div>
                    <?php /*
                    <div class="control-group" hidden>
                        <label class="control-label">No. Peserta</label>
                        <div class="controls">
                            <?php echo CHtml::textField('cari[no_peserta]', null, array('class'=>'span3')) ?>
                        </div>
                    </div>
                    <?php /*
                    <div class="control-group">
                        <label class="control-label">No. Rekam Medik</label>
                        <div class="controls">
                            <?php echo CHtml::textField('cari[no_rekam_medik]', null, array('class'=>'span3')) ?>
                        </div>
                    </div>
                    */ ?>
                </div>
                <div class="search_rujukan rujukan_manual">
                    <div class="control-group">
                        <label class="control-label">Jenis Pelayanan</label>
                        <div class="controls">
                            <?php echo CHtml::dropDownList('cari[jnspelayanan]', null, array(
                                '2' => 'Rawat Jalan', '1' => 'Rawat Inap'
                            ), array('empty'=>'-- Pilih --', 'class'=>'span3')) ?>
                        </div>
                    </div>
                    <div class="control-group" hidden>
                        <label class="control-label">PPK Asal Peserta</label>
                        <div class="controls">
                            <?php echo CHtml::textField('cari[ppkasal]', null, array('class'=>'span3')) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'button', 'onclick'=>'cariRiwayatPasien()')
            ); ?>
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
            ); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>    
    </div>
</div>

<script>
function pilihRujukan() {
    return false; 
    ///$(".search_rujukan").hide().find(":input").prop("disabled", true);
    ///if ($(".jenisrujukan:checked").val() == 1) {
    ///    $(".rujukan").show().find(":input").prop("disabled", false);
    ///} else if ($(".jenisrujukan:checked").val() == 2) {
    ///    $(".rujukan_manual").show().find(":input").prop("disabled", false);
    ///}
}

function cariRiwayatPasien() {

    /*
    if ($(".jenisrujukan:checked").val() == 1) {
        if ($("#cari_no_peserta").val().trim() == "" && $("#cari_no_rekam_medik").val().trim() == "") {
            myAlert("No Peserta atau Nomor Rekam Medik harus diisi untuk dilakukan pencarian.");
            return false;
        }
    } else if ($(".jenisrujukan:checked").val() == 2) {

    }
    */

    $("#panel_riwayat_sep").addClass("animation-loading");

    $.post('<?php echo $this->createUrl('cariRiwayatSEP')?>', $("#riwayat-sep-search").serialize(), function(data) {
        if (data.ok == 1) {
            $("#detail_riwayat").html(data.html);
            $("#detail_kartu").html(data.peserta);
        } else {
            myAlert(data.msg);
        }
        $("#panel_riwayat_sep").removeClass("animation-loading");
    }, 'json');
}

$(document).ready(function() {
    pilihRujukan();
});
</script>