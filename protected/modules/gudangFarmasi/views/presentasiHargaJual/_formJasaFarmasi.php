<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Jasa Farmasi</b>
        </div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-condensed" id="tabJasaFarmasi">
            <thead>
                <tr>
                    <th>Instalasi</th>
                    <th>Jenis Penjamin</th>
                    <th>Penjamin</th>
                    <th>Tarif Jasa</th>
                    <th><?php echo CHtml::link("+ Tambah", "#", array('onclick' => 'tambahItemJasaFarmasi(); return false')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $newRow = $this->renderPartial('_rowJasaFarmasi', array('jasaFarmasi' => new JasafarmasiM), true);

                foreach ($jasaFarmasi as $item) {
                    echo $this->renderPartial('_rowJasaFarmasi', array('jasaFarmasi' => $item), true);
                } ?>
            </tbody>
        </table>
    </div>
</div>

<?php

$newRow = str_replace("\n", "", $newRow);
$newRow = str_replace("\r", "", $newRow);

?>

<script>
    var row = '<?php echo $newRow; ?>';

    function setPenjamin(obj) {
        $.post('<?php echo Yii::app()->createUrl('actionDynamic/getPenjaminPasienDariIDCarabayar') ?>', {
            carabayar_id: $(obj).val()
        }, function(data) {
            $(obj).parents("tr").find(".penjamin_id").html(data);
        });
    }

    function tambahItemJasaFarmasi() {
        var cnt = 0;
        var last = null;

        $("#tabJasaFarmasi tbody").append(row);

        last = $("#tabJasaFarmasi tbody tr:last-child");

        last.find(".tarif_jasa").maskMoney({ "symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2 });

        renameInputJasaFarmasi();
    }

    function renameInputJasaFarmasi() {
        var cnt = 0;
        $("#tabJasaFarmasi tbody tr").each(function() {
            $(this).find(".jasafarmasi_id").prop("name", "jasaFarmasi[" + cnt + "][jasafarmasi_id]");
            $(this).find(".is_delete").prop("name", "jasaFarmasi[" + cnt + "][is_delete]");
            $(this).find(".instalasi_id").prop("name", "jasaFarmasi[" + cnt + "][instalasi_id]");
            $(this).find(".carabayar_id").prop("name", "jasaFarmasi[" + cnt + "][carabayar_id]");
            $(this).find(".penjamin_id").prop("name", "jasaFarmasi[" + cnt + "][penjamin_id]");
            $(this).find(".tarif_jasa").prop("name", "jasaFarmasi[" + cnt + "][tarif_jasa]");

            cnt++;
        });
    }

    function hapusItemJasaFarmasi(obj) {
        $(obj).parents('tr').find('.is_delete').val(1);
        $(obj).parents('tr').hide();
    }

    $(document).ready(function() {
        renameInputJasaFarmasi();
    });
</script>