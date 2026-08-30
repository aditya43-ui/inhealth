<?php $this->renderPartial('test/_search', array('model' => $model, 'id' => 'garis')); ?>
<table>
    <tr>
        <td width="50%">
            <div id="garis" style='width: 100%;'>
                <?php $this->renderPartial('test/_grafik', array('model' => $model, 'id' => 'garis')); ?>
            </div>
            

        </td>
        <td width="50%">
                <div id="pie" style='width: 100%;z-index:2;'>
                    <?php $this->renderPartial('test/_grafik', array('model' => $model, 'id' => 'pie')); ?>
                </div>
        </td>
    </tr>
    <tr>
        <td width="50%">
            <?php
            $table = 'ext.bootstrap.widgets.BootGroupGridView';
            $sort = true;
            if (isset($caraPrint)) {
                $data = $model->searchPrint();
                $template = "{items}";
                $sort = false;
                if ($caraPrint == "EXCEL")
                    $table = 'ext.bootstrap.widgets.BootExcelGridView';
            } else {
                $data = $model->searchTable();
                $template = "{summary}\n{items}{pager}";
            }
            ?>
            <?php
            $this->widget($table, array(
                'id' => 'tableLaporan',
                'dataProvider' => $data,
                //    'filter'=>$model,
                'template' => $template,
                'enableSorting' => $sort,
                'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                'mergeColumns' => array('instalasi_nama', 'ruangan_nama'),
                'columns' => array(
                    'instalasi_nama',
                    'ruangan_nama',
                    'no_rekam_medik',
                    'nama_pasien',
//                    'alamat_pasien',
//                    'jeniskelamin',
//                    'umur',
                    'jeniskasuspenyakit_nama',
//                    'kelaspelayanan_nama',
//                    'tgl_pendaftaran',
                ),
            ));
            ?> 
        </td>
        <td width="50%">
            <div id="spedo" style='width: 100%;top:-100px;z-index:0;'>
            <?php
                    $this->widget('ext.jQPlot.widget.gaugeMeterChart', array(
                                'dataProvider' => $model->searchDashboard(),
//                                'autoUpdate'=>array(
//                                    'bind'=>array(
//                                        'form'=>'#searchLaporan',
//                                    ),
//                                    'url'=>Yii::app()->createUrl($this->route),
//                                ),
                                'rendererOptions'=>array(
                                    'min'=>0,
                                    'max'=>100,
                                    'intervals'=>array(10, 30, 45, 100),
                                    'label'=> 'Jumlah Kunjungan Rumah Sakit',
                                    'labelPosition'=>'bottom',
                                    'labelHeightAdjust'=> -5,
                                    'intervalOuterRadius'=> 85,
                                ),
                                'id' => 'spedo',
                            )
                    );
                    ?>
                </div>
        </td>
    </tr>
</table>

<?php
$url = Yii::app()->createUrl($this->route);
$js = <<< JS
$('#garis').bind('jqplotDblClick', 
    function (ev, seriesIndex, pointIndex, data,a) {
        kirim = $('#searchLaporan').serialize();
        $.post('index.php?'+kirim,{test:'test',ruangan_nama:a.options.axes.xaxis.ticks[(data.data[0])-1]}, function(hasil){
            plot_pie.destroy();
            plot_pie.series[0].data = hasil.pie;
            plot_pie.axes.xaxis.ticks = hasil.pie;
            plot_pie.redraw();
            setValue_spedo(hasil.spedo);
        },'json');
    });
        
    setInterval(function(){
        $.fn.yiiGridView.update('tableLaporan', {
                data: $('.search-form form').serialize()
        });
    },3000);
//$('#pie').bind('jqplotDblClick', 
//    function (ev, seriesIndex, pointIndex, data,a) {
////        console.log(ev);
////        console.log(seriesIndex);
////        console.log(pointIndex);
////        console.log(data);
//        console.log(a.axes.xaxis.ticks[(data.data[0])-1]);
////        $.post('{$url}',{test:'test_pie',ruangan_nama:a.options.axes.xaxis.ticks[(data.data[0])-1]}, function(hasil){
////            plot_pie.destroy();
////            plot_pie.series[0].data = hasil.pie;
////            plot_pie.axes.xaxis.ticks = hasil.pie;
////            plot_pie.redraw();
////            console.log(hasil.spedo);
////            setValue_spedo(hasil.spedo);
////        },'json');
//    });
JS;

Yii::app()->clientScript->registerScript('testingkksss',$js, CClientScript::POS_READY)
?>