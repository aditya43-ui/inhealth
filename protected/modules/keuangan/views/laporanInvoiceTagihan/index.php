<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Invoice Tagihan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Laporan Invoice Tagihan',
        );
        //$url = Yii::app()->createUrl(Yii::app()->controller->module->id.'/laporan/frameGrafikBukuRegister&id=1');
        Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
        });
        $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('tableLaporan', {
                    data: $(this).serialize()
            });
            return false;
        });
        ");
        ?>
        <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); 
        ?>
        <div class="box search-form">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-search"></i> Pencarian
                    </div>
                </div>
                <div class="panel-body">
                    <?php $this->renderPartial('_search', array(
                        'model' => $model, 'format' => $format
                    )); ?>
                </div>
            </div>
        </div>
        <!--search-form-->

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Invoice Tagihan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('_table', array('model' => $model)); ?>
            </div>
        </div>
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
        ?>
        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "";
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "";
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "";
            ?>
            <?php
            $content = $this->renderPartial('../tips/laporan', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php

        $jsx = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#searchLaporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $jsx, CClientScript::POS_HEAD);
        ?>
        <?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>
    </div>
</div>