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
    .btn-danger{
        background-color:#00df92;
        border-color:#00df92;
    }
    body{
        background-color:#efefef;
        /*background-image:url("<?php echo Yii::app()->request->baseUrl; ?>/images/antrian/back.jpg"); //default*/
        background-repeat:no-repeat;

        background-size:cover;

    }

   

    

    .k1btn-tiket1:hover{
         width:100%;
        height:250px;
        box-shadow: 2px 4px 3px 2px #222;

    }
    .k2btn-tiket1:hover{
         width:100%;
        height:250px;
        box-shadow: 2px 4px 3px 2px #222;

    }

    .k3btn-tiket1:hover{
         width:100%;
        height:250px;
        box-shadow: 2px 4px 3px 2px #222;

    }

    .keterangan{
        /*color:#000000;*/
        /* margin: 32px 0px 0px 32px; */
        font-size:20px;
        /*text-indent: 10px;*/ 
        font-weight: bold;
        color: grey;

        text-align: center;
    }
    /*
    
    .btns {
        float: left;
        margin-right: 30px;
        text-align: center;
        width: calc((100% / 3) - 100px);
    }
    */

    .bases {
        text-align: center !important;
        width: 100%;
    }

    .content {
        width: 100%;
        padding: 0;
        margin: 0;
        position:static;
        display: block;
        text-align: center;
    }

    .block-footer-antrian {
        /*position: absolute;*/
        position: fixed;
        bottom: 0;
    }

    .list-jadwal {
        border-collapse: collapse;
    }
    .list-jadwal td, .list-jadwal th{
        border: 1px solid #ddd;
        padding: 8px;
    }
    .list-jadwal tr:nth-child(even){background-color: #f2f2f2;}

    .list-jadwal tr:hover {background-color: #ddd;}

    .list-jadwal th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #00df92;
        color: #fff;
        font-family:oswald;
        font-weight:bold
    }

    .borderline{
     padding:15px;   
     border:2px solid #00df92;
     border-radius:10px;
    
    }
    .backpanggil{
     
       
    }
    .tombol{
        width:100%;
        height:250px;
        border-radius:20px;
       cursor:pointer;
    }
    .tombolicon{
        font-size:72pt;
        color:white;
          
    }
    .tombolicon table td{
        height:110px;
        vertical-align:middle;
        text-align:center;
    }
    .tombolbody{
    
    }
    .labeltiket{
          font-size:16pt;
          color:white;
          font-family:oswald;
          font-weight: bold;
          padding-top:5px;
          text-decoration:none;
    }
    .setakhir{
        font-size:12pt;
    }
</style>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'antrian-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
        ));
?> 
<!--<div id="headerAntrian">
        <div id="refresh" style="float:right;">-->
<div id="refresh" style=" right:5px; top:5px; position:absolute; z-index:3;">
    <?php
    echo CHtml::link(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), "javascript:void(0);", array('class' => 'btn btn-danger',
        'onclick' => "window.location.href = window.location.href"));
    ?>
</div>
<!--</div>
    </div>-->
<!--<div id="contentAntrian" style="width:100%;background-size:cover;">
    <div class="content">-->
<?php echo $form->hiddenField($model, 'modelantrian_id', array('readonly' => true)); ?>
<?php echo $form->hiddenField($model, 'ruangan_id', array('readonly' => true)); ?>
<?php echo $form->hiddenField($model, 'carabayar_id', array('readonly' => true)); ?>
<?php echo $form->hiddenField($model, 'statuspasien', array('readonly' => true)); ?>
<?php echo $form->hiddenField($model, 'carabayar_loket', array('readonly' => true)); ?>
<?php echo $form->hiddenField($model, 'loket_id', array('readonly' => true)); ?>
<?php echo $form->hiddenField($model, 'noantrian', array('readonly' => true)); ?>

<!--<div class="bases">-->

<div class="bases">
    <div class="row">
        <div align:center class="col-sm-12" style=" font-size:30px;  font-family:oswald; font-weight: bold;"> 
            <img style="height:100px; padding-top:2%;" src="<?php echo Params::urlProfilRSDirectory() . $config->logolayarantrian ?>" id="logo"/>
            <br><div>Antrian Pendaftaran</div>
             <br>
            
        </div>
    </div>    
    <div>

        <div class="row">
            <div class="col-xs-7 backpanggil">

                <?php
                if (count($modLokets) > 0) {
                    $i = 1;

                    foreach ($modLokets as $key => $loket) {
                        ?>                  

                        <?php $k = "k" . $i ?>
                        <?php
                             $input = array("#fe344d", "#00d692", "#616ce6", "#f8005f", "#ab00b0","#00bbd6","#009d88","#5E7B8B");
                                $rand_keys = array_rand($input);
                               
                               
                        ?>
                        <div  class='hovereffect col-xs-4'>
                           
                            <div class="tombol <?php echo $k ?>btn-tiket1" onclick="simpan(<?php echo "'btn-".strtolower(str_replace(" ", "-", $loket->modelantrian_nama))."'"  ?>,<?php echo $loket->modelantrian_id ?>)" id="btn-<?php echo strtolower(str_replace(" ", "-", $loket->modelantrian_nama))  ?>" style="background-color:<?php echo $input[$rand_keys] ?>">
                                <div class="tombolheader">
                                    <div class="tombolicon">
                                        <table style="width: 100%; border: none;">
                                            <tr>
                                                <td>
                                                     <i class="entypo-print"></i>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                              
                                <div class="tombolbody">
                                   
                                    <div style="border:1px solid white;margin-left:20px; margin-right: 20px;"></div>
                                    <div class="labeltiket">
                                        ANTRIAN <br>
                                        <?php echo strtoupper($loket->modelantrian_nama); ?>
                                    </div>
                                   
                                    <div class="labeltiket">
                                        <div class="setakhir">ANTRIAN AKHIR</div>
                                        <div class="setnomor">0-000</div>
                                        
                                    </div>
                                    
                                </div>
                                 
                            </div>
                            <?php
                            $i++;
                            ?>
                        </div>
                        <?php
                    }
                }
                ?>
                <div class="row">
                    <div class="col-xs-11" style="margin-top: 30px;position: center;">
                     <div class="borderline">
                            <p style="font-size:24px"><b>Perhatian</b></p>
                            <p style="font-size:16px"><b>Untuk Antrian Laboratorium</b></p>
                            <p>1.Lab Atas Permintaan Doker Form Dokter (APDOK)</p>
                            <p>2.Lab Atas Permintaan Sendiri (APS)</p>
                        </div>
                </div>
                </div>
            </div>      
            <div class="col-xs-5">
                <table width="100%" class="list-jadwal">
                    <thead>
                    <th>Nama Dokter</th>
                    <th>Ruangan</th>
                    <th>Jumlah Antrian Saat Ini</th>
                    <th>Maksimum Antrian</th>
                    </thead>
                    <tbody>
                        <?php foreach ($modJadwaldokter as $jadwal) { ?>
                            <tr>
                                <td><?= $jadwal['dokter'] ?></td>
                                <td><?= $jadwal['ruangan'] ?></td>
                                <td><?= $jadwal['total_pendaftaran'] ?></td>
                                <td><?= $jadwal['max'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>
            </div>
<!--<div class="row">
                 
                    <div class="col-xs-7">
                        <br><br>
                        <div class="borderline">
                            <p style="font-size:24px"><b>Perhatian</b></p>
                            <p style="font-size:16px"><b>Untuk Antrian Laboratorium</b></p>
                            <p>1.Lab Atas Permintaan Doker Form Dokter (APDOK)</p>
                            <p>2.Lab Atas Permintaan Sendiri (APS)</p>
                        </div>
                    </div>
                </div>-->
                <div class="row">
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
                </div>
   

        </div>
        <iframe id="print_win" src="" style="display: none;"></iframe>
        <br>

    </div>

</div>

<?php $this->endWidget(); ?>


<?php $konfig = KonfigsystemK::model()->find(); ?>
<script type="text/javascript">

    var socket;

    function simpan(obj, loket_id) {
        //salin ke form
       
//        if (!$(obj).hasClass("disabled")) {
            $("#<?php echo CHtml::activeId($model, "modelantrian_id") ?>").val(loket_id);
            //$("#<?php echo CHtml::activeId($model, "carabayar_id") ?>").val(carabayar_id);
            //post form
          
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('SimpanTiket'); ?>',
                data: {data: $("#antrian-form").serialize()}, //
                dataType: "json",
                success: function (data) {
                            
                    var delaytombol = parseInt(data.delaytombol) * parseInt(1000);
<?php if ($konfig->is_nodejsaktif) { ?>
                        socket.emit('send', {conversationID: 'antrian', modelantrian_id: loket_id});
<?php } ?>
                    $("#"+obj).find(".setnomor").html(data.loket_singkatan+'-'+data.model.noantrian);
                    print(data.model.antrian_id);
                    setTimeout(function () {
                        $("button").removeAttr("disabled");
                        $("button").removeClass("disabled");
                    }, delaytombol);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
//        }
    }
    function print(antrian_id) {
        $("#print_win").attr('src', "<?php echo $this->createUrl('Print') ?>&antrian_id=" + antrian_id);
    }
    function tampilkanRunningText() {
        $.post('<?php echo $this->createUrl('getRunningText') ?>', {}, function (data) {
            $('#textrunning').html(data);
        }, 'json');
    }
    tampilkanRunningText();
    setInterval(// fungsi untuk menjalankan suatu fungsi berdasarkan waktu
            function () {
                tampilkanRunningText()
                return false;
            },
            50000  // fungsi di eksekusi setiap 50 detik sekali
            );

    $(document).ready(function () {
<?php if ($konfig->is_nodejsaktif) { ?>
            var chatServer = '<?php echo $konfig->nodejs_host ?>';
            if (chatServer == '') {
                chatServer = 'http://localhost';
            }
            var chatPort = '<?php echo $konfig->nodejs_port ?>';
            socket = io.connect(chatServer + ':' + chatPort);
            socket.emit('subscribe', 'antrian');
<?php } ?>
    });
</script>

