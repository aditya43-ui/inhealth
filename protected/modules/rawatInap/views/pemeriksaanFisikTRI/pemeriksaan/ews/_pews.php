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
            <td>Keadaan Umum</td>
            <td width="200"><?php
                            $data_keadaanumum = LookupM::getItemsUrutanExtra('pews_keadaanumum', 'lookup_name', array(
                                'data-val' => 'lookup_value'
                            ));

                            echo $form->dropDownList($model, 'pews_keadaanumum', $data_keadaanumum['data'], array('class' => 'span3 penilaian', 'options' => $data_keadaanumum['option']));

                            unset($data_keadaanumum);
                            ?></td>
            <td width="50"><?php echo $form->textField($model, 'pews_skorkesadaranumum', array('class' => 'span1 integer2 skor', 'readonly' => true)); ?></td>
        </tr>
        <tr>
            <td>Kardiovaskuler</td>
            <td><?php
                $data_kardiovaskuler = LookupM::getItemsUrutanExtra('pews_kardiovaskuler', 'lookup_name', array(
                    'data-val' => 'lookup_value'
                ));

                echo $form->dropDownList($model, 'pews_kardiovaskuler', $data_kardiovaskuler['data'], array('class' => 'span3 penilaian', 'options' => $data_kardiovaskuler['option']));
                unset($data_kardiovaskuler);
                ?></td>
            <td><?php echo $form->textField($model, 'pews_skorkardiovaskuler', array('class' => 'span1 integer2 skor', 'readonly' => true)); ?></td>
        </tr>
        <tr>
            <td>Respirasi</td>
            <td><?php
                $data_respirasi = LookupM::getItemsUrutanExtra('pews_respirasi', 'lookup_name', array(
                    'data-val' => 'lookup_value'
                ));

                echo $form->dropDownList($model, 'pews_respirasi', $data_respirasi['data'], array('class' => 'span3 penilaian', 'options' => $data_respirasi['option']));
                unset($data_respirasi);
                ?></td>
            <td><?php echo $form->textField($model, 'pews_skorrespirasi', array('class' => 'span1 integer2 skor', 'readonly' => true)); ?></td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2">Total Skor</td>
            <td><?php echo $form->textField($model, 'pews_totalskor', array('class' => 'span1 integer2 total_skor', 'readonly' => true)); ?></td>
        </tr>
        <tr>
            <td>Frekuensi Monitor</td>
            <td colspan="2"><?php echo $form->textArea($model, 'pews_frekmonitor', array('class' => 'span4')); ?></td>
        </tr>
        <tr>
            <td>Eskalasi Perawatan</td>
            <td colspan="2"><?php echo $form->dropDownList($model, 'pews_eskalasi', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?></td>
        </tr>
    </tfoot>
</table>

<script>
    function hitungSkorPews() {
        var total = 0;
        $("#panel_pews table tbody .penilaian").each(function() {
            var nilai = parseInt($(this).find(":selected").data('val'));

            if (isNaN(nilai)) {
                nilai = 0;
            }
            total += nilai;

            $(this).parents("tr").find(".skor").val(nilai);
        });

        $("#panel_pews table tfoot .total_skor").val(total);
    }

    $(document).ready(function() {
        $("#panel_pews table tbody .penilaian").on("change", hitungSkorPews);

        hitungSkorPews();
    });
</script>