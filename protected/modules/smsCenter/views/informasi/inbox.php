<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pesan Masuk</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Informasi Pesan Masuk',
        );

        $arrMenu = array();
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => ' Pesan Masuk ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) :  '';

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $.fn.yiiGridView.update('inbox-grid', {
            data: $(this).serialize()
        });
        return false;
    });
    ");

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pesan masuk</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'inbox-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed table-bordered',
                    'columns' => array(
                        //'updatedindb',
                        //'ReceivingDateTime',
                        array(
                            'header' => 'No.',
                            'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                        ),
                        array(
                            'name' => 'ReceivingDateTime',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->ReceivingDateTime)',
                            'filter' => false
                        ),
                        array(
                            'header' => 'Nomor SMS Center',
                            'name' => 'SMSCNumber',
                            'value' => '$data->SMSCNumber',
                        ),
                        'SenderNumber',
                        /*
						'coding',
						'udh',
						'class',
						 */
                        array(
                            'header' => 'Isi Pesan SMS',
                            'name' => 'TextDecoded',
                            'value' => '$data->TextDecoded',
                        ),
                        array(
                            'header' => 'Diproses',
                            'name' => 'Processed',
                            'value' => '$data->Processed',
                        ),

                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
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
    window.open("${urlPrint}/"+$('#inbox-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>

<script type="text/javascript">
    setInterval( // fungsi untuk menjalankan suatu fungsi berdasarkan waktu
        function() {
            $.post('<?php echo $this->createUrl('Monitor/AjaxMonitorInbox') ?>', {}, function() {}, 'json');
            $.fn.yiiGridView.update('inbox-grid', { // fungsi untuk me-update data pada Cgridview yang memiliki id=category_grid
                data: $(this).serialize()
            });
            return false;
        },
        10000 // fungsi di eksekusi setiap 10 detik sekali
    );
</script>