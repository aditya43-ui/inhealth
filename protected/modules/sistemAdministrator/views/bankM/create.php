<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Bank Penerimaan / Pengeluaran RS</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Bank' => Yii::app()->request->getUrlReferrer(),

            'Tambah',
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Bank ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Bank', 'icon' => 'folder-open', 'url' => array('Admin'))) :  '';

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php // echo $this->renderPartial($this->path_view. '_tabMenu',array()); 
        ?>
        <!--div class="biru">
        <div class="white"-->
        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model, 'rekDebit' => $rekDebit, 'rekKredit' => $rekKredit)); ?>
        <!--/div>
    </div-->
    </div>
</div>