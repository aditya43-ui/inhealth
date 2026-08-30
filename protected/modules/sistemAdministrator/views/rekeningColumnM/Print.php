<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'colspan' => 6));
    ?>
    <div class="header">
        <?php //echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
    </div>
    <div class="content">
        <?php
        $rows = '$row+1';
        $template = "{items}";
        $table = 'ext.bootstrap.widgets.BootGridView';
        $this->widget($table, array(
            'id' => 'jenispenerimaan-m-grid',
            'enableSorting' => false,
            'dataProvider' => $model->searchPrint(),
            'template' => $template,
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'No.',
                    'value' => $rows,
                ),
                array(
                    'header'=>'Keterangan Penggunaan Rekening',
                    'name'=>'keterangan',
                    'value'=>'$data->keterangan',
		),
                array(
                    'header' => 'Nama Tabel',
                    'name' => 'table_name',
                    'value' => '$data->table_name',
                ),
                array(
                    'header' => 'Nama Kolom',
                    'name' => 'column_name',
                    'value' => '$data->column_name',
                ),
                array(
                    'header' => 'Rekening Debit',
                    'type' => 'raw',
                    'value' => function($data) {
                        $r = RekeningcolumnM::model()->findAllByAttributes(array(
                            'rekeningcolumn_id' => $data->rekeningcolumn_id,
                            'debitkredit' => 'D'
                        ));
                        $str = "<ul>";

                        if (count((array)$r) == 0)
                            return "-";
                        foreach ($r as $item) {
                            $r5 = Rekening5M::model()->findByPk($item->rekening5_id);
                            $str .= "<li>" . $r5->nmrekening5 . "</li>";
                        }

                        $str .= "</ul>";
                        return $str;
                    }
                ),
                array(
                    'header' => 'Rekening Kredit',
                    'type' => 'raw',
                    'value' => function($data) {
                        $r = RekeningcolumnM::model()->findAllByAttributes(array(
                            'rekeningcolumn_id' => $data->rekeningcolumn_id,
                            'debitkredit' => 'K'
                        ));
                        $str = "<ul>";

                        if (count((array)$r) == 0)
                            return "-";
                        foreach ($r as $item) {
                            $r5 = Rekening5M::model()->findByPk($item->rekening5_id);
                            $str .= "<li>" . $r5->nmrekening5 . "</li>";
                        }

                        $str .= "</ul>";
                        return $str;
                    }
                )
            ),
        ));
        ?>
        <?php if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK' || $caraPrint == 'EXCEL') { ?>
            <div id="footer" style = "width:100%;">
                <div style = "display:inline-block;float:left;text-align:left;">
                    <i><b>
                            Created At : 
                            <?php
                            echo MyFormatter::formatDateTimeId(date('Y-m-d H:i:s'));
                            ?>
                        </b></i>
                </div>
                <div style = "text-align:right;float:right;">
                    <i><b>
                            Created By : 
                            <?php
                            echo $this->pageTitle = Yii::app()->user->nama_pemakai;
                            ?>
                        </b></i>
                </div>
            </div>
        <?php } ?>
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
                        $rows = '$row+1';
                        $template = "{items}";
                        $table = 'ext.bootstrap.widgets.BootGridView';
                        $this->widget($table, array(
                            'id' => 'jenispenerimaan-m-grid',
                            'enableSorting' => false,
                            'dataProvider' => $model->searchPrint(),
                            'template' => $template,
                            'itemsCssClass' => 'table border',
                            'columns' => array(
                                array(
                                    'header' => 'No.',
                                    'value' => $rows,
                                ),
                                array(
                                    'header' => 'ID',
                                    'name' => 'rekeningcolumn_id',
                                    'value' => '$data->rekeningcolumn_id',
                                ),
                                array(
                                    'header' => 'Nama Tabel',
                                    'name' => 'table_name',
                                    'value' => '$data->table_name',
                                ),
                                array(
                                    'header' => 'Nama Kolom',
                                    'name' => 'column_name',
                                    'value' => '$data->column_name',
                                ),
                                array(
                                    'header' => 'Keterangan',
                                    'name' => 'keterangan',
                                    'value' => '$data->keterangan',
                                ),
                                array(
                                    'header' => 'Rekening Debit',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        $r = RekeningcolumnM::model()->findAllByAttributes(array(
                                            'rekeningcolumn_id' => $data->rekeningcolumn_id,
                                            'debitkredit' => 'D'
                                        ));
                                        $str = "<ul>";

                                        if (count((array)$r) == 0)
                                            return "-";
                                        foreach ($r as $item) {
                                            $r5 = Rekening5M::model()->findByPk($item->rekening5_id);
                                            $str .= "<li>" . $r5->nmrekening5 . "</li>";
                                        }

                                        $str .= "</ul>";
                                        return $str;
                                    }
                                ),
                                array(
                                    'header' => 'Rekening Kredit',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        $r = RekeningcolumnM::model()->findAllByAttributes(array(
                                            'rekeningcolumn_id' => $data->rekeningcolumn_id,
                                            'debitkredit' => 'K'
                                        ));
                                        $str = "<ul>";

                                        if (count((array)$r) == 0)
                                            return "-";
                                        foreach ($r as $item) {
                                            $r5 = Rekening5M::model()->findByPk($item->rekening5_id);
                                            $str .= "<li>" . $r5->nmrekening5 . "</li>";
                                        }

                                        $str .= "</ul>";
                                        return $str;
                                    }
                                )
                            ),
                        ));
                        ?>
                        <?php if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK' || $caraPrint == 'EXCEL') { ?>
                            <div id="footer" style = "width:100%;">
                                <div style = "display:inline-block;float:left;text-align:left;">
                                    <i><b>
                                            Created At : 
                                            <?php
                                            echo MyFormatter::formatDateTimeId(date('Y-m-d H:i:s'));
                                            ?>
                                        </b></i>
                                </div>
                                <div style = "text-align:right;float:right;">
                                    <i><b>
                                            Created By : 
                                            <?php
                                            echo $this->pageTitle = Yii::app()->user->nama_pemakai;
                                            ?>
                                        </b></i>
                                </div>
                            </div>
                        <?php } ?>
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
        <?php //$this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => '')); ?>
    </div>
    <div class="content">
        <?php
        $rows = '$row+1';
        $template = "{items}";
        $table = 'ext.bootstrap.widgets.BootGridView';
        $this->widget($table, array(
            'id' => 'jenispenerimaan-m-grid',
            'enableSorting' => false,
            'dataProvider' => $model->searchPrint(),
            'template' => $template,
            'itemsCssClass' => 'table border',
            'columns' => array(
                array(
                    'header' => 'No.',
                    'value' => $rows,
                ),
                array(
                    'header' => 'ID',
                    'name' => 'rekeningcolumn_id',
                    'value' => '$data->rekeningcolumn_id',
                ),
                array(
                    'header' => 'Nama Tabel',
                    'name' => 'table_name',
                    'value' => '$data->table_name',
                ),
                array(
                    'header' => 'Nama Kolom',
                    'name' => 'column_name',
                    'value' => '$data->column_name',
                ),
                array(
                    'header' => 'Keterangan',
                    'name' => 'keterangan',
                    'value' => '$data->keterangan',
                ),
                array(
                    'header' => 'Rekening Debit',
                    'type' => 'raw',
                    'value' => function($data) {
                        $r = RekeningcolumnM::model()->findAllByAttributes(array(
                            'rekeningcolumn_id' => $data->rekeningcolumn_id,
                            'debitkredit' => 'D'
                        ));
                        $str = "<ul>";

                        if (count((array)$r) == 0)
                            return "-";
                        foreach ($r as $item) {
                            $r5 = Rekening5M::model()->findByPk($item->rekening5_id);
                            $str .= "<li>" . $r5->nmrekening5 . "</li>";
                        }

                        $str .= "</ul>";
                        return $str;
                    }
                ),
                array(
                    'header' => 'Rekening Kredit',
                    'type' => 'raw',
                    'value' => function($data) {
                        $r = RekeningcolumnM::model()->findAllByAttributes(array(
                            'rekeningcolumn_id' => $data->rekeningcolumn_id,
                            'debitkredit' => 'K'
                        ));
                        $str = "<ul>";

                        if (count((array)$r) == 0)
                            return "-";
                        foreach ($r as $item) {
                            $r5 = Rekening5M::model()->findByPk($item->rekening5_id);
                            $str .= "<li>" . $r5->nmrekening5 . "</li>";
                        }

                        $str .= "</ul>";
                        return $str;
                    }
                )
            ),
        ));
        ?>
        <?php if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK' || $caraPrint == 'EXCEL') { ?>
            <div id="footer" style = "width:100%;">
                <div style = "display:inline-block;float:left;text-align:left;">
                    <i><b>
                            Created At : 
                            <?php
                            echo MyFormatter::formatDateTimeId(date('Y-m-d H:i:s'));
                            ?>
                        </b></i>
                </div>
                <div style = "text-align:right;float:right;">
                    <i><b>
                            Created By : 
                            <?php
                            echo $this->pageTitle = Yii::app()->user->nama_pemakai;
                            ?>
                        </b></i>
                </div>
            </div>
        <?php } ?>
    </div>

    <?php
}
?>
