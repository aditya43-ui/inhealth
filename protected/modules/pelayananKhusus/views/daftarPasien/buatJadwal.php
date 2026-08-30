<div class="white-container">
    <legend class="rim2">Buat Jadwal <b>Rehab Medis</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php  ?>
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'buatjadwal-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#lamaterapi',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
    )); ?>

    <?php echo $form->errorSummary(array($modNewHasil,$modJadwalKunjungan,$modTindakanPelayanan,$modTindakanKomponen)); ?>

    <?php echo $this->renderPartial('_formDataPasien',array('form'=>$form,'modPasienPenunjang'=>$modPasienPenunjang)) ?>

    <?php echo $this->renderPartial('_formJadwalKunjungan',array('form'=>$form,'modPasienPenunjang'=>$modPasienPenunjang,'id'=>$id,'listJadwalKunjungan'=>$listJadwalKunjungan,)) ?>
    <div class='form-actions'>
        <?php if(empty($listJadwalKunjungan)){?>

                <?php echo CHtml::htmlButton($modJadwalKunjungan->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
						Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
							array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), $this->createUrl('buatJadwal',array('id'=>$modPasienPenunjang->pasienmasukpenunjang_id)), array('class'=>'btn btn-danger')); ?>
                <?php $this->widget('UserTips',array('type'=>'transaksi','content'=>'penjelasan transaksi')); ?>
        <?php }else{ ?>
                <?php 
                $this->widget('UserTips',array('type'=>'transaksi','content'=>'penjelasan transaksi'));
                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp";
                ?>
        <?php } ?>

        <?php $this->endWidget(); ?>
    </div>
</div>
<script type="text/javascript">
    function print(caraPrint)
{
    window.open("<?php echo $this->createUrl('printJadwal'); ?>/"+"&id=<?php echo $id; ?>"+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
</script>


