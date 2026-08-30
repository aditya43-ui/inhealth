<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Menu</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Menu' => array('admin'),
            // $model->menu_id,
        );

        $this->menu = array(
            //        array('label'=>Yii::t('mds','View').' Menu ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
            //	array('label'=>Yii::t('mds','List').' Menu', 'icon'=>'list', 'url'=>array('index')),
            //	array('label'=>Yii::t('mds','Create').' Menu', 'icon'=>'file', 'url'=>array('create')),
            //        array('label'=>Yii::t('mds','Update').' Menu', 'icon'=>'pencil','url'=>array('update','id'=>$model->menu_id)),
            //	array('label'=>Yii::t('mds','Delete').' Menu','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->menu_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?'))),
            //	array('label'=>Yii::t('mds','Manage').' Menu', 'icon'=>'folder-open', 'url'=>array('admin')),
        );

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'menu_id',
                'kelompokmenu.kelmenu_nama',
                'modulk.modul_nama',
                'menu_nama',
                'menu_namalainnya',
                'menu_key',
                'menu_url',
                'menu_fungsi',
                'menu_urutan',
                'menu_aktif',
                array(
                    'label' => 'Aktif',
                    'type' => 'raw',
                    'value' => (($model->menu_aktif == true) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')), $this->createUrl('update', array('id' => $model->menu_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Menu', array('{icon}' => '<i class="entypo-folder"></i>')),
                $this->createUrl('Admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>