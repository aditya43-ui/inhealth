<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Status Kepemilikan Rumah</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Statuskepemilikanrumah Ms' => array('index'),
            $model->statuskepemilikanrumah_id,
        );

        $this->menu = array(
            //        array('label'=>Yii::t('mds','View').' Status Kepemilikan Rumah', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
            //	array('label'=>'List StatuskepemilikanrumahM', 'url'=>array('index')),
            //	array('label'=>'Create StatuskepemilikanrumahM', 'url'=>array('create')),
            //	array('label'=>'Update StatuskepemilikanrumahM', 'url'=>array('update', 'id'=>$model->statuskepemilikanrumah_id)),
            //	array('label'=>'Delete StatuskepemilikanrumahM', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->statuskepemilikanrumah_id),'confirm'=>'Are you sure you want to delete this item?')),
            //	array('label'=>'Manage Status Kepemilikan Rumah', 'url'=>array('admin')),
        );
        ?>
        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'statuskepemilikanrumah_id',
                'statuskepemilikanrumah_nama',
                'statuskepemilikanrumah_namalain',
                'statuskepemilikanrumah_aktif',
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Status Kepemilikan Rumah', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('statuskepemilikanrumahM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>