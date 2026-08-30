<style>
    .tile-block.tile-danger{
        background-color: #ff4141;
        color: #fff;
    }
</style>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"> <b> Unggah Dokumen  </b></div>
        <span style="float:right; padding: 10px" >
            <?php echo CHtml::link("&nbsp;<span style='font-size:19px;'><i class='entypo-info'></i></span>", "javascript:;", array('rel' => 'tooltip', 'data-original-title' => 'Jika muncul warning pada baris yang kosong, maka pada file excelnya, pada baris kosong tersebut, harus di klik kanan dan pilih delete, lalu pilih delete entire row', 'data-placement' => 'bottom')); ?>
        </span>
    </div>
    <div class="panel-body">
        <div class="col-md-12 import-data">
            <div class="control-group ">
                <label class="control-label" style="width: 60px !important">File</label>
                <div class="controls btn-group">
                    <?php
                    echo CHtml::link("<b>Browse Files </b>", "javascript:;", array('class' => 'btn btn-info', 'style' => 'border-left:none;text-align:left; min-width:105px', 'onclick' => 'fileLoad(this);'));
                    echo "&nbsp;";
                    echo CHtml::link("<u></u>", 'javascript:;', array('class' => 'labelbrowse', 'onclick' => 'fileLoad(this);'));
                    echo "<div class='hide'>";
                    echo CHtml::activeFileField($model, 'fileimport', array('onchange' => 'cekFile(this);', 'accept' => '.xls', 'class' => 'required'));
                    echo CHtml::activeHiddenField($model, 'statusfile', array('class' => 'statusfile', 'style' => 'height:32px'));
                    echo "</div>";
                    ?> 
                </div>
            </div>
            <br>
            <div class="control-group ">
                <label class="control-label" style="width: 60px !important"></label>
                <div class="controls btn-group" onclick='cekImportFile(this);'>
                    <?php
                    echo CHtml::link("<i class='fa fa-upload'></i>", "javascript:;", array('class' => 'btn btn-info class unggah', 'style' => 'border-right:none; height:32px'));
                    echo CHtml::link("<b>Unggah</b>", "javascript:;", array('class' => 'btn btn-info class unggah', 'style' => 'border-left:none; min-width:70px; height:32px'));
                    echo CHtml::link("", "javascript:;", array('class' => 'label-statusfile', 'style' => 'height:32px'));
                    ?>    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"> <b> Hasil Unggah  </b></div>
    </div>
    <div class="panel-body">
        <div class="col-md-12">
            <div> 
                <h4 id="judul">Silahkan unggah data</h4>
                <p id="logerror"> </p> 
            </div>
        </div>
    </div>
</div>
<script>
    
    /**
     * Fungsi menutup dialog
     * @returns {undefined}
     */
    function tutup() {
        window.parent.$("#dialogUpload").dialog("close");
    }

    /**
     * Cek hasil import file apakah sesuai atau tidak
     * @param {type} obj
     * @returns {undefined}
     */
    function cekImportFile(obj) {

        var formData = new FormData();
        formData.append('file', $(obj).parents(".import-data").find('input:file')[0].files[0]);

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('cekFileImport'); ?>',
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (data) {
                var jumlah = window.parent.$("#tabel-hps > tbody > tr ").length;

                if (jumlah != data.jumlah) {
                    $('#judul').html('Data Gagal Diunggah <i style="color:#f73f3f" class="fa fa-times-circle"></i>');
                    $('#logerror').html('Jumlah data pada excel tidak sama dengan jumlah data pada tabel rincian pekerjaan', "Perhatian!");
                    $(obj).parents(".import-data").find('.statusfile').val('DITOLAK');
                    $(obj).parents(".import-data").find('.label-statusfile').html("<i class='fa fa-times'></i>");
                    $(obj).parents(".import-data").find('.label-statusfile').removeClass("btn btn-success");
                    $(obj).parents(".import-data").find('.label-statusfile').addClass("btn btn-danger");
                } else {
                    if (data.sukses == 1) {
                        $('#judul').html('Data Berhasil Diunggah <i style="color:#00a157" class="fa fa-check-circle"></i>');
                        $('#logerror').html("");
                        $(obj).parents(".import-data").find('.statusfile').val('VERIFIKASI');
                        $(obj).parents(".import-data").find('.label-statusfile').html("<i class='fa fa-check'></i>");
                        $(obj).parents(".import-data").find('.label-statusfile').removeClass("btn btn-danger");
                        $(obj).parents(".import-data").find('.label-statusfile').addClass("btn btn-success disabled");
                        $(obj).parents(".import-data").find('.unggah').addClass("disabled");

                        $.each(data.spk, function (key, value) {
                            window.parent.$("#tabel-hps > tbody > tr ").find("#ADPersiapanpengadaandetT_detail_" + key + "_persiapanpengadaandet_nama").val(value);
                        });

                        $.each(data.id, function (key, value) {
                            window.parent.$("#tabel-hps > tbody > tr ").find("#ADPersiapanpengadaandetT_detail_" + key + "_obatalkes_id").val(value);
                        });
                    } else {
                        $('#judul').html('Data Gagal Diunggah <i style="color:#f73f3f" class="fa fa-times-circle"></i>');
                        $('#logerror').html(data.pesan);
                        $(obj).parents(".import-data").find('.statusfile').val('DITOLAK');
                        $(obj).parents(".import-data").find('.label-statusfile').html("<i class='fa fa-times'></i>");
                        $(obj).parents(".import-data").find('.label-statusfile').removeClass("btn btn-success");
                        $(obj).parents(".import-data").find('.label-statusfile').addClass("btn btn-danger");
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    /**
     * Cek file apakah sesuai atau tidak
     * @param {type} obj
     * @returns {Boolean}     
     */
    function cekFile(obj) {
        var cek = $(obj).val();
        if (cek != '') {
            var type = $(obj).get(0).files[0]['type'];
            var tipeFile = type.split('/');
            var ext = '.' + $(obj).val().split('.').pop().toLowerCase();
            var fileExt = $(obj).attr('accept').split(',');

            if ($.inArray(ext, fileExt) == -1 && $.inArray(tipeFile[0] + '/*', fileExt) == -1) {
                window.parent.myAlert('Tipe file yang diupload tidak diizinkan !', "Perhatian!");
                $(obj).val("");
                return false;
            }

            var sizee = $(obj).get(0).files[0].size; //file size in bytes
            sizee = sizee / 1024; //file size in Kb
            sizee = sizee / 1024; //file size in Mb

            if (sizee > 5) {
                window.parent.myAlert("Ukuran file tidak boleh lebih dari 5mb", "perhatian !");
                $(obj).val("");
                $(obj).parents(".import-data").find('.labelbrowse').html('');
                return false;
            } else {
                $(obj).parents(".import-data").find('.labelbrowse').html("<u>" + $(obj).get(0).files[0]['name'] + "</u>");
                $(obj).parents(".import-data").find('.statusfile').val('');
                $(obj).parents(".import-data").find('.label-statusfile').html('');
                $(obj).parents(".import-data").find('.label-statusfile').removeClass('btn btn-danger');
                $(obj).parents(".import-data").find('.label-statusfile').removeClass('btn btn-success');
            }
        }
    }

    /**
     * Fungsi untuk membuka pilihan upload
     * @param {type} obj
     * @returns {undefined}     
     */
    function fileLoad(obj) {
        $(obj).parents(".import-data").find('input:file').trigger('click');
    }

    /**
     * Fungsi download log error
     * @param {type} jenis
     * @returns {undefined}     
     */
    function downloadTemplate(jenis){
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('unduhTemplate'); ?>',
            data: {
                jenis: jenis,              
            },
            dataType: "json",
            success: function (data) {
                if (data.sukses == 1){    
                    window.open(data.url_download, '_blank',);
                }else{
                    window.parent.toastr.warning(data.pesan,"Perhatian!");
                }               
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
</script>