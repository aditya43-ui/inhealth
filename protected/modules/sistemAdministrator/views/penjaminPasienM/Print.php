<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'colspan' => 12));
?>
    <div class="header">
        <?php //echo $this->renderPartial('application.views.headerReport.headerDefaultNew');  
        ?>
    </div>
    <div class="content">
        <?php
        $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
        $sort = true;
        if (isset($caraPrint)) {
            $data = $model->searchPrint();
            $template = "{items}";
            $sort = false;
            if ($caraPrint == "EXCEL")
                $table = 'ext.bootstrap.widgets.BootExcelGridView';
        } else {
            $data = $model->searchPrint();
            $template = "{summary}\n{items}\n{pager}";
        }

        $this->widget($table, array(
            'id' => 'sajenis-kelas-m-grid',
            'enableSorting' => $sort,
            'dataProvider' => $data,
            'mergeHeaders' => array(
                array(
                    'name' => 'Diskon',
                    'start' => 6,
                    'end' => 10,
                ),
            ),
            'template' => $template,
            'itemsCssClass' => 'table border',
            'columns' => array(
                array(
                    'header' => 'No.',
                    'value' => '($this->grid->dataProvider->pagination) ? 
                                                ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                : ($row+1)',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'name' => 'carabayar_id',
                    'value' => '$data->carabayar->carabayar_nama',
                    'type' => 'raw',
                ),
                array(
                    'header' => 'Nama Penjamin',
                    'value' => '$data->penjamin_nama',
                    'htmlOptions' => array(
                        'style' => 'text-align: center;',
                    ),
                ),
                array(
                    'header' => 'No. Telepon',
                    'value' => '$data->penjamin_nomobile',
                    'htmlOptions' => array(
                        'style' => 'text-align: center;',
                    ),
                ),
                array(
                    'header' => 'Lama Jatuh Tempo (Hari)',
                    'value' => '$data->lama_tempo',
                    'htmlOptions' => array(
                        'style' => 'text-align: center;',
                    ),
                ),
                array(
                    'header' => 'Lampiran File PKS',
                    'value' => '($data->lampiranpks==null)? Yii::t("mds","Tidak ada") : Yii::t("mds","Ada")',
                    'htmlOptions' => array(
                        'style' => 'text-align: center;',
                    ),
                ),
                array(
                    'header' => 'Tagihan (%)',
                    'type' => 'raw',
                    'value' => '$data->diskon_tagihan',
                    'htmlOptions' => array(
                        'style' => 'text-align: center;',
                    ),
                ),
                array(
                    'header' => 'Klaim (%)',
                    'type' => 'raw',
                    'value' => '$data->diskon_klaim',
                    'htmlOptions' => array(
                        'style' => 'text-align: center;',
                    ),
                ),
                array(
                    'header' => 'RJ (%)',
                    'type' => 'raw',
                    'value' => '$data->diskon_rj',
                    'htmlOptions' => array(
                        'style' => 'text-align: center;',
                    ),
                ),
                array(
                    'header' => 'RI (%)',
                    'type' => 'raw',
                    'value' => '$data->diskon_ri',
                    'htmlOptions' => array(
                        'style' => 'text-align: center;',
                    ),
                ),
                array(
                    'header' => 'RD (%)',
                    'type' => 'raw',
                    'value' => '$data->diskon_rd',
                    'htmlOptions' => array(
                        'style' => 'text-align: center;',
                    ),
                ),
                array(
                    'header' => 'Biaya Adm',
                    'type' => 'raw',
                    // 'value' => '"Rp " . $data->biaya_administrasi',
                    'value' => '"Rp ".MyFormatter::formatNumberForPrint($data->biaya_administrasi)',
                ),
                array(
                    'header' => 'Status',
                    'name' => 'penjamin_aktif',
                    'type' => 'raw',
                    'value' => '($data->penjamin_aktif==1)? Yii::t("mds","Aktif") : Yii::t("mds","No")',
                ),
            ),
        ));
        ?>
    </div>

<?php
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF' && $caraPrint != 'EXCEL') {
?>

    <table style="width: 100%; border: none;">
        <thead>
            <tr>
                <td>
                    <div class="header"><?php
                                        echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => ''));
                                        ?></div>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="content">
                        <?php
                        $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
                        $sort = true;
                        if (isset($caraPrint)) {
                            $data = $model->searchPrint();
                            $template = "{items}";
                            $sort = false;
                            if ($caraPrint == "EXCEL")
                                $table = 'ext.bootstrap.widgets.BootExcelGridView';
                        } else {
                            $data = $model->searchPrint();
                            $template = "{summary}\n{items}\n{pager}";
                        }

                        $this->widget($table, array(
                            'id' => 'sajenis-kelas-m-grid',
                            'enableSorting' => $sort,
                            'dataProvider' => $data,
                            'mergeHeaders' => array(
                                array(
                                    'name' => 'Diskon',
                                    'start' => 6,
                                    'end' => 10,
                                ),
                            ),
                            'template' => $template,
                            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                            'columns' => array(
                                array(
                                    'header' => 'No.',
                                    'value' => '($this->grid->dataProvider->pagination) ? 
                                                ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                : ($row+1)',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                ),
                                array(
                                    'name' => 'carabayar_id',
                                    'value' => '$data->carabayar->carabayar_nama',
                                    'type' => 'raw',
                                ),
                                array(
                                    'header' => 'Nama Penjamin',
                                    'value' => '$data->penjamin_nama',
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center;',
                                    ),
                                ),
                                array(
                                    'header' => 'No. Telepon',
                                    'value' => '$data->penjamin_nomobile',
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center;',
                                    ),
                                ),
                                array(
                                    'header' => 'Lama Jatuh Tempo (Hari)',
                                    'value' => '$data->lama_tempo',
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center;',
                                    ),
                                ),
                                array(
                                    'header' => 'Lampiran File PKS',
                                    'value' => '($data->lampiranpks==null)? Yii::t("mds","Tidak ada") : Yii::t("mds","Ada")',
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center;',
                                    ),
                                ),
                                array(
                                    'header' => 'Tagihan (%)',
                                    'type' => 'raw',
                                    'value' => '$data->diskon_tagihan',
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center;',
                                    ),
                                ),
                                array(
                                    'header' => 'Klaim (%)',
                                    'type' => 'raw',
                                    'value' => '$data->diskon_klaim',
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center;',
                                    ),
                                ),
                                array(
                                    'header' => 'RJ (%)',
                                    'type' => 'raw',
                                    'value' => '$data->diskon_rj',
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center;',
                                    ),
                                ),
                                array(
                                    'header' => 'RI (%)',
                                    'type' => 'raw',
                                    'value' => '$data->diskon_ri',
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center;',
                                    ),
                                ),
                                array(
                                    'header' => 'RD (%)',
                                    'type' => 'raw',
                                    'value' => '$data->diskon_rd',
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center;',
                                    ),
                                ),
                                array(
                                    'header' => 'Biaya Adm',
                                    'type' => 'raw',
                                    // 'value' => '"Rp " . $data->biaya_administrasi',
                                    'value' => '"Rp ".MyFormatter::formatNumberForPrint($data->biaya_administrasi)',
                                ),
                                array(
                                    'header' => 'Status',
                                    'name' => 'penjamin_aktif',
                                    'type' => 'raw',
                                    'value' => '($data->penjamin_aktif==1)? Yii::t("mds","Aktif") : Yii::t("mds","No")',
                                ),
                            ),
                        ));
                        ?>
                    </div>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td>
                    <div class="footer-space">&nbsp;</div>
                </td>
            </tr>
        </tfoot>
    </table>
    <div class="">
    </div>
    <div class="footer">
        <?php if (isset($caraPrint) && $caraPrint != "PDF") { ?>
            <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
        <?php } ?>
    </div>

<?php
}
if ($caraPrint == 'PDF') {
?>
    <div class="header">
        <?php //$this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => ''));  
        ?>
    </div>
    <div class="content">
        <?php
        $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
        $sort = true;
        if (isset($caraPrint)) {
            $data = $model->searchPrint();
            $template = "{items}";
            $sort = false;
            if ($caraPrint == "EXCEL")
                $table = 'ext.bootstrap.widgets.BootExcelGridView';
        } else {
            $data = $model->searchPrint();
            $template = "{summary}\n{items}\n{pager}";
        }

        $this->widget($table, array(
            'id' => 'sajenis-kelas-m-grid',
            'enableSorting' => $sort,
            'dataProvider' => $data,
            'mergeHeaders' => array(
                array(
                    'name' => 'Diskon',
                    'start' => 6,
                    'end' => 10,
                ),
            ),
            'template' => $template,
            'itemsCssClass' => 'table border',
            'columns' => array(
                array(
                    'header' => 'No.',
                    'value' => '($this->grid->dataProvider->pagination) ? 
                                                ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                : ($row+1)',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'name' => 'carabayar_id',
                    'value' => '$data->carabayar->carabayar_nama',
                    'type' => 'raw',
                ),
                array(
                    'header' => 'Nama Penjamin',
                    'value' => '$data->penjamin_nama',
                    'htmlOptions' => array(
                        'style' => 'text-align: center;',
                    ),
                ),
                array(
                    'header' => 'No. Telepon',
                    'value' => '$data->penjamin_nomobile',
                    'htmlOptions' => array(
                        'style' => 'text-align: center;',
                    ),
                ),
                array(
                    'header' => 'Lama Jatuh Tempo (Hari)',
                    'value' => '$data->lama_tempo',
                    'htmlOptions' => array(
                        'style' => 'text-align: center;',
                    ),
                ),
                array(
                    'header' => 'Lampiran File PKS',
                    'value' => '($data->lampiranpks==null)? Yii::t("mds","Tidak ada") : Yii::t("mds","Ada")',
                    'htmlOptions' => array(
                        'style' => 'text-align: center;',
                    ),
                ),
                array(
                    'header' => 'Tagihan (%)',
                    'type' => 'raw',
                    'value' => '$data->diskon_tagihan',
                    'htmlOptions' => array(
                        'style' => 'text-align: center;',
                    ),
                ),
                array(
                    'header' => 'Klaim (%)',
                    'type' => 'raw',
                    'value' => '$data->diskon_klaim',
                    'htmlOptions' => array(
                        'style' => 'text-align: center;',
                    ),
                ),
                array(
                    'header' => 'RJ (%)',
                    'type' => 'raw',
                    'value' => '$data->diskon_rj',
                    'htmlOptions' => array(
                        'style' => 'text-align: center;',
                    ),
                ),
                array(
                    'header' => 'RI (%)',
                    'type' => 'raw',
                    'value' => '$data->diskon_ri',
                    'htmlOptions' => array(
                        'style' => 'text-align: center;',
                    ),
                ),
                array(
                    'header' => 'RD (%)',
                    'type' => 'raw',
                    'value' => '$data->diskon_rd',
                    'htmlOptions' => array(
                        'style' => 'text-align: center;',
                    ),
                ),
                array(
                    'header' => 'Biaya Adm',
                    'type' => 'raw',
                    // 'value' => '"Rp " . $data->biaya_administrasi',
                    'value' => '"Rp ".MyFormatter::formatNumberForPrint($data->biaya_administrasi)',
                ),
                array(
                    'header' => 'Status',
                    'name' => 'penjamin_aktif',
                    'type' => 'raw',
                    'value' => '($data->penjamin_aktif==1)? Yii::t("mds","Aktif") : Yii::t("mds","No")',
                ),
            ),
        ));
        ?>
    </div>

<?php
}
?>