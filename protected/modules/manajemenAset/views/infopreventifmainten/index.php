<?php

Yii::app()->clientScript->registerScript('search', "
    $('#preventifmaintenance-r-search').submit(function(){
        $.fn.yiiGridView.update('tabel-preventif', {
            data: $(this).serialize()
        });
        return false;
    });
");

$this->widget('bootstrap.widgets.BootAlert');

?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title"><i class="entypo-info-circled"></i> Preventive Maintenance</div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-credit-card"></i> Preventive Maintenance</div>
                    </div>
                    <div class="panel-body overflow-x" >
                        <div class="block-tabel">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                        'id'=>'tabel-preventif',
                        'dataProvider'=>$model->searchInformasi(),
                        'filter'=>$model,
                        'template'=>"{summary}\n{items}\n{pager}",
                        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                        'columns'=>array(
                                array(
                                    'header'=>'',
                                    'value' => function($data){
                                        echo "<a id='show' class='btn btn-xs btn-primary' onclick='myFunction2(".$data->prevmainten_id.")'><i class='icon-white icon-plus' style='margin-top: -2px;'></i></a>";
                                    },
                                    'type'=>'raw',
                                    'htmlOptions'=>array('style'=>'text-align:right;'),
                                ),
                                array(
                                    'header'=>'No',
                                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                                    'type'=>'raw',
                                    'htmlOptions'=>array('style'=>'text-align:center;'),
                                ),
                                array(
                                    'header' => 'Frekuensi',
                                    'value' => function($data){
                                            $cekPrev = PrevmaintenT::model()->findByAttributes(array('prevmainten_id'=>$data->prevmainten_id));
                                            echo $cekPrev->frekuansi_prev." ".$cekPrev->frekuensi_jml_prev." ".$cekPrev->frekuensi_sat_prev;
                                    },
                                    'htmlOptions'=>array('style'=>'text-align:center;'),
                                ),
                                array(
                                    'header'=>'Checklist',
                                    'value'=>'$data->getCeklis($data->prevmainten_id,$data)',
                                ),                                
                                array(
                                    'header' => 'Lokasi',
                                    'value' => function($data){
                                            $cekPeralatan = InvperalatanT::model()->findByAttributes(array('invperalatan_id'=>$data->invperalatan_id));
                                            $cekRuangan = RuanganM::model()->findByAttributes(array('ruangan_id'=>$cekPeralatan->ruangan_id));
                                            echo $cekRuangan->ruangan_nama;
                                    },
                                    'htmlOptions'=>array('style'=>'text-align:center;'),
                                ),                     
                                array(
                                    'header'=>'Nama Aset',
                                    'value' => '$data->invperalatan_namabrg',
                                    'htmlOptions'=>array('style'=>'text-align:center;'),
                                ),
                                array(
                                    'header'=>'No. Aset',
                                    'value' => '$data->invperalatan_kode',
                                    'htmlOptions'=>array('style'=>'text-align:center;'),
                                ),
                                array(
                                    'header'=>'Tanggal Pemeliharaan',
                                    'value' => function($data){
                                        $format = new MyFormatter;
                                        $cekInfoPrev = InfoprevmaintenV::model()->findByAttributes(array('prevmainten_id'=>$data->prevmainten_id));
                                        echo $cekInfoPrev->tglprevmainten = $format->formatDateTimeForUser($cekInfoPrev->tglprevmainten);
                                    },
                                    'htmlOptions'=>array('style'=>'text-align:center;'),
                                ),
                                array(
                                    'header'=>'Keterangan',
                                    'value' => '$data->invperalatan_ket',
                                    'htmlOptions'=>array('style'=>'text-align:center;'),
                                ),
                                array(
                                    'header'=>'Skip / WO',
                                    'value'=>'$data->getSkipWO($data->prevmainten_id,$data)',
                                    'htmlOptions'=>array('style'=>'text-align:center;'),
                                ),
                                array(
                                    'header'=>'Keterangan Skip',
                                    'value'=>'$data->getKetSkip($data->prevmainten_id,$data)',
                                    
                                ),  
                            ),
                            'afterAjaxUpdate'=>'function(id, data){
                                jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                                $("table").find("input[type=text]").each(function(){
                                        cekForm(this);
                                });
                                 $("table").find("select").each(function(){
                                        cekForm(this);
                                });
                                $(".numbers-only").keyup(function() {
                                        setNumbersOnly(this);
                                });
                                $(".custom-only").keyup(function() {
                                        setNumbersOnly(this);
                                });
                            }',
                        )); ?>
                </div>
                    </div>
                </div>							
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="">
                            <?php $this->renderPartial($this->path_view.'_search',array(
                                    'model'=>$model,
                            )); ?>
                        </fieldset>
                    </div>
                </div>								
            </div>
        </div>
    </div>
</div>        
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
$url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);

?>
<?php 
// Dialog untuk Skip =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogSkip',
        'options'=>array(
                'title'=>'Form Skip',
                'autoOpen'=>false,
                'modal'=>true,
                'minWidth'=>980,
                'minHeight'=>250,
                'resizable'=>true,
        ),
));
?>
<iframe src="" name="iframeSkip" width="100%" height="250">
</iframe>

<?php
$this->endWidget();
//========= end Skip =============================
?>

<?php 
// Dialog untuk Work Order =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogWO',
        'options'=>array(
                'title'=>'Form Work Order',
                'autoOpen'=>false,
                'modal'=>true,
                'minWidth'=>1100,
                'minHeight'=>450,
                'resizable'=>true,
        ),
));
?>
<iframe src="" name="iframeWO" width="100%" height="500">
</iframe>

<?php
$this->endWidget();
//========= end Work Order =============================
?>
<script type="text/javascript">
function myFunction2(prevmainten_id) {
    if($(".ceklis"+prevmainten_id).css('display') == 'none')
    {
        $(".ceklis"+prevmainten_id).show();
    }else{
        $(".ceklis"+prevmainten_id).hide();
    }
}
</script>