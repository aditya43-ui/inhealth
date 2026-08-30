<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Catatan Atas Laporan Keuangan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
        $tablecss = 'table table-striped table-bordered table-condensed';
        $sort = true;
        if (isset($caraPrint)) {
            $data = $model->searchPrint();
            $template = "{items}";
            $sort = false;
            if ($caraPrint == "EXCEL") {
                $table = 'ext.bootstrap.widgets.BootExcelGridView';
            }
            if ($caraPrint == 'PDF') {
                $table = 'ext.bootstrap.widgets.BootGroupGridViewPDF';
            }

            echo "
        <style>
            .border th, .border td{
                border:1px solid #000;
            }
            .table thead:first-child{
                border-top:1px solid #000;        
            }

            thead th{
                background:none;
                color:#333;
            }

            .border {
                box-shadow:none;
                border-spacing: 0;
                padding: 0;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
            $tablecss = "table border";
        } else {
            $data = $model->searchLaporan();
            $template = "{summary}\n{items}\n{pager}";
        }

        ?>
        <?php $this->widget($table, array(
            'id' => 'tableLaporan',
            'dataProvider' => $data,
            'template' => $template,
            'enableSorting' => $sort,
            'itemsCssClass' => $tablecss,
            'columns' => array(
                'calk_no',
                array(
                    'header' => 'Tgl. CALK',
                    'name' => 'calk_tgl',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->calk_tgl)))',
                ),
                array(
                    'name' => 'rekperiod_id',
                    'type' => 'raw',
                    'header' => 'Periode Akuntansi',
                    'value' => function ($data) {
                        $dat = RekperiodM::model()->findByPk($data->rekperiod_id);
                        if (empty($dat)) return "-";
                        return $dat->deskripsi;
                    },
                ),
                array(
                    'header' => 'Print',
                    'type' => 'raw',
                    'value' => function ($data) {
                        return CHtml::link('<i class="glyphicon glyphentypo-print"></i>', '#', array(
                            'onclick' => 'printCALK(' . $data->calk_id . '); return false;', 'data-toggle' => 'tooltip', 'title' => 'Klik untuk mencetak Catatan Atas Laporan Keuangan'
                        ));
                    },
                    'htmlOptions' => array(
                        'style' => 'text-align: center;',
                    )
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )); ?>

    </div>
</div>