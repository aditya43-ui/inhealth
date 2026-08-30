<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'insiden-rs-t-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
    'focus'=>'#',
)); ?>
<?php
    if (isset($_GET['sukses'])) {
        Yii::app()->user->setFlash('success','<strong>Berhasil </strong> Data berhasil disimpan');
    }
    $this->widget('bootstrap.widgets.BootAlert');
?>
<style>
    .control-label-left {
      float: left;
      width: 150px;
      padding-top: 5px;
      text-align: left;
    }
    
    .control-label-margin {
        margin-left: 15px;  
        float: left; 
        width: 135px; 
        padding-top: 5px; 
        text-align: left;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><strong>Ubah Laporan Insiden </strong></div>
            <span style="float:right; padding: 10px">
                <?php echo CHtml::link(Yii::t('mds','{icon} Kembali',array('{icon}'=>'<i class="entypo-left-bold"></i>')), 
                        Yii::app()->createUrl('yankesMasyarakat/InformasiLaporanInsiden/index'),
                        array('class'=>'btn btn-success')); ?>
            </span>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><b>Data Pasien </b></div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <?php echo $this->renderPartial($this->path_update.'/_dataPasien', array('model'=>$model, 'form'=>$form)); ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><b>Data Kejadian </b></div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <?php echo $this->renderPartial($this->path_update.'/_dataKejadian', array('model'=>$model, 'form'=>$form)); ?>
                </div>
            </div>
        </div>
        <div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'onclick'=>'cekForm();')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('index'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php
                    $tips = array(
                        '0' => 'tanggal',
                        '1' => 'cari',
                        '2' => 'ulang'
                    );
                    $content = $this->renderPartial('penelitianKesehatan.views.tips.transaksi',array('tips'=>$tips),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                ?>
		</div>
	</div>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php 
    $this->renderPartial($this->path_update.'/_jsFunctions', array('model' => $model));
    $this->renderPartial($this->path_update.'/_dialog', array('model' => $model));
?>