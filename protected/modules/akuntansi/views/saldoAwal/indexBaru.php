<?php 
$this->breadcrumbs=array(
	'Saldo Awal',
);
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<script type="text/javascript">
    var id_form = new Array();
</script>

<div class="panel panel-gradient">
	<div class="panel-heading">
		<div class="panel-title">Tambah <b>Saldo Awal</b></div>
	</div>
	<div class="panel-body">
		<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Cari Saldo Awal</div>
			</div>
			<div class="panel-body">
				<div class="row-fluid">
					 <?php 
                            Yii::app()->clientScript->registerScript('search', "
                            $('.search-form form').submit(function(){
                                $('#obatalkes-m-grid').addClass('animation-loading');
                                $.fn.yiiGridView.update('obatalkes-m-grid', {
                                    data: $(this).serialize()
                                });
                                return false;
                            });
                            ");
                        ?>
					<?php echo $this->renderPartial('_cariAkun',array('modAkun'=>$AKSaldorekeningV),true); ?>
				</div>
			</div>
		</div>
		 <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                            'id'=>'saldoawal-t-form',
                            'enableAjaxValidation'=>false,
                            'type'=>'horizontal',
                            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
                        )); 
				 ?>
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Detail Saldo Awal</div>
			</div>
			<div class="panel-body">
				
				<?php echo $this->renderPartial('_listAkun',array('modAkun'=>$AKSaldorekeningV),true); ?>
			</div>
		</div>
		<?php //echo $this->renderPartial('__gridSaldoRekening', array('model'=>$AKSaldorekeningV)); ?>
		  <?php
					if (!isset($_GET['sukses'])){
						echo CHtml::htmlButton(Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="'.MyIcon::getIcons('simpan').'"></i>')), 
                        array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
					}else{
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="'.MyIcon::getIcons('simpan').'"></i>')), 
                        array('class' => 'btn btn-primary', 'type' => 'button', 'id' => 'btn_simpan','disabled'=>true));
					}
					?>
                    <?php
                        echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="'.MyIcon::getIcons('ulang').'"></i>')), 
                        $this->createUrl($this->id.'/index'), 
                        array('class'=>'btn btn-danger',
                        'onclick'=>'return refreshForm(this);'));
						echo "&nbsp;";
						echo "&nbsp;";
						 echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="'.MyIcon::getIcons('pdf').'"></i>')),
							array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 

						echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="'.MyIcon::getIcons('excel').'"></i>')),
							array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 

						echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),
							array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 						
						
						$content = $this->renderPartial('../tips/master',array(),true);
						$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
						$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
						$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
						$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
        
		
						
						
$js = <<< JSCRIPT
function print(caraPrint)
{
	if ($('#AKRekeningakuntansiV_periodeposting_id').val()==''){
		myAlert('Periode Akuntansi Belum Dipilih','Perhatian !');
	return false;
	}else{
		window.open("${urlPrint}/"+$('#pencarianobat-form').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
	}
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
?>
<!--__formInputSaldoRekening-->


                    
					
		<?php $this->endWidget(); ?>
	</div>
</div>

<script type="text/javascript">
    function setNol(obj){
		if($(obj).is(":checked")){
			obj.value = 1;
		}else{
			obj.value = 0;
		}
	}
	
	function pilihSemua(obj){
		if($(obj).is(":checked")){
			$(".cekList").val(1);
			$(".cekList").attr("checked",true);
		}else{
			$(".cekList").val(0);
			$(".cekList").attr("checked",false);
		}
	}
 
    
</script>
