<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'colspan' => 5));
    ?>
    <div class="header">
        <?php //echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
    </div>
    <div class="content">

        <?php
        $table = 'ext.bootstrap.widgets.BootGridView';
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
            'id' => 'ptkp-kelas-m-grid',
            'enableSorting' => $sort,
            'dataProvider' => $data,
            'template' => $template,
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'Kelompok Tindakan',
                    'value' => 'isset($data->daftartindakan->kelompoktindakan->kelompoktindakan_nama)?$data->daftartindakan->kelompoktindakan->kelompoktindakan_nama:" - "',
                //				'filter'=>true,                                
                ),
                array(
                    'header' => 'Komponen Unit',
                    'value' => 'isset($data->daftartindakan->komponenunit->komponenunit_nama)?$data->daftartindakan->komponenunit->komponenunit_nama:" - "',
                ),
                array(
                    'header' => 'Kategori Tindakan',
                    'value' => 'isset($data->daftartindakan->kategoritindakan->kategoritindakan_nama)?$data->daftartindakan->kategoritindakan->kategoritindakan_nama:" - "',
                ),
                array(
                    'header' => 'Kode Tindakan',
                    'value' => 'isset($data->daftartindakan->daftartindakan_kode)?$data->daftartindakan->daftartindakan_kode:" - "',
                ),
                array(
                    'header' => 'Uraian Tindakan',
                    'value' => 'isset($data->daftartindakan->daftartindakan_nama)?$data->daftartindakan->daftartindakan_nama:" - "',
                ),
                array(
                    'header' => 'Ruangan ',
                    'type' => 'raw',
                    //'value'=>'$this->grid->getOwner()->renderPartial(\'_ruangan\',array(\'daftartindakan_id\'=>$data->daftartindakan_id),true)',
                    'value' => '$data->ruangan->ruangan_nama'
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
                        $table = 'ext.bootstrap.widgets.BootGridView';
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
                            'id' => 'ptkp-kelas-m-grid',
                            'enableSorting' => $sort,
                            'dataProvider' => $data,
                            'template' => $template,
                            'itemsCssClass' => 'table border',
                            'columns' => array(
                                array(
                                    'header' => 'Kelompok Tindakan',
                                    'value' => 'isset($data->daftartindakan->kelompoktindakan->kelompoktindakan_nama)?$data->daftartindakan->kelompoktindakan->kelompoktindakan_nama:" - "',
                                //				'filter'=>true,                                
                                ),
                                array(
                                    'header' => 'Komponen Unit',
                                    'value' => 'isset($data->daftartindakan->komponenunit->komponenunit_nama)?$data->daftartindakan->komponenunit->komponenunit_nama:" - "',
                                ),
                                array(
                                    'header' => 'Kategori Tindakan',
                                    'value' => 'isset($data->daftartindakan->kategoritindakan->kategoritindakan_nama)?$data->daftartindakan->kategoritindakan->kategoritindakan_nama:" - "',
                                ),
                                array(
                                    'header' => 'Kode Tindakan',
                                    'value' => 'isset($data->daftartindakan->daftartindakan_kode)?$data->daftartindakan->daftartindakan_kode:" - "',
                                ),
                                array(
                                    'header' => 'Uraian Tindakan',
                                    'value' => 'isset($data->daftartindakan->daftartindakan_nama)?$data->daftartindakan->daftartindakan_nama:" - "',
                                ),
                                array(
                                    'header' => 'Ruangan ',
                                    'type' => 'raw',
                                    //'value'=>'$this->grid->getOwner()->renderPartial(\'_ruangan\',array(\'daftartindakan_id\'=>$data->daftartindakan_id),true)',
                                    'value' => '$data->ruangan->ruangan_nama'
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
        <?php //$this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => '')); ?>
    </div>
    <div class="content">
        <?php
        $table = 'ext.bootstrap.widgets.BootGridView';
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
            'id' => 'ptkp-kelas-m-grid',
            'enableSorting' => $sort,
            'dataProvider' => $data,
            'template' => $template,
            'itemsCssClass' => 'table border',
            'columns' => array(
                array(
                    'header' => 'Kelompok Tindakan',
                    'value' => 'isset($data->daftartindakan->kelompoktindakan->kelompoktindakan_nama)?$data->daftartindakan->kelompoktindakan->kelompoktindakan_nama:" - "',
                //				'filter'=>true,                                
                ),
                array(
                    'header' => 'Komponen Unit',
                    'value' => 'isset($data->daftartindakan->komponenunit->komponenunit_nama)?$data->daftartindakan->komponenunit->komponenunit_nama:" - "',
                ),
                array(
                    'header' => 'Kategori Tindakan',
                    'value' => 'isset($data->daftartindakan->kategoritindakan->kategoritindakan_nama)?$data->daftartindakan->kategoritindakan->kategoritindakan_nama:" - "',
                ),
                array(
                    'header' => 'Kode Tindakan',
                    'value' => 'isset($data->daftartindakan->daftartindakan_kode)?$data->daftartindakan->daftartindakan_kode:" - "',
                ),
                array(
                    'header' => 'Uraian Tindakan',
                    'value' => 'isset($data->daftartindakan->daftartindakan_nama)?$data->daftartindakan->daftartindakan_nama:" - "',
                ),
                array(
                    'header' => 'Ruangan ',
                    'type' => 'raw',
                    //'value'=>'$this->grid->getOwner()->renderPartial(\'_ruangan\',array(\'daftartindakan_id\'=>$data->daftartindakan_id),true)',
                    'value' => '$data->ruangan->ruangan_nama'
                ),
            ),
        ));
        ?>
    </div>

    <?php
}
?>