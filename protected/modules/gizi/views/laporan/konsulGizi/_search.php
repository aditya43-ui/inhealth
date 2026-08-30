<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
    'id' => 'searchLaporan',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
));
?>

<style>
    .form-horizontal .radio>label,
    .form-horizontal .checkbox>label {
        float: left !important;
        margin-left: 5px !important;
        padding: 0 !important;
    }

    .form-horizontal .radio>input,
    .form-horizontal .checkbox>input {
        float: left !important;
        margin-top: 2px !important;
    }
</style>

<div class="row">
    <div class="col-sm-6">
        <?php echo CHtml::hiddenField('type', ''); ?>
        <div class="control-group">
            <?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
            <?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
            <?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
            <?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
            <?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
            <?php echo CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
    </div>
</div>


<table width="100%" border="0">
    <tr>
        <td>
            <div id='searching'>
                <fieldset>
                    <?php
                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'kunjungan',
                        'slide' => true,
                        'content' => array(
                            'content1' => array(
                                'header' => 'Berdasarkan Status Bayar',
                                'isi' => '  <table><tr></tr></table>
                                            <table class="penjamin">                                            
                                            <tr>
                                                    <td><div class="controls">' .
                                    CHtml::checkBox('pilihSemua', true, array('onclick' => 'checkAllKelas();')) . '<label><b>Pilih Semua</b></label>
                        <div id="checkBoxList">
                            ' . $form->checkBoxList($model, 'kelaspelayanan_id', CHtml::listData(KelaspelayananM::model()->items, 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('class' => 'kelasPelayanan')) . '<br>
                        </div>                
                    </div></td>
                                            </tr>
                                            </table>',
                                'active' => true,
                            ),
                        ),
                        //                                    'htmlOptions'=>array('class'=>'aw',)
                    ));
                    ?>
                </fieldset>
            </div>
        </td>

        </fieldset>
        </div>
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array(
            'title' => 'Cari',
            'class' => 'btn btn-danger',
            'type' => 'submit', 'id' => 'btn_simpan', 'onclick' => 'CekCaraBayar();return false;'
        )
    );
    ?>
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array(
            'class' => 'btn btn-default',
            'title' => 'Ulang',
            'onclick' => 'konfirmasi()', 'onKeypress' => 'return formSubmit(this,event)'
        )
    );
    ?>
</div>

<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>

<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
', CClientScript::POS_READY);
?>
<?php
$urlPeriode = Yii::app()->createUrl('actionAjax/GantiPeriode');
$js = <<< JSCRIPT

function setPeriode(){
    namaPeriode = $('#PeriodeName').val();
    
        $.post('${urlPeriode}',{namaPeriode:namaPeriode},function(data){
            $('#GZLaporankonsultasigiziV_tgl_awal').val(data.periodeawal);
            $('#GZLaporankonsultasigiziV_tgl_akhir').val(data.periodeakhir);
        },'json');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('setPeriode', $js, CClientScript::POS_HEAD);
?>
<script>
    function checkPilihan(event) {
        var namaPeriode = $('#PeriodeName').val();

        if (namaPeriode == '') {
            myAlert('Silakan pilih kategori pencarian!');
            event.preventDefault();
            $('#dtPicker3').datepicker("hide");
            return true;;
        }
    }

    function checkAllKelas() {
        if ($('#pilihSemua').is(':checked')) {
            $('#checkBoxList').each(function() {
                $(this).find('input').attr('checked', true);
            });
        } else {
            $('#checkBoxList').each(function() {
                $(this).find('input').removeAttr('checked');
            });
        }
    }
    checkAllKelas();
</script>