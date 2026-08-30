<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/ckeditor/ckeditor.js', CClientScript::POS_END);

$this->breadcrumbs = array(
    'Ringkasan Masuk dan Keluar',
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan");
}
$this->widget('bootstrap.widgets.BootAlert');

?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title" style="width: 100%">
            <b>Ringkasan Masuk dan Keluar</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'frm-ringkasanmasukkeluar',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
        ?>
        <?php echo $form->hiddenField($model, 'pendaftaran_id'); ?>
        <?php echo $form->hiddenField($model, 'pasienadmisi_id'); ?>

        <?= $this->renderPartial($this->path_view . 'form/_1_dataPasien', [
            'model' => $model,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
            'form' => $form,
            'modPasienPulang' => $modPasienPulang
        ], true) ?>
        <hr />

        <?= $this->renderPartial($this->path_view . 'form/_9_dataRingkasanMasukKeluar', [
            'modRi' => $modRi,
        ], true) ?>

        <hr>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><strong>Data Ringkasan</strong></div>
            </div>
            <div class="panel-body">

                <?= $this->renderPartial($this->path_view . 'form/_2_dataRingkasan', [
                    'model' => $model,
                    'form' => $form,
                ], true) ?>
                <hr />
                <?= $this->renderPartial($this->path_view . 'form/_3_dataPemeriksaanUmum', [
                    'model' => $model,
                    'form' => $form,
                ], true) ?>
                <hr />
                <?= $this->renderPartial($this->path_view . 'form/_4_dataPengobatanDiRS', [
                    'model' => $model,
                    'form' => $form,
                ], true) ?>
                <hr />
                <?= $this->renderPartial($this->path_view . 'form/_5_dataDiagnosis', [
                    'model' => $model,
                    'form' => $form,
                ], true) ?>
                <hr />
                <?= $this->renderPartial($this->path_view . 'form/_7_dataLainLain', [
                    'model' => $model,
                    'form' => $form,
                ], true) ?>
                <hr />
                <?= $this->renderPartial($this->path_view . 'form/_8_dataSumberInformasi', [
                    'model' => $model,
                    'form' => $form,
                ], true) ?>
                <hr />

            </div>
        </div>

        <div class="row-fluid">
            <div class="form-actions">
                <?php
                $disableSimpan = (isset($_GET['sukses']) ? true : false);

                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('id' => 'btn-submit', 'class' => 'btn btn-danger', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'disabled' => $disableSimpan, 'onclick' => 'cekForm();'));
                echo "&nbsp;";
                echo CHtml::link(
                    Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index/&pendaftaran_id=' . $_GET['pendaftaran_id']),
                    array(
                        'class' => 'btn btn-default',
                        'onclick' => 'return refreshForm(this);'
                    )
                );
                echo "&nbsp;";
                $riwayat_id = isset($_GET['ringkasanmasukdankeluar_id']) ? $_GET['ringkasanmasukdankeluar_id'] : "";
                echo CHtml::Link(
                    Yii::t('mds', '{icon} Print Ringkasan Masuk dan Keluar', array('{icon}' => '<i class="icon-print icon-white"></i>')),
                    Yii::app()->controller->createUrl("/rawatInap/RingkasanMasukKeluar/print", array("id" => $riwayat_id, "frame" => true)),
                    array(
                        "class" => "btn btn-info",
                        "target" => "iframeRincianPasienPulang",
                        "onclick" => "$(\"#dialogRincianPasienPulang\").dialog(\"open\");",
                        "rel" => "tooltip",
                        "title" => "Klik untuk Cetak Riwayat Ringkasan Pasien Pulang",
                        'disabled' => (($disableSimpan == true) ? false : true)

                    )
                );
                // echo CHtml::link(Yii::t('mds', '{icon} Print Ringkasan Masuk dan Keluar', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print();", 'disabled' => (($disableSimpan == true) ? false : true)));
                ?>
                <?php
                $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
                $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
                ?>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>

<script type="text/javascript">
    function print() {
        var ringkasanmasukdankeluar_id = '<?php echo (isset($_GET['ringkasanmasukdankeluar_id']) ? $_GET['ringkasanmasukdankeluar_id'] : "") ?>';
        window.open('<?php echo $this->createUrl('/rawatInap/RingkasanMasukKeluar/print'); ?>&id=' + ringkasanmasukdankeluar_id, 'printwin', 'left=100,top=100,width=793,height=1122,scrollbars=yes');
    }

    $(document).ready(function() {
        $(".errorMessage").hide();
        $(".set-dis").find("input:checkbox").click(function() {
            set_dis($(this));

            if ($(this).parents(".control-group").hasClass("tindak-lanjut-cek")) {
                cekTindakLanjut();
            } else if ($(this).parents(".control-group").hasClass("cara-keluar-cek")) {
                cekCaraKeluar();
            }
        });

        $(".set-dis").find("input:checkbox").each(function() {
            set_dis($(this));
        });

        // setEventPilihTindakan();

        cekTindakLanjut();
        cekCaraKeluar();

        // loadPilihTindakan();
        CKEDITOR.replace('pemeriksaanfisik', {
            extraPlugins: 'colorbutton,colordialog',
            toolbarGroups: [{
                    "name": "basicstyles",
                    "groups": ["basicstyles", "align", "spacings", "colors"]
                },
                {
                    "name": "paragraph",
                    "groups": ["list", "blocks"]
                },
                {
                    "name": "styles",
                    "groups": ["styles"]
                }
            ]
        });

        const attrCkEditor = ['tindakanyangdipilih', 'diagnosisprimer', 'terapipulang', 'pemeriksaanpenunjang', 'terapiselamadirs', 'diagnosissekunder', 'icd10', 'icd9'];

        attrCkEditor.forEach(function(value, index) {
            CKEDITOR.replace(value, {
                extraPlugins: 'colorbutton,colordialog',
                toolbarGroups: [{
                        "name": "basicstyles",
                        "groups": ["basicstyles", "align", "spacings", "colors"]
                    },
                    {
                        "name": "paragraph",
                        "groups": ["list", "blocks"]
                    },
                    {
                        "name": "styles",
                        "groups": ["styles"]
                    }
                ]
            });
        });
    });

    const cekForm = () => {
        var data = $(".nama_dokter").val();
        console.log("data", data);
        if (requiredCheck($("frm-ringkasanmasukkeluar"))) {
            $(".salahsatu:not(:checked)").attr("disabled", true);
            if (data == null || data == '') {
                window.scrollTo(0, 100);
                $(".errorMessage").show();
                myAlert('Silakan isi tanda yang berbintang <span style="color:red;">*</span> !')
            } else {
                $("#frm-ringkasanmasukkeluar").submit();
                disableOnSubmit($("#btn-submit"));
            }

            // var data = <?php //echo $model->dokter_yangmerawat_nama; 
                            ?>

            // return false 

        }
    }



    // function ceklisPilihTindakan() {
    //     data_pilih[$(this).val()] = $(this).is(":checked") ? 1 : 0;
    //     $(".input_tindakanyangdipilih").val(JSON.stringify(data_pilih));
    // }

    // function setEventPilihTindakan() {
    //     $("#tindakan-grid .cb_pilih_tindakan").on("click", ceklisPilihTindakan);
    // }

    // function loadPilihTindakan() {
    //     console.log("loader");
    //     $.each(data_pilih, function(idx, v) {
    //         //              console.log("Kick");
    //         //              console.log(idx, v, $("#tindakan-grid .pilih_tindakan_" + idx));
    //         if (v == 1) {
    //             $("#tindakan-grid .pilih_tindakan_" + idx).attr("checked", true);
    //         } else {
    //             $("#tindakan-grid .pilih_tindakan_" + idx).attr("checked", false);
    //         }
    //     });
    // }

    const cekTindakLanjut = () => {
        const obj = $(".tindak-lanjut-cek").find("input:checkbox:checked");
        const value = obj.attr('value');

        $("#tglkontrol").attr("disabled", true);
        $("#tglkontrol").parents(".control-group").find(".add-on").addClass("hide");
        if (obj.prop("checked") && (value).toLowerCase() == 'kontrol rawat jalan') {
            $("#tglkontrol").removeAttr("disabled");
            $("#tglkontrol").parents(".control-group").find(".add-on").removeClass("hide");
        }
    }

    const cekCaraKeluar = () => {
        const obj = $(".cara-keluar-cek").find("input:checkbox:checked");
        const value = obj.attr('value');
        $("#lainlain").attr("disabled", true);
        if (obj.prop("checked") && (value).toLowerCase() == 'lain-lain') {
            $("#lainlain").removeAttr("disabled");
        }
    }
</script>