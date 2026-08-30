<?php
$this->breadcrumbs = array(
    'Samkategoriberita Ms' => array('index'),
    $model->mkategoriberita_id,
);
?>
<fieldset class="box">
    <legend class="rim">Lihat Kategori Berita</legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row">
        <div class="col-sm-6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'mkategoriberita_id',
                    'kategoriberita',
                    'ketkategoriberita',
                    //'urutankategori',
                    //'kategoriberita_aktif',
                ),
            )); ?>
        </div>
        <div class="col-sm-6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    //'mkategoriberita_id',
                    //'kategoriberita',
                    //'ketkategoriberita',
                    'urutankategori',
                    'kategoriberita_aktif',
                ),
            )); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
            $this->createUrl($this->id . '/update&id=' . $model->mkategoriberita_id, array('modul_id' => Yii::app()->session['modul_id'])),
            array('title' => 'Ubah', 'class' => 'btn btn-danger',)
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Kategori Berita', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php
        $content = $this->renderPartial('tips/view', array(), true);
        $this->widget('UserTips', array('type' => 'view', 'content' => $content));
        ?>
    </div>
</fieldset>