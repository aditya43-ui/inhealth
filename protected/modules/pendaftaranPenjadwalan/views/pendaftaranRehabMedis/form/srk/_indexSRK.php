<?php


$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogSRK',
    'options' => array(
        'title' => 'Pembuatan Surat Rencana Kontrol',
        'autoOpen' => false,
        'modal' => true,
        'width' => 480,
        'height' => 400,
        'resizable' => false,
    ),
));



$srk = new SuratketeranganR;
$srk->tglkontrol = MyFormatter::formatDateTimeForUser(date('Y-m-d'));

?>
<div class="row-fluid">
    <div class="col-sm-12">
        <form id="form_srk" class="form-horizontal">
            <?php echo CHtml::activeHiddenField($srk, 'suratketerangan_id', array(
                'class' => 'srk_suratketerangan_id',
            )); ?>
            <?php echo CHtml::activeHiddenField($srk, 'nokartu_asuransi', array(
                'class' => 'srk_nokartu_asuransi',
            )); ?>
            <?php echo CHtml::activeHiddenField($srk, 'nama_pasien', array(
                'class' => 'srk_nama_pasien',
            )); ?>
            <div class="control-group">
                <?php echo CHtml::label('No. Kartu', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::activeTextField($srk, 'nokartu', array(
                        'class' => 'span3 srk_nokartu',
                    )); ?>
                    <?php echo CHtml::htmlButton('Cari', array(
                        'class' => 'btn btn-info',
                        'onclick' => 'srkCariRiwayatSEP();'
                    )); ?>
                </div>
            </div>
            <hr />
            <div class="control-group">
                <?php echo CHtml::label('No. SEP', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::activeTextField($srk, 'nosep', array(
                        'class' => 'span3 srk_nosep', 'readonly' => true,
                    )); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Tgl. SEP', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::activeTextField($srk, 'tglsep', array(
                        'class' => 'span3 srk_tglsep', 'readonly' => true,
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Sub / Spesialis', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php

                    $dataSP = SpesialissubspesialisM::model()->findAllByAttributes(array(
                        'spesialissubspesialis_aktif' => true,
                    ), array(
                        'order' => 'spesialissubspesialis_nama asc'
                    ));
                    $listSP = CHtml::listData($dataSP, 'spesialissubspesialis_id', 'spesialissubspesialis_nama');
                    $optionSP = array();


                    foreach ($dataSP as $item) {
                        $optionSP[$item->spesialissubspesialis_id] = array(
                            'data-kode' => $item->spesialissubspesialis_kodebpjs
                        );
                    }

                    echo CHtml::activeDropDownList(
                        $srk,
                        'spesialissubspesialis_id',
                        $listSP,
                        array(
                            'empty' => '-- Pilih --',
                            'class' => 'span3 srk_spesialissubspesialis_id',
                            'options' => $optionSP,
                            'onchange' => 'cekSpesialisVClaim();'
                        )
                    );
                    ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('DPJP Melayani', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $dataDokter = PegawaiM::model()->findAllByAttributes(array(
                        'pegawai_aktif' => true,
                    ), array(
                        'condition' => "kodedokter_bpjs is not null and kodedokter_bpjs not ilike '%null%'",
                        'order' => 'nama_pegawai asc'
                    ));
                    $listDokter = CHtml::listData($dataDokter, 'pegawai_id', 'namaLengkap');
                    $optionDokter = array();

                    foreach ($dataDokter as $item) {
                        $optionDokter[$item->pegawai_id] = array(
                            'data-kode' => $item->kodedokter_bpjs
                        );
                    }
                    echo CHtml::activeDropDownList($srk, 'doktertujuankontrol_id', $listDokter, array('empty' => '-- Pilih --', 'class' => 'span3 srk_doktertujuankontrol_id', 'options' => $optionDokter));
                    ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Tgl Kontrol', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $srk,
                        'attribute' => 'tglkontrol',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            // 'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('class' => 'dtPicker3 span3', 'onchange' => 'srkSetKontrolDariSEP();'),
                    )); ?>
                </div>
            </div>
            <div class="form-action">
                <?php echo CHtml::htmlButton('<i class="entypo-check"></i> Simpan', array(
                    'class' => 'btn btn-primary srk_btn_submit',
                    'onclick' => 'srkSimpan();'
                )); ?>
                <?php echo CHtml::htmlButton('<i class="entypo-print"></i> Cetak', array(
                    'class' => 'btn btn-info srk_btn_cetak',
                    'onclick' => 'printSRK();',
                    'disabled' => true,
                )) ?>
                <?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i> Ulangi', array(
                    'class' => 'btn btn-danger',
                    'type' => 'reset',
                )) ?>
            </div>


        </form>
    </div>
</div>

<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRSKRiwayatSEP',
    'options' => array(
        'title' => 'Riwayat SEP',
        'autoOpen' => false,
        'modal' => true,
        'width' => 775,
        'height' => 480,
        'resizable' => false,
    ),
));
?>
<div class="srk_riwayat_sep">
    <table>
        <tr>
            <td>
                <?php
                echo CHtml::label("Tanggal SEP", 'tgl_sep', array('class' => 'control-label', 'style' => 'width:80px !important; padding-top: 10px !important; padding-left:10px !important; '));
                ?>
            </td>
            <td>
                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($modSep->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($modSep->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d F Y', strtotime($modSep->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($modSep->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($modSep, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($modSep, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </td>
            <td>
                <?php echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                    array(
                        'class' => 'btn btn-danger',
                        'type' => 'button',
                        'title' => 'Cari',
                        'onClick' => 'cariRiwayatSep()'
                    )
                ); ?>
            </td>
        </tr>
    </table>
    <table class="table table-bordered table-condensed srk_tab_riwayat_base">
        <thead>
            <tr>
                <th>Pilih</th>
                <th>No. Sep</th>
                <th>Tgl. Sep</th>
                <th>No. Kartu dan Nama Peserta</th>
                <th>No. Rujukan</th>
                <th>Diagnosa</th>
                <th>Poliklinik</th>
            </tr>
        </thead>
        <tbody class="tab_srk_riwayat_sep">

        </tbody>
    </table>
</div>
<?php
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRSKRiwayatSEPRI',
    'options' => array(
        'title' => 'Riwayat SEP Rawat Inap',
        'autoOpen' => false,
        'modal' => true,
        'width' => 775,
        'height' => 480,
        'resizable' => false,
    ),
));
?>
<div class="srk_riwayat_sep_ri">
    <table class="table table-bordered table-condensed srk_tab_riwayat_base_ri">
        <thead>
            <tr>
                <th>Pilih</th>
                <th>No. Sep</th>
                <th>Tgl. Sep</th>
                <th>No. Kartu dan Nama Peserta</th>
                <th>No. Rujukan</th>
                <th>Diagnosa</th>
                <th>Poliklinik</th>
                <th>PPK Pelayanan</th>
            </tr>
        </thead>
        <tbody class="tab_srk_riwayat_sep_ri">

        </tbody>
    </table>
</div>
<?php
$this->endWidget();
?>


<script>
    function setDialogSRK() {

        $("#form_srk").get(0).reset();
        var no_kartu = $("#PPAsuransipasienbpjsM_nopeserta").val() //$(".no_kartu_srk").val();

        if (no_kartu == "") {
            myAlert("Isi Nomor Kartu terlebih dahulu");
            return false;
        }


        $(".srk_btn_cetak").prop("disabled", true);
        $(".srk_btn_submit").prop("disabled", false);
        $(".srk_suratketerangan_id").val("");
        $(".srk_nokartu").val(no_kartu);
        $("#dialogSRK").dialog("open");



    }
    // cari riwayat sep
    function srkCariRiwayatSEP() {
        $("#dialogRSKRiwayatSEP").dialog("open");

        var no_kartu = $(".srk_nokartu").val();

        $(".tab_srk_riwayat_sep").empty();
        $(".srk_tab_riwayat_base").addClass('animation-loading');

        $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/srkGetLoadRiwayatSEP'); ?>', {
            nokartu: no_kartu
        }, function(data) {
            if (data.ok != 1) {
                myAlert(data.msg);
            } else {
                $(".tab_srk_riwayat_sep").html(data.html);
            }
            $(".srk_tab_riwayat_base").removeClass('animation-loading');
        }, 'json');
    }

    function srkSetKontrolDariSEP(nosep = null) {
        if (nosep == null) {
            nosep = $("#SuratketeranganR_nosep").val();
        }
        var spesialis_idd = $("#SuratketeranganR_spesialissubspesialis_id").val();

        var tgl = $("#SuratketeranganR_tglkontrol").val();
        $("#dialogRSKRiwayatSEP").dialog("close");
        $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/srkLoadSEP'); ?>', {
            nosep: nosep,
            tgl: tgl,
            spesialis_id: spesialis_idd
        }, function(data) {
            if (data.ok != 1) {
                myAlert(data.msg);
            } else {
                console.log(data.sepData);
                $(".srk_nosep").val(data.sepData.noSep);
                $(".srk_tglsep").val(data.sepData.tglSep);
                $('.srk_nama_pasien').val(data.sepData.peserta.nama);
                $('.srk_nokartu_asuransi').val(data.sepData.peserta.noKartu);
                var spesialis_id = null;
                $(".srk_spesialissubspesialis_id option").each(function() {
                    if ($(this).data('kode') == data.sepData.poli) {
                        spesialis_id = $(this).val();
                    }
                });
                if (spesialis_id != null) {
                    $(".srk_spesialissubspesialis_id").val(spesialis_id);
                }

                var dokter = null;
                $(".srk_doktertujuankontrol_id").html(data.html_dpjp);
                $(".srk_doktertujuankontrol_id option").each(function() {
                    if ($(this).data('kode') == data.sepData.dpjp.dkDPJP) {
                        dokter = $(this).val();
                    }
                });
                if (dokter != null) {
                    $(".srk_doktertujuankontrol_id").val(dokter);
                }


            }
        }, 'json');
    }

    function srkSimpan() {
        $(".form-action").addClass('animation-loading');
        $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/rskSimpan'); ?>',
            $("#form_srk").serialize(),
            function(data) {
                if (data.ok != 1) {
                    myAlert(data.msg);
                } else {
                    $("#PPSepT_no_surat").val(data.nomor_kontrol);
                    $("#PPSepT_nama_dpjp").val(data.nama_dpjp);
                    $("#PPSepT_kode_dpjp").val(data.kode_dpjp);


                    $(".srk_form_no_surat").val(data.nomor_kontrol);
                    $(".srk_form_nama_dpjp").val(data.nama_dpjp);
                    $(".srk_form_kode_dpjp").val(data.kode_dpjp);
                    $(".srk_suratketerangan_id").val(data.suratketerangan_id);

                    // $("#dialogSRK").dialog("close");
                    // $("#form_srk").get(0).reset();
                    $(".srk_btn_cetak").prop("disabled", false);
                    $(".srk_btn_submit").prop("disabled", true);
                    myAlert("Surat Rencana Kontrol berhasil dibuat!")
                }
                $(".form-action").removeClass('animation-loading');
            }, 'json');
    }

    function printSRK() {
        var id = $(".srk_suratketerangan_id").val();

        window.open('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/printSRK'); ?>&id=' + id, 'printwin', 'left=100,top=100,width=640,height=480');
    }

    function cekSpesialisVClaim() {

        var no_kartu = $("#SuratketeranganR_nokartu").val();
        var spesialis_id = $("#SuratketeranganR_spesialissubspesialis_id").val();
        var tgl = $("#SuratketeranganR_tglsep").val();
        var tglkontrol = $("#SuratketeranganR_tglkontrol").val()

        if (no_kartu == "") {
            myAlert("Nomor Kartu BPJS harus di isi.");
            return false;
        }
        if (spesialis_id == "") {
            myAlert("Spesialis harus di isi.");
            return false;
        }
        if (tgl == "") {
            myAlert("Tanggal rencana harus di isi.");
            return false;
        }



        $.post('<?php echo $this->createUrl('cekVClaimSpesialis'); ?>', {
            no_kartu: no_kartu,
            spesialis_id: spesialis_id,
            tgl: tgl,
            tglkontrol: tglkontrol
        }, function(data) {
            if (data.ok == 0) {
                myAlert(data.msg);
            }

            $("#SuratketeranganR_doktertujuankontrol_id").html(data.html);

        }, 'json');
    }

    function cariRiwayatSep() {
        var tgl_awal = $("#<?php echo CHtml::activeId($modSep, 'tgl_awal') ?>").val();
        var tgl_akhir = $("#<?php echo CHtml::activeId($modSep, 'tgl_akhir') ?>").val();

        var nomor = $("#SuratketeranganR_nokartu").val();
        $(".tab_srk_riwayat_sep").empty();
        $(".srk_tab_riwayat_base").addClass('animation-loading');

        $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/loadRiwayatSEP2'); ?>', {
            nomor: nomor,
            tgl_awal: tgl_awal,
            tgl_akhir: tgl_akhir
        }, function(data) {
            console.log(data, 'data');
            if (data.ok != 1) {
                myAlert(data.msg);
            } else {
                $(".tab_srk_riwayat_sep").html(data.html);
            }
            $(".srk_tab_riwayat_base").removeClass('animation-loading');
        }, 'json');
    }

    function srkCariRiwayatSEPRI() {
        $("#dialogRSKRiwayatSEPRI").dialog("open");

        var no_kartu = $("#PPAsuransipasienbpjsM_nopeserta").val(); //$(".no_kartu_srk").val();

        if (no_kartu == "") {
            no_kartu = $("#<?php echo CHtml::activeId($modSep, 'nopeserta') ?>").val();
        }

        $(".tab_srk_riwayat_sep_ri").empty();
        $(".srk_tab_riwayat_base_ri").addClass('animation-loading');

        $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/srkGetLoadRiwayatSEPRI'); ?>', {
            nokartu: no_kartu
        }, function(data) {
            console.log(data, 'data');
            if (data.ok != 1) {
                myAlert(data.msg);
            } else {
                $(".tab_srk_riwayat_sep_ri").html(data.html);
            }
            $(".srk_tab_riwayat_base_ri").removeClass('animation-loading');
        }, 'json');
    }

    function rujukanSetKontrolDariSEP(nosep, diagnosa_kode = null, diagnosa_nama = null, tglsep = null) {
        <?php if (strtolower($this->id) == "sepasuransi") : ?>
            $("#ARRujukanbpjsT_no_rujukan").val(nosep);
            $('#ARSepT_jenisfaskes_1').prop('checked', true);
            $('#ARSepT_jenis_kunjungan').val(0);
            $('#ARSepT_asesmen_pelayanan').val("");
            $("#<?php echo CHtml::activeId($modRujukanBpjs, 'tanggal_rujukan') ?>").val(tglsep);
        <?php endif  ?>

        <?php if (strtolower($this->id) == "pendaftaranrawatjalan") : ?>
            $("#skdp").removeClass('hidden');
            $("#PPRujukanbpjsT_no_rujukan").val(nosep);
            $('#PPSepT_jenisfaskes_1').prop('checked', true);
            $('#PPSepT_jenis_kunjungan').val(0);
            $('#PPSepT_asesmen_pelayanan').val("");
            $("#<?php echo CHtml::activeId($modRujukanBpjs, 'tanggal_rujukan') ?>").val(tglsep);
        <?php endif  ?>

        var kodeppkpelayanan = '<?php echo Yii::app()->user->getState('ppkpelayanan'); ?>';
        var jenisfaskes = $('#<?php echo CHtml::activeId($modSep, 'jenisfaskes'); ?>');
        jenisfaskes.val(2);
        getBpjsPPKRujukan(kodeppkpelayanan);
        resetDiagnosaBpjs();
        setDiagnosaBpjs(diagnosa_kode, diagnosa_nama);




    }
</script>