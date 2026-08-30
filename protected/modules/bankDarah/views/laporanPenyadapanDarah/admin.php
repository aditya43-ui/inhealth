<?php
$this->breadcrumbs = array(
    'Laporan Penyadapan Darah'
);
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('#penyadapan-darah-search').submit(function(){
        $.fn.yiiGridView.update('laporan-penyadapan-darah-grid', {
            data: $(this).serialize()
        });
        return false;
    });
    ");
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Laporan <strong>Penyadapan Darah</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body search-form">
                        <?php
                        $this->renderPartial('_search', array(
                            'model' => $model,
                        ));
                        ?>
                    </div>
                </div>								
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Penyadapan Darah</strong></div>
                    </div>
                    <div class="panel-body overflow-x" >
                        <?php $this->renderPartial('_table', array('model' => $model)); ?>
                    </div>
                </div>
                <?php
                echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
                $content = $this->renderPartial('../tips/master', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
                ?>
            </div>
        </div>
    </div>
</div>

<?php
$js = <<< JSCRIPT
function cekForm(obj)
{
    $("#penyadapan-darah-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#penyadapan-darah-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
