<div class="panel panel-gradient">
	<div class="panel-heading">
		<div class="panel-title">
			<?php
				if (isset($_GET['kelaspelayanan_id'])){
					echo 'Ubah Nominal Tarif';
				}else{
					echo 'Tambah Nominal Tarif';
				}
			?>
		</div>
	</div>
	<div class="panel-body">
    <?php
    $this->breadcrumbs=array(
            'SaNominal Tarif Ms'=>array('index'),
            'Create',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Tarif Tindakan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Tarif Tindakan', 'icon'=>'list', 'url'=>array('index'))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Tarif Tindakan', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model,'modDetails'=>$modDetails, 'lists'=>$lists, 'isCreate'=>$isCreate)); ?>
    <?php //$this->widget('UserTips',array('type'=>'create'));?>
	</div>
</div>