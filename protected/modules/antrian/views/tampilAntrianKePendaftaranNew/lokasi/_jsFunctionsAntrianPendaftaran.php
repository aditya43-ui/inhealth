<script type="text/javascript">
    
    /**
     * set div antrian
     * @param {type} obj
     * @param {type} data
     * @returns {undefined} */
    function setFormAntrian(obj, data) {        
        $(obj).find("#<?php echo CHtml::activeId($model, 'antrian_id'); ?>").val(data.antrian_id);
        $(obj).find("#<?php echo CHtml::activeId($model, 'ruangan_id'); ?>").val(data.ruangan_id);
        $(obj).find("#<?php echo CHtml::activeId($model, 'carabayar_id'); ?>").val(data.carabayar_id);
        $(obj).find("#<?php echo CHtml::activeId($model, 'pendaftaran_id'); ?>").val(data.pendaftaran_id);
        $(obj).find("#<?php echo CHtml::activeId($model, 'profilrs_id'); ?>").val(data.profilrs_id);
        $(obj).find("#<?php echo CHtml::activeId($model, 'loket_id'); ?>").val(data.loket_id);
        $(obj).find("#<?php echo CHtml::activeId($model, 'tglantrian'); ?>").val(data.tglantrian);
        $(obj).find("#<?php echo CHtml::activeId($model, 'noantrian'); ?>").val(data.noantrian);
        $(obj).find("#<?php echo CHtml::activeId($model, 'statuspasien'); ?>").val(data.statuspasien);
        $(obj).find("#<?php echo CHtml::activeId($model, 'carabayar_loket'); ?>").val(data.carabayar_loket);
        $(obj).find("#<?php echo CHtml::activeId($model, 'panggil_flaq'); ?>").val(data.panggil_flaq);
        $(obj).find(".no-antrian").html(data.modelantrian_singkatan + "-" + data.noantrian);
    }

    /**
     * set tabel statistik
     * @param {type} obj
     * @param {type} data
     * @returns {undefined}
     */
    function setTableStatistik(obj, data) {
        $(obj).find("#jmlpasien").html(data.jmlpasien);
        $(obj).find("#jmlmenunggu").html(data.jmlmenunggu);
        $(obj).find("#jmlterdaftar").html(data.jmlterdaftar);
    }

    /**
     * 
     * @param {type} param
     */
    function setSuaraPanggilan(noantrians, loket_ids, modelantrian_singkatan) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SuaraPanggilanPendaftaran'); ?>',
            data: {noantrians: noantrians, loket_ids: loket_ids , modelantrian_singkatan: modelantrian_singkatan},
            dataType: "json",
            success: function (data) {
                $("#suarapanggilan").html(data.suarapanggilan);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function updateStatistik(loket_id) {
        console.log(loket_id);
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('updateStatistik'); ?>',
            data: {loket_id: loket_id},
            dataType: "json",
            success: function (data) {
                setTableStatistik($("#loket_" + loket_id), data.stat);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    $(document).ready(function () {
        
        //DINONAKTIF KAN KARENA BERAT JIKA DI EKSEKUSI DI SMART TV BOX (TARAKAN) >> setInterval(function(){reloadHalaman();},1000);

        refreshAt(1, 0, 0);
    });

    function refreshAt(hours, minutes, seconds) {
        var now = new Date();
        var then = new Date();

        if (now.getHours() > hours ||
                (now.getHours() == hours && now.getMinutes() > minutes) ||
                now.getHours() == hours && now.getMinutes() == minutes && now.getSeconds() >= seconds) {
            then.setDate(now.getDate() + 1);
        }
        then.setHours(hours);
        then.setMinutes(minutes);
        then.setSeconds(seconds);

        var timeout = (then.getTime() - now.getTime());
        setTimeout(function () {
            window.location.reload(true);
        }, timeout);
    }

    function setAntrianAllTerakhir(lokasi_karcisantrian_id, modelantrian_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setAntrianAllTerakhir'); ?>',
            data: {
                lokasi_karcisantrian_id: lokasi_karcisantrian_id,
                modelantrian_id:modelantrian_id,
                layarantrian_id:'<?php echo isset($_GET['layarantrian_id'])?$_GET['layarantrian_id']:null; ?>'
            },
            dataType: "json",
            success: function (data) {
                if (data.model != null) {
                    $('.no-antrian2').html(data.model.modelantrian_singkatan + "-" + data.model.noantrian);
                    $('.no-antrian3').html(data.model.loket_nama);
                } else {
                    $('.no-antrian2').html("X - XXX");
                    $('.no-antrian3').html("LOKET XX");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

</script>