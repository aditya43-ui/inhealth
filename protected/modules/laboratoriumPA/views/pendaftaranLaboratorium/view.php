<legend class="rim2">Lihat Pendaftaran</legend>
<?php 
if(isset($_GET['sukses'])){
    Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan !");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial($this->path_view.'_view', array('model'=>$model, 'modPasien'=>$modPasien, 'modPenanggungJawab'=>$modPenanggungJawab, 'modRujukan'=>$modRujukan, 'modTindakan'=>$modTindakan)); ?>

<div class="row-fluid">
    <div class="form-actions">
        <?php
            echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printStatus('$model->pendaftaran_id');return false",'disabled'=>FALSE  ));
            echo CHtml::link(Yii::t('mds', '{icon} Print Kartu Pasien', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printKartuPasien('$model->pasien_id');return false",'disabled'=>FALSE  ));
        ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Kembali',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')), 
            'javascript:void(0);',
            array('class'=>'btn btn-danger',
                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) history.back();}); return false;'));  ?>
        <?php $this->widget('UserTips',array('type'=>'view'));?>
    </div>
</div>

<?php echo $this->renderPartial($this->path_view.'_jsFunctions', array('model'=>$model, 'modPasien'=>$modPasien, 'modPenanggungJawab'=>$modPenanggungJawab, 'modRujukan'=>$modRujukan)); ?>
