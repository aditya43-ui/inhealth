<?php
/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 */
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#pengadaanlelang-r-search').submit(function(){
            $.fn.yiiGridView.update('pengadaanlelang-r-grid', {
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
                <div class="panel-title">Informasi <strong> Pengadaan Lelang </strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong> Pengadaan Lelang  </strong></div>
                    </div>
                    <div class="panel-body overflow-x" >
                        <?php
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'pengadaanlelang-r-grid',
                            'replaceUrl' => true,
                            'dataProvider' => $model->searchInformasiPengadaanLelang(),
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
                                ),
                                array(
                                    'header' => 'Nomor dan Tanggal Persiapan Pengadaan',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data)) {
                                            return CHtml::link($data->persiapanpengadaan_nomor. '<br>' . date("d M Y", strtotime($data->persiapanpengadaan_tanggal)), Yii::app()->createUrl('pengadaan/informasiPengadaanLelang/detailPersiapan&id=' . $data->persiapanpengadaan_id), array(
                                                        'class' => 'hover',
                                                        "rel" => "tooltip",
                                                        "target"=>"iframeDetail", 
                                                        "onclick"=>"$('#dialogDetail').dialog('open');",
                                                        "title" => "Klik untuk Melihat Detail Persiapan Pengadaan"));
                                        } else {
                                            return '-';
                                        }
                                    },
                                ),
                                array(
                                    'header' => 'Nama Pekerjaan',
                                    'value' => '$data->rencanaumumpengadaan->nama_pekerjaan',
                                ),
                                array(
                                    'header' => 'Pagu',
                                    'value' => function($data){
                                        echo 'Rp'.number_format($data->rencanaumumpengadaan->total_pagu, 0, "", ".");
                                    }
                                ),
                                array(
                                    'header' => 'Tahun Anggaran',
                                    'value' => '$data->rencanaumumpengadaan->rencanaumumpengadaan_tahun',
                                ),
                                array(
                                    'header' => 'Tahun Anggaran',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data->rencanaumumpengadaan->periodeanggaran_id)) {
                                            $periodeanggaran = PeriodeanggaranK::model()->findByPk(($data->rencanaumumpengadaan->periodeanggaran_id));
                                            return $periodeanggaran->tahunanggaran . " - " . $periodeanggaran->anggaran_nama;
                                        } else {
                                            return '-';
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Detail',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data)) {
                                            return CHtml::link("<span style='font-size:17px'> <i class ='fa fa-file-text'> </i></span>", Yii::app()->createUrl('pengadaan/informasiPengadaanLelang/detail&id=' . $data->persiapanpengadaan_id), array(
                                                        'class' => 'hover',
                                                        "rel" => "tooltip",
                                                        "title" => "Klik untuk Melihat Detail Persiapan Pengadaan"));
                                        } else {
                                            return '-';
                                        }
                                    },
                                ),
                                
                                        
                            ),
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                        ));
                        
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $js = <<< JSCRIPT
                                function cekForm(obj){
                                        $("#informasiae-r-search :input[name='"+ obj.name +"']").val(obj.value);
                                }
                                function print(caraPrint){
                                        window.open("${urlPrint}/"+$('#informasiae-r-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
                                }
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="">
                            <?php 
                                $this->renderPartial($this->path_view.'_search', array('model' => $model))
                            ?>
                        </fieldset>
                    </div>
                </div>	
            </div>
        </div>
    </div>
</div>

<?php
// ===========================Dialog Details Rencana Umum Pengadaan=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogDetail',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Detail Persiapan Pengadaan',
    'autoOpen'=>false,
    'width'=>1000,
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