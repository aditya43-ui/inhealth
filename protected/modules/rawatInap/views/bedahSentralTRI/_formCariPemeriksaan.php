<br/>
<div id="cari_periksa" class="col-sm-12">
        <div class="control-group">
            <?php echo CHtml::label('Kegiatan Operasi','kegiatanoperasi_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::dropDownList('kegiatanoperasi_id', null, CHtml::listData(KegiatanoperasiM::model()->findAll(array(
                    'condition' => 'kegiatanoperasi_aktif = true',
                    'order' => 'kegiatanoperasi_nama',
                )), 'kegiatanoperasi_id', 'kegiatanoperasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Nama Jenis Operasi',)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Operasi', 'operasi_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('operasi_nama', null, array('class' => 'span3', 'onkeyup' => "return setEnterCari(event)", 'placeholder' => 'Nama Operasi',)); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', "onclick" => "updateChecklistPemeriksaanLab();", 'rel' => 'tooltip', 'title' => 'Klik untuk mencari pemeriksaan')); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'button', "onclick" => "setChecklistPemeriksaanLabReset();", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang pencarian')); ?>
            </div>
        </div>
</div>

<script>

    function setEnterCari(evt) {
        evt.preventDefault();
        console.log(evt.keyCode);

        if (evt.keyCode == 13) {
            updateChecklistPemeriksaanLab();
        }

        return true;
    }

    function updateChecklistPemeriksaanLab() {
        var jenis = $("#kegiatanoperasi_id").val().trim().toLowerCase();
        var nama = $("#operasi_nama").val().trim().toLowerCase();

        
        console.log("cari", jenis, nama);

        $(".pilih_periksa").each(function() {
            var jenis_terpilih = true;
            var nama_terpilih = true;
            console.log(jenis, $(this).find('label').data('jenis'));
            if (jenis == "" || (jenis != "" && $(this).find('label').data('jenis') == jenis)) {
                jenis_terpilih = true;
            } else {
                jenis_terpilih = false;
            }

            if (nama == "" || (nama != "" && $(this).find('label').data('nama').indexOf(nama)) != -1) {
                nama_terpilih = true;
            } else {
                nama_terpilih = false;
            }


            if (jenis_terpilih && nama_terpilih) {
                console.log("Kick");
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        $(".boxtindakan").each(function() {
            var box_tercari = false;
            var panel = $(this);

            $(this).find(".pilih_periksa").each(function() {
                if ($(this).css("display") != "none") {
                    box_tercari = true;
                }
            });
            
            if (box_tercari) {
                $(panel).parents(".jquery-tiler-block").show();
            } else {
                $(panel).parents(".jquery-tiler-block").hide();
            }
        });
    }

    function setChecklistPemeriksaanLabReset() {
        $("#kegiatanoperasi_id").val("");
        $("#operasi_nama").val("");

        updateChecklistPemeriksaanLab();
    }

    $(document).ready(function() {
        setChecklistPemeriksaanLabReset();
    });
</script>