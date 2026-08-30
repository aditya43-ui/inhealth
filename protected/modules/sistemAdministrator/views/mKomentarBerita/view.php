<?php
$this->breadcrumbs = array(
    'Samberitakomentar Ts' => array('index'),
    $model->mberitakomentar_id,
);
?>
<fieldset class='box'>
    <legend class="rim">Lihat Komentar Berita</legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row">
        <div class="col-sm-6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'mberitakomentar_id',
                    'mberita.judulberita',
                    'tglkomentar',
                    'namakomentar',
                    //'emailkomentar',
                    //'isikomentar',
                    //'tampilkankomentar',
                ),
            )); ?>
        </div>
        <div class="col-sm-6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    //'mberitakomentar_id',
                    //'mberita_id',
                    //'tglkomentar',
                    //'namakomentar',
                    'emailkomentar',
                    'isikomentar',
                    'tampilkankomentar',
                ),
            )); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
            $this->createUrl($this->id . '/update&id=' . $model->mberitakomentar_id, array('modul_id' => Yii::app()->session['modul_id'])),
            array('title' => 'Ubah', 'class' => 'btn btn-danger',)
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Berita Komentar', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php
        $content = $this->renderPartial('tips/view', array(), true);
        $this->widget('UserTips', array('type' => 'view', 'content' => $content));
        ?>
    </div>
</fieldset>