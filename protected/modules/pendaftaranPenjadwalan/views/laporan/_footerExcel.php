<!--echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'));-->

<div class="form-actions">
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
    ?>
    <?php
    if (isset($tips)) :
        if ($tips == 'rekapitulasi') :
            $content = $this->renderPartial('pendaftaranPenjadwalan.views.laporan.tips.laporanRekapitulasiPerUnitpelayanan', array(), true);
        elseif ($tips == 'bukuregister') :
            $content = $this->renderPartial('pendaftaranPenjadwalan.views.laporan.tips.laporanBukuRegister', array(), true);
        else :
            $content = $this->renderPartial('pendaftaranPenjadwalan.views.laporan.tips.laporan10BesarPenyakit', array(), true);
        endif;
    else :
        $content = $this->renderPartial('pendaftaranPenjadwalan.views.laporan.tips.laporan10BesarPenyakit', array(), true);
    endif;

    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>

</div>
<?php

$jsx = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#searchInfoKunjungan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $jsx, CClientScript::POS_HEAD);
?>
<?php
Yii::app()->clientScript->registerScript('test', '
function resizeIframe(obj){
       obj.style.height = obj.contentWindow.document.body.scrollHeight + "px";
    }    

', CClientScript::POS_HEAD);

?>