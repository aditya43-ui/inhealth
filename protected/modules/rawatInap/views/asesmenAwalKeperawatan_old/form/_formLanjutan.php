<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Gangguan Fungsional</label>
        <div class="controls">
            <?php echo $form->checkBox($model,'gangguanfungsi_buta',array()); ?> <label>Buta</label>
        </div>
        <div class="controls">
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="controls">
            <?php echo $form->checkBox($model,'gangguanfungsi_dayaingat',array()); ?> <label>Penurunan Daya Ingat</label>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <?php echo $form->checkBox($model,'gangguanfungsi_tuli',array()); ?> <label>Tuli</label>
        </div>
        <div class="controls">
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="controls">
            <?php echo $form->checkBox($model,'gangguanfungsi_lemahanggotagerak',array()); ?> <label>Kelemahan Anggota</label>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <?php echo $form->checkBox($model,'gangguanfungsi_normal',array()); ?> <label>Normal</label>
        </div>
        <div class="controls">
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="controls">
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Skrining Risiko Jatuh</label>
        <div class="controls">
            <?php echo $form->checkBox($model,'resikojatuh_ada',array('onclick'=>'getDataResikoJatuh("ada")')); ?> <label>Ada</label>
            <?php echo $form->hiddenField($model,'skoringresikojatuh_id',array('class'=>'span2','readonly'=>true)); ?>
        </div>
        <div class="controls">
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="controls">
            <?php echo $form->checkBox($model,'resikojatuh_tidakada',array('onclick'=>'getDataResikoJatuh("tidak")')); ?> <label>Tidak</label>
        </div>
    </div> 
    
    <div class="control-group">
        <label class="control-label"></label>
        <div class="hover">
            <div class="controls" style="border:1px solid #333;padding:5px;height:42px;width:42px;">

            </div>
            <div class="controls geseraja" style="border:1px solid #333;padding:5px;height:22px;width:20px;border-radius:20%;position: relative;left:-30px;top:5px;" onclick="calldialogAsesmenResikoJatuh(this)">

            </div>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <label>Skrining Jatuh</label>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Skrining Nyeri</label>
        <div class="controls">
            <?php echo $form->checkBox($model,'skrining_nyeri_ada',array('onclick'=>'getDataAsesmenNyeri("ada");')); ?> <label>Ada</label>
        </div>
        <div class="controls">
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="controls">
            <?php echo $form->checkBox($model,'skrining_nyeri_tidakada',array('onclick'=>'getDataAsesmenNyeri("tidak");')); ?> <label>Tidak</label>
        </div>
    </div> 
    
    <div class="control-group">
        <label class="control-label"></label>
        <div class="hover">
        <div class="controls" style="border:1px solid #333;padding:5px;">
            <?php  echo CHtml::image('images/icon_nyeri/6.png','alt',array('width'=>'30px','onclick'=>'calldialogAsesmenNyeri();')); ?>
<!--        <a href="<?php // echo $this->createUrl('/rawatInap/AsesmenNyeri/Index',array('pendaftaran_id'=> $modPendaftaran->pendaftaran_id)) ?>">
             <img src="images/icon_nyeri/6.png" title="sports" width="30px" />
        </a>-->


        </div>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <label>Skrining Nyeri</label>
        </div>
    </div>
     <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
           <?php echo $form->hiddenField($model,'asesmentnyeri_id',array('class'=>'span2','readonly'=>true)); ?>
           <?php echo $form->textField($model,'skor_nyeri',array('class'=>'span2','readonly'=>true)); ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Risiko Infeksi</label>
        <div class="controls">
            <?php echo $form->checkBox($model,'resikoinfeksi_ada',array('onclick'=>'
                if($(this).is(":checked")){
                    $("#'.CHtml::activeId($model, 'resikoinfeksi_tidakada').'").removeAttr("checked");
                    $("#'.CHtml::activeId($model, 'resikoinfeksi_tidakdiketahui').'").removeAttr("checked");
                }
            ')); ?> <label>Ada</label>
        </div>
        <div class="controls">
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="controls">
            <?php echo $form->checkBox($model,'resikoinfeksi_tidakada',array('onclick'=>'
                if($(this).is(":checked")){
                    $("#'.CHtml::activeId($model, 'resikoinfeksi_ada').'").removeAttr("checked");
                    $("#'.CHtml::activeId($model, 'resikoinfeksi_tidakdiketahui').'").removeAttr("checked");
                }
            ')); ?> <label>Tidak Ada</label>
        </div>
    </div> 
    
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <?php echo $form->checkBox($model,'resikoinfeksi_tidakdiketahui',array('onclick'=>'
                if($(this).is(":checked")){
                    $("#'.CHtml::activeId($model, 'resikoinfeksi_tidakada').'").removeAttr("checked");
                    $("#'.CHtml::activeId($model, 'resikoinfeksi_ada').'").removeAttr("checked");
                }
            ')); ?> <label>Tidak Diketahui</label>
        </div>
    </div> 
    
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <?php echo $form->textField($model,'resikoinfeksi_ada_keterangan',array('placeholder'=>'ada',
                'onblur'=>'if($(this).val()==""){
                        $("#'.CHtml::activeId($model, 'resikoinfeksi_ada').'").removeAttr("checked");
                    }else{
                        $("#'.CHtml::activeId($model, 'resikoinfeksi_ada').'").attr("checked",true);
                        $("#'.CHtml::activeId($model, 'resikoinfeksi_tidakada').'").removeAttr("checked");
                        $("#'.CHtml::activeId($model, 'resikoinfeksi_tidakdiketahui').'").removeAttr("checked");
                    }',
            )); ?> 
        </div>       
    </div> 
    
    <div class="control-group">
        <label class="control-label">Pencegahan yang harus dilakukan</label>
        <div class="controls">
            <?php echo $form->checkBox($model,'pencegahan_droplet',array()); ?> <label>Droplet</label>
        </div>
        <div class="controls">
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="controls">
            <?php echo $form->checkBox($model,'pencegahan_udara',array()); ?> <label>Udara</label>
        </div>
    </div> 
    
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <?php echo $form->checkBox($model,'pencegahan_cairantubuh',array()); ?> <label>Cairan Tubuh</label>
        </div>
        <div class="controls">
            
        </div>
        <div class="controls">
            <?php echo $form->checkBox($model,'pencegahan_cairankulit',array()); ?> <label>Cairan Kulit</label>
        </div>
    </div> 
    
     <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
               <?php echo $form->checkBox($model,'pencegahan_kontakkulit',array()); ?> <label>Kontak Langsung/Kulit</label>
        </div>      
    </div> 
     
</div>


<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Risiko Sosial</label>
        <div class="controls">
               <?php echo $form->checkBox($model,'resikososial_hidupsendiri',array()); ?> <label>Hidup Sendiri</label>
        </div>      
    </div> 
    
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
               <?php echo $form->checkBox($model,'resikososial_tidakada',array()); ?> <label>Tidak Ada</label>
        </div>      
    </div> 
    
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
               <?php echo $form->checkBox($model,'resikososial_tidaktetap',array()); ?> <label>Tempat Tinggal Tidak Tetap</label>
        </div>      
    </div>
    
    
    
    <div class="control-group">
        <label class="control-label">Kondisi Psikologis Pasien</label>
        <div class="controls">
               <?php echo $form->checkBox($model,'kondisipasien_denial',array()); ?> <label>Denial (menolak)</label>
        </div>      
    </div> 
    
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
               <?php echo $form->checkBox($model,'kondisipasien_marah',array()); ?> <label>Marah</label>
        </div>      
    </div> 
    
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
               <?php echo $form->checkBox($model,'kondisipasien_bargaining',array()); ?> <label>Bargaining</label>
        </div>      
    </div> 
    
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
               <?php echo $form->checkBox($model,'kondisipasien_depresi',array()); ?> <label>Depresi/Cemas</label>
        </div>      
    </div> 
    
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
               <?php echo $form->checkBox($model,'kondisipasien_pasrah',array()); ?> <label>Pasrah</label>
        </div>      
    </div> 
    
    <div class="control-group">
        <label class="control-label">Masalah Keperawatan</label>
        <div class="controls">
               <?php echo $form->textArea($model,'masalahkeperawatan',array('class'=>'autogrow')); ?>
        </div>      
    </div> 
</div>

<div class="clear"></div>


<div class="col-sm-12">
     <div class="control-group">
        <label class="control-label">Mengetahui :</label>
        <div class="controls">
               
        </div>      
    </div>         
</div>

<div class="clear"></div>
<div class="col-sm-6">
     <div class="control-group">
         <label class="control-label">DPJP Utama<span class="required">*</span></label>
        <div class="controls">       
            <?php
                echo $form->hiddenField($model,'dpjp_id',array('class'=>'required','readonly'=>true));

               $this->widget('MyJuiAutoComplete', array(    
                   'model'=>$model,
                   'attribute' => 'dpjp_nama',
                   'source'=>'js: function(request, response) {
                                   $.ajax({
                                       url: "' . $this->createUrl('AutocompleteDokter') . '",
                                       dataType: "json",
                                       data: {
                                           term: request.term,
                                       },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
                    'options'=>array(
                           'showAnim'=>'fold',
                           'minLength' => 3,
                           'focus'=> 'js:function( event, ui ) {
                                $(this).val("");
                                return false;
                            }',
                           'select'=>'js:function( event, ui ) {
                                $(this).val(ui.item.label);
                                $("#RIAsesmenAwalKeperawatanT_dpjp_id").val(ui.item.value);
                                $("#RIAsesmenAwalKeperawatanT_dpjp_nama").val(ui.item.label);
                                return false;
                            }',
                    ),
               'htmlOptions'=>array(
                   'readonly'=>false,
                   'placeholder'=>'DPJP',
                   'size'=>20,
                   'class'=>'span3 required',
                   'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'dpjp_id') . '").val(""); ',
                   'onkeypress'=>"return $(this).focusNextInputField(event);",
               ),
               'tombolDialog'=>array('idDialog'=>'dialogDPJP','idTombol'=>'tombolDPJP'),
               ));
               ?>        
        </div>      
    </div>  
</div>    
<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Perawat/PPJP<span class="required">*</span></label>
        <div class="controls">
               <?php
                echo $form->hiddenField($model,'perawat_id',array('class'=>'required','readonly'=>true));

               $this->widget('MyJuiAutoComplete', array(    
                   'model'=>$model,
                   'attribute' => 'perawat_nama',
                   'source'=>'js: function(request, response) {
                                   $.ajax({
                                       url: "' . $this->createUrl('AutocompletePerawat') . '",
                                       dataType: "json",
                                       data: {
                                           term: request.term,
                                       },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
                    'options'=>array(
                           'showAnim'=>'fold',
                           'minLength' => 3,
                           'focus'=> 'js:function( event, ui ) {
                                $(this).val("");
                                return false;
                            }',
                           'select'=>'js:function( event, ui ) {
                                $(this).val(ui.item.label);
                                $("#RIAsesmenAwalKeperawatanT_perawat_id").val(ui.item.value);
                                $("#RIAsesmenAwalKeperawatanT_perawat_nama").val(ui.item.label);
                                return false;
                            }',
                    ),

               'htmlOptions'=>array(
                   'readonly'=>false,
                   'placeholder'=>'PPJP',
                   'size'=>20,
                   'class'=>'span3 required',
                   'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'perawat_id') . '").val(""); ',
                   'onkeypress'=>"return $(this).focusNextInputField(event);",
               ),
               'tombolDialog'=>array('idDialog'=>'dialogPPJP','idTombol'=>'tombolPPJP'),
               ));
               ?>  
        </div>      
    </div> 
</div>

<?php
//========= Dialog Detail Asesmen Nyeri =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAsesmennyeri',
    'options' => array(
        'title' => 'Data Asesmen Nyeri',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1160,
        'height' => 600,
        'resizable' => false,
        'close'=>'js:function(){getDataAsesmenNyeri("");}',
    ),
));
?>
<iframe id="frameAsesmenNyeri" name="pesan" width="100%" height="500">
</iframe>
<?php
$this->endWidget();
?>

<?php
//========= Dialog Resiko Jatuh =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogResikoJatuh',
    'options' => array(
        'title' => 'Data Asesmen Resiko Jatuh',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));
?>
<iframe id="frameAsesmenResikoJatuh" name="pesan" width="100%" height="500">
</iframe>
<?php
$this->endWidget();
?>

<script type="text/javascript">
function calldialogAsesmenNyeri(){
    $('#dialogAsesmennyeri').dialog('open');

    $('#frameAsesmenNyeri').attr('src','<?php echo $this->createUrl('/rawatInap/AsesmenNyeri/Index',array('pendaftaran_id'=> $modPendaftaran->pendaftaran_id)); ?>');				
}

function calldialogAsesmenResikoJatuh(){
    $('#dialogResikoJatuh').dialog('open');
    	
    $('#frameAsesmenResikoJatuh').attr('src','<?php  echo $this->createUrl('/rawatJalan/AsesmentResikoJatuh/Index',array('id'=>$modPendaftaran->pendaftaran_id)); ?>');				
}


function getDataAsesmenNyeri(ket) { 
    var pendaftaran_id = <?php echo $modPendaftaran->pendaftaran_id ?>;
    
    if($("#<?php echo CHtml::activeId($model, 'skrining_nyeri_tidakada') ?>").is(":checked") && ket=="tidak"){
        $('#<?php echo CHtml::activeId($model, 'skor_nyeri'); ?>').val('');
        $('#<?php echo CHtml::activeId($model, 'asesmennyeri_id'); ?>').val('');
        $("#<?php echo CHtml::activeId($model, 'skrining_nyeri_ada') ?>").removeAttr('checked');
        $("#<?php echo CHtml::activeId($model, 'skrining_nyeri_tidakada') ?>").attr('checked',true);
        return false;
    }
    
    $.ajax({
        url:'<?php echo $this->createUrl('/rawatInap/AsesmenAwalKeperawatan/GetDataAsesmenNyeri'); ?>',
        data:{pendaftaran_id:pendaftaran_id},
        type:'post',
        dataType:'json',
        success:function(data){
            if(data.status == true && data.score_skalanyeri > 0){
               $("#<?php echo CHtml::activeId($model, 'skor_nyeri') ?>").val(data.score_skalanyeri);
               $("#<?php echo CHtml::activeId($model, 'asesmennyeri_id') ?>").val(data.asesmentnyeri);
               $("#<?php echo CHtml::activeId($model, 'skrining_nyeri_ada') ?>").attr('checked',true);
               $("#<?php echo CHtml::activeId($model, 'skrining_nyeri_tidakada') ?>").removeAttr('checked');
            }else{
               $('#<?php echo CHtml::activeId($model, 'skor_nyeri'); ?>').val('');
               $("#<?php echo CHtml::activeId($model, 'skrining_nyeri_ada') ?>").removeAttr('checked');
               $("#<?php echo CHtml::activeId($model, 'skrining_nyeri_tidakada') ?>").attr('checked',true);
           }
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            $('#<?php echo CHtml::activeId($model, 'skor_nyeri'); ?>').val('');
            $('#<?php echo CHtml::activeId($model, 'asesmennyeri_id'); ?>').val('');
            $("#<?php echo CHtml::activeId($model, 'skrining_nyeri_ada') ?>").removeAttr('checked');
            $("#<?php echo CHtml::activeId($model, 'skrining_nyeri_tidakada') ?>").removeAttr('checked');
        },
        cache:false,
    }); 
}

function getDataResikoJatuh(ket) {
    var pendaftaran_id = <?php echo $modPendaftaran->pendaftaran_id ?>; 
    
    if($("#<?php echo CHtml::activeId($model, 'resikojatuh_tidakada') ?>").is(":checked") && ket=="tidak"){
        $('#<?php echo CHtml::activeId($model, 'skoringresikojatuh_id') ?>').val("");
        $("#<?php echo CHtml::activeId($model, 'resikojatuh_ada') ?>").removeAttr('checked');
        $("#<?php echo CHtml::activeId($model, 'resikojatuh_tidakada') ?>").attr('checked',true);
        return false;
    }
    
    $.ajax({
        url:'<?php echo $this->createUrl('/rawatInap/AsesmenAwalKeperawatan/GetDataResikoJatuh'); ?>',
        data:{pendaftaran_id:pendaftaran_id}, 
        type:'post',
        dataType:'json',
        success:function(data){
          if(data.status == 1) {
              $('#<?php echo CHtml::activeId($model, 'skoringresikojatuh_id') ?>').val(data.skoringresikojatuh_id);
              $("#<?php echo CHtml::activeId($model, 'resikojatuh_ada') ?>").attr('checked',true);
              $("#<?php echo CHtml::activeId($model, 'resikojatuh_tidakada') ?>").removeAttr('checked');
          }else{
              $('#<?php echo CHtml::activeId($model, 'skoringresikojatuh_id') ?>').val("");
              $("#<?php echo CHtml::activeId($model, 'resikojatuh_ada') ?>").removeAttr('checked');
              $("#<?php echo CHtml::activeId($model, 'resikojatuh_tidakada') ?>").attr('checked',true);
          }     
        },   
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);},
        cache:false,
    });    
}

$(document).ready(function(){ 
    getDataAsesmenNyeri();
    getDataResikoJatuh();
})

</script>