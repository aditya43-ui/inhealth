<link rel="stylesheet" type="text/css" href="css/font.css" />

<script>
    var ekt = document.body;
    if (ekt.requestFullscreen) {
        ekt.requestFullscreen();
    } else if (ekt.msRequestFullscreen) {
        ekt.msRequestFullscreen();
    } else if (ekt.mozRequestFullScreen) {
        ekt.mozRequestFullScreen();
    } else if (ekt.webkitRequestFullscreen) {
        ekt.webkitRequestFullscreen();
    }
</script>

<?php
$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$config = KonfigsystemK::model()->find();
?>

<style>
    html {
        background: url(<?php echo Yii::app()->request->baseUrl; ?>/images/login_mixed_new.jpg) center center no-repeat;
        background-size: cover;
        background-attachment: fixed;
    }

    body {
        width: 100%;
        height: 100%;
        padding-bottom: 70px;
        background: none;
    }

    #refresh {
        position: fixed;
        right: 5px;
        top: 5px;
        z-index: 50;
        padding: 5px;
        color: #fff;
        background: #57A595;
        border-radius: 5px;
    }

    #refresh a {
        color: #fff;
        font-size: 20px;
    }

    .k1btn-tiket1 {
        width: 200px;
        height: 300px;
        border: none;
        vertical-align: top;
        font-family: Arial, Helvetica, sans-serif;
        color: white;
        font-size: 35px;
        letter-spacing: 0;
        font-weight: bold;
        line-height: 1;
        background-color: #dd2848;
        background-repeat: no-repeat;
        border-radius: 10px;
        box-shadow: 3px 3px rgba(0, 0, 0, .2);
    }

    .b2btn-tiket1 {
        width: 200px;
        height: 300px;
        border: none;
        vertical-align: top;
        font-family: Arial, Helvetica, sans-serif;
        color: white;
        font-size: 35px;
        letter-spacing: 0;
        font-weight: bold;
        line-height: 1;
        background-color: #36AE7C;
        background-repeat: no-repeat;
        border-radius: 10px;
        box-shadow: 3px 3px rgba(0, 0, 0, .2);
    }

    .keterangan {
        font-size: 20px;
        font-weight: bold;
        color: grey;
        text-align: center;
    }

    .bases {
        text-align: center !important;
        width: 100%;
    }

    .content {
        width: 100%;
        padding: 0;
        margin: 0;
        position: static;
        display: block;
        text-align: center;
    }

    .block-footer-antrian {
        position: fixed;
        width: 100%;
        left: 0;
        bottom: 0;
    }

    .title {
        margin: 15px 0;
        font-size: 2vw;
        font-family: oswald;
        font-weight: bold;
    }

    .title .img {
        padding: 10px 0;
        background: #fff;
    }

    .title .text {
        padding: 10px 0;
        background: #377fb7;
        color: #fff;
        text-transform: uppercase;
        font-size: 30px;
    }

    .form-horizontal {
        padding: 0 15px
    }

    .tombol-tiket {
        transition: .25s;
    }

    .tombol-tiket:hover {
        filter: brightness(80%);
    }
</style>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'antrian-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
)); ?>
<div id="refresh">
    <?php echo CHtml::link(
        Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        "javascript:void(0);",
        array(
            'onclick' => "window.location.href = window.location.href"
        )
    ); ?>
</div>
<?php echo $form->hiddenField($model, 'ruangan_id', array('readonly' => true)); ?>
<?php echo $form->hiddenField($model, 'carabayar_id', array('readonly' => true)); ?>
<?php echo $form->hiddenField($model, 'statuspasien', array('readonly' => true)); ?>
<?php echo $form->hiddenField($model, 'carabayar_loket', array('readonly' => true)); ?>
<?php echo $form->hiddenField($model, 'modelantrian_id', array('readonly' => true)); ?>
<?php echo $form->hiddenField($model, 'noantrian', array('readonly' => true)); ?>

<div class="bases">
    <div class="title">
        <div class="img"><img src="<?php echo Params::urlProfilRSDirectory() . $config->logolayarantrian ?>" id="logo" style="height:95px; margin-top: 0;"></div>
        <div class="text">Antrian Kasir</div>
    </div>
    <p style="margin: 0; text-align: center;">
        <?php
        if (count((array)$modLokets) > 0) {
            $i = 1;
            $lop = array("1", "2", "3");
            foreach ($modLokets as $key => $loket) {
                $k = strtolower(str_replace(" ", "-", $loket->modelantrian_formatnomor)) . $i;
               
                echo "<div style='display: inline-block; width: calc((100%/3) - 50px); class='hovereffect'>";
                echo CHtml::htmlButton('<div class="entypo-print" style="font-size:75pt; margin-bottom: 10px; border-bottom: 1px solid white; padding-bottom: 40px;"></div><div style="padding-top: 10px;">Antrian '.$loket->modelantrian_nama.'</div>', array(
                    'onclick' => 'simpan(this,' . $loket->modelantrian_id . ')',
                    'id' => 'btn-' . strtolower(str_replace(" ", "-", $loket->modelantrian_nama)),
                    'class' => $k . 'btn-tiket' . '1 tombol-tiket',
                ));
                echo "<div class='keterangan'style='font-family:oswald;font-weight:bolder'>";

                echo "</div></div>";
                $i++;
            }
        }
        ?>
    </p>

    <iframe id="print_win" src="" style="display: none;"></iframe>
</div>

<?php $this->endWidget(); ?>
</div>

<div class="block-footer-antrian">
    <div id="footerAntrian">
        <marquee direction="left" scrollamount="10" id="textrunning">
            <?php echo Yii::app()->user->getState('running_text_kiosk'); ?>
        </marquee>
    </div>
    <div id="footerClock">
        <div id="clock"></div>
    </div>
</div>

<?php $konfig = KonfigsystemK::model()->find(); ?>

<script type="text/javascript">
    function simpan(obj, loket_id) {
        if (!$(obj).hasClass("disabled")) {
            $("#<?php echo CHtml::activeId($model, "modelantrian_id") ?>").val(loket_id);

            $("button").attr("disabled");
            $("button").addClass("disabled");
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('SimpanTiket'); ?>',
                data: {
                    data: $("#antrian-form").serialize()
                }, //
                dataType: "json",
                success: function(data) {
                    var delaytombol = parseInt(data.delaytombol) * parseInt(1000);
                    print(data.model.antrian_id);
                    setTimeout(function() {
                        $("button").removeAttr("disabled");
                        $("button").removeClass("disabled");
                    }, delaytombol);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }

    function print(antrian_id) {
        $("#print_win").attr('src', "<?php echo $this->createUrl('Print') ?>&antrian_id=" + antrian_id);
    }

    function tampilkanRunningText() {
        $.post('<?php echo $this->createUrl('getRunningText') ?>', {}, function(data) {
            $('#textrunning').html(data);
        }, 'json');
    }
    tampilkanRunningText();
    setInterval( // fungsi untuk menjalankan suatu fungsi berdasarkan waktu
        function() {
            tampilkanRunningText()
            return false;
        },
        50000 // fungsi di eksekusi setiap 50 detik sekali
    );
</script>