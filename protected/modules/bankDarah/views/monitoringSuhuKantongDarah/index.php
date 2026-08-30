<style>
    .desimal{
        text-align: right;
    }
</style>
<?php 
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success',"Data berhasil disimpan !");
    }
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'monitoringsuhu-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
    'focus'=>'',
)); ?>

    <div class="panel panel-primary panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"><strong>Monitoring Suhu Cool Box Transport Darah Donor</strong></div>
        </div>
        <div class="panel-body">
            
            <div class="panel panel-success panel-shadow">
                <div class="panel-heading">
                    <div class="panel-title"><span class='judul'>Data Pengirim Kantong Darah</span></div>
                </div>
                <div class="panel-body">
                    <div class="row-fluid">
                        <?php $this->renderPartial('_formPengirim', array('form'=>$form,
                            'model'=>$model,
                            'modKirimKantongDarah'=>$modKirimKantongDarah,)); 
                        ?>
                    </div>
                </div>
            </div>
            <div class="panel panel-success panel-shadow">
                <div class="panel-heading">
                    <div class="panel-title"><span class='judul'>Monitoring Suhu Cool Box</span></div>
                </div>
                <div class="panel-body">
                    <div class="row-fluid">
                        <?php $this->renderPartial('_formMonitoring', array('form'=>$form,
                            'model'=>$model,
                            'modKirimKantongDarah'=>$modKirimKantongDarah,)); 
                        ?>
                    </div>
                </div>
            </div>
            <div class="row-fluid" style="margin-left: 25px;">
                <div class="span6">
                    <div class="control-group">
                        <?php echo CHtml::label("Tanggal <span class='required'>*</span>", 'tglmonitoring', array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'tglmonitoring',
                            'mode'=>'date',
                            'options'=> array(
                                'maxDate' => 'd',
                                'showOn' => false,
                                'yearRange'=> "-150:+0",
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                            'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 span3 required', 'onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true
                            ),
                            )); 
                            ?>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="control-group">
                        <?php echo CHtml::label(" ", 'tglmonitoring', array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Tambah',array('{icon}'=>'<i class="entypo-plus"></i>')),
                            array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'tambahSuhu();return false;', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-success panel-shadow">
                <div class="panel-heading">
                    <div class="panel-title"><span class='judul'>Tabel Monitoring Suhu Cool Box</span></div>
                </div>
                <div class="panel-body" style="overflow-y: auto;">
                    <div class="row-fluid">
                        <?php $this->renderPartial('_tabel', array('form'=>$form,
                            'model'=>$model,
                            'modKirimKantongDarah'=>$modKirimKantongDarah,)); 
                        ?>
                    </div>
                </div>
            </div>
                        
            <div class="row-fluid">
                <div class="form-actions">
                    <?php
                    if(!isset($_GET['sukses'])){
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('id'=>'btn_submit','class'=>'btn btn-primary submit', 'type'=>'button','onclick'=>'cekSimpan();return false;'));
                        echo "&nbsp;";
                        echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'disabled'=>'true'));
                        echo "&nbsp;";
                    }else{
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('disabled'=>true,'id'=>'btn_submit','class'=>'btn btn-primary', 'type'=>'button','onkeypress'=>'formSubmit(this,event);'));
                        echo "&nbsp;";
                        echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"myAlert('Comming Soon');return false"));
                        echo "&nbsp;";
                    }
                    echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    '#', 
                    array('class'=>'btn btn-danger',
                        'onclick'=>'myConfirm("Apakah Anda yakin ingin mengulang ?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index',array('kirimkantongdarah_id'=>$modKirimKantongDarah->kirimkantongdarah_id)).'";} ); return false;'));
                    echo "&nbsp;";
                    echo CHtml::link(Yii::t('mds','{icon} Kembali',array('{icon}'=>'<i class="entypo-back"></i>')), 
                    '#', 
                    array('class'=>'btn btn-danger',
                        'onclick'=>'myConfirm("Apakah Anda yakin ingin Kembali ke informasi pengiriman ?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('informasiPengirimanDarah/index').'";} ); return false;'));
                    echo "&nbsp;";
                    $content = $this->renderPartial('laboratorium.views.pemakaianBahan.tips.tipsPemakaianBahan',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                    ?>
                </div>
            </div>
        </div>
            
        </div>
    </div>
                

<?php $this->endWidget(); ?>

<script>
    
    function tambahSuhu(){
        var petugasmonitoring_id = $("#<?php echo CHtml::activeId($model, 'petugasmonitoring_id') ?>").val();
        if(petugasmonitoring_id == ""){
            myAlert("Pilih petugas monitoring suhu !");
            return false;
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setSuhuMonitor'); ?>',
            data: $('#monitoringsuhu-form').serialize(),
            dataType: "json",
            success: function (data) {
                if(cekDuplikasi(data.model)==0){
                    $("#detail-suhu > tbody").append(data.form);
                    reset();
                    $(".monitor").removeClass('error');
                    $(".monitor").val('');
                    $(".desimal").val(0);
                }else{
                    myAlert("Data tidak boleh sama ! ");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    }
    
    function cekDuplikasi(model){
        var ada = 0;
        $("#detail-suhu > tbody > tr").each(function(){ 
            kosongtanpalistrik_suhu = $(this).find('input[name$="[kosongtanpalistrik_suhu]"]').val();
            kosongtanpalistrik = $(this).find('input[name$="[kosongtanpalistrik]"]').val();
            kosongdenganlistrik_suhu = $(this).find('input[name$="[kosongdenganlistrik_suhu]"]').val();
            kosongdenganlistrik = $(this).find('input[name$="[kosongdenganlistrik]"]').val();
            listrikdanicepack_suhu = $(this).find('input[name$="[listrikdanicepack_suhu]"]').val();
            listrikdanicepack = $(this).find('input[name$="[listrikdanicepack]"]').val();
            mulaiisikantong_suhu = $(this).find('input[name$="[mulaiisikantong_suhu]"]').val();
            mulaiisikantong = $(this).find('input[name$="[mulaiisikantong]"]').val();
            setelahdiisikantong_suhu = $(this).find('input[name$="[setelahdiisikantong_suhu]"]').val();
            setelahdiisikantong = $(this).find('input[name$="[setelahdiisikantong]"]').val();
            lepaslistrik_suhu = $(this).find('input[name$="[lepaslistrik_suhu]"]').val();
            lepaslistrik = $(this).find('input[name$="[lepaslistrik]"]').val();
            kirimkelabitd_suhu = $(this).find('input[name$="[kirimkelabitd_suhu]"]').val();
            kirimkelabitd = $(this).find('input[name$="[kirimkelabitd]"]').val();
            sampaidilabitd_suhu = $(this).find('input[name$="[sampaidilabitd_suhu]"]').val();
            sampaidilabitd = $(this).find('input[name$="[sampaidilabitd]"]').val();
            ket_monitoring = $(this).find('input[name$="[ket_monitoring]"]').val();
            petugasmonitoring_id = $(this).find('input[name$="[petugasmonitoring_id]"]').val();
            
            if(
                model.kosongtanpalistrik == kosongtanpalistrik && model.kosongdenganlistrik == kosongdenganlistrik &&
                model.listrikdanicepack == listrikdanicepack && model.mulaiisikantong == mulaiisikantong &&
                model.setelahdiisikantong == setelahdiisikantong && model.lepaslistrik == lepaslistrik &&
                model.kirimkelabitd == kirimkelabitd && model.sampaidilabitd == sampaidilabitd &&
                model.ket_monitoring == ket_monitoring && model.petugasmonitoring_id == petugasmonitoring_id
            ){
                ada++;
            }
            
            if(model.kosongtanpalistrik != "" && model.kosongtanpalistrik == kosongtanpalistrik){
                $("#<?php echo CHtml::activeId($model, 'kosongtanpalistrik')?>").addClass('error');
                ada++;
            }
            if(model.kosongdenganlistrik != "" && model.kosongdenganlistrik == kosongdenganlistrik){
                $("#<?php echo CHtml::activeId($model, 'kosongdenganlistrik')?>").addClass('error');
                ada++;
            }
            if(model.listrikdanicepack != "" &&model.listrikdanicepack == listrikdanicepack){
                $("#<?php echo CHtml::activeId($model, 'listrikdanicepack')?>").addClass('error');
                ada++;
            }
            if(model.mulaiisikantong != "" &&model.mulaiisikantong == mulaiisikantong){
                $("#<?php echo CHtml::activeId($model, 'mulaiisikantong')?>").addClass('error');
                ada++;
            }
            if(model.setelahdiisikantong != "" &&model.setelahdiisikantong == setelahdiisikantong){
                $("#<?php echo CHtml::activeId($model, 'setelahdiisikantong')?>").addClass('error');
                ada++;
            }
            if(model.lepaslistrik != "" &&model.lepaslistrik == lepaslistrik){
                $("#<?php echo CHtml::activeId($model, 'lepaslistrik')?>").addClass('error');
                ada++;
            }
            if(model.kirimkelabitd != "" &&model.kirimkelabitd == kirimkelabitd){
                $("#<?php echo CHtml::activeId($model, 'kirimkelabitd')?>").addClass('error');
                ada++;
            }
            if(model.sampaidilabitd != "" &&model.sampaidilabitd == sampaidilabitd){
                $("#<?php echo CHtml::activeId($model, 'sampaidilabitd')?>").addClass('error');
                ada++;
            }
            
        });
        return ada;
    }
    
    function reset(){
        renameInput("MonitoringkantongT", "kosongtanpalistrik_suhu");
        renameInput("MonitoringkantongT", "kosongtanpalistrik");
        renameInput("MonitoringkantongT", "kosongdenganlistrik_suhu");
        renameInput("MonitoringkantongT", "kosongdenganlistrik");
        renameInput("MonitoringkantongT", "listrikdanicepack_suhu");
        renameInput("MonitoringkantongT", "listrikdanicepack");
        renameInput("MonitoringkantongT", "mulaiisikantong_suhu");
        renameInput("MonitoringkantongT", "mulaiisikantong");
        renameInput("MonitoringkantongT", "setelahdiisikantong_suhu");
        renameInput("MonitoringkantongT", "setelahdiisikantong");
        renameInput("MonitoringkantongT", "lepaslistrik_suhu");
        renameInput("MonitoringkantongT", "lepaslistrik");
        renameInput("MonitoringkantongT", "kirimkelabitd_suhu");
        renameInput("MonitoringkantongT", "kirimkelabitd");
        renameInput("MonitoringkantongT", "sampaidilabitd_suhu");
        renameInput("MonitoringkantongT", "sampaidilabitd");
        renameInput("MonitoringkantongT", "ket_monitoring");
        renameInput("MonitoringkantongT", "petugasmonitoring_id");
    }
    
    function renameInput(modelName, attributeName)
    {
        var i=0;
        $('#detail-suhu tbody tr').each(function(){
            $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
            $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
            i++;
        });
    }
    
    function batalDetail(obj){
        myConfirm("Apakah anda akan membatalkan monitoring ini ?", "Peringatan", function(r) {
            if (r) {
                $(obj).parents('tr').detach();
                reset();
            }
        });
    }
    
    function cekSimpan(){
        var trLength = $('#detail-suhu tbody tr').length;
        if(trLength > 0){
            $("#monitoringsuhu-form").submit();
        }else{
            myAlert("Tambahkan pencatatan monitoring suhu terlebih dahulu");
        }
    }
    
    $(document).ready(function(){
        $('form').bind('click keyup select change', function(event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change',function(){
            cekDisabled('form');
        });

        cekDisabled('form');
    });
</script>