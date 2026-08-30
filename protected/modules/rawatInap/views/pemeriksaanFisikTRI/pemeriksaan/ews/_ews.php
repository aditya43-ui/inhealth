<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>Parameter</th>
            <th>Penilaian</th>
            <th>Skor</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Pernapasan (per menit)</td>
            <td width="100"><?php echo $form->textField($model, 'ews_pernafasan', array('class' => 'span2 numbers-only ews_pernafasan penilaian')); ?></td>
            <td width="50"><?php echo $form->textField($model, 'ews_pernafasanskor', array('class' => 'span1 integer2 skor ews_pernafasanskor', 'readonly' => true)); ?></td>
        </tr>
        <tr>
            <td>Saturasi Oksigen Skala 1 (%)</td>
            <td><?php echo $form->textField($model, 'ews_so2skala1', array('class' => 'span2 numbers-only ews_so2skala1 penilaian')); ?></td>
            <td><?php echo $form->textField($model, 'ews_so2skala1skor', array('class' => 'span1 integer2 skor ews_so2skala1skor', 'readonly' => true)); ?></td>
        </tr>
        <tr>
            <td>Saturasi Oksigen Skala 2 (%)</td>
            <td><?php echo $form->textField($model, 'ews_so2skala2', array('class' => 'span2 numbers-only ews_so2skala2 penilaian')); ?></td>
            <td><?php echo $form->textField($model, 'ews_so2skala2skor', array('class' => 'span1 integer2 skor ews_so2skala2skor', 'readonly' => true)); ?></td>
        </tr>
        <tr>
            <td>Pemberian O2</td>
            <td><?php
                $data_pemberiano2 = LookupM::getItemsUrutanExtra('ews_pemberiano2', 'lookup_name', array(
                    'data-val' => 'lookup_value'
                ));

                echo $form->dropDownList($model, 'ews_pemberiano2', $data_pemberiano2['data'], array('class' => 'span2 ews_pemberiano2 penilaian', 'options' => $data_pemberiano2['option']));
                unset($data_pemberiano2);
                ?></td>
            <td><?php echo $form->textField($model, 'ews_pemberiano2skor', array('class' => 'span1 integer2 skor ews_pemberiano2skor', 'readonly' => true)); ?></td>
        </tr>
        <tr>
            <td>Tekanan Darah Sistolik</td>
            <td><?php echo $form->textField($model, 'ews_tdsistolik', array('class' => 'span2 numbers-only ews_tdsistolik penilaian')); ?></td>
            <td><?php echo $form->textField($model, 'ews_tdsistolikskor', array('class' => 'span1 integer2 skor ews_tdsistolikskor', 'readonly' => true)); ?></td>
        </tr>
        <tr>
            <td>Nadi</td>
            <td><?php echo $form->textField($model, 'ews_nadi', array('class' => 'span2 numbers-only ews_nadi penilaian')); ?></td>
            <td><?php echo $form->textField($model, 'ews_nadiskor', array('class' => 'span1 integer2 skor ews_nadiskor', 'readonly' => true)); ?></td>
        </tr>
        <tr>
            <td>Kesadaran</td>
            <td><?php
                $data_kesadaran = LookupM::getItemsUrutanExtra('ews_kesadaran', 'lookup_name', array(
                    'data-val' => 'lookup_value'
                ));

                echo $form->dropDownList($model, 'ews_kesadaran', $data_kesadaran['data'], array('class' => 'span2 ews_kesadaran penilaian', 'options' => $data_kesadaran['option']));
                unset($data_kesadaran);
                ?></td>
            <td><?php echo $form->textField($model, 'ews_kesadaranskor', array('class' => 'span1 integer2 skor ews_kesadaranskor', 'readonly' => true)); ?></td>
        </tr>
        <tr>
            <td>Suhu</td>
            <td><?php echo $form->textField($model, 'ews_suhu', array('class' => 'span2 float2 ews_suhu penilaian')); ?></td>
            <td><?php echo $form->textField($model, 'ews_suhuskor', array('class' => 'span1 integer2 skor ews_suhuskor', 'readonly' => true)); ?></td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2">Total Skor</td>
            <td><?php echo $form->textField($model, 'ews_totalskor', array('class' => 'span1 integer2 total_skor', 'readonly' => true)); ?></td>
        </tr>
        <tr>
            <td>Frekuensi Monitor</td>
            <td colspan="2"><?php echo $form->textArea($model, 'ews_frekmonitor', array('class' => 'span3')); ?></td>
        </tr>
        <tr>
            <td>Eskalasi Perawatan</td>
            <td colspan="2"><?php echo $form->dropDownList($model, 'ews_eskalasi', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?></td>
        </tr>
    </tfoot>
</table>

<script>
    var ews_pernafasan_nilai = [{
            range: [0, 8],
            nilai: 3
        },
        {
            range: [9, 11],
            nilai: 1
        },
        {
            range: [12, 20],
            nilai: 0
        },
        {
            range: [21, 24],
            nilai: 2
        },
        {
            range: [25, -1],
            nilai: 3
        }
    ];

    var ews_s02_1_nilai = [{
            range: [0, 91],
            nilai: 3
        },
        {
            range: [92, 93],
            nilai: 2
        },
        {
            range: [94, 95],
            nilai: 1
        },
        {
            range: [96, -1],
            nilai: 0
        }
    ];

    var ews_s02_2_nilai = [{
            range: [0, 83],
            nilai: 3
        },
        {
            range: [84, 85],
            nilai: 2
        },
        {
            range: [86, 87],
            nilai: 1
        },
        {
            range: [88, 92],
            nilai: 0
        },
        {
            range: [93, 94],
            nilai: 1
        },
        {
            range: [95, 96],
            nilai: 2
        },
        {
            range: [97, -1],
            nilai: 3
        }
    ];

    var ews_sistolik_nilai = [{
            range: [0, 90],
            nilai: 3
        },
        {
            range: [91, 100],
            nilai: 2
        },
        {
            range: [101, 110],
            nilai: 0
        },
        {
            range: [111, 180],
            nilai: 1
        },
        {
            range: [181, 220],
            nilai: 2
        },
        {
            range: [221, -1],
            nilai: 3
        }
    ];

    var ews_nadi_nilai = [{
            range: [0, 40],
            nilai: 3
        },
        {
            range: [41, 50],
            nilai: 2
        },
        {
            range: [51, 90],
            nilai: 0
        },
        {
            range: [91, 110],
            nilai: 1
        },
        {
            range: [110, 130],
            nilai: 2
        },
        {
            range: [131, -1],
            nilai: 3
        }
    ];

    var ews_suhu_nilai = [{
            range: [0, 35],
            nilai: 3
        },
        {
            range: [35.01, 36],
            nilai: 1
        },
        {
            range: [36.01, 38],
            nilai: 0
        },
        {
            range: [38.01, 39],
            nilai: 1
        },
        {
            range: [39.01, -1],
            nilai: 2
        }
    ];

    function hitungPenilanan(obj_penilaian, obj_skor, range_data) {
        var penilaian = parseFloat(unformatNumber($(obj_penilaian).val()));
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

        $(obj_skor).val(hasil);
    }

    function hitungSkorEWS() {

        hitungPenilanan($(".ews_pernafasan"), $(".ews_pernafasanskor"), ews_pernafasan_nilai);
        hitungPenilanan($(".ews_so2skala1"), $(".ews_so2skala1skor"), ews_s02_1_nilai);
        hitungPenilanan($(".ews_so2skala2"), $(".ews_so2skala2skor"), ews_s02_2_nilai);
        hitungPenilanan($(".ews_tdsistolik"), $(".ews_tdsistolikskor"), ews_sistolik_nilai);
        hitungPenilanan($(".ews_nadi"), $(".ews_nadiskor"), ews_nadi_nilai);
        hitungPenilanan($(".ews_suhu"), $(".ews_suhuskor"), ews_suhu_nilai);

        var total = 0;

        $("#panel_ews table tbody .penilaian").each(function() {
            var nilai = parseInt($(this).parents("tr").find(".skor").val());

            if ($(this).is("select")) {
                nilai = parseInt($(this).find(":selected").data('val'));
            }

            if (isNaN(nilai)) {
                nilai = 0;
            }

            $(this).parents("tr").find(".skor").val(nilai);
            total += nilai;
        });

        $("#panel_ews table tfoot .total_skor").val(total);
    }

    $(document).ready(function() {
        $("#panel_ews table tbody .penilaian").on("blur", hitungSkorEWS);
        $("#panel_ews table tbody .penilaian").on("change", hitungSkorEWS);

        hitungSkorEWS();
    });
</script>