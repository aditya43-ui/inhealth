<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Master <strong>Bed Triage</strong></div>
            </div>
            <div class="panel-body">
                <?php
                $sukses = null;
                if (isset($_GET['sukses'])) {
                    $sukses = $_GET['sukses'];
                }
                if ($sukses > 0) {
                    Yii::app()->user->setFlash('success', "Data Bed Triage berhasil disimpan!");
                }
                ?>
                <?php
                $this->breadcrumbs = array(
//						'Bed Triage'=>array('index'),
                    'Bed Triage',
                );

                $arrMenu = array();
                //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Bed Triage ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
                //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Bed Triage ', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

                $this->menu = $arrMenu;

       
                ?>

                <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
                <p></p>
                <div class="cari-lanjut2 search-form" style="display:none;padding: 10px; border: 1px solid">
                    <?php
                    $this->renderPartial($this->path_view . '_search', array(
                        'model' => $model,
                    ));
                    ?>
                </div><hr>
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Bed Triage</strong></div>
                    </div>
                    <div class="panel-body" style="overflow-x: scroll">
                        <?php
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'bed-triage-m-grid',
                            'dataProvider' => $model->searchBedTriage(),
//                            'filter' => $model,
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                            'columns' => array(
                                array(
                                    'header' => 'No.',
                                    'value' => '$row+1',
                                ),
                                array(
                                    'header' => 'No. Bed Triage',
                                    'name' => 'no_bed',
                                    'value' => '$data->no_bed',
                                ),
                                array(
                                    'header' => 'Keterangan',
                                    'name' => 'keterangan',
                                    'value' => '$data->keterangan',
                                ),
                                array(
                                    'header' => 'Status',
                                    'value' => '($data->is_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                ),
                                array(
                                    'header' => Yii::t('zii', 'View'),
                                    'class' => 'bootstrap.widgets.BootButtonColumn',
                                    'template' => '{view}',
                                    'buttons' => array(
                                        'view' => array(
                                            'options' => array('rel' => 'tooltip', 'title' => 'Lihat Bed Triage'),
                                        ),
                                    ),
                                ),
                                array(
                                    'header' => Yii::t('zii', 'Update'),
                                    'class' => 'bootstrap.widgets.BootButtonColumn',
                                    'template' => '{update}',
                                    'buttons' => array(
                                        'update' => array(
                                            'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                            'options' => array('rel' => 'tooltip', 'title' => 'Ubah Bed Triage'),
                                        ),
                                    ),
                                ),
                                array(
                                    'header' => 'Hapus',
                                    'type' => 'raw',
                                    'value' => '($data->is_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->bed_triage_id)",array("id"=>"$data->bed_triage_id","rel"=>"tooltip","title"=>"Menonaktifkan Bed Triage"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->bed_triage_id)",array("id"=>"$data->bed_triage_id","rel"=>"tooltip","title"=>"Hapus Bed Triage")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->bed_triage_id)",array("id"=>"$data->bed_triage_id","rel"=>"tooltip","title"=>"Hapus Bed Triage"));',
                                    'htmlOptions' => array('style' => 'text-align: center; width:40px'),
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
								$(".custom-only").keyup(function() {
									setCustomOnly(this);
								});
								$(".numbers-only").keyup(function() {
									setNumbersOnly(this);
								});
							}',
                        ));
                        ?>
                    </div>
                </div>
                <?php
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                echo CHtml::link(Yii::t('mds', '{icon} Tambah Bed Triage', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . "&nbsp&nbsp";
                echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
                $content = $this->renderPartial($this->path_view . 'tips/tipsAdmin', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
                $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

                $js = <<< JSCRIPT
				function cekForm(obj){
					$("#search :input[name='"+ obj.name +"']").val(obj.value);
				}
				function print(caraPrint){
					window.open("${urlPrint}/"+$('#search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
        myConfirm('Yakin akan menonaktifkan data ini untuk sementara?', 'Perhatian!',
                function (r) {
                    if (r) {
                        $.post(url, {id: id},
                                function (data) {
                                    if (data.status == 'proses_form') {
                                        $.fn.yiiGridView.update('bed-triage-m-grid');
                                    } else {
                                        myAlert('Data Gagal di Nonaktifkan');
                                    }
                                }, "json");
                    }
                });

    }

    function deleteRecord(id) {
        var id = id;
        var url = '<?php echo $url . "/delete"; ?>';
        myConfirm('Yakin Akan Menghapus Data ini?', 'Perhatian!',
                function (r) {
                    if (r) {
                        $.post(url, {id: id},
                                function (data) {
                                    if (data.status == 'proses_form') {
                                        $.fn.yiiGridView.update('bed-triage-m-grid');
                                    } else if (data.status == 'warning') {
                                        myAlert(data.pesan);
                                    } else {
                                        myAlert('Data Gagal di Hapus');
                                    }
                                }, "json");
                    }
                });
    }
    $('.filters #BedTriageM_no_bed').focus();
</script>