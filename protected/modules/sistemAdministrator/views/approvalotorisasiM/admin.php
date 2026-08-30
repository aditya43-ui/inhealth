<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-cogs"></i> Konfigurasi <b> Otorisasi Approval</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Konfigurasi Otorisasi Approval',
        );

        $this->menu = array(
            array('label' => 'List ApprovalotorisasiM', 'url' => array('index')),
            array('label' => 'Create ApprovalotorisasiM', 'url' => array('create')),
        );

        Yii::app()->clientScript->registerScript('search', "
						$('.search-button').click(function(){
							$('.search-form').toggle();
							return false;
						});
						$('.search-form form').submit(function(){
							$.fn.yiiGridView.update('approvalotorisasi-m-grid', {
								data: $(this).serialize()
							});
							return false;
						});
					");
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id;
        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial('_search', array(
                'model' => $model,
            )); ?>
        </div>
        <!--search-form-->
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Konfigurasi Otorisasi Approval</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'approvalotorisasi-m-grid',
                    'dataProvider' => $model->search(),
                    // 'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
												($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
												: ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        // 'kepalagizi_id',
                        array(
                            'header' => 'Kepala Instalasi Gizi',
                            'value' => '(isset($data->kepalagizi_id)? $data->kepalagizi->namaLengkap:"")',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        // 'kepalafarmasi_id',
                        array(
                            'header' => 'Kepala Instalasi Farmasi',
                            'value' => '(isset($data->kepalafarmasi_id)? $data->kepalafarmasi->namaLengkap:"")',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        // 'kepalaumum_id',
                        array(
                            'header' => 'Kepala Instalasi Gudang Umum',
                            'value' => '(isset($data->kepalaumum_id)? $data->kepalaumum->namaLengkap:"")',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        // 'kasipersonalia_id',
                        array(
                            'header' => 'Kasi Personalia',
                            'value' => '(isset($data->kasipersonalia_id)? $data->kasipersonalia->namaLengkap:"")',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        // 'managerumum_id',
                        array(
                            'header' => 'Manager Umum',
                            'value' => '(isset($data->managerumum_id)? $data->managerumum->namaLengkap:"")',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        // 'managerkeuangan_id',
                        array(
                            'header' => 'Manager Keuangan',
                            'value' => '(isset($data->managerkeuangan_id)? $data->managerkeuangan->namaLengkap:"")',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        // 'direkturrs_id',
                        array(
                            'header' => 'Direktu RS',
                            'value' => '(isset($data->direkturrs_id)? $data->direkturrs->namaLengkap:"")',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        // 'direkturpt_id',
                        array(
                            'header' => 'Direktu PT',
                            'value' => '(isset($data->direkturpt_id)? $data->direkturpt->namaLengkap:"")',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),

                        array(
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                        ),
                    ),
                ));
                ?>
            </div>
        </div>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Tambah Tindakan Ruangan', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
        $tips = array(
            '0' => 'ubah',
            '1' => 'lihat',
            '2' => 'hapus',
            '3' => 'pencarianlanjut',
            '4' => 'cari',
            '5' => 'masterPRINT',
            '6' => 'masterEXCEL',
            '7' => 'masterPDF',
        );
        $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
        $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
        $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
        $js = <<< JSCRIPT
					function cekForm(obj){
						$("#approvalotorisasi-m-search :input[name='"+ obj.name +"']").val(obj.value);
					}
					function print(caraPrint){
						window.open("${urlPrint}/"+$('#approvalotorisasi-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
					}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('input[name="SATindakanruanganM[daftartindakan_nama]"]').focus();
    });
</script>