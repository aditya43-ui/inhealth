<script type="text/javascript">
    
    function setInduksi(obj){
        var ada = $('#EvaluasiPrainduksiT_masalahsaatinduksi_ada_0');
        if (ada.is(" :checked")) {
            $("#<?php echo CHtml::activeId($model, 'masalahsaatinduksi_ada_keterangan') ?>").attr('readonly',false);
        } else {
            $("#<?php echo CHtml::activeId($model, 'masalahsaatinduksi_ada_keterangan') ?>").attr('readonly',true);
        }
    }
    
    function setPerubahan(obj){
        var ada = $('#EvaluasiPrainduksiT_perubahanrencanaanestesi_ada_0');
        if (ada.is(" :checked")) {
            $("#<?php echo CHtml::activeId($model, 'perubahanrencanaanestesi_ada_keterangan') ?>").attr('readonly',false);
        } else {
            $("#<?php echo CHtml::activeId($model, 'perubahanrencanaanestesi_ada_keterangan') ?>").attr('readonly',true);
        }
    }
    
    $(document).ready(function(){
        setPerubahan();
        setInduksi();
    });
</script>