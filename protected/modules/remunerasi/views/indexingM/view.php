<legend class="rim">Lihat Indexing</legend>
<!--<div class="white-container">
    <legend class="rim2"><b>Indexing</b></legend>-->
<?php

$kel = KelremM::model()->findByPk($model->kelrem_id);

$this->breadcrumbs = array(
    'Indexing Ms' => array('index'),
    $model->indexing_id,
);

$arrMenu = array();
//                    array_push($arrMenu,array('label'=>Yii::t('mds','View').' Indexing ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kelompok Remunerasi', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess('Create')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kelompok Remunerasi', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess('Update')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Kelompok Remunerasi', 'icon'=>'pencil','url'=>array('update','id'=>$model->gelarbelakang_id))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Kelompok Remunerasi','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->gelarbelakang_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
(Yii::app()->user->checkAccess('Admin')) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Indexing', 'icon' => 'folder-open', 'url' => array('admin'))) :  '';

$this->menu = $arrMenu; ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
    'data' => $model,
    'attributes' => array(
        //'indexing_id',
        array(
            'label' => 'Kelompok Remunerasi',
            'value' => $kel->kelrem_nama,
        ),
        'indexing_urutan',
        'indexing_nama',
        'indexing_singk',
        'indexing_nilai',
        'indexing_offset',
        'indexing_step',
        array(               // related city displayed as a link
            'name' => 'indexing_aktif',
            'type' => 'raw',
            'value' => (($model->indexing_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
        ),
    ),
)); ?>
<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>Nama</th>
            <th width="100">Nilai Bobot</th>
            <th width="100">Nilai Index</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count((array)$det) == 0) : ?>
            <tr>
                <td colspan="3">Data tidak ditemukan</td>
            </tr>
        <?php endif; ?>
        <?php foreach ($det as $item) : ?>
            <tr>
                <td><?php echo $item->indexingdef_nama; ?></td>
                <td style="text-align: right;"><?php echo $item->bobot; ?></td>
                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($model->indexing_offset + ($item->bobot * $model->indexing_nilai), 2); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="form-actions">
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Indexing', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>

    <?php $this->widget('UserTips', array('type' => 'view')); ?>
</div>