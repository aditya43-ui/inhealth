<?php
$url = Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/verifikasiDpjp', []);
?>
<script type="text/javascript">

    function changeJenisPPA(){
        var id=$("#<?php echo CHtml::activeId($model,'ppa_jenis');?>").val();
        var ppa_nama="";
        var pendaftaran_id = '<?php echo isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null; ?>';
        console.log(pendaftaran_id);
        console.log(id);
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetOperasi'); ?>',
            data: {
                id : id,
            }, //
            dataType: "json",
            success: function (data) {
                $("#<?php echo CHtml::activeId($model, "tanggal_cppt"); ?>").val(data.tglrencanaoperasi);
                $("#<?php echo CHtml::activeId($model, "pegawaippa_id"); ?>").val(data.dokterpelaksana1_id);
                $("#<?php echo CHtml::activeId($model, "dpjp_id"); ?>").val(data.dokterpelaksana2_id);
                if($("#<?php echo CHtml::activeId($model, "dpjp_id"); ?>").val()=='-'){
                    $(".dpjpid").addClass("hide");
                }else{
                    $(".dpjpid").removeClass("hide");
                }
                if($("#<?php echo CHtml::activeId($model, "pegawaippa_id"); ?>").val()=='-'){
                    $(".namajenis_ppa").addClass("hide");
                }else{
                    $(".namajenis_ppa").removeClass("hide");

                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
        var pegawai_ppa=$("#<?php echo CHtml::activeId($model, "pegawaippa_id"); ?>").val();
        var dpjp=  $("#<?php echo CHtml::activeId($model, "dpjp_id"); ?>").val();
        if($("#<?php echo CHtml::activeId($model, "dpjp_id"); ?>").val()=='-'){
            $(".dpjpid").addClass("hide");
        }else{
            $(".dpjpid").removeClass("hide");

        }
        if($("#<?php echo CHtml::activeId($model, "pegawaippa_id"); ?>").val()=='-'){
            $(".namajenis_ppa").addClass("hide");
        }else{
            $(".namajenis_ppa").removeClass("hide");

        }
        var tanggal = $("#<?php echo CHtml::activeId($model, "tanggal_cppt"); ?>").val();
        console.log( $("#<?php echo CHtml::activeId($model, "pegawaippa_id"); ?>").val());
        console.log( $("#<?php echo CHtml::activeId($model, "dpjp_id"); ?>").val());
        console.log(tanggal);

    }
    $(document).ready(function() {
        // changeJenisPPA($('#<?php //echo CHtml::activeId($model, 'ppa_jenis'); ?>'));
        $(".namajenis_ppa").addClass("hide");
        $(".dpjpid").addClass("hide");        
    });

    function printRiwayat(pendaftaran_id, caraPrint) {
        var operasi_id=$("#<?php echo CHtml::activeId($model,'ppa_jenis');?>").val();
        window.open('<?php echo $this->createUrl('print'); ?>&pendaftaran_id=' + pendaftaran_id + '&operasi_id='+operasi_id+'&caraPrint=' + caraPrint + '&' + $("#searchriwayatcppt :input").serialize(), 'printwin', 'left=100,top=100,width=793,height=1122,scrollbars=yes');
    }
</script>