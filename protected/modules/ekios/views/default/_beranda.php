<div style="text-align: center;">
    <?php $start_image = Yii::app()->getBaseUrl('webroot') . "/images/kiosk/newekios/backgroundhome.jpg"; ?>
    <div class="setbackout">
        <?php echo CHtml::image($start_image, 'Selamat datang di e-Kios!', array('style' => 'max-height: calc(100vh - 240px);', 'class' => 'setback',)); ?>
    </div>
</div>