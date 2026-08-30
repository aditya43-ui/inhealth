<?php
/**
 *  halaman utama untuk pengaturan tampilan ambil tiket antrian
 */
$konfig = KonfigsystemK::model()->find(); 
?>
<link rel="stylesheet" type="text/css" href="css/font.css" /> 
<link rel="stylesheet" href="themes/neon/assets/css/bootstrap4/bootstrap.min.css" />
<style>
    .nohover{
        cursor: unset;
    }
</style>
<script>
//    var ekt = document.body;
//        if (ekt.requestFullscreen) {
//          ekt.requestFullscreen();
//        } else if (ekt.msRequestFullscreen) {
//          ekt.msRequestFullscreen();
//        } else if (ekt.mozRequestFullScreen) {
//          ekt.mozRequestFullScreen();
//        } else if (ekt.webkitRequestFullscreen) {
//          ekt.webkitRequestFullscreen();
//    }
</script>
<style>    
    body{
        background-color: #dfdfdf;
/*        background-image:url("<?php echo Yii::app()->request->baseUrl; ?>/images/antrian/back.jpg");*/
/*        background-repeat:no-repeat;
        background-size:cover;*/
    }
    
    .keterangan{        
        font-size:20px;        
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
        position: fixed;
        bottom: 0px;
        padding:2px !important;
    }
    #footerClock{
        font-size:18pt;
    }
    #footerAntrian{
     font-size:18pt !important;
    }
   
</style>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'antrian-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#',
)); ?> 
    <div id="headerAntrian2" style="margin-top: 5% !important">
        <div id="refresh" style="position:absolute;top:10px;right:10px">
            <?php echo CHtml::link(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                "javascript:void(0);", 
                array('class'=>'btn btn-danger',
                      'onclick'=>"window.location.href = window.location.href"));  ?>
            
            <?php 
                echo "<br/><br/>";
                echo CHtml::link("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;","javascript:;",array('onclick'=>'toggleFullScreen();', 'id'=>'full','class'=>'btn btn-primary', 'style'=>'background:#dfdfdf;border:1px solid #dfdfdf')) ?>
        </div>
        <?php
        
        $data = explode("<BR>",strtoupper($lokasiAntrian->lokasi_karcisantrian_judul));

        $profil = ProfilrumahsakitM::model()->findByPk(1);
        $tampung1 = $data[0]." ";
        $tampung2 = $profil->nama_rumahsakit;
        ?>
        
        <div class="row justify-content-lg-center" style="margin-right:0;margin-left:0;margin-top:10px">
                    
                    <div class="col col-lg-3"  align="center">

                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo_login/LOG RSSAGRP-03.png" class="visible-md-inline visible-lg-inline" style="height: 60%; max-height: 550px;">

                    </div>
       
                </div>
          <div class="close"></div>
        <div class="container" style="margin-top:20px">
            <h1 style="text-align: center; font-size: 40px;font-family:oswald; font-weight:bolder; color: grey; "><?php echo $tampung1; ?></h1>
            <h1 style="text-align: center;  font-size: 30px;font-family:oswald; font-weight:bolder; color: #766F57; "><?php echo $tampung2; ?></h1>
        </div>
    </div>    
    <div id="contentAntrian" style="margin-top:10px;width:100%;background-size:cover;">
    <div class="content">
        <?php echo $form->hiddenField($model,'ruangan_id', array('readonly'=>true)); ?>
        <?php echo $form->hiddenField($model,'carabayar_id', array('readonly'=>true)); ?>
        <?php echo $form->hiddenField($model,'statuspasien', array('readonly'=>true)); ?>
        <?php echo $form->hiddenField($model,'carabayar_loket', array('readonly'=>true)); ?>
        <?php echo $form->hiddenField($model,'modelantrian_id', array('readonly'=>true)); ?>
        <?php echo $form->hiddenField($model,'noantrian', array('readonly'=>true)); ?>
        <div class="container">

        <table style="width: 100%; margin-top: 80px;">
            <tr>


            <?php
            if(count($modLokets) > 0) {
                $i=1;                
                foreach ($modLokets as $key => $loket) {                    
                    $close = 'noklik closeall'.$i;                    
                    if (!empty($loket->modelantrian_buka) && !empty($loket->modelantrian_tutup)){
                        if ( strtotime(date('H:i:s')) >=  strtotime($loket->modelantrian_buka) && strtotime(date('H:i:s')) < strtotime($loket->modelantrian_tutup)){
                            $close = '';
                        } 
                    }else{
                        $close = '';
                    }
                    
                    echo $this->renderPartial($this->pathView.'buttonCss',array('lokasi'=>$lokasiAntrian,'i'=>$i,'gambar'=>!empty($loket->modelantrian_gambartombol)?$loket->modelantrian_gambartombol:''),true);
                    $k="k".$i;
                    echo "<td  class='col col-md hovereffect' style=' padding-left:5px;
        padding-right:5px;margin-left:1vh;'> ";
                    echo CHtml::htmlButton("<span class='baris-kata".$i."'>".strtoupper($loket->modelantrian_labeltombol)."</span>"."<div class='baris-singkatan".$i."' style='margin-top:-135px;'>".strtoupper($loket->modelantrian_singkatan)."</div>",
                        array('onclick'=>'simpan(this,'.$loket->modelantrian_id.')',
                       'id'=>'btn-'.strtolower(str_replace(" ","-",$loket->modelantrian_nama)) ,
                       'class'=>$k.'btn-tiket'.$i.' model-load  '.$close,
                       'nourut'=>$i,
                       'buka'=>$loket->modelantrian_buka,
                       'tutup'=>$loket->modelantrian_tutup,
                    ));
                        echo "<div class='keterangan' style='font-family:oswald;font-weight:bolder;margin-top:-170px;'>";
                        echo strtoupper($loket->modelantrian_deskripsi);
                        echo "</div>";

                    echo "</td>";                    
                    $i++;
                }
            }
                
            ?>

            </tr>
        </table>
        <div class=" row justify-content-md-center" style="" align="center">
        
            <div style="clear: both;"></div>
            <iframe id="print_win" src="" style="display: none;"></iframe>
        </div>
        </div>
     </div>
    </div>
    <?php $this->endWidget(); ?>





<div class="block-footer-antrian">
    <div id="footerAntrian" style="font-family:oswald;color:black">
        <marquee direction="left" scrollamount="10" id="textrunning">
            <?php //echo Yii::app()->user->getState('running_text_kiosk'); ?>
        </marquee>
    </div> 
    <div id="footerClock" style="font-family:oswald;color:black">
        <div id="clock"></div>
    </div>
</div>
    

<script type="text/javascript">

    var socket;
    
   
    
    function simpan(obj, modelantrian_id){
        //salin ke form
        if(!$(obj).hasClass("nohover") && !$(obj).hasClass("noklik") ){
            $("#<?php echo CHtml::activeId($model, "modelantrian_id") ?>").val(modelantrian_id);
            
            $("button").attr("disabled",true);            
            $("button").addClass("nohover");            
            $("button").parents('.hovereffect').addClass("animation-loading");                           
            
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('SimpanTiket'); ?>',
                data: {data:$("#antrian-form").serialize()},//
                dataType: "json",
                success:function(data){
                    var delaytombol = parseInt(data.delaytombol) * parseInt(1000);
                    <?php if($konfig->is_nodejsaktif){ ?>
                        //socket.emit('send',{conversationID:'antrian',modelantrian_id:modelantrian_id});
                        socket.emit('send',{conversationID:'panggilAntrianPendaftaran',antrian_id:modelantrian_id});
                    <?php } ?>
                    print(data.model.antrian_id);
                    setTimeout(function(){
                        $("button").removeAttr("disabled");                        
                        $("button").removeClass("nohover");            
                        $("button").parents('.hovereffect').removeClass("animation-loading");                                       
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
    
    function toggleFullScreen() {        
        $('.trigger-fullscreen').toggle();
        if (!document.fullscreenElement &&    // alternative standard method
            !document.mozFullScreenElement && !document.webkitFullscreenElement) {  // current working methods
            if (document.documentElement.requestFullscreen) {
                document.documentElement.requestFullscreen();
            } else if (document.documentElement.mozRequestFullScreen) {
                document.documentElement.mozRequestFullScreen();
            } else if (document.documentElement.webkitRequestFullscreen) {
                document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
            }
            $.cookie('fullscreen', 'true');
        } else {
            if (document.cancelFullScreen) {
                document.cancelFullScreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitCancelFullScreen) {
                document.webkitCancelFullScreen();
            }
            $.cookie('fullscreen', 'false');
        }                
    }
               
    $(document).ready(function() {       
         setInterval(function(){                    
            updateClock();
            var jamsekarang =  $("#clock").html();
            if (jamsekarang == '05:00:00'){
                location.reload();
            }                        
            <?php
                foreach($script as $det){
                    echo $det;
                    echo "\n";
                }
            ?>
        }, 1000);
        
        tampilkanRunningText();
        <?php if($konfig->is_nodejsaktif){ ?>
        var chatServer='<?php echo $konfig->nodejs_host ?>';
        if (chatServer == ''){
            chatServer='http://localhost';
        }
        var chatPort='<?php echo $konfig->nodejs_port ?>';
        socket = io.connect(chatServer+':'+chatPort);
        //socket.emit('subscribe', 'antrian');
        <?php } ?>
//        setTimeout(function(){
//            $("#full").trigger('click');
//        },1000)
    });
    
    
</script>


