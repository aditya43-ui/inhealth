<?php
$this->breadcrumbs = array(
    'Formulir Stok Opname Bahan Makanan',
); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Formulir <b>Stok Opname Bahan Makanan</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body" id="form-obatalkes">
                <?php
                Yii::app()->clientScript->registerScript('search', "
                            $('#pencarianbahanmakanan-form').submit(function(){
                                $('#makanan-m-grid').addClass('animation-loading');
                                $.fn.yiiGridView.update('makanan-m-grid', {
                                    data: $(this).serialize()
                                });
                                return false;
                            });
                            ");
                ?>
                <?php
                if (isset($_GET['sukses'])) {
                    Yii::app()->user->setFlash('success', "Data Formulir Stok Opname Bahan Makanan berhasil disimpan!");
                }
                ?>
                <?php if (!isset($_GET['sukses'])) { ?>
                    <!--fieldset class="box" id="form-obatalkes"-->
                    <div>
                        <?php $this->renderPartial($this->path_view . '_pencarianBahan', array('modObat' => $modObat)); ?>
                    </div>
                    <!--</fieldset>-->
                <?php } ?>
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Stok Opname Bahan Makanan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'formuliropnamegizi-r-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
                ));
                ?>

                <?php $this->renderPartial($this->path_view . '_listBahan', array('modObat' => $modObat, 'model' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Formulir Stok Opname</b>
                </div>
            </div>
            <div class="panel-body" id="form-formuliropanme">
                <!--fieldset class="box" id="form-formuliropanme"-->
                <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                            ?></p>-->
                <?php echo $form->errorSummary($model); ?>
                <div>
                    <?php $this->renderPartial($this->path_view . '_formFormulirOpname', array('form' => $form, 'format' => $format, 'model' => $model)); ?>
                </div>
                <!--</fieldset>-->
            </div>
        </div>
        <div class="form-actions">
            <?php
            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
            $disableSave = false;
            $disableSave = (!empty($_GET['formuliropname_id'])) ? true : (($sukses > 0) ? true : false);
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'validasiBahan();', 'onkeypress' => 'validasiObat();', 'disabled' => $disableSave)
            ); //formSubmit(this,event)        
            //  jika tanpa validasiObat
            /**echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disableSave));
             * 
             */
            ?>
            <?php if (!isset($_GET['frame'])) {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl('index'),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'refreshForm(this); return false;'
                    )
                );
            } ?>
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => $disablePrint, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            ?>
            <?php
            $tips = array(
                '0' => 'cari2',
                '1' => 'simpan',
                '2' => 'ulang',
                '3' => 'print',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
            <?php
            //$content = $this->renderPartial($this->path_view.'tips/tipsFormulirStock',array(),true);
            //$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modObat' => $modObat)); ?>
<!--/div-->