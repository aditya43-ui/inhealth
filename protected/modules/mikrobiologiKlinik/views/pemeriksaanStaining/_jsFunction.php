<?php 
    $modStainingDet = new MKStainingdetT();
?>
<script type="text/javascript">
    var row = <?php echo CJSON::encode(array('html' => $this->renderPartial("_2_formPemeriksaan", array('modStainingGambar' => $modStainingGambar, "i" => 1, 'j' => 1, 'modStainingDet' => $modStainingDet), true))); ?>;

    function tambahGmabarStaining(obj){
        var file = obj.files[0];
        if (file.size > 1000000) {
            myAlert("ukuran maks : 1Mb");
            $(obj).attr("src", "blank");
            $(obj).wrap('<form>').closest('form').get(0).reset();
            $(obj).unwrap();
            return false;
        }
        if (file.type.indexOf("image") == -1) {
            myAlert("Tipe file harus berupa gambar");
            $(obj).attr("src", "blank");
            $(obj).wrap('<form>').closest('form').get(0).reset();
            $(obj).unwrap();
            return false;
        }
        
        if(file.type.match('image.*')) {
            var reader = new FileReader();
            // Read in the image file as a data URL.
            reader.readAsDataURL(file);
            reader.onload = function(evt){
                if( evt.target.readyState == FileReader.DONE) {
                    i = $(obj).parents('div').find('#id_count').val();
                    $(obj).parents('div').find('#output_'+i).attr('src', evt.target.result);
                }
            }    
        } else {
            alert("not an image");
        }
    }
    
    function checkGambarBlood(obj) {  
        var file = obj.files[0];
        if (file.size > 1000000) {
            toastr.error("Ukuran maks : 1Mb", "Perhatian!");
            $(obj).attr("src", "blank");
            $(obj).wrap('<form>').closest('form').get(0).reset();
            $(obj).unwrap();
            return false;
        }
        if (file.type.indexOf("image") == -1) {
            toastr.error("Tipe file harus berupa gambar", "Perhatian!");
            $(obj).attr("src", "blank");
            $(obj).wrap('<form>').closest('form').get(0).reset();
            $(obj).unwrap();
            return false;
        }
        
        if(file.type.match('image.*')) {
            var reader = new FileReader();
            // Read in the image file as a data URL.
            reader.readAsDataURL(file);
            reader.onload = function(evt){
                if( evt.target.readyState == FileReader.DONE) {
                    i = $(obj).parents('.panel-det-staining').find('#id_count').val();
                    $(obj).parents('.panel-det-staining').find('#output_'+i).attr('src', evt.target.result);
                }
            }    
        } else {
            alert("not an image");
        }
    }
        
    function renameRiwayatStaining(){
        var row = 1;
        $('#table-riwayat-staining > tbody > tr').each(function(){
            $(this).find("#no-urut").html(row);
            row++;
        });
    }
       
    function hapusTransaksiStaining(staining_id, obj){
        myConfirm("Apakah anda yakin untuk menghapus data ini ?","Perhatian!",function(r){
            if (r){
                $('#accordion-riwayat').addClass("animation-loading");
                $.ajax({
                    type:'POST',
                    url:'<?php echo $this->createUrl('batalStaining'); ?>',
                    data: {staining_id: staining_id},
                    dataType: "json",
                    success:function(data){
                        $('#accordion-riwayat').removeClass("animation-loading");
                        if (data.status == 'ok') {
                            $(obj).parents('tr').detach();
                            renameRiwayatStaining();
                            myAlert("Spesimen berhasil dibatalkan");
                            window.location.href = '<?= $this->createUrl($this->id . '/index', array('spesimen_id' => $_GET['spesimen_id'])) ?>';
                        } else {
                            myAlert(data.keterangan);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $('#accordion-riwayat').removeClass("animation-loading");
                        myAlert('Terjadi kesalahan');
                        console.log(errorThrown);
                    }
		});
            }
        });
    }
    
    // Baru 
    function tambahStaining() {
        loadStaining('new');
    }
    
    function tambahBarisPemeriksaan(obj) {
        $(obj).parents('.form-pemeriksaannya').append(row.html);
        renameInputRow($(".panel-staining"));
    }

    function loadStaining(jenis) {
        var spesimen = '<?php echo $_GET['spesimen_id']; ?>';
        var staining = '<?php echo !empty($_GET['staining_id']) ? $_GET['staining_id'] : ""; ?>';
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('loadStaining'); ?>',
            data: {spesimen: spesimen, jenis: jenis, staining:staining},
            dataType: "json",
            success: function (data) {
                if (data.sukses == 1) {
                    if (jenis == 'load') {
                        $(".panel-staining").html(data.html);
                    } else {
                        if ($(".panel-staining > .panel-det-staining").length == 0) {
                            $(".panel-staining").html(data.html);
                        } else {
                            $(".panel-staining > .panel-det-staining:last").after(data.html);
                        }
                    }
                    renameInputRow($(".panel-staining"));
                    generatePickerStaining();
                } else {
                    toastr.error(data.pesan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
    function setDialogPPDS(obj) {
        var no = $(obj).parents(".panel-det-staining").attr('row-rincian-staining');
        var row = $("#no_row").val(no);
        $("#dialogPPDS").dialog("open");
    }   
    
    function setDialogDPJTM(obj) {
        var no = $(obj).parents(".panel-det-staining").attr('row-rincian-staining');
        var row = $("#no_row").val(no);
        $("#dialogVerifikator").dialog("open");
    }    
    
    function setDialogAnalis(obj) {
        var no = $(obj).parents(".panel-det-staining").attr('row-rincian-staining');
        var row = $("#no_row").val(no);
        $("#dialogAnalis").dialog("open");
    }   
    
    function setAnalisDialog(id) {
        var dialog = "#dialogAnalis";
        var no = $("#no_row").val();
        parent = $(dialog).attr("parent-dialog");
        obj = $("#" + parent);
        console.log('aaa');
        $.get('<?php echo $this->createUrl('GetAnalis'); ?>', {pegawai_id: id}, function (data) {
            $(".panel-det-staining").each(function () {
                if ($(this).find('#id_count').val() == no) {
                    setPegAnalis($(this).find('input[name$="[analis_id]"]'), data[0]);
                    console.log('abc');
                }
            });
        }, "json");
        
        $(dialog).dialog("close");
    }
    
    function setPpdsDialogBl(id) {
        var dialog = "#dialogPPDS";
        var no = $("#no_row").val();
        parent = $(dialog).attr("parent-dialog");
        obj = $("#" + parent);
        console.log('aaa');
        $.get('<?php echo $this->createUrl('GetPpds'); ?>', {ppds_id: id}, function (data) {
            $(".panel-det-staining").each(function () {
                if ($(this).find('#id_count').val() == no) {
                    setPegPPDSBl($(this).find('input[name$="[ppds_id]"]'), data[0]);
                    console.log('abc');
                }
            });
        }, "json");
        
        $(dialog).dialog("close");
    }
    
    /**
     * Set data ppds 
     * @param {type} obj
     * @param {type} item
     * @returns {undefined}
     */
    function setPegPPDSBl(obj, item) {
       console.log(item.ppds_id);
        $(obj).parents(".panel-det-staining").find('input[name$="[ppds_id]"]').val(item.ppds_id);
        $(obj).parents(".panel-det-staining").find('input[name$="[ppds_nama]"]').val(item.ppds_nama);
        $(obj).parents(".panel-det-staining").find('input[name$="[ppds_nim]"]').val(item.ppds_nim);
    }
    
    function resetPPDSBl(obj) {
        var no = $(obj).parents(".panel-det-staining").attr('row-rincian-staining');
        var row = $("#no_row").val(no);
        $(".panel-det-staining").each(function () {
            if ($(this).attr('row-rincian-staining') == no) {
                $(this).find('input[name$="[ppds_id]"]').val("");
                $(this).find('input[name$="[ppds_nama]"]').val("");
                $(this).find('input[name$="[ppds_nim]"]').val("");
            }
        });
    }
    
    /**
     * Set data analis 
     * @param {type} obj
     * @param {type} item
     * @returns {undefined}
     */
    function setPegAnalis(obj, item) {
        console.log(item.pegawai_id);
        $(obj).parents(".panel-det-staining").find('input[name$="[analis_id]"]').val(item.pegawai_id);
        $(obj).parents(".panel-det-staining").find('input[name$="[analis_nama]"]').val(item.nama_pegawai);
        $(obj).parents(".panel-det-staining").find('.analis_nip').val(item.nomorindukpegawai);
    }
    
    function resetAnalis(obj) {
        var no = $(obj).parents(".panel-det-staining").attr('row-rincian-staining');
        var row = $("#no_row").val(no);
        $(".panel-det-staining").each(function () {
            if ($(this).attr('row-rincian-staining') == no) {
                $(this).find('input[name$="[analis_id]"]').val("");
                $(this).find('input[name$="[analis_nama]"]').val("");
                $(this).find('.analis_nip').val("");
            }
        });
    }
    
    /**
     * Menghapus field DPJTM 
     * @param {type} obj
     * @returns {undefined}
     */
    function resetDPJTMBl(obj){
        var no = $(obj).parents(".panel-det-staining").attr('row-rincian-staining');
        var row = $("#no_row").val(no);
        $(".panel-det-staining").each(function () {
            if ($(this).attr('row-rincian-staining') == no) {
                $(this).find('input[name$="[dpjtm_id]"]').val("");
                $(this).find('input[name$="[dpjtm_nama]"]').val("");
                $(this).find('input[name$="[dpjtm_nip]"]').val("");
            }
        });
    }

    /**
     * Mencari data ppds berdasarkan pegawai_id yang dipilih melalui ajax. jika ditemukan maka set dpjtm
     * @param {type} id
     * @returns {undefined}
     */
    function setDpjtmDialogBl(id) {
        var dialog = "#dialogVerifikator";
        var no = $("#no_row").val();
        parent = $(dialog).attr("parent-dialog");
        obj = $("#" + parent);
        
        $.get('<?php echo $this->createUrl('GetDpjtm'); ?>', {pegawai_id: id}, function (data) {
            $(".panel-det-staining").each(function () {
                if ($(this).find('#id_count').val() == no) {
                    setPegDPJTMBl($(this).find('input[name$="[dpjtm_id]"]'), data[0]);
                }
            });
        }, "json");
        
        $(dialog).dialog("close");
    }

    /**
     * Set data ppds 
     * @param {type} obj
     * @param {type} item
     * @returns {undefined}
     */
    function setPegDPJTMBl(obj, item) {
        $(obj).parents(".panel-det-staining").find('input[name$="[dpjtm_id]"]').val(item.pegawai_id);
        $(obj).parents(".panel-det-staining").find('input[name$="[dpjtm_nama]"]').val(item.nama_pegawai);
        $(obj).parents(".panel-det-staining").find('input[name$="[dpjtm_nip]"]').val(item.nomorindukpegawai);
    }
    
    function renameInputRow(obj_table) {
        var row = 1;

        $(obj_table).find('.panel-det-staining').each(function () {
            $(this).find("#id_count").val(row);
            $(this).find('#no_urut').val(row);
            $(this).find(".gambar-prev").attr("id", "output_"+(row));
            $(this).attr('row-rincian-staining', row);
            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");

                if (old_name_arr.length == 4) {
                    $(this).attr("id", old_name_arr[0] + "_" + old_name_arr[1] + "_" + row + "_" + old_name_arr[3]);
                    $(this).attr("name", old_name_arr[0] + "[" + old_name_arr[1] + "][" + row + "][" + old_name_arr[3] + "]");
                }
            });

            var a = 1;
            $(this).find('.panel-det-pemeriksaan').each(function () {
                $(this).attr('row-det-staining', a);
                $(this).find('.no_urut_det').html(a + 1);
                $(this).find('input,select,textarea').each(function () {
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 5) {
                        $(this).attr("id", old_name_arr[0] + "_" + old_name_arr[1] + "_" + row + "_" + a + "_" + old_name_arr[4]);
                        $(this).attr("name", old_name_arr[0] + "[" + old_name_arr[1] + "][" + row + "][" + a + "][" + old_name_arr[4] + "]");
                    }
                });
                a++;
            });
            row++;
        });

        $('.numbers-only').keyup(function () {
            setNumbersOnly(this);
        });

        jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip();
    }
    
    function hapusBarisPemeriksaan(obj){
        var stainingdet_id = $(obj).parents(".panel-det-pemeriksaan").find('.stainingdet_id').val();

        console.log(stainingdet_id);
        if (stainingdet_id === "") {
            $(obj).parents('.panel-det-pemeriksaan').remove();
        } else {
            $(obj).parents('.panel-det-pemeriksaan').hide(); 
            $(obj).parents('.panel-det-pemeriksaan').find('.status').val(1);
        }
    }
    
    function hapusBarisStaining(obj){
        var staining_gambar_id = $(obj).parents(".panel-det-staining").find('.staining_gambar_id').val();
        console.log(staining_gambar_id);
        if (typeof staining_gambar_id  === "undefined") {
            $(obj).parents('.panel-det-staining').remove();
        } else {
            $(obj).parents('.panel-det-staining').hide();
            $(obj).parents('.panel-det-staining').find('.status_gambar').val(1);
        }

    }
        
    
    $(document).ready(function(){        
        <?php if(isset($_GET['sukses'])){ ?>
            $("input,select,textarea").attr('disabled', true);
            $('.panel-success').find('button').attr('disabled', true);
            $(".add-on").hide();
        <?php } ?>
        <?php if (!empty($_GET['staining_id'])) { ?>
            loadStaining('load');
        <?php } else { ?>
            loadStaining('new');
        <?php } ?>
    });
</script>