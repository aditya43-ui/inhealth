<script type='text/javascript'>
    function setDataPasien(pasien_id, nama_pasien, no_rekam_medik, tanggal_lahir, jeniskelamin, alamat_pasien){
        $('#<?php echo CHtml::activeId($modPasien,'pasien_id'); ?>').val(pasien_id);
        $('#<?php echo CHtml::activeId($modPasien,'nama_pasien'); ?>').val(nama_pasien);
        $('#<?php echo CHtml::activeId($modPasien,'no_rekam_medik'); ?>').val(no_rekam_medik);
        $('#<?php echo CHtml::activeId($modPasien,'tanggal_lahir'); ?>').val(tanggal_lahir);
        $('#<?php echo CHtml::activeId($modPasien,'jeniskelamin'); ?>').val(jeniskelamin);
        $('#<?php echo CHtml::activeId($modPasien,'alamat_pasien'); ?>').val(alamat_pasien);
        setRiwayatPasien();
        $('#dialogPasien').dialog('close');
    }

    function setRiwayatPasien() {
        var frameObj = document.getElementById("riwayatPasien");
        var jsframe = $("#riwayatPasien");
        var id = $('#<?php echo CHtml::activeId($modPasien,'pasien_id'); ?>').val();
        jsframe.attr("src", "<?php echo Yii::app()->controller->createUrl('getRiwayatPasien'); ?>&id="+id);
        jsframe.parent().addClass("animation-loading");
        jsframe.on('load', function() {
            resizeIframeJs(jsframe);
            jsframe.parent().removeClass("animation-loading");
        });
        return false;
    }

    function resizeIframeJs(obj) {
        var h1 = obj.height();
        var h2 = 100;
        var h3 = h2 + h1;

        obj.attr("style", 'width: 100%; height:' + h3 + 'px;');
    }

    $(document).ready(function(){
        setRiwayatPasien();
    });
</script>
