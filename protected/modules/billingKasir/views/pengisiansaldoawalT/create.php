<!-- <?php
        // $this->breadcrumbs=array(
        // 	' Ts'=>array('index'),
        // 	'Create',
        // );

        // $this->menu=array(
        // 	array('label'=>'List PengisiansaldoawalT', 'url'=>array('index')),
        // 	array('label'=>'Manage PengisiansaldoawalT', 'url'=>array('admin')),
        // );
        ?>

<h1>Tambah</h1>

<?php //echo $this->renderPartial('_form', array('model'=>$model)); 
?>
 -->
<div class="panel panel-success panel-shadow">
    <div class="panel-heading">
        <div class="panel-title"><b>Pengisian Saldo Awal</b></div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><b>Data Pengisian Saldo Awal</b></div>
            </div>
            <div class="panel-body">
                <?php
                $this->breadcrumbs = array(
                    ' ' => array('index'),
                    'Create',
                );

                $arrMenu = array();
                //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Cara Pembayaran ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Cara Pembayaran', 'icon'=>'list', 'url'=>array('index'))) ;
                //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Cara Pembayaran', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

                $this->menu = $arrMenu;

                $this->widget('bootstrap.widgets.BootAlert'); ?>

                <?php echo $this->renderPartial('_form', array('model' => $model, 'ruanganAsal' => $ruanganAsal)); ?>
                <?php //$this->widget('UserTips',array('type'=>'create'));
                ?>
            </div>
        </div>
    </div>
</div>