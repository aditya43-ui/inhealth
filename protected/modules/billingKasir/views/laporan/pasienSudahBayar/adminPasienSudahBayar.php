<?php
$this->breadcrumbs = array(
    'Pasien Sudah Bayar' => array('/billingKasir/Laporan/pasienSudahBayar'),
    'PasienKarcis',
); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
Yii::app()->clientScript->registerScript('cariPasien', "
$('#caripasien-form').submit(function(){
        $.fn.yiiGridView.update('semua_pencarianpasien_grid', {
            data: $(this).serialize()
        });
        $.fn.yiiGridView.update('penjamin_pencarianpasien_grid', {
            data: $(this).serialize()
        });
        $.fn.yiiGridView.update('umum_pencarianpasien_grid', {
            data: $(this).serialize()
        });
        return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Laporan <b>Pasien Sudah Bayar</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'caripasien-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'focus' => '#' . CHtml::activeId($model, 'no_rekam_medik'),
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
                ));
                ?>
                <!--fieldset class="box form-actions"-->
                <?php echo $this->renderPartial('pasienSudahBayar/_formKriteriaPencarian', array('model' => $model, 'form' => $form, 'format' => $format), true); ?>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                    ); ?>
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset', 'onClick' => 'onReset()')
                    ); ?>
                </div>
                <?php $this->endWidget(); ?>
                <!--</fieldset>-->
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Sudah Bayar</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('bootstrap.widgets.BootMenu', array(
                    'type' => 'tabs',
                    'stacked' => false,
                    'htmlOptions' => array('id' => 'tabmenu'),
                    'items' => array(
                        array('label' => 'All', 'url' => 'javascript:tab(0);', 'active' => true),
                        array('label' => 'P3', 'url' => 'javascript:tab(1);', 'itemOptions' => array("index" => 1)),
                        array('label' => 'Umum', 'url' => 'javascript:tab(2);', 'itemOptions' => array("index" => 2)),
                    ),
                ))
                ?>
                <div class="biru" id="div_semua">
                    <!--<legend class="rim">Tabel Pasien Sudah Bayar - Semua</legend>-->
                    <div class="white">
                        <?php
                            $this->renderPartial('pasienSudahBayar/table/_tableAll', ['model' => $model]);
                        ?>
                    </div>
                </div>
                <div class="biru" id="div_penjamin">
                    <!--<legend class="rim">Tabel Pasien Sudah Bayar - P3</legend>-->
                    <div class="white" style="max-width:100%;overflow-x:auto">
                        <?php
                            $this->renderPartial('pasienSudahBayar/table/_tablePenjamin', ['model' => $model]);
                        ?>
                    </div>
                </div>
                <div class="biru" id="div_umum">
                    <!--<legend class="rim">Tabel Pasien Sudah Bayar - Umum</legend>-->
                    <div class="white" style="max-width:100%;overflow-x:auto">
                        <?php
                            $this->renderPartial('pasienSudahBayar/table/_tableUmum', ['model' => $model]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai    
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            //        $this->widget('bootstrap.widgets.BootButtonGroup', array(
            //            'type'=>'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            //            'buttons'=>array(
            //                array('label'=>'Print', 'icon'=>'entypo-print', 'url'=>$urlPrint, 'htmlOptions'=>array('onclick'=>'print(\'PRINT\');return false;')),
            //                array('label'=>'',
            //                    'items'=>array(
            //                        array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>$urlPrint, 'itemOptions'=>array('onclick'=>'print(\'PDF\');return false;')),
            //                        array('label'=>'Excel','icon'=>'icon-pdf', 'url'=>$urlPrint, 'itemOptions'=>array('onclick'=>'print(\'EXCEL\');return false;')),
            //                    )
            //                ),
            //            ),
            //        ));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'url' => $urlPrint, 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'url' => $urlPrint, 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'url' => $urlPrint, 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('../tips/tips_laporan', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<?php
$js = <<< JS
$(document).ready(function() {
    $("#tabmenu").children("li").children("a").click(function() {
        $("#tabmenu").children("li").attr('class','');
        $(this).parents("li").attr('class','active');
        $(".icon-pencil").remove();
        // $(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
    });
    $("#div_semua").show();
    $("#div_penjamin").hide();
    $("#div_umum").hide();
});
function tab(index){
    $(this).hide();
    if (index==0){
        $("#filter_tab").val('all');
        $("#div_semua").show();
        $("#div_penjamin").hide();
        $("#div_umum").hide();        
    } else if (index==1){
        $("#filter_tab").val('p3');
        $("#div_semua").hide();
        $("#div_penjamin").show();
        $("#div_umum").hide();
    } else if (index==2){
        $("#filter_tab").val('umum');
        $("#div_semua").hide();
        $("#div_penjamin").hide();
        $("#div_umum").show();        
    }
}
function onReset()
{
setTimeout(
    function(){
        $.fn.yiiGridView.update('semua_pencarianpasien_grid', {
            data: $("#caripasien-form").serialize()
        });
        $.fn.yiiGridView.update('penjamin_pencarianpasien_grid', {
            data: $("#caripasien-form").serialize()
        });
        $.fn.yiiGridView.update('umum_pencarianpasien_grid', {
            data: $("#caripasien-form").serialize()
        });        
    }, 2000
);
return false;
}   
JS;
Yii::app()->clientScript->registerScript('pencatatanriwayat', $js, CClientScript::POS_HEAD);
?>
<?php
$js = <<< JSCRIPT
function print(caraPrint)
{
window.open("${urlPrint}/&"+$('#caripasien-form').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>