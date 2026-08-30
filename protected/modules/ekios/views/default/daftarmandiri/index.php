<!DOCTYPE html>
<html>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <style>

        .footer, .footer-space {
            height: 5cm;
        }


        body {
            background-color: #f1f1f1;
        }

        #regForm {
            background-color: #ffffff;
            /*  margin: 100px auto;*/
            font-family: Raleway;
            /*            padding: 40px;*/
            width: 100%;
            /*  min-width: 300px;*/
        }

        h1 {
            text-align: center;  
        }

        input {
            padding: 10px;
            width: 100%;
            /*            font-size: 17px;*/
            font-family: Raleway;
            border: 1px solid #aaaaaa;
        }

        /* Mark input boxes that gets an error on validation: */
        input.invalid {
            background-color: #ffdddd;
        }

        /* Hide all steps by default: */
        .tab {
            display: none;
            padding-top: 50px;
        }

        button {
            background-color: #4CAF50;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            /*            font-size: 17px;*/
            font-family: Raleway;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.8;
        }

        #prevBtn,#prevlist{
            background-color: #bbbbbb;
        }


        /* Make circles that indicate the steps of the form: */
        .step {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbbbbb;
            border: none;  
            border-radius: 50%;
            display: inline-block;
            opacity: 0.5;
        }

        .step.active {
            opacity: 1;
        }

        /* Mark the steps that are finished and valid: */
        .step.finish {
            background-color: #4CAF50;
        }
        .tile-purple {
            background-color:white !important;
            border: 2px solid #c31884;
        }
        .tile-stats.tile-purple .num{
            color:#c31884;
        }
    </style>
    <body>
        <?php
        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl('ekios/Default/ambilDataPasien'),
            'method' => 'post',
            'id' => 'ppbuat-janji-poli-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('id' => 'regForm', 'onKeyPress' => 'return disableKeyPress(event)', ''),
        ));
        ?>
        <?php
        $modPasien = new PPPasienM();
        $modPPBuatJanjiPoli = new BuatjanjipoliT();
        ?>
        <h1></h1>
        <!-- One "tab" for each step in the form: -->

        <div class="tab form-user1" align="center">
            <div><h1><b>Pendaftaran Pasien Mandiri</b></h1></div><br>
            <p><?php echo $form->textField($modPasien, 'no_rekam_medik', array('placeholder' => 'Nomer Rekam Medik', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span12','required'=>true)); ?></p>
            

           
        </div>
         
  <div class="tab">
            <input type="hidden" class="pendaftaran_id">
            <input type="hidden" class="pasien_id">
            <div class="row" id="menudokumen">
                <div class="col-xs-6 ">
                    <a href="#" onclick="setKwitansi($('.pasien_id').val())">
                        <div class="tile-stats tile-purple" style="height:100px;" onclick="tampil(this)">
                            <div class="icon"><i class="entypo-doc-text"></i></div>
                            <div class="num" style="font-size:14pt"><b>KWITANSI</b></div>

                        </div>
                    </a>    

                </div>
                <div class="col-xs-6">
                    <a href="#" onclick="setEresep($('.pendaftaran_id').val())">
                        <div class="tile-stats tile-purple" style="height:100px;">
                            <div class="icon"><i class="entypo-doc-text"></i></div>
                            <div class="num" style="font-size:14pt"><b>ERESEP</b></div>

                        </div>
                    </a>

                </div>
                <div class="col-xs-6  ">
                    <a href="#" onclick="setKeteranganSehat($('.pendaftaran_id').val())">
                        <div class="tile-stats tile-purple" style="height:100px;" >
                            <div class="icon"><i class="entypo-doc-text"></i></div>
                            <div class="num" style="font-size:12pt"><b>SURAT KETERANGAN SEHAT</b></div>

                        </div>
                    </a>    

                </div>
                <div class="col-xs-6  ">
                    <a href="#" onclick="setSuratRujukan($('.pendaftaran_id').val())">
                        <div class="tile-stats tile-purple" style="height:100px;" onclick="tampil(this)">
                            <div class="icon"><i class="entypo-doc-text"></i></div>
                            <div class="num" style="font-size:14pt"><b>RUJUKAN KELUAR</b></div>

                        </div>
                    </a>     
                </div>
                <div class="col-xs-6  ">
                    <a href="#" onclick="setKeteranganSakit($('.pendaftaran_id').val())">
                        <div class="tile-stats tile-purple" style="height:100px;" >
                            <div class="icon"><i class="entypo-doc-text"></i></div>
                            <div class="num" style="font-size:14pt;"><b>SURAT KETERANGAN SAKIT</b></div>

                        </div>
                    </a>    
                </div>  
            </div>    
            <div id="keterangandokumen">

            </div>


        </div>
        <div >
            <div style="margin-left:285px">

                <button type="submit" style="background-color:#57a595" id="nextBtn" onclick="nextPrev(1)">Lanjutkan</button>
                <!--                <button type="submit" id="btn_simpan" onclick="">Simpan</button>-->

            </div>
        </div>
      
        
        <?php $this->endWidget(); ?>

        <script>

            $(document).ready(function () {
                $("#btn_simpan").show();
                $("#picker_date").hide();

            });
            var currentTab = 0; // Current tab is set to be the first tab (0)
            showTab(currentTab); // Display the crurrent tab

            function showTab(n) {
                console.log("sdsd" + currentTab);
                // This function will display the specified tab of the form...
                var x = document.getElementsByClassName("tab");
                x[n].style.display = "block";

                if (n == (x.length - 1)) {

                    //document.getElementById("nextBtn").innerHTML = "Simpan";
                    $("#nextBtn").hide();
                    $("#prevBtn").show();
                    $("#prevlist").hide();


                } else {

                    document.getElementById("nextBtn").innerHTML = "Lanjutkan";
                    $("#nextBtn").show();
                    $("#prevBtn").hide();
                    $("#prevlist").hide();

                }
                //... and run a function that will display the correct step indicator:
                fixStepIndicator(n)
            }

            function nextPrev(n) {
                var inisial = $('#inisial').val();
                var norekam = $('#PPPasienM_no_rekam_medik').val();
                var tgllahir = $('#picker').val();
                console.log(inisial);
                var statusaksi = false;


                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createUrl('/ekios/Default/ValidasiUtama') ?>',
                    data: {norekam: norekam, tgllahir: tgllahir},
                    dataType: "json",
                    success: function (data) {

                        if (data.status != false) {

                            //console.log(data.jenisidentitas);
                            statusaksi = true;

                            if (statusaksi == true && inisial == 1) {
                                $(".pendaftaran_id").val(data.pendaftaran_id);
                                $(".pasien_id").val(data.pasien_id);
                                $("#inisial").val("2");
                                // This function will figure out which tab to display
                                var x = document.getElementsByClassName("tab");
                                // Exit the function if any field in the current tab is invalid:
                                if (n == 1 && !validateForm())
                                    return false;
                                // Hide the current tab:
                                x[currentTab].style.display = "none";
                                // Increase or decrease the current tab by 1:
                                currentTab = currentTab + n;

                                // Otherwise, display the correct tab:
                                showTab(currentTab);

                            } else if (statusaksi == true && inisial == 2) {
                                // This function will figure out which tab to display
                                $(".pendaftaran_id").val(data.pendaftaran_id);
                                $(".pasien_id").val(data.pasien_id);
                                var x = document.getElementsByClassName("tab");
                                // Exit the function if any field in the current tab is invalid:
                                if (n == 1 && !validateForm())
                                    return false;
                                // Hide the current tab:
                                x[currentTab].style.display = "none";
                                // Increase or decrease the current tab by 1:
                                currentTab = currentTab + n;

                                // Otherwise, display the correct tab:
                                showTab(currentTab);


                            } else {
                                return false;
                            }
                        } else {
                            statusaksi = false;
                            alert("No RM atau Tanggal Lahir Salah, Mohon di Periksa Kembali");
                        }
                    }
                });


                console.log(statusaksi);

            }

            function validateForm() {
                // This function deals with validation of the form fields
                var x, y, i, valid = true;

                x = document.getElementsByClassName("tab");
                y = x[currentTab].getElementsByTagName("input");
                // A loop that checks every input field in the current tab:
                for (i = 0; i < y.length; i++) {
                    // If a field is empty...
                    if (y[i].value == "") {
                        // add an "invalid" class to the field:
                        y[i].className += " invalid";
                        // and set the current valid status to false
                        valid = false;
                    }
                }
                // If the valid status is true, mark the step as finished and valid:
                if (valid) {
                    document.getElementsByClassName("step")[currentTab].className += " finish";
                }
                return valid; // return the valid status
            }

            function fixStepIndicator(n) {
                // This function removes the "active" class of all steps...
                var i, x = document.getElementsByClassName("step");
                for (i = 0; i < x.length; i++) {
                    x[i].className = x[i].className.replace(" active", "");
                }
                //... and adds the "active" class on the current step:
                x[n].className += " active";
            }

            function setKeteranganSehat(pendaftaran_id) {
                $("#keterangandokumen").addClass("animation-loading");
                $('#keterangandokumen').html("");
                console.log(pendaftaran_id);
                $.ajax({
                    type: 'GET',
                    url: '<?php echo $this->createUrl('SetKeteranganSehat'); ?>',
                    data: {pendaftaran_id: pendaftaran_id}, //
                    dataType: "json",
                    success: function (data) {
                        $("#menudokumen").hide();
                        $("#prevlist").show();
                        $("#prevBtn").hide();
                        $('#keterangandokumen').append(data.form);
                        $('#keterangandokumen').removeClass("animation-loading");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }


            function setSuratRujukan(pendaftaran_id) {
                $("#keterangandokumen").addClass("animation-loading");
                $('#keterangandokumen').html("");
                console.log(pendaftaran_id);
                $.ajax({
                    type: 'GET',
                    url: '<?php echo $this->createUrl('SetSuratRujukan'); ?>',
                    data: {pendaftaran_id: pendaftaran_id}, //
                    dataType: "json",
                    success: function (data) {
                        $("#menudokumen").hide();
                        $("#prevlist").show();
                        $("#prevBtn").hide();
                        $('#keterangandokumen').append(data.form);
                        $('#keterangandokumen').removeClass("animation-loading");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert("Anda Mungkin Belum Membuat Surat");
                        console.log(errorThrown);

                    }
                });
            }

            function setKeteranganSakit(pendaftaran_id) {
                $("#keterangandokumen").addClass("animation-loading");
                $('#keterangandokumen').html("");
                // console.log(pendaftaran_id);
                $.ajax({
                    type: 'GET',
                    url: '<?php echo $this->createUrl('SetKeteranganSakit'); ?>',
                    data: {pendaftaran_id: pendaftaran_id}, //
                    dataType: "json",
                    success: function (data) {
                        $("#menudokumen").hide();
                        $("#prevlist").show();
                        $("#prevBtn").hide();
                        $('#keterangandokumen').append(data.form);
                        $('#keterangandokumen').removeClass("animation-loading");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert("Anda Mungkin Belum Membuat Surat");
                        console.log(errorThrown);

                    }
                });
            }

            function setEresep(pendaftaran_id) {
                $("#keterangandokumen").addClass("animation-loading");
                $('#keterangandokumen').html("");
                console.log(pendaftaran_id);
                $.ajax({
                    type: 'GET',
                    url: '<?php echo $this->createUrl('SetEresep'); ?>',
                    data: {pendaftaran_id: pendaftaran_id}, //
                    dataType: "json",
                    success: function (data) {

                        if (data.status == true) {
                            $("#menudokumen").hide();
                            $("#prevlist").show();
                            $("#prevBtn").hide();
                            $('#keterangandokumen').append(data.form);


                        } else {
                            alert("Pastikan Anda Menggunakan no Pendaftaran Tebaru");
                        }
                        $('#keterangandokumen').removeClass("animation-loading");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
            function showlist() {
                $("#menudokumen").show();
                $('#keterangandokumen').html("");
                $("#prevBtn").show();
                $("#prevlist").hide();
            }


            function setKwitansi(pasien_id) {
                $("#keterangandokumen").addClass("animation-loading");
                $('#keterangandokumen').html("");
                console.log(pasien_id);
                $.ajax({
                    type: 'GET',
                    url: '<?php echo $this->createUrl('SetKwitansi'); ?>',
                    data: {pasien_id: pasien_id}, //
                    dataType: "json",
                    success: function (data) {

                        if (data.status == true) {
                            $("#menudokumen").hide();
                            $("#prevlist").show();
                            $("#prevBtn").hide();
                            $('#keterangandokumen').append(data.form);


                        } else {
                            alert("Pastikan Anda Mempunyai Riwayat Pembayaran");
                        }
                        $('#keterangandokumen').removeClass("animation-loading");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        </script>

    </body>
</html>
