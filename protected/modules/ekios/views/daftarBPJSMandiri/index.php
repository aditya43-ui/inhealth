<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/literallycanvas/css/literallycanvas.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/react/build/react-with-addons.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/literallycanvas/js/literallycanvas-core.min.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/notiflix/dist/notiflix-aio-2.7.0.min.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/notiflix/alertnotiflix/notiflixalert.js'); ?>
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Oswald" />
<?php $data = ProfilrumahsakitM::model()->find(); ?>
<style>
    body {
        padding: 0;
        margin: 0;
        background-color: #8B0000;
    }

    .judul_form {
        font-size: 20pt;
        text-align: center;
        margin-bottom: 50px;
    }

    #logo {
        float: left;
        height: 70px;
        background: url("<?php echo Params::urlProfilRSDirectory() . $data->logo_rumahsakit; ?>") left center no-repeat;
        background-size: contain;
    }

    #header {
        display: flex;
        align-items: center;
        height: 120px;
        background-color: #8B0000;
        /* padding-top: -12px; */
    }

    .background {
        position: absolute;
        left: 0;
        top: 0;
        z-index: -100;
        width: 105vw;
        height: 105vh;
        background: url("<?php echo Params::urlProfilRSDirectory() . $data->logo_rumahsakit; ?>") center center no-repeat;
        background-size: cover;
        opacity: 10%;
    }
</style>

<body onload="startTime()">
    <div class="background"></div>
    <div id="header" class="row">
        <div class="col-sm-6">
            <div class="col-lg-2">
                <a href="<?php echo $this->createUrl('/ekios/Default/Index'); ?>"><img style="max-width: 120px;" src="<?php echo Params::urlProfilRSDirectory() . $data->logo_rumahsakit; ?>"></a>
            </div>
        </div>
        <div class="col-sm-3"></div>
        <div class="col-sm-6" style="padding-right: 30px; color:white;">
            <p style="margin: 0 15px 0 0; float: right;">
                <?php echo "<span style='font-family: oswald; font-size:1.5vw;'>" . strtoupper(hari()) . ",</span>"; ?>
                <?php
                $tgl = date('d');
                $tahun = date('Y');
                echo "<span style='font-family:oswald;font-size:1.5vw;'>" . $tgl . " " . strtoupper(bulan()) . " " . $tahun . " -</span>";
                ?>
                <span id="clock" style="display: inline-block; width: 110px;font-family: oswald; font-size: 1.5vw;"></span>
            </p>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="judul_form"><b>PEMBUATAN SURAT ELIGIBILITAS PESERTA</b></div>

    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'daftar-mandiri-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('class' => 'form_pendaftaran'),
        'focus' => '#input_no_kartu',
    )); ?>
    <?php
    if (isset($_GET['sukses'])) {
        //$model = BuatjanjipoliT::model()->findByPk($_GET['buatjanjipoli_id']);
        Yii::app()->user->setFlash('success', "Anda Berhasil Checkin");
        echo "<script>
        
        function autoPrint() {
            setTimeout(function() {
                window.scrollBy(0, 768);
            }, 1000);
            printSep();
            
        }
        $(document).ready(function() {
            autoPrint();
        });</script>";
    }
    ?>

    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUtama', array(
        'form' => $form,
    ), true); ?>
    <?php echo $this->renderPartial('_formBPJS', array(
        'form' => $form,
        'modSep' => $modSep,
        'modAsuransiPasien' => $modAsuransiPasien,
        'model' => $model,
        'modPasien' => $modPasien,
        'modRujukanBpjs' => $modRujukanBpjs,
    ), true); ?>

    <?php $this->endWidget(); ?>

    <?php
    function hari()
    {
        $hari = date('l');
        /* $new = date('l, F d, Y', strtotime($Today)); */
        if ($hari == "Sunday") {
            return "Minggu";
        } elseif ($hari == "Monday") {
            return "Senin";
        } elseif ($hari == "Tuesday") {
            return "Selasa";
        } elseif ($hari == "Wednesday") {
            return "Rabu";
        } elseif ($hari == "Thursday") {
            return "Kamis";
        } elseif ($hari == "Friday") {
            return "Jum'at";
        } elseif ($hari == "Saturday") {
            return "Sabtu";
        }
    }

    function bulan()
    {
        $bulan = date('F');
        if ($bulan == "January") {
            return " Januari ";
        } elseif ($bulan == "February") {
            return " Februari ";
        } elseif ($bulan == "March") {
            return " Maret ";
        } elseif ($bulan == "April") {
            return " April ";
        } elseif ($bulan == "May") {
            return " Mei ";
        } elseif ($bulan == "June") {
            return " Juni ";
        } elseif ($bulan == "July") {
            return " Juli ";
        } elseif ($bulan == "August") {
            return " Agustus ";
        } elseif ($bulan == "September") {
            return " September ";
        } elseif ($bulan == "October") {
            return " Oktober ";
        } elseif ($bulan == "November") {
            return " November ";
        } elseif ($bulan == "December") {
            return " Desember ";
        }
    }
    ?>
    <script>
        function tampilkanwaktu() { //fungsi ini akan dipanggil di bodyOnLoad dieksekusi tiap 1000ms = 1detik 
            var waktu = new Date(); //membuat object date berdasarkan waktu saat 
            var sh = waktu.getHours() +
                ""; //memunculkan nilai jam, //tambahan script + "" supaya variable sh bertipe string sehingga bisa dihitung panjangnya : sh.length //ambil nilai menit
            var sm = waktu.getMinutes() + ""; //memunculkan nilai detik 
            var ss = waktu.getSeconds() +
                ""; //memunculkan jam:menit:detik dengan menambahkan angka 0 jika angkanya cuma satu digit (0-9)
            document.getElementById("clock").innerHTML = (sh.length == 1 ? "0" + sh : sh) + ":" + (sm.length == 1 ?
                "0" + sm : sm) + ":" + (ss.length == 1 ? "0" + ss : ss);
        }

        function startTime() {
            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById('clock').innerHTML =
                h + ":" + m + ":" + s;
            var t = setTimeout(startTime, 500);
        }

        function checkTime(i) {
            if (i < 10) {
                i = "0" + i
            }; // add zero in front of numbers < 10
            return i;
        }

        function printSep() {
            window.open('<?php echo $this->createUrl('/ekios/daftarBPJSMandiri/printSep', array('sep_id' => (isset($_GET['sep_id'])) ? $_GET['sep_id'] : "")); ?>', '_blank', 'printwin', 'left=100,top=100,width=480,height=640');
        }

        function printLabel() {
            window.open('<?php echo $this->createUrl('/ekios/daftarBPJSMandiri/printLabel', array('pendaftaran_id' => (isset($_GET['pendaftaran_id'])) ? $_GET['pendaftaran_id'] : "")); ?>', '_blank', 'printwin', 'left=100,top=100,width=860,height=480');
        }
    </script>
</body>