<?php
$this->breadcrumbs = array(
    'Kode Rekening',
);
?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.treeview.js"></script>
<script type="text/javascript">
    var id_form = new Array();
</script>

<!--
    referensi tree jquery
    http://jquery.bassistance.de/treeview/demo/
-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Master <b>Kode Rekening</b>
        </div>
    </div>
    <div class="panel-body">
        <table style="width: 100%; border: none;">
            <tr>
                <td width="45%" id="ka-viewtree">
                    <?php echo $this->renderPartial('__treeAkunNew', array(
                        'rekeningSatu' => $rekeningSatu,
                        'rekeningDua' => $rekeningDua,
                        'rekeningTiga' => $rekeningTiga,
                        'rekeningEmpat' => $rekeningEmpat,
                        'rekeningLima' => $rekeningLima,
                    ), true); ?>
                </td>
                <td style="padding:10px;" id="side_win">
                    <div id="content_form">
                        <div style="text-align: center;">Klik Tombol Tambah untuk menampilkan<br>Form Inputan</div>
                    </div>
                </td>
            </tr>
        </table>
        <hr>
        <?php
        echo $this->renderPartial('__dataGridRekening', array('model' => $rekeningakuntansiV));
        ?>
    </div>
</div>
<script type="text/javascript">
    var frmRekeningSatu = new String(<?php echo CJSON::encode($this->renderPartial('__formInputRekeningSatu', array('rekeningSatu' => $rekeningSatu), true)); ?>);
    var frmRekeningDua = new String(<?php echo CJSON::encode($this->renderPartial('__formInputRekeningDua', array('rekeningDua' => $rekeningDua), true)); ?>);
    var frmJenisRekening = new String(<?php echo CJSON::encode($this->renderPartial('__formInputJenisRekening', array('jenisRekening' => $rekeningTiga), true)); ?>);
    var frmObyekRekening = new String(<?php echo CJSON::encode($this->renderPartial('__formInputObyekRekening', array('model' => $rekeningEmpat), true)); ?>);
    var frmObyekDetailRekening = new String(<?php echo CJSON::encode($this->renderPartial('__formInputObyekDetailRekeningNew', array('model' => $rekeningLima), true)); ?>);

    function setTreeMenu() {
        $("#browser").treeview({
            animated: "fast",
            collapsed: false,
            unique: true,
            persist: "cookie"
        });
    }
    setTreeMenu();

    //function getTreeMenu()
    //{
    //    $.ajax({
    //        url:"<?php echo Yii::app()->createUrl('ActionAjax/getTreeMenu') ?>",
    //        context:"#tree_rekening_satu"
    //    }).done(
    //        function(data){
    //            data = jQuery.parseJSON(data);
    //            $("#tree_rekening_satu").empty();
    //
    //            setTimeout(function(){
    //                $("#tree_rekening_satu").append(data);
    //                setTreeMenu();
    //                jQuery('a[rel="tooltip"],button[rel="tooltip"],input[rel="tooltip"]').tooltip({'placement':'bottom'});
    //            }, 50);
    //        }
    //    );
    //}

    function hapusIndexMenu() {
        for (key in id_form) {
            delete id_form[key];
        }
        $('#content_form').empty();
    }

    function tambahStrukturRekening(obj) {
        hapusIndexMenu();
        if (id_form['satu'] == undefined) {
            $('#content_form').append(frmRekeningSatu.replace());



            id_form['satu'] = 'yes';
            var max_kode = $(obj).attr('max_kode');
            max_kode = parseInt(max_kode);
            max_kode = max_kode + 1;
            if (!jQuery.isNumeric(max_kode)) {
                max_kode = 1;
            }
            if (max_kode.length > 1) {
                max_kode = max_kode;
            } else {
                max_kode = //"0" +
                    max_kode;
            }
            $('#fieldsetRekeningSatu').parents(".panel").find('.form_judul').text("Tambah");
            $('#fieldsetRekeningSatu').find("input[name$='[kdrekening1]']").val(max_kode);

            setFormPos(obj);
        }
    }

    function editStrukturRekening(obj) {
        hapusIndexMenu();
        if (id_form['satu'] == undefined) {
            $('#content_form').append(frmRekeningSatu.replace());



            id_form['satu'] = 'yes';
            var value = $(obj).attr('value');
            $('#fieldsetRekeningSatu').parents(".panel").find('.form_judul').text("Edit");
            $.post("<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getInformasiStruktur'); ?>", {
                    id: value
                },
                function(data) {
                    $.each(data, function(key, value) {
                        $("#form-rekening-satu").find("input[type=text][name$='[" + key + "]']").val(value);
                        $("#form-rekening-satu").find("input[type=hidden][name$='[" + key + "]']").val(value);
                        $("#form-rekening-satu").find("select[name$='[" + key + "]']").val(value);

                        if (key == 'rekening1_aktif') {
                            var x = 0;
                            if (value == true) {
                                x = 1;
                            }
                            key = key + "_" + x;
                            $("#form-rekening-satu").find("input[type=radio][id='AKRekening1M_" + key + "']").attr('checked', true);
                        }
                    });
                }, "json"
            );

            setFormPos(obj);
        }
    }

    function tambahKelompokRekening(obj) {
        hapusIndexMenu();
        if (id_form['dua'] == undefined) {
            $('#content_form').append(frmRekeningDua.replace());


            var debitkredit = $(obj).data('debitkredit');
            var kode_rek = $(obj).attr('kode_rek');
            console.log("debit kredit", debitkredit);

            id_form['dua'] = 'yes';

            var max_kode = $(obj).attr('max_kode');
            max_kode = parseInt(max_kode);
            max_kode = max_kode + 1;
            if (max_kode.length > 1) {
                max_kode = max_kode;
            } else {
                max_kode = //"0" +
                    max_kode;
            }
            var kode_rek = $(obj).attr('kode_rek');
            var id_rek = $(obj).attr('id_rek');

            $('#fieldsetRekeningDua').find("input[name$='[rekening1_id]']").val(id_rek);
            $('#fieldsetRekeningDua').find("input[name$='[kdrekening1]']").val(kode_rek);
            $('#fieldsetRekeningDua').find("input[name$='[kdrekening2]']").val(max_kode);
            $('#fieldsetRekeningDua').find(".rekening2_nb").val(debitkredit);

            if (kode_rek.charAt(0) == "1" || kode_rek.charAt(0) == "8") {
                $('#fieldsetRekeningDua').find(".rekening2_nb_select").attr('disabled', false);
            } else {
                $('#fieldsetRekeningDua').find(".rekening2_nb_select").attr('disabled', true);
            }

            $('#fieldsetRekeningDua').parents(".panel").find('.form_judul').text("Tambah");
            setFormPos(obj);
        }
    }


    function editKelompokRekening(obj) {
        hapusIndexMenu();
        if (id_form['satu'] == undefined) {
            $('#content_form').append(frmRekeningDua.replace());



            id_form['satu'] = 'yes';
            var value = $(obj).attr('value');
            $('#fieldsetRekeningDua').parents(".panel").find('.form_judul').text("Edit");
            $.post("<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getInformasiKelompok'); ?>", {
                    id: value
                },
                function(data) {

                    var kode_rek = $(obj).attr('kode_rek');
                    if (kode_rek.charAt(0) == "1" || kode_rek.charAt(0) == "8") {
                        $('#fieldsetRekeningDua').find(".rekening2_nb_select").attr('disabled', false);
                    } else {
                        $('#fieldsetRekeningDua').find(".rekening2_nb_select").attr('disabled', true);
                    }

                    $.each(data, function(key, value) {



                        $("#form-rekening-dua").find("input[type=text][name$='[" + key + "]']").val(value);
                        $("#form-rekening-dua").find("input[type=hidden][name$='[" + key + "]']").val(value);
                        $("#form-rekening-dua").find("select[name$='[" + key + "]']").val(value);

                        if (key == 'rekening2_aktif') {
                            var x = 0;
                            if (value == true) {
                                x = 1;
                            }
                            key = key + "_" + x;
                            $("#form-rekening-dua").find("input[type=radio][id='AKRekening2M_" + key + "']").attr('checked', true);
                        }
                    });
                }, "json"
            );

            setFormPos(obj);
        }
    }

    function tambahJenisRekening(obj) {
        hapusIndexMenu();
        if (id_form['tiga'] == undefined) {
            $('#content_form').append(frmJenisRekening.replace());

            var debitkredit = $(obj).data('debitkredit');
            var kode_rek2 = $(obj).attr('kode_rek');
            console.log("Kode Rek 3", kode_rek);
            id_form['tiga'] = 'yes';

            var max_kode = $(obj).attr('max_kode');
            max_kode = parseInt(max_kode);
            max_kode = max_kode + 1;
            if (max_kode.length > 1) {
                max_kode = max_kode;
            } else {
                max_kode = //"0" +
                    max_kode;
            }

            var kode_rek = $(obj).attr('kode_rek').split("_");
            var id_rek = $(obj).attr('id_rek').split("_");

            $('#fieldsetJenisRekening').find("input[name$='[rekening2_id]']").val(id_rek[1]);

            $('#fieldsetJenisRekening').find("input[name$='[kdrekening2]']").val(kode_rek[1]);
            $('#fieldsetJenisRekening').find("input[name$='[kdrekening3]']").val(max_kode);

            $('#fieldsetJenisRekening').find(".rekening3_nb").val(debitkredit);

            if (kode_rek2.charAt(0) == "1" || kode_rek2.charAt(0) == "8") {
                $('#fieldsetJenisRekening').find(".rekening3_nb_select").attr('disabled', false);
            } else {
                $('#fieldsetJenisRekening').find(".rekening3_nb_select").attr('disabled', true);
            }

            $('#fieldsetJenisRekening').parents(".panel").find('.form_judul').text("Tambah");

            setFormPos(obj);
        }
    }

    function editJenisRekening(obj) {
        hapusIndexMenu();
        if (id_form['tiga'] == undefined) {
            $('#content_form').append(frmJenisRekening.replace());



            id_form['tiga'] = 'yes';
            var value = $(obj).attr('value');
            $('#fieldsetJenisRekening').parents(".panel").find('.form_judul').text("Edit");
            $.post("<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getInformasiJenis'); ?>", {
                    id: value
                },
                function(data) {

                    var kode_rek = $(obj).attr('kode_rek');
                    if (kode_rek.charAt(0) == "1" || kode_rek.charAt(0) == "8") {
                        $('#fieldsetJenisRekening').find(".rekening3_nb_select").attr('disabled', false);
                    } else {
                        $('#fieldsetJenisRekening').find(".rekening3_nb_select").attr('disabled', true);
                    }


                    $.each(data, function(key, value) {
                        $("#form-jenis-rekening").find("input[type=text][name$='[" + key + "]']").val(value);
                        $("#form-jenis-rekening").find("input[type=hidden][name$='[" + key + "]']").val(value);
                        $("#form-jenis-rekening").find("select[name$='[" + key + "]']").val(value);

                        if (key == 'rekening3_aktif') {
                            var x = 0;
                            if (value == true) {
                                x = 1;
                            }
                            key = key + "_" + x;
                            $("#form-jenis-rekening").find("input[type=radio][id='AKRekening3M_" + key + "']").attr('checked', true);
                        }
                    });
                }, "json"
            );

            setFormPos(obj);
        }
    }

    function tambahObyekRekening(obj) {
        hapusIndexMenu();
        if (id_form['empat'] == undefined) {
            $('#content_form').append(frmObyekRekening.replace());

            var debitkredit = $(obj).data('debitkredit');
            var kode_rek2 = $(obj).attr('kode_rek');
            id_form['empat'] = 'yes';

            var max_kode = $(obj).attr('max_kode');
            max_kode = parseInt(max_kode);
            max_kode = max_kode + 1;
            if (max_kode.length > 1) {
                max_kode = max_kode;
            } else {
                max_kode = // "0" +
                    max_kode;
            }

            var kode_rek = $(obj).attr('kode_rek').split("_");
            var id_rek = $(obj).attr('id_rek').split("_");

            $('#fieldsetObyekRekening').find("input[name$='[rekening3_id]']").val(id_rek[2]);

            $('#fieldsetObyekRekening').find("input[name$='[kdrekening3]']").val(kode_rek[2]);
            $('#fieldsetObyekRekening').find("input[name$='[kdrekening4]']").val(max_kode);


            $('#fieldsetObyekRekening').find(".rekening4_nb").val(debitkredit);

            if (kode_rek2.charAt(0) == "1" || kode_rek2.charAt(0) == "8") {
                $('#fieldsetObyekRekening').find(".rekening4_nb_select").attr('disabled', false);
            } else {
                $('#fieldsetObyekRekening').find(".rekening4_nb_select").attr('disabled', true);
            }

            $('#fieldsetObyekRekening').parents(".panel").find('.form_judul').text("Tambah");

            setFormPos(obj);
        }
    }

    function editObyekRekening(obj) {
        hapusIndexMenu();
        if (id_form['empat'] == undefined) {
            $('#content_form').append(frmObyekRekening.replace());



            id_form['empat'] = 'yes';
            var value = $(obj).attr('value');
            $('#fieldsetObyekRekening').parents(".panel").find('.form_judul').text("Edit");
            $.post("<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getInformasiObyek'); ?>", {
                    id: value
                },
                function(data) {

                    var kode_rek = $(obj).attr('kode_rek');
                    if (kode_rek.charAt(0) == "1" || kode_rek.charAt(0) == "8") {
                        $('#fieldsetObyekRekening').find(".rekening4_nb_select").attr('disabled', false);
                    } else {
                        $('#fieldsetObyekRekening').find(".rekening4_nb_select").attr('disabled', true);
                    }


                    $.each(data, function(key, value) {
                        $("#form-obyek-rekening").find("input[type=text][name$='[" + key + "]']").val(value);
                        $("#form-obyek-rekening").find("input[type=hidden][name$='[" + key + "]']").val(value);
                        $("#form-obyek-rekening").find("select[name$='[" + key + "]']").val(value);

                        if (key == 'rekening4_aktif') {
                            var x = 0;
                            if (value == true) {
                                x = 1;
                            }
                            key = key + "_" + x;
                            $("#form-obyek-rekening").find("input[type=radio][id='AKRekening4M_" + key + "']").attr('checked', true);
                        }
                    });
                }, "json"
            );

            setFormPos(obj);
        }
    }

    function tambahObyekDetailRekening(obj, normal) {
        hapusIndexMenu();
        $('#content_form').append(frmObyekDetailRekening.replace());
        $('#content_form').find('.panel-heading').find('.panel-title').find('#pnl_judul').html('Tambah');

        var debitkredit = $(obj).data('debitkredit');
        var kode_rek2 = $(obj).attr('kode_rek');
        var parent_id = $(obj).data('parentid');
        var level = $(obj).data('levelrek');
        var namarekening = $(obj).data('namarek');
        var kelrekening = $(obj).data('kelrekening');
        var tiperekening = $(obj).data('tiperekening');
        var parentkode_rek = $(obj).attr('parentkode_rek');


        $('#AKRekening5M_levelrek').val(level)
        $('#AKRekening5M_tiperekening_id').val(tiperekening)
        // $('#AKRekening5M_rekening5_nb').val(debitkredit)
        if (level != 1) {
            $('#AKRekening5M_parent_nmrekening5').val(parentkode_rek + ' - ' + namarekening);
        }
        id_form['empat'] = 'yes';

        var max_kode = $(obj).attr('max_kode');
        // console.log(max_kode)

        // max_kode = parseInt(max_kode);
        // console.log(max_kode)

        max_kode = parseInt(max_kode) + 1;

        if (max_kode.length > 1) {
            max_kode = max_kode;
        } else {
            max_kode = max_kode;
        }
        var kode_rek = $(obj).attr('kode_rek').split("_");
        var id_rek = $(obj).attr('id_rek').split("_");

        $('#fieldsetDetailObyekRekening').find("input[name$='[kdrekening5]']").val(max_kode);
        $('#fieldsetDetailObyekRekening').find("input[name$='[levelrek]']").val(level);
        $('#fieldsetDetailObyekRekening').find("input[name$='[parent_id]']").val(parent_id);
        $('#fieldsetDetailObyekRekening').find("select[name$='[rekening5_nb]']").val(debitkredit);
        $('#fieldsetDetailObyekRekening').find("select[name$='[kelrekening_id]']").val(kelrekening);

        $('#fieldsetDetailObyekRekening').find(".rekening5_nb").val(debitkredit);

        if (kode_rek2.charAt(0) == "1" || kode_rek2.charAt(0) == "8") {
            $('#fieldsetDetailObyekRekening').find(".rekening5_nb_select").attr('disabled', false);
        } else {
            $('#fieldsetDetailObyekRekening').find(".rekening5_nb_select").attr('disabled', true);
        }

        $('#fieldsetDetailObyekRekening').parents(".panel").find('.form_judul').text("Tambah");

        setFormPos(obj);
    }

    function editObyekDetailRekening(obj) {
        hapusIndexMenu();
        if (id_form['lima'] == undefined) {
            $('#content_form').append(frmObyekDetailRekening.replace());

            $('#content_form').find('.panel-heading').find('.panel-title').find('#pnl_judul').html('Ubah');
            
            id_form['lima'] = 'yes';
            var value = $(obj).attr('value');
            $('#fieldsetDetailObyekRekening').parents(".panel").find('.form_judul').text("Edit");
            $.post("<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getInformasiDetailObyek'); ?>", {
                    id: value
                },
                function(data) {
                    var kode_rek = $(obj).attr('kode_rek');
                    if (kode_rek.charAt(0) == "1" || kode_rek.charAt(0) == "8") {
                        $('#fieldsetDetailObyekRekening').find(".rekening5_nb_select").attr('disabled', false);
                    } else {
                        $('#fieldsetDetailObyekRekening').find(".rekening5_nb_select").attr('disabled', true);
                    }
                    $("#form-detail-obyek-rekening").find('#AKRekening5M_parent_nmrekening5').val(data.parent_kode + ' - ' + data.parent_nama);
                    $.each(data, function(key, value) {
                        $("#form-detail-obyek-rekening").find("input[type=text][name$='[" + key + "]']").val(value);
                        $("#form-detail-obyek-rekening").find("textarea[name$='[" + key + "]']").val(value);
                        $("#form-detail-obyek-rekening").find("input[type=hidden][name$='[" + key + "]']").val(value);
                        $("#form-detail-obyek-rekening").find("select[name$='[" + key + "]']").val(value);

                        if (key == 'rekening5_aktif') {
                            var x = 0;
                            if (value == true) {
                                x = 1;
                            }
                            key = key + "_" + x;
                            $("#form-detail-obyek-rekening").find("input[type=radio][id='AKRekening5M_" + key + "']").attr('checked', true);
                        }
                    });
                }, "json"
            );

            setFormPos(obj);
        }
    }

    function refreshTree() {
        $("#ka-viewtree").empty();
        $.post("<?php echo $this->createUrl('index'); ?>", {
            is_ajax: true,
            f: "loadTree",
        }, function(data) {
            $("#ka-viewtree").html(data);
            setTreeMenu();
        });
    }

    function setFormPos(obj) {
        var side_win_bound = $("#side_win").get()[0].getBoundingClientRect();
        var clicked_bound = obj.getBoundingClientRect();
        var panel_bound = $("#content_form .panel").get()[0].getBoundingClientRect();

        var scrollPos = $(window).scrollTop();


        var panel_pos = (((-(side_win_bound.height / 2) + (panel_bound.height / 2))) + (clicked_bound.top - side_win_bound.top));

        console.log("panel pos", panel_pos);
        console.log("panel height", panel_bound.height);
        console.log("side height", side_win_bound.height / 2);

        if (panel_pos + panel_bound.height > side_win_bound.height / 2) {

            panel_pos = (side_win_bound.height / 2) - panel_bound.height / 2;
        }

        console.log("Side win", side_win_bound);
        console.log("Clicked", clicked_bound);




        console.log(-side_win_bound.height / 2);

        $("#content_form .panel")
            .css("position", "relative")
            .css("top", panel_pos + "px");

    }

    //function exportTemplateCsv(){
    ////        tableName = $("#tableName").val();
    ////        jenis = 'export';
    ////        if (tableName != ''){
    //            window.open("<?php // echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/eksportCSV'); 
                                ?>"+$('#AKRekeningakuntansi-v :input').serialize(),"",'location=_new, width=900px');
    ////        }
    ////        else{
    ////            myAlert("Silakan isi nama tabel!");
    ////        }
    //    }
</script>