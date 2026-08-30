<?php
/**
 *  halaman utama untuk pengaturan tampilan ambil tiket antrian
 */

?>
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

<style>
    
    body{
        background-color: white;
        background-image:url("<?php echo Yii::app()->request->baseUrl; ?>/images/antrian/back.jpg"); //default
        background-repeat:no-repeat;
        background-size:cover;
    }
   
    .k1btn-tiket1 {
        width:337px;
        height:431px;        
        border:none;
        vertical-align: top;
        font-family: Arial, Helvetica, sans-serif;
        color:white;
        font-size:35px;
        letter-spacing:0px;
        font-weight: bold;
        text-shadow: 2px 2px 6px #000000;
        line-height: 1;
        <?php if($jenis_pasien=="BARU" || empty($jenis_pasien)){
            if($lokasiantrian_id== Params::LOKASI_ANTRIAN_GRIU_ID){
                echo "background: url('images/antrian/antrianGrahaBaru.png');";
            }else{
                echo "background: url('images/antrian/button_a1.png');";
            }
        }else{
            echo "background: url('images/antrian/button_d1_2.png');";
        }?>
        background-repeat: no-repeat;
    }
     .k2btn-tiket2 {
        width:337px;
        height:431px;
        <?php if($jenis_pasien=="BARU" || empty($jenis_pasien)){
            if($lokasiantrian_id== Params::LOKASI_ANTRIAN_GRIU_ID){
                echo "background: url('images/antrian/antrianGrahaLama.png');";
            }else{
                echo "background: url('images/antrian/button_b1.png');";
            }
        }else{
            echo "background: url('images/antrian/button_e1_2.png');";
        } ?>
        border:none;
        vertical-align: top;
        font-family: Arial, Helvetica, sans-serif;
        color:white;
        font-size:35px;
        letter-spacing:0px;
        font-weight: bold;
        text-shadow: 2px 2px 6px #000000;
        line-height: 1;
        background-repeat: no-repeat;
    }
     .k3btn-tiket3 {
        width:337px;
        height:431px;
        <?php if($jenis_pasien=="BARU" || empty($jenis_pasien)){
            echo "background: url('images/antrian/button_c1.png');";
        }else{
            echo "background: url('images/antrian/button_f1_1.png');";
        } ?>
        border:none;
        vertical-align: top;
        font-family: Arial, Helvetica, sans-serif;
        color:white;
        font-size:35px;
        letter-spacing:0px;
        font-weight: bold;
        text-shadow: 2px 2px 6px #000000;
        line-height: 1;
        transition: all 0.8s;
  -moz-transition: all 0.8s;
  -webkit-transition: all 0.8s;
  -ms-transition: all 0.8s;
  -o-transition: all 0.8s;
      background-repeat: no-repeat;
        
    }

    button.k1btn-tiket1:active{
        <?php if($jenis_pasien=="BARU" || empty($jenis_pasien)){
            if($lokasiantrian_id== Params::LOKASI_ANTRIAN_GRIU_ID){
                echo "background: url('images/antrian/antrianGrahaBaruOver.png');";
            }else{
                echo "background: url('images/antrian/btn1overcopy.png');";
            }
        }else{
            echo "background: url('images/antrian/btn4overcopy_1.png');";
        } ?>
        box-shadow: 2px 4px 3px 2px #222;
        background-repeat: no-repeat;    
    }
    button.k2btn-tiket2:active{
        <?php if($jenis_pasien=="BARU" || empty($jenis_pasien)){
            if($lokasiantrian_id== Params::LOKASI_ANTRIAN_GRIU_ID){
                echo "background: url('images/antrian/antrianGrahaLamaOver.png');";
            }else{
                echo "background: url('images/antrian/btn2overcopy.png');";
            }
        }else{
            echo "background: url('images/antrian/btn5overcopy_1.png');";
        } ?>
        box-shadow: 2px 4px 3px 2px #222;
        background-repeat: no-repeat;    
    }
    button.k3btn-tiket3:active{
        <?php if($jenis_pasien=="BARU" || empty($jenis_pasien)){
            echo "background: url('images/antrian/btn3overcopy.png');";
        }else{
            echo "background: url('images/antrian/btn6overcopy_1.png');";
        } ?>
        box-shadow: 2px 4px 3px 2px #222;
        background-repeat: no-repeat;    
    }
    button.k1btn-tiket1:hover {
        <?php if($jenis_pasien=="BARU" || empty($jenis_pasien)){
            if($lokasiantrian_id== Params::LOKASI_ANTRIAN_GRIU_ID){
                echo "background: url('images/antrian/antrianGrahaBaruOver.png');";
            }else{
                echo "background: url('images/antrian/btn1overcopy.png');";
            }
        }else{
            echo "background: url('images/antrian/btn4overcopy_2.png');";
        } ?>
        box-shadow: 2px 4px 3px 2px #222;
        background-repeat: no-repeat;    
    }
    button.k2btn-tiket2:hover {
        <?php if($jenis_pasien=="BARU" || empty($jenis_pasien)){
            if($lokasiantrian_id== Params::LOKASI_ANTRIAN_GRIU_ID){
                echo "background: url('images/antrian/antrianGrahaLamaOver.png');";
            }else{
                echo "background: url('images/antrian/btn2overcopy.png');";
            }
        }else{
            echo "background: url('images/antrian/btn5overcopy_2.png');";
        } ?>
        box-shadow: 2px 4px 3px 2px #222;
        background-repeat: no-repeat;    
    }
    button.k3btn-tiket3:hover {
        <?php if($jenis_pasien=="BARU" || empty($jenis_pasien)){
            echo "background: url('images/antrian/btn3overcopy.png');";
        }else{
            echo "background: url('images/antrian/btn6overcopy_1.png');";
        } ?>
        box-shadow: 2px 4px 3px 2px #222;
        background-repeat: no-repeat;    
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
    
    .bases {
        text-align: center !important;
        width: 100%;
    }
    
    .content {
        width: 100%;
        padding: 0px;
        margin: 0px;
        position:static;
        display: block;
        text-align: center;
    }
    
    .block-footer-antrian {
        position: absolute;
        bottom: 0px;
    }
    
</style>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'antrian-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#',
)); ?> 
    <div id="headerAntrian2">
        <div id="refresh" style="float:right;">
            <?php echo CHtml::link(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                "javascript:void(0);", 
                array('class'=>'btn btn-danger',
                      'onclick'=>"window.location.href = window.location.href"));  ?>
        </div>
        <?php
        $data = explode("<BR>",strtoupper($lokasiAntrian->lokasi_karcisantrian_judul));
        $tampung1 = $data[0]." ";
        $tampung2 = isset($data[1])? $data[1] : '';
        ?>
        <h1 style="text-align: center; margin-top: 200px; height: 60px; font-size: 50px;font-family:oswald; font-weight:bolder; color: grey; "><?php echo $tampung1; ?></h1>
        <h1 style="text-align: center; height: 100px; font-size: 40px;font-family:oswald; font-weight:bolder; color: #766F57; "><?php echo $tampung2; ?></h1>
    </div>    
    <div id="contentAntrian" style="width:100%;background-size:cover;">
    <div class="content">
        <?php echo $form->hiddenField($model,'ruangan_id', array('readonly'=>true)); ?>
        <?php echo $form->hiddenField($model,'carabayar_id', array('readonly'=>true)); ?>
        <?php echo $form->hiddenField($model,'statuspasien', array('readonly'=>true)); ?>
        <?php echo $form->hiddenField($model,'carabayar_loket', array('readonly'=>true)); ?>
        <?php echo $form->hiddenField($model,'modelantrian_id', array('readonly'=>true)); ?>
        <?php echo $form->hiddenField($model,'noantrian', array('readonly'=>true)); ?>
        <div class="bases" style="padding-left: calc(100% - (100% - 160px));">
        <?php
            if(count($modLokets) > 0) {
                $i=1;
               
                foreach ($modLokets as $key => $loket) {
                    $k="k".$i;
                    echo "<div style='width: calc((100%/".count($modLokets).") - 50px); float: left;' class='hovereffect'>";
                    echo CHtml::htmlButton(strtoupper(""),
                        array('onclick'=>'simpan(this,'.$loket->modelantrian_id.')',
                       'id'=>'btn-'.strtolower(str_replace(" ","-",$loket->modelantrian_nama)) ,
                       'class'=>$k.'btn-tiket'.$i,
                    ));
                        echo "<div class='keterangan' style='font-family:oswald;font-weight:bolder'>";
                        echo strtoupper($loket->modelantrian_deskripsi);
                        echo "</div>";

                    echo "</div>";
                    $i++;
                }
            }
                
            ?>
            <div style="clear: both;"></div>
            <iframe id="print_win" src="" style="display: none;"></iframe>
        </div>
     </div>
    </div>
    <?php $this->endWidget(); ?>





<div class="block-footer-antrian">
    <div id="footerAntrian" style="font-family:oswald;color:black">
        <marquee direction="left" scrollamount="10" id="textrunning">
            <?php echo Yii::app()->user->getState('running_text_kiosk'); ?>
        </marquee>
    </div> 
    <div id="footerClock" style="font-family:oswald;color:black">
        <div id="clock"></div>
    </div>
</div>
    
<?php $konfig = KonfigsystemK::model()->find(); ?>
<script type="text/javascript">

    var socket;
    
    function simpan(obj, modelantrian_id){
        //salin ke form
        if(!$(obj).hasClass("disabled")){
            $("#<?php echo CHtml::activeId($model, "modelantrian_id") ?>").val(modelantrian_id);
            // $("#<?php echo CHtml::activeId($model, "carabayar_id") ?>").val(carabayar_id);
            //post form
            $("button").attr("disabled");
            $("button").addClass("disabled");
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('SimpanTiket'); ?>',
                data: {data:$("#antrian-form").serialize()},//
                dataType: "json",
                success:function(data){
                    var delaytombol = parseInt(data.delaytombol) * parseInt(1000);
                    <?php if($konfig->is_nodejsaktif){ ?>
                        socket.emit('send',{conversationID:'antrian',modelantrian_id:modelantrian_id});
                    <?php } ?>
                    print(data.model.antrian_id);
                    setTimeout(function(){
                        $("button").removeAttr("disabled");
                        $("button").removeClass("disabled");
                    },delaytombol);
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        }
    }
    function print(antrian_id){
        $("#print_win").attr('src',"<?php echo $this->createUrl('Print') ?>&antrian_id="+antrian_id);
        //window.open('<?php echo $this->createUrl('Print'); ?>&antrian_id='+antrian_id,'printwin','left=100,top=100,width=480,height=640');
    }
    function tampilkanRunningText(){
        $.post('<?php echo $this->createUrl('getRunningText') ?>',{},function(data){
            $('#textrunning').html(data);
        },'json');
    }
    tampilkanRunningText();
    /**
    setInterval(   // fungsi untuk menjalankan suatu fungsi berdasarkan waktu
        function(){
            tampilkanRunningText()
            return false;
        }, 
        50000  // fungsi di eksekusi setiap 50 detik sekali
    );
    */
    
    $(document).ready(function() {
        <?php if($konfig->is_nodejsaktif){ ?>
        var chatServer='<?php echo $konfig->nodejs_host ?>';
        if (chatServer == ''){
            chatServer='http://localhost';
        }
        var chatPort='<?php echo $konfig->nodejs_port ?>';
        socket = io.connect(chatServer+':'+chatPort);
        socket.emit('subscribe', 'antrian');
        <?php } ?>
    });
</script>

