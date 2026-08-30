<style>
    .tab_antrian {
        width: 100%;
    }
    
    .tab_antrian td {
        border: 1px solid black;
        padding: 5px;
    }
    
    .label_det {
        font-size: 12pt;
        font-weight: bold;
        text-align: center;
    }
    .label_no_antrian {
        font-size: 40pt;
        font-weight: bold;
        text-align: center;
    }
    .label_no_antrian_2 {
        font-size: 60pt;
        font-weight: bold;
        text-align: center;
    }
    .panel_panggil {
        text-align: center;
    }
    
</style>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-bullhorn"></i> Panggil Antrian 
        </div>
    </div>
    <div class="panel-body">
        <div class="control-group">
            <?php echo CHtml::label('No. Antrian', 'noantrian', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php 
                $daftar = new PPPendaftaranT;
                $daftar->unsetAttributes();
                echo CHtml::activeHiddenField($daftar, 'antrian_id', array('readonly' => true)); ?>
                <?php echo CHtml::dropDownList('cari_loket_id', $modAntrian->modelantrian_id, CHtml::listData(ModelantrianM::model()->findAll('modelantrian_aktif = true order by modelantrian_id asc'), 'modelantrian_id', 'modelantrian_nama'), array('class' => 'span2', 'empty' => '-- Pilih --', 'onchange' => 'setNamaLoket(this.value); setFormAntrian("reset");')) ?>
                <?php echo CHtml::textField('noantrian', $modAntrian->noantrian, array('readonly' => true, 'class' => 'span2', 'style' => 'width:50px;', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                di <i class="diLoketAjax"> <?php echo CHtml::dropDownList('namaLoket', $modAntrian->namaLoket, CHtml::listData($modAntrian->getNamaLoketAntrian($modAntrian->modelantrian_id), 'loket_id', 'loket_nama'), array('class' => 'span2', 'empty' => '-- Pilih --', 'style' => 'width:100px;', 'onchange' => 'setFormAntrian("reset");')) ?></i>
                &nbsp; <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-volume-up icon-white"></i>')), array('id' => 'bth-lihatantrian', 'title' => 'Klik untuk menampilkan form antrian', 'rel' => 'tooltip', 'class' => 'btn btn-dark', 'onclick' => '$("#dialog-panggilantrian").dialog("open");')); ?>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-bullhorn"></i> No Antrian
        </div>
    </div>
    <div class="panel-body">
        <table class="tab_antrian">
            <tr>
                <td rowspan="2" style="width: 50%;" class="panel_panggil">
                    <div>
                        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="glyphicon glyphicon-backward"></i>')), array('title' => 'Klik untuk menampilkan antrian sebelumnya', 'rel' => 'tooltip', 'class' => 'btn btn-default', 'onclick' => 'setFormAntrian("prev");', 'style' => 'margin-bottom: 5px; font-size: 26pt;')); ?>
                        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Panggil', array('id' => 'btn-panggilantrian', '{icon}' => '<i class="glyphicon glyphicon-volume-up"></i>')), array('title' => 'Klik untuk memanggil antrian ini', 'rel' => 'tooltip', 'class' => 'btn btn-danger', 'onclick' => ' panggilAntrian();', 'style' => 'margin-bottom: 5px; font-size:18pt;')); ?>
                        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="glyphicon glyphicon-forward"></i>')), array('title' => 'Klik untuk menampilkan antrian berikutnya', 'rel' => 'tooltip', 'class' => 'btn btn-default', 'onclick' => 'setFormAntrian("next");', 'style' => 'margin-bottom: 5px; font-size: 26pt;')); ?>
                    </div>
                    <br/>Panggil Manual<br/>
                    <?php
                    echo CHtml::textField('txt_no_antrian', null, array(
                        'style'=>'width: 300px; height: 90px; font-size: 50pt; text-align: center; font-weight: bold;', 'class'=>'all-caps',
                        'rel'=>'tooltip', 'title'=>'Panggil Manual'
                        //'placeholder'=>'Panggil Manual'
                    ));
                    ?>
                </td>
                <td colspan="2" id="panel_form_antrian">
                    <?php echo $this->renderPartial($this->path_view."_formPanggilAntrian2",array('modAntrian'=>$modAntrian),true); ?>
                    
                </td>
            </tr>
            <tr>
                <td>
                    <div class="label_det">Sebelumnya</div>
                    <div class="label_no_antrian" id="antrian_sebelum">X-0000</div>
                </td>
                <td>
                    <div class="label_det">Selanjutnya</div>
                    <div class="label_no_antrian" id="antrian_selanjutnya">X-0000</div>
                </td>
            </tr>
        </table>
    </div>
</div>

<?php $konfig = KonfigsystemK::model()->find(); ?>
<script>
    
    var socket;
    
    function setNamaLoket(idModelantrian){
	$.ajax({
            type:'POST',
    //        url:'<?php // echo $this->createUrl('SetDropdownLoket'); ?>',
            url:'<?php echo Yii::app()->createUrl('/pendaftaranPenjadwalan/PendaftaranRawatJalan/SetDropdownLoket'); ?>',
            data: {idModelantrian:idModelantrian},
            dataType: "json",
            success:function(data){
                $(".diLoketAjax").html(data.diLoket_antrian);
                return true;
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }
    
    /**
    * set form antrian 
    * @param {type} antrian_id
    * @returns {undefined} */
    function setFormAntrian(record){
        var modelantrian_id = $("#cari_loket_id").val();
        var noantrian = $("#<?php echo CHtml::activeId($modAntrian, 'noantrian'); ?>").val();
        $("#<?php echo CHtml::activeId($daftar, 'antrian_id')?>").val("");
        $("#noantrian").val("");
        if(record == "reset"){
            noantrian = "";
        } else if (record == "next" || record == "prev") {
            $("#txt_no_antrian").val("");
        }
        $("#panel_form_antrian").addClass('animation-loading');
        $.ajax({
            type:'POST',
            url:'<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan/SetFormAntrian'); ?>',
            data: {loket_id:modelantrian_id, noantrian : noantrian, record:record, menu:1},
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                }
                $("#panel_form_antrian").html(data.form_antrian);
                $("#panel_form_antrian").removeClass('animation-loading');
                
                $("#antrian_sebelum").html(data.antrian_prev);
                $("#antrian_selanjutnya").html(data.antrian_next);
                
                return true;
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }
    
    function panggilAntrian() {
        var modelantrian_id = $("#cari_loket_id").val();
        var loket_id = $("#namaLoket").val();
        
        if (modelantrian_id == "") {
            myAlert("Silakan tentukan loket yang akan digunakan untuk memanggil antrian!");
            return false;
        }
        
        var antrian_id = $("#<?php echo CHtml::activeId($modAntrian, 'antrian_id'); ?>").val();
        var noantrian = $("#txt_no_antrian").val();
	var sudahdipanggil = $("#<?php echo CHtml::activeId($modAntrian, 'panggil_flaq'); ?>").val();
	var attr_onclick = $("#btn-panggilantrian").attr("onclick"); //RTN-2259
        var loket_id = $("#namaLoket").val();
        if(antrian_id == ""){
            myAlert("Silakan tentukan antrian yang akan dipanggil!");
            return false;
        }
        if (loket_id == "") {
            myAlert("Silakan tentukan loket yang akan digunakan untuk memanggil antrian!");
            return false;
        }
	//if(sudahdipanggil == 1){ //RTN-2259
	//	myAlert("Pasien ini sudah dipanggil!");
	//	return false;	
	//}
	$(".panel_panggil .btn-primary").parent().addClass('animation-loading');
	$('.panel_panggil .btn-primary').attr("disabled",true);
	// $('#dialog-panggilantrian .btn-primary').removeAttr("onclick");
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/Panggil'); ?>&antrian_id='+antrian_id+'&ket='+''+'&loket_id='+loket_id+'&no_antrian='+noantrian,
            data: {},
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                }
                <?php if(Yii::app()->user->getState('is_nodejsaktif')){ ?>
                socket.emit('send',{conversationID:'antrian',panggil:1,antrian_id:data.antrian_id});
                <?php } ?>
                $("#<?php echo CHtml::activeId($modAntrian, 'antrian_id')?>").val(data.antrian_id);
                $("#<?php echo CHtml::activeId($modAntrian, 'noantrian')?>").val(data.noantrian);
                setFormAntrian(""); //refresh
                $("#noantrian").val(data.noantrian);
                $("#<?php echo CHtml::activeId($daftar, 'antrian_id')?>").val(data.antrian_id);
                            setTimeout(function(){
                                    $(".panel_panggil .btn-primary").parent().removeClass('animation-loading');
                                    $('.panel_panggil .btn-primary').removeAttr("disabled");
                                    // $('#dialog-panggilantrian .btn-primary').attr("onclick",attr_onclick);
                            },3000); //3 detik tombol baru aktif
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
        
        
    }
    
    
    $(document).ready(function() {
        //setAntrians('');
        <?php if($konfig->is_nodejsaktif){ ?>
        <?php 
                if (!empty($konfig->nodejs_host)){
        ?>
                        var chatServer='<?php echo 	$konfig->nodejs_host; ?>';
                        var chatPort='<?php echo 	$konfig->nodejs_port; ?>';                                        
        <?php
                }else{
        ?>
                        var chatServer='localhost';
                        var chatPort='3000';
        <?php
                }
        ?>	
        socket = io.connect(chatServer+':'+chatPort,{secure: true});
        <?php }  ?>
    });
    
</script>

