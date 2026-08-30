<?php
Yii::app()->clientScript->registerScript('search', "
    $('#notadinaspptk-v-search').submit(function(){
        $.fn.yiiGridView.update('notadinaspptk-v-grid', {
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
                <div class="panel-title">Informasi <strong>Nota Dinas PPTK</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Informasi <strong>Nota Dinas PPTK</strong></div>
                    </div>
                    <div class="panel-body overflow-x" >
                        <?php
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'notadinaspptk-v-grid',
                            'dataProvider' => $model->searchInformasi(),
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                            'replaceUrl' => true,
                            'columns' => array(
                                array(
                                    'header' => 'No.',
                                    'value' => '($this->grid->dataProvider->pagination) ? 
                                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                    : ($row+1)',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align:left;'),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Nomor&nbsp;dan&nbsp;Tanggal <br>',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data)) {
                                            return CHtml::link($data->notadinaspptk_nomor . '<br>' . date('d M Y', strtotime($data->notadinaspptk_tanggal)), Yii::app()->createUrl('pengadaan/InformasiNotadinaspptk/detail&notadinaspptk_id=' . $data->notadinaspptk_id), array(
                                                        'class' => 'hover',
                                                        "rel" => "tooltip",
                                                        "title" => "Klik untuk Melihat Detail Nota Dinas PPTK"));
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
                                    'header' => 'Nomor Nota Dinas',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data->nomor_notadinas)) {
                                            return $data->nomor_notadinas;
                                        } else {
                                            return '-';
                                        }
                                    },
                                    'htmlOptions' => array( 'style' => 'text-align: center', ),
                                    'headerHtmlOptions' => array( 'style' => 'text-align: center',),
                                ),
                                array(
                                    'header' => 'Nama Pekerjaan',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        $modNota = NotadinaspptkT::model()->findByPk($data->notadinaspptk_id);
                                        if (!empty($modNota->paket_pekerjaan)) {
                                            return $modNota->paket_pekerjaan;
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
                                    'header' => 'Total',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data->jumlah_diterima)) {
                                            return 'Rp ' . number_format($data->jumlah_diterima, 2, ',', '.');
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
                                    'header' => 'Tahun Anggaran',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        $modNota = NotadinaspptkT::model()->findByPk($data->notadinaspptk_id);
                                        if (!empty($modNota->suratperjanjiankerja_id)) {
                                            $modInfo = DaftarnomorNotadinaspptkV::model()->findByAttributes(array('nomor_id' => $modNota->suratperjanjiankerja_id, 'kategori_pengadaan' => 'Penyedia'));
                                        } else {
                                            $modInfo = DaftarnomorNotadinaspptkV::model()->findByAttributes(array('nomor_id' => $modNota->rencanaumumpengadaan_id, 'kategori_pengadaan' => 'Swakelola'));
                                        }

                                        if (!empty($modInfo->tahun)) {
                                            echo $modInfo->tahun;
                                        } else {
                                            echo '-';
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
                                    'header' => 'PPTK',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data->pegpptk)) {
                                            return $data->pegpptk;
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
                                    'header' => 'PJK',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data->pegpjk)) {
                                            return $data->pegpjk;
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
                                    'header' => 'PPK',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data->pegppk)) {
                                            return $data->pegppk;
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
                                    'header' => 'Ubah',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        $cekLogin = Yii::app()->user->getState('pegawai_id');
                                        $modInvoice = InvoicemasukT::model()->findByAttributes(array('notadinaspptk_id' => $data->notadinaspptk_id));
                                        
                                        if (!empty($data)) {
                                            if (!empty($modInvoice)) {
                                                return "<span style='font-size:15px;'><i class='entypo-pencil'></i></span>";
                                            } else {
                                                return CHtml::link("<span style='font-size:15px;'><i class='entypo-pencil'></i></span>", Yii::app()->createUrl('pengadaan/NotadinaspptkT/index&notadinaspptk_id=' . $data->notadinaspptk_id . '&ubah=1'), array(
                                                            'class' => 'hover',
                                                            "rel" => "tooltip",
                                                            "data-placement" => "left",
                                                            "title" => "Klik untuk Mengubah Nota Dinas PPTK"));
                                            }
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
                                    'header' => 'Cetak <br> Nota&nbsp;Dinas',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        $cekLogin = Yii::app()->user->getState('pegawai_id');
                                        if (!empty($data)) {

                                            return CHtml::link('<span style="font-size:15px;"><i class="entypo-print"></i></span>', '#', array(
                                                        'class' => 'hover',
                                                        "rel" => "tooltip",
                                                        "data-placement" => "left",
                                                        "title" => "Klik untuk Cetak Nota Dinas",
                                                        'onclick' => "window.open('" . $this->createUrl('printNotadinas', array('id' => $data->notadinaspptk_id)) . "', 'printwin', 'left=100,top=100,width=790,height=1120')"
                                            ));
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
                                    'header' => 'Cetak Uraian',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data)) {

                                            return CHtml::link('<span style="font-size:15px;"><i class="entypo-print"></i></span>', '#', array(
                                                        'class' => 'hover',
                                                        "rel" => "tooltip",
                                                        "data-placement" => "left",
                                                        "title" => "Klik untuk Cetak Uraian",
                                                        'onclick' => "window.open('" . $this->createUrl('printUraian', array('id' => $data->notadinaspptk_id)) . "', 'printwin', 'left=100,top=100,width=1120,height=790')"
                                            ));
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
                        <?php
                        $this->renderPartial('_search', array(
                            'model' => $model,
                        ));
                        ?>
                    </div>
                </div>								
            </div>
        </div>
    </div>
</div>        
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');

$js = <<< JSCRIPT
    function cekForm(obj){
        $("#notadinaspptk-v-search :input[name='"+ obj.name +"']").val(obj.value);
    }
    function print(caraPrint){
        window.open("${urlPrint}/"+$('#notadinaspptk-v-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=800px, height=800');
    }
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>