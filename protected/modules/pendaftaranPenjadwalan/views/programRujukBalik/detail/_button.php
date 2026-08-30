
<?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
    
    $this->renderPartial('_buttonPengaturan',['model'=>$model]);
    
?>    

<script>
    function print(caraPrint){
            window.open("<?= $this->createUrl('printDetail',['id'=>$_GET['id']]) ?>&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
</script>