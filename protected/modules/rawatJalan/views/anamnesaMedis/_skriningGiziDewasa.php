<style>
    .tab_skrining th,
    .tab_skrining td {
        color: black;
        border: 1px solid black;
        padding: 2px;
    }

    .tab_skrining th {
        text-align: center;
        font-weight: bold;
    }

    .tab_skrining tfoot td {
        font-weight: bold;
    }

    .pilih_center {
        text-align: center;
    }
</style>

<div class="panel panel-default panel_skrining" id="skrining_gizi_dewasa" style="margin: 17px 0;" hidden>
    <div class="panel-heading">
        <div class="panel-title">
            <?php echo $form->checkBox($modAnamnesa, 'skrining_dewasa', array('id' => 'cek_dewasa', 'class' => 'cek_skrining')); ?>
            Skrining Gizi Dewasa
        </div>
    </div>
    <div class="panel-body">
        <table width="100%" class="tab_skrining">
            <thead>
                <tr>
                    <th rowspan="2">No.</th>
                    <th rowspan="2">Kriteria.</th>
                    <th colspan="2">Jawaban</th>
                </tr>
                <tr>
                    <th>Ya<br>Skor=1</th>
                    <th>Tidak<br>Skor=0</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="10">1</td>
                    <td>Apakah IMT < 20,5 atau LLA < 25 cm untuk wanita dan LLA < 26,3 cm untuk pria ?</td>
                    <td class="pilih_center" width="50"><?php echo $form->radioButton($modAnamnesa, 'skrining_dewasa_kriteria1', array('uncheckValue' => null, 'value' => 1, 'class' => 'pilih-skrining')); ?></td>
                    <td class="pilih_center" width="50"><?php echo $form->radioButton($modAnamnesa, 'skrining_dewasa_kriteria1', array('uncheckValue' => null, 'value' => 0, 'class' => 'pilih-skrining')); ?></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Apakah pasien kehilangan BB dalam 3 minggu terakhir ?</td>
                    <td class="pilih_center"><?php echo $form->radioButton($modAnamnesa, 'skrining_dewasa_kriteria2', array('uncheckValue' => null, 'value' => 1, 'class' => 'pilih-skrining')); ?></td>
                    <td class="pilih_center"><?php echo $form->radioButton($modAnamnesa, 'skrining_dewasa_kriteria2', array('uncheckValue' => null, 'value' => 0, 'class' => 'pilih-skrining')); ?></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Apakah asupan makan pasien menurun hingga 1 minggu terakhir ?</td>
                    <td class="pilih_center"><?php echo $form->radioButton($modAnamnesa, 'skrining_dewasa_kriteria3', array('uncheckValue' => null, 'value' => 1, 'class' => 'pilih-skrining')); ?></td>
                    <td class="pilih_center"><?php echo $form->radioButton($modAnamnesa, 'skrining_dewasa_kriteria3', array('uncheckValue' => null, 'value' => 0, 'class' => 'pilih-skrining')); ?></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Apakah pasien dengan penyakit berat dan atau membutuhkan terapi gizi ?</td>
                    <td class="pilih_center"><?php echo $form->radioButton($modAnamnesa, 'skrining_dewasa_kriteria4', array('uncheckValue' => null, 'value' => 1, 'class' => 'pilih-skrining')); ?></td>
                    <td class="pilih_center"><?php echo $form->radioButton($modAnamnesa, 'skrining_dewasa_kriteria4', array('uncheckValue' => null, 'value' => 0, 'class' => 'pilih-skrining')); ?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td>TOTAL SKOR</td>
                    <td colspan="2"><?php echo $form->textField($modAnamnesa, 'skrining_dewasa_skor', array('readonly' => true, 'class' => 'span2 skor-skrining')); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">HASIL : <?php echo $form->textField($modAnamnesa, 'skrining_dewasa_hasil', array(
                                                'readonly' => true, 'class' => 'hasil-skrining span4',
                                                'data-kurang' => 'Skrining diulang 1 bulan kemudian', 'data-lebih' => 'Rujuk/Konsul Ahli Gizi'
                                            )); ?></td>
                </tr>

            </tfoot>
        </table>
    </div>
</div>

<div class="panel panel-default panel_skrining" id="skrining_gizi_anak" hidden>
    <div class="panel-heading">
        <div class="panel-title">
            <?php echo $form->checkBox($modAnamnesa, 'skrining_anak', array('id' => 'cek_anak', 'class' => 'cek_skrining')); ?>
            Skrining Gizi Anak
        </div>
    </div>
    <div class="panel-body">
        <table width="100%" class="tab_skrining">
            <thead>
                <tr>
                    <th rowspan="2">No.</th>
                    <th rowspan="2">Kriteria.</th>
                    <th colspan="2">Jawaban</th>
                </tr>
                <tr>
                    <th>Ya<br>Skor=1</th>
                    <th>Tidak<br>Skor=0</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="10">1</td>
                    <td>Apakah IMT anak berada dibawah nilai cut-off tabel IMT rujukan ?</td>
                    <td class="pilih_center" width="50"><?php echo $form->radioButton($modAnamnesa, 'skrining_anak_kriteria1', array('uncheckValue' => null, 'value' => 1, 'class' => 'pilih-skrining')); ?></td>
                    <td class="pilih_center" width="50"><?php echo $form->radioButton($modAnamnesa, 'skrining_anak_kriteria1', array('uncheckValue' => null, 'value' => 0, 'class' => 'pilih-skrining')); ?></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Apakah anak mengalami penurunan berat badan akhir-akhir ini ? (Seperti penurunan BB Tidak disengaja, baju menjadi lebih longgar, kenaikan BB tidak signifikan (jika <2 tahun))</td>
                    <td class="pilih_center"><?php echo $form->radioButton($modAnamnesa, 'skrining_anak_kriteria2', array('uncheckValue' => null, 'value' => 1, 'class' => 'pilih-skrining')); ?></td>
                    <td class="pilih_center"><?php echo $form->radioButton($modAnamnesa, 'skrining_anak_kriteria2', array('uncheckValue' => null, 'value' => 0, 'class' => 'pilih-skrining')); ?></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Apakah anak mengalami penurunan intake makanan (termasuk ASI dan susu formula) setidaknya selama 1 minggu terakhir ?</td>
                    <td class="pilih_center"><?php echo $form->radioButton($modAnamnesa, 'skrining_anak_kriteria3', array('uncheckValue' => null, 'value' => 1, 'class' => 'pilih-skrining')); ?></td>
                    <td class="pilih_center"><?php echo $form->radioButton($modAnamnesa, 'skrining_anak_kriteria3', array('uncheckValue' => null, 'value' => 0, 'class' => 'pilih-skrining')); ?></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Apakah status gizi anak akan dipengaruhi oleh penyakit/kondisi kesehatan setidaknya untuk 1 minggu kedepan ?</td>
                    <td class="pilih_center"><?php echo $form->radioButton($modAnamnesa, 'skrining_anak_kriteria4', array('uncheckValue' => null, 'value' => 1, 'class' => 'pilih-skrining')); ?></td>
                    <td class="pilih_center"><?php echo $form->radioButton($modAnamnesa, 'skrining_anak_kriteria4', array('uncheckValue' => null, 'value' => 0, 'class' => 'pilih-skrining')); ?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td>TOTAL SKOR</td>
                    <td colspan="2"><?php echo $form->textField($modAnamnesa, 'skrining_anak_skor', array('readonly' => true, 'class' => 'span2 skor-skrining')); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">HASIL : <?php echo $form->textField($modAnamnesa, 'skrining_anak_hasil', array(
                                                'readonly' => true, 'class' => 'hasil-skrining span4',
                                                'data-kurang' => 'Tidak beresiko malnutrisi', 'data-lebih' => 'Beresiko malnutrisi -> Rujuk/Konsul Ahli Gizi'
                                            )); ?></td>
                </tr>

            </tfoot>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        hitungSkriningGizi();
        pilihSkriningGizi();
    });

    $(".pilih-skrining").click(hitungSkriningGizi);
    $(".cek_skrining").click(pilihSkriningGizi);

    function pilihSkriningGizi() {

        if ($(this).prop("id") != null) {
            var name = $(this).prop("id");

            $(".cek_skrining").not("#" + name).prop("checked", false);
        }

        $(".panel_skrining").each(function() {
            if ($(this).find(".cek_skrining").is(":checked")) {
                $(this).find(".panel-body").show().find("input").prop("disabled", false);
            } else {
                $(this).find(".panel-body").hide().find("input").prop("disabled", true);
            }
        });
    }

    function hitungSkriningGizi() {
        $(".panel_skrining").each(function() {
            var obj = $(this);
            var total = 0;
            var var_name = $(this).prop("id");

            $(obj).find(".pilih-skrining:checked").each(function() {
                total += parseInt($(this).val());
            });

            if (var_name == "skrining_gizi_dewasa") {
                if (total > 0) {
                    $(obj).find(".hasil-skrining").val($(".hasil-skrining").data('lebih'));
                } else {
                    $(obj).find(".hasil-skrining").val($(".hasil-skrining").data('kurang'));

                }
            }
            if (var_name == "skrining_gizi_anak") {
                if (total < 2) {
                    $(obj).find(".hasil-skrining").val($(obj).find(".hasil-skrining").data('kurang'));
                } else {
                    $(obj).find(".hasil-skrining").val($(obj).find(".hasil-skrining").data('lebih'));

                }
            }

            $(obj).find(".skor-skrining").val(total);


        });
    }
</script>