<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB 
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pengajuan <b>Pergantian Kacamata</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data pengajuan kacamata berhasil disimpan!");
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php
        Yii::app()->clientScript->registerScript('search', "
        $('#pencariankacamata-form').submit(function(){
            $('#gantikacamata-t-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('gantikacamata-t-grid', {
                data: $(this).serialize()
            });
				$('#is_pilihsemua').attr('checked',true);
				hitungTotal();
            return false;
        });
        ");
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_pencarian', array('modGantiKacamata' => $modGantiKacamata)); ?>
            </div>
        </div>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'mcpengajuangantikm-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);', 'onkeyup' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '', 'onclick' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : ''),
            'focus' => '#' . CHtml::activeId($model, 'no_pengajuan'),
        ));
        ?>
        <?php echo $form->errorSummary($model); ?>
        <?php echo $form->errorSummary($modGantiKacamata); ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pergantian Kacamata</b>
                </div>
            </div>
            <div class="panel-body table-responsive" id="form-obatalkes">
                <?php $this->renderPartial($this->path_view . '_daftarGantiKacamata', array('modGantiKacamata' => $modGantiKacamata, 'model' => $model)); ?>
                <div class="control-group">
                    <div class="control-label">Total Harga</div>
                    <div class="controls">
                        <?php echo CHtml::textField('totalharga', '', array('class' => 'span3 integer', 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
        </div>

        <fieldset class="box" id="form-formuliropanme">
            <div class="rim">Data Pergantian Kacamata</div>
            <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                        ?></p>-->
            <div>
                <?php $this->renderPartial($this->path_view . '_formPenggantianKacamata', array('form' => $form, 'format' => $format, 'model' => $model)); ?>
            </div>
        </fieldset>

        <div class="form-actions">
            <?php
            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
            $disableSave = false;

            if (!empty($_GET['id'])) {
                $disableSave = true;
            } else {
                $disableSave = false;
            }
            $disableSave = (!empty($_GET['id'])) ? true : (($sukses > 0) ? true : false);
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => (isset($_GET['sukses'])) ? true : false)
            );
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
            $content = $this->renderPartial($this->path_view . 'tips/tipsPenggantianKacamata', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modGantiKacamata' => $modGantiKacamata)); ?>
    </div>
</div>