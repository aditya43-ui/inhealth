<style>
    .integer,
    .float {
        text-align: right;
    }
</style>
<!--div class="white-container"-->
<?php
$this->breadcrumbs = array(
    'Transaksi Produksi Obat',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Produksi Obat</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'faproduksiobat-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            //        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return cekInput();'),
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#FAProduksiobatT_noproduksiobt',
        )); ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Transaksi berhasil disimpan");
        }
        ?>
        <?php echo $form->errorSummary(array($model)); ?>
        <?php echo isset($modObatalkesM) ? $form->errorSummary(array($modObatalkesM)) : ""; ?>

        <?php echo $this->renderPartial('_form', array('model' => $model, 'modProduksiDetail' => $modProduksiDetail, 'modObatalkesM' => $modObatalkesM, 'form' => $form)); ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Detail <b>Bahan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php echo $this->renderPartial('_formDetailProduksi', array('model' => $model, 'modProduksiDetail' => $modProduksiDetail, 'modObatalkesM' => $modObatalkesM, 'form' => $form, 'dataDetails' => $dataDetails)); ?>
            </div>
        </div>

        <?php echo $this->renderPartial('_formObatalkes', array('model' => $model, 'modProduksiDetail' => $modProduksiDetail, 'modObatalkesM' => $modObatalkesM, 'form' => $form)); ?>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'cekObat();', 'onkeypress' => 'cekObat();', 'onKeypress' => 'return formSubmit(this,event)')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/create'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);'
                )
            ); ?>
            <?php $this->endWidget(); ?>
            <?php
            $tips = array(
                '0' => 'simpan',
                '1' => 'ulang',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>

<!--/div-->
<script>
    function cekInput() {
        $('.float').each(function() {
            this.value = unformatNumber(this.value)
        });
        $('.integer').each(function() {
            this.value = unformatNumber(this.value)
        });
        return true;
    }

    function formatInputLoad() {
        $('.float').each(function() {
            this.value = formatNumber(this.value)
        });
        $('.integer').each(function() {
            this.value = formatNumber(this.value)
        });
    }
    formatInputLoad();
</script>
<?php $this->renderPartial('_jsFunctions', array('model' => $model, 'modObatalkesM' => $modObatalkesM, 'form' => $form, 'modProduksiDetail' => $modProduksiDetail)); ?>