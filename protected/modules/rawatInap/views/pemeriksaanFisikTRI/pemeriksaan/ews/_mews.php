<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>Parameter</th>
            <th>Penilaian</th>
            <th>Kriteria Penilaian</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Pernapasan (per menit)</td>
            <td width="100"><?php echo $form->textField($model, 'mews_pernafasan', array('class' => 'span2 numbers-only mews_pernafasan penilaian')); ?></td>
            <td width="100"><?php echo $form->textField($model, 'mews_pernafasannilai', array('class' => 'span3 kriteria mews_pernafasannilai nilai', 'readonly' => true)); ?></td>
        </tr>
        <tr>
            <td>Saturasi O2</td>
            <td><?php echo $form->textField($model, 'mews_so2', array('empty' => '-- Pilih --', 'class' => 'span2 mews_so2 penilaian')); ?></td>
            <td><?php echo $form->textField($model, 'mews_so2nilai', array('class' => 'span3 kriteria mews_so2nilai nilai', 'readonly' => true)); ?></td>
        </tr>
        <tr>
            <td>Tekanan Darah Sistolik</td>
            <td><?php echo $form->textField($model, 'mews_tdsistolik', array('class' => 'span2 numbers-only mews_tdsistolik penilaian')); ?></td>
            <td><?php echo $form->textField($model, 'mews_tdsistoliknilai', array('class' => 'span3 kriteria mews_tdsistoliknilai nilai', 'readonly' => true)); ?></td>
        </tr>
        <tr>
            <td>Tekanan Darah Diastolik</td>
            <td><?php echo $form->textField($model, 'mews_tddiastolik', array('class' => 'span2 numbers-only mews_tddiastolik penilaian')); ?></td>
            <td><?php echo $form->textField($model, 'mews_tddiastoliknilai', array('class' => 'span3 kriteria mews_tddiastoliknilai nilai', 'readonly' => true)); ?></td>
        </tr>
        <tr>
            <td>Nadi</td>
            <td><?php echo $form->textField($model, 'mews_nadi', array('class' => 'span2 numbers-only mews_nadi penilaian')); ?></td>
            <td><?php echo $form->textField($model, 'mews_nadinilai', array('class' => 'span3 kriteria mews_nadinilai nilai', 'readonly' => true)); ?></td>
        </tr>
        <tr>
            <td>Kesadaran</td>
            <td><?php
                $data_kesadaran = LookupM::getItemsUrutanExtra('mews_kesadaran', 'lookup_name', array(
                    'data-penilaian' => 'lookup_value',
                    'data-val' => 'lookup_urutan',
                ));
                echo $form->dropDownList($model, 'mews_kesadaran', $data_kesadaran['data'], array('empty' => '-- Pilih --', 'class' => 'span2 mews_kesadaran penilaian', 'options' => $data_kesadaran['option']));
                unset($data_kesadaran);
                ?></td>
            <td><?php echo $form->textField($model, 'mews_kesadarannilai', array('class' => 'span3 kriteria mews_kesadarannilai nilai', 'readonly' => true)); ?></td>
        </tr>
        <tr>
            <td>Suhu</td>
            <td><?php echo $form->textField($model, 'mews_suhu', array('class' => 'span2 float2 mews_suhu penilaian')); ?></td>
            <td><?php echo $form->textField($model, 'mews_suhunilai', array('class' => 'span3 kriteria mews_suhunilai nilai', 'readonly' => true)); ?></td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2">Total Kriteria</td>
            <td colspan="2">
                <?php
                echo "<div>";
                echo '<div class="pull-right">';
                echo CHtml::label("Merah ", "", array('style' => 'width: 60px; text-align: right; margin-right: 2px;'));
                echo $form->textField($model, 'mews_totalkriteria[0]', array('class' => 'span1 total_merah', 'data-nilai' => "Merah", "readonly" => true, 'style' => 'text-align: right'));
                echo "</div>";
                echo "</div>";
                ?> <br>
                <?php
                echo "<div>";
                echo '<div class="pull-right">';
                echo CHtml::label("Kuning ", "", array('style' => 'width: 60px; text-align: right; margin-right: 2px;'));
                echo $form->textField($model, 'mews_totalkriteria[1]', array('class' => 'span1 total_kuning', 'data-nilai' => "Kuning", "readonly" => true, 'style' => 'text-align: right'));
                echo "</div>";
                echo "</div>";
                ?> <br>
                <?php
                echo "<div>";
                echo '<div class="pull-right">';
                echo CHtml::label("Putih ", "", array('style' => 'width: 60px; text-align: right; margin-right: 2px;'));
                echo $form->textField($model, 'mews_totalkriteria[2]', array('class' => 'span1 total_putih', 'data-nilai' => "Putih", "readonly" => true, 'style' => 'text-align: right'));
                echo "</div>";
                echo "</div>";
                ?> <br>
            </td>
        </tr>
        <?php /*
            <tr>
            <td colspan="2">Total Skor</td>
            <td colspan="2"><?php echo $form->textField($model, 'mews_totalskor', array('class'=>'span3 integer2 total_skor', 'readonly'=>true)); ?></td>
            </tr>
            * 
            */ ?>
        <tr>
            <td colspan="2">Frekuensi Monitor</td>
            <td><?php echo $form->textArea($model, 'mews_frekmonitor', array('class' => 'span3')); ?></td>
        </tr>
        <tr>
            <td colspan="2">Eskalasi Perawatan</td>
            <td><?php echo $form->dropDownList($model, 'mews_eskalasi', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?></td>
        </tr>
    </tfoot>
</table>

<script>
    var mews_pernafasan_nilai = [{
            range: [0, 10],
            nilai: "Merah"
        },
        {
            range: [11, 24],
            nilai: "Putih"
        },
        {
            range: [25, 30],
            nilai: "Kuning"
        },
        {
            range: [31, -1],
            nilai: "Merah"
        }
    ];

    var mews_saturasio2_nilai = [{
            range: [0, 95],
            nilai: "Merah"
        },
        {
            range: [96, -1],
            nilai: "Putih"
        }
    ];

    var mews_tdsistolik_nilai = [{
            range: [0, 89],
            nilai: "Merah"
        },
        {
            range: [90, 100],
            nilai: "Kuning"
        },
        {
            range: [101, 139],
            nilai: "Putih"
        },
        {
            range: [140, 180],
            nilai: "Kuning"
        },
        {
            range: [181, -1],
            nilai: "Merah"
        }
    ];

    var mews_tddiastolik_nilai = [{
            range: [0, 49],
            nilai: "Merah"
        },
        {
            range: [50, 89],
            nilai: "Putih"
        },
        {
            range: [90, 100],
            nilai: "Kuning"
        },
        {
            range: [101, -1],
            nilai: "Merah"
        }
    ];

    var mews_nadi_nilai = [{
            range: [0, 40],
            nilai: "Merah"
        },
        {
            range: [41, 50],
            nilai: "Kuning"
        },
        {
            range: [51, 99],
            nilai: "Putih"
        },
        {
            range: [100, 120],
            nilai: "Kuning"
        },
        {
            range: [121, -1],
            nilai: "Merah"
        }
    ];

    var mews_suhu_nilai = [{
            range: [0.00, 35.00],
            nilai: "Merah"
        },
        {
            range: [35.01, 36.00],
            nilai: "Kuning"
        },
        {
            range: [36.01, 37.49],
            nilai: "Putih"
        },
        {
            range: [37.50, 38.00],
            nilai: "Kuning"
        },
        {
            range: [38.01, -1],
            nilai: "Merah"
        }
    ];

    function hitungPenilananMEWS(obj_penilaian, obj_nilai, range_data) {
        var penilaian = parseFloat($(obj_penilaian).val().replace(",", "."));
        var hasil = 0;

        if (isNaN(penilaian)) {
            penilaian = 0;
            $(obj_penilaian).val(penilaian);
        }

        $.each(range_data, function(idx, val) {
            if (penilaian >= val.range[0] && (penilaian <= val.range[1] || val.range[1] === -1)) {
                hasil = val.nilai;
            }
        });

        $(obj_nilai).val(hasil);
    }

    function hitungSkorMEWS() {

        hitungPenilananMEWS($(".mews_pernafasan"), $(".mews_pernafasannilai"), mews_pernafasan_nilai);
        hitungPenilananMEWS($(".mews_so2"), $(".mews_so2nilai"), mews_saturasio2_nilai);
        hitungPenilananMEWS($(".mews_tdsistolik"), $(".mews_tdsistoliknilai"), mews_tdsistolik_nilai);
        hitungPenilananMEWS($(".mews_tddiastolik"), $(".mews_tddiastoliknilai"), mews_tddiastolik_nilai);
        hitungPenilananMEWS($(".mews_nadi"), $(".mews_nadinilai"), mews_nadi_nilai);
        hitungPenilananMEWS($(".mews_suhu"), $(".mews_suhunilai"), mews_suhu_nilai);



        $("#panel_mews table tbody .penilaian").each(function() {
            var nilai = "";
            if ($(this).is("select")) {
                nilai = $(this).find(":selected").data('penilaian');
                $(this).parents("tr").find(".nilai").val(nilai);
            }

        });

        var total_merah = 0;
        var total_kuning = 0;
        var total_putih = 0;
        $("#panel_mews table tbody .nilai").each(function() {
            if ($(this).val() == "Merah") {
                total_merah++;
            }
            if ($(this).val() == "Kuning") {
                total_kuning++;
            }
            if ($(this).val() == "Putih") {
                total_putih++;
            }
        });

        $(".total_merah").val(total_merah);
        $(".total_kuning").val(total_kuning);
        $(".total_putih").val(total_putih);

        // $("#panel_mews table tfoot .total_skor").val(total);

    }

    $(document).ready(function() {
        $("#panel_mews table tbody .penilaian").on("blur", hitungSkorMEWS);
        $("#panel_mews table tbody .penilaian").on("change", hitungSkorMEWS);

        hitungSkorMEWS();
    });
</script>