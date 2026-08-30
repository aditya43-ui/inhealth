<?php
if ($model->lookup_type == 'jenisbahanmakanan') :
?>

    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="far fa-plus-square"></i> Tambah <b>Jenis Bahan Makanan</b>
            </div>
        </div>
        <div class="panel-body">
        <?php
        $pengaturan = CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Jenis Bahan Makanan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('/gizi/JenisBahanMakanan/admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        );
        $ulang = CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            Yii::app()->createUrl($this->module->id . '/JenisBahanMakanan/create'),
            array(
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        );
    else :
        ?>
            <div class="panel panel-gradient">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="far fa-plus-square"></i> Tambah <b>Kelompok Bahan Makanan</b>
                    </div>
                </div>
                <div class="panel-body">
                <?php
                // echo "<legend class='rim'>Tambah <b>Kelompok Bahan Makanan</b></legend>";
                $pengaturan = CHtml::link(
                    Yii::t('mds', '{icon} Pengaturan Kelompok Bahan Makanan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                    $this->createUrl('/gizi/KelompokBahanMakanan/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                    array('class' => 'btn btn-success',)
                );
                $ulang = CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    Yii::app()->createUrl($this->module->id . '/kelompokBahanMakanan/create'),
                    array(
                        'class' => 'btn btn-default',
                        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                    )
                );
            endif;
                ?>
                <?php
                $this->breadcrumbs = array(
                    'Lookup Ms' => array('index'),
                    'Create',
                );

                $this->menu = array(
                    //        array('label'=>Yii::t('mds','Create').' Satuan Barang ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
                    //	array('label'=>Yii::t('mds','List').' Lookup', 'icon'=>'list', 'url'=>array('index')),
                    //	array('label'=>Yii::t('mds','Manage').' Satuan Barang', 'icon'=>'folder-open', 'url'=>array('admin')),
                );

                $this->widget('bootstrap.widgets.BootAlert');
                ?>

                <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model, 'pengaturan' => $pengaturan, 'ulang' => $ulang)); ?>
                </div>
            </div>