<?php
/**
* digunakan untuk Master Termin
* @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
**/
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Pengaturan <strong>Termin</strong></div>
            </div>
            <div class="panel-body">
                <?php
                $this->breadcrumbs = array(
                    'ADLookup M' => array('index'),
                    'Manage',
                );

                $arrMenu = array();
                $this->menu = $arrMenu;

                Yii::app()->clientScript->registerScript('search', "
                $('.search-button').click(function(){
                        $('.search-form').toggle();
                        return false;
                });
                $('.search-form form').submit(function(){
                        $.fn.yiiGridView.update('adlookup-m-grid', {
                                data: $(this).serialize()
                        });
                        return false;
                });
                ");

                $this->widget('bootstrap.widgets.BootAlert');
                ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
                <p></p>
                <div class="cari-lanjut search-form" style="display:none; padding: 10px;">
                    <?php
                    $this->renderPartial($this->path_view . '_search', array(
                        'model' => $model,
                    ));
                    ?>
                </div><!-- search-form --><hr>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Termin</strong></div>
                    </div>
                    <div class="panel-body" style="overflow-x: scroll">
                        <div class="block-tabel">
                            <?php
                            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                                'id' => 'adlookup-m-grid',
                                'dataProvider' => $model->searchTermin(),
                                'filter' => $model,
                                'template' => "{summary}\n{items}\n{pager}",
                                'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                                'columns' => array(
                                    array(
                                        'header' => 'No',
                                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                                        'type' => 'raw',
                                        'htmlOptions' => array('style' => 'text-align:right;'),
                                    ),
                                    array(
                                        'header' => 'Nama Termin',
                                        'name' => 'lookup_name',
                                        'value' => '$data->lookup_name',
                                        'filter' => Chtml::activeTextField($model, 'lookup_name', array('class' => ''))
                                    ),
                                    array(
                                        'header' => 'Jumlah Termin',
                                        'name' => 'lookup_value',
                                        'value' => '$data->lookup_value',
                                        'filter' => Chtml::activeTextField($model, 'lookup_value', array('class' => ''))
                                    ),
                                     array(
                                        'header' => 'Urutan',
                                        'name' => 'lookup_urutan',
                                        'value' => '$data->lookup_urutan',
                                        'filter' => Chtml::activeTextField($model, 'lookup_urutan', array('class' => ''))
                                    ),
                                    array(
                                        'header' => '<center>Status</center>',
                                        'value' => '($data->lookup_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                        'htmlOptions' => array('style' => 'text-align:center;'),
                                    ),
                                    array(
                                        'header' => Yii::t('zii', 'View'),
                                        'class' => 'bootstrap.widgets.BootButtonColumn',
                                        'template' => '{view}',
                                        'buttons' => array(
                                            'view' => array(
                                                'label' => "<i class='" . MyIcon::getIcons('lihat') . "'></i>",
                                                'options' => array('title' => Yii::t('mds', 'View')),
                                                'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("id"=>"$data->lookup_id"))',
                                            ),
                                        ),
                                    ),
                                    array(
                                        'header' => Yii::t('zii', 'Update'),
                                        'class' => 'bootstrap.widgets.BootButtonColumn',
                                        'template' => '{update}',
                                        'buttons' => array(
                                            'update' => array(
                                                'label' => "<i class='" . MyIcon::getIcons('ubah') . "'></i>",
                                                'options' => array('title' => Yii::t('mds', 'Update')),
                                                'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/update",array("id"=>"$data->lookup_id"))',
                                            ),
                                        ),
                                    ),
                                    array(
                                        'header' => 'Hapus',
                                        'type' => 'raw',
                                        'value' => function($data) {
                                            if ($data->lookup_aktif == true) {
                                                return CHtml::link("<i class='glyphicon glyphicon-remove'></i> ", "javascript:removeTemporary($data->lookup_id)", array("id" => "$data->lookup_id", "rel" => "tooltip", "title" => "Menonaktifkan Termin")) . ' ' . CHtml::link("<i class='glyphicon glyphicon-trash'></i> ", "javascript:deleteRecord($data->lookup_id)", array("id" => "$data->lookup_id", "rel" => "tooltip", "title" => "Hapus Termin"));
                                            } else {
                                                return CHtml::link("<i class='glyphicon glyphicon-check'></i> ", "javascript:aktifkan($data->lookup_id)", array("id" => "$data->lookup_id", "rel" => "tooltip", "title" => "Mengaktifkan Termin")) . ' ' . CHtml::link("<i class='glyphicon glyphicon-trash'></i> ", "javascript:deleteRecord($data->lookup_id)", array("id" => "$data->lookup_id", "rel" => "tooltip", "title" => "Hapus Termin"));
                                            }
                                        },
                                        'htmlOptions' => array('style' => 'text-align: center; width:80px'),
                                    ),
                                ),
                                'afterAjaxUpdate' => 'function(id, data){
                            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                            $("table").find("input[type=text]").each(function(){
                                    cekForm(this);
                            });
                             $("table").find("select").each(function(){
                                    cekForm(this);
                            });
                            $(".numbers-only").keyup(function() {
                                    setNumbersOnly(this);
                            });
                            $(".custom-only").keyup(function() {
                                    setNumbersOnly(this);
                            });
                    }',
                            ));
                            ?>
                        </div>
                    </div>
                </div>			
                <?php
                echo CHtml::link(Yii::t('mds', '{icon} Tambah Termin', array('{icon}' => '<i class="entypo-plus"></i>')), $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . "&nbsp&nbsp";
                echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
                $content = $this->renderPartial($this->path_tips . 'master', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
                $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

                $js = <<< JSCRIPT
				function cekForm(obj){
					$("#adlookup-m-search :input[name='"+ obj.name +"']").val(obj.value);
				}
				function print(caraPrint){
					window.open("${urlPrint}/"+$('#adlookup-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
				}
JSCRIPT;
                Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
                ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm('Yakin akan menonaktifkan data ini untuk sementara?', 'Perhatian!', function (r) {
            if (r) {
                $.post(url, {id: id},
                        function (data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('adlookup-m-grid');
                            } else {
                                myAlert('Data Gagal di Nonaktifkan')
                            }
                        }, "json");
            }
        });
    }
    function aktifkan(id){
        var url = '<?php echo $url."/aktifkan"; ?>';
        myConfirm('Yakin akan mengaktifkan data ini?','Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('adlookup-m-grid');
                            }else{
                                myAlert('Data Gagal di Aktifkan')
                            }
                },"json");
           }
        });
    }
    function deleteRecord(id) {
        var id = id;
        var url = '<?php echo $url . "/delete"; ?>';
        myConfirm('Yakin Akan Menghapus Data ini ?', 'Perhatian!', function (r) {
            if (r) {
                $.post(url, {id: id},
                        function (data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('adlookup-m-grid');
                            } else {
                                myAlert('Data gagal di hapus karena digunakan di transaksi lain')
                            }
                        }, "json");
            }
        });
    }
</script>