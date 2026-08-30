<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Penjamin Pasien</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Penjamin Pasien' => array('admin'),
            $model->penjamin_id,
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Penjamin Pasien ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Penjamin', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Penjamin', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Penjamin', 'icon'=>'pencil','url'=>array('update','id'=>$model->penjamin_id))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Penjamin','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->penjamin_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Penjamin Pasien', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php
        $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                //'penjamin_id',
                //'carabayar.carabayar_nama',
                array(
                    'name' => 'Jenis Penjamin',
                    'value' => $model->carabayar->carabayar_nama,
                ),
                'penjamin_nama',
                'penjamin_namalainnya',
                'penjamin_cp',
                'penjamin_nomobile',
                array(
                    'name' => 'lama_tempo',
                    'value' => $model->lama_tempo . " Hari",
                ),
                array(
                    'name' => 'lampiranpks',
                    'value' => ($model->lampiranpks == null) ? Yii::t("mds", "Tidak ada") : Yii::t("mds", "Ada"),
                ),
                array(
                    'name' => 'diskon_tagihan',
                    'value' => $model->diskon_tagihan . " %",
                ),
                array(
                    'name' => 'diskon_klaim',
                    'value' => $model->diskon_klaim . " %",
                ),
                array(
                    'name' => 'diskon_rj',
                    'value' => $model->diskon_rj . " %",
                ),
                array(
                    'name' => 'diskon_ri',
                    'value' => $model->diskon_ri . " %",
                ),
                array(
                    'name' => 'diskon_rd',
                    'value' => $model->diskon_rd . " %",
                ), array(
                    'name' => 'biaya_administrasi',
                    'value' => $model->biaya_administrasi . " %",
                ),
                array( // related city displayed as a link
                    'name' => 'penjamin_aktif',
                    'type' => 'raw',
                    'value' => (($model->penjamin_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                ),
            ),
        ));
        ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Penjamin Pasien', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('/sistemAdministrator/PenjaminPasienM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>