<?php
$this->breadcrumbs=array(
	'Kppresensi Ts'=>array('index'),
	'Manage',
);

$arrMenu = array();
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Presensi ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' KPPresensiT', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Presensi', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                
$this->menu=$arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('kppresensi-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="cari-lanjut search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!--search-form-->
<div class="form-horizontal">
<?php
$konfigFinger = AlatfingerM::model()->findAll();
if (is_array($konfigFinger)){    
    echo '<div class="control-group"><label for="KPPresensiT_no_fingerprint" class="control-label required">No. Finger Print <span class="required">*</span></label>
            <div class="controls">';
    echo CHtml::dropDownList('finger', '', CHtml::listData($konfigFinger,'alatfinger_id', 'namaalat'), array('empty'=>'-- Pilih --'));
    echo CHtml::button("connect",array("id"=>"connect","class"=>'btn btn-primary','style'=>'height:20px;line-height:4px;padding:0px 5px 0px 5px ;', 'onclick'=>'aktifkanFinger(this, false);'));
    echo CHtml::button("info",array("class"=>'btn btn-info','style'=>'height:20px;line-height:4px;padding:0px 5px 0px 5px ;', 'onclick'=>'$("#infokoneksi").slideToggle();'));
    echo '</div>';
    echo '</div>';
}
?>
    <style>
        #infokoneksi{
            margin-left:80px;
            display: none;
            width:400px;
            border:1px solid #cccccc;
            padding:5px;
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            border-radius: 2px;
            margin-bottom:10px;
        }
        #infokoneksi .control-label{
            width:50px;
        }
        #infokoneksi .controls{
            margin-left: 70px;
        }
        </style>
    <div id="infokoneksi">
        <div class="control-group"><label for="KPPresensiT_no_fingerprint" class="control-label required">Status</label>
            <div class="controls" id="status-connection">
                
            </div>
        </div>
        <div class="control-group"><label for="KPPresensiT_no_fingerprint" class="control-label required">IP</label>
            <div class="controls" id="ip-connection">
                
            </div>
        </div>
        <div class="control-group"><label for="KPPresensiT_no_fingerprint" class="control-label required">Lokasi</label>
            <div class="controls" id="lokasi-connection">
                
            </div>
        </div>
    </div>
</div>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'kppresensi-t-grid',
	'dataProvider'=>$model->search(),
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                'no_fingerprint',
                'pegawai.nomorindukpegawai',
                'pegawai.nama_pegawai',
                'statusscan.statusscan_nama',
                'tglpresensi',
                'statuskehadiran.statuskehadiran_nama',
                'verifikasi'
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>

<?php 
 
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
        $this->widget('UserTips',array('type'=>'admin'));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#kppresensi-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>

<?php Yii::app()->clientScript->registerScript('onheadfungsi','
        var interval;
    function updateTable(){
        $.fn.yiiGridView.update("kppresensi-t-grid", {
                data: $(".search-form form").serialize()
        });
    }
    
    function setAuto(){
        if ($("#atur").is(":checked")){
            atur = $("#atur").val();
        }else{
            atur = 0;
        }
        $.post("'.Yii::app()->createUrl('actionAjax/turnAutoRefresh').'",{atur:atur},function(data){
        });
    }
    
    function ambilData(ip,key){
        $.post("'.Yii::app()->createUrl('kepegawaian/presensiT/ambilData').'",{ip:ip,key:key},function(data){
            if (data == 1){
                updateTable();
            }
        });
    }
    
    function beat(){
        $.post("'.Yii::app()->createUrl('kepegawaian/presensiT/ambilData').'",{},function(data){
            if (data == 1){
                updateTable();
            }
        });
    }
    
function aktifkanFinger(obj,disconnect){
    var idAlat = $("#finger").val();
    var data = {idAlat:idAlat};

    if (disconnect){
        data = {idAlat:idAlat,disconnect:true};
    }
    
    if (jQuery.isNumeric(idAlat)){
        $(obj).parents(".controls").find("select, input#connect").attr("disabled","disabled");
        $.ajax({
            dataType:"json",
            data: data,
            success:function(data){

                if (disconnect){
                   if (data.success == true){
                        clearInterval(interval);
                        if ($("#infokoneksi").not(":hidden")){
                            $("#infokoneksi").slideUp();
                        }
                        $("#status-connection").html("");
                        $("#ip-connection").html("");
                        $("#lokasi-connection").html("");
                        $("select#finger, input#connect").removeAttr("disabled");
                    }
                }else{
                    if ($("#infokoneksi").is(":hidden")){
                        $("#infokoneksi").slideDown();
                    }
                    var statusKoneksi;
                    if(data.success == 1 && data.connection == true){
                        interval = setInterval(function(){ambilData(data.data.ipfinger, data.data.keyfinger);},3000);
                        statusKoneksi = "Connect ("+data.time+") <a onclick=\"aktifkanFinger(this, true);\" style=\"line-height:8px;\" class=\"btn btn-danger\">disconnect</a>";
                    }
                    else{
                        $(obj).parents(".controls").find("select, input#connect").removeAttr("disabled");
                        statusKoneksi = "<div class=\'error\'>Failed";
                    }
                    $("#status-connection").html(statusKoneksi);
                    $("#ip-connection").html("<div class=\'control-label\' style=\'width: 0;\'>"+data.data.ipfinger+"</div>");
                    $("#lokasi-connection").html("<div class=\'control-labe\' style=\'width: 0;\'>"+data.data.lokasifinger+"</div>");
                }
            }
        });
    }
    
    return false;
}
', CClientScript::POS_HEAD); ?>