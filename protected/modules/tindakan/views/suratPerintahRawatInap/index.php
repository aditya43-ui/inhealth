<style>
    body {
        color: black !important;
    }

    h5 {
        color: black !important;
    }

    label {
        color: black !important;
    }

    .tab_header {
        width: 100%;
    }

    .pilihan_ijin,
    .pilihan_privasi {
        font-weight: bold;
        cursor: pointer;
    }

    p {
        text-align: justify;
    }


    .borderclass {
        border: 1px solid black;
    }

    .bordertopclass {
        border-top: 1px solid black;
    }

    .borderrightclass {
        border-right: 1px solid black;
    }

    .borderleftclass {
        border-left: 1px solid black;
    }

    .borderbottomclass {
        border-bottom: 1px solid black !important;
    }
</style>


<?php
$this->widget('bootstrap.widgets.BootAlert');

$modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
if (empty($modPasien)) {
    $modPasien = new PasienM;
}

?>

<?php echo $this->renderPartial($this->path_view . '_headerSurat'); ?>

<div id="form-isi-surat">
    <?php echo $this->renderPartial($this->path_view . '_isiSurat', [
        'model' => $model,
        'modPendaftaran' => $modPendaftaran,
        'modPasien' => $modPasien,
        // 'modAnamnesa'=>$modAnamnesa,    
    ], true); ?>
</div>

<p>
    * Coret yang tidak perlu
</p>

<script type="text/javascript">
    function print(caraprint) {
        <?php
        $idsurat = "";

        if (isset($_GET['sukses'])) {
            $idsurat = $_GET['suratperintahranap_id'];
        }
        ?>
        window.open('<?php echo $this->createUrl('print', array('pendaftaran_id' => $model->pendaftaran_id, 'suratperintahranap_id' => $model->suratperintahranap_id)); ?>&caraPrint=' + caraprint, 'printwin', 'left=100,top=100,width=860,height=480');
    }


    function printSPRI(caraprint) {

        const carabayar_id = $(".carabayar_id").val();

        <?php
        $idsurat = "";

        if (isset($_GET['sukses'])) {
            $idsurat = $_GET['suratperintahranap_id'];
        }
        ?>

        if (carabayar_id != '<?= Params::CARABAYAR_ID_BPJS ?>') {
                    myAlert("Surat Perintah Rencana Inap BPJS tidak tersedia untuk pasien dengan penjamin bukan BPJS");
        } else {
            window.open('<?php echo $this->createUrl('printSuratRencanaInapBpjs', array('pendaftaran_id' => $model->pendaftaran_id, 'suratperintahranap_id' => $model->suratperintahranap_id)); ?>&caraPrint=' + caraprint, 'printwin', 'left=100,top=100,width=860,height=480');
        }
    }

    function cekSpesialisVClaim() {
        const carabayar_id = $(".carabayar_id").val();

        if (carabayar_id != '<?= Params::CARABAYAR_ID_BPJS ?>') {
            myAlert("Pasien bukan penjamin BPJS!");
            $("#SuratperintahranapT_spesialissubspesialis_id").removeClass('animation-loading');
            var spesialis_id = $("#SuratperintahranapT_spesialissubspesialis_id").val();

            $.post('<?php echo $this->createUrl('loadDataDropdown'); ?>', {
                spesialis_id: spesialis_id
            }, function(data) {
                if (data.ok == 0) {
                    myAlert(data.msg);
                }

                $("#SuratperintahranapT_dpjp_id").html(data.html);
                $("#SuratperintahranapT_spesialissubspesialis_id").removeClass('animation-loading');

            }, 'json');
            return false;
        }

        <?php if (Yii::app()->user->getState('isbridging') != true) : ?>
            myAlert("Bridging BPJS Tidak Aktif, SPRI tidak akan terupdate ke BPJS !");
            $("#SuratperintahranapT_spesialissubspesialis_id").removeClass('animation-loading');
            return false;
        <?php else : ?>

            var sep_id = $("#PendaftaranT_sep_id").val();
            var no_kartu = $(".nokartu_bpjs").val();
            var spesialis_id = $("#SuratperintahranapT_spesialissubspesialis_id").val();
            var tgl = $("#SuratperintahranapT_tgl_rencanaranap").val();

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

            $("#SuratperintahranapT_spesialissubspesialis_id").addClass('animation-loading');

            $.post('<?php echo $this->createUrl('cekVClaimSpesialis'); ?>', {
                no_kartu: no_kartu,
                spesialis_id: spesialis_id,
                tgl: tgl
            }, function(data) {
                if (data.ok == 0) {
                    myAlert(data.msg);
                }

                $("#SuratperintahranapT_dpjp_id").html(data.html);
                $("#SuratperintahranapT_spesialissubspesialis_id").removeClass('animation-loading');

            }, 'json');


        <?php endif; ?>
    }

    function changeGenerateNomor(obj) {
        var instalasi_id = $('#<?php echo Chtml::activeId($model, 'instalasi_id') ?>').val();
        var isranap_perinatologi = true;

        if ($(obj).is(':checked') === false) {
            isranap_perinatologi = false;
        }

        $.ajax({
            url: "<?php echo $this->createUrl('generateNomor'); ?>",
            dataType: "json",
            type: 'POST',
            data: {
                instalasi_id: instalasi_id,
                isranap_perinatologi: isranap_perinatologi
            },
            success: function(data) {
                if (data != null) {
                    $('#<?php echo Chtml::activeId($model, 'nomorsurat') ?>').val(data.nomorsurat);
                    $('#<?php echo Chtml::activeId($model, 'nourutsurat') ?>').val(data.nourut);
                }
            }
        })
    }

    function loadDataPasienDariKartu() {
        var nomor = $("#PasienM_no_identitas_pasien").val();

        $(".nokartu_bpjs").addClass("animation-loading");

        $.post('<?php echo $this->createUrl('loadNomorKartuDariNIK'); ?>', {
            nomor: nomor
        }, function(data) {
            if (data.ok == 0) {
                myAlert(data.msg);
            } else {
                $(".nokartu_bpjs").val(data.peserta.noKartu);
            }
            $(".nokartu_bpjs").removeClass("animation-loading");
        }, 'json');
    }

    $(document).ready(function() {
        cekSpesialisVClaim()
    });
</script>