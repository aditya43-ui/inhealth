
<legend class="rim2">Penjadwalan Dokter Rawat Inap</legend>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.mtz.monthpicker.js'); ?>
<?php 

$this->breadcrumbs=array(
    'Informasi Jadwal Dokter'
);

$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'carijadwal-form',
	'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#'.CHtml::activeId($model,'ruangan_id'),
                'method'=>'GET',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
));
$url=Yii::app()->createUrl($this->route);
Yii::app()->clientScript->registerScript('cariPasien', "
$('#carijadwal-form').submit(function(){
	$.get('${url}&'+$(this).serialize(),{},function(data){
           $('#table-jadwal-poliklinik').html(data);
        },'json');
	return false;
});
");?>
<style>
    .table tbody tr td{
        height: 100px;
/*        font-size:7pt;*/
    }
    .table tbody tr td.disabled{
        background-color: #FEE;
    }
    .table tbody tr td .box1{        
        border: 1px solid #ccc;
        margin:2px 2px 5px 2px;
        padding:5px 5px 0px 5px;
        border-radius:3px;
        -webkit-border-radius:3px;
        -o-border-radius:3px;
        -moz-border-radius:3px;
    }
    .table tbody tr td .box1.active{        
        border:1px solid red;
    }
    
    .table tbody tr td .box1 ul li.active a{
        color:red;
    }
</style>
<div id="table-jadwal-poliklinik">
<?php echo $grid; ?>
</div>
<hr>
<fieldset>
    <legend class="rim">Pencarian</legend>
    
    <table class="table">
        <tr>
            <td>
                <div class="control-group">
                <?php echo $form->labelEx($model,'jadwaldokter_mulai', array('class'=>'control-label')) ?>
                <div class="controls">
                    <div class="input-append">
                        <input type="text" name="RIJadwaldokterM[jadwaldokter_mulai]" id="RIJadwaldokterM" onkeypress="return $(this).focusNextInputField(event);" readonly="readonly" class="hasDatepicker">
                        <span class="add-on"><i class="entypo-calendar"></i></span>
                    </div>                    
                </div>
            </div>
                   
                </div>
            </div>
                <?php //echo $form->dropDownListRow($model,'jadwaldokter_hari', $listHari ,array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'empty'=>'-- Pilih --')); ?>
                <?php echo $form->dropDownListRow($model,'pegawai_id', CHtml::listData(RIPendaftaranT::model()->getDokterItemsInstalasi(Params::INSTALASI_ID_RI), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                
            </td>
            <td>
                <?php echo $form->dropDownListRow($model,'ruangan_id', CHtml::listData(RIPendaftaranT::model()->getRuanganItems(Params::INSTALASI_ID_RI), 'ruangan_id', 'ruangan_nama') ,
                                                      array('empty'=>'-- Pilih --',
                                                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                
                <!--
            <div class="control-group">
                <?php echo $form->labelEx($model,'jadwaldokter_tutup', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'jadwaldokter_tutup',
                                            'mode'=>'time',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,
                                                                 'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                                 ),
                    )); ?><?php echo $form->error($model, 'jadwaldokter_tutup'); ?>
                    
                </div>
            </div>
-->
            </td>
        </tr>
    </table>
</fieldset>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            ); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                $this->createUrl($this->id.'/index'), 
                                array('class' => 'btn btn-default',
                                    'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;')); ?>
        <?php 
            $content = $this->renderPartial('../tips/informasi',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>	
    </div>


<?php $this->endWidget(); ?>
<?php 
$format = new MyFormatter();
        ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#RDJadwaldokterM_jadwaldokter_mulai').monthpicker({ pattern: 'mmmm yyyy'});
    });
</script>

<?php 
$urlListDokterRuangan = Yii::app()->createUrl('actionDynamic/listDokterRuangan');
Yii::app()->clientScript->registerScript('test','
function updateJadwal(data){
    $.post("'.$url.'",{data:data},function(hasil){
        $("#isiDialogUbahJadwal").html(hasil);
        $("#dialogUbahjadwal").dialog("open");
        findObject();
    },"json");
}
function updateValueJadwal(obj){
    url = $(obj).attr("action");
    variable = $(obj).serialize();
    $.ajax({
        url : url,
        type : "post",
        dataType : "json",
        data : $(obj).serialize()+"&data=true",
        success : function(result){
            $("#isiDialogUbahJadwal").html(result);
            findObject();
        }
    });
    
}

function findObject(){
    $("#isiDialogUbahJadwal .numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
    $("#isiDialogUbahJadwal .timePickerTest").timepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional["id"], {"showAnim":"fold","dateFormat":"yy-mm-dd","changeFirstDay":false,"changeMonth":true,"timeText":"Waktu","hourText":"Jam","minuteText":"Menit","secondText":"Detik","showSecond":true,"timeOnlyTitle":"Pilih Waktu","timeFormat":"hh:mm:ss","changeYear":true,"yearRange":"-80y:+20y"}));
}

function listDokterRuangan(idRuangan)
{
    $.post("'.$urlListDokterRuangan.'", { idRuangan: idRuangan },
        function(data){
            $("#JadwaldokterM_pegawai_id").html(data.listDokter);
    }, "json");
}
', CClientScript::POS_HEAD); 
?>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'dialogUbahjadwal',
        'options'=>array(
            'title'=>'Ubah Jadwal',
            'resizable'=>false,
            'width'=>500,
            'height'=>350,
            'autoOpen' => false,
            'modal' => true,
            'beforeClose'=>'js:function(event,test){$("#carijadwal-form").submit();}'
    ),
));

   echo '<div id="isiDialogUbahJadwal"></div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.numbersOnly',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => ',',
        'thousands' => '',
        'precision' => 0,
    )
));
?>

<?php
    $this->widget('MyDateTimePicker', array(
        'name'=>'jadwalDokter[txtEndDate]',
        'mode'=>'date',
        // additional javascript options for the date picker plugin
        'options'=>array(
            'showAnim'=>'fold',
            'beforeShow'=>'js:function(){customRange(this);}',
            'dateFormat'=>"yy-mm-dd",
            'changeFirstDay'=>false,
            'changeMonth'=>true,
            'numberOfMonths'=>3,
        ),
        'htmlOptions'=>array(
            'id'=>'txtEndDate',
            'onchange'=>'$("#inputForm, #submitForm").html("");',
            'style'=>'display:none;',
            'hide'=>true,
        ),
    ));
?>