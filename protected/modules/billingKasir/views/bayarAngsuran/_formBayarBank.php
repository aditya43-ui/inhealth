<?php
$modJenis = new JenispembayaranT();
?>

<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>Jenis Pembayaran</th>
            <th>Nominal</th>
            <th width="10">
                <?php
                echo CHtml::link('<i class="entypo-plus"></i>', '#', array(
                    'onclick' => 'tambahBayar(); return false;',
                    'class' => 'btn btn-green'
                ));
                ?>
            </th>
        </tr>
    </thead>
    <tbody id="tab_jenispembayaran">
    </tbody>
</table>

<script>

    var row = <?php
        echo CJSON::encode($this->renderPartial($this->path_view . "jenis._rowJenis", array(
                'modJenis' => $modJenis,
                'i' => 0,
                ), true));
        ?>


    function hapusBayar(obj) {
        var idx = $(obj).parents("tr").data("idx");
        $('#tab_jenispembayaran tr[data-idx="' + idx + '"]').remove();

        renameInput();
        cekBayarBank();
    }

    function tambahBayar() {
        $("#tab_jenispembayaran").append(row);

        var last_main = $("#tab_jenispembayaran").find(".row_main:last");
        var last_detail = $("#tab_jenispembayaran").find(".row_detail:last");
        last_main.find(".main_nominal").maskMoney(
                {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 0}
        );



        renameInput();
        cekBayarBank();
        jQuery(last_detail).find(".tgltransaksi").datetimepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold','yearRange':'-80y:+20y'}));
        jQuery(last_detail).find(".tgljatuhtempo").datetimepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold','yearRange':'-80y:+20y'}));


        pilihJenis(last_main.find(".main_jenis"));

        setOtomatisNominal($(last_main).find(".main_nominal"));


    }

    function renameInput() {
        var idx = 0;
        $("#tab_jenispembayaran .row_main").each(function () {
            $(this).data('idx', idx);
            $(this).attr("data-idx", idx);

            $(this).find(".main_jenis").prop("name", "JenispembayaranT[detail][" + idx + "][jenispembayaran]");
            $(this).find(".main_nominal").prop("name", "JenispembayaranT[detail][" + idx + "][jumlahpembayaran]");

            idx++;
        });

        var idx = 0;
        $("#tab_jenispembayaran .row_detail").each(function () {
            $(this).data('idx', idx);
            $(this).attr("data-idx", idx);

            $(this).find(".pemilikgopay").prop("name", "JenispembayaranT[detail][" + idx + "][pemilikgopay]");
            $(this).find(".nogopay").prop("name", "JenispembayaranT[detail][" + idx + "][nogopay]");
            $(this).find(".alamatemailgopay").prop("name", "JenispembayaranT[detail][" + idx + "][alamatemailgopay]");

            $(this).find(".pemilikovo").prop("name", "JenispembayaranT[detail][" + idx + "][pemilikovo]");
            $(this).find(".noovo").prop("name", "JenispembayaranT[detail][" + idx + "][noovo]");
            $(this).find(".kodetransaksi").prop("name", "JenispembayaranT[detail][" + idx + "][kodetransaksi]");
            $(this).find(".noreferensi").prop("name", "JenispembayaranT[detail][" + idx + "][noreferensi]");

            $(this).find(".pemilikvirtualaccount").prop("name", "JenispembayaranT[detail][" + idx + "][pemilikvirtualaccount]");
            $(this).find(".norekening").prop("name", "JenispembayaranT[detail][" + idx + "][norekening]");
            $(this).find(".namavirtualaccountpenerima").prop("name", "JenispembayaranT[detail][" + idx + "][namavirtualaccountpenerima]");
            $(this).find(".novirtualaccount").prop("name", "JenispembayaranT[detail][" + idx + "][novirtualaccount]");

            $(this).find(".bank").prop("name", "JenispembayaranT[detail][" + idx + "][bank]");
            $(this).find(".pemilikkartu").prop("name", "JenispembayaranT[detail][" + idx + "][pemilikkartu]");
            $(this).find(".nokartu").prop("name", "JenispembayaranT[detail][" + idx + "][nokartu]");
            $(this).find(".nostruk").prop("name", "JenispembayaranT[detail][" + idx + "][nostruk]");
            $(this).find(".bankpenerima_id").prop("name", "JenispembayaranT[detail][" + idx + "][bankpenerima_id]");

            // $(this).find(".profilrs_id").prop("name", "JenispembayaranT[detail][" + idx + "][profilrs_id]");
            $(this).find(".tgltransaksi").prop("name", "JenispembayaranT[detail][" + idx + "][tgltransaksi]");
            $(this).find(".tgltransaksi").prop("id", "JenispembayaranT_detail_" + idx + "_tgltransaksi");

            $(this).find(".tgljatuhtempo").prop("name", "JenispembayaranT[detail][" + idx + "][tgljatuhtempo]");
            $(this).find(".tgljatuhtempo").prop("id", "JenispembayaranT_detail_" + idx + "_tgljatuhtempo");



            idx++;
        });


    }


    function pilihJenis(obj) {
        var idx = $(obj).parents("tr").data("idx");
        var detail = $('#tab_jenispembayaran tr[data-idx="' + idx + '"][class="row_detail"]');
        var jenis = $(obj).val();

        var ispiutangbank = $(obj).find(":selected").data('ispiutangbank');
        var ispembayarandigital = $(obj).find(":selected").data('ispembayarandigital');
        var rekening = $(obj).find(":selected").data('rekening');
        var tgljatuhtempo = $(obj).find(":selected").data('tgljatuhtempo');

        var is_ada = false;
        $(".main_jenis").not(obj).each(function () {
            if ($(this).val() != "" && $(this).val() == jenis) {
                is_ada = true;
            }
        });

        $(detail).find(".panel_jenispembayaran").hide();
        $(detail).find(".panel_jenispembayaran :input").prop("disabled", true);

        if (is_ada) {
            myAlert("Jenis Pembayaran sudah dipilih sebelumnya");
            $(obj).val("");
            return false;
        }


        console.log("JENIS BAYAR", jenis, detail, $(detail).find(".panel_jenispembayaran_debit"));

        if (ispiutangbank == 1) {
            $(detail).find(".panel_jenispembayaran_debit").show();
            $(detail).find(".panel_jenispembayaran_debit :input").attr("disabled", false);
            $(detail).find(".panel_jenispembayaran_debit .tgljatuhtempo").val(tgljatuhtempo);

            $.post('<?php echo $this->createUrl('listBayarBank'); ?>', {id: jenis}, function(data) {
                $(detail).find(".panel_jenispembayaran_debit .bankpenerima_id").html(data.list);
            }, 'json');
        }

        if (ispembayarandigital == 1) {
            $(detail).find(".panel_jenispembayaran_digital").show();
            $(detail).find(".panel_jenispembayaran_digital :input").attr("disabled", false);

            $(detail).find(".panel_jenispembayaran_digital .bayar_kodeakun").val(rekening);
            $(detail).find(".panel_jenispembayaran_digital .tgljatuhtempo").val(tgljatuhtempo);
        }


    }


    function setKodeAkunBankMulti(obj) {
        var data = $(obj).find(":selected").data('rekening');
        $(obj).parents(".panel_jenispembayaran_debit").find(".kode_akun_bank").val(data);
    }

</script>
