<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Rekapitulasi Penerimaan Sejenis</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $url = Yii::app()->createUrl(Yii::app()->controller->module->id . '/laporan/frameGrafikKasHarian&id=1');
        Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
        });
        $('#searchLaporan').submit(function(){
            $('#Grafik').attr('src','').css('height','0px');
            $.fn.yiiGridView.update('laporanrekapterimasejenisrj-grid', {
                    data: $(this).serialize()
            });
            return false;
        });
        ");
        ?>

        <?php $this->renderPartial('rekapRJ/_search', array('model' => $model, 'filter' => $filter, 'format' => $format)); ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Rekapitulasi Penerimaan Sejenis</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $this->widget('bootstrap.widgets.BootMenu', array(
                    'type' => 'tabs',
                    'stacked' => false,
                    'htmlOptions' => array('id' => 'tabmenu'),
                    'items' => array(
                        array('label' => 'Rekap Penerimaan Sejenis Rawat Inap', 'url' => $this->createAbsoluteUrl($controller . '/index')),
                        array('label' => 'Rekap Penerimaan Sejenis Rawat Jalan', 'url' => $this->createAbsoluteUrl($controller . '/indexRJ'), 'active' => true),
                    ),
                ))
                ?>

                <?php $this->renderPartial('rekapRJ/_table', array('model' => $model)); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-chart-bar"></i> Grafik
                </div>
            </div>
            <div class="panel-body">
                <iframe src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
            </div>
        </div>

        <div class="form-actions">
            <?php
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanKasHarian');
            //$this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); 
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            //                    echo CHtml::htmlButton(Yii::t('mds','{icon} Grafik',array('{icon}'=>'<i class="entypo-chart-area"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'GRAFIK\')')); 

            $content = $this->renderPartial('billingKasir.views.laporanRekapTerimaSejenis.tips.tips2', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
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
    });

   function onReset()
   {
        setTimeout(
            function(){
                $.fn.yiiGridView.update('laporanrekapterimasejenisri-grid', {
                    data: $(this).serialize()
                });    
                $.fn.yiiGridView.update('laporanrekapterimasejenisrj-grid', {
                    data: $(this).serialize()
                });    
            }, 2000
        );
        return false;
   }   
JS;
    Yii::app()->clientScript->registerScript('laporankasharian', $js, CClientScript::POS_HEAD);
    ?>
</div>