<?php

$this->breadcrumbs=array(
	'Stock Opname Bahan Makanan',
);?>

<style type="text/css">
.integer-decimal{
	text-align: right;
}
</style>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Stock Opname Bahan Makanan</div>
<?php
//  $this->breadcrumbs = array(
//      'Stock Opname Bahan Makanan',
//  ); ?>
 <!-- <style type="text/css">
     .integer-decimal {
         text-align: right;
     }
 </style>
 <div class="panel panel-gradient">
     <div class="panel-heading">
         <div class="panel-title">
             <i class="glyphicon glyphicon-briefcase"></i> Stock Opname Bahan Makanan
         </div> -->

    </div>
    <div class="panel-body">
        <?php
        // CHtml::$hiddenDebug = true;

        Yii::app()->clientScript->registerScript('search', "
        $('.search-form form').submit(function(){
            $('#makanan-m-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('makanan-m-grid', {
                data: $(this).serialize()
            });
            return false;
        });
        "); ?>
        <?php

        if(isset($_GET['sukses'])){
            Yii::app()->user->setFlash('success',"Data Stock Opname Bahan Makanan berhasil disimpan !");

        // if (isset($_GET['sukses'])) {
        //     Yii::app()->user->setFlash('success', "Data Stock Opname Bahan Makanan berhasil disimpan !");

        }
        ?>
        <div class="panel panel-success" id="form-barang">
            <div class="panel-heading">
                <div class="panel-title judul">Pencarian Bahan Makanan</div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view.'_pencarianBahanMakanan', array('modMakanan' => $modMakanan)); ?>
            </div>
        </div>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php
            $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'id' => 'opnamemakanan-t-form',
                'enableAjaxValidation' => false,
                'type' => 'horizontal',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'),
            ));
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">

                <div class="panel-title judul">Tabel <b>Stock Opname Bahan Makanan</b></div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view.'_listBahanMakanan', array('modMakanan' => $modMakanan,'model'=>$model)); ?>

                <!-- <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Stock Opname Bahan Makanan</b>
                </div>
            </div>
            <div class="panel-body">
                <?php //$this->renderPartial($this->path_view . '_listBahanMakanan', array('modMakanan' => $modMakanan, 'model' => $model)); ?> -->

            </div>
        </div>

        <div class="panel panel-success" id="form-inventarisasi-barang">
            <div class="panel-heading">

                <!-- <div class="panel-title judul">Data Stock Opname Bahan Makanan</b></div> -->

                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i>Data Stock Opname Bahan Makanan</b>
                </div>
            </div>
            <div class="panel-body">
                <?php echo $form->errorSummary($model); ?>
                <?php $this->renderPartial($this->path_view.'_formOpnameBahanMakanan', array('form'=>$form,'model'=>$model)); ?>
                <div class="form-actions">
                    <?php

                            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
                            $disableSave = false;
                            $disableSave = (!empty($_GET['invbarang_id'])) ? true : (($sukses > 0) ? true : false);;
                        ?>
                        <?php $disablePrint = ($disableSave) ? false : true; ?>
                        <?php
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'validasiBarang();', 'onkeypress'=>'validasiBarang();','disabled'=>$disableSave)); //formSubmit(this,event)
                            //  jika tanpa validasiBarang
                            /**echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disableSave));
                             *
                             */
                             ?>
                        <?php if(!isset($_GET['frame'])){
                            echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                                $this->createUrl('index'),
                                array('class'=>'btn btn-danger',
                                      'onclick'=>'refreshForm(this); return false;'));
                        } ?>
                        <?php
                                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>$disablePrint,'type'=>'button','onclick'=>'print(\'PRINT\')'));
                        ?>
                        <?php
                            //$content = $this->renderPartial($this->path_view.'tips/tipsInventarisasiBarang',array(),true);
                            //$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>

                    <!-- $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
                    $disableSave = false;
                    $disableSave = (!empty($_GET['invbarang_id'])) ? true : (($sukses > 0) ? true : false);; -->
                    <!-- ?> -->
                    <?php //$disablePrint = ($disableSave) ? false : true; ?>
                    <?php
                    //echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'validasiBarang();', 'onkeypress' => 'validasiBarang();', 'disabled' => $disableSave)); //formSubmit(this,event)
                    //  jika tanpa validasiBarang
                    /**echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disableSave));
                     *
                     */
                    ?>
                    <?php //if (!isset($_GET['frame'])) {
                        //echo CHtml::link(
                            // Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                            // $this->createUrl('index'),
                            // array(
                            //     'class' => 'btn btn-default',
                            //     'onclick' => 'refreshForm(this); return false;'
                            //)
                        //);
                    //} ?>
                    <?php
                    //echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => $disablePrint, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
                    ?>
                    <?php
                    //$content = $this->renderPartial($this->path_view.'tips/tipsInventarisasiBarang',array(),true);
                    //$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                    ?>

                </div>
            </div>
        </div>

        <?php $this->endWidget(); ?>
        <?php $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model,'modMakanan'=>$modMakanan)); ?>
    </div>
</div>
