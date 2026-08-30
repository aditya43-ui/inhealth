<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-info-circled"></i> Informasi <b>MCU Karyawan</b>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $this->breadcrumbs = array(
                    'Informasi MCU Karyawan',
                );

                Yii::app()->clientScript->registerScript('search', "
                            $('#mcukaryawan-info-search').submit(function(){
                                    $.fn.yiiGridView.update('mcukaryawan-info-grid', {
                                            data: $(this).serialize()
                                    });
                                    return false;
                            });
                            ");
                ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>MCU Karyawan</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php
                        $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp', array(
                            'id' => 'mcukaryawan-info-grid',
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
                                    'header' => 'Tanggal Pelaksanaan MCU',
                                    'type' => 'raw',
                                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglhasilpemeriksaanmcu)',
                                ),
                                array(
                                    'header' => 'No Register',
                                    'type' => 'raw',
                                    'value' => '$data->nomorindukpegawai',
                                ),
                                array(
                                    'header' => 'Nama Karyawan',
                                    'type' => 'raw',
                                    'value' => '$data->nama_pegawai',
                                ),
                                array(
                                    'header' => 'Status MCU',
                                    'type' => 'raw',
                                    'value' => function ($data) {
                                        $html = CHtml::link('Belum','javascript:;',array('class'=>'btn btn-danger nohover'));

                                        if (!empty($data->statuspemeriksaan)){
                                            if (strtolower($data->statuspemeriksaan) == 'sudah'){
                                                $html = CHtml::link('Sudah','javascript:;',array('class'=>'btn btn-success nohover'));
                                            }
                                        }
                                        return $html;
                                    },
                                    'htmlOptions' => array('style' => 'text-align: center;'),
                                ),
                                array(
                                    'header' => 'Hasil MCU',
                                    'type' => 'raw',
                                    'value' => function ($data) {
                                        if(!empty($data->kesimpulanmcu_id)){
                                            return CHtml::link("<i class='icon-form-detail'></i>", 'javascript:void(0)', array('onclick' => 'printHasilMCU('.$data->kesimpulanmcu_id.')', "id" => $data->kesimpulanmcu_id, "rel" => "tooltip", "title" => "Klik untuk melihat hasil MCU", "data-placement" => "left"));
                                        }else{
                                            return CHtml::Link("<i class='icon-form-detail'></i>", '', array('disabled' => true, 'style' => 'opacity: 0.3', "class" => "", "rel" => "tooltip", "title" => "Tombol akan aktif jika sudah mengisi kesimpulan dan saran MCU"));
                                        }
                                    },
                                    'htmlOptions' => array('style' => 'text-align: center;')
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

<script type="text/javascript">
    function printHasilMCU(kesimpulanmcu_id){
        window.open("<?php echo $this->createUrl('/mcu/KesimpulanSaran/PrintMcu') ?>&kesimpulanmcu_id=" + kesimpulanmcu_id, "", 'location=_new, width=1024px');
    }
</script>
