<?php $linkHalaman = CustomFunction::getUrlByMenuID(677); ?>
<div class="panel panel-primary panel-gradient" id="form-barang">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Inventarisasi Barang</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Informasi Formulir Inventarisasi Barang' => Yii::app()->request->getUrlReferrer(),
            'Transaksi Inventarisasi Barang',
        );
        Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function(){
        $('#barang-m-grid').addClass('animation-loading');
        $.fn.yiiGridView.update('barang-m-grid', {
            data: $(this).serialize()
        });
        return false;
    });
    "); ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data Inventarisasi Barang berhasil disimpan !");
        }
        ?>
        <?php if (!isset($_GET['sukses']) && !isset($_GET['formulirinvbarang_id'])) { ?>
            <div class="panel panel-success" id="form-barang">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-search"></i> Pencarian
                    </div>
                </div>
                <div class="panel-body">
                    <?php $this->renderPartial($this->path_view . '_pencarianBarang', array('modBarang' => $modBarang)); ?>
                </div>
            </div>
        <?php } ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'invbarang-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#' . CHtml::activeId($modBarang, 'barang_kode'),
        ));
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Inventarisasi Barang</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_listBarang', array('modBarang' => $modBarang, 'model' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success" id="form-inventarisasi-barang">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data Inventarisasi Barang</b>
                </div>
            </div>
            <div class="panel-body">
                <?php echo $form->errorSummary($model); ?>
                <?php $this->renderPartial($this->path_view . '_formInventarisasiBarang', array('form' => $form, 'format' => $format, 'model' => $model)); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php
            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
            $disableSave = false;
            $disableSave = ((!empty($_GET['invbarang_id'])) ? true : (($sukses > 0) ? true : false));
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'validasiBarang();', 'onkeypress' => 'validasiBarang();', 'disabled' => $disableSave)); //formSubmit(this,event)        
            //  jika tanpa validasiBarang
            /**echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disableSave));
             * 
             */
            ?>
            <?php if (!isset($_GET['frame'])) {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl('index'),
                    array(
                        'class' => 'btn btn-default',
                        'onclick' => 'refreshForm(this); return false;'
                    )
                );
            } ?>
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => $disablePrint, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            ?>
            <?php
            $content = $this->renderPartial($this->path_view . 'tips/tipsInventarisasiBarang', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modBarang' => $modBarang)); ?>
    </div>
</div>