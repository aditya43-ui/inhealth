<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Setoran ke Bank
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
            'Informasi Kirim Closing' => Yii::app()->request->getUrlReferrer(),
            'Setoran ke Bank',
        );
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'setoranbendahara-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return cekValidasi(this);',
            ),
        ));
        ?>
        <?php
        if (isset($_GET['id'])) {
            Yii::app()->user->setFlash('success', "Data setoran berhasil disimpan!");
        }
        ?>
        <?php if (empty($id)) echo $this->renderPartial($this->path_view . 'sub/_infosetoran', array('form' => $form, 'model' => $model), true); ?>
        <?php echo $this->renderPartial($this->path_view . 'sub/_formsetoran', array('form' => $form, 'model' => $model, 'setorbank' => $setorbank), true); ?>
        <?php echo $this->renderPartial($this->path_view . 'sub/_detailsetoran', array('form' => $form, 'model' => $model, 'detail' => $detail, 'detailTotal' => $detailTotal), true); ?>
        <div class="form-actions">
            <?php
            if ($model->isNewRecord) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_submit')
                ); //formSubmit(this,event)
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'return false', 'onkeypress' => 'return false', 'disabled' => true, 'style' => 'cursor:not-allowed;')
                );
            }
            ?>
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);'
                )
            );
            if ($model->isNewRecord) {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printSetoran(" . $id . ");return false", 'disabled' => FALSE));
            }
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
        </div>
        <?php $this->endWidget(); ?>
    </div>
    <?php echo $this->renderPartial($this->path_view . 'sub/_jsfunctions', array('form' => $form, 'model' => $model, 'detail' => $detail), true); ?>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRincianClosing',
    'options' => array(
        'title' => 'Rincian Closing Kasir',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1000,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeRincianClosing" width="100%" height="460"></iframe>
<?php
$this->endWidget();
?>