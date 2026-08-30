<div class="panel panel-success">
    <div class="panel panel-heading">
        <div class="panel-title"> Tabel <b> Pengadaan </b></div>
    </div>
    <div class="panel-body">
        <div style="float: right">
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-red', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
            echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-success', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
            ?>
        </div>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'type' => 'horizontal',
            'id' => 'penilaian-indikator-m-search',
                ));
        ?>
        <?php echo $form->hiddenField($modDashboard, 'rencanaumumpengadaan_kategori', array('class' => 'span3')); ?>
        <?php echo $form->hiddenField($modDashboard, 'nomor_rup', array('class' => 'span3')); ?>
        <?php echo $form->hiddenField($modDashboard, 'nomor_kontrak', array('class' => 'span3')); ?>
        <?php echo $form->hiddenField($modDashboard, 'nomor_bast', array('class' => 'span3')); ?>
        <?php echo $form->hiddenField($modDashboard, 'bapemeriksaanadmpphp_nomor', array('class' => 'span3')); ?>
        <?php echo $form->hiddenField($modDashboard, 'nomor_notadinaspptk', array('class' => 'span3')); ?>
        <?php echo $form->hiddenField($modDashboard, 'nomor_verifikasi', array('class' => 'span3')); ?>
        <?php echo $form->hiddenField($modDashboard, 'nomor_realisasi', array('class' => 'span3')); ?>
        <?php $this->endWidget(); ?>
        <br>
        <?php
        $this->widget('ext.bootstrap.widgets.BootGroupGridView', array(
            'id' => 'dashboardpengadaan-v-grid',
            'dataProvider' => $modDashboard->searchDashboard(),
            'filter' => $modDashboard,
            'mergeColumns' => array('rencanaumumpengadaan_kategori', 'nomor_rup', 'nomor_kontrak'),
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
            'columns' => array(
                array(
                    'header' => 'No.',
                    'value' => '($this->grid->dataProvider->pagination) ? 
                        ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                        : ($row+1)',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                    'headerHtmlOptions' => array('style' => 'text-align: center',),
                ),
                array(
                    'header' => 'Kategori',
                    'type' => 'raw',
                    'name' => 'rencanaumumpengadaan_kategori',
                    'htmlOptions' => array('style' => 'text-align:left; vertical-align: middle'),
                    'headerHtmlOptions' => array('style' => 'text-align: center',),
                    'filter' => CHtml::activeDropDownList($modDashboard, 'rencanaumumpengadaan_kategori', LookupM::getItems('kategoripengadaan'), array('empty' => '-- Pilih --')),
                    'value' => function($data){
                        return $data->rencanaumumpengadaan_kategori . "<span style='display: none'>".$data->nomor_rup .$data->nomor_kontrak."</span>";
                    },
                ),
                array(
                    'header' => 'RUP', 
                    'type' => 'raw',
                    'name' => 'nomor_rup', 
                    'htmlOptions' => array('style' => 'text-align:left;'),
                    'headerHtmlOptions' => array('style' => 'text-align: center',),
                    'value' => function($data) {
                        return CHtml::link($data->nomor_rup, Yii::app()->createUrl('pengadaan/InformasiRencanaUmum/detail&id=' . $data->rencanaumumpengadaan_id), array(
                            'class' => 'hover',
                            'target' => '_blank',
                            "rel" => "tooltip",
                            "title" => "Klik untuk Melihat Detail Rencana Umum Pengadaan")) . "<br>" .
                        MyFormatter::formatDateTimeForUser($data->tanggal_rup) . "<br>" .
                        MyFormatter::formatUang($data->nominal_rup, "Rp.", 2) . "<span style='display: none'>".$data->rencanaumumpengadaan_kategori. $data->nomor_kontrak."</span>";
                    },
                ),
                array(
                    'header' => 'Kontrak',
                    'type' => 'raw',
                    'name' => 'nomor_kontrak',
                    'htmlOptions' => array('style' => 'text-align:left;'),
                    'headerHtmlOptions' => array('style' => 'text-align: center',),
                    'value' => function($data) {
                        if (!empty($data->suratperjanjiankerja_id)) {
                            $modSPK = SuratperjanjiankerjaT:: model()->findByPk($data->suratperjanjiankerja_id);
                            return CHtml::link($data->nomor_kontrak, Yii::app()->createUrl('pengadaan/suratPerjanjianKerja/index&id=' . $modSPK->persiapanpengadaan_id), array(
                                'class' => 'hover',
                                'target' => '_blank',
                                "rel" => "tooltip",
                                "title" => "Klik untuk Melihat Detail Kontrak")) . "<br>" .
                            MyFormatter::formatDateTimeForUser($data->tanggal_kontrak) . "<br>" .
                            MyFormatter::formatUang($data->nominal_kontrak, "Rp.", 2) . "<span style='display: none'>".$data->rencanaumumpengadaan_kategori. $data->nomor_rup."</span>";
                        } else {
                            return "-";
                        }
                    },
                ),
                array(
                    'header' => 'Serah Terima',
                    'name' => 'nomor_bast',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align:left;'),
                    'headerHtmlOptions' => array('style' => 'text-align: center',),
                    'value' => function($data) {
                        if (!empty($data->baserahterima_id)) {
                            echo CHtml::link($data->nomor_bast, Yii::app()->createUrl('pengadaan/BASerahTerima/detail&suratperjanjiankerja_id=' . $data->suratperjanjiankerja_id . "&baserahterima_id=" . $data->baserahterima_id), array(
                                'class' => 'hover',
                                "target" => "frameST",
                                "onclick" => "$('#dialogST').dialog('open');",
                                "rel" => "tooltip",
                                "title" => "Klik untuk Melihat Detail BA Serah Terima")) . "<br>" .
                            MyFormatter::formatDateTimeForUser($data->tanggal_bast) . "<br>" .
                            MyFormatter::formatUang($data->nominal_bast, "Rp.", 2);
                        } else {
                            echo "-";
                        }
                    },
                ),
                array(
                    'header' => 'Penyerahan <br> Barang / Jasa',
                    'name' => 'nomor_bast',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align:left;'),
                    'headerHtmlOptions' => array('style' => 'text-align: center',), 'value' => function($data) {
                        if (!empty($data->bapenyerahanbarangjasa_id)) {
                            echo CHtml::link($data->nomor_bapbj, Yii::app()->createUrl('pengadaan/BAPenyerahanBarangJasa/detail&bapenyerahanbarangjasa_id=' . $data->bapenyerahanbarangjasa_id), array(
                                'class' => 'hover',
                                "target" => "framePB",
                                "onclick" => "$('#dialogPB').dialog('open');",
                                "rel" => "tooltip",
                                "title" => "Klik untuk Melihat Detail BA Penyerahan Barang / Jasa")) . "<br>" .
                            MyFormatter:: formatDateTimeForUser($data->tanggal_bapbj) . "<br>" .
                            MyFormatter::formatUang($data->nominal_bapbj, "Rp.", 2);
                        } else {
                            echo "-";
                        }
                    },
                ),
                array(
                    'header' => 'PPHP/PjPHP',
                    'name' => 'bapemeriksaanadmpphp_nomor',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align:left;'),
                    'headerHtmlOptions' => array('style' => 'text-align: center',),
                    'value' => function($data) {
                        if (!empty($data->bapemeriksaanadmpphp_id) || !empty($data->bapemeriksaanadmpjphp_id)) {
                            if (!empty($data->bapemeriksaanadmpphp_id)) {
                                if (!empty($data->nominal_pphp)) {
                                    $nominal = MyFormatter::formatUang($data->nominal_pjphp, "Rp.", 2);
                                } else {
                                    $nominal = MyFormatter::formatUang(0, "Rp.", 2);
                                }
                                echo CHtml::link($data->bapemeriksaanadmpphp_nomor, Yii::app()->createUrl('pengadaan/BAPemeriksaanAdmPPHP/detail&suratperjanjiankerja_id=' . $data->suratperjanjiankerja_id . "&bapemeriksaanadmpphp_id=" . $data->bapemeriksaanadmpphp_id), array(
                                    'class' => 'hover',
                                    "target" => "framePB",
                                    "onclick" => "$('#dialogPB').dialog('open');", "rel" => "tooltip",
                                    "title" => "Klik untuk Melihat Detail BA PPHP")) . "<br>" .
                                MyFormatter:: formatDateTimeForUser($data->tanggal_pphp) . "<br>" .
                                $nominal;
                            } else if (!empty($data->bapemeriksaanadmpjphp_id)) {
                                if (!empty($data->nominal_pjphp)) {
                                    $nominal = MyFormatter::formatUang($data->nominal_pjphp, "Rp.", 2);
                                } else {
                                    $nominal = MyFormatter::formatUang(0, "Rp.", 2);
                                }
                                echo CHtml::link($data->bapemeriksaanadmpjphp_nomor, Yii::app()->createUrl('pengadaan/BAPemeriksaanAdmPjPHP/detail&suratperjanjiankerja_id=' . $data->suratperjanjiankerja_id . "&bapemeriksaanadmpjphp_id=" . $data->bapemeriksaanadmpjphp_id), array(
                                    'class' => 'hover',
                                    "target" => "framePB",
                                    "onclick" => "$('#dialogPB').dialog('open');",
                                    "rel" => "tooltip",
                                    "title" => "Klik untuk Melihat Detail BA PjPHP")) . "<br>" .
                                MyFormatter::formatDateTimeForUser($data->tanggal_pjphp) . "<br>" .
                                $nominal;
                            }
                        } else {
                            echo "-";
                        }
                    },
                ),
                array(
                    'header' => 'Nota Dinas',
                    'name' => 'nomor_notadinaspptk',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align:left;'),
                    'headerHtmlOptions' => array('style' => 'text-align: center',),
                    'value' => function($data) {
                        if (!empty($data->nomor_notadinaspptk)) {
                            echo CHtml::link($data->nomor_notadinaspptk, Yii::app()->createUrl('pengadaan/informasiNotadinaspptk/detail&notadinaspptk_id=' . $data->notadinaspptk_id), array(
                                'class' => 'hover',
                                "target" => "_blank",
                                "rel" => "tooltip",
                                "title" => "Klik untuk Melihat Detail Nota Dinas PPTK")) . "<br>" .
                                MyFormatter::formatDateTimeForUser($data->tanggal_notadinaspptk)."<br>".
                            MyFormatter ::formatUang($data->nominal_notadinaspptk, "Rp.", 2);
                        } else {
                            echo "-";
                        }
                    }
                ),
                array(
                    'header' => 'Verifikasi',
                    'type' => 'raw',
                    'name' => 'nomor_verifikasi', 'htmlOptions' => array('style' => 'text-align:left;'),
                    'headerHtmlOptions' => array('style' => 'text-align: center',),
                    'value' => function($data) {
                        if (!empty($data->nomor_verifikasi)) {
                            echo CHtml::link($data->nomor_verifikasi, Yii::app()->createUrl('keuangan/informasiInvoiceTagihan/detail&id=' . $data->invoicemasuk_id), array(
                                'class' => 'hover',
                                "target" => "_blank",
                                "rel" => "tooltip",
                                "title" => "Klik untuk Melihat Detail Invoice")) . "<br>" .
                            MyFormatter::formatDateTimeForUser($data->tanggal_verifikasi) . "<br>" .
                            MyFormatter::formatUang($data->nominal_verifikasi, "Rp.", 2);
                        } else {
                            echo "-";
                        }
                    }
                ),
                array(
                    'header' => 'Realisasi',
                    'name' => 'nomor_realisasi',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align:left;'),
                    'headerHtmlOptions' => array('style' => 'text-align: center',),
                    'value' => function($data) {
                        if (!empty($data->nomor_realisasi)) {
                            echo $data->nomor_realisasi . "<br>" . MyFormatter::formatDateTimeForUser($data->tanggal_realisasi) . "<br>" .
                            MyFormatter ::formatUang($data->nominal_realisasi, "Rp.", 2);
                        } else {
                            echo "-";
                        }
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
    </div>
</div>


<?php
// ===========================Dialog Penelitian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array('id' => 'dialogST',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail BA Serah Terima', 'autoOpen' => false,
        'width' => 1100,
        'height' => 600,
        'resizable' => true, 'scroll' => false,
    ),
));
?>
<iframe src="" name="frameST" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
?>

<?php
// ===========================Dialog Penelitian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPB',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail BA Penyerahan Barang / Jasa',
        'autoOpen' => false,
        'width' => 1100,
        'height' => 600,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="framePB" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
?>
<?php
// ===========================Dialog Penelitian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogND',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Nota Dinas PPTK',
        'autoOpen' => false,
        'width' => 1100,
        'height' => 600,
        'resizable' => true, 'scroll' => false,
    ),
));
?>
<iframe src="" name="frameND" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
?>