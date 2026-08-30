
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
    'id' => 'penilaian-indikator-m-search',
        ));
?>
<?php echo $form->hiddenField($modPemeriksaanLab, 'tgl_pendaftaran', array('class' => 'span3')); ?>
<?php echo $form->hiddenField($modPemeriksaanLab, 'instalasi_nama', array('class' => 'span3')); ?>
<?php echo $form->hiddenField($modPemeriksaanLab, 'pemeriksaanlab_nama', array('class' => 'span3')); ?>
<?php echo $form->hiddenField($modPemeriksaanLab, 'pegawai_id', array('class' => 'span3')); ?>
<?php echo $form->hiddenField($modPemeriksaanLab, 'hasilpemeriksaan', array('class' => 'span3')); ?>
<?php echo $form->hiddenField($modPemeriksaanLab, 'nilairujukan', array('class' => 'span3')); ?>
<?php echo $form->hiddenField($modPemeriksaanLab, 'hasilpemeriksaan_satuan', array('class' => 'span3')); ?>
<?php echo $form->hiddenField($modPemeriksaanLab, 'namapemeriksaandet', array('class' => 'span3')); ?>
<?php $this->endWidget(); ?>
<br>

<?php
$this->widget('ext.bootstrap.widgets.BootGroupGridView', array(
    'id' => 'dashboardpengadaan-v-grid',
    'dataProvider' => $modPemeriksaanLab->searchPemeriksaanLab(!empty($modPendaftaran->pasien_id) ? $modPendaftaran->pasien_id : null),
    'filter' => $modPemeriksaanLab,
    'mergeColumns' => array('tgl_pendaftaran', 'tglhasilpemeriksaanlab', 'instalasi_nama', 'pegawai_id', 'pemeriksaanlab_nama'),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Tgl Pendaftaran / No Pendaftaran',
            'type' => 'raw',
            'name' => 'tgl_pendaftaran',
            'headerHtmlOptions' => array('style' => 'text-align: center',),
            'value' => function($data) {
                return MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran) . "/ <br>" . $data->no_pendaftaran . "<span style='display: none'>" . $data->tgl_pendaftaran . $data->no_pendaftaran . $data->pemeriksaanlab_nama. "</span>";
            },
        ),
        array(
            'header' => 'Tgl Pemeriksaan Lab',
            'type' => 'raw',
            'name' => 'tglhasilpemeriksaanlab',
            'filter' => false,
            'headerHtmlOptions' => array('style' => 'text-align: center',),
            'value' => function($data) {
                return MyFormatter::formatDateTimeForUser($data->tglhasilpemeriksaanlab) . "<span style='display: none'>" . $data->tgl_pendaftaran . $data->no_pendaftaran . $data->pemeriksaanlab_nama . "</span>";
            },
        ),
        array(
            'header' => 'Instalasi / Ruangan',
            'type' => 'raw',
            'name' => 'instalasi_nama',
            'headerHtmlOptions' => array('style' => 'text-align: center',),
            'value' => function($data) {
                return $data->instalasi_nama . "/ <br>" . $data->ruangan_nama . "<span style='display: none'>" . $data->tgl_pendaftaran . $data->no_pendaftaran . $data->pemeriksaanlab_nama . "</span>";
            },
        ),
        array(
            'header' => 'DPJTM',
            'type' => 'raw',
            'name' => 'pegawai_id',
            'headerHtmlOptions' => array('style' => 'text-align: center',),
            'value' => function($data) {
                $modPegawai = PegawaiM::model()->findByPk($data->pegawai_id);
                return $modPegawai->namaLengkap . "<span style='display: none'>" . $data->tgl_pendaftaran . $data->no_pendaftaran . $data->pemeriksaanlab_nama .  "</span>";
            },
        ),
        array(
            'header' => 'Pemeriksaan Laboratorium',
            'name' => 'pemeriksaanlab_nama',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:left;'),
            'headerHtmlOptions' => array('style' => 'text-align: center',),
            'value' => function($data) {
                return $data->pemeriksaanlab_nama;
            }
        ),
        array(
            'header' => 'Detail <br> Pemeriksaan Laboratorium',
            'name' => 'namapemeriksaandet',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:left;'),
            'headerHtmlOptions' => array('style' => 'text-align: center',),
            'value' => function($data) {
                return $data->namapemeriksaandet;
            }
        ),
        array(
            'header' => 'Hasil',
            'name' => 'hasilpemeriksaan',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:left;'),
            'headerHtmlOptions' => array('style' => 'text-align: center',),
            'value' => function($data) {
                return $data->hasilpemeriksaan;
            }
        ),
        array(
            'header' => 'Nilai Rujukan',
            'name' => 'nilairujukan',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:left;'),
            'headerHtmlOptions' => array('style' => 'text-align: center',),
            'value' => function($data) {
                return $data->nilairujukan;
            }
        ),
        array(
            'header' => 'Satuan',
            'name' => 'hasilpemeriksaan_satuan',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:left;'),
            'headerHtmlOptions' => array('style' => 'text-align: center',),
            'value' => function($data) {
                return $data->hasilpemeriksaan_satuan;
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
                        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                        $("table").find("input[type=text]").each(function(){
                            cekForm(this);
                        })
                        $("table").find("select").each(function(){
                            cekForm(this);
                        })
                    }',
));

$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');

$js = <<< JSCRIPT
                        function cekForm(obj)
{
    $("#penilaian-indikator-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#penilaian-indikator-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>