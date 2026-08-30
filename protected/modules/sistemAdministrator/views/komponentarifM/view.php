<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Komponen Tarif</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Sakomponen Tarif Ms' => array('index'),
            $model->komponentarif_id,
        );

        //$arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Komponen Tarif ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        ////                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Komponen Tarif', 'icon'=>'list', 'url'=>array('index'))) ;
        ////                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Komponen Tarif', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        ////                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Komponen Tarif', 'icon'=>'pencil','url'=>array('update','id'=>$model->komponentarif_id))) :  '' ;
        ////                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Komponen Tarif','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->komponentarif_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
        ////                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Komponen Tarif', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;
        //
        //$this->menu=$arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'komponentarif_id',
                'komponentarif_nama',
                'komponentarif_namalainnya',
                'komponentarif_urutan',
                array(
                    'label' => 'Instalasi',
                    'type' => 'raw',
                    'value' => $this->renderPartial($this->path_view . '_komponenTarifInstalasi', array('komponentarif_id' => $model->komponentarif_id), true),
                ),
                //'komponentarif_aktif',
                array(
                    'label' => 'Aktif',
                    'type' => 'raw',
                    'value' => (($model->komponentarif_aktif == 1) ? '' . Yii::t('mds', 'Yes') . '' : '' . Yii::t('mds', 'No') . ''),
                ),
            ),
        )); ?>

        <table class="table table-bordered table-condensed" id="detail-kelompok">
            <thead>
                <tr>
                    <th>Kelompok Komponen Tarif</th>
                    <th>Persentase (%)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $det = PersenkelkomponentarifM::model()->findAllByAttributes(array(
                    'komponentarif_id' => $model->komponentarif_id
                ));
                foreach ($det as $item) { ?>
                    <tr>
                        <td><?php
                            $kel = KelompokkomponentarifM::model()->findByPk($item->kelompokkomponentarif_id);
                            echo $kel->kelompokkomponentarif_nama;
                            ?></td>
                        <td style="text-align: right;"><?php echo $item->persentase; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Komponen Tarif', array('{icon}' => '<i class="icon-file icon-white"></i>')),
                $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            );
            $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>