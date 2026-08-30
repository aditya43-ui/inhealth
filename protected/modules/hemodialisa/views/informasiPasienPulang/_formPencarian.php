<?php  ?>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'daftarPasienPulang-form',
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#' . CHtml::activeId($modPasienYangPulang, 'no_pendaftaran'),
)); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class='col-sm-6'>
                <div class="control-group">
                    <label for="namaPasien" class="control-label">
                        <?php echo CHtml::activecheckBox($modPasienYangPulang, 'ceklis', array('onClick' => 'cekTanggal()', 'rel' => 'tooltip', 'data-original-title' => 'Cek untuk pencarian berdasarkan tanggal')); ?>
                        Tanggal Pulang
                    </label>
                    <div class="controls">
                        <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($modPasienYangPulang->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($modPasienYangPulang->tgl_akhir)) ?>">
                            <i class="entypo-calendar"></i>
                            <span><?php echo date('d M Y', strtotime($modPasienYangPulang->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($modPasienYangPulang->tgl_akhir)) ?></span>
                            <?php echo $form->hiddenField($modPasienYangPulang, 'tgl_awal', array('class' => 'start')) ?>
                            <?php echo $form->hiddenField($modPasienYangPulang, 'tgl_akhir', array('class' => 'end')) ?>
                        </div>
                    </div>
                </div>
                <!--</div>
    <div class='col-sm-6'>-->
                <?php echo $form->textFieldRow($modPasienYangPulang, 'no_pendaftaran', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => 'No. Pendaftaran')); ?>
                <?php echo $form->textFieldRow($modPasienYangPulang, 'nama_pasien', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => 'Nama Pasien')); ?>
                <?php echo $form->textFieldRow($modPasienYangPulang, 'nama_bin', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => 'Nama Bin')); ?>
            </div>
            <div class='col-sm-6'>
                <?php echo $form->textFieldRow($modPasienYangPulang, 'no_rekam_medik', array('class' => 'span4 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 8, 'placeholder' => 'No. Rekam Medik')); ?>
                <?php echo $form->textFieldRow($modPasienYangPulang, 'keterangan_kamar', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => 'Keterangan Kamar.')); ?>
                <?php echo $form->dropDownListRow($modPasienYangPulang, 'carabayar_id', CHtml::listData($modPasienYangPulang->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                    'class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien', array('encode' => false, 'namaModel' => 'HDPendaftaran')),
                        'update' => '#' . CHtml::activeId($modPasienYangPulang, 'penjamin_id') . ''  //selector to update
                    ),
                )); ?>
                <?php echo $form->dropDownListRow($modPasienYangPulang, 'penjamin_id', CHtml::listData($modPasienYangPulang->getPenjaminItems($modPasienYangPulang->carabayar_id), 'penjamin_id', 'penjamin_nama'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            );
            //	echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),
            //                                                array('class' => 'btn btn-danger', 'type'=>'submit','id'=>'btn_simpan',
            //                                                    'ajax' => array(
            //                                                     'type' => 'GET', 
            //                                                     'url' => array("/".$this->route), 
            //                                                     'update' => '#daftarPasienPulang-grid',
            //                                                     'beforeSend' => 'function(){
            //                                                                          $("#daftarPasienPulang-grid").addClass("animation-loading");
            //                                                                      }',
            //                                                     'complete' => 'function(){
            //                                                                          $("#daftarPasienPulang-grid").removeClass("animation-loading");
            //                                                                      }',
            //                                                 ))); 
            echo CHtml::hiddenField('pendaftaran_id');
            echo CHtml::hiddenField('pasien_id');
            ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/index'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
            <?php
            $content = $this->renderPartial('../tips/informasi', array(), true);
            $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget();?>

<script>
document.getElementById('HDPasienpulangrddanriV_tgl_awal_date').setAttribute("style","display:block;");
document.getElementById('HDPasienpulangrddanriV_tgl_akhir_date').setAttribute("style","display:block;");
function cekTanggal(){

    var checklist = $('#HDPasienpulangrddanriV_ceklis');
    var pilih = checklist.attr('checked');
    if(pilih){
        document.getElementById('HDPasienpulangrddanriV_tgl_awal_date').setAttribute("style","display:block;");
        document.getElementById('HDPasienpulangrddanriV_tgl_akhir_date').setAttribute("style","display:block;");
    }else{
        document.getElementById('HDPasienpulangrddanriV_tgl_awal_date').setAttribute("style","display:none;");
        document.getElementById('HDPasienpulangrddanriV_tgl_akhir_date').setAttribute("style","display:none;");
    }
}
</script>