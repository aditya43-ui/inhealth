<script>
    /**
     * set form kunjungan
     * @param {type} pasienanastesi_id, pendaftaran_id, pasienmasukpenunjang_id
     * @returns {undefined}
     */
    function setKunjungan(pasienanastesi_id, pendaftaran_id, pasienmasukpenunjang_id) {
        $("#form-datakunjungan > div").addClass("animation-loading");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetDataKunjungan'); ?>',
            data: {pasienanastesi_id: pasienanastesi_id, pendaftaran_id: pendaftaran_id, pasienmasukpenunjang_id: pasienmasukpenunjang_id},
            dataType: "json",
            success: function (data) {
                if (data.pesan != "") {
                    myAlert(data.pesan);
                    setKunjunganReset();
                } else {
                    $("#<?php echo CHtml::activeId($modKunjungan, 'pasienanastesi_id'); ?>").val(data.pasienanastesi_id);
                    $("#<?php echo CHtml::activeId($modKunjungan, 'pendaftaran_id'); ?>").val(data.pendaftaran_id);
                    $("#<?php echo CHtml::activeId($modKunjungan, 'pasien_id'); ?>").val(data.pasien_id);
                    $("#<?php echo CHtml::activeId($modKunjungan, 'pasienmasukpenunjang_id'); ?>").val(data.pasienmasukpenunjang_id);
                    $("#<?php echo CHtml::activeId($modKunjungan, 'noanestesi'); ?>").val(data.noanestesi);
                    $("#<?php echo CHtml::activeId($modKunjungan, 'tglanastesi'); ?>").val(data.tglanastesi);
                    $("#<?php echo CHtml::activeId($modKunjungan, 'umur'); ?>").val(data.umur);
                    $("#<?php echo CHtml::activeId($modKunjungan, 'jeniskasuspenyakit_id'); ?>").val(data.jeniskasuspenyakit_id);
                    $("#<?php echo CHtml::activeId($modKunjungan, 'jeniskasuspenyakit_nama'); ?>").val(data.jeniskasuspenyakit_nama);
                    $("#<?php echo CHtml::activeId($modKunjungan, 'pegawai_id'); ?>").val(data.nama_pegawai);
                    $("#<?php echo CHtml::activeId($modKunjungan, 'no_rekam_medik'); ?>").val(data.no_rekam_medik);
                    $("#<?php echo CHtml::activeId($modKunjungan, 'nama_pasien'); ?>").val(data.nama_pasien);
                    $("#<?php echo CHtml::activeId($modKunjungan, 'jeniskelamin'); ?>").val(data.jeniskelamin);
                    $("#<?php echo CHtml::activeId($modKunjungan, 'pekerjaan_id'); ?>").val(data.pekerjaan_id);
                    $("#<?php echo CHtml::activeId($modKunjungan, 'pekerjaan_nama'); ?>").val(data.pekerjaan_nama);
                    $("#<?php echo CHtml::activeId($modKunjungan, 'kelaspelayanan_id'); ?>").val(data.kelaspelayanan_id);
                    $("#<?php echo CHtml::activeId($modKunjungan, 'kelaspelayanan_nama'); ?>").val(data.kelaspelayanan_nama);
                    $("#<?php echo CHtml::activeId($modKunjungan, 'alamat_pasien'); ?>").val(data.alamat_pasien);
                    $("#<?php echo CHtml::activeId($model, 'pegawai_id'); ?>").val(data.pegawai_id);
                    $("#<?php echo CHtml::activeId($model, 'nama_pegawai'); ?>").val(data.nama_pegawai);

                    $("#<?php echo CHtml::activeId($modIntraAnestesi, 'ventilasi_circuit'); ?>").val(data.ventilasi_circuit);
                    $("#<?php echo CHtml::activeId($modIntraAnestesi, 'ventilasi_spontan'); ?>").val(data.ventilasi_spontan);
                    $("#<?php echo CHtml::activeId($modIntraAnestesi, 'ventilasi_assisted'); ?>").val(data.ventilasi_assisted);
                    $("#<?php echo CHtml::activeId($modIntraAnestesi, 'ventilasi_cmv'); ?>").val(data.ventilasi_cmv);
                    $("#<?php echo CHtml::activeId($modIntraAnestesi, 'ventilasi_pcv'); ?>").val(data.ventilasi_pcv);

                    $("#<?php echo CHtml::activeId($modIntraAnestesi, 'ventilasi_tv'); ?>").val(data.ventilasi_tv);
                    $("#<?php echo CHtml::activeId($modIntraAnestesi, 'ventilasi_rate'); ?>").val(data.ventilasi_rate);
                    $("#<?php echo CHtml::activeId($modIntraAnestesi, 'ventilasi_peep'); ?>").val(data.ventilasi_peep);
                    $("#<?php echo CHtml::activeId($modIntraAnestesi, 'gasflow_n2o_keterangan'); ?>").val(data.gasflow_n2o_keterangan);
                    $("#<?php echo CHtml::activeId($modIntraAnestesi, 'gasflow_o2_keterangan'); ?>").val(data.gasflow_o2_keterangan);
                    $("#<?php echo CHtml::activeId($modIntraAnestesi, 'gasflow_air_keterangan'); ?>").val(data.gasflow_air_keterangan);
                    $("#tabelgasinhalasi").html(data.tabelgasinhalasi);
                    $("#tabelkristaloid").html(data.tabelkristaloid);
                    $("#tabelkolloid").html(data.tabelkolloid);
                    $("#tabeldarah_wb").html(data.tabeldarah_wb);
                    $("#tabeldarah_prc").html(data.tabeldarah_prc);
                    $("#tabeldarah_ffp").html(data.tabeldarah_ffp);
                    $("#tabeldarah_tc").html(data.tabeldarah_tc);
                    $("#tabeldarah_ppr").html(data.tabeldarah_ppr);

                    $("#<?php echo CHtml::activeId($modObat, 's_dan_i'); ?>").val(data.s_dan_i);
                    $("#<?php echo CHtml::activeId($modObat, 'urin'); ?>").val(data.urin);
                    $("#<?php echo CHtml::activeId($modObat, 'darah'); ?>").val(data.darah);
                    $("#<?php echo CHtml::activeId($modObat, 'ebl'); ?>").val(data.ebl);

                    var data1 = document.getElementById("1");
                    var data2 = document.getElementById("2");
                    var data3 = document.getElementById("3");
                    var data4 = document.getElementById("4");
                    var data5 = document.getElementById("5");
                    var data6 = document.getElementById("6");
                    var data7 = document.getElementById("7");
                    var data8 = document.getElementById("8");
                    var data9 = document.getElementById("9");
                    var data10 = document.getElementById("10");
                    var data11 = document.getElementById("11");
                    var data12 = document.getElementById("12");
                    var data13 = document.getElementById("13");
                    var data14 = document.getElementById("14");
                    var data15 = document.getElementById("15");
                    var data16 = document.getElementById("16");
                    var data17 = document.getElementById("17");
                    var data18 = document.getElementById("18");
                    var data19 = document.getElementById("19");

                    if (data.ventilasi_circuit == true) {
                        data1.style.display = "block";
                    } else {
                        data1.style.display = "none";
                    }
                    if (data.ventilasi_spontan == true) {
                        data2.style.display = "block";
                    } else {
                        data2.style.display = "none";
                    }
                    if (data.ventilasi_assisted == true) {
                        data3.style.display = "block";
                    } else {
                        data3.style.display = "none";
                    }
                    if (data.ventilasi_cmv == true) {
                        data4.style.display = "block";
                    } else {
                        data4.style.display = "none";
                    }
                    if (data.ventilasi_pcv == true) {
                        data5.style.display = "block";
                    } else {
                        data5.style.display = "none";
                    }
                    if (data.ventilasi_tv != null) {
                        data6.style.display = "block";
                    } else {
                        data6.style.display = "none";
                    }
                    if (data.ventilasi_rate != null) {
                        data7.style.display = "block";
                    } else {
                        data7.style.display = "none";
                    }
                    if (data.ventilasi_peep != null) {
                        data8.style.display = "block";
                    } else {
                        data8.style.display = "none";
                    }
                    if (data.gasflow_n2o == true) {
                        data9.style.display = "block";
                    } else {
                        data9.style.display = "none";
                    }
                    if (data.gasflow_o2 == true) {
                        data10.style.display = "block";
                    } else {
                        data10.style.display = "none";
                    }
                    if (data.gasflow_air == true) {
                        data11.style.display = "block";
                    } else {
                        data11.style.display = "none";
                    }
                    if (data.gasflow_gasinhalasi == true) {
                        data12.style.display = "block";
                        $("#<?php echo CHtml::activeId($modIntraAnestesi, 'gasflow_gasinhalasi'); ?>").val('true');
                    } else {
                        data12.style.display = "none";
                        $("#<?php echo CHtml::activeId($modIntraAnestesi, 'gasflow_gasinhalasi'); ?>").val('false');
                    }

                    if (data.tabelkristaloid != '') {
                        data13.style.display = "block";
                    } else {
                        data13.style.display = "none";
                    }
                    if (data.tabelkolloid != '') {
                        data14.style.display = "block";
                    } else {
                        data14.style.display = "none";
                    }

                    if (data.tabeldarah_wb != '') {
                        data15.style.display = "block";
                    } else {
                        data15.style.display = "none";
                    }
                    if (data.tabeldarah_prc != '') {
                        data16.style.display = "block";
                    } else {
                        data16.style.display = "none";
                    }
                    if (data.tabeldarah_ffp != '') {
                        data17.style.display = "block";
                    } else {
                        data17.style.display = "none";
                    }
                    if (data.tabeldarah_tc != '') {
                        data18.style.display = "block";
                    } else {
                        data18.style.display = "none";
                    }
                    if (data.tabeldarah_ppr != '') {
                        data19.style.display = "block";
                    } else {
                        data19.style.display = "none";
                    }
                    if (data.photopasien === null || data.photopasien === "" || data.photopasien === undefined) { //set photo
                        $('#photo-preview').attr('src', '<?php echo Params::urlPhotoPasienDirectory() . "no_photo.jpeg" ?>');
                    } else {
                        $('#photo-preview').attr('src', '<?php echo Params::urlPasienTumbsDirectory() . "kecil_" ?>' + data.photopasien);
                    }
                    if (data.noanestesi == '' || data.noanestesi == null) {
                        var noanestesi = data.no_masukpenunjang;
                    } else {
                        var noanestesi = data.noanestesi;
                    }

                    $("#form-datakunjungan > legend > .judul").html('Data Pasien ' + data.no_masukpenunjang);
                    $("#form-datakunjungan > legend > .tombol").attr('style', 'display:true;');
                    $("#form-datakunjungan > .box").addClass("well").removeClass("box");
                }
                $("#form-datakunjungan > div").removeClass("animation-loading");
                $("#<?php echo CHtml::activeId($modKunjungan, 'noanestesi'); ?>").focus();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                myAlert("Data kunjungan tidak ditemukan !");
                console.log(errorThrown);
                setKunjunganReset();
                $("#form-datakunjungan > div").removeClass("animation-loading");
                $("#<?php echo CHtml::activeId($modKunjungan, 'noanestesi'); ?>").focus();
            }
        });

    }

    /**
     * untuk mereset form kunjungan
     * @returns {undefined} */
    function setKunjunganReset() {
        $("#form-datakunjungan input,textarea").each(function () {
            $(this).val("");
        });
        $('#photo-preview').attr('src', '<?php echo Params::urlPhotoPasienDirectory() . "no_photo.jpeg" ?>');
        $("#form-datakunjungan > legend > .judul").html('Data Pasien');
        $("#form-datakunjungan > legend > .tombol").attr('style', 'display:none;');
        $("#form-datakunjungan > .well").addClass("box").removeClass("well");
    }

    function setTableMonitoring(id) {
        var frame = '<?= !empty($_GET['frame']) ? $_GET['frame'] : 0; ?>';
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setTableMonitoring'); ?>',
            data: {id: id, frame:frame},
            dataType: "json",
            success: function (data) {
                $('#table-monitoringanastesi > tbody').html(data);
                $('#table-monitoringanastesi').removeClass("animation-loading");
                generateGrafik();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }

        });
    }

    function setTombolTambah(id) {
        var frame = '<?= !empty($_GET['frame']) ? $_GET['frame'] : 0; ?>';
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setTombolTambah'); ?>',
            data: {id: id, frame:frame},
            dataType: "json",
            success: function (data) {
                $('#tombolTambah').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }

        });
    }

    function generateGrafik() {
        var tensi = $("#chart_tensi");

        var o = 0;//untuk nadi
        var p = 0;//untuk diastolik
        var q = 0;//untuk sistolik
        var r = 0;//untuk map
        var s = 0;//untuk torniquet
        var t = 0;//untuk spont resp
        var u = 0;//untuk spont resp
        var v = 0;//untuk spont resp
        var arrNadi = [];//untuk pencatatan nadi 
        var arrDias = [];//untuk pencatatan diastolik
        var arrSys = [];//untuk pencatatan sistolik
        var arrMap = [];//untuk pencatatan mean arterial pres (map)   
        var arrTor = [];//untuk pencatatan torniquet
        var arrSR = [];//untuk pencatatan spont resp
        var arrAR = [];//untuk pencatatan assissted resp
        var arrCR = [];//untuk pencatatan controlled resp
        var arrTgl = [];
        var a = 0;

        $("#table-monitoringanastesi > tbody > tr").each(function () {

            //nadi
            if ($(this).find(".kontrol-waktu").val() != '' && $(this).find(".kontrol-nadi").val() != '') {
                arrNadi[o] = {
                    x: $(this).find(".kontrol-waktu").val(),
                    y: $(this).find(".kontrol-nadi").val(),
                };
                o++;
            }

            //sistolik
            if ($(this).find(".kontrol-waktu").val() != '' && $(this).find(".kontrol-systolic").val() != '') {
                arrSys[q] = {
                    x: $(this).find(".kontrol-waktu").val(),
                    y: $(this).find(".kontrol-systolic").val(),
                };
                q++;
            }

            //diastolik
            if ($(this).find(".kontrol-waktu").val() != '' && $(this).find(".kontrol-diastolic").val() != '') {
                arrDias[p] = {
                    x: $(this).find(".kontrol-waktu").val(),
                    y: $(this).find(".kontrol-diastolic").val(),
                };
                p++;
            }

            //mean arterial pres
            if ($(this).find(".kontrol-waktu").val() != '' && $(this).find(".kontrol-map").val() != '') {
                arrMap[r] = {
                    x: $(this).find(".kontrol-waktu").val(),
                    y: $(this).find(".kontrol-map").val(),
                };
                r++;
            }

            //mean torniquet
            if ($(this).find(".kontrol-waktu").val() != '' && $(this).find(".kontrol-torniquet").val() != '') {
                arrTor[s] = {
                    x: $(this).find(".kontrol-waktu").val(),
                    y: $(this).find(".kontrol-torniquet").val(),
                };
                s++;
            }

            //spont resp
            if ($(this).find(".kontrol-waktu").val() != '' && $(this).find(".kontrol-spontresp").val() != '') {
                arrSR[t] = {
                    x: $(this).find(".kontrol-waktu").val(),
                    y: $(this).find(".kontrol-spontresp").val(),
                };
                t++;
            }

            //assisted resp
            if ($(this).find(".kontrol-waktu").val() != '' && $(this).find(".kontrol-assistedresp").val() != '') {
                arrAR[u] = {
                    x: $(this).find(".kontrol-waktu").val(),
                    y: $(this).find(".kontrol-assistedresp").val(),
                };
                u++;
            }

            //controlled resp
            if ($(this).find(".kontrol-waktu").val() != '' && $(this).find(".kontrol-controlledresp").val() != '') {
                arrCR[v] = {
                    x: $(this).find(".kontrol-waktu").val(),
                    y: $(this).find(".kontrol-controlledresp").val(),
                };
                v++;
            }

            //menit-ke
            if ($(this).find(".kontrol-waktu").val() != '') {
                arrTgl[a] = $(this).find(".kontrol-waktu").val();
            }
            a++;
        });

        console.log(arrNadi);

        var lineTensi = new Chart(tensi, {
            type: 'line',
            data: {
                labels: arrTgl,
                datasets: [{
                        label: 'Nadi',
                        yAxisID: 'A',
                        display: false,
                        fill: false,
                        data: arrNadi,
                        backgroundColor: '#4178ab',
                        borderColor: '#4178ab',
                        pointStyle: 'circle',
                        pointRadius: 5,
                        pointBorderColor: '#4178ab',
                    }, {
                        label: 'Diastolik',
                        yAxisID: 'A',
                        display: false,
                        fill: false,
                        data: arrDias,
                        backgroundColor: '#909090',
                        borderColor: '#909090',
                        pointStyle: 'circle',
                        pointRadius: 5,
                        pointBorderColor: '#909090',
                    }, {
                        label: 'Sistolik',
                        yAxisID: 'A',
                        display: false,
                        fill: false,
                        data: arrSys,
                        backgroundColor: '#ca763f',
                        borderColor: '#ca763f',
                        pointStyle: 'circle',
                        pointRadius: 5,
                        pointBorderColor: '#ca763f',
                    }, {
                        label: 'Mean Aterial Pres.',
                        yAxisID: 'A',
                        display: false,
                        fill: false,
                        data: arrMap,
                        backgroundColor: '#d2a114',
                        borderColor: '#d2a114',
                        pointStyle: 'circle',
                        pointRadius: 5,
                        pointBorderColor: '#d2a114',
                    }, {
                        label: 'Torniquet',
                        yAxisID: 'A',
                        display: false,
                        fill: false,
                        data: arrTor,
                        backgroundColor: '#395ea1',
                        borderColor: '#395ea1',
                        pointStyle: 'circle',
                        pointRadius: 5,
                        pointBorderColor: '#395ea1',
                    }, {
                        label: 'Spont Resp.',
                        yAxisID: 'A',
                        display: false,
                        fill: false,
                        data: arrSR,
                        backgroundColor: '#558933',
                        borderColor: '#558933',
                        pointStyle: 'circle',
                        pointRadius: 5,
                        pointBorderColor: '#558933',
                    }, {
                        label: 'Assissted Resp.',
                        yAxisID: 'A',
                        display: false,
                        fill: false,
                        data: arrAR,
                        backgroundColor: '#5396d2',
                        borderColor: '#5396d2',
                        pointStyle: 'circle',
                        pointRadius: 5,
                        pointBorderColor: '#5396d2',
                    }, {
                        label: 'Controlled Resp.',
                        yAxisID: 'A',
                        display: false,
                        fill: false,
                        data: arrCR,
                        backgroundColor: '#ee8e4c',
                        borderColor: '#ee8e4c',
                        pointStyle: 'circle',
                        pointRadius: 5,
                        pointBorderColor: '#ee8e4c',
                    }],
            },
            options: {
                layout: {
                    padding: {
                        left: 50,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                },
                tooltips: {
                    mode: 'nearest',
                    intersect: false,
                },
                legend: {
                    labels: {
                        usePointStyle: true
                    }
                },
                responsive: true,
                title: {
                    display: false,
                    text: ''
                },
                scales: {
                    xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Menit ke'
                            },
                            ticks: {
                                fontSize: 11
                            },
                            categoryPercentage: .1,
                            barPercentage: 1,
                            gridLines: {
                                offsetGridLines: true,
                            }
                        }],
                    yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'TD/N',
                            },
                            id: 'A',
                            type: 'linear',
                            position: 'top',
                            ticks: {
                                min: 0,
                                max: 220,
                                stepSize: 20,
                                fontSize: 11
                            },
                        }, {
                            scaleLabel: {
                                display: true,
                                labelString: 'RR',
                            },
                            id: 'B',
                            type: 'linear',
                            position: 'right',
                            ticks: {
                                min: 10,
                                max: 40,
                                stepSize: 5,
                                fontSize: 11
                            }
                        }],
                },
            },

        });
    }

    function hapus(id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('delete'); ?>',
            data: {id: id},
            dataType: "json",
            success: function (data) {
                $('#table-monitoringanastesi > tbody').html(data);
                $('#table-monitoringanastesi').removeClass("animation-loading");
                generateGrafik();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }

        });
    }
</script>
