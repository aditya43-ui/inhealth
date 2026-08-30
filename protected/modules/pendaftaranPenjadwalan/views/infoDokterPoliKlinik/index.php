<?php
$this->breadcrumbs = array(
    'Informasi Jadwal Dokter Poliklinik'
);
?>
<style>
    .table>tbody>tr:hover {
        filter: none;
    }

    .table>tbody>tr>td:hover {
        background: #fff;
        filter: brightness(.85);
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-calendar"></i> Penjadwalan <b>Poliklinik</b>
        </div>
    </div>
    <div class="panel-body">
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.mtz.monthpicker.js'); ?>
        <?php
        $url = Yii::app()->createUrl($this->route);
        Yii::app()->clientScript->registerScript('search', "
$('#divSearch-form form').submit(function(){
    $('#table-jadwal-poliklinik').addClass('animation-loading');
	$.fn.yiiGridView.update('table-jadwal-poliklinik', {
		data: $(this).serialize()
	});
	return false;
});
");
        ?>
        <style>
            .table tbody tr td {
                height: 100px;
                /*        font-size:7pt;*/
            }

            .table tbody tr td.disabled {
                background-color: #FEE;
            }

            .table tbody tr td .box1 {
                border: 1px solid #ccc;
                margin: 2px 2px 5px 2px;
                padding: 5px 5px 0px 5px;
                border-radius: 3px;
                -webkit-border-radius: 3px;
                -o-border-radius: 3px;
                -moz-border-radius: 3px;
            }

            .table tbody tr td .box1.active {
                border: 1px solid red;
            }

            .table tbody tr td .box1 ul li.active a {
                color: red;
            }
        </style>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'carijadwal-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'focus' => '#' . CHtml::activeId($model, 'ruangan_id'),
                    'method' => 'GET',
                    'action' => $this->createUrl('index'),
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
                ));
                ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'jadwaldokter_mulai', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                // var_dump($model->attributes); die;
                                $this->widget('MyMonthPicker', array(
                                    'model' => $model,
                                    'attribute' => 'jadwaldokter_mulai',
                                    'options' => array(
                                        'dateFormat' => Params::MONTH_FORMAT,
                                        'yearRange' => "-100y:+0y",
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'class' => "span2 periode_gaji",
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'onchange' => 'getTanggalPeriode(); setKomponenGaji(null);',
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->dropDownListRow($model, 'pegawai_id', CHtml::listData(PPPendaftaranT::model()->getDokterItemsInstalasi(Params::INSTALASI_ID_RJ), 'pegawai_id', 'namaLengkap'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'multiple' => 'multiple')); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php //echo $form->dropDownListRow($model,'jadwaldokter_hari', $listHari ,array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'empty'=>'-- Pilih --'));   
                        ?>
                        <?php
                        echo $form->dropDownListRow($model, 'ruangan_id', CHtml::listData(PPPendaftaranT::model()->getRuanganItems(Params::INSTALASI_ID_RJ), 'ruangan_id', 'ruangan_nama'), array(
                            'onkeypress' => "return $(this).focusNextInputField(event)", 'multiple' => 'multiple'
                        ));
                        ?>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'title' => 'Cari')
                    ); ?>
                    <?php
                    echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        $this->createUrl($this->id . '/index'),
                        array(
                            'title' => 'Ulang',
                            'class' => 'btn btn-default', 'title' => 'Ulang',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'
                        )
                    );
                    ?>
                    <?php
                    $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasiJadwalDokterPoli', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
        <div class='block-tabel' id="table-jadwal-poliklinik" style="margin-top: 17px;">
            <?php echo $grid; ?>
        </div>
        <?php
        $format = new MyFormatter();
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#RDJadwaldokterM_jadwaldokter_mulai').monthpicker({
                    pattern: 'mmmm yyyy'
                });
            });
        </script>
        <?php
        $urlListDokterRuangan = $this->createUrl('listDokterRuangan');
        Yii::app()->clientScript->registerScript('test', '
function updateJadwal(data){
    $.post("' . $url . '",{data:data},function(hasil){
        $("#isiDialogUbahJadwal").html(hasil);
        $("#dialogUbahjadwal").dialog("open");
        findObject();
    },"json");
}
function findObject(){
    $("#isiDialogUbahJadwal .numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
    $("#isiDialogUbahJadwal .timePickerTest").timepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional["id"], {"showAnim":"fold","dateFormat":"yy-mm-dd","changeFirstDay":false,"changeMonth":true,"timeText":"Waktu","hourText":"Jam","minuteText":"Menit","secondText":"Detik","showSecond":true,"timeOnlyTitle":"Pilih Waktu","timeFormat":"hh:mm:ss","changeYear":true,"yearRange":"-80y:+20y"}));
}
function updateValueJadwal(obj){
    url = $(obj).attr("action");
    variable = $(obj).serialize();
    $.ajax({
        url : url,
        type : "post",
        dataType : "json",
        data : $(obj).serialize()+"&data=true",
        success : function(result){
            $("#isiDialogUbahJadwal").html(result);
            findObject();
        }
    });
}
function listDokterRuangan(idRuangan)
{
    $.post("' . $urlListDokterRuangan . '", { idRuangan: idRuangan },
        function(data){
            $("#JadwaldokterM_pegawai_id").html(data.listDokter);
    }, "json");
}
', CClientScript::POS_HEAD);
        ?>
        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogUbahjadwal',
            'options' => array(
                'title' => 'Ubah Jadwal',
                'resizable' => false,
                'width' => 500,
                'height' => 350,
                'autoOpen' => false,
                'modal' => true,
                'beforeClose' => 'js:function(event,test){$("#carijadwal-form").submit();}'
            ),
        ));
        echo '<div id="isiDialogUbahJadwal"></div>';
        $this->endWidget('zii.widgets.jui.CJuiDialog');
        ?>
        <?php
        $this->widget('application.extensions.moneymask.MMask', array(
            'element' => '.numbersOnly',
            'config' => array(
                'defaultZero' => true,
                'allowZero' => true,
                'decimal' => ',',
                'thousands' => '',
                'precision' => 0,
            )
        ));
        ?>
        <?php
        $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker', array(
            'name' => 'jadwalDokter[txtEndDate]',
            'mode' => 'date',
            // additional javascript options for the date picker plugin
            'options' => array(
                'showAnim' => 'fold',
                'beforeShow' => 'js:function(){customRange(this);}',
                'dateFormat' => "yy-mm-dd",
                'changeFirstDay' => false,
                'changeMonth' => true,
                'numberOfMonths' => 3,
            ),
            'htmlOptions' => array(
                'id' => 'txtEndDate',
                'onchange' => '$("#inputForm, #submitForm").html("");',
                'style' => 'display:none;',
                'hide' => true,
            ),
        ));
        ?>
    </div>
</div>
<script>
    function getSyncJadwalDokter(ruangan_id, tgl){
        $.ajax({
            url : '<?php echo $this->createUrl('/pendaftaranPenjadwalan/InfoDokterPoliKlinik/getSycnJadwalDokterBPJS'); ?>',
            type : "post",
            dataType : "json",
            data : {ruangan_id: ruangan_id, tanggal: tgl},
            success : function(data){
                if(data != ''){
                    myAlert(data.msg);

                    if(data.sukses == 1){
                        window.location = window.location.href;
                    }
                }
            }
        });
    }

    $(document).ready(function() {
        jQuery("#PPJadwaldokterM_ruangan_id").multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
        }).hide();
        jQuery("#PPJadwaldokterM_pegawai_id").multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
        }).hide();
    });
</script>