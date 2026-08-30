<style>
.fa-disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>

<?php
$this->breadcrumbs = array(
    'Informasi Forbes Bedah Sentral',
);

$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

Yii::app()->clientScript->registerScript('cariwew', "
    $('#daftarPasiens-form').submit(function(){
        $('#daftarpasien-v-grid').addClass('animation-loading');
        $.fn.yiiGridView.update('daftarpasien-v-grid', {
                data: $(this).serialize()
        });
        return false;
    });
    ");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Informasi <b>Laporan Forbes Bedah Elektif</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Laporan Forbes Bedah Elektif</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'daftarpasien-v-grid',
                    'dataProvider' => $model->searchLaporan(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'replaceUrl' => true,
                    'columns' => array(

                        array(
                            'header' => 'NO.',
                            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:left;'),
                        ),

                        array(
                            'header' => 'TANGGAL RENCANA OPERASI',
                            'name' => 'tglrencanaoperasi',
                            'filter' => $this->widget(
                                'MyDateTimePicker',
                                array(
                                    'model' => $model,
                                    'attribute' => 'tglrencanaoperasi',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array('readonly' => false, 'class' => 'span3 dtPicker3', 'id' => 'tglrencanaoperasi', 'placeholder' => ''),
                                ),
                                true
                            ),
                            'value' => function ($data) {

                                return MyFormatter::formatDateTimeForUser($data->tglrencanaoperasi);

                            },
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:left;'),
                        ),

                        array(
                            'header' => 'OK',
                            'name' => 'kamarruangan_nobed',
                            'value' => 'isset($data->kamarruangan_nobed) ? $data->kamarruangan_nobed : ""',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:left;'),
                        ),


                        array(
                            'header' => 'JAM',
                            'name' => 'jam_mulai',
                            'filter' => $this->widget(
                                'MyDateTimePicker',
                                array(
                                    'model' => $model,
                                    'attribute' => 'jam_mulai',
                                    'mode' => 'time',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array('readonly' => false, 'class' => 'span3 dtPicker3', 'id' => 'jam_mulai', 'placeholder' => ''),
                                ),
                                true
                            ),
                            'value' => function ($data) {

                                $jam_mulai = $data->jam_mulai;
                                $jam = null;

                                if(!empty($jam_mulai)) {

                                    $jam = $jam_mulai;
                                }

                                return !empty($jam_mulai) ? $jam : '';

                            },
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:left;'),
                        ),
                        array(
                            'header' => 'NAMA/JK/UMUR',
                            'name' => 'nama_pasien',
                            'value' => function ($data) {

                                $nama = $data->nama_pasien;
                                $jk = $data->jeniskelamin;
                                $umur = $data->umur . " TH";

                                return "$nama/$jk/$umur";
                                
                            },
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:left;'),
                        ),
                        array(
                            'header' => 'REGISTER',
                            'name' => 'no_rekam_medik',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:left;'),
                        ),
                        array(
                            'header' => 'RUANG',
                            'name' => 'ruanganasal_nama',
                            // 'value' => 'isset($data->kamarruangan_nokamar) ? $data->kamarruangan_nokamar : "-"',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:left;'),
                        ),
                        array(
                            'header' => 'DIAGNOSIS',
                            'name' => 'diagnosa_nama',
                            // 'value' => 'isset($data->kamarruangan_nokamar) ? $data->kamarruangan_nokamar : "-"',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:left;'),
                        ),
                        array(
                            'header' => 'RENCANA TINDAKAN',
                            'name' => 'operasi_nama',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:left;'),
                        ),
                        array(
                            'header' => 'SMF',
                            'name' => 'jeniskasuspenyakit_nama',
                            // 'value' => 'isset($data->kamarruangan_nokamar) ? $data->kamarruangan_nokamar : "-"',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:left;'),
                        ),
                        array(
                            'header' => 'KELAS PELAYANAN',
                            'name' => 'kelaspelayanan_nama',
                            'filter' => CHtml::activeDropDownList($model, 'kelaspelayanan_id', CHtml::listData(
                                KelaspelayananM::model()->findAll(array(
                                    'condition' => 'kelaspelayanan_aktif = true',
                                    'order' => 'urutankelas',
                                )),
                                'kelaspelayanan_id',
                                'kelaspelayanan_nama'
                            ), array('empty' => '-- Pilih --')),
                            // 'value' => 'isset($data->kamarruangan_nokamar) ? $data->kamarruangan_nokamar : "-"',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:left;'),
                        ),
                        array(
                            'header' => 'DPJP',
                            'name' => 'dpjp_nama',
                            // 'value' => 'isset($data->kamarruangan_nokamar) ? $data->kamarruangan_nokamar : "-"',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:left;'),
                        ),
                        array(
                            'header' => 'RESIDEN',
                            'name' => 'residen',
                            // 'value' => 'isset($data->kamarruangan_nokamar) ? $data->kamarruangan_nokamar : "-"',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:left;'),
                        ),
                        array(
                            'header' => 'ANESTESI',
                            'name' => 'jenisanestesi',
                            // 'value' => 'isset($data->kamarruangan_nokamar) ? $data->kamarruangan_nokamar : "-"',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:left;'),
                        ),
                        array(
                            'header' => 'LAMA OP',
                            'name' => 'lama_op',
                            // 'value' => 'isset($data->kamarruangan_nokamar) ? $data->kamarruangan_nokamar : "-"',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:left;'),
                        ),
                        array(
                            'header' => 'KETERANGAN',
                            'name' => 'keterangan_rencana',
                            // 'value' => 'isset($data->kamarruangan_nokamar) ? $data->kamarruangan_nokamar : "-"',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:left;'),
                        ),        
                    ),

                    'afterAjaxUpdate' => 'function(id, data){
                        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                        jQuery(\'#jam_mulai\').timepicker(jQuery.extend({
                               showMonthAfterYear:false}, 
                               jQuery.timepicker.regional[\'id\'], 
                              {\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                              \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mm:ss\',
                            \'showAnim\':\'fold\'})); 
                       jQuery(\'#jam_mulai_date\').on(\'click\', function(){jQuery(\'#jam_mulai\').timepicker(\'show\');});
                       jQuery(\'#tglrencanaoperasi\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
                        jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
                jQuery(\'#tglrencanaoperasi_date\').on(\'click\', function(){jQuery(\'#tglrencanaoperasi\').datepicker(\'show\');});
                       
                   
                   }',                    
                ));
                ?>
            </div>
        </div>
        <div class="form-actions">
            <?php      
              echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printLap(\'PRINT\')'));   
              echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printLap(\'PDF\')'));
              echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printLap(\'EXCEL\')'));      
            ?>
            <?php
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
                $content = $this->renderPartial('pendaftaranPenjadwalan.views.laporan.tips.laporanBukuRegister',array(),true); 
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 

            ?>

<?php
$gets = "";

// echo '<pre>';

if(isset($_GET)){
    foreach($_GET AS $name => $get){
        if($name != "r" && is_array($get)) {
            // var_dump($get, " -- 1");
            // $gets .= "&".$name."=".$get;
            foreach($get as $g => $val) {
            $gets .= "&".$g."=".str_replace(" ", "+", $val);
        }
        }
    }
}

$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');

?>
  
        </div>
    </div>
</div>

<script>

function printLap(caraPrint)
{
    var url = window.location.href;

    var get = '';

    $('#daftarpasien-v-grid').find('input').each(function () {

        var name = $(this).attr('name');
        name = name.replace('LaporanforbesbedahsentralV[', '');
        name = name.replace(']', '');
        var val = $(this).val();
        val = val.replace(' ', '+');

        // console.log('id ' + name + ' - val ' + val);

        get += '&' + name + '=' + val;


    });
    
    console.log('get: ' + get);
    window.open("<?= $urlPrint ?>"+get+"&caraPrint="+caraPrint,"",'location=_new, width=1800px, scrollbars=yes');
    console.log($('#daftarpasien-v-grid').serialize());
}
</script>
