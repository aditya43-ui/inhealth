<style>
    .jml_antrian_free {
        position: relative;
        top: -15px;
        left: -10px;
    }
    .badge_jmlPanggil {
        position: relative;
        top: -15px;
        left: -10px;
    }
</style>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-bullhorn"></i> Panggil Antrian
                <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPasienBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?></span>
            </div>
        </div>
        <div class="panel-body">
            <div class="control-group">
                <?php echo CHtml::label('No. Antrian', 'noantrian', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->hiddenField($model, 'antrian_id', array('readonly' => true)); ?>
                    <?php echo CHtml::dropDownList('cari_loket_id', $modAntrian->modelantrian_id, CHtml::listData($modAntrian->getModelAntriansPendaftaranByCode('L'), 'modelantrian_id', 'modelantrian_nama'), array('class' => 'span2', 'empty' => '-- Pilih --', 'onchange' => 'setNamaLoket(this.value); setFormAntrian("reset");')) ?>
                    <?php echo CHtml::textField('noantrian', $modAntrian->noantrian, array('readonly' => true, 'class' => 'span2', 'style' => 'width:50px;', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    di <i class="diLoketAjax"> <?php echo CHtml::dropDownList('namaLoket', $modAntrian->namaLoket, CHtml::listData($modAntrian->getNamaLoketAntrian($modAntrian->modelantrian_id), 'loket_id', 'loket_nama'), array('class' => 'span2', 'empty' => '-- Pilih --', 'style' => 'width:100px;', 'onchange' => 'setFormAntrian("reset");')) ?></i>
                    &nbsp; <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-volume-up icon-white"></i>')), array('id' => 'bth-lihatantrian', 'title' => 'Klik untuk menampilkan form antrian', 'rel' => 'tooltip', 'class' => 'btn btn-primary', 'onclick' => '$("#dialog-panggilantrian").dialog("open");')); ?>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
    
    /**
     * Untuk direct link ke pendaftaran Rujukan RS
     */
    function pendaftaranRujukan(){
        var pasienkirimkeunitlain_id = $("#pasienkirimkeunitlain_id").val();
        var antrian_id = $("#<?=CHtml::activeId($model, 'antrian_id');?>").val();
        if(pasienkirimkeunitlain_id==''){
            myAlert("Silahkan pilih terlebih dahulu data rujukan pasien");
        }else{
            var url = "&pasienkirimkeunitlain_id="+pasienkirimkeunitlain_id+"&antrian_id="+antrian_id+"";
            window.location = '<?=Yii::app()->controller->createUrl("pendaftaranLaboratoriumRujukanRS/index")?>'+url;
        }
    }
    
    /**
     * Reset pasienkirimkeunitlain_id ketika no pendaftaran kosong/dihapus
     * @param {type} obj
     */
    function resetId(obj){
        if($(obj).val()==''){
            $("#pasienkirimkeunitlain_id").val('');
        }
    }
    
    function panggilAntrianLab(ket){
        var antrian_id = $("#<?php echo CHtml::activeId($modAntrian, 'antrian_id'); ?>").val();
        var noantrian = $("#<?php echo CHtml::activeId($modAntrian, 'noantrian'); ?>").val();
        var jml_panggil = parseInt($("#<?php echo CHtml::activeId($modAntrian, 'jml_panggil'); ?>").val());
        var sudahdipanggil = $("#<?php echo CHtml::activeId($modAntrian, 'panggil_flaq'); ?>").val();
        var attr_onclick = $("#btn-panggilantrian").attr("onclick"); //RTN-2259
        var loket_id = $("#cari_loket_id").val();
        var modelantrian_id = $("#modelantrian_id").val();

        if(modelantrian_id == "" && loket_id == ""){
            myAlert("Silahkan tentukan antrian yang akan dipanggil !");
            return false;
        }
        if(loket_id == ""){
            myAlert("Silahkan tentukan loket antrian !");
            return false;
        }

        if(jml_panggil >= 3 && ket != 'ulang'){
            myConfirm('Panggil antrian pasien yang ke '+(jml_panggil+1)+' kali nya ?','Perhatian!',
            function(r){
                if(r){
                    panggilAntrianLab('ulang');
                }else{
                    return false;
                }
            });
            return false;
        }

        if(ket == 'panggil' && antrian_id==''){
            myAlert("Silahkan tentukan antrian yang akan dipanggil !");
            return false;
        }

        $("#dialog-panggilantrian .btn-primary").parent().addClass('animation-loading');
        $("#panggil").addClass('animation-loading');
        $('#dialog-panggilantrian .btn-primary').attr("disabled",true);
        $.ajax({
            type:'POST',
            url:'<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan/Panggil'); ?>&antrian_id='+antrian_id+'&ket='+ket+'&loket_id='+loket_id,
            data: {},
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                }
        <?php if (Yii::app()->user->getState('is_nodejsaktif')) { ?>
            socket.emit('send',{conversationID:'antrianPendaftaranLab',panggil:1,antrian_id:antrian_id});
            socket.emit('send',{conversationID:'panggilAntrianPendaftaran',antrian_id:antrian_id,user_id:data.update_loginpemakai_id});
        <?php } ?>
            $("#noantrian").html(data.noantrian+' <i class="icon-volume-up icon-white"></li>');
            if(data.jml_panggil != null){
                $('.badge_jmlPanggil').html(data.jml_panggil+' x');
                $('.badge_jmlPanggil').show();
            }else{
                $('.badge_jmlPanggil').html();
                $('.badge_jmlPanggil').hide();
            }
            $('.jml_antrian_free').html(data.sisaAntrian);
            $('.jml_antrian_free').show();

            $("#<?php echo CHtml::activeId($modAntrian, 'jml_panggil'); ?>").val(data.jml_panggil);
            $("#<?php echo CHtml::activeId($model, 'antrian_id') ?>").val(data.antrian_id);
                setTimeout(function(){
                    $("#dialog-panggilantrian .btn-primary").parent().removeClass('animation-loading');
                    $('#dialog-panggilantrian .btn-primary').removeAttr("disabled");
                    $("#panggil").removeClass("animation-loading");
                    $(".f_rm:first").focus();
                },3000); //3 detik tombol baru aktif
            },
            error: function (jqXHR, textStatus, errorThrown) { 
                console.log(errorThrown);
                $('#panggil').removeClass("animation-loading");
            }
        });
    }
</script>