<!--div class="white-container"-->
<?php
$this->breadcrumbs = array(
    'Formulir Stock Obat Alkes Opname',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-file-medical"></i> Formulir <b>Stock Opname Obat Alkes</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
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
                            $('#pencarianobat-form').submit(function(){
                                $('#tabel-detailstok tbody').empty();
                                $('#obatalkes-m-grid').addClass('animation-loading');
                                $.fn.yiiGridView.update('obatalkes-m-grid', {
                                    data: $(this).serialize()
                                });
                                return false;
                            });
                            ");
                ?>
                <?php
                if (isset($_GET['sukses'])) {
                    Yii::app()->user->setFlash('success', "Data Formulir Stock Obat Alkes Opname " . $model->noformulir . " berhasil disimpan!");
                }
                ?>
                <?php if (!isset($_GET['sukses'])) { ?>
                    <!--fieldset class="box" id="form-obatalkes"-->
                    <div>
                        <?php $this->renderPartial($this->path_view . '_pencarianObat', array('modObat' => $modObat)); ?>
                    </div>
                    <!--</fieldset>-->
                <?php } ?>
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Stok Opname Obat Alkes</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial($this->path_view . '_listObat', array('modObat' => $modObat, 'model' => $model)); ?>                    
            </div>
        </div>
        
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'gfformuliropname-r-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#' . CHtml::activeId($modObat, 'obatalkes_kode'),
        ));
        ?>
        <table id="tabel-detailstok" hidden>
            <tbody>

            </tbody>
        </table>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Stok Opname Obat Alkes</b>
                </div>
            </div>
            <div class="panel-body">
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
                array('title' => 'Simpan', 'id' => 'btn_submit', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'validasiObat();', 'onkeypress' => 'validasiObat();', 'disabled' => $disableSave)
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

            echo CHtml::link(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => $disablePrint, 'onclick' => "print('EXCEL')"));

            ?>
            <?php
            $content = $this->renderPartial($this->path_view . 'tips/tipsFormulirStock', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modObat' => $modObat)); ?>
<!--/div-->