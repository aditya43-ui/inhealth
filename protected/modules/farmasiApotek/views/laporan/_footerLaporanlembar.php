<!--echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PRINT\')'));-->

<div class="form-actions">
<table style="width: 100%; border: none;">
  <tr>
   <?php 
//    $this->widget('bootstrap.widgets.BootButtonGroup', array(
//         'type'=>'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
//         'buttons'=>array(
//             array('label'=>'Print', 'icon'=>'entypo-print', 'url'=>'#', 'htmlOptions'=>array('onclick'=>'print(\'PRINT\')')),
//             array('label'=>'', 'items'=>array(
//                 array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'PDF\')')),
//                 array('label'=>'Excel','icon'=>'icon-pdf', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'EXCEL\')')),
//                 array('label'=>'Grafik','icon'=>'entypo-print', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'GRAFIK\')')),
//             )),       
//         ),
// //        'htmlOptions'=>array('class'=>'btn')
//     )); 
    ?>	
    <td>

        <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Grafik',array('{icon}'=>'<i class="entypo-chart-area"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'GRAFIK\')')); 

$content = $this->renderPartial('tips/tips',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
?></td>

  </tr>
</table>
</div>
<?php 

$jsx = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#laporan-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$jsx,CClientScript::POS_HEAD);                        
?> 
<?php 
Yii::app()->clientScript->registerScript('test','
function resizeIframe(obj){
       obj.style.height = obj.contentWindow.document.body.scrollHeight + "px";
    }    
function setType(obj, index){
    $("#type").val($(obj).attr("type"));
    $(obj).parents("ul").find("li").each(function(){
        $(this).removeClass("active");
    });
    $(obj).addClass("active");
//    $.fn.yiiGridView.update("laporan-grid", {
//            data: $(this).serialize()
//    });
    if (index==1) {
        index="batang";
    } else if (index==2) {
        index="pie";
    } else if (index==3) {
        index="garis";
    }
    $("#Grafik").attr("src","'.$url.'"+$("#laporan-search").serialize()+"&type="+index);
    return false;
}
', CClientScript::POS_HEAD);

?>

<script>
$(document).ready(function() {
		var ins  = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_nama') ?>');		
		var ru  = jQuery('#<?php echo CHtml::activeId($model, 'ruanganasal_nama') ?>');		
	
		jQuery(ins).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '182px',
			enableCaseInsensitiveFiltering: true,
			onChange: function(element, checked) {				
					var ins  = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_nama') ?>');
					var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_nama') ?>   option:selected');
					var ru  = jQuery('#<?php echo CHtml::activeId($model, 'ruanganasal_nama') ?>');
				
					var brands = ins_all;
					var selected = [];
					
				
					$(brands).each(function(index, brand){
						selected.push($(this).val());
					});

					ru.addClass('animation-loading');
					//alert(selected);

					jQuery.ajax({
						type:'POST',
						url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganAsalByMultiSelect') ?>',					
						dataType: "json",
						data: {instalasiasal_nama:selected},
						success: function(data){	
							
							if (data.sukses != '1'){
								
								//toastr.error(data.pesan);
								ru.addClass('animation-loading');
							}else{							
								//alert(data.ruangan);
								ru.html(data.ruangan_nama);								
								ru.multiselect('rebuild');																
								ru.removeClass('animation-loading');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { 					
							console.log(errorThrown);
							
						}
					});

			},
			onSelectAll: function() {
					var ins  = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_nama') ?>');
					var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_nama') ?>   option:selected');
					var ru  = jQuery('#<?php echo CHtml::activeId($model, 'ruanganasal_nama') ?>');
					
					var brands = ins_all;
					var selected = [];
				
					$(brands).each(function(index, brand){
						selected.push($(this).val());
					});

					ru.addClass('animation-loading');

					jQuery.ajax({
						type:'POST',
						url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganAsalByMultiSelect') ?>',					
						dataType: "json",
						data: {instalasiasal_nama:selected},
						success: function(data){	
							
							if (data.sukses != '1'){
								
								//toastr.error(data.pesan);
								ru.addClass('animation-loading');
							}else{							
								//alert(data.ruangan);
								ru.html(data.ruangan_nama);								
								ru.multiselect('rebuild');																
								ru.removeClass('animation-loading');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { 					
							console.log(errorThrown);
							
						}
					});
					
			},
			onDeselectAll: function() {		
				var ins  = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_nama') ?>');
				var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_nama') ?>   option:selected');
				var ru  = jQuery('#<?php echo CHtml::activeId($model, 'ruanganasal_nama') ?>');
					
				var brands = ins_all;
				var selected = '';

				

				ru.addClass('animation-loading');

				jQuery.ajax({
					type:'POST',
					url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganAsalByMultiSelect') ?>',					
					dataType: "json",
					data: {instalasiasal_nama:selected},
					success: function(data){	

						if (data.sukses != '1'){

							//toastr.error(data.pesan);
							ru.addClass('animation-loading');
						}else{							
							//alert(data.ruangan);
							ru.html(data.ruangan_nama);								
							ru.multiselect('rebuild');															
							ru.removeClass('animation-loading');
						}
					},
					error: function (jqXHR, textStatus, errorThrown) { 					
						console.log(errorThrown);

					}
				});

			}
		}).hide();
		
		jQuery(ru).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '182px',
			enableCaseInsensitiveFiltering: true
		}).hide();
			
});
</script>

