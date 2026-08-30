<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Bank Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Bank Pasien' => array('admin'),
            'Manage',
        );

        $this->menu = array(
            //        array('label'=>Yii::t('mds','Manage').' Satuan Barang ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
            //	array('label'=>Yii::t('mds','List').' Lookup', 'icon'=>'list', 'url'=>array('index')),
            //	array('label'=>Yii::t('mds','Create').' Satuan Barang', 'icon'=>'file', 'url'=>array('create')),
        );

        Yii::app()->clientScript->registerScript('search', "
				$('.search-button').click(function(){
					$('.search-form').toggle();
					$('#GULookupM_lookup_type').focus();
					return false;
				});
				$('.search-form form').submit(function(){
					$.fn.yiiGridView.update('lookup-m-grid', {
						data: $(this).serialize()
					});
					return false;
				});
				");

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            )); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Bank Pasien</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--<h6>Tabel <b>Satuan Barang</b></h6>-->
                <?php //echo CHtml::dropDownList('agama', '', LookupM::getItems('agama')); 
                ?>
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'lookup-m-grid',
                    'dataProvider' => $model->searchBank(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        ////'lookup_id',
                        array(
                            'header' => 'ID',
                            'value' => '$data->lookup_id',
                        ),
                        //'lookup_type',
                        array(
                            'header' => 'Tipe',
                            'value' => '$data->lookup_type',
                            //'filter'=> CHtml::dropDownList('SALookupM[lookup_type]',$model->lookup_type,CHtml::listData(LookupM::getItems('satuanbarang'), 'lookup_type', 'lookup_type'), array('empty'=>'-- Pilih --')),
                        ),
                        array(
                            'header' => 'Nama',
                            'name' => 'lookup_name',
                            'value' => '$data->lookup_name',
                            'filter' => CHtml::activeTextField($model, 'lookup_name'),
                        ),
                        array(
                            'header' => 'Value',
                            'name' => 'lookup_value',
                            'value' => '$data->lookup_value',
                            'filter' => false
                            //										'filter'=>CHtml::activeTextField($model, 'lookup_name'),
                        ),
                        array(
                            //										'header'=>'Lookup Name',
                            'name' => 'lookup_kode',
                            'value' => '$data->lookup_name',
                            'filter' => false
                            //										'filter'=>CHtml::activeTextField($model, 'lookup_name'),
                        ),
                        array(
                            'name' => 'lookup_urutan',
                            'value' => '$data->lookup_name',
                            'filter' => false
                            //										'filter'=>CHtml::activeTextField($model, 'lookup_name'),
                        ),
                        array(
                            'header' => 'Status',
                            'value' => '($data->lookup_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),
                        //'lookup_aktif',
                        //                array(
                        //                        'header'=>'Aktif',
                        //                        'class'=>'CCheckBoxColumn',
                        //                        'selectableRows'=>0,
                        //                        'id'=>'rows',
                        //                        'checked'=>'$data->lookup_aktif',
                        //                ),
                        array(
                            'header' => Yii::t('zii', 'View'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{view}',
                        ),
                        array(
                            'header' => Yii::t('zii', 'Update'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{update}',
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->lookup_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->lookup_id)",array("id"=>"$data->lookup_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->lookup_id)",array("id"=>"$data->lookup_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->lookup_id)",array("id"=>"$data->lookup_id","rel"=>"tooltip","title"=>"Hapus"));',
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

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Bank Pasien', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah Bank Pasien', 'class' => 'btn btn-danger')
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('keuangan.views.tips.master', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
				function cekForm(obj){
					$("#sakonfigfarmasi-k-search :input[name='"+ obj.name +"']").val(obj.value);
				}
				function print(caraPrint){
					window.open("${urlPrint}/"+$('#sakonfigfarmasi-k-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
				}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm('Yakin akan menonaktifkan data ini untuk sementara?', 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('lookup-m-grid');
                        } else {
                            myAlert('Data gagal dinonaktifkan!')
                        }
                    }, "json");
            }
        });
    }

    function deleteRecord(id) {
        var id = id;
        var url = '<?php echo $url . "/delete"; ?>';
        myConfirm('Yakin Akan Menghapus Data ini?', 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('lookup-m-grid');
                        } else {
                            myAlert('Data gagal dihapus!')
                        }
                    }, "json");
            }
        });
    }
    $('.filters #GULookupM_lookup_name').focus();
</script>