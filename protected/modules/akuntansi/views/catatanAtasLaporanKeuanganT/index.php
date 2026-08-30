 <?php
    $this->breadcrumbs = array(
        'Transaksi Catatan Atas Laporan Keuangan',
    );
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');

    $menu_nama = empty($menu_label[Yii::app()->controller->id]) ? "Catatan Atas Laporan Keuangan" : $menu_label[Yii::app()->controller->id];
    ?>
 <!--div class="white-container"-->

 <div class="panel panel-gradient">
     <div class="panel-heading">
         <div class="panel-title">
             <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Catatan Atas Laporan Keuangan</b>
         </div>
     </div>
     <div class="panel-body">
         <?php
            if (!empty($_GET['sukses'])) {
            ?>

         <?php } ?>
         <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
         <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'id' => 'calk-t-form',
                'enableAjaxValidation' => false,
                'type' => 'horizontal',
                'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);', 'enctype' => 'multipart/form-data'),
                'focus' => '#namaBarang',
            )); ?>
         <div class="panel panel-success">
             <div class="panel-heading">
                 <div class="panel-title">
                     <i class="entypo-search"></i> Pencarian
                 </div>
             </div>
             <div class="panel-body">
                 <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                            ?></p>-->

                 <?php // echo $form->errorSummary($model); 
                    ?>
                 <?php $this->renderPartial('_search', array('model' => $model, 'form' => $form)); ?>
             </div>
         </div>
         <div class="panel panel-success">
             <div class="panel-heading">
                 <div class="panel-title">
                     <i class="far fa-edit"></i> Catatan Atas Laporan Keuangan
                 </div>
             </div>
             <div class="panel-body">
                 <?php $this->renderPartial('_calk', array('model' => $model, 'form' => $form,)); ?>
             </div>
         </div>
         <div class="form-actions">
             <?php
                $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
                $disableSave = false;

                $disableSave = (!empty($_GET['id'])) ? true : (($sukses > 0) ? true : false);
                ?>
             <?php $disablePrint = ($disableSave) ? false : true; ?>
             <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit')); //formSubmit(this,event) 
                ?>
             <?php echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->module->id . '/Index'),
                    array(
                        'class' => 'btn btn-default',
                        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('Index') . '";} ); return false;'
                    )
                ); ?>
             <?php echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')", 'disabled' => $disablePrint)); ?>
             <?php
                $tips = array(
                    '0' => 'simpan',
                    '1' => 'ulang',
                    '2' => 'print',
                );
                $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                ?>
         </div>

         <?php $this->endWidget(); ?>
     </div>
 </div>

 <script type="text/javascript">
     function print(caraPrint) {
         var calk_id = '<?php echo isset($_GET['calk_id']) ? $_GET['calk_id'] : null; ?>';
         window.open('<?php echo $this->createUrl('print'); ?>&calk_id=' + calk_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
     }
 </script>