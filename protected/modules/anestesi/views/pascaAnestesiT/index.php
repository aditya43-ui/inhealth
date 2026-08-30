<div class="panel panel-gradient">
    <div class="panel-heading">    
        <div class="panel-title">PASCA ANESTESIA</div>
        <?php if(!empty($_GET['pendaftaran_id'])){ ?>
        <span style="float:right; padding: 10px">
            <?php echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class'=>'btn btn-danger','onclick'=>'window.history.back(); return false;', 'style'=>'color: white;'));?>
        </span>
        <?php } ?>
    </div>
    <div class="panel-body">

    <?php 
		$this->breadcrumbs=array(
			'Anestesi'=>array('index'),
			'Manage',
		);
    ?>
	<?php
		$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
			'id' => 'praanestesi-form',
			'enableAjaxValidation' => false,
			'type' => 'horizontal',
			'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
			'focus' => '#'.CHtml::activeId($modKunjungan,'noanestesi'),
		));
    ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title judul">Data Pasien </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>', array('class' => 'btn btn-danger btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span></div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view.'_dataPasien',array('modKunjungan'=>$modKunjungan)); ?>
            </div>
        </div>
  
	<?php 
		$this->renderPartial($this->path_view.'_tabMenu',array());
		$this->renderPartial($this->path_view.'_jsFunctions',array('modKunjungan'=>$modKunjungan)); 
	?>
    <div>
		<iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; overflow-x: scroll;" ></iframe>
    </div>
        <div>
        <?php /*
            if(isset($_GET['pendaftaran_id'])){
                echo CHtml::link(Yii::t('mds','{icon} Kembali',array('{icon}'=>'<i class="entypo-left-bold"></i>')), 
                        Yii::app()->createUrl('anestesi/DaftarPasienAT/Index'),
                        array('class'=>'btn btn-danger')); 
            }*/
        ?>
        </div>
</div>
<?php $this->endWidget(); ?>