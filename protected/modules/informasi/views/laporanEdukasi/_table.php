<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Edukasi</b>
        </div>
    </div>
    <div class="panel-body">
        <style>
            .grid-view+.grid-view {
                margin-top: 10px !important;
            }
        </style>

        <?php
        $tmp = 1;
        $triwulan = 1;
        for ($i = 1; $i <= 12; $i++) {

            if ($tmp == 1) {
                echo '<div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
<i class="glyphicon glyphicon-file"></i> Laporan <b>Pendidikan Pasien & Keluarga ' . Yii::app()->user->getState('nama_rumahsakit') . ' TRIWULAN ' . $triwulan . '</b></div>
            </div>
            <div class="panel-body">';
                $rekap = $triwulan;
                $triwulan++;
            }
            if ($tmp <= 3) {
                $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
                $data = $model->search($i);
                $template = "{summary}\n{items}\n{pager}";
                $sort = true;
                $kaset = 0;
                $poster = 0;
                $jumlah = 0;
                $metode_ceramah = 0;
                $metode_demonstrasi = 0;
                $metode_diskusi = 0;
                $metode_wawancara = 0;

                foreach ($data->data as $item) {
                    $metode_ceramah += $item->metode_ceramah;
                    $metode_demonstrasi += $item->metode_demonstrasi;
                    $metode_diskusi += $item->metode_diskusi;
                    $metode_wawancara += $item->metode_wawancara;
                }
                $jumlah = $metode_ceramah + $metode_demonstrasi + $metode_diskusi + $metode_wawancara;
        ?>
                <?php
                $this->widget($table, array(
                    'id' => 'tableInformasi' . $i,
                    'dataProvider' => $data,
                    'enableSorting' => $sort,
                    'template' => $template,
                    'mergeColumns' => array('bulanedukasi'),
                    'extraRowColumns' => array('bulanedukasi'),
                    'itemsCssClass' => 'table table-bordered datatable',
                    'columns' => array(
                        array(
                            'header' => 'Bulan',
                            'name' => 'bulanedukasi',
                            'type' => 'raw',
                            'value' => function ($data) {

                                if (!empty($data->bulanedukasi)) {
                                    return "Bulan: " . MyFormatter::getMonthId($data->bulanedukasi);
                                } else {
                                    return "-";
                                }
                            },
                            'footerHtmlOptions' => array('colspan' => 2, 'style' => 'text-align:right;'),
                            'footer' => '<b>Jumlah</b>',
                            // 'visible'=>false,
                        ),
                        array(
                            'header' => 'Topik Penyuluhan',
                            'type' => 'raw',
                            'name' => 'topikedukasi',
                            'value' => function ($data) {

                                if (!empty($data->topikedukasi)) {
                                    return $data->topikedukasi;
                                } else {
                                    return "-";
                                }
                            },
                        ),
                        array(
                            'header' => 'Pemasangan Poster',
                            'value' => function ($data) {

                                return "-";
                            },
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'footer' => number_format($poster, 0, "", "."),
                            'footerHtmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        array(
                            'header' => 'Pemutaran Kaset',
                            'value' => function ($data) {

                                return "-";
                            },
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'footer' => number_format($kaset, 0, "", "."),
                            'footerHtmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        array(
                            'header' => 'Ceramah',
                            'name' => 'metode_ceramah',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data->metode_ceramah)) {
                                    return number_format($data->metode_ceramah, 0, "", ".");
                                } else {
                                    return "-";
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'footer' => 'sum(metode_ceramah)',
                            'footerHtmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        array(
                            'header' => 'Demonstrasi',
                            'name' => 'metode_demonstrasi',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data->metode_demonstrasi)) {

                                    return $data->metode_demonstrasi;
                                } else {
                                    return "-";
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'footer' => 'sum(metode_demonstrasi)',
                            'footerHtmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        array(
                            'header' => 'Diskusi Kelompok',
                            'name' => 'metode_diskusi',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data->metode_diskusi)) {

                                    return $data->metode_diskusi;
                                } else {
                                    return "-";
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'footer' => 'sum(metode_diskusi)',
                            'footerHtmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        array(
                            'header' => 'Tatap Muka',
                            'name' => 'metode_wawancara',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data->metode_wawancara)) {
                                    return $data->metode_wawancara;
                                } else {
                                    return "-";
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'footer' => 'sum(metode_wawancara)',
                            'footerHtmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        array(
                            'header' => 'Jumlah',
                            'value' => function ($data) {

                                return "-";
                            },
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'footer' => number_format($jumlah, 0, "", "."),
                            'footerHtmlOptions' => array('style' => 'text-align:right;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
        $("table").find("input[type=text]").each(function(){
            cekForm(this);
        })
    }',
                ));

                if ($tmp == 3) {
                    $tmp = 1;

                    $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
                    $data = $model->searchRekap($rekap);
                    $template = "{summary}\n{items}\n{pager}";
                    $sort = true;
                    $kaset = 0;
                    $poster = 0;
                    $jumlah = 0;
                    $metode_ceramah = 0;
                    $metode_demonstrasi = 0;
                    $metode_diskusi = 0;
                    $metode_wawancara = 0;

                    foreach ($data->data as $item) {
                        $metode_ceramah += $item->metode_ceramah;
                        $metode_demonstrasi += $item->metode_demonstrasi;
                        $metode_diskusi += $item->metode_diskusi;
                        $metode_wawancara += $item->metode_wawancara;
                    }
                    $jumlah = $metode_ceramah + $metode_demonstrasi + $metode_diskusi + $metode_wawancara;
                ?>
        <?php
                    $this->widget($table, array(
                        'id' => 'tableRekap' . $triwulan,
                        'dataProvider' => $data,
                        'enableSorting' => $sort,
                        'template' => $template,
                        'itemsCssClass' => 'table table-bordered datatable',
                        'columns' => array(
                            array(
                                'header' => 'No.',
                                'value' => '$row+1',
                                'footerHtmlOptions' => array('colspan' => 3, 'style' => 'text-align:right;'),
                                'footer' => '<b>Jumlah</b>',
                            ),
                            array(
                                'header' => 'Topik Penyuluhan',
                                'type' => 'raw',
                                'name' => 'topikedukasi',
                                'value' => function ($data) {

                                    if (!empty($data->topikedukasi)) {
                                        return $data->topikedukasi;
                                    } else {
                                        return "-";
                                    }
                                },
                            ),
                            array(
                                'header' => 'Topik Penyuluhan',
                                'type' => 'raw',
                                'name' => 'topikedukasi',
                                'value' => function ($data) {

                                    if (!empty($data->topikedukasi)) {
                                        return $data->topikedukasi;
                                    } else {
                                        return "-";
                                    }
                                },
                            ),
                            array(
                                'header' => 'Pemasangan Poster',
                                'value' => function ($data) {

                                    return "-";
                                },
                                'htmlOptions' => array('style' => 'text-align: right;'),
                                'footer' => number_format($poster, 0, "", "."),
                                'footerHtmlOptions' => array('style' => 'text-align:right;'),
                            ),
                            array(
                                'header' => 'Pemutaran Kaset',
                                'value' => function ($data) {

                                    return "-";
                                },
                                'htmlOptions' => array('style' => 'text-align: right;'),
                                'footer' => number_format($kaset, 0, "", "."),
                                'footerHtmlOptions' => array('style' => 'text-align:right;'),
                            ),
                            array(
                                'header' => 'Ceramah',
                                'name' => 'metode_ceramah',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    if (!empty($data->metode_ceramah)) {
                                        return number_format($data->metode_ceramah, 0, "", ".");
                                    } else {
                                        return "-";
                                    }
                                },
                                'htmlOptions' => array('style' => 'text-align: right;'),
                                'footer' => 'sum(metode_ceramah)',
                                'footerHtmlOptions' => array('style' => 'text-align:right;'),
                            ),
                            array(
                                'header' => 'Demonstrasi',
                                'name' => 'metode_demonstrasi',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    if (!empty($data->metode_demonstrasi)) {

                                        return $data->metode_demonstrasi;
                                    } else {
                                        return "-";
                                    }
                                },
                                'htmlOptions' => array('style' => 'text-align: right;'),
                                'footer' => 'sum(metode_demonstrasi)',
                                'footerHtmlOptions' => array('style' => 'text-align:right;'),
                            ),
                            array(
                                'header' => 'Diskusi Kelompok',
                                'name' => 'metode_diskusi',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    if (!empty($data->metode_diskusi)) {

                                        return $data->metode_diskusi;
                                    } else {
                                        return "-";
                                    }
                                },
                                'htmlOptions' => array('style' => 'text-align: right;'),
                                'footer' => 'sum(metode_diskusi)',
                                'footerHtmlOptions' => array('style' => 'text-align:right;'),
                            ),
                            array(
                                'header' => 'Tatap Muka',
                                'name' => 'metode_wawancara',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    if (!empty($data->metode_wawancara)) {
                                        return $data->metode_wawancara;
                                    } else {
                                        return "-";
                                    }
                                },
                                'htmlOptions' => array('style' => 'text-align: right;'),
                                'footer' => 'sum(metode_wawancara)',
                                'footerHtmlOptions' => array('style' => 'text-align:right;'),
                            ),
                            array(
                                'header' => 'Jumlah',
                                'value' => function ($data) {

                                    return "-";
                                },
                                'htmlOptions' => array('style' => 'text-align: right;'),
                                'footer' => number_format($jumlah, 0, "", "."),
                                'footerHtmlOptions' => array('style' => 'text-align:right;'),
                            ),
                        ),
                        'afterAjaxUpdate' => 'function(id, data){
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
        $("table").find("input[type=text]").each(function(){
            cekForm(this);
        })
    }',
                    ));

                    echo " </div>
                    </div>";
                    //rekap hasil
                } else {
                    $tmp++;
                }
            }
        }
        ?>

    </div>
</div>
<!--<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
        <i class="fas fa-chart-bar"></i> Grafik
    </div>
    </div>
    <div class="panel-body table-responsive">
        <?php //$this->renderPartial('_tab'); 
        ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>
    </div>
</div>-->

<?php
echo '<br>';
echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));

$tips = array(
    '0' => 'cari',
    '1' => 'ulang',
    '2' => 'print',
);
$content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

$urlPrint = $this->createUrl('print');
$url = $this->createUrl('FrameInformasiEdukasi&id=1');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#penilaian-alokasi-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
<?php
Yii::app()->clientScript->registerScript('test', '
function resizeIframe(obj){
       obj.style.height = obj.contentWindow.document.body.scrollHeight + "px";
    }    
function setType(obj, index){
    $("#type").val($(obj).attr("type"));
    $(obj).parents("ul").find("li").each(function(){
        $(this).removeClass("active");
    });
    $(obj).addClass("active");
    $.fn.yiiGridView.update("tableInformasi", {
            data: $(this).serialize()
    });
    if (index==1) {
        index="batang";
    } else if (index==2) {
        index="pie";
    } else if (index==3) {
        index="garis";
    }
    $("#Grafik").attr("src","' . $url . '"+$("#penilaian-alokasi-t-search").serialize()+"&type="+index);
    return false;
}
', CClientScript::POS_HEAD);
?>