<script type="text/javascript">

    function pilihPeluang(obj) {
        var peluang = $(obj).val();
        $.post('<?php echo $this->createUrl('getBobotPeluang'); ?>', {
            id: peluang},
                function (data) {
                    $('#YKMProgressmonevindentifikasirisikoT_peluang_skor').val(data.return);
                    hitungRPN();
                }, "json");
    }

    function pilihKonsekuensi(obj) {
        var peluang = $(obj).val();
        $.post('<?php echo $this->createUrl('getBobotKonsekuensi'); ?>', {
            id: peluang},
                function (data) {
                    $('#YKMProgressmonevindentifikasirisikoT_konsekuensi_skor').val(data.return);
                    hitungRPN();
                }, "json");
    }

    function pilihDetectability(obj) {
        var peluang = $(obj).val();
        $.post('<?php echo $this->createUrl('getBobotDetectability'); ?>', {
            id: peluang},
                function (data) {
                    $('#YKMProgressmonevindentifikasirisikoT_detectability_skor').val(data.return);
                    hitungRPN();
                }, "json");
    }

    function loadTingkatRisiko() {
        var konsekuensi_id = $("#<?php echo CHtml::activeId($modProgress, 'konsekuensi_id') ?>").val();
        var peluang_id = $("#<?php echo CHtml::activeId($modProgress, 'peluang_id') ?>").val();
        var detect_id = $("#<?php echo CHtml::activeId($modProgress, 'detectability_id') ?>").val();

        $.post('<?php echo $this->createUrl('getTingkatRisiko'); ?>', {
            konsekuensi_id: konsekuensi_id,
            peluang_id: peluang_id,
            detect_id: detect_id
        },
                function (data) {
                    $('#<?php echo CHtml::activeId($modProgress, 'konsekuensi_skor') ?>').val(data.konsekuensi_skor);
                    $('#<?php echo CHtml::activeId($modProgress, 'peluang_skor') ?>').val(data.peluang_skor);
                    $('#<?php echo CHtml::activeId($modProgress, 'detectability_skor') ?>').val(data.detectability_skor);

                    $('#<?php echo CHtml::activeId($modProgress, 'rpn_sisa') ?>').val(data.rpn_score);
                }, "json");
    }


    function hitungRPN() {
        var konsekuensi_id = $("#YKMProgressmonevindentifikasirisikoT_konsekuensi_id").val();
        var peluang_id = $("#YKMProgressmonevindentifikasirisikoT_peluang_id").val();
        var detectability_id = $("#YKMProgressmonevindentifikasirisikoT_detectability_id").val();
        var nilai_konsekuensi = $("#YKMProgressmonevindentifikasirisikoT_konsekuensi_skor").val();
        var nilai_peluang = $("#YKMProgressmonevindentifikasirisikoT_peluang_skor").val();
        var nilai_detectability = $("#YKMProgressmonevindentifikasirisikoT_detectability_skor").val();

        if (nilai_konsekuensi == 0) {
            nilai_konsekuensi = 1;
        }
        if (nilai_peluang == 0) {
            nilai_peluang = 1;
        }
        if (nilai_detectability == 0) {
            nilai_detectability = 1;
        }

        var total = parseInt(nilai_konsekuensi) * parseInt(nilai_peluang) * parseInt(nilai_detectability);
        if (konsekuensi_id == "" && peluang_id == "" && detectability_id == "") {
            total = 0;
        }
        console.log(total);
//    $("#YKMProgressmonevindentifikasirisikoT_rpn_score").val(total);
    }


    $(document).ready(function () {
        loadTingkatRisiko();
        refreshDialog();
        if (<?= Yii::app()->user->getState('ruangan_id') ?> == <?= Params::RUANGAN_ID_KEPERAWATAN_YANKES ?>) {
        } else if (<?= Yii::app()->user->getState('ruangan_id') ?> == <?= $model->ruangan_id ?>) {
        } else {
            $("#penelitian-t-form .formprogres select").attr("disabled", true);
            $("#penelitian-t-form .formprogres input").attr("disabled", true);
            $("#penelitian-t-form .formprogres textarea").attr("disabled", true);
        }
        $("#penelitian-t-form .lookdisable select").attr("disabled", true);
        $("#penelitian-t-form .lookdisable input").attr("disabled", true);
        $("#penelitian-t-form .lookdisable textarea").attr("disabled", true);
    });
</script>