<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Jurnal Rekening Supplier</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Jurnal Rekening Supplier' => array('index'),
            // $model->supplier_id,
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jurnal Rekening Supplier ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Jurnal Rekening Supplier', 'icon' => 'folder-open', 'url' => array('admin'))) :  '';

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(

                array(
                    'label' => 'Nama Supplier',
                    'type' => 'raw',
                    'value' => $model->supplier_nama,
                ),
                array(
                    'label' => 'Rekening Debit',
                    'type' => 'raw',
                    'value' => $this->renderPartial('_viewDebit', array('supplier_id' => $model->supplier_id, 'saldonormal' => "D"), true),
                ),
                array(
                    'label' => 'Rekening Kredit',
                    'type' => 'raw',
                    'value' => $this->renderPartial('_viewDebit', array('supplier_id' => $model->supplier_id, 'saldonormal' => "K"), true),
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Supplier Rekening', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>