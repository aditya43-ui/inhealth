<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>FAQ</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $arrMenu = array();
        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
				$('.search-button').click(function(){
					$('.search-form').toggle();
					return false;
				});
				$('.search-form form').submit(function(){
					$.fn.yiiGridView.update('faq-m-grid', {
						data: $(this).serialize()
					});
					return false;
				});
				");

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial('_search', array(
                'model' => $model,
            )); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>FAQ</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'faq-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        // ''
                        array(
                            'header'=>'Modul',
                            'name'=>'modul',
                            'filter'=>Chtml::activeDropDownList($model, 'modul_id', CHtml::listData(ModulK::model()->findAll(array('order'=>'modul_nama ASC'),'modul_aktif = true'), 'modul_id', 'modul_nama'), array('empty' => '-- Pilih --','style'=>'margin-top:4px; width: 150px;')),
                            'value'=>'$data->modul->modul_nama',
                            'htmlOptions' => array('style' => 'width: 150px;'),
                        ),
                        'faq_pertanyaan',
                        'faq_jawaban',
                        'faq_urutan',
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat FAQ'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah FAQ'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->faq_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->faq_id)",array("id"=>"$data->faq_id","rel"=>"tooltip","title"=>"Menonaktifkan FAQ"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->faq_id)",array("id"=>"$data->faq_id","rel"=>"tooltip","title"=>"Hapus FAQ")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->faq_id)",array("id"=>"$data->faq_id","rel"=>"tooltip","title"=>"Hapus FAQ"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
								jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
								$("table").find("input[type=text]").each(function(){
									cekForm(this);
								})
							}',
                )); ?>
            </div>
        </div>
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        echo CHtml::link(
            Yii::t('mds', '{icon} Tambah FAQ', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
            $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
            array('title' => 'Tambah FAQ', 'class' => 'btn btn-danger',)
        );
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
        $content = $this->renderPartial('tips/tipsAdmin', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        $urlPrint =  $this->createUrl('print');
        $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
        $js = <<< JSCRIPT
				function cekForm(obj){
					$("#faq-m-search :input[name='"+ obj.name +"']").val(obj.value);
				}
				function print(caraPrint){
					window.open("${urlPrint}/"+$('#faq-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
				}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
    </div>
</div>

<!--<div class="white-container">
    <legend class="rim2">Pengaturan <b>FAQ</b></legend>
    <div class="biru">
        <div class="white">-->
<!--<h6>Tabel <b>FAQ</b></h6>-->
<!--</div>-->
<!--</div>
    </div>-->
<!--</div>-->
<script type="text/javascript">
    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm('Yakin akan menonaktifkan data ini untuk sementara?', 'Perhatian!',
            function(r) {
                if (r) {
                    $.ajax({
                        type: 'GET',
                        url: url,
                        data: {id: id}, //
                        dataType: "json",
                        success: function(data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('faq-m-grid');
                            } else {
                                myAlert('Data gagal dinonaktifkan!')
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            myAlert('Data gagal dinonaktifkan!');
                            console.log(errorThrown);
                        }
                    });
                }
            });

    }

    function deleteRecord(id) {
        var id = id;
        var url = '<?php echo $url . "/delete"; ?>';
        myConfirm('Yakin Akan Menghapus Data ini?', 'Perhatian!',
            function(r) {
                if (r) {
                    $.ajax({
                        type: 'GET',
                        url: url,
                        data: {id: id}, //
                        dataType: "json",
                        success: function(data) {
                            $.fn.yiiGridView.update('faq-m-grid');
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            myAlert('Data gagal dihapus!');
                            console.log(errorThrown);
                        }
                    });
                }
            });
    }
</script>