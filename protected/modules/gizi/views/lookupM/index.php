<?php
$this->breadcrumbs = array(
    'Lookup Ms',
);
if ($model->lookup_type == 'jenisbahanmakanan') :
    echo "<legend class='rim'>Lihat <b>Jenis Bahan Makanan</b></legend>";
    $pengaturan = CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jenis Bahan Makanan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('/gizi/JenisBahanMakanan/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    );
    $list = ' Jenis Bahan Makanan ';
else :
    echo "<legend class='rim'>Lihat <b>Kelompok Bahan Makanan</b></legend>";
    $pengaturan = CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Kelompok Bahan Makanan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('/gizi/KelompokBahanMakanan/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    );
    $list = ' Kelompok Bahan Makanan ';
endif;

$this->menu = array(
    array('label' => Yii::t('mds', 'List') . $list, 'header' => true, 'itemOptions' => array('class' => 'heading-master')),
    //	array('label'=>Yii::t('mds','Create').' Lookup', 'icon'=>'file', 'url'=>array('create')),
    //	array('label'=>Yii::t('mds','Manage').' Satuan Barang', 'icon'=>'folder-open', 'url'=>array('admin')),
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
)); ?>

<?php $this->widget('UserTips', array('type' => 'list')); ?>
<?php echo $pengaturan; ?>