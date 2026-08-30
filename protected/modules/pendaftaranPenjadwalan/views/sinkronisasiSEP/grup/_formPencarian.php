<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Tgl Pendaftaran <span class='required'>*</span>", 'tgl_pendaftaran', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'name' => 'cari[tgl_pendaftaran]',
                            'value' => null,
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'showOn' => false,
                                'maxDate' => 'd',
                                'yearRange' => "-150:+0",
                            ),
                            'htmlOptions' => array(
                                'class' => 'dtPicker2 span2 datetime required', 'onkeyup' => "return $(this).focusNextInputField(event)",
                            ),
                        )); ?>
                    </div>
                </div>

            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Jenis Pelayanan <span class='required'>*</span>", 'jns_pelayanan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo CHtml::dropDownList('cari[jns_pelayanan]', null, array(
                            'Rawat Jalan'=>'Rawat Jalan',
                            'Rawat Inap'=>'Rawat Inap'
                        ), array(
                            'empty'=>'-- Pilih --',
                        )); ?>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="form-action">
            <?php echo CHtml::htmlButton('<i class="entypo-search"></i> Cari', array(
                'class'=>'btn btn-success', 'onclick'=>'cariSEPKosong();',
            )); ?>
        </div>
    </div>
</div>
<script>

function cariSEPKosong() {
    if ($("#cari_tgl_pendaftaran").val().trim() == "" || $("#cari_jns_pelayanan").val().trim() == "") {
        myAlert("Tanggal pendaftaran dan Jenis Pelayanan harus diisi untuk pencarian ini.");
        return false;
    }

    $("#tab_no_sep").addClass('animation-loading');

    $.post("<?php echo $this->createUrl('searchNoSEPList'); ?>", {
        tgl_pendaftaran: $("#cari_tgl_pendaftaran").val(),
        jns_pelayanan: $("#cari_jns_pelayanan").val()
    }, function(data) {
        if (data.ok == 1) {
            $("#tab_no_sep tbody").html(data.html);
        } else {
            myAlert(data.msg);
        }

        $("#tab_no_sep").removeClass('animation-loading');
    }, 'json');
}


</script>