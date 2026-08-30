<?php

if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF') {


?>

    <table style="width: 100%; border: none;">
        <thead>
            <tr>
                <td>
                    <div class="header"><?php
                                        echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                                        ?></div>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="content">
                        <br>
                        <div class="judulcontent"> <?php echo $judulLaporan   ?> <br></div>
                        <br>
                        <?php $itemCssClass = 'table table-striped table-bordered table-condensed';
                        if ($caraPrint == 'EXCEL') {
                            header('Content-Type: application/vnd.ms-excel');
                            header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
                            header('Cache-Control: max-age=0');
                        }
                        if ($caraPrint != "PDF") {
                            //echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan, 'colspan' => 10));
                        }
                        $table = 'ext.bootstrap.widgets.BootGridView';
                        $sort = true;
                        if (isset($caraPrint)) {
                            $data = $model->searchPrint();
                            $template = "{items}";
                            $sort = false;
                            if ($caraPrint == "EXCEL") {
                                $table = 'ext.bootstrap.widgets.BootExcelGridView';
                            }
                            if ($caraPrint == "PDF") {
                                $itemCssClass = 'table border';
                            }
                        } else {
                            $data = $model->searchPrint();
                            $template = "{summary}\n{items}\n{pager}";
                        }

                        $this->widget($table, array(
                            'id' => 'sajenis-kelas-m-grid',
                            'enableSorting' => false,
                            'dataProvider' => $data,
                            'template' => $template,
                            'enableSorting' => $sort,
                            'itemsCssClass' => $itemCssClass,
                            'columns' => array(
                                array(
                                    'header' => 'ID',
                                    'value' => '$row+1',
                                ),
                                'jenistindakanrm_nama',
                                'jenistindakanrm_namalainnya',
                                array(
                                    'header' => 'Status',
                                    'value' => '($data->jenistindakanrm_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                                ),
                                //		
                            ),
                        )); ?>
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
        <?php if (isset($caraPrint) && $caraPrint != "PDF") {  ?>
            <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
        <?php  }  ?>
    </div>

<?php
}
if ($caraPrint == 'PDF') {
?>
    <div class="header">
        <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
    </div>
    <div class="content">
        <br>
        <div class="judulcontent"> <?php echo $judulLaporan   ?> <br></div>
        <br>
        <?php $itemCssClass = 'table table-striped table-bordered table-condensed';
        if ($caraPrint == 'EXCEL') {
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
            header('Cache-Control: max-age=0');
        }
        if ($caraPrint != "PDF") {
            echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan, 'colspan' => 10));
        }
        $table = 'ext.bootstrap.widgets.BootGridView';
        $sort = true;
        if (isset($caraPrint)) {
            $data = $model->searchPrint();
            $template = "{items}";
            $sort = false;
            if ($caraPrint == "EXCEL") {
                $table = 'ext.bootstrap.widgets.BootExcelGridView';
            }
            if ($caraPrint == "PDF") {
                $itemCssClass = 'table border';
            }
        } else {
            $data = $model->searchPrint();
            $template = "{summary}\n{items}\n{pager}";
        }

        $this->widget($table, array(
            'id' => 'sajenis-kelas-m-grid',
            'enableSorting' => false,
            'dataProvider' => $data,
            'template' => $template,
            'enableSorting' => $sort,
            'itemsCssClass' => $itemCssClass,
            'columns' => array(
                array(
                    'header' => 'ID',
                    'value' => '$row+1',
                ),
                'jenistindakanrm_nama',
                'jenistindakanrm_namalainnya',
                array(
                    'header' => 'Status',
                    'value' => '($data->jenistindakanrm_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                ),
                //		
            ),
        )); ?>
    </div>

<?php
}
if ($caraPrint == 'GRAFIK') {
?>
    <table style="width: 100%; border: none;">
        <thead>
            <tr>
                <td>
                    <div class="header"><?php
                                        echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                                        ?></div>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="content">
                        <br>
                        <div class="judulcontent"> <?php echo $judulLaporan   ?> <br></div>
                        <br>
                        <?php $itemCssClass = 'table table-striped table-bordered table-condensed';
                        if ($caraPrint == 'EXCEL') {
                            header('Content-Type: application/vnd.ms-excel');
                            header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
                            header('Cache-Control: max-age=0');
                        }
                        if ($caraPrint != "PDF") {
                            echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan, 'colspan' => 10));
                        }
                        $table = 'ext.bootstrap.widgets.BootGridView';
                        $sort = true;
                        if (isset($caraPrint)) {
                            $data = $model->searchPrint();
                            $template = "{items}";
                            $sort = false;
                            if ($caraPrint == "EXCEL") {
                                $table = 'ext.bootstrap.widgets.BootExcelGridView';
                            }
                            if ($caraPrint == "PDF") {
                                $itemCssClass = 'table border';
                            }
                        } else {
                            $data = $model->searchPrint();
                            $template = "{summary}\n{items}\n{pager}";
                        }

                        $this->widget($table, array(
                            'id' => 'sajenis-kelas-m-grid',
                            'enableSorting' => false,
                            'dataProvider' => $data,
                            'template' => $template,
                            'enableSorting' => $sort,
                            'itemsCssClass' => $itemCssClass,
                            'columns' => array(
                                array(
                                    'header' => 'ID',
                                    'value' => '$row+1',
                                ),
                                'jenistindakanrm_nama',
                                'jenistindakanrm_namalainnya',
                                array(
                                    'header' => 'Status',
                                    'value' => '($data->jenistindakanrm_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                                ),
                                //		
                            ),
                        )); ?>
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
        <?php if (isset($caraPrint) && $caraPrint != "PDF") {  ?>
            <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
        <?php  }  ?>
    </div>

<?php
}
?>