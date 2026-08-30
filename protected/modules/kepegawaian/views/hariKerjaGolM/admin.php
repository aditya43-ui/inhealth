<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Hari Kerja Pegawai</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Hari Kerja Golongan' => array('admin'),
        );

        $arrMenu = array();
        (Yii::app()->user->checkAccess('Admin')) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Hari Kerja Golongan  ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) :  '';
        (Yii::app()->user->checkAccess('Create')) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Create') . ' Hari Kerja Golongan ', 'icon' => 'file', 'url' => array('create'))) :  '';

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
                $('.search-button').click(function(){
                    $('.search-form').toggle();
                    $('#KPHariKerjaGolM_jmlharikerja').focus();
                    return false;
                });
                $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('golongan-gaji-m-grid', {
                        data: $(this).serialize()
                    });
                    return false;
                });
                ");

        $this->widget('bootstrap.widgets.BootAlert');
        //$this->renderPartial('_tabMenu',array());
        ?>

        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial('_search', array(
                'model' => $model,
            )); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b> Hari Kerja Pegawai</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'golongan-gaji-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{pager}{summary}\n{items}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        /*
                                array (
                                        'name'=>'harikerjagol_id',
                                        'value'=>'$data->harikerjagol_id',
                                        'filter'=>false,
                                ),
                                 * 
                                 */
                        array(
                            'header' => 'Kelompok Pegawai',
                            'name' => 'kelompokpegawai_id',
                            'value' => '$data->kelompokpegawai->kelompokpegawai_nama',
                            'filter' => Chtml::dropDownList('KPHariKerjaGolM[kelompokpegawai_id]', $model->kelompokpegawai_id, CHtml::listData(KPKelompokpegawaiM::model()->findAll('kelompokpegawai_aktif = true ORDER BY kelompokpegawai_nama ASC'), 'kelompokpegawai_id', 'kelompokpegawai_nama'), array('empty' => ' -- Pilih --'))
                        ),
                        array(
                            'name' => 'periodeharikerjaawl',
                            'filter' => CHtml::activeDropDownList($model, 'periodeharikerjaawl', CustomFunction::getNamaHari(), array('class' => 'span2  required', 'onkeyup' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --'))
                            //'value'=>'MyFormatter::formatDateTimeForUser($data->periodeharikerjaawl)',									

                            /*'filter'=>$this->widget('MyDateTimePicker', array(
                                        'model'=>$model, 
                                        'attribute'=>'periodeharikerjaawl', 
                                        'mode' => 'date',    
                                        //'language' => 'ja',
                                        // 'i18nScriptFile' => 'jquery.ui.datepicker-ja.js', (#2)
                                        'htmlOptions' => array(
                                            'id' => 'datepicker_for_due_date2',
                                            'size' => '10',
                                            'style'=>'width:80%'
                                        ),
                                        'options' => array(  // (#3)                    
                                            'dateFormat' => Params::DATE_FORMAT,                    
                                            'maxDate' => 'd',
                                        ),                            
                                    ), 
                                    true),*/
                        ),
                        array(
                            'name' => 'periodeharikerjaakhir',
                            'filter' => CHtml::activeDropDownList($model, 'periodeharikerjaakhir', CustomFunction::getNamaHari(), array('class' => 'span2  required', 'onkeyup' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --'))
                            /*'value'=>'MyFormatter::formatDateTimeForUser($data->periodehariakhir)',
                                    'filter'=>$this->widget('MyDateTimePicker', array(
                                        'model'=>$model, 
                                        'attribute'=>'periodehariakhir', 
                                        'mode' => 'date',    
                                        //'language' => 'ja',
                                        // 'i18nScriptFile' => 'jquery.ui.datepicker-ja.js', (#2)
                                        'htmlOptions' => array(
                                            'id' => 'datepicker_for_due_date1',
                                            'size' => '10',
                                            'style'=>'width:80%'
                                        ),
                                        'options' => array(  // (#3)                    
                                            'dateFormat' => Params::DATE_FORMAT,                    
                                            'maxDate' => 'd',
                                        ),                            
                                    ), 
                                    true),*/
                        ),
                        //array(
                        // 'name'=>'periodeharikerjaakhir',
                        /*'value'=>'MyFormatter::formatDateTimeForUser($data->periodeharikerjaakhir)',
                                    'filter'=>$this->widget('MyDateTimePicker', array(
                                        'model'=>$model, 
                                        'attribute'=>'periodeharikerjaakhir', 
                                        'mode' => 'date',    
                                        //'language' => 'ja',
                                        // 'i18nScriptFile' => 'jquery.ui.datepicker-ja.js', (#2)
                                        'htmlOptions' => array(
                                            'id' => 'datepicker_for_due_date',
                                            'size' => '10',
                                            'style'=>'width:80%'
                                        ),
                                        'options' => array(  // (#3)                    
                                            'dateFormat' => Params::DATE_FORMAT,                    
                                            'maxDate' => 'd',
                                        ),                            
                                    ), 
                                    true),*/
                        // ),                              
                        /*array(
                                    'header' => 'Jumlah Hari Bulan',
                                    'name' => 'jmlharibln',
                                    'value' => '$data->jmlharibln',
                                    'filter'=>  CHtml::activeTextField($model, 'jmlharibln', array('class'=>'numbers-only','style'=>'text-align:right;')),
                                    'htmlOptions' => array('style'=>'text-align:right;')
                                ),*/
                        array(
                            'header' => 'Status',
                            'value' => '($data->harikerjagol_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->harikerjagol_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->harikerjagol_id)",array("id"=>"$data->harikerjagol_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->harikerjagol_id)",array("id"=>"$data->harikerjagol_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->harikerjagol_id)",array("id"=>"$data->harikerjagol_id","rel"=>"tooltip","title"=>"Hapus"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
                                jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                                reinstallDatePicker();    
                                reinstallDatePicker1();
                                reinstallDatePicker2();
                                $("table").find("input[type=text]").each(function(){
                                    cekForm(this);
                                })
                                $("table").find("select").each(function(){
                                    cekForm(this);
                                })
                            }',
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Hari Kerja Pegawai', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah hari kerja pegawai', 'class' => 'btn btn-danger',)
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
                function cekForm(obj){
                    $("#golongan-gaji-m-search :input[name='"+ obj.name +"']").val(obj.value);
                }
                function print(caraPrint){
                    window.open("${urlPrint}/"+$('#golongan-gaji-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
                }
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);

            Yii::app()->clientScript->registerScript('re-install-date-picker', "
                    function reinstallDatePicker(id, data) {        
                        $('#datepicker_for_due_date').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['id'],{'dateFormat':'" . Params::DATE_FORMAT . "','changeMonth':true, 'changeYear':true,'maxDate':'d'}));
                    }
                    function reinstallDatePicker1(id, data) {        
                        $('#datepicker_for_due_date1').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['id'],{'dateFormat':'" . Params::DATE_FORMAT . "','changeMonth':true, 'changeYear':true,'maxDate':'d'}));
                    }
                    function reinstallDatePicker2(id, data) {        
                        $('#datepicker_for_due_date2').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['id'],{'dateFormat':'" . Params::DATE_FORMAT . "','changeMonth':true, 'changeYear':true,'maxDate':'d'}));
                    }
                ");
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm('Apakah Anda yakin ingin menonaktifkan data ini untuk sementara?', 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('golongan-gaji-m-grid');
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
        myConfirm('Apakah Anda yakin igin menghapus data ini?', 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('golongan-gaji-m-grid');
                        } else {
                            myAlert('Data gagal dihapus!')
                        }
                    }, "json");
            }
        });
    }
</script>