<script>

    var row = <?php echo CJSON::encode(array('html' => $this->renderPartial("_formLoadBloodAgarDet", array("idx" => 0, 'i' => 0, 'modBlood' => $modBlood, 'modBloodGambar' => $modBloodGambar), true))); ?>;
    var rowChoc = <?php echo CJSON::encode(array('html' => $this->renderPartial("_formLoadChocAgarDet", array("idx" => 0, 'i' => 0, 'modChoc' => $modChoc, 'modChocGambar' => $modChocGambar), true))); ?>;
    var rowMc = <?php echo CJSON::encode(array('html' => $this->renderPartial("_formLoadMcAgarDet", array("idx" => 0, 'i' => 0, 'modMcConcey' => $modMcConcey, 'modMcConceyGambar' => $modMcConceyGambar), true))); ?>;
    var rowRs = <?php echo CJSON::encode(array('html' => $this->renderPartial("_formLoadRsAgarDet", array("idx" => 0, 'i' => 0, 'modBrucella' => $modBrucella, 'modBrucellaGambar' => $modBrucellaGambar), true))); ?>;
    
    //BLOOD 

    function tambahUsulan() {
        loadRincian('new');
    }

    function loadRincian(jenis) {
        var spesimen = '<?php echo $_GET['spesimen_id']; ?>';
        var culture = '<?php echo !empty($_GET['culture_id']) ? $_GET['culture_id'] : ""; ?>';
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('loadBlood'); ?>',
            data: {spesimen: spesimen, jenis: jenis, culture:culture},
            dataType: "json",
            success: function (data) {
                if (data.sukses == 1) {
                    if (jenis == 'load') {
                        $(".panel-bloodagar").html(data.html);
                    } else {
                        if ($(".panel-bloodagar > .panel-det-blood").length == 0) {
                            $(".panel-bloodagar").html(data.html);
                        } else {
                            $(".panel-bloodagar > .panel-det-blood:last").after(data.html);
                        }
                    }
                    renameInputRow($(".panel-bloodagar"));
                    generatePickerBl();
                } else {
                    toastr.error(data.pesan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function tambahBaris(obj) {
        $(obj).parents('.tab_detail').append(row.html);
        renameInputRow($(".panel-bloodagar"));
    }

    function renameInputRow(obj_table) {
        var row = 0;

        $(obj_table).find('.panel-det-blood').each(function () {
            $(this).find("#id_count").val(row+1);
            $(this).attr('row-rincian', row);
            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");

                if (old_name_arr.length == 4) {
                    $(this).attr("id", old_name_arr[0] + "_" + old_name_arr[1] + "_" + row + "_" + old_name_arr[3]);
                    $(this).attr("name", old_name_arr[0] + "[" + old_name_arr[1] + "][" + row + "][" + old_name_arr[3] + "]");
                }
            });

            var a = 0;
            var count = $(this).find('.tab_detail > tr').length;
            $(this).find('.tab_detail > tr').each(function () {

                $(this).attr('row-detail', a);
                $(this).find('.no_urut_det').html(a + 1);
                $(this).find('input,select,textarea').each(function () {
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 5) {
                        $(this).attr("id", old_name_arr[0] + "_" + old_name_arr[1] + "_" + row + "_" + a + "_" + old_name_arr[4]);
                        $(this).attr("name", old_name_arr[0] + "[" + old_name_arr[1] + "][" + row + "][" + a + "][" + old_name_arr[4] + "]");
                    }

                });

                if (count == 1) {
                    $(this).find('.btntambah').removeClass('hide');
                    $(this).find('.btnhapus').addClass('hide');
                } else {
                    if (count == (a + 1)) {
                        $(this).find('.btntambah').removeClass('hide');
                        $(this).find('.btnhapus').addClass('hide');
                    } else {
                        $(this).find('.btntambah').addClass('hide');
                        $(this).find('.btnhapus').removeClass('hide');
                    }
                }

                a++;
            });
            row++;
        });

        $('.numbers-only').keyup(function () {
            setNumbersOnly(this);
        });

        jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip();
    }
    
    /**
     * Hapus seluruh data bloodagar_t dan bloodagar_gambar_t
     * @param {type} obj
     * @returns {undefined}
     */
    function hapusDataBlood(obj){
        var blood_id = $(obj).parents(".panel-det-blood").find("input[name$='[blood_agar_id]']").val();
        if (blood_id !== "") {
            myConfirm("Apakah anda yakin akan menghapus data ini dari database?","Perhatian!",
                function(r){
                    if(r){
                        $.ajax({
                            type:'POST',
                            url:'<?php echo $this->createUrl('deleteBlood'); ?>&id='+blood_id,
                            data: {id : blood_id},//
                            dataType: "json",
                            success:function(data){
                                if(data.sukses == 1){
                                    $(obj).parents(".panel-det-blood").remove();
                                    renameInputRow($("#panel-bloodagar"));
                                }
                                myAlert(data.pesan);
                                var rowCount = document.getElementsByClassName("panel-det-blood");
                                var count = rowCount.length;
                                if (count == 0) {
                                      tambahUsulan();
                                }
                            },
                    error: function (jqXHR, textStatus, errorThrown) { myAlert("Data tidak dapat dihapus karena sudah digunakan di transaksi lainnya.");}
                        });
                    }
                });
        } else {
            myConfirm("Apakah Anda yakin ingin menghapus data ini ?", "Perhatian!", function (r) {
                if (r) {
                    $(obj).parents(".panel-det-blood").remove();
                    renameInputRow($("#panel-bloodagar"));
                }
            });
        }
    }
   
    /**
     * Hapus Gambar Blood
     * @param {type} obj
     * @returns {undefined}     */
    function hapusBarisBlood(obj){
        var bloodagar_gambar_id = $(obj).parents(".panel-det-blood").find("input[name$='[bloodagar_gambar_id]']").val();
        if (bloodagar_gambar_id !== "") {
            myConfirm("Apakah anda yakin akan menghapus data gambar ini dari database?","Perhatian!",
                function(r){
                    if(r){
                        $.ajax({
                            type:'POST',
                            url:'<?php echo $this->createUrl('deleteGambarBlood'); ?>&id='+bloodagar_gambar_id,
                            data: {id : bloodagar_gambar_id},//
                            dataType: "json",
                            success:function(data){
                            if(data.sukses == 1){
                                $(obj).parents(".panel-det-blood").remove();
                            }
                            myAlert(data.pesan);
                            var rowCount = $(".panel-det-blood").find('tbody tr').length;
                            if(rowCount==0){
                                tambahBaris();
                                }
                            },
                    error: function (jqXHR, textStatus, errorThrown) { myAlert("Data tidak dapat dihapus karena sudah digunakan di transaksi lainnya.");}
                        });
                    }
                });
        } else {
            $(obj).parents("tr").remove();
        }
    }
    // END OF BLOOD 

    // CHOC
    
    /**
     * Load data Choc Agar 
     * @param {type} jenis
     * @returns {undefined}     */
    function loadChoc(jenis) {
        var spesimen = '<?php echo $_GET['spesimen_id']; ?>';
        var culture = '<?php echo !empty($_GET['culture_id']) ? $_GET['culture_id'] : ""; ?>';
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('loadChoc'); ?>',
            data: {spesimen: spesimen, jenis: jenis, culture:culture},
            dataType: "json",
            success: function (data) {
                if (data.sukses == 1) {
                    if (jenis == 'load') {
                        $(".panel-chocagar").html(data.html);
                    } else {
                        if ($(".panel-chocagar > .panel-det-choc").length == 0) {
                            $(".panel-chocagar").html(data.html);
                        } else {
                            $(".panel-chocagar > .panel-det-choc:last").after(data.html);
                        }
                    }
                    renameInputChoc($(".panel-chocagar"));
                    generatePickerChoc();
                } else {
                    toastr.error(data.pesan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
    function renameInputChoc(obj_table) {
        var row = 0;

        $(obj_table).find('.panel-det-choc').each(function () {
            $(this).find("#id_count").val(row+1);
            $(this).attr('row-rincian-choc', row);
            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");

                if (old_name_arr.length == 4) {
                    $(this).attr("id", old_name_arr[0] + "_" + old_name_arr[1] + "_" + row + "_" + old_name_arr[3]);
                    $(this).attr("name", old_name_arr[0] + "[" + old_name_arr[1] + "][" + row + "][" + old_name_arr[3] + "]");
                }
            });

            var a = 0;
            var count = $(this).find('.tab_choc > tr').length;
            $(this).find('.tab_choc > tr').each(function () {

                $(this).attr('row-choc', a);
                $(this).find('.no_urut_det').html(a + 1);
                $(this).find('input,select,textarea').each(function () {
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 5) {
                        $(this).attr("id", old_name_arr[0] + "_" + old_name_arr[1] + "_" + row + "_" + a + "_" + old_name_arr[4]);
                        $(this).attr("name", old_name_arr[0] + "[" + old_name_arr[1] + "][" + row + "][" + a + "][" + old_name_arr[4] + "]");
                    }
                });

                if (count == 1) {
                    $(this).find('.btntambah').removeClass('hide');
                    $(this).find('.btnhapus').addClass('hide');
                } else {
                    if (count == (a + 1)) {
                        $(this).find('.btntambah').removeClass('hide');
                        $(this).find('.btnhapus').addClass('hide');
                    } else {
                        $(this).find('.btntambah').addClass('hide');
                        $(this).find('.btnhapus').removeClass('hide');
                    }
                }
                a++;
            });
            row++;
        });

        $('.numbers-only').keyup(function () {
            setNumbersOnly(this);
        });

        jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip();
    }
    
    function tambahChoc() {
        loadChoc('new');
    }

    function tambahBarisChoc(obj) {
        $(obj).parents('.tab_choc').append(rowChoc.html);
        renameInputChoc($(".panel-chocagar"));
    }
    
    function hapusDataChoc(obj){
        var choc_id = $(obj).parents(".panel-det-choc").find("input[name$='[choc_agar_id]']").val();
        if (choc_id !== "") {
            myConfirm("Apakah anda yakin akan menghapus data ini dari database?","Perhatian!",
                function(r){
                    if(r){
                        $.ajax({
                            type:'POST',
                            url:'<?php echo $this->createUrl('deleteChoc'); ?>&id='+choc_id,
                            data: {id : choc_id},//
                            dataType: "json",
                            success:function(data){
                                if(data.sukses == 1){
                                    $(obj).parents(".panel-det-choc").remove();
                                    renameInputChoc($("#panel-chocagar"));
                                }
                                myAlert(data.pesan);
                                var rowCount = document.getElementsByClassName("panel-det-choc");
                                var count = rowCount.length;
                                if (count == 0) {
                                      tambahChoc();
                                }
                            },
                    error: function (jqXHR, textStatus, errorThrown) { myAlert("Data tidak dapat dihapus karena sudah digunakan di transaksi lainnya.");}
                        });
                    }
                });
        } else {
            myConfirm("Apakah Anda yakin ingin menghapus data ini ?", "Perhatian!", function (r) {
                if (r) {
                    $(obj).parents(".panel-det-choc").remove();
                    renameInputChoc($("#panel-chocagar"));
                    var rowCount = document.getElementsByClassName("panel-det-choc");
                    var count = rowCount.length;
                    if (count == 0) {
                          tambahChoc();
                    }
                }
            });
        }
    }   
    
    function hapusChoc(obj) {
        myConfirm("Apakah Anda yakin ingin menghapus data ini ?", "Perhatian!", function (r) {
            if (r) {
                $(obj).parents(".panel-det-choc").remove();
                renameInputChoc($("#panel-chocagar"));
            }
        });
    }
    
    function hapusBarisChoc(obj) {
        var chocagar_gambar_id = $(obj).parents(".panel-det-choc").find("input[name$='[chocagar_gambar_id]']").val();
        if (chocagar_gambar_id !== "") {
            myConfirm("Apakah anda yakin akan menghapus data gambar ini dari database?","Perhatian!",
                function(r){
                    if(r){
                        $.ajax({
                            type:'POST',
                            url:'<?php echo $this->createUrl('deleteGambarChoc'); ?>&id='+chocagar_gambar_id,
                            data: {id : chocagar_gambar_id},//
                            dataType: "json",
                            success:function(data){
                            if(data.sukses == 1){
                                $(obj).parents("tr").remove();
                            }
                            myAlert(data.pesan);
                            var rowCount = $(".panel-det-choc").find('tbody tr').length;
                            if(rowCount==0){
                                tambahBarisChoc();
                                }
                            },
                    error: function (jqXHR, textStatus, errorThrown) { myAlert("Data tidak dapat dihapus karena sudah digunakan di transaksi lainnya.");}
                        });
                    }
                });
        } else {
            $(obj).parents("tr").remove();
        }
    }

    // END OF CHOC

    // Mc Conkey
    
    function loadMc(jenis) {
        var spesimen = '<?php echo $_GET['spesimen_id']; ?>';
        var culture = '<?php echo !empty($_GET['culture_id']) ? $_GET['culture_id'] : ""; ?>';

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('loadMc'); ?>',
            data: {spesimen: spesimen, jenis: jenis, culture:culture},
            dataType: "json",
            success: function (data) {
                if (data.sukses == 1) {
                    if (jenis == 'load') {
                        $(".panel-mcagar").html(data.html);
                    } else {
                        if ($(".panel-mcagar > .panel-det-mc").length == 0) {
                            $(".panel-mcagar").html(data.html);
                        } else {
                            $(".panel-mcagar > .panel-det-mc:last").after(data.html);
                        }
                    }
                    renameInputMc($(".panel-mcagar"));
                    generatePickerMc();
                } else {
                    toastr.error(data.pesan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
    function renameInputMc(obj_table) {
        var row = 0;

        $(obj_table).find('.panel-det-mc').each(function () {
            $(this).find("#id_count").val(row+1);
            $(this).attr('row-rincian-mc', row);
            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");

                if (old_name_arr.length == 4) {
                    $(this).attr("id", old_name_arr[0] + "_" + old_name_arr[1] + "_" + row + "_" + old_name_arr[3]);
                    $(this).attr("name", old_name_arr[0] + "[" + old_name_arr[1] + "][" + row + "][" + old_name_arr[3] + "]");
                }
            });

            var a = 0;
            var count = $(this).find('.tab_mc > tr').length;
            $(this).find('.tab_mc > tr').each(function () {

                $(this).attr('row-mc', a);
                $(this).find('.no_urut_det').html(a + 1);
                $(this).find('input,select,textarea').each(function () {
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 5) {
                        $(this).attr("id", old_name_arr[0] + "_" + old_name_arr[1] + "_" + row + "_" + a + "_" + old_name_arr[4]);
                        $(this).attr("name", old_name_arr[0] + "[" + old_name_arr[1] + "][" + row + "][" + a + "][" + old_name_arr[4] + "]");
                    }
                });

                if (count == 1) {
                    $(this).find('.btntambah').removeClass('hide');
                    $(this).find('.btnhapus').addClass('hide');
                } else {
                    if (count == (a + 1)) {
                        $(this).find('.btntambah').removeClass('hide');
                        $(this).find('.btnhapus').addClass('hide');
                    } else {
                        $(this).find('.btntambah').addClass('hide');
                        $(this).find('.btnhapus').removeClass('hide');
                    }
                }
                a++;
            });
            row++;
        });

        $('.numbers-only').keyup(function () {
            setNumbersOnly(this);
        });

        jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip();
    }
    
    function tambahMc() {
        loadMc('new');
    }

    function tambahBarisMc(obj) {
        $(obj).parents('.tab_mc').append(rowMc.html);
        renameInputMc($(".panel-mcagar"));
    }
    
    function hapusMc(obj) {
        myConfirm("Apakah Anda yakin ingin menghapus data ini ?", "Perhatian!", function (r) {
            if (r) {
                $(obj).parents(".panel-det-mc").remove();
                renameInputMc($("#panel-mcagar"));
            }
        });
    }
    
    function hapusDataMc(obj){
        var mc_id = $(obj).parents(".panel-det-mc").find("input[name$='[mcconcey_agar_id]']").val();
        if (mc_id !== "") {
            myConfirm("Apakah anda yakin akan menghapus data ini dari database?","Perhatian!",
                function(r){
                    if(r){
                        $.ajax({
                            type:'POST',
                            url:'<?php echo $this->createUrl('deleteMc'); ?>&id='+mc_id,
                            data: {id : mc_id},//
                            dataType: "json",
                            success:function(data){
                                if(data.sukses == 1){
                                    $(obj).parents(".panel-det-mc").remove();
                                    renameInputMc($("#panel-mcagar"));
                                }
                                myAlert(data.pesan);
                                var rowCount = document.getElementsByClassName("panel-det-mc");
                                var count = rowCount.length;
                                if (count == 0) {
                                      tambahMc();
                                }
                            },
                    error: function (jqXHR, textStatus, errorThrown) { myAlert("Data tidak dapat dihapus karena sudah digunakan di transaksi lainnya.");}
                        });
                    }
                });
        } else {
            myConfirm("Apakah Anda yakin ingin menghapus data ini ?", "Perhatian!", function (r) {
                if (r) {
                    $(obj).parents(".panel-det-mc").remove();
                    renameInputMc($("#panel-mcagar"));
                    var rowCount = document.getElementsByClassName("panel-det-mc");
                    var count = rowCount.length;
                    if (count == 0) {
                          tambahMc();
                    }
                }
            });
        }
    }        
    
    function hapusBarisMc(obj) {
        var mcconceyagar_gambar_id = $(obj).parents(".panel-det-mc").find("input[name$='[mcconceyagar_gambar_id]']").val();
        if (mcconceyagar_gambar_id !== "") {
            myConfirm("Apakah anda yakin akan menghapus data gambar ini dari database?","Perhatian!",
                function(r){
                    if(r){
                        $.ajax({
                            type:'POST',
                            url:'<?php echo $this->createUrl('deleteGambarMc'); ?>&id='+mcconceyagar_gambar_id,
                            data: {id : mcconceyagar_gambar_id},//
                            dataType: "json",
                            success:function(data){
                            if(data.sukses == 1){
                                $(obj).parents("tr").remove();
                            }
                            myAlert(data.pesan);
                            var rowCount = $(".panel-det-mc").find('tbody tr').length;
                            if(rowCount==0){
                                tambahBarisMc();
                                }
                            },
                    error: function (jqXHR, textStatus, errorThrown) { myAlert("Data tidak dapat dihapus karena sudah digunakan di transaksi lainnya.");}
                        });
                    }
                });
        } else {
            $(obj).parents("tr").remove();
        }
    }
    
    var parseHTML = function(str) {
        var tmp = document.implementation.createHTMLDocument();
        tmp.body.innerHTML = str;
        return tmp.body.children;
    };
    
    function checkGambarBlood(obj) {  
        var file = obj.files[0];
        if (file.size > 1000000) {
            myAlert("ukuran maks : 1Mb");
            $(obj).attr("src", "blank");
            $(obj).wrap('<form>').closest('form').get(0).reset();
            $(obj).unwrap();
            return false;
        }
        if (file.type.indexOf("image") == -1) {
            toastr.error("Tipe file harus berupa gambar");
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
                    i = $(obj).parents('tr').find('#id_count').val();
                    $(obj).parents('tr').find('#output_'+i).attr('src', evt.target.result);
                }
            }    
        } else {
            alert("not an image");
        }
    }
    
    function checkGambarChoc(obj) {  
        var file = obj.files[0];
        if (file.size > 1000000) {
            myAlert("ukuran maks : 1Mb");
            $(obj).attr("src", "blank");
            $(obj).wrap('<form>').closest('form').get(0).reset();
            $(obj).unwrap();
            return false;
        }
        if (file.type.indexOf("image") == -1) {
            toastr.error("Tipe file harus berupa gambar");
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
                    i = $(obj).parents('tr').find('#id_count').val();
                    $(obj).parents('tr').find('#output_'+i).attr('src', evt.target.result);
                }
            }    
        } else {
            alert("not an image");
        }
    }
    
    // END OF Mc Conkey
    
    /**
     * Load data Brucella 
     * @param {type} jenis
     * @returns {undefined}     */
    function loadRosela(jenis) {
        var spesimen = '<?php echo $_GET['spesimen_id']; ?>';
        var culture = '<?php echo !empty($_GET['culture_id']) ? $_GET['culture_id'] : ""; ?>';
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('loadRosela'); ?>',
            data: {spesimen: spesimen, jenis: jenis, culture:culture},
            dataType: "json",
            success: function (data) {
                if (data.sukses == 1) {
                    if (jenis == 'load') {
                        $(".panel-rsagar").html(data.html);
                    } else {
                        if ($(".panel-rsagar > .panel-det-rs").length == 0) {
                            $(".panel-rsagar").html(data.html);
                        } else {
                            $(".panel-rsagar > .panel-det-rs:last").after(data.html);
                        }
                    }
                    renameInputRs($(".panel-rsagar"));
                    generatePickerRs();
                } else {
                    toastr.error(data.pesan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
    function renameInputRs(obj_table) {
        var row = 0;

        $(obj_table).find('.panel-det-rs').each(function () {
            $(this).find("#id_count").val(row+1);
            $(this).attr('row-rincian-rs', row);
            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");

                if (old_name_arr.length == 4) {
                    $(this).attr("id", old_name_arr[0] + "_" + old_name_arr[1] + "_" + row + "_" + old_name_arr[3]);
                    $(this).attr("name", old_name_arr[0] + "[" + old_name_arr[1] + "][" + row + "][" + old_name_arr[3] + "]");
                }
            });

            var a = 0;
            var count = $(this).find('.tab_rs > tr').length;
            $(this).find('.tab_rs > tr').each(function () {

                $(this).attr('row-rs', a);
                $(this).find('.no_urut_det').html(a + 1);
                $(this).find('input,select,textarea').each(function () {
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 5) {
                        $(this).attr("id", old_name_arr[0] + "_" + old_name_arr[1] + "_" + row + "_" + a + "_" + old_name_arr[4]);
                        $(this).attr("name", old_name_arr[0] + "[" + old_name_arr[1] + "][" + row + "][" + a + "][" + old_name_arr[4] + "]");
                    }
                });

                if (count == 1) {
                    $(this).find('.btntambah').removeClass('hide');
                    $(this).find('.btnhapus').addClass('hide');
                } else {
                    if (count == (a + 1)) {
                        $(this).find('.btntambah').removeClass('hide');
                        $(this).find('.btnhapus').addClass('hide');
                    } else {
                        $(this).find('.btntambah').addClass('hide');
                        $(this).find('.btnhapus').removeClass('hide');
                    }
                }
                a++;
            });
            row++;
        });

        $('.numbers-only').keyup(function () {
            setNumbersOnly(this);
        });

        jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip();
    }
    
    function tambahRs() {
        loadRosela('new');
    }

    function tambahBarisRs(obj) {
        $(obj).parents('.tab_rs').append(rowRs.html);
        renameInputRs($(".panel-rsagar"));
    }
    
    function hapusDataRs(obj){
        var rs_id = $(obj).parents(".panel-det-rs").find("input[name$='[rs_agar_id]']").val();
        if (rs_id !== "") {
            myConfirm("Apakah anda yakin akan menghapus data ini dari database?","Perhatian!",
                function(r){
                    if(r){
                        $.ajax({
                            type:'POST',
                            url:'<?php echo $this->createUrl('deleteRs'); ?>&id='+rs_id,
                            data: {id : rs_id},//
                            dataType: "json",
                            success:function(data){
                                if(data.sukses == 1){
                                    $(obj).parents(".panel-det-rs").remove();
                                    renameInputRs($("#panel-rsagar"));
                                }
                                myAlert(data.pesan);
                                var rowCount = document.getElementsByClassName("panel-det-rs");
                                var count = rowCount.length;
                                if (count == 0) {
                                      tambahRs();
                                }
                            },
                    error: function (jqXHR, textStatus, errorThrown) { myAlert("Data tidak dapat dihapus karena sudah digunakan di transaksi lainnya.");}
                        });
                    }
                });
        } else {
            myConfirm("Apakah Anda yakin ingin menghapus data ini ?", "Perhatian!", function (r) {
                if (r) {
                    $(obj).parents(".panel-det-rs").remove();
                    renameInputRs($("#panel-rsagar"));
                    var rowCount = document.getElementsByClassName("panel-det-rs");
                    var count = rowCount.length;
                    if (count == 0) {
                          tambahRs();
                    }
                }
            });
        }
    }   
    
    function hapusRs(obj) {
        myConfirm("Apakah Anda yakin ingin menghapus data ini ?", "Perhatian!", function (r) {
            if (r) {
                $(obj).parents(".panel-det-rs").remove();
                renameInputRs($("#panel-rsagar"));
            }
        });
    }
    
    function hapusBarisRs(obj) {
        var rosellaagar_gambar_id = $(obj).parents(".panel-det-rs").find("input[name$='[rosellaagar_gambar_id]']").val();
        if (rosellaagar_gambar_id !== "") {
            myConfirm("Apakah anda yakin akan menghapus data gambar ini dari database?","Perhatian!",
                function(r){
                    if(r){
                        $.ajax({
                            type:'POST',
                            url:'<?php echo $this->createUrl('deleteGambarRs'); ?>&id='+rosellaagar_gambar_id,
                            data: {id : rosellaagar_gambar_id},//
                            dataType: "json",
                            success:function(data){
                            if(data.sukses == 1){
                                $(obj).parents("tr").remove();
                            }
                            myAlert(data.pesan);
                            var rowCount = $(".panel-det-rs").find('tbody tr').length;
                            if(rowCount==0){
                                tambahBarisRs();
                                }
                            },
                    error: function (jqXHR, textStatus, errorThrown) { myAlert("Data tidak dapat dihapus karena sudah digunakan di transaksi lainnya.");}
                        });
                    }
                });
        } else {
            $(obj).parents("tr").remove();
        }
    }

    // END OF Rosela
    
    /**
     * Load data Cook 
     * @param {type} jenis
     * @returns {undefined}     
     **/
    function loadCook(jenis) {
        var spesimen = '<?php echo $_GET['spesimen_id']; ?>';
        var culture = '<?php echo !empty($_GET['culture_id']) ? $_GET['culture_id'] : ""; ?>';
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('loadCook'); ?>',
            data: {spesimen: spesimen, jenis: jenis, culture:culture},
            dataType: "json",
            success: function (data) {
                if (data.sukses == 1) {
                    if (jenis == 'load') {
                        $(".panel-cookagar").html(data.html);
                    } else {
                        if ($(".panel-cookagar > .panel-det-cook").length == 0) {
                            $(".panel-cookagar").html(data.html);
                        } else {
                            $(".panel-cookagar > .panel-det-cook:last").after(data.html);
                        }
                    }
                    renameInputCook($(".panel-cookagar"));
                    generatePickerCook();
                } else {
                    toastr.error(data.pesan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
    function renameInputCook(obj_table) {
        var row = 0;

        $(obj_table).find('.panel-det-cook').each(function () {
            $(this).find("#id_count").val(row+1);
            $(this).attr('row-rincian-cook', row);
            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");

                if (old_name_arr.length == 4) {
                    $(this).attr("id", old_name_arr[0] + "_" + old_name_arr[1] + "_" + row + "_" + old_name_arr[3]);
                    $(this).attr("name", old_name_arr[0] + "[" + old_name_arr[1] + "][" + row + "][" + old_name_arr[3] + "]");
                }
            });

            var a = 0;
            var count = $(this).find('.tab_cook > tr').length;
            $(this).find('.tab_cook > tr').each(function () {

                $(this).attr('row-cook', a);
                $(this).find('.no_urut_det').html(a + 1);
                $(this).find('input,select,textarea').each(function () {
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 5) {
                        $(this).attr("id", old_name_arr[0] + "_" + old_name_arr[1] + "_" + row + "_" + a + "_" + old_name_arr[4]);
                        $(this).attr("name", old_name_arr[0] + "[" + old_name_arr[1] + "][" + row + "][" + a + "][" + old_name_arr[4] + "]");
                    }
                });

                if (count == 1) {
                    $(this).find('.btntambah').removeClass('hide');
                    $(this).find('.btnhapus').addClass('hide');
                } else {
                    if (count == (a + 1)) {
                        $(this).find('.btntambah').removeClass('hide');
                        $(this).find('.btnhapus').addClass('hide');
                    } else {
                        $(this).find('.btntambah').addClass('hide');
                        $(this).find('.btnhapus').removeClass('hide');
                    }
                }
                a++;
            });
            row++;
        });

        $('.numbers-only').keyup(function () {
            setNumbersOnly(this);
        });

        jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip();
    }
    
    function tambahCook() {
        loadCook('new');
    }

    function tambahBarisCook(obj) {
//        $(obj).parents('.tab_cook').append(rowCook.html);
        renameInputCook($(".panel-cookagar"));
    }
    
    function hapusDataCook(obj){
        var cook_id = $(obj).parents(".panel-det-cook").find("input[name$='[cook_agar_id]']").val();
        if (cook_id !== "") {
            myConfirm("Apakah anda yakin akan menghapus data ini dari database?","Perhatian!",
                function(r){
                    if(r){
                        $.ajax({
                            type:'POST',
                            url:'<?php echo $this->createUrl('deleteCook'); ?>&id='+cook_id,
                            data: {id : cook_id},//
                            dataType: "json",
                            success:function(data){
                                if(data.sukses == 1){
                                    $(obj).parents(".panel-det-cook").remove();
                                    renameInputCook($("#panel-cookagar"));
                                }
                                myAlert(data.pesan);
                                var rowCount = document.getElementsByClassName("panel-det-cook");
                                var count = rowCount.length;
                                if (count == 0) {
                                      tambahCook();
                                }
                            },
                    error: function (jqXHR, textStatus, errorThrown) { myAlert("Data tidak dapat dihapus karena sudah digunakan di transaksi lainnya.");}
                        });
                    }
                });
        } else {
            myConfirm("Apakah Anda yakin ingin menghapus data ini ?", "Perhatian!", function (r) {
                if (r) {
                    $(obj).parents(".panel-det-cook").remove();
                    renameInputCook($("#panel-cookagar"));
                    var rowCount = document.getElementsByClassName("panel-det-cook");
                    var count = rowCount.length;
                    if (count == 0) {
                          tambahCook();
                    }
                }
            });
        }
    }   
    
    function hapusCook(obj) {
        myConfirm("Apakah Anda yakin ingin menghapus data ini ?", "Perhatian!", function (r) {
            if (r) {
                $(obj).parents(".panel-det-cook").remove();
                renameInputCook($("#panel-cookagar"));
            }
        });
    }
    
    function hapusBarisCook(obj) {
        var rosellaagar_gambar_id = $(obj).parents(".panel-det-cook").find("input[name$='[rosellaagar_gambar_id]']").val();
        if (rosellaagar_gambar_id !== "") {
            myConfirm("Apakah anda yakin akan menghapus data gambar ini dari database?","Perhatian!",
                function(r){
                    if(r){
                        $.ajax({
                            type:'POST',
                            url:'<?php echo $this->createUrl('deleteGambarCook'); ?>&id='+rosellaagar_gambar_id,
                            data: {id : rosellaagar_gambar_id},//
                            dataType: "json",
                            success:function(data){
                            if(data.sukses == 1){
                                $(obj).parents("tr").remove();
                            }
                            myAlert(data.pesan);
                            var rowCount = $(".panel-det-cook").find('tbody tr').length;
                            if(rowCount==0){
                                tambahBarisCook();
                                }
                            },
                    error: function (jqXHR, textStatus, errorThrown) { myAlert("Data tidak dapat dihapus karena sudah digunakan di transaksi lainnya.");}
                        });
                    }
                });
        } else {
            $(obj).parents("tr").remove();
        }
    }

    // END OF Cook
    
    /**
     * Load data Thigli 
     * @param {type} jenis
     * @returns {undefined}     
     **/
    function loadThigli(jenis) {
        var spesimen = '<?php echo $_GET['spesimen_id']; ?>';
        var culture = '<?php echo !empty($_GET['culture_id']) ? $_GET['culture_id'] : ""; ?>';
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('loadThigli'); ?>',
            data: {spesimen: spesimen, jenis: jenis, culture:culture},
            dataType: "json",
            success: function (data) {
                if (data.sukses == 1) {
                    if (jenis == 'load') {
                        $(".panel-thigliagar").html(data.html);
                    } else {
                        if ($(".panel-thigliagar > .panel-det-thigli").length == 0) {
                            $(".panel-thigliagar").html(data.html);
                        } else {
                            $(".panel-thigliagar > .panel-det-thigli:last").after(data.html);
                        }
                    }
                    renameInputThigli($(".panel-thigliagar"));
                    generatePickerThigli();
                } else {
                    toastr.error(data.pesan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
    function renameInputThigli(obj_table) {
        var row = 0;

        $(obj_table).find('.panel-det-thigli').each(function () {
            $(this).find("#id_count").val(row+1);
            $(this).attr('row-rincian-thigli', row);
            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");

                if (old_name_arr.length == 4) {
                    $(this).attr("id", old_name_arr[0] + "_" + old_name_arr[1] + "_" + row + "_" + old_name_arr[3]);
                    $(this).attr("name", old_name_arr[0] + "[" + old_name_arr[1] + "][" + row + "][" + old_name_arr[3] + "]");
                }
            });

            var a = 0;
            var count = $(this).find('.tab_thigli > tr').length;
            $(this).find('.tab_thigli > tr').each(function () {

                $(this).attr('row-thigli', a);
                $(this).find('.no_urut_det').html(a + 1);
                $(this).find('input,select,textarea').each(function () {
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 5) {
                        $(this).attr("id", old_name_arr[0] + "_" + old_name_arr[1] + "_" + row + "_" + a + "_" + old_name_arr[4]);
                        $(this).attr("name", old_name_arr[0] + "[" + old_name_arr[1] + "][" + row + "][" + a + "][" + old_name_arr[4] + "]");
                    }
                });

                if (count == 1) {
                    $(this).find('.btntambah').removeClass('hide');
                    $(this).find('.btnhapus').addClass('hide');
                } else {
                    if (count == (a + 1)) {
                        $(this).find('.btntambah').removeClass('hide');
                        $(this).find('.btnhapus').addClass('hide');
                    } else {
                        $(this).find('.btntambah').addClass('hide');
                        $(this).find('.btnhapus').removeClass('hide');
                    }
                }
                a++;
            });
            row++;
        });

        $('.numbers-only').keyup(function () {
            setNumbersOnly(this);
        });

        jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip();
    }
    
    function tambahThigli() {
        loadThigli('new');
    }

    function tambahBarisThigli(obj) {
//        $(obj).parents('.tab_thigli').append(rowThigli.html);
        renameInputThigli($(".panel-thigliagar"));
    }
    
    function hapusDataThigli(obj){
        var thigli_id = $(obj).parents(".panel-det-thigli").find("input[name$='[thigli_agar_id]']").val();
        if (thigli_id !== "") {
            myConfirm("Apakah anda yakin akan menghapus data ini dari database?","Perhatian!",
                function(r){
                    if(r){
                        $.ajax({
                            type:'POST',
                            url:'<?php echo $this->createUrl('deleteThigli'); ?>&id='+thigli_id,
                            data: {id : thigli_id},//
                            dataType: "json",
                            success:function(data){
                                if(data.sukses == 1){
                                    $(obj).parents(".panel-det-thigli").remove();
                                    renameInputThigli($("#panel-thigliagar"));
                                }
                                myAlert(data.pesan);
                                var rowCount = document.getElementsByClassName("panel-det-thigli");
                                var count = rowCount.length;
                                if (count == 0) {
                                      tambahThigli();
                                }
                            },
                    error: function (jqXHR, textStatus, errorThrown) { myAlert("Data tidak dapat dihapus karena sudah digunakan di transaksi lainnya.");}
                        });
                    }
                });
        } else {
            myConfirm("Apakah Anda yakin ingin menghapus data ini ?", "Perhatian!", function (r) {
                if (r) {
                    $(obj).parents(".panel-det-thigli").remove();
                    renameInputThigli($("#panel-thigliagar"));
                    var rowCount = document.getElementsByClassName("panel-det-thigli");
                    var count = rowCount.length;
                    if (count == 0) {
                          tambahThigli();
                    }
                }
            });
        }
    }   
    
    function hapusThigli(obj) {
        myConfirm("Apakah Anda yakin ingin menghapus data ini ?", "Perhatian!", function (r) {
            if (r) {
                $(obj).parents(".panel-det-thigli").remove();
                renameInputThigli($("#panel-thigliagar"));
            }
        });
    }
    
    function hapusBarisThigli(obj) {
        var rosellaagar_gambar_id = $(obj).parents(".panel-det-thigli").find("input[name$='[rosellaagar_gambar_id]']").val();
        if (rosellaagar_gambar_id !== "") {
            myConfirm("Apakah anda yakin akan menghapus data gambar ini dari database?","Perhatian!",
                function(r){
                    if(r){
                        $.ajax({
                            type:'POST',
                            url:'<?php echo $this->createUrl('deleteGambarThigli'); ?>&id='+rosellaagar_gambar_id,
                            data: {id : rosellaagar_gambar_id},//
                            dataType: "json",
                            success:function(data){
                            if(data.sukses == 1){
                                $(obj).parents("tr").remove();
                            }
                            myAlert(data.pesan);
                            var rowCount = $(".panel-det-thigli").find('tbody tr').length;
                            if(rowCount==0){
                                tambahBarisThigli();
                                }
                            },
                    error: function (jqXHR, textStatus, errorThrown) { myAlert("Data tidak dapat dihapus karena sudah digunakan di transaksi lainnya.");}
                        });
                    }
                });
        } else {
            $(obj).parents("tr").remove();
        }
    }

    // END OF Thigli
    
    $(document).ready(function () {
        CekTindakan();
        
    });
    
    function CekTindakan(){
        var daftartindakan = $('#CultureT_daftartindakan_id').val();
        if(daftartindakan == <?php echo Params::DAFTARTINDAKAN_ID_AEROB; ?> || daftartindakan == 8918){
            <?php if (!empty($_GET['culture_id'])) { ?>
                $(".panel-bloodagar").html("");
                $(".panel-chocagar").html("");
                $(".panel-mcagar").html("");
                $(".panel-rsagar").html("");
                $(".panel-cookagar").html("");
                $(".panel-thigliagar").html("");
                loadRincian('load');
                loadChoc('load');
                loadMc('load');
                loadCook('load');
                loadThigli('load');
            <?php } else { ?>
                $(".panel-bloodagar").html("");
                $(".panel-chocagar").html("");
                $(".panel-mcagar").html("");
                $(".panel-rsagar").html("");
                $(".panel-cookagar").html("");
                $(".panel-thigliagar").html("");
                loadRincian('pertama');
                loadChoc('pertama');
                loadMc('pertama');
                loadCook('pertama');
                loadThigli('pertama');
            <?php } ?>
        }else if(daftartindakan == <?php echo Params::DAFTARTINDAKAN_ID_AN_AEROB; ?> || daftartindakan == 8919){
            <?php if (!empty($_GET['culture_id'])) { ?>
                $(".panel-bloodagar").html("");
                $(".panel-chocagar").html("");
                $(".panel-mcagar").html("");
                $(".panel-rsagar").html("");
                $(".panel-cookagar").html("");
                $(".panel-thigliagar").html("");
                loadRosela('load');
                loadCook('load');
                loadThigli('load');
            <?php } else { ?>
                $(".panel-bloodagar").html("");
                $(".panel-chocagar").html("");
                $(".panel-mcagar").html("");
                $(".panel-rsagar").html("");
                $(".panel-cookagar").html("");
                $(".panel-thigliagar").html("");
                loadRosela('pertama');
                loadCook('pertama');
                loadThigli('pertama');
            <?php } ?>
        }else{
            $(".panel-bloodagar").html("");
            $(".panel-chocagar").html("");
            $(".panel-mcagar").html("");
            $(".panel-rsagar").html("");
            $(".panel-cookagar").html("");
            $(".panel-thigliagar").html("");
        }
    }
</script>