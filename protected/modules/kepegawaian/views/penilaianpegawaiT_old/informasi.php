<div class="white-container">
    <legend class="rim2">Informasi <b>Performance Index</b></legend>
    <?php
    $this->breadcrumbs = array(
        'Kppenilaianpegawai Ts' => array('index'),
        'Manage',
    );
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#search-t-form').submit(function(){
            $.fn.yiiGridView.update('penilaianpegawai-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="block-tabel">
        <h6>Tabel <b>Performance Index</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'penilaianpegawai-t-grid',
            'dataProvider' => $model->searchInformasi(),
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-condensed',
            'columns' => array(
                array(
                    'header' => 'No.',
                    'type' => 'raw',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                ),
                'pegawai.nama_pegawai',
                array(
                    'header' => 'tglpenilaian',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglpenilaian)',
                ),
                'periodepenilaian',
                'sampaidengan',
                array(
                    'header' => 'Detail',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align:left;'),
                    'value' => 'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("PenilaianpegawaiT/detail",array("id"=>$data->penilaianpegawai_id)),
                            array("class"=>"", 
                                "target"=>"detail",
                                  "onclick"=>"$(\"#dialogDetail\").dialog(\"open\");",
                                  "rel"=>"tooltip",
                                  "title"=>"Klik untuk melihat details",
                            ))',
                    //                    'value'=>'CHtml::link(\'<i class="icon-eye-open"></i>\',Yii::app()->createUrl(\'remunerasi/PenilaianpegawaiT/detail&id=\'.$data->penilaianpegawai_id))',
                ),
                //		'kesetiaan',
                /*
                    'prestasikerja',
                    'tanggungjawab',
                    'ketaatan',
                    'kejujuran',
                    'kerjasama',
                    'prakarsa',
                    'kepemimpinan',
                    'jumlahpenilaian',
                    'nilairatapenilaian',
                    'performanceindex',
                    'penilaianpegawai_keterangan',
                    'keberatanpegawai',
                    'tanggal_keberatanpegawai',
                    'tanggapanpejabat',
                    'tanggal_tanggapanpejabat',
                    'keputusanatasan',
                    'tanggal_keputusanatasan',
                    'lainlain',
                    'dibuattanggalpejabat',
                    'diterimatanggalpegawai',
                    'diterimatanggalatasan',
                    'penilainama',
                    'penilainip',
                    'penilaipangkatgol',
                    'penilaijabatan',
                    'penilaiunitorganisasi',
                    'pimpinannama',
                    'pimpinannip',
                    'pimpinanpangkatgol',
                    'pimpinanjabatan',
                    'pimpinanunitorganisasi',
                    'create_time',
                    'update_time',
                    'create_loginpemakai_id',
                    'update_loginpemakai_id',
                    'create_ruangan',
                    */
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )); ?>
    </div>
    <fieldset class="box">
        <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'id' => 'search-t-form',
            'type' => 'horizontal',
            'focus' => '#' . CHtml::activeId($model, 'nama_pegawai'),
        )); ?>
        <table style="width: 100%; border: none;">
            <tr>
                <td>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'tglpenilaian', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $model->tglpenilaian = $format->formatDateTimeForUser($model->tglpenilaian);
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglpenilaian',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2'),
                            ));
                            $model->tglpenilaian = $format->formatDateTimeForDb($model->tglpenilaian);
                            ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'periodepenilaian', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $model->periodepenilaian = $format->formatDateTimeForUser($model->periodepenilaian);
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'periodepenilaian',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2'),
                            ));
                            $model->periodepenilaian = $format->formatDateTimeForDb($model->periodepenilaian);
                            ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'sampaidengan', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $model->sampaidengan = $format->formatDateTimeForUser($model->sampaidengan);
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'sampaidengan',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2'),
                            ));
                            $model->sampaidengan = $format->formatDateTimeForDb($model->sampaidengan);
                            ?>
                        </div>
                    </div>
                </td>
                <td>
                    <?php echo $form->textFieldRow($model, 'nama_pegawai', array('class' => 'span3')); ?>
                </td>
            </tr>
        </table>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'name' => 'search')); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/PenilaianpegawaiT/informasi'), array('class' => 'btn btn-default', 'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
        <?php
        $content = $this->renderPartial('kepegawaian.views./tips/informasi', array(), true);
        $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
        ?>
    </fieldset>
    <?php $this->endWidget(); ?>
</div>
<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Details Performance Index',
        'autoOpen' => false,
        'minWidth' => 900,
        'minHeight' => 100,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="detail" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================
?>