<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Transaksi <b>Penerimaan Linen Ruangan</b>
        </div>
        <!-- <?php
        if (!empty($model->pengirimanlinen_id) && !isset($_GET['penlinenruangan_id'])) : ?>
            <div class="panel-options">
                <?php echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-default', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;')) ?>
            </div>
        <?php elseif (!empty($model->pengirimanlinen_id)) : ?>
            <div class="panel-options">
                <?php echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-default', 'onclick' => 'backMenu(); return false;', 'style' => 'color: white;')) ?>
            </div>
        <?php endif; ?> -->
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php
        $this->breadcrumbs = array(
            'LApenerimaanlinen Ts' => array('index'),
            'Create',
        );
        ?>
        <?php  /*
			if(!empty($_GET['sukses'])){        
		?>
		<?php echo Yii::app()->user->setFlash('success',"Data Penerimaan Linen (Ruangan) berhasil disimpan!");  $this->widget('bootstrap.widgets.BootAlert');?>
		<?php }  */ ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'lapenerimaanlinenruangan-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
            'focus' => '#',
        )); ?>
        <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <?php echo $form->errorSummary($model); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Penerimaan</b>
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . '_formPenerimaan', array(
                    'model' => $model, 'form' => $form, 'format' => $format
                )); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Linen
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_tabelLinen', array('model' => $model, 'form' => $form, 'modPengirimanDetail' => $modPengirimanDetail, 'form' => $form)); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php
            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
            $disableSave = false;
            $disableSave = (!empty($_GET['sukses'])) ? true : (($sukses > 0) ? true : false);
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'disabled' => $disableSave)); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl('index'),
                array('class' => 'btn btn-default', 'onclick' => 'if(!confirm("' . Yii::t('mds', 'Apakah Anda akan mengulang input data ?') . '")) return false;')
            ); ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')", 'disabled' => $disablePrint)); ?>
            <?php $content = $this->renderPartial($this->path_view . 'tips/transaksi1', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model)); ?>