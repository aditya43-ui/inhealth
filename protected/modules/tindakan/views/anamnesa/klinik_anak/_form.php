<?php
$modAnamnesa->anamnesa_anak = true;
$modAnamnesa->kebiasaan_menghisap_jari = 0;
$modAnamnesa->kebiasaan_pakai_dot = 0;

echo $form->hiddenField($modAnamnesa, 'anamnesa_anak');
?>

<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Riwayat Vaksinasi</div>
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-condensed">
                <tr>
                    <th rowspan="2">Jenis</th>
                    <th rowspan="2">1</th>
                    <th rowspan="2">2</th>
                    <th rowspan="2">3</th>
                    <th colspan="3">Booster</th>
                </tr>
                <tr>
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>
                </tr>
                <tr>
                    <td>BCG</td>
                    <td><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[bcg][1]', array('class' => 'span1 numbers-only')); ?></td>
                    <td colspan="2"><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[bcg][2]', array('class' => 'span1 numbers-only')); ?></td>
                    <td colspan="3"><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[bcg][booster][1]', array('class' => 'span1 numbers-only')); ?></td>
                </tr>
                <tr>
                    <td>DPT</td>
                    <td><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[dpt][1]', array('class' => 'span1 numbers-only')); ?></td>
                    <td><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[dpt][2]', array('class' => 'span1 numbers-only')); ?></td>
                    <td><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[dpt][3]', array('class' => 'span1 numbers-only')); ?></td>
                    <td><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[dpt][booster][1]', array('class' => 'span1 numbers-only')); ?></td>
                    <td><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[dpt][booster][2]', array('class' => 'span1 numbers-only')); ?></td>
                    <td><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[dpt][booster][3]', array('class' => 'span1 numbers-only')); ?></td>
                </tr>
                <tr>
                    <td>Polio</td>
                    <td><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[polio][1]', array('class' => 'span1 numbers-only')); ?></td>
                    <td><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[polio][2]', array('class' => 'span1 numbers-only')); ?></td>
                    <td><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[polio][3]', array('class' => 'span1 numbers-only')); ?></td>
                    <td><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[polio][booster][1]', array('class' => 'span1 numbers-only')); ?></td>
                    <td><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[polio][booster][2]', array('class' => 'span1 numbers-only')); ?></td>
                    <td><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[polio][booster][3]', array('class' => 'span1 numbers-only')); ?></td>
                </tr>
                <tr>
                    <td>Campak</td>
                    <td colspan="3"><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[campak][1]', array('class' => 'span1 numbers-only')); ?></td>
                    <td colspan="3"><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[campak][booster][1]', array('class' => 'span1 numbers-only')); ?></td>
                </tr>
                <tr>
                    <td>MMR</td>
                    <td colspan="3"><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[mmr][1]', array('class' => 'span1 numbers-only')); ?></td>
                    <td colspan="3"><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[mmr][booster][1]', array('class' => 'span1 numbers-only')); ?></td>
                </tr>
                <tr>
                    <td>HB</td>
                    <td><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[hb][1]', array('class' => 'span1 numbers-only')); ?></td>
                    <td><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[hb][2]', array('class' => 'span1 numbers-only')); ?></td>
                    <td><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[hb][3]', array('class' => 'span1 numbers-only')); ?></td>
                    <td><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[hb][booster][1]', array('class' => 'span1 numbers-only')); ?></td>
                    <td><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[hb][booster][2]', array('class' => 'span1 numbers-only')); ?></td>
                    <td><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[hb][booster][3]', array('class' => 'span1 numbers-only')); ?></td>
                </tr>
                <tr>
                    <td>Lain2</td>
                    <td><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[lain2][1]', array('class' => 'span1 numbers-only')); ?></td>
                    <td><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[lain2][2]', array('class' => 'span1 numbers-only')); ?></td>
                    <td><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[lain2][3]', array('class' => 'span1 numbers-only')); ?></td>
                    <td><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[lain2][booster][1]', array('class' => 'span1 numbers-only')); ?></td>
                    <td><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[lain2][booster][2]', array('class' => 'span1 numbers-only')); ?></td>
                    <td><?php echo $form->textField($modAnamnesa, 'riwayat_vaksinasi[lain2][booster][3]', array('class' => 'span1 numbers-only')); ?></td>
                </tr>

            </table>
        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                Kebiasaan
            </div>
        </div>
        <div class="panel-body">
            <div class="control-group">
                <label class="control-label">Menghisap Jari</label>
                <div class="controls">
                    <?php echo CHtml::activeRadioButtonList($modAnamnesa, 'kebiasaan_menghisap_jari', array(1 => "Ya", 0 => "Tidak")); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Pakai Dot</label>
                <div class="controls">
                    <?php echo CHtml::activeRadioButtonList($modAnamnesa, 'kebiasaan_pakai_dot', array(1 => "Ya", 0 => "Tidak")); ?>
                </div>
            </div>
        </div>

    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                Kemampuan Pergerakan
            </div>
        </div>
        <div class="panel-body">
            <div class="control-group">
                <label class="control-label">Kemampuan Pergerakan</label>
                <div class="controls">
                    <?php echo CHtml::activeRadioButtonList($modAnamnesa, 'kemampuan_pergerakan', array("Baik" => "Baik", "Cukup" => "Cukup", "Kurang" => "Kurang")); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Tangisan</label>
                <div class="controls">
                    <?php echo CHtml::activeRadioButtonList($modAnamnesa, 'tangisan', array(
                        "Keras" => "Keras",
                        "Cukup" => "Cukup",
                        "Kurang" => "Kurang",
                        "Lemah" => "Lemah",
                        "Tidak Menangis" => "Tidak Menangis",
                    )); ?>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                Nutrisi
            </div>
        </div>
        <div class="panel-body">
            <div class="control-group">
                <label class="control-label">BB</label>
                <div class="controls">
                    <?php echo $form->textField($modAnamnesa, 'nutrisi_beratbadan', array('class' => 'span1 angkacoma-only')) . " Kg"; ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">TB</label>
                <div class="controls">
                    <?php echo $form->textField($modAnamnesa, 'nutrisi_tinggibadan', array('class' => 'span1 angkacoma-only')) . " cm"; ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Tipe Makanan</label>
                <div class="controls">
                    <?php echo CHtml::activeCheckBoxList($modAnamnesa, 'nutrisi_tipemakan', array(
                        'ASI' => 'ASI',
                        'Bubur Susu' => 'Bubur Susu',
                        'Susu Formula' => 'Susu Formula',
                        'ASI+Susu Formula' => 'ASI+Susu Formula',
                        'Makanan Saring' => 'Makanan Saring',
                        'Makanan Padat' => 'Makanan Padat',
                    )); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->label($modAnamnesa, 'nutrisi_makanan_suka', array('class' => 'control-label', 'label' => 'Makanan yang disukai')); ?>
                <div class="controls">
                    <?php echo $form->textArea($modAnamnesa, 'nutrisi_makanan_suka', array('class' => 'span3')); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->label($modAnamnesa, 'nutrisi_makanan_tdk_suka', array('class' => 'control-label', 'label' => 'Makanan yang tidak disukai')); ?>
                <div class="controls">
                    <?php echo $form->textArea($modAnamnesa, 'nutrisi_makanan_tdk_suka', array('class' => 'span3')); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Kondisi yang Perlu Dikaji</label>
                <div class="controls">
                    <?php echo CHtml::activeCheckBoxList($modAnamnesa, 'nutrisi_kondisi', array(
                        'Diare' => 'Diare',
                        'Konstipasi' => 'Konstipasi',
                        'Mual dan Muntah' => 'Mual dan Muntah',
                        'Penurunan Nafsu Makan' => 'Penurunan Nafsu Makan',
                        'Demam' => 'Demam',
                        'Penurunan BB' => 'Penurunan BB',
                    )); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                Eliminasi
            </div>
        </div>
        <div class="panel-body">
            <div class="control-group">
                <label class="control-label">Buang Air Besar</label>
                <div class="controls">
                    <?php echo $form->checkBox($modAnamnesa, 'eliminasi_buangairbesar[]', array('value' => 'TAK', 'uncheckValue' => null)) . CHtml::label("TAK", "") ?><br>
                    <?php echo $form->checkBox($modAnamnesa, 'eliminasi_buangairbesar[]', array('value' => 'Feses Berdarah', 'uncheckValue' => null)) . CHtml::label("Feses Berdarah", "") ?><br>
                    <?php echo $form->checkBox($modAnamnesa, 'eliminasi_buangairbesar[]', array('value' => 'Kolostomi', 'uncheckValue' => null)) . CHtml::label("Kolostomi", "") ?><br>
                    <?php echo $form->checkBox($modAnamnesa, 'eliminasi_buangairbesar[]', array('value' => 'Konstipasi', 'uncheckValue' => null)) . CHtml::label("Konstipasi", "") ?><br>
                    <?php echo $form->checkBox($modAnamnesa, 'eliminasi_buangairbesar[]', array('value' => 'Diare', 'uncheckValue' => null)) . CHtml::label("Diare", "") ?>
                    <?php echo $form->textField($modAnamnesa, 'eliminasi_buangairbesar_diarehari', array('class' => 'span1 numbers-only')) . CHtml::label(" X/Hari", "") ?><br>
                    <?php echo $form->checkBox($modAnamnesa, 'eliminasi_buangairbesar[]', array('value' => 'Lain-Lain', 'uncheckValue' => null)) . CHtml::label("Lain-Lain", "") ?>
                    <?php echo $form->textField($modAnamnesa, 'eliminasi_buangairbesar_lain2', array('class' => 'span4')) ?><br>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Buang Air Kecil</label>
                <div class="controls">
                    <?php echo $form->checkBox($modAnamnesa, 'eliminasi_buangairkecil[]', array('value' => 'TAK', 'uncheckValue' => null)) . CHtml::label("TAK", "") ?><br>
                    <?php echo $form->checkBox($modAnamnesa, 'eliminasi_buangairkecil[]', array('value' => 'Oliguria', 'uncheckValue' => null)) . CHtml::label("Oliguria", "") ?><br>
                    <?php echo $form->checkBox($modAnamnesa, 'eliminasi_buangairkecil[]', array('value' => 'Poliuria', 'uncheckValue' => null)) . CHtml::label("Poliuria", "") ?><br>
                    <?php echo $form->checkBox($modAnamnesa, 'eliminasi_buangairkecil[]', array('value' => 'Disuria', 'uncheckValue' => null)) . CHtml::label("Disuria", "") ?><br>
                    <?php echo $form->checkBox($modAnamnesa, 'eliminasi_buangairkecil[]', array('value' => 'Hematuri', 'uncheckValue' => null)) . CHtml::label("Hematuri", "") ?><br>
                    <?php echo $form->checkBox($modAnamnesa, 'eliminasi_buangairkecil[]', array('value' => 'Lain-Lain', 'uncheckValue' => null)) . CHtml::label("Lain-Lain", "") ?>
                    <?php echo $form->textField($modAnamnesa, 'eliminasi_buangairbesar_lain2', array('class' => 'span4')) ?><br>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Integritas Kulit</label>
                <div class="controls">
                    <?php echo CHtml::activeRadioButtonList($modAnamnesa, 'integritas_kulit', array(
                        'Luka/Lecet' => 'Luka/Lecet',
                        'Memar' => 'Memar',
                    )); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Modifikasi Strong-Kids
        </div>
    </div>
    <div class="panel-body">
        <table width="100%" class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th width="50">NO</th>
                    <th>PERTANYAAN</th>
                    <th width="70">JAWABAN</th>
                    <th width="70">SKOR</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Apakah Pasien memiliki status nutrisi kurang atau buruk secara klinik
                        (anak kurus/sangat kurus, mata cekung, wajah tampak tua, edema, rambut tipis dan jarang,
                        otot lengan dan paha tipis, iga gambang, perut kempes, bokong tipis dan kisut) ?</td>
                    <td><?php echo $form->dropDownList($modAnamnesa, 'strongkids_nutrisikurang', array("0" => "Tidak", "1" => "Ya"), array("class" => 'span2 strongkids_select')); ?></td>
                    <td><?php echo CHtml::textField("strongkids_skor", 0, array('readonly' => true, 'class' => 'strongkids_skor span1', 'style' => 'text-align: right;')); ?></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Apakah Terdapat Penurunan Berat Badan selama satu bulan terakhir atau untuk bayi < 1 tahun dan BB tidak naik selama 3 bulan terakhir ?<br>
                            Jika Ibu pasien menjawab tidak tahu dianggap Ya</td>
                    <td><?php echo $form->dropDownList($modAnamnesa, 'strongkids_peneurunanberat', array("0" => "Tidak", "1" => "Ya"), array("class" => 'span2 strongkids_select')); ?></td>
                    <td><?php echo CHtml::textField("strongkids_skor", 0, array('readonly' => true, 'class' => 'strongkids_skor span1', 'style' => 'text-align: right;')); ?></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Apakah terdapat SALAH SATU dari kondisi berikut :
                        <ul>
                            <li>Diare Profuse ( > 5x/hari) dan atau muntah ( > 3x/hari)</li>
                            <li>Asupan makanan berkurang selama 1 minggu terakhir</li>
                        </ul>
                    </td>
                    <td><?php echo $form->dropDownList($modAnamnesa, 'strongkids_diare_profus', array("0" => "Tidak", "1" => "Ya"), array("class" => 'span2 strongkids_select')); ?></td>
                    <td><?php echo CHtml::textField("strongkids_skor", 0, array('readonly' => true, 'class' => 'strongkids_skor span1', 'style' => 'text-align: right;')); ?></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Apakah terdapat penyakit besar atau keadaan yang melibatkan pasien beresiko mengalami malnutrisi
                        (lihat tabel daftar penyakit yang beresiko malnutrisi) ?
                    </td>
                    <td><?php echo $form->dropDownList($modAnamnesa, 'strongkids_penyakit_dasar', array("0" => "Tidak", "1" => "Ya"), array("class" => 'span2 strongkids_select')); ?></td>
                    <td><?php echo CHtml::textField("strongkids_skor", 0, array('readonly' => true, 'class' => 'strongkids_skor span1', 'style' => 'text-align: right;')); ?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right; font-weight: bold;">Total Skor</td>
                    <td><?php echo $form->textField($modAnamnesa, "strongkids_skor", array('readonly' => true, 'class' => 'strongkids_skor_total span1', 'style' => 'text-align: right;')); ?></td>
                </tr>
                <tr>
                    <td colspan="4" style="font-weight: bold;">
                        KESIMPULAN : <span class="strongkids_kesimpulan"></span>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(".strongkids_select").change(function(data) {
            $(this).parents("tr").find(".strongkids_skor").val($(this).val());
            hitungSkorStrongKids();
        });

        hitungSkorStrongKids();

    });

    function hitungSkorStrongKids() {
        var total = 0;
        $(".strongkids_skor").each(function() {
            total += parseFloat($(this).val());
        });
        $(".strongkids_skor_total").val(total);

        if (total >= 2) {
            $(".strongkids_kesimpulan").html("Dikonsultasikan Ahli Gizi");
        } else {
            $(".strongkids_kesimpulan").html("Konsultasi belum diperlukan");
        }
    }
</script>