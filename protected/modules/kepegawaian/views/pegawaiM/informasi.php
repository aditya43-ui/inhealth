<!--div class="white-container"-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pegawai <?php echo $this->kategoripegawaiasal ?> </b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_search', array('model' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pegawai</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="block-tabel">
                    <?php
                    $this->breadcrumbs = array(
                        'Informasi Pegawai',
                    );
                    Yii::app()->clientScript->registerScript('search', "
                                $('.search-button').click(function(){
                                        $('.search-form').toggle();
                                        return false;
                                });
                                $('#sapegawai-m-search').submit(function(){
                                        $.fn.yiiGridView.update('sapegawai-m-grid', {
                                                data: $(this).serialize()
                                        });
                                        return false;
                                });
                                ");
                    $this->widget('bootstrap.widgets.BootAlert');
                    ?>
                    <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); 
                    ?>
                    <!--<div class="cari-lanjut search-form">-->
                    <?php //$this->renderPartial('_search',array(
                    //'model'=>$model,
                    //)); 
                    ?>
                    <!--</div> search-form-->
                    <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'sapegawai-m-grid',
                        'dataProvider' => $model->search(),
                        'filter' => $model,
                        'overflowx' => true,
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                        'columns' => array(
                            array(
                                'header' => 'No. Finger Print',
                                'name' => 'nofingerprint',
                                'value' => '$data->nofingerprint',
                            ),
                            array(
                                'header' => 'NIP',
                                'name' => 'nomorindukpegawai',
                                'value' => '$data->nomorindukpegawai',
                            ), /*
                                            array(
                                                    'header'=>'Gelar Depan',
                                                    'name'=>'gelardepan',
                                                    'value'=>'$data->gelardepan',
                                            ), */
                            array(
                                'header' => 'Nama Pegawai',
                                'name' => 'nama_pegawai',
                                'value' => '$data->namaLengkap',
                            ), /*
                                            array(
                                                    'header'=>'Nama Keluarga',
                                                    'name'=>'nama_keluarga',
                                                    'value'=>'$data->nama_keluarga',
                                            ), */
                            array(
                                'header' => 'Tempat, Tanggal Lahir',
                                'value' => '$data->tempatlahir_pegawai.", ".MyFormatter::formatDateTimeForUser($data->tgl_lahirpegawai)'
                            ),
                            array(
                                'header' => 'Jenis Kelamin',
                                'name' => 'jeniskelamin',
                                'value' => '$data->jeniskelamin',
                                'filter' => CHtml::activeDropDownList($model, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('empty' => '-- Pilih --')),
                            ),
                            array(
                                'header' => 'Agama',
                                'name' => 'agama',
                                'value' => '$data->agama',
                                'filter' => CHtml::activeDropDownList($model, 'agama', LookupM::getItems('agama'), array('empty' => '-- Pilih --')),
                            ),
                            array(
                                'header' => 'Status Perkawinan',
                                'name' => 'statusperkawinan',
                                'value' => '$data->statusperkawinan',
                                'filter' => CHtml::activeDropDownList($model, 'statusperkawinan', LookupM::getItems('statusperkawinan'), array('empty' => '-- Pilih --')),
                            ), /*
                                            array(
                                                    'header'=>'Alamat Pegawai',
                                                    'name'=>'alamat_pegawai',
                                                    'value'=>'$data->alamat_pegawai',
                                            ), */
                            array(
                                'header' => 'Jabatan',
                                'name' => 'jabatan_id',
                                'value' => '(isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : "")',
                                'filter' => CHtml::activeDropDownList($model, 'jabatan_id', CHtml::listData(
                                    JabatanM::model()->findAll(array(
                                        'condition' => 'jabatan_aktif = true',
                                        'order' => 'jabatan_nama'
                                    )),
                                    'jabatan_id',
                                    'jabatan_nama'
                                ), array('empty' => '-- Pilih --')),
                            ),
                            array(
                                'header' => 'Unit Kerja',
                                'name' => 'unitkerja_id',
                                'value' => '(isset($data->unitkerja_id) ? $data->unitkerja->namaunitkerja : "")',
                                'filter' => CHtml::activeDropDownList($model, 'unitkerja_id', $model->getDropUnitKerjaItems(), array('empty' => '-- Pilih --')),
                            ),
                            array(
                                'header' => 'Lihat Riwayat',
                                'type' => 'raw',
                                'value' => 'CHtml::link("<i class=\'icon-form-riwayatpegawai\'></i>",Yii::app()->createUrl(\'kepegawaian/pegawaiM/Riwayat&id=\'.$data->pegawai_id),array("rel"=>"tooltip","title"=>"Klik untuk Detail Riwayat Pegawai"))',
                                'htmlOptions' => array('style' => 'text-align: center; width:60px'),
                            ),
                            array(
                                'header' => 'Penilaian Pegawai',
                                'type' => 'raw',
                                'value' => 'CHtml::link("<i class=\'icon-form-penilaianpegawai\'></i>",Yii::app()->createUrl(\'kepegawaian/PenilaianPegawai/index&id=\'.$data->pegawai_id),array("rel"=>"tooltip","title"=>"Klik untuk Detail Penilaian Pegawai"))',
                                'htmlOptions' => array('style' => 'text-align: center; width:60px'),
                            ),
                            array(
                                'header' => 'Kesimpulan dan Saran Penilaian',
                                'type' => 'raw',
                                'value' => 'CHtml::link("<i class=\'icon-form-penilaianpegawai\'></i>",Yii::app()->createUrl(\'kepegawaian/kesimpulanPenilaian/index&id=\'.$data->pegawai_id),array("rel"=>"tooltip","title"=>"klik untuk input kesimpulan dan saran penilaian"))',
                                'htmlOptions' => array('style' => 'text-align: center; width:60px'),
                            ),
                            array(
                                'header' => 'Kelola Data Pribadi Pegawai',
                                'type' => 'raw',
                                'value' => 'CHtml::link("<i class=\'icon-form-kelolapegawai\'></i>",Yii::app()->createUrl(\'kepegawaian/pencatatanRiwayat&id=\'.$data->pegawai_id),array("rel"=>"tooltip","title"=>"Klik untuk Kelola Data Pribadi Pegawai"))',
                                'htmlOptions' => array('style' => 'text-align: center; width:60px'),
                            ),
                            array(
                                'header' => 'Hukuman Poin Pegawai',
                                'type' => 'raw',
                                'value' => 'CHtml::link("<i class=\'icon-form-penilaianpegawai\'></i>",Yii::app()->createUrl(\'kepegawaian/hukumanPoinPegawai&id=\'.$data->pegawai_id),array("rel"=>"tooltip","title"=>"Klik untuk Kelola Data Hukuman Poin Pegawai"))',
                                'htmlOptions' => array('style' => 'text-align: center; width:60px'),
                            ),
                            array(
                                'header' => 'Komponen Gaji',
                                'type' => 'raw',
                                'value' => 'CHtml::link("<i class=\'icon-form-riwayatpegawai\'></i>",Yii::app()->createUrl(\'kepegawaian/komponenGaji&id=\'.$data->pegawai_id),array("rel"=>"tooltip","title"=>"Klik untuk Kelola Komponen Gaji Pegawai"))',
                                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            ),
                            array(
                                'header' => 'SK Tanda Tangan Elektronik',
                                'type' => 'raw',
                                'value' => 'CHtml::link("<i class=\'icon-form-riwayatpegawai\'></i>",Yii::app()->createUrl(\'/kepegawaian/ttdelktronikpegawaiskT/create&id=\'.$data->pegawai_id),array("rel"=>"tooltip","title"=>"Klik untuk Kelola SK Tanda Tangan Elektronik"))',
                                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            ),
                            array(
                                'header' => 'Status Kepegawaian',
                                'type' => 'raw',
                                'value' => '(($data->pegawai_aktif == 1 ) ? "Aktif" : "Tidak Aktif")."/<br>".($data->kategoripegawai)',
                                'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                                'filter' => CHtml::activeDropDownList($model, 'pegawai_aktif', array(true => 'Aktif', false => 'Tidak Aktif'), array('empty' => '-- Pilih --')),
                            ),
                            //                Jika pake dialog box
                            //                array(
                            //                       'header'=>'Ubah Pegawai',
                            //                       'type'=>'raw',
                            //                       'value'=>'CHtml::link("<i class=\'icon-edit\'></i>",Yii::app()->controller->createUrl(Yii::app()->controller->id."/update",
                            //                           array("id"=>$data->pegawai_id)),
                            //                           array("title"=>"Klik untuk Ubah Pegawai","target"=>"iframeUbahPegawai", "onclick"=>"$(\'#dialogUbahPegawai\').dialog(\'open\')"))', 
                            //                       'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                            //                    ),
                            array(
                                'header' => 'Kelola Data Pekerjaan Pegawai',
                                'type' => 'raw',
                                'value' => 'CHtml::link("<i class=\'icon-form-pekerjaanpegawai\'></i>",Yii::app()->createUrl(\'kepegawaian/pencatatanPekerjaan&id=\'.$data->pegawai_id),array("rel"=>"tooltip","title"=>"Klik untuk Kelola Data Pekerjaan Pegawai"))',
                                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            ),
                            array(
                                'header' => 'Ubah Pegawai',
                                'class' => 'bootstrap.widgets.BootButtonColumn',
                                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                'template' => '{update}',
                                'buttons' => array(
                                    'update' => array(
                                        //                                                                            'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                    ),
                                ),
                            ),
                            array(
                                'header' => Yii::t('zii', 'Non Aktif'),
                                'class' => 'bootstrap.widgets.BootButtonColumn',
                                'template' => '{remove}',
                                'buttons' => array(
                                    'remove' => array(
                                        'label' => "<i class='icon-form-silang'></i>",
                                        'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                                        'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/removeTemporary",array("id"=>"$data->pegawai_id"))',
                                        //'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
                                        'click' => 'function(){return confirm("' . Yii::t("mds", "Do You want to remove this item temporary?") . '");}',
                                    ), /*
                                                                                        'delete'=> array(
                                                                                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                                                                        ), */
                                ),
                                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            ),
                            //		array(
                            //                        'header'=>Yii::t('zii','View'),
                            //			'class'=>'bootstrap.widgets.BootButtonColumn',
                            //                        'template'=>'{view}',
                            //		),
                            //		
                            //		array(
                            //                        'header'=>Yii::t('zii','Delete'),
                            //			'class'=>'bootstrap.widgets.BootButtonColumn',
                            //                        'template'=>'{remove} {delete}',
                            //                        'buttons'=>array(
                            //                        'remove' => array (
                            //                                'label'=>"<i class='icon-form-silang'></i>",
                            //                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                            //                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->pegawai_id"))',
                            //                                //'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
                            //                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
                            //                        ),
                            //                        'delete'=> array(
                            //                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                            //                        ),
                            //                        )
                            //		),
                        ),
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                    )); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="dialog" title="Perhatian!" style="display:none;min-width:600px;">
    <!-- Some problem -->
    <div id="msgstr"></div>
</div>
<!--/div-->
<?php
//        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
//        $content = $this->renderPartial('../tips/master',array(),true);
//$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
//        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
//        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
//        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
//
//$js = <<< JSCRIPT
//function print(caraPrint)
//{
//    window.open("${urlPrint}/"+$('#sapegawai-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
//}
//JSCRIPT;
//Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<?php
// Dialog untuk menambah data provinsi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPenilaianPegawai',
    'options' => array(
        'title' => 'Penilaian Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 980,
        'height' => 610,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('penilaianpegawait-grid', {
                        data: $('#penilaianpegawai-t-form').serialize()
                    }); }",
    ),
));
?>
<iframe src="" name="iframePenilaianPegawai" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end propinsi dialog =============================
?>
<?php
//======================= Dialog Ubah Data Pegawai ===========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogUbahPegawai',
    'options' => array(
        'title' => 'Ubah Data Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1024,
        'height' => 500,
        'resizable' => false,
    ),
));
echo '<iframe src="" name="iframeUbahPegawai" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget();
//==============================================================================
?>
<script>
    function refreshGrid() {
        $.fn.yiiGridView.update('sapegawai-m-grid');
        return false;
    }
    /**
     * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
     * @param {type} caraPrint
     * @returns {undefined}
     * - digunakan untuk mencetak
     */
    function printInfo(caraPrint) {
        window.open('<?php echo $this->createUrl('printInfo'); ?>/' + $('#sapegawai-m-search').serialize() + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640,scrollbars=1');
    }

    function printPegawai(caraPrint) {
        window.open("<?php echo $this->createUrl('printPegawai'); ?>&" +
            $("#sapegawai-m-search :input").not("input[name='r']").serialize() +
            "&caraPrint=" + caraPrint, "", 'location=_new, width=900px');
    }
    $(document).ready(function() {
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('PegawaiM/GetMasaAktifPegawai'); ?>',
            success: function(data) {
                // console.log(data.str)
                json = JSON.parse(data)
                // // myAlert(data.str)
                // console.log(json.str)
                if (json.show) {
                    // console.log(data.str)
                    $("#dialog").dialog();
                    $('#msgstr').append(json.table)
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    });
</script>