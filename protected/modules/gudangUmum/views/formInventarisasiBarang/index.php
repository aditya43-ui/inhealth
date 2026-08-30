<?php $linkHalaman = CustomFunction::getUrlByMenuID(1160); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Formulir <b>Inventarisasi Barang</b>
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
            'Transaksi Formulir Inventarisasi Barang',
        );
        Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function(){
        $('#barang-m-grid').addClass('animation-loading');
        $.fn.yiiGridView.update('barang-m-grid', {
            data: $(this).serialize()
        });
        return false;
    });
    ");
        ?>
        <?php
        $konfig = KonfigsystemK::model()->find();
        $classHidden = false;
        if (isset($konfig->tampilhargagu)) {
            if ($konfig->tampilhargagu == true) {
                if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_PURCHASING) {
                    $classHidden = true;
                }
            }
        }
        ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data nomor Formulir Inventarisasi Barang " . $model->forminvbarang_no . " berhasil disimpan!");
        }
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-search"></i> Pencarian Inventarisasi Barang
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_pencarianBarang', array('modBarang' => $modBarang)); ?>
            </div>
            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
            <?php
            $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'id' => 'forminvbarang-t-form',
                'enableAjaxValidation' => false,
                'type' => 'horizontal',
                'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
                'focus' => '#' . CHtml::activeId($modBarang, 'barang_kode'),
            ));
            ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Inventarisasi Barang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial($this->path_view . '_listBarang', array('modBarang' => $modBarang, 'model' => $model, 'modDetail' => $modDetail)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Formulir Inventarisasi Barang</b>
                </div>
            </div>
            <div class="panel-body">
                <p class="help-block"> <?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                        ?></p>
                <?php echo $form->errorSummary($model); ?>
                <?php $this->renderPartial($this->path_view . '_formFormulirInventarisasi', array('form' => $form, 'format' => $format, 'model' => $model, 'classHidden' => $classHidden)); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php
            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
            $disableSave = false;
            $disableSave = (!empty($_GET['invbarang_id'])) ? true : (($sukses > 0) ? true : false);
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'validasiBarang();', 'onkeypress' => 'validasiBarang();', 'disabled' => $disableSave)
            ); //formSubmit(this,event)        
            //  jika tanpa validasiBarang
            /*                 * echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                  array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disableSave));
                 * 
                 */
            ?>
            <?php
            if (!isset($_GET['frame'])) {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl('index'),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'refreshForm(this); return false;'
                    )
                );
            }
            ?>
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => $disablePrint, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            ?>
            <?php
            $content = $this->renderPartial($this->path_view . 'tips/tipsFormInventarisasiBarang', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model)); ?>
    </div>
</div>