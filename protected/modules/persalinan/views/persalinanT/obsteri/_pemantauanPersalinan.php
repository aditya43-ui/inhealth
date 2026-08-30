<div class="row">
    <div class="col-sm-12">
        <table class="table table-bordered table-consended">
            <thead>
                <tr>
                    <th>Jam Ke-</th>
                    <th>Waktu</th>
                    <th>Tekanan Darah</th>
                    <th>Nadi</th>
                    <th>Suhu</th>
                    <th>Tinggi Fundus Uteri</th>
                    <th>Kontraksi Uterus</th>
                    <th>Kandung Kemih</th>
                    <th>Pendarahan</th>
                    <th><?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array('class' => 'btn btn-danger', 'onclick' => 'tambahBarisPemantauan();')); ?></th>
                </tr>
            </thead>
            <tbody id="tab_pemantauan_kalaiv">
                <?php
                $det = PemantauankalaivT::model()->findAllByAttributes(array(
                    'pemeriksaankala_id' => $model->pemeriksaankala_id,
                ), array(
                    'order' => 'waktu',
                ));

                foreach ($det as $idx => $item) {
                    $item->waktu = MyFormatter::formatDateTimeForUser($item->waktu);
                    $item->suhu = number_format($item->suhu, 2, ",", "");
                    echo $this->renderPartial($this->path_view . "obsteri._rowPemantauan", array('model' => $item, 'i' => $idx), true);
                }

                ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    var row_pemantauan = <?php echo CJSON::encode(array('html' => $this->renderPartial($this->path_view . "obsteri._rowPemantauan", array('model' => new PemantauankalaivT, 'i' => 'ii'), true))); ?>;

    function tambahBarisPemantauan() {
        $("#tab_pemantauan_kalaiv").append(row_pemantauan.html);

        var last = $("#tab_pemantauan_kalaiv tr:last-child");

        renameInputPemantauan();

        $(last).find('.numbers-only').keyup(function() {
            setNumbersOnly(this);
        });
        $(last).find(".p_suhu").maskMoney({
            "defaultZero": true,
            "allowZero": true,
            "decimal": ",",
            "thousands": "",
            "precision": 2
        });
    }

    function hapusBarisPemantauan(obj) {
        $(obj).parents("tr").remove();
    }

    function renameInputPemantauan() {
        var idx = 0;
        $("#tab_pemantauan_kalaiv tr").each(function() {
            $(this).find(".date_pemantauan").prop("name", "PemantauankalaivT[" + idx + "][waktu]");
            $(this).find(".date_pemantauan").prop("id", "PemantauankalaivT_" + idx + "_waktu");
            $(this).find(".p_systolic").prop("name", "PemantauankalaivT[" + idx + "][systolic]");
            $(this).find(".p_diastolic").prop("name", "PemantauankalaivT[" + idx + "][diastolic]");
            $(this).find(".p_nadi").prop("name", "PemantauankalaivT[" + idx + "][nadi]");
            $(this).find(".p_suhu").prop("name", "PemantauankalaivT[" + idx + "][suhu]");
            $(this).find(".p_tinggi").prop("name", "PemantauankalaivT[" + idx + "][tinggi_fundus_uteri]");
            $(this).find(".p_kontraksi").prop("name", "PemantauankalaivT[" + idx + "][kontraksi_uterus]");
            $(this).find(".p_kantung").prop("name", "PemantauankalaivT[" + idx + "][kantung_kemih]");
            $(this).find(".p_darah").prop("name", "PemantauankalaivT[" + idx + "][darah_yang_keluar]");
            $(this).find(".jam_ke").prop("name", "PemantauankalaivT[" + idx + "][jam_ke]");
            

            $("#PemantauankalaivT_" + idx + "_waktu").datetimepicker(jQuery.extend({
                    showMonthAfterYear: false
                },
                jQuery.datepicker.regional['id'], {
                    'dateFormat': 'dd M yy',
                    'minDate': 'd',
                    'timeText': 'Waktu',
                    'hourText': 'Jam',
                    'minuteText': 'Menit',
                    'secondText': 'Detik',
                    'showSecond': true,
                    'timeOnlyTitle': 'Pilih   Waktu',
                    'timeFormat': 'hh:mm:ss',
                    'changeYear': true,
                    'changeMonth': true,
                    'showAnim': 'fold'
                }));
            $("#PemantauankalaivT_" + idx + "_waktu").parents(".input-append").find(".add-on").click(function() {
                $(last).find("#PemantauankalaivT_" + idx + "_waktu").focus();
            });

            idx++;
        });
    }

    $(document).ready(function() {
        $("#tab_pemantauan_kalaiv .p_suhu").maskMoney({
            "defaultZero": true,
            "allowZero": true,
            "decimal": ",",
            "thousands": "",
            "precision": 2
        });
    });
</script>