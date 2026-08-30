<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Penjamin Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Penjamin Pasien' => array('index'),
            'Manage',
        );

        Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
    $('#PPPenjaminpasienM_carabayar_id').focus();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('pppenjaminpasien-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial('_search', array(
                'model' => $model,
            )); ?>
        </div>
        <!--search-form-->

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Penjamin Pasien</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="overflow-x">
                    <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'pppenjaminpasien-m-grid',
                        'dataProvider' => $model->search(),
                        'filter' => $model,
                        'template' => "{summary}\n{items}{pager}",
                        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                        'columns' => array(
                            array(
                                'header' => 'No.',
                                'value' => '($this->grid->dataProvider->pagination) ? 
						($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
						: ($row+1)',
                                'type' => 'raw',
                                //'htmlOptions'=>array('style'=>'text-align:right;'),
                            ),
                            /*array(
                        'name'=>'penjamin_id',
                        'value'=>'$data->penjamin_id',
                        'filter'=>false,
                ),*/
                            array(
                                'header' => 'Jenis Penjamin',
                                'name' => 'carabayar_id',
                                'value' => '$data->carabayar->carabayar_nama',
                                'filter' => CHtml::dropDownList('PPPenjaminpasienM[carabayar_id]', $model->carabayar_id, CHtml::listData($model->getCarabayarItems(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --')),
                            ),
                            'penjamin_nama',
                            'penjamin_namalainnya',
                            array(
                                'header' => 'Jenis Tarif',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    $jenis = JenistarifpenjaminM::model()->findByAttributes(array(
                                        'penjamin_id' => $data->penjamin_id
                                    ));

                                    if (empty($jenis)) return "-";
                                    $jen = JenistarifM::model()->findByPk($jenis->jenistarif_id);
                                    return $jen->jenistarif_nama;
                                }
                            ),
                            array(
                                'name' => 'diskon_klaim',
                                'value' => 'number_format($data->diskon_klaim, 2, ",", "")',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                ),
                                'filter' => false,
                            ),
                            array(
                                'name' => 'lama_tempo',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                ),
                                'filter' => false,
                            ),
                            array(
                                'name' => 'biaya_administrasi',
                                'value' => 'number_format($data->biaya_administrasi, 2, ",", "")',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                ),
                                'filter' => false,
                            ),
                            array(
                                'name' => 'diskon_rj',
                                'value' => 'number_format($data->diskon_rj, 2, ",", "")',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                ),
                                'filter' => false,
                            ),
                            array(
                                'name' => 'diskon_rd',
                                'value' => 'number_format($data->diskon_rd, 2, ",", "")',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                ),
                                'filter' => false,
                            ),
                            array(
                                'name' => 'diskon_ri',
                                'value' => 'number_format($data->diskon_ri, 2, ",", "")',
                                'htmlOptions' => array(
                                    'style' => 'text-align: right;',
                                ),
                                'filter' => false,
                            ),
                            array(
                                'header' => 'Status',
                                'value' => '($data->penjamin_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            ),
                            //'penjamin_aktif',
                            //                array(
                            //                    'header'=>'Aktif',
                            //                    'class'=>'CCheckBoxColumn',
                            //                    'selectableRows'=>0,
                            //                    'id'=>'rows',
                            //                    'checked'=>'$data->penjamin_aktif',
                            //                ),
                            array(
                                'header' => 'Lihat',
                                'type' => 'raw',
                                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                'value' => 'CHtml::Link("<i class=\"icon-form-lihat\"></i>",Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("id"=>$data->penjamin_id)),
                                 array("class"=>"view",
                                       "rel"=>"tooltip",
                                       "title"=>"Lihat Penjamin Pasien",
                         ))',
                            ),
                            array(
                                'header' => 'Ubah',
                                'type' => 'raw',
                                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                'value' => 'CHtml::Link("<i class=\"icon-form-ubah\"></i>",Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/update",array("id"=>$data->penjamin_id)),
                                 array("class"=>"update",
                                       "rel"=>"tooltip",
                                       "title"=>"Ubah Penjamin Pasien",
                         ))',
                            ),
                            array(
                                'header' => 'Hapus',
                                'type' => 'raw',
                                'value' => '($data->penjamin_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->penjamin_id)",array("id"=>"$data->penjamin_id","rel"=>"tooltip","title"=>"Menonaktifkan Penjamin Pasien"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->penjamin_id)",array("id"=>"$data->penjamin_id","rel"=>"tooltip","title"=>"Hapus Penjamin Pasien")):CHtml::link("<i class=\'entypo-trash\'></i> ", "javascript:deleteRecord($data->penjamin_id)",array("id"=>"$data->penjamin_id","rel"=>"tooltip","title"=>"Hapus Penjamin Pasien"));',
                                'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            ),
                        ),
                        'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
            $("table").find("input[type=text]").each(function(){
                cekForm(this);
            })
            $("table").find("select").each(function(){
                cekForm(this);
            })
        }',
                    )); ?>
                </div>


                <?php
                /*
<table>
    <tr>
        <td width="12%"><?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
            <div class="cari-lanjut search-form">
            <?php $this->renderPartial('_search',array(
                'model'=>$model,
            )); ?>
            </div><!--search-form--></td>
        <td width="15%"><?php echo CHtml::link(Yii::t('mds', '{icon} Tambah Penjamin Pasien', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('/pendaftaranPenjadwalan/penjaminpasienM/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?></td>
        <td width="8%"><?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
        'type'=>'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'buttons'=>array(
            array('label'=>'Print', 'icon'=>'entypo-print', 'url'=>'#', 'htmlOptions'=>array('onclick'=>'print(\'PRINT\')')),
            array('label'=>'', 'items'=>array(
                array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'PDF\')')),
                array('label'=>'Excel','icon'=>'icon-pdf', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'EXCEL\')')),
                array('label'=>'Grafik','icon'=>'entypo-print', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'GRAFIK\')')),
            )),       
        ),
//        'htmlOptions'=>array('class'=>'btn')
        ));?>
        </td>
        <td><?php $content = $this->renderPartial('../tips/master',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
            $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller); ?>   </td>
    </tr>
</table>
*/ ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Penjamin Pasien', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('/pendaftaranPenjadwalan/penjaminpasienM/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah penjamin pasien', 'class' => 'btn btn-danger')
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('../tips/master', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
        
          function cekForm(obj)
{
    $("#pppenjaminpasien-m-search :input[name='"+ obj.name +"']").val(obj.value);
}     
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#pppenjaminpasien-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>

        <script type="text/javascript">
            function removeTemporary(id) {
                var url = '<?php echo $url . "/removeTemporary"; ?>';
                myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!", function(r) {
                    if (r) {
                        $.post(url, {
                                id: id
                            },
                            function(data) {
                                if (data.status == 'proses_form') {
                                    $.fn.yiiGridView.update('pppenjaminpasien-m-grid');
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
                myConfirm("Yakin Akan Menghapus Data ini?", "Perhatian!", function(r) {
                    if (r) {
                        $.post(url, {
                                id: id
                            },
                            function(data) {
                                if (data.status == 'proses_form') {
                                    $.fn.yiiGridView.update('pppenjaminpasien-m-grid');
                                } else if (data.status == 'warning') {
                                    myAlert('Tidak bisa dihapus karena data ini digunakan di table tanggunganpenjamin_m')
                                } else {
                                    myAlert('Data gagal dihapus!')
                                }
                            }, "json");
                    }
                });
            }
        </script>
    </div>
</div>