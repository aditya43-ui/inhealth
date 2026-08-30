<?php
$url = Yii::app()->createUrl('akuntansi/laporanLabaRugi/frameGrafikLaporanRugiLaba&id=1');
Yii::app()->clientScript->registerScript('search', "
//$('#searchLaporan').submit(function(){
  //  $('#Grafik').attr('src','').css('height','0px');
	//$('#tableLaporan').addClass('srbacLoading');
	//$.fn.yiiGridView.update('tableLaporan', {
	//	data: $(this).serialize()
	//});
    //return false;
//});
");
?>
<div class="panel panel-primary panel-gradient">
		<div class="panel-heading">
			<div class="panel-title">Laporan Laba Rugi</div>
		</div>
		<div class="panel-body">
			<div class="box search-form">
				<?php $this->renderPartial($this->path_view.'_search',array('model'=>$model)); 
				?>
			</div>
		
			
     <div class="panel panel-primary panel-success">
		<div class="panel-heading">
			<div class="panel-title">Tabel <b>Laba Rugi</b></div>
		</div>
		<div class="panel-body">
			<?php 
            $this->renderPartial($this->path_view.'_table', array('model'=>$model,'models'=>$models, 'caraPrint'=>$caraPrint)); ?>
		</div>
    </div>
    <?php 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanLabaRugi');
    ?>
<div class="form-actions">
	<?php 
	echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Cetak',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 

	$tips = array(
            '0' => 'tanggal',            
            '1' => 'cari',
            '2' => 'ulang2',
            '3' => 'bootaccordion',
            '4' => 'masterPDF',
            '5' => 'masterEXCEL',
            '6' => 'masterPRINT',
        );
	$content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
	$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>
</div>
<?php 
$jsx = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#searchLaporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$jsx,CClientScript::POS_HEAD);                        
?> 
<?php 
Yii::app()->clientScript->registerScript('test','
function resizeIframe(obj){
       obj.style.height = obj.contentWindow.document.body.scrollHeight + "px";
    }    
function setType(obj){
    $("#type").val($(obj).attr("type"));
    $(obj).parents("ul").find("li").each(function(){
        $(this).removeClass("active");
    });
    $(obj).addClass("active");
    $.fn.yiiGridView.update("tableLaporan", {
            data: $(this).serialize()
    });
    $("#Grafik").attr("src","'.$url.'"+$(".search-form form").serialize());
    return false;
}
function pilihSegmen(){

    if($("#Segmen_3").is(":checked") == true || $("#Segmen_4").is(":checked") == true)
        $(".totalRek2").fadeOut("slow");
    else
        $(".totalRek2").fadeIn("slow");

    if($("#Segmen_3").is(":checked") == true || $("#Segmen_4").is(":checked") == true)
        $(".totalRek3").fadeOut("slow");
    else
        $(".totalRek3").fadeIn("slow");

    if ($("#pilihSemuaSg").is(":checked")) {
        $(".segmen1").each(function(){
            $(this).fadeIn("slow");
        })
        $(".segmen2").each(function(){
            $(this).fadeIn("slow");
        })
         $(".segmen3").each(function(){
            $(this).fadeIn("slow");
        })
         $(".segmen4").each(function(){
            $(this).fadeIn("slow");
        })
         $(".segmen5").each(function(){
            $(this).fadeIn("slow");
        })
    }else{
        $(".segmen1").each(function(){
            $(this).fadeOut("slow");
        })
        $(".segmen2").each(function(){
            $(this).fadeOut("slow");
        })
         $(".segmen3").each(function(){
            $(this).fadeOut("slow");
        })
         $(".segmen4").each(function(){
            $(this).fadeOut("slow");
        })
         $(".segmen5").each(function(){
            $(this).fadeOut("slow");
        })
    }
}

function Segmen(obj){
    var seg = $(obj).val();
    
    if($("#Segmen_2").is(":checked") == true || ($("#Segmen_3").is(":checked") == true || $("#Segmen_4").is(":checked") == true))
        $(".totalRek2").fadeOut("slow");
    else
        $(".totalRek2").fadeIn("slow");

    if($("#Segmen_3").is(":checked") == true || $("#Segmen_4").is(":checked") == true)
        $(".totalRek3").fadeOut("slow");
    else
        $(".totalRek3").fadeIn("slow");

    var seg = $(obj).val();
    if(seg == 1){     
        $(".segmen1").each(function(){
            if($("#Segmen_0").is(":checked") == true)
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });  
        $(".segmen2").each(function(){
            if($("#Segmen_1").is(":checked") == true)
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });  
        $(".segmen3").each(function(){
            if($("#Segmen_2").is(":checked") == true)
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });
        $(".segmen4").each(function(){
            if($("#Segmen_3").is(":checked") == true)
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });
        $(".segmen5").each(function(){
            if($("#Segmen_4").is(":checked") == true)
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });
    }
    if(seg == 2){
        $(".segmen2").each(function(){
            if($("#Segmen_1").is(":checked") == true)
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });  
        $(".segmen3").each(function(){
            if($("#Segmen_2").is(":checked") == true)
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });
        $(".segmen4").each(function(){
            if($("#Segmen_3").is(":checked") == true)
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });
        $(".segmen5").each(function(){
            if($("#Segmen_4").is(":checked") == true)
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });
    }
    if(seg == 3){
        $(".segmen3").each(function(){
            if($("#Segmen_2").is(":checked") == true)
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });
        $(".segmen4").each(function(){
            if($("#Segmen_3").is(":checked") == true)
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });
        $(".segmen5").each(function(){
            if($("#Segmen_4").is(":checked") == true)
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });
    }
    if(seg == 4){
        $(".segmen4").each(function(){
            if($("#Segmen_3").is(":checked") == true)
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });
        $(".segmen5").each(function(){
            if($("#Segmen_4").is(":checked") == true)
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });
    }
    if(seg == 5){
        $(".segmen5").each(function(){
            if($("#Segmen_4").is(":checked") == true)
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });
    }
}
', CClientScript::POS_HEAD);

?>
</div>