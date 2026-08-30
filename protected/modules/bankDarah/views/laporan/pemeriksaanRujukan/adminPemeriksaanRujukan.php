<div class="white-container">
    <legend class="rim2">Laporan <b>Pemeriksaan Rujukan</b></legend>
    <?php
    Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
        });
        $('#searchLaporan').submit(function(){
            $('#Grafik').attr('src','').css('height','0px');
            $.fn.yiiGridView.update('tableRujukanLuar', {
                    data: $(this).serialize()
            });
            $.fn.yiiGridView.update('tableRujukanRS', {
                    data: $(this).serialize()
            });
            return false;
        });
        ");
    ?>
    <!--<div class="search-form">
            <?php // $this->renderPartial('bankDarah.views.laporan.pemeriksaanRujukan/_searchPemeriksaanRujukan',
            //                array('model'=>$model,'modelRS'=>$modelRS)); 
            ?>
    </div>-->
    <?php
    //        $this->widget('bootstrap.widgets.BootMenu',array(
    //            'type'=>'tabs',
    //            'stacked'=>false,
    //            'htmlOptions'=>array('id'=>'tabmenu'),
    //            'items'=>array(
    //                array('label'=>'Rujukan dari Luar','url'=>'javascript:tab(0);','active'=>true),
    //                array('label'=>'Rujukan dari RS','url'=>'javascript:tab(1);', 'itemOptions'=>array("index"=>1)),
    //            ),
    //        ))
    ?>
    <?php $this->renderPartial('bankDarah.views.laporan.pemeriksaanRujukan/_tabMenu', array()); ?>
    <?php $this->renderPartial('bankDarah.views.laporan.pemeriksaanRujukan/_jsFunctions', array()); ?>
    <div>
        <iframe id="frame" class="biru" src="" style="width: 100%; overflow-y: scroll; border: none;"></iframe>
        <?php // $this->renderPartial('bankDarah.views.laporan.pemeriksaanRujukan/_tablePemeriksaanRujukan', array('model'=>$model,'modelRS'=>$modelRS)); 
        ?>
    </div>
</div>