<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Bahan Makanan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'gzbahanmakanan Ms' => array('index'),
            $model->bahanmakanan_id,
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Bahan Makanan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Bahan Makanan', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Bahan Makanan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Bahan Makanan', 'icon'=>'pencil','url'=>array('update','id'=>$model->bahanmakanan_id))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Bahan Makanan','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->bahanmakanan_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Bahan Makanan', 'icon' => 'folder-open', 'url' => array('admin'))) : '';

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php
        $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'bahanmakanan_id',
                'golbahanmakanan_id',
                'sumberdanabhn',
                'jenisbahanmakanan',
                'kelbahanmakanan',
                'namabahanmakanan',
                'jmlpersediaan',
                'satuanbahan',
                array(
                    'label' => 'Harga Netto',
                    'value' => number_format($model->harganettobahan, 0, "", ".")
                ),
                array(
                    'label' => 'Harga Netto',
                    'value' => number_format($model->hargajualbahan, 0, "", ".")
                ),
                'discount',
                array(
                    'label' => 'Tanggal Kedaluwarsa',
                    'value' => MyFormatter::formatDateTimeForUser($model->tglkadaluarsabahan)
                ),
                'jmlminimal',
                array(
                    'label' => 'Status',
                    'value' => ($model->bahanmakanan_aktif == TRUE) ? "Aktif" : "Tidak Aktif"
                ),
            ),
        ));
        ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Bahan Makanan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('bahanMakananM/admin', array('modul_id' => Yii::app()->session['modul_id'], 'tab' => 'frame')),
                array('class' => 'btn btn-success',)
            );
            ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>

    </div>
</div>