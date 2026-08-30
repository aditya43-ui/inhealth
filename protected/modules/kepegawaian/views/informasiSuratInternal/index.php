<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-info-circled"></i> Informasi <b>Pencatatan Surat Internal</b>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $this->breadcrumbs = array(
                    'Informasi Pencatatan Surat Internal',
                );

                Yii::app()->clientScript->registerScript('search', "
                            $('#suratinternal-info-search').submit(function(){
                                    $.fn.yiiGridView.update('suratinternal-info-grid', {
                                            data: $(this).serialize()
                                    });
                                    return false;
                            });
                            ");
                ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Pencatatan Surat Internal</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php
                        $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp', array(
                            'id' => 'suratinternal-info-grid',
                            'dataProvider' => $model->searchInformasi(),
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                            'columns' => array(
                                array(
                                    'header' => 'No.',
                                    'type' => 'raw',
                                    'value' => '$row+1',
                                ),
                                array(
                                    'header' => 'Tanggal Surat',
                                    'type' => 'raw',
                                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglsurat)',
                                ),
                                array(
                                    'header' => 'Jenis Surat',
                                    'type' => 'raw',
                                    'value' => '$data->jenissurat',
                                ),
                                array(
                                    'header' => 'Nomor Surat',
                                    'type' => 'raw',
                                    'value' => '$data->nomorsurat',
                                ),
                                array(
                                    'header' => 'Tujuan',
                                    'type' => 'raw',
                                    'value' => '$data->tujuansurat',
                                ),
                                array(
                                    'header' => 'Asal',
                                    'type' => 'raw',
                                    'value' => '$data->asalsurat',
                                ),
                                array(
                                    'header' => 'Judul/ Perihal',
                                    'type' => 'raw',
                                    'value' => '(!empty($data->judul) ? $data->judul : $data->perihal)',
                                ),
                                array(
                                    'header' => 'Dokumen',
                                    'type' => 'raw',
                                    'value' => function ($data){
                                        if(!empty($data->dokumen)){
                                            return CHtml::link("<i class='icon-file-silver'></i>", Yii::app()->createUrl('kepegawaian/InformasiSuratInternal/download', array("suratinternal_id"=>$data->suratinternal_id)), array("id" => $data->suratinternal_id, "rel" => "tooltip", "title" => "Klik untuk melihat dokumen", "data-placement" => "left"));
                                        }else{
                                            return CHtml::Link("<i class='icon-file-silver'></i>", '', array('disabled' => true, 'style' => 'opacity: 0.3', "class" => "", "rel" => "tooltip", "title" => "Tombol akan aktif jika sudah mengisi pencatatan surat internal"));
                                        }
                                    },
                                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;')
                                ),
                                array(
                                    'header' => 'Status',
                                    'type' => 'raw',
                                    'value' => function ($data) {
                                        $html = CHtml::link('Proses','javascript:;',array('class'=>'btn btn-blue nohover'));;

                                        if (!empty($data->statussurat)){
                                            if ($data->statussurat == 'Selesai'){
                                                $html = CHtml::link('Selesai','javascript:;',array('class'=>'btn btn-success nohover'));
                                            }
                                        }
                                        return $html;
                                    },
                                    'htmlOptions' => array('style' => 'text-align: center;'),
                                ),
                                array(
                                    'header' => 'Detail',
                                    'type' => 'raw',
                                    'value' => function ($data) {
                                        return CHtml::link('<u><i class="icon-form-detail"></i></u>', Yii::app()->controller->createUrl('rincian', array('suratinternal_id' => $data->suratinternal_id)), array(
                                            'target' => 'frameRincian',
                                            'onclick' => '$("#dialogRincian").dialog("open");',
                                            'data-toggle' => 'tooltip',
                                            'title' => 'Klik untuk Rincian Perbaikan',
                                        ));
                                    },
                                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                ),
                            ),
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                        )); ?>
                    </div>
                </div>

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-search"></i> Pencarian
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php $this->renderPartial($this->path_view . '_search', array('model' => $model)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// ===========================Dialog=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRincian',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Pencatatan Surat Internal',
        'autoOpen' => false,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="frameRincian" style="width: 100%; height: 100%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog================================
?>