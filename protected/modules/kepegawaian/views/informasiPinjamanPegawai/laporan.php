<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                <i class="entypo-newspaper"></i> Laporan <b>Pinjaman Pegawai</b></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="box">
                            <?php $this->renderPartial('_searchLaporan',array('model'=>$model)); ?>
                        </fieldset>
                    </div>
                </div>								
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Pinjaman Pegawai</b></div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php
                        $this->breadcrumbs=array(
                                'Kppenggajianpeg Ts'=>array('index'),
                                'Manage',
                        );
                        Yii::app()->clientScript->registerScript('search', "
                        $('.search-button').click(function(){
                                $('.search-form').toggle();
                                return false;
                        });
                        $('#laporan-search').submit(function(){
                                $.fn.yiiGridView.update('kppenggajianpeg-t-grid', {
                                        data: $(this).serialize()
                                });
                                return false;
                        });
                        ");

                        $this->widget('bootstrap.widgets.BootAlert'); ?>
                        <div class="block-tabel">
                            <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                                'id'=>'kppenggajianpeg-t-grid',
                                'dataProvider'=>$model->searchLaporan(),
                                'template'=>"{summary}\n{items}\n{pager}",
                                'itemsCssClass'=>'table table-bordered table-striped table-condensed',
                                'columns'=>array( 
                                        array(
                                                'header'=>'NIP',
                                                'name'=>'nomorindukpegawai',
                                                'value'=>'$data->nomorindukpegawai',
                                        ),
                                        array(
                                                'header'=>'Nama Pegawai',
                                                'name'=>'nama_pegawai',
                                                'value'=>'$data->gelardepan." ".$data->nama_pegawai',
                                        ),
                                        'nopinjam',
                                        array(
                                                'name'=>'tglpinjampeg',
                                                'value'=>'date("d/m/Y H:i:s",strtotime($data->tglpinjampeg))',
                                        ),
                                        array(
                                                'name'=>'tgljatuhtempo',
                                                'value'=>'date("d/m/Y H:i:s",strtotime($data->tglpinjampeg))',
                                        ),
                                        array(
                                                'header'=>'Rincian Pinjaman',
                                                'type'=>'raw',
                                                'value'=>'CHtml::link("<i class=\'icon-form-detail\'></i>",Yii::app()->createUrl(\'kepegawaian/informasiPinjamanPegawai/detailPinjaman&pinjamanpeg_id=\'.$data->pinjamanpeg_id),array("rel"=>"tooltip","title"=>"Klik untuk Detail Pinjaman","target"=>"iframe", "onclick"=>"$(\"#dialogDetailsPinjaman\").dialog(\"open\");", ))',
                                                'htmlOptions'=>array('style'=>'text-align:left; width:40px'),
                                                ),
                                ),
                                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                            )); ?>
                        </div>
                    </div>
                </div>	
                <?php 
                    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintLaporan');
                    $url = "";//?
                ?>
                <div class="form-actions">
                    <?php
                        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'));
                        $content = $this->renderPartial('../tips/laporan_presensi',array(),true);
                        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>
                </div>
            </div>
        </div>
    </div>
</div>
       
<?php
$jsx = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#laporan-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$jsx,CClientScript::POS_HEAD);                        
?> 
<?php 
Yii::app()->clientScript->registerScript('test','
function resizeIframe(obj){
       obj.style.height = obj.contentWindow.document.body.scrollHeight + "px";
    }    
function setType(obj, index){
    $("#type").val($(obj).attr("type"));
    $(obj).parents("ul").find("li").each(function(){
        $(this).removeClass("active");
    });
    $(obj).addClass("active");
    $.fn.yiiGridView.update("laporan-grid", {
            data: $(this).serialize()
    });
    if (index==1) {
        index="batang";
    } else if (index==2) {
        index="pie";
    } else if (index==3) {
        index="garis";
    }
    $("#Grafik").attr("src","'.$url.'"+$("#laporan-search").serialize()+"&type="+index);
    return false;
}
', CClientScript::POS_HEAD);

?>

<?php
// ===========================Dialog Details Penggajian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'dialogDetailsPinjaman',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Rincian Pinjaman Pegawai',
                        'autoOpen'=>false,
                        'width'=>1000,
                        'height'=>500,
                        'resizable'=>true,
                        'scroll'=>false    
                         ),
                    ));
?>
<iframe src="" name="iframe" style="width:100%; height: 98%;"></iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details Penggajian================================
?>

