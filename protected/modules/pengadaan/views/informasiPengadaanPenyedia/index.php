<?php
Yii::app()->clientScript->registerScript('search', "
    $('#persiapanpengadaan-m-search').submit(function(){
        $.fn.yiiGridView.update('persiapanpengadaan-m-grid', {
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
                <div class="panel-title">Informasi <strong>Pengadaan Penyedia </strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Informasi <strong>Pengadaan Penyedia </strong></div>
                    </div>
                    <div class="panel-body overflow-x" >
                        <?php
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'persiapanpengadaan-m-grid',
                            'dataProvider' => $model->searchInformasiPengadaanPenyedia(),
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                            'columns' => array(
                                array(
                                    'header'=>'No.',
                                    'value' => '($this->grid->dataProvider->pagination) ? 
                                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                    : ($row+1)',
                                    'type'=>'raw',
                                    'htmlOptions'=>array('style'=>'text-align:left;'),
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Tanggal Diumumkan',
                                    'type' => 'raw', 
                                    'value' => function($data){
                                        return date("d M Y", strtotime($data->diumumkan_tanggal));
                                    }
                                ),
                                array(
                                    'header'=>'Nomor Pekerjaan',
                                    'type'=>'raw',
                                    'value'=>function($data) {
                                        if(!empty($data)){
                                            return CHtml::link($data->rencanaumumpengadaan_nomor, 
                                                    Yii::app()->createUrl('pengadaan/'.Yii::app()->controller->id.'/detail&id='.$data->persiapanpengadaan_id),
                                                    array(
                                                        'class'=>'hover',
                                                        "rel"=>"tooltip",
                                                        "target"=>"iframeDetail", 
                                                        "onclick"=>"$('#dialogDetail').dialog('open');",
                                                        "title"=>"Klik untuk Melihat Detail Persiapan Pengadaan"));
                                        }else{
                                            return '-';
                                        }
                                    },
                                    'htmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                ),
                                array(
                                    'header'=>'Nama Pekerjaan',
                                    'type'=>'raw',
                                    'value'=>function($data) {
                                        if(!empty($data->nama_pekerjaan)){
                                            return $data->nama_pekerjaan;
                                        }else{
                                            return '-';
                                        }
                                    },
                                    'htmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                ),
                                array(
                                    'header'=>'Ajukan Penawaran',
                                    'type'=>'raw',
                                    'value'=>function($data) {
                                        if(!empty($data)){
                                            /*return CHtml::link("<i class='fa fa-cloud-upload'></i>", 
                                                Yii::app()->createUrl('pengadaan/informasiPengadaanPenyedia/penawaran&id='.$data->persiapanpengadaan_id),
                                                array(
                                                    'class'=>'hover',
                                                    "rel"=>"tooltip",
                                                    "target"=>"iframeDetail", 
                                                    "onclick"=>"$('#dialogDetail').dialog('open');",
                                                    "title"=>"Klik untuk Mengajukan Penawaran"));*/
                                            return CHtml::Link("<i class='fa fa-cloud-upload'></i>","javascript:void(0);",
                                                array("class"=>"", 
                                                    "onclick"=>"$('#persiapanpengadaan_id').val(".$data->persiapanpengadaan_id."); $('#logindialog').dialog('open');",
                                                    "rel"=>"tooltip",
                                                    "title"=>"Klik untuk Mengajukan Penawaran",
                                                ));
                                        }else{
                                            return '-';
                                        }
                                    },
                                    'htmlOptions'=>array(
                                        'style'=>'text-align: center; font-size:14px;',
                                    ),
                                    'headerHtmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                ),
                            ),
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                        ));
                        ?>                            
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
$this->renderPartial($this->path_view . '_jsFunction', array(
    'model' => $model,
));
?>
<?php
$this->renderPartial($this->path_view . '_formLogin', array(
    'id' => 'index' //untuk param pembeda antara index dan detail
));
?>

<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    
    $js = <<< JSCRIPT
				function cekForm(obj){
					$("#persiapanpengadaan-m-search :input[name='"+ obj.name +"']").val(obj.value);
				}
				function print(caraPrint){
					window.open("${urlPrint}/"+$('#persiapanpengadaan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
				}
JSCRIPT;
                Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
                ?>
<?php
// ===========================Dialog Details Rencana Umum Pengadaan=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogDetail',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Detail Rencana Umum Pengadaan',
    'autoOpen'=>false,
    'width'=>1070,
    'height'=>650,
    'resizable'=>true,
    'scroll'=>false,
    ),
));
?>
<iframe src="" name="iframeDetail" width="100%" height="100%">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Rencana Umum Pengadaan================================
?>