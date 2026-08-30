<?php
/**
* digunakan untuk Master sub tipe insiden
* @author Elham Budianto <elhambudianto1@gmail.com>
**/
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Pengaturan <strong> Subtipe Insiden</strong></div>
            </div>
            <div class="panel-body">
                <?php
                $this->breadcrumbs = array(
                    'IPM Checklist' => array('index'),
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
                        $.fn.yiiGridView.update('subtipeinsiden-m-grid', {
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
                        <div class="panel-title">Tabel <strong> Subtipe Insiden</strong></div>
                    </div>
                    <div class="panel-body" style="overflow-x: scroll">
                        <div class="block-tabel">
                            <?php
                            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                                'id' => 'subtipeinsiden-m-grid',
                                'dataProvider' => $model->search(),
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
                                        'header' => 'Tipe Insiden',
                                        'name' => 'tipeinsiden_id',
                                        'value' => function($data){
                                            $tipeinsiden = TipeinsidenM::model()->findByPk($data->tipeinsiden_id);
                                            if(!empty($tipeinsiden)){
                                                return $tipeinsiden->tipeinsiden_nama;
                                            }else{
                                                return '-';
                                            }
                                        },
                                        'filter' => Chtml::activeDropDownList($model, 'tipeinsiden_id',Chtml::listData(TipeinsidenM::model()->findAllByAttributes(array('tipeinsiden_aktif'=>true)),'tipeinsiden_id','tipeinsiden_nama'), array('class' => '','empty'=>'-- Pilih --'))
                                    ),
                                    array(
                                        'header' => 'Kelompok Subtipe Insiden',
                                        'name' => 'kelompoksubtipeinsiden_id',
                                        'value' => function($data){
                                            $kelompoksubtipeinsiden = KelompoksubtipeinsidenM::model()->findByPk($data->kelompoksubtipeinsiden_id);
                                            if(!empty($kelompoksubtipeinsiden)){
                                                return $kelompoksubtipeinsiden->kelompoksubtipeinsiden_nama;
                                            }else{
                                                return '-';
                                            }
                                        },
                                        'filter' => Chtml::activeDropDownList($model, 'kelompoksubtipeinsiden_id',Chtml::listData(KelompoksubtipeinsidenM::model()->findAllByAttributes(array('kelompoksubtipeinsiden_aktif'=>true)),'kelompoksubtipeinsiden_id','kelompoksubtipeinsiden_nama'), array('class' => '','empty'=>'-- Pilih --'))
                                    ),
                                    array(
                                        'header' => 'Nama Subtipe Insiden',
                                        'name' => 'subtipeinsiden_nama',
                                        'value' => '$data->subtipeinsiden_nama',
                                        'filter' => Chtml::activeTextField($model, 'subtipeinsiden_nama', array('class' => ''))
                                    ),
                                    array(
                                        'header' => 'Nama Lain Subtipe Insiden',
                                        'name' => 'subtipeinsiden_namalainnya',
                                        'value' => '$data->subtipeinsiden_namalainnya',
                                        'filter' => Chtml::activeTextField($model, 'subtipeinsiden_namalainnya', array('class' => ''))
                                    ),
                                    array(
                                        'header' => '<center>Status</center>',
                                        'value' => '($data->subtipeinsiden_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
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
                                                'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("id"=>"$data->subtipeinsiden_id"))',
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
                                                'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/update",array("id"=>"$data->subtipeinsiden_id"))',
                                            ),
                                        ),
                                    ),
                                    array(
                                        'header' => 'Hapus',
                                        'type' => 'raw',
                                        'value' => function($data) {
                                            if ($data->subtipeinsiden_aktif == true) {
                                                return CHtml::link("<i class='glyphicon glyphicon-remove'></i> "
                                                        , "javascript:removeTemporary($data->subtipeinsiden_id)", 
                                                        array(
                                                            "id" => "$data->subtipeinsiden_id", 
                                                            "rel" => "tooltip", 
                                                            "data-placement"=>'left',
                                                            "title" => "Menonaktifkan Kelompok Subtipe Insiden")) . ' ' . 
                                                        CHtml::link("<i class='glyphicon glyphicon-trash'></i> ", 
                                                            "javascript:deleteRecord($data->subtipeinsiden_id)", 
                                                                array(
                                                                    "id" => "$data->subtipeinsiden_id", 
                                                                    "rel" => "tooltip", 
                                                                    "data-placement"=>'left',
                                                                    "title" => "Hapus Kelompok Subtipe Insiden"));
                                            } else {
                                                return CHtml::link("<i class='glyphicon glyphicon-check'></i> ", 
                                                        "javascript:aktifkan($data->subtipeinsiden_id)", 
                                                        array(
                                                            "id" => "$data->subtipeinsiden_id", 
                                                            "rel" => "tooltip", 
                                                            "data-placement"=>'left',
                                                            "title" => "Mengaktifkan Kelompok Subtipe Insiden")) . ' ' . 
                                                        CHtml::link("<i class='glyphicon glyphicon-trash'></i> ",
                                                            "javascript:deleteRecord($data->subtipeinsiden_id)", 
                                                                array(
                                                                    "id" => "$data->subtipeinsiden_id", 
                                                                    "rel" => "tooltip",
                                                                    "data-placement"=>'left',
                                                                    "title" => "Hapus Kelompok Subtipe Insiden"));
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
                echo CHtml::link(Yii::t('mds', '{icon} Tambah Subtipe Insiden', array('{icon}' => '<i class="entypo-plus"></i>')), $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . "&nbsp&nbsp";
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
					$("#subtipeinsiden-m-search :input[name='"+ obj.name +"']").val(obj.value);
				}
				function print(caraPrint){
					window.open("${urlPrint}/"+$('#subtipeinsiden-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
                                $.fn.yiiGridView.update('subtipeinsiden-m-grid');
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
                                $.fn.yiiGridView.update('subtipeinsiden-m-grid');
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
                                $.fn.yiiGridView.update('subtipeinsiden-m-grid');
                            } else {
                                myAlert('Data gagal di hapus karena digunakan di transaksi lain')
                            }
                        }, "json");
            }
        });
    }
</script>