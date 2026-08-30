<script type="text/javascript">
    $(document).ready(function () {
        loadTingkatRisiko();
        refreshDialog(); 
        if (<?= Yii::app()->user->getState('ruangan_id') ?> == <?= Params::RUANGAN_ID_KEPERAWATAN_YANKES ?>){
        } else if (<?= Yii::app()->user->getState('ruangan_id') ?> == <?= $model->ruangan_id ?>) {
        } else {
            $("#penelitian-t-form .lookdisable select").attr("disabled", true);
            $("#penelitian-t-form .lookdisable input").attr("disabled", true);
            $("#penelitian-t-form .lookdisable textarea").attr("disabled", true);
        }
    });
    
    function loadTingkatRisiko(){
        var konsekuensi_id = $("#YKMIdentifikasiresikoT_konsekuensi_id").val();
        var peluang_id = $("#YKMIdentifikasiresikoT_peluang_id").val();
        var detect_id = $("#YKMIdentifikasiresikoT_detectability_id").val();

        $.post('<?php echo $this->createUrl('getTingkatRisiko'); ?>', { 
            konsekuensi_id:konsekuensi_id,
            peluang_id:peluang_id,
            detect_id:detect_id
        },        
        function(data){
            $('#YKMIdentifikasiresikoT_skor_cl').val(data.skor_cl);
            $('#YKMIdentifikasiresikoT_konsekuensi_skor').val(data.konsekuensi_skor);
            $('#YKMIdentifikasiresikoT_peluang_skor').val(data.peluang_skor);
            $('#YKMIdentifikasiresikoT_detectability_skor').val(data.detectability_skor);       

            $('#YKMIdentifikasiresikoT_tingkatrisiko_id').val(data.tingkatrisiko_id);            
            $('#YKMIdentifikasiresikoT_tingkatrisiko_nama').val(data.tingkatrisiko_nama);

            $("#YKMIdentifikasiresikoT_rpn_score").val(data.rpn_score);
            $("#YKMIdentifikasiresikoT_target_rpn").val(data.target_rpn);
        }, "json");    
    }
</script>