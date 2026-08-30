<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Kelompok Menu</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        //$this->widget('bootstrap.widgets.BootMenu', array(
        //    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
        //    'stacked'=>false, // whether this is a stacked menu
        //    'items'=>array(
        //        array('label'=>'Kelompok Menu',  'url'=>$this->createUrl('/sistemAdministrator/kelompokMenuK')),
        //        array('label'=>'Menu', 'url'=>$this->createUrl('/sistemAdministrator/menuModulK')),
        //
        //    ),
        //)); 
        ?>
        <?php
        $this->breadcrumbs = array(
            'Kelompok Menu' => array('admin'),
            $model->kelmenu_id,
        );

        $this->menu = array(
            //        array('label'=>Yii::t('mds','View').' Kelompok Menu ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
            //	array('label'=>Yii::t('mds','List').' Kelompok Menu', 'icon'=>'list', 'url'=>array('index')),
            //	array('label'=>Yii::t('mds','Create').' Kelompok Menu', 'icon'=>'file', 'url'=>array('create')),
            //        array('label'=>Yii::t('mds','Update').' Kelompok Menu', 'icon'=>'pencil','url'=>array('update','id'=>$model->kelmenu_id)),
            //	array('label'=>Yii::t('mds','Delete').' Kelompok Menu','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->kelmenu_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?'))),
            //	array('label'=>Yii::t('mds','Manage').' Kelompok Menu', 'icon'=>'folder-open', 'url'=>array('admin')),
        );

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'kelmenu_id',
                'kelmenu_nama',
                'kelmenu_namalainnya',
                'kelmenu_key',
                'kelmenu_url',
                'kelmenu_urutan',
                // 'kelmenu_aktif',
                array(
                    'label' => 'Aktif',
                    'type' => 'raw',
                    'value' => (($model->kelmenu_aktif == 1) ? '' . Yii::t('mds', 'Yes') . '' : '' . Yii::t('mds', 'No') . ''),
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')), $this->createUrl('update', array('id' => $model->kelmenu_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelompok Menu', array('{icon}' => '<i class="entypo-folder"></i>')), $this->createUrl('/sistemAdministrator/kelompokMenuK/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success',)); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>