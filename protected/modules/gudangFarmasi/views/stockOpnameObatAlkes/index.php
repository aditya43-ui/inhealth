<?php
$this->breadcrumbs = array(
    'Informasi Formulir Stock Opname Obat Alkes' => Yii::app()->request->getUrlReferrer(),
    'Transaksi Stock Opname Obat Alkes',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <strong>Stock Opname Obat Alkes</strong>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data Stock Opname Obat Alkes berhasil disimpan !");
        }
        ?>
        <?php if (!isset($_GET['sukses']) && !isset($_GET['formuliropname_id'])) { ?>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-search"></i> Pencarian <b>Stock Opname Obat Alkes</b>
                    </div>
                </div>
                <div class="panel-body" id="form-obatalkes">
                    <?php
                    Yii::app()->clientScript->registerScript('search', "
                            $('.search-form form').submit(function(){
                                $('#obatalkes-m-grid').addClass('animation-loading');
                                $.fn.yiiGridView.update('obatalkes-m-grid', {
                                    data: $(this).serialize()
                                });
                                return false;
                            });
                            ");
                    ?>
                    <!--fieldset class="box" id="form-obatalkes"-->
                    <?php $this->renderPartial($this->path_view . '_pencarianObat', array('modObat' => $modObat)); ?>
                    <!--/fieldset-->
                </div>
            </div>
        <?php } ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'gfstokopname-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
            //'focus'=>'#'.CHtml::activeId($model,'jenisstokopname'),
        )); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <strong>Stock Opname Obat Alkes</strong>
                </div>
            </div>
            <div class="panel-body" id="form-obatalkes" class="overflow-x">
                <?php $this->renderPartial($this->path_view . '_listObat', array('modObat' => $modObat, 'model' => $model, 'modDet' => $modDet)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <strong>Stock Opname Obat Alkes</strong>
                </div>
            </div>
            <div class="panel-body" id="form-stokopname">
                <!--fieldset class="box" id="form-stokopname"-->
                <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
                <?php echo $form->errorSummary($model); ?>
                <div>
                    <?php $this->renderPartial($this->path_view . '_formStockOpname', array('form' => $form, 'format' => $format, 'model' => $model)); ?>
                </div>
                <!--/fieldset-->
            </div>
        </div>
        <div class="form-actions">
            <?php
            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
            $disableSave = false;
            $disableSave = ((!empty($_GET['stokopname_id'])) ? true : (($sukses > 0) ? true : false));
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'validasiBarang();', 'onkeypress' => 'validasiBarang();', 'disabled' => $disableSave)); //formSubmit(this,event)
            //  jika tanpa validasiObat
            /**echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disableSave));
             *
             */
            ?>
            <?php
            if (!isset($_GET['frame'])) {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="' . MyIcon::getIcons('ulang') . '"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'class' => 'btn btn-default',
                        'onclick' => 'return refreshForm(this);'
                    )
                );
            }
            ?>
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), array('class' => 'btn btn-info', 'disabled' => $disablePrint, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            ?>
            <?php
            $content = $this->renderPartial($this->path_view . 'tips/tipsStokOpname', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modObat' => $modObat)); ?>
<!--/div-->