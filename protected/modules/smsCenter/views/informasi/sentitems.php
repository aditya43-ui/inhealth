<?php
$this->breadcrumbs = array(
    'Informasi Pesan Terkirim',
); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pesan Terkirim</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pesan Terkirim</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $arrMenu = array();
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => ' Pesan Terkirim ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) :  '';
                $this->menu = $arrMenu;
                Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $.fn.yiiGridView.update('sentitems-grid', {
            data: $(this).serialize()
        });
        return false;
    });
    ");
                $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); 
                ?>
                <div class="cari-lanjut search-form">
                    <?php
                    ?>
                </div>
                <!--search-form-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'sentitems-grid',
                    'dataProvider' => $model->searchTable(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed table-bordered',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                        ),
                        //                'SendingDateTime',
                        array(
                            'name' => 'SendingDateTime',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->SendingDateTime)',
                            'filter' => false,
                        ),
                        array(
                            'header' => 'Kategori SMS',
                            'name' => 'SenderID',
                            'type' => 'raw',
                            'value' => '$data->SenderID',
                            'filter' => array('phone1' => 'Pengaduan (phone1)', 'phone2' => 'Pelayanan (phone2)'),
                        ),
                        'SMSCNumber',
                        'DestinationNumber',
                        array(
                            'header' => 'Isi Pesan SMS',
                            'name' => 'TextDecoded',
                            'value' => '$data->TextDecoded',
                        ),
                        'Status',
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                    $(\'input[name="Sentitems[SendingDateTime]"]\').daterangepicker({
                        "maxDate": "' . date('m/d/Y') . '",
                        "showDropdowns": true,
                    });
                }',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sentitems-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
<script type="text/javascript">
    $(function() {
        $('input[name="Sentitems[SendingDateTime]"]').daterangepicker({
            "maxDate": "<?php echo date('m/d/Y') ?>",
            "showDropdowns": true,
        });
    });
    setInterval( // fungsi untuk menjalankan suatu fungsi berdasarkan waktu
        function() {
            $.fn.yiiGridView.update('sentitems-grid', { // fungsi untuk me-update data pada Cgridview yang memiliki id=category_grid
                data: $("#sentitems-grid :input").serialize()
            });
            return false;
        },
        10000 // fungsi di eksekusi setiap 10 detik sekali
    );
</script>