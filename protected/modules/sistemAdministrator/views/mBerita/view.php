<?php
$this->breadcrumbs = array(
    'Samberita Ms' => array('index'),
    $model->mberita_id,
);
?>
<fieldset class="box">
    <legend class="rim">Lihat Berita</legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row">
        <div class="col-sm-6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'mberita_id',
                    'mkategoriberita.kategoriberita',
                    'judulberita',
                    'ringkasanberita',
                    'isiberita',
                    // 'gambarberita_path',
                    array(
                        'name' => 'gambarberita_path',
                        'type' => 'raw',
                        'value' => '<img src="' . Params::urlBerita() . $model->gambarberita_path . '" width="200px" height="200px;">',
                    ),
                    'gambarberita_text',
                    //'keteranganberita',
                    //'beritaterkait',
                    //'waktutampilberita',
                    //'waktuselesaitampil',
                    //'tglbuatberita',
                    //'create_user',
                ),
            )); ?>
        </div>
        <div class="col-sm-6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    //'mberita_id',
                    //'mkategoriberita_id',
                    //'judulberita',
                    //'ringkasanberita',
                    //'isiberita',
                    //'gambarberita_path',
                    //'gambarberita_text',
                    'keteranganberita',
                    'beritaterkait',
                    'waktutampilberita',
                    'waktuselesaitampil',
                    'tglbuatberita',
                    'create_user',
                ),
            )); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
            $this->createUrl($this->id . '/update&id=' . $model->mberita_id, array('modul_id' => Yii::app()->session['modul_id'])),
            array('title' => 'Ubah', 'class' => 'btn btn-danger',)
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Berita', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php
        $content = $this->renderPartial('tips/view', array(), true);
        $this->widget('UserTips', array('type' => 'view', 'content' => $content));
        ?>
    </div>
</fieldset>