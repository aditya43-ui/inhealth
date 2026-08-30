<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Kabupaten</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Sakabupaten Ms' => array('index'),
            $model->kabupaten_id,
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Kabupaten ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kabupaten', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kabupaten', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Kabupaten', 'icon'=>'pencil','url'=>array('update','id'=>$model->kabupaten_id))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Kabupaten','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->kabupaten_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
        //(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kabupaten', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php
        $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'kabupaten_id',
                'propinsi.propinsi_nama',
                'kabupaten_nama',
                'kabupaten_namalainnya',
                array(
                    'label' => 'Aktif',
                    'type' => 'raw',
                    'value' => (($model->kabupaten_aktif == 1) ? '' . Yii::t('mds', 'Yes') . '' : '' . Yii::t('mds', 'No') . ''),
                ),
            ),
        ));
        ?>

        <div class="form-actions">
            <?php // echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="entypo-pencil"></i>')),$this->createUrl('update',array('id'=>$model->kabupaten_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
            ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Kabupaten', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('KabupatenM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            );
            ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>