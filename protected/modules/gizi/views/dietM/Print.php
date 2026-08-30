<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'colspan' => 3));
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
            'id' => 'gzdiet-m_search',
            'enableSorting' => $sort,
            'dataProvider' => $data,
            'template' => $template,
            'itemsCssClass' => 'table border',
            'columns' => array(
                array(
                    'name' => 'tipediet_id',
                    'filter' => CHtml::listData($model->getTipeDietItems(), 'tipediet_id', 'tipediet_nama'),
                    'value' => '$data->tipediet->tipediet_nama',
                ),
                array(
                    'name' => 'jenisdiet_id',
                    'filter' => CHtml::listData($model->getJenisdietItems(), 'jenisdiet_id', 'jenisdiet_nama'),
                    'value' => '$data->jenisdiet->jenisdiet_nama',
                ),
                array(
                    'name' => 'zatgizi_id',
                    'filter' => CHtml::listData($model->getZatgiziItems(), 'zatgizi_id', 'zatgizi_nama'),
                    'value' => '$data->zatgizi->zatgizi_nama',
                ),
                array(
                    'name' => 'diet_kandungan',
                    'value' => '$data->diet_kandungan." ".$data->zatgizi->zatgizi_satuan',
                    'filter' => CHtml::activeTextField($model, 'diet_kandungan', array('class' => 'numbersOnly')),
                    'htmlOptions' => array('style' => 'text-align: right;'),
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
        'id' => 'gzdiet-m_search',
        'enableSorting' => $sort,
        'dataProvider' => $data,
        'template' => $template,
        'itemsCssClass' => 'table border',
        'columns' => array(
            array(
                'name' => 'tipediet_id',
                'filter' => CHtml::listData($model->getTipeDietItems(), 'tipediet_id', 'tipediet_nama'),
                'value' => '$data->tipediet->tipediet_nama',
            ),
            array(
                'name' => 'jenisdiet_id',
                'filter' => CHtml::listData($model->getJenisdietItems(), 'jenisdiet_id', 'jenisdiet_nama'),
                'value' => '$data->jenisdiet->jenisdiet_nama',
            ),
            array(
                'name' => 'zatgizi_id',
                'filter' => CHtml::listData($model->getZatgiziItems(), 'zatgizi_id', 'zatgizi_nama'),
                'value' => '$data->zatgizi->zatgizi_nama',
            ),
            array(
                'name' => 'diet_kandungan',
                'value' => '$data->diet_kandungan." ".$data->zatgizi->zatgizi_satuan',
                'filter' => CHtml::activeTextField($model, 'diet_kandungan', array('class' => 'numbersOnly')),
                'htmlOptions' => array('style' => 'text-align: right;'),
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
        'id' => 'gzdiet-m_search',
        'enableSorting' => $sort,
        'dataProvider' => $data,
        'template' => $template,
        'itemsCssClass' => 'table border',
        'columns' => array(
            array(
                'name' => 'tipediet_id',
                'filter' => CHtml::listData($model->getTipeDietItems(), 'tipediet_id', 'tipediet_nama'),
                'value' => '$data->tipediet->tipediet_nama',
            ),
            array(
                'name' => 'jenisdiet_id',
                'filter' => CHtml::listData($model->getJenisdietItems(), 'jenisdiet_id', 'jenisdiet_nama'),
                'value' => '$data->jenisdiet->jenisdiet_nama',
            ),
            array(
                'name' => 'zatgizi_id',
                'filter' => CHtml::listData($model->getZatgiziItems(), 'zatgizi_id', 'zatgizi_nama'),
                'value' => '$data->zatgizi->zatgizi_nama',
            ),
            array(
                'name' => 'diet_kandungan',
                'value' => '$data->diet_kandungan." ".$data->zatgizi->zatgizi_satuan',
                'filter' => CHtml::activeTextField($model, 'diet_kandungan', array('class' => 'numbersOnly')),
                'htmlOptions' => array('style' => 'text-align: right;'),
            ),
        ),
    ));
    ?>
    </div>

    <?php
}
?>