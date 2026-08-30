<link rel="stylesheet" type="text/css" href="css/font.css" /> 

<style>
    
    body{
        background-color:#efefef;
        /*background-image:url("<?php echo Yii::app()->request->baseUrl; ?>/images/antrian/back.jpg"); //default*/
        background-repeat:no-repeat;
        background-size:cover;
    }
    
   
    .k1btn-tiket1 {
        width:300px;
        height:200px;
        background-color: #029;
        margin-top: 50px;
        /* background:	url("images/antrian/button a tanpa text ijo.png") no-repeat; */
        
        border:none;
        vertical-align: top;
        font-family: Arial, Helvetica, sans-serif;
        color:white;
        font-size:35px;
        letter-spacing: 0;
        font-weight: bold;
        text-shadow: 2px 2px 6px #000000;
        line-height: 1;
    }
    
    .k1btn-tiket1 .antrian_singkatan {
        font-size: 75px;
    }
    .k1btn-tiket1 .deskripsi {
        font-size: 25px;
    }
    
    .k1btn-tiket1:hover {
        background-color: #35c;
    }
    
    .k1btn-tiket1:active {
        background-color: #46d;
    }
    
    
    /*
    button.btn-tiket:hover{
        // background:	url("images/antrian/button a tanpa text.png") no-repeat;
        background-size: 100% 100%;
    }*/

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
        position: absolute;
        bottom: 0;
    }
    
    
   
   
    
</style>

<!--<div id="container" style="height:100%;width:98%;background-size:cover;background-color: transparent;">-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            
        </div>
    </div>
    <div class="panel-body">
        
<div class="row">
        <div class="span12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                     
                    </div>
                </div>
                <div class="panel-body">    
                <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                        'id'=>'antrian-form',
                        'enableAjaxValidation'=>false,
                        'type'=>'horizontal',
                        'focus'=>'#',
                )); ?> 
          <div id="refresh" style="float:right;">
            <?php echo CHtml::link(Yii::t('mds','{icon}',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                "javascript:void(0);", 
                array('class' => 'btn btn-default',
                      'onclick'=>"window.location.href = window.location.href")); ?>
        </div>
        <?php echo $form->hiddenField($model,'ruangan_id', array('readonly'=>true)); ?>
        <?php echo $form->hiddenField($model,'carabayar_id', array('readonly'=>true)); ?>
        <?php echo $form->hiddenField($model,'statuspasien', array('readonly'=>true)); ?>
        <?php echo $form->hiddenField($model,'carabayar_loket', array('readonly'=>true)); ?>
        <?php echo $form->hiddenField($model,'loket_id', array('readonly'=>true)); ?>
        <?php echo $form->hiddenField($model,'noantrian', array('readonly'=>true)); ?>

<!--<div class="bases">-->

         <div class="bases" style="padding-left: calc(100% - (100% - 160px));">
             <div align:center class="col-md-12" style=" font-size:30px; color:#222; font-family:oswald; font-weight: bold;"> 
                 <br><div style="margin-left:-160px;">Ambil Tiket<br> Daftar Langsung <?php echo $modLokets->loket_nama; ?></div>
             
            </div>
        <?php
            if(!empty($modLokets)){
                $i=1;
                $lop=array("1","2","3");
                 
                $loket = $modLokets;
                $key = 0;
                $k="k".$i;
                echo "<div style='width: calc(100% - 150px); float: left;' class='hovereffect'>";
                echo "<div ></div>";
                //echo "<div class='btns'>";
                echo CHtml::htmlButton('<div class="antrian_singkatan">'.$loket->loket_singkatan."-".
                                        MyGenerator::noAntrianLoket($loket->loket_id, $loket->loket_formatnomor).
                                        '</div><div class="deskripsi">'.$loket->loket_nama.'</div>',
                                         array('onclick'=>'simpan(this,'.$loket->loket_id.','.$loket->carabayar_id.')',
                                        'id'=>'btn-'.strtolower(str_replace(" ","-",$loket->loket_nama)) ,
                                         'class'=>$k.'btn-tiket'.'1',    

                                        //'style'=>"background: url('images/antrian/button_".strtolower($loket->loket_singkatan).".png') no-repeat; background-size: 100% 100%;"
                ));
                    echo "<div class='keterangan'style='font-family:oswald;font-weight:bolder'>";
                    //echo strtoupper($loket->loket_fungsi);

                    echo "</div>";

                echo "</div>";
                $i++;
            }

            ?>
            <iframe id="print_win" src="" style="display: none;"></iframe>
        </div>
     </div>
    </div>
    <?php $this->endWidget(); ?>
            </div>
       </div>
   </div>
    
<?php $konfig = KonfigsystemK::model()->find(); ?>
<script type="text/javascript">

    var socket;
    
    function simpan(obj,loket_id, carabayar_id){
        //salin ke form
        if(!$(obj).hasClass("disabled")){
            $("#<?php echo CHtml::activeId($model, "loket_id") ?>").val(loket_id);
            $("#<?php echo CHtml::activeId($model, "carabayar_id") ?>").val(carabayar_id);
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
                        socket.emit('send',{conversationID:'antrian',loket_id:loket_id});
                    <?php } ?>
                    $(".antrian_singkatan").html(data.singkatan + "-" + data.nomor_lanjut);
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
    }
    function tampilkanRunningText(){
        $.post('<?php echo $this->createUrl('getRunningText') ?>',{},function(data){
            $('#textrunning').html(data);
        },'json');
    }
    tampilkanRunningText();
    setInterval(   // fungsi untuk menjalankan suatu fungsi berdasarkan waktu
        function(){
            tampilkanRunningText()
            return false;
        }, 
        50000  // fungsi di eksekusi setiap 50 detik sekali
    );
    
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

