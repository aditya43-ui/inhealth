<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'colspan' => 7));
?>
    <div class="header">
        <?php //echo $this->renderPartial('application.views.headerReport.headerDefaultNew');  
        ?>
    </div>
    <div class="content">
        <?php
        $table = 'ext.bootstrap.widgets.BootGridView';
        $template = "{summary}\n{items}\n{pager}";
        $this->widget($table, array(
            'id' => 'sajenis-kelas-m-grid',
            'enableSorting' => false,
            'dataProvider' => $model->searchPrint(),
            'template' => $template,
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                ////'kelkumurhasillab_id',
                array(
                    'header' => 'ID',
                    'value' => '$data->kelkumurhasillab_id',
                ),
                'kelkumurhasillabnama',
                array(
                    'name' => 'umurminlab',
                    'type' => 'raw',
                    'value' => '$data->umurminlab',
                    'htmlOptions' => array('style' => 'text-align: center;'),
                ),
                array(
                    'name' => 'umurmakslab',
                    'type' => 'raw',
                    'value' => '$data->umurmakslab',
                    'htmlOptions' => array('style' => 'text-align: center;'),
                ),
                array(
                    'name' => 'satuankelumur',
                    'type' => 'raw',
                    'value' => '$data->satuankelumur',
                    'htmlOptions' => array('style' => 'text-align: center;'),
                ),
                array(
                    'name' => 'kelkumurhasillab_urutan',
                    'type' => 'raw',
                    'value' => '$data->kelkumurhasillab_urutan',
                    'htmlOptions' => array('style' => 'text-align: center;'),
                ),
                array(
                    'name' => 'kelkumurhasillab_aktif',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                    'value' => '(($data->kelkumurhasillab_aktif == 1)? "' . Yii::t('mds', 'Aktif') . '" : "' . Yii::t('mds', 'Tidak Aktif') . '")',
                )
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
                        $template = "{summary}\n{items}\n{pager}";
                        $this->widget($table, array(
                            'id' => 'sajenis-kelas-m-grid',
                            'enableSorting' => false,
                            'dataProvider' => $model->searchPrint(),
                            'template' => $template,
                            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                            'columns' => array(
                                ////'kelkumurhasillab_id',
                                array(
                                    'header' => 'ID',
                                    'value' => '$data->kelkumurhasillab_id',
                                ),
                                'kelkumurhasillabnama',
                                array(
                                    'name' => 'umurminlab',
                                    'type' => 'raw',
                                    'value' => '$data->umurminlab',
                                    'htmlOptions' => array('style' => 'text-align: center;'),
                                ),
                                array(
                                    'name' => 'umurmakslab',
                                    'type' => 'raw',
                                    'value' => '$data->umurmakslab',
                                    'htmlOptions' => array('style' => 'text-align: center;'),
                                ),
                                array(
                                    'name' => 'satuankelumur',
                                    'type' => 'raw',
                                    'value' => '$data->satuankelumur',
                                    'htmlOptions' => array('style' => 'text-align: center;'),
                                ),
                                array(
                                    'name' => 'kelkumurhasillab_urutan',
                                    'type' => 'raw',
                                    'value' => '$data->kelkumurhasillab_urutan',
                                    'htmlOptions' => array('style' => 'text-align: center;'),
                                ),
                                array(
                                    'name' => 'kelkumurhasillab_aktif',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                                    'value' => '(($data->kelkumurhasillab_aktif == 1)? "' . Yii::t('mds', 'Aktif') . '" : "' . Yii::t('mds', 'Tidak Aktif') . '")',
                                )
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
        $table = 'ext.bootstrap.widgets.BootGridView';
        $template = "{summary}\n{items}\n{pager}";
        $this->widget($table, array(
            'id' => 'sajenis-kelas-m-grid',
            'enableSorting' => false,
            'dataProvider' => $model->searchPrint(),
            'template' => $template,
            'itemsCssClass' => 'table border',
            'columns' => array(
                ////'kelkumurhasillab_id',
                array(
                    'header' => 'ID',
                    'value' => '$data->kelkumurhasillab_id',
                ),
                'kelkumurhasillabnama',
                array(
                    'name' => 'umurminlab',
                    'type' => 'raw',
                    'value' => '$data->umurminlab',
                    'htmlOptions' => array('style' => 'text-align: center;'),
                ),
                array(
                    'name' => 'umurmakslab',
                    'type' => 'raw',
                    'value' => '$data->umurmakslab',
                    'htmlOptions' => array('style' => 'text-align: center;'),
                ),
                array(
                    'name' => 'satuankelumur',
                    'type' => 'raw',
                    'value' => '$data->satuankelumur',
                    'htmlOptions' => array('style' => 'text-align: center;'),
                ),
                array(
                    'name' => 'kelkumurhasillab_urutan',
                    'type' => 'raw',
                    'value' => '$data->kelkumurhasillab_urutan',
                    'htmlOptions' => array('style' => 'text-align: center;'),
                ),
                array(
                    'name' => 'kelkumurhasillab_aktif',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                    'value' => '(($data->kelkumurhasillab_aktif == 1)? "' . Yii::t('mds', 'Aktif') . '" : "' . Yii::t('mds', 'Tidak Aktif') . '")',
                )
            ),
        ));
        ?>
    </div>

<?php
}
?>