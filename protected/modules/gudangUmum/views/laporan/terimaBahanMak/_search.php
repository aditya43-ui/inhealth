<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
    </div>
    <div class="panel-body">
        <div class="search-form">
            <?php
            $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'action' => Yii::app()->createUrl($this->route),
                'method' => 'get',
                'type' => 'horizontal',
                'id' => 'laporan-search',
                'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
            ?>
            <style>

                #penjamin label.checkbox{
                    width: 200px;
                    display:inline-block;
                }
                label.checkbox, label.radio{
                    width:260px;
                    display:inline-block;
                }

            </style>

            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
                        <?php echo CHtml::label("Periode Laporan", 'dari_tanggal', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                                <i class="entypo-calendar"></i>
                                <span ><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                                <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                            </div>
                        </div>
                    </div>	

                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div id='searching'>
                        <fieldset>    
                            <?php
                            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                                'id' => 'kunjungan2',
                                'slide' => true,
                                'content' => array(
                                    'content3' => array(
                                        'header' => 'Berdasarkan Jenis Bahan Makanan',
                                        'isi' => '  <table><tr></tr></table>
                      <table class="jenisbahanmakanan">
                      <tr>
                      <td><div class="controls">' . CHtml::hiddenField('filter2', 'supplier') .
                                        CHtml::checkBox('pilihSemua2', true, array('onclick' => 'checkAllJenisBahanMak();')) . '<label><b>Pilih Semua</b></label>
                      <div id="checkBoxJenisBahanMak">
                      ' . $form->checkBoxList($model, 'jenisbahanmakanan', LookupM::getItems('jenisbahanmakanan'), array('class' => 'jenisbahanmakanan')) . '<br>
                      </div>
                      </div>
                      </td>
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
                </div>
                <div class="col-sm-6">
                    <div id='searching'>
                        <fieldset>    
                            <?php
                            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                                'id' => 'kunjungan',
                                'slide' => true,
                                'content' => array(
                                    'content1' => array(
                                        'header' => 'Berdasarkan Supplier',
                                        'isi' => '  <table><tr></tr></table>
                                            <table class="supplier">                                            
                                            <tr>
                                                    <td><div class="controls">' . CHtml::hiddenField('filter', 'supplier') .
                                        CHtml::checkBox('pilihSemua', true, array('onclick' => 'checkAllSupplier();')) . '<label><b>Pilih Semua</b></label>
                                                            <div id="checkBoxSupplier">
                                                                ' . $form->checkBoxList($model, 'supplier_id', CHtml::listData(SupplierM::model()->getSupplierGiziItems(), 'supplier_id', 'supplier_nama'), array('class' => 'suplier')) . '<br>
                                                            </div>                
                                                        </div>
                                                    </td>
                                            </tr>
                                            </table>',
                                        'active' => true,
                                    ),
                                ),
                                    //                                    'htmlOptions'=>array('class'=>'aw',)
                            ));
                            ?>											
                        </fieldset>	
                    </div></div>

                <div class="col-sm-6">

                    <div id='searching'>
                        <fieldset>    
                            <?php
                            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                                'id' => 'kunjungan1',
                                'slide' => true,
                                'content' => array(
                                    'content2' => array(
                                        'header' => 'Berdasarkan Golongan Bahan Makanan',
                                        'isi' => '  <table><tr></tr></table>
                                            <table class="golbahanmakanan">                                            
                                            <tr>
                                                    <td><div class="controls">' . CHtml::hiddenField('filter1', 'golbahanmakanan') .
                                        CHtml::checkBox('pilihSemua1', true, array('onclick' => 'checkAllGolBahanMak();')) . '<label><b>Pilih Semua</b></label>
                                                            <div id="checkBoxGolBahanMak">
                                                                ' . $form->checkBoxList($model, 'golbahanmakanan_id', GolbahanmakananM::getGolBhnMakanItems(), array('class' => 'golbahanmakanan')) . '<br>
                                                            </div>                
                                                        </div>
                                                    </td>
                                            </tr>
                                            </table>',
                                        'active' => true,
                                    ),
                                ),
                                    //                                    'htmlOptions'=>array('class'=>'aw',)
                            ));
                            ?>											
                        </fieldset>	
                    </div></div>

                <div class="col-sm-6">
                    <div id='searching'>
                        <fieldset>    
                            <?php
                            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                                'id' => 'kunjungan3',
                                'slide' => true,
                                'content' => array(
                                    'content4' => array(
                                        'header' => 'Berdasarkan Kelompok Bahan Makanan',
                                        'isi' => '  <table><tr></tr></table>
                      <table class="kelbahanmakanan">
                      <tr>
                      <td><div class="controls">' . CHtml::hiddenField('filter3', 'kelbahanmakanan') .
                                        CHtml::checkBox('pilihSemua3', true, array('onclick' => 'checkAllkelBahanMak();')) . '<label><b>Pilih Semua</b></label>
                      <div id="checkBoxKelBahanMak">
                      ' . $form->checkBoxList($model, 'kelbahanmakanan', LookupM::getItems('kelompokbahanmakanan'), array('class' => 'kelbahanmakanan')) . '<br>
                      </div>
                      </div>
                      </td>
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
                </div>
            </div>

            <div class="form-actions">
                <?php
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary',
                    'type' => 'submit', 'id' => 'btn_simpan'));
                ?>
                <?php
                echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array('class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
                ?>
            </div>
        </div> 
    </div> 
</div> 
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>

<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#big").find("input").attr("checked", "checked");
  $("#supplier").find("input").attr("checked", "checked");
  $("#golbahanmakanan").find("input").attr("checked", "checked");
  $("#jenisbahanmakanan").find("input").attr("checked", "checked");
  $("#kelbahanmakanan").find("input").attr("checked", "checked");
', CClientScript::POS_READY);
?>
<?php
$urlPeriode = Yii::app()->createUrl('actionAjax/GantiPeriode');
$js = <<< JSCRIPT

function setPeriode(){
    namaPeriode = $('#PeriodeName').val();
    
        $.post('${urlPeriode}',{namaPeriode:namaPeriode},function(data){
            $('#GZLaporanmakanangiziV_tgl_awal').val(data.periodeawal);
            $('#GZLaporanmakanangiziV_tgl_akhir').val(data.periodeakhir);
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
            return true;
            ;
        }
    }
    function checkAllSupplier() {
        if ($('#pilihSemua').is(':checked')) {
            $('#checkBoxSupplier').each(function () {
                $(this).find('input').attr('checked', true);
            });
        } else {
            $('#checkBoxSupplier').each(function () {
                $(this).find('input').removeAttr('checked');
            });
        }
    }

    function checkAllGolBahanMak() {
        if ($('#pilihSemua1').is(':checked')) {
            $('#checkBoxGolBahanMak').each(function () {
                $(this).find('input').attr('checked', true);
            });
        } else {
            $('#checkBoxGolBahanMak').each(function () {
                $(this).find('input').removeAttr('checked');
            });
        }
    }

    function checkAllJenisBahanMak() {
        if ($('#pilihSemua2').is(':checked')) {
            $('#checkBoxJenisBahanMak').each(function () {
                $(this).find('input').attr('checked', true);
            });
        } else {
            $('#checkBoxJenisBahanMak').each(function () {
                $(this).find('input').removeAttr('checked');
            });
        }
    }

    function checkAllKelBahanMak() {
        if ($('#pilihSemua3').is(':checked')) {
            $('#checkBoxKelBahanMak').each(function () {
                $(this).find('input').attr('checked', true);
            });
        } else {
            $('#checkBoxKelBahanMak').each(function () {
                $(this).find('input').removeAttr('checked');
            });
        }
    }
    checkAllJenisBahanMak();
    checkAllKelBahanMak();
    checkAllGolBahanMak();
    checkAllSupplier();
</script>