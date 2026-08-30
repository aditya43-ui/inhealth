 <?php
    $this->breadcrumbs = array(
        'Jurnal Rekening',
    );

    $arrMenu = array();
    //                    array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jenis Jurnal ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Jurnal Rekening', 'icon' => 'folder-open', 'url' => array('admin'))) :  '';

    $this->menu = $arrMenu;

    $this->widget('bootstrap.widgets.BootAlert');
    ?>

 <style>
     iframe {
         width: 100% !important;
     }
 </style>

 <div class="panel panel-gradient">
     <div class="panel-heading">
         <div class="panel-title">
             <i class="fas fa-layer-group"></i> Jurnal Rekening
         </div>
     </div>
     <div class="panel-body">
         <?php $this->renderPartial($this->path_view . '_tabMenu', array()); ?>
         <?php $this->renderPartial($this->path_view . '_jsFunctions', array()); ?>
         <div>
             <iframe id="frame" class="biru" src="" style="width: 100%; overflow-y: scroll; border: none;"></iframe>
         </div>
     </div>
 </div>