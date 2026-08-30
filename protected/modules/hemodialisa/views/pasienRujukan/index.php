<style>
    .button-status {
        margin-right: 8px;
    }
    .badge-status {
        position: relative;
        top: 8px;
        left: 8px;
    }

    .badge-status-jmlPanggil{
        position: relative;
        top: 8px;
        left: 10px;
        z-index: 10;
    }
    .button-status {
        min-width: 150px;
    }
    .btn-status {
        min-width: 150px;
    }
</style>
<!--div class="white-container"-->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Informasi <strong>Pasien Rujukan</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Pasien Rujukan</strong></div>
                    </div>
                    <div class="panel-body table-responsive">
                        <div class="block-tabel">
                            <?php
                                $this->widget('bootstrap.widgets.BootAlert');
                                $this->renderPartial('_table', ['dataProvider' => $dataProvider]);
                            ?>
                        </div>
                    </div>
                </div>								
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="icon-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
<?php $this->renderPartial('_formSearch', array('model' => $model)); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogKonfirm',
    'options' => array(
        'title' => '',
        'autoOpen' => false,
        'modal' => true,
        'width' => 300,
        'resizable' => false,
    ),
));
?>
                        <div class="divForForm"></div>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>								
            </div>
        </div>
    </div>
</div>

<?php echo $this->renderPartial('_jsFunctions', array()); ?>

<script type="text/javascript">
// document.getElementById('tgl_awal_date').setAttribute("style","display:none;");
// document.getElementById('tgl_akhir_date').setAttribute("style","display:none;");
    function cekTanggal() {

        var checklist = $('#cbTglMasuk');
        var pilih = checklist.attr('checked');
        if (pilih) {
            document.getElementById('tgl_awal_date').setAttribute("style", "display:block;");
            document.getElementById('tgl_akhir_date').setAttribute("style", "display:block;");
        } else {
            document.getElementById('tgl_awal_date').setAttribute("style", "display:none;");
            document.getElementById('tgl_akhir_date').setAttribute("style", "display:none;");
        }
    }

    function batalperiksa(pasienkirimkeunitlain_id)
    {
//        console.log(pasienkirimkeunitlain_id); return false;
        myConfirm("Apakah Anda yakin akan membatalkan rujukan Hemodialisa pasien ini?", "Perhatian!", function (r) {
            if (r) {
                $.get('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'batalRujuk') ?>', {pasienkirimkeunitlain_id: pasienkirimkeunitlain_id},
                        function (data) {
                            if (data.status == 'ok') {
                                myAlert(data.pesan);
                                $.fn.yiiGridView.update('pasienrujukan-m-grid', {
                                    data: $('#search-pasienrujukan-form').serialize()
                                });
                                return false;

                            } else {
                                myAlert(data.pesan, 'perhatian!');
                                return false;
                            }
                        }, 'json'
                        );
            }
        });
    }

    function setRuangan(data) {
        $("#<?php CHtml::activeId($model, "ruangan_nama") ?>").html(data);
        var ruanganAsal = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_nama') ?>');
        jQuery(ruanganAsal).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();
    }

    $(document).ready(function () {
        var instalasiAsal = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_nama') ?>');
        var ruanganAsal = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_nama') ?>');
        var dokterPengirim = jQuery('#<?php echo CHtml::activeId($model, 'nama_pegawai') ?>');
//        jQuery(instalasiAsal).multiselect({
//                includeSelectAllOption: true,
//                buttonClass: "form-control",
//                maxHeight: 300,
//                buttonWidth: '150px',
//                enableCaseInsensitiveFiltering: true
//        }).hide();

        jQuery(instalasiAsal).multiselect({

            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true,
            onChange: function (element, checked) {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_nama') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_nama') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_nama') ?>');

                var brands = ins_all;
                var selected = [];


                $(brands).each(function (index, brand) {
                    selected.push($(this).val());
                });

                ru.addClass('animation-loading');
                //alert(selected);

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('GetRuanganNamaByMultiSelect') ?>',
                    dataType: "json",
                    data: {instalasi_nama: selected},
                    success: function (data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onSelectAll: function () {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_nama') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_nama') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_nama') ?>');

                var brands = ins_all;
                var selected = [];

                $(brands).each(function (index, brand) {
                    selected.push($(this).val());
                });

                ru.addClass('animation-loading');


                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('GetRuanganNamaByMultiSelect') ?>',
                    dataType: "json",
                    data: {instalasi_nama: selected},
                    success: function (data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onDeselectAll: function () {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_nama') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_nama') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_nama') ?>');

                var brands = ins_all;
                var selected = '';



                ru.addClass('animation-loading');


                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('GetRuanganNamaByMultiSelect') ?>',
                    dataType: "json",
                    data: {instalasi_nama: selected},
                    success: function (data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            }
        }).hide();

        jQuery(ruanganAsal).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true,
            onChange: function (element, checked) {
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_nama') ?>');
                var ru_all = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_nama') ?>   option:selected');
                var np = jQuery('#<?php echo CHtml::activeId($model, 'nama_pegawai') ?>');

                var brands = ru_all;
                var selected = [];


                $(brands).each(function (index, brand) {
                    selected.push($(this).val());
                });

                np.addClass('animation-loading');
                //alert(selected);

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('GetDokterPengirimNamaByMultiSelect') ?>',
                    dataType: "json",
                    data: {ruangan_nama: selected},
                    success: function (data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            np.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            np.html(data.ruangan);
                            np.multiselect('rebuild');
                            np.removeClass('animation-loading');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onSelectAll: function () {
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_nama') ?>');
                var ru_all = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_nama') ?>   option:selected');
                var np = jQuery('#<?php echo CHtml::activeId($model, 'nama_pegawai') ?>');

                var brands = ru_all;
                var selected = [];

                $(brands).each(function (index, brand) {
                    selected.push($(this).val());
                });

                np.addClass('animation-loading');


                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('GetDokterPengirimNamaByMultiSelect') ?>',
                    dataType: "json",
                    data: {ruangan_nama: selected},
                    success: function (data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            np.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            np.html(data.ruangan);
                            np.multiselect('rebuild');
                            np.removeClass('animation-loading');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onDeselectAll: function () {
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_nama') ?>');
                var ru_all = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_nama') ?>   option:selected');
                var np = jQuery('#<?php echo CHtml::activeId($model, 'nama_pegawai') ?>');

                var brands = ru_all;
                var selected = '';



                np.addClass('animation-loading');


                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('GetDokterPengirimNamaByMultiSelect') ?>',
                    dataType: "json",
                    data: {ruangan_nama: selected},
                    success: function (data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            np.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            np.html(data.ruangan);
                            np.multiselect('rebuild');
                            np.removeClass('animation-loading');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            }

        }).hide();

        jQuery(dokterPengirim).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();
    });


</script>


<?php
// INFORM CONSENT =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPilihTglPeriksa',
    'options' => array(
        'title' => 'Pilih Tgl. Pemeriksaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 400,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('pasienrujukan-m-grid', {
            data: $('#search-pasienrujukan-form').serialize()
        }); }",
    ),
));
?>
<iframe name='framePilihTglPeriksa' style="width: 100%; height: 98%;"></iframe>

<?php $this->endWidget(); ?>