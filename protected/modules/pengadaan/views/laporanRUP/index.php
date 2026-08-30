<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $('#Grafik').attr('src','').css('height','0px');
            $.fn.yiiGridView.update('laporan-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title"> Laporan <strong> Rencana Umum Pengadaan </strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> <b> Pencarian </b></div>
                    </div>
                    <div class="panel-body box">						
                        <?php $this->renderPartial($this->path_view . '_search', array('model' => $model)); ?>						
                    </div>
                </div>								
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Rencana Umum Pengadaan </strong></div>
                    </div>
                    <div class="panel-body" style="overflow-x: scroll">
                        <div class="block-tabel">
                            <?php $this->renderPartial($this->path_view . '_table', array('model' => $model)); ?>
                        </div>
                        <div class="row-fluid">
                            <?php
                            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                            $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
                            $content = $this->renderPartial('kepegawaian.views.tips.laporan_presensi', array(), true);
                            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

                            $jsx = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#laporanrup-v-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
                            Yii::app()->clientScript->registerScript('print', $jsx, CClientScript::POS_HEAD);
                            ?> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>