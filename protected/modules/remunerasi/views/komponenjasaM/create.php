<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Komponen Jasa</b>
        </div>
    </div>
    <div class="panel-body">
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'komponenjasa-m-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
            'focus' => '#',
        )); ?>

        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->

        <?php echo $form->errorSummary($model); ?>

        <!--================================== Form pendidikan =====================================-->
        <div id="tablePendidikanpegawai">
            <table>
                <tr>
                    <td>
                        <?php //echo $form->labelEx($model,'jenistarif_id'); 
                        ?>
                        <?php //echo $form->dropDownList($model,'jenistarif_id',CHtml::listData($model->getJenistarifItems(),'jenistarif_id','jenistarif_nama'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --','style'=>'width:120px;')) 
                        ?>
                        <?php //golongan
                        echo $form->dropDownListRow(
                            $model,
                            'jenistarif_id',
                            CHtml::listData($model->getJenistarifItems(), 'jenistarif_id', 'jenistarif_nama'),
                            array(
                                'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => $this->createUrl('/ActionDynamic/GetCaraBayar', array('encode' => false, 'model_nama' => get_class($model))),
                                    'update' => "#" . CHtml::activeId($model, 'carabayar_id'),
                                ),
                                //    'onchange'=>"setClearBidang();setClearKelompok();setClearSubKelompok();setClearSubSubKelompok();",
                            )
                        ); ?>

                    </td>
                    <td>
                        <?php echo $form->labelEx($model, 'carabayar_id'); ?>
                        <?php echo $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCarabayarItems(), 'carabayar_id', 'carabayar_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --', 'style' => 'width:120px;')) ?>
                    </td>
                    <td>
                        <?php echo $form->labelEx($model, 'komponentarif_id'); ?>
                        <?php echo $form->dropDownList($model, 'komponentarif_id', CHtml::listData($model->getKomponentarifItems(), 'komponentarif_id', 'komponentarif_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --', 'style' => 'width:120px;')) ?>
                    </td>
                </tr>
            </table>
            <table class="table table-bordered table-striped table-condensed" style="padding-left: 0; padding-right: 0;">
                <thead>
                    <tr>
                        <th rowspan="2">No. urut</th>
                        <th rowspan="2">Kelompok Tindakan</th>
                        <th rowspan="2">Ruangan</th>
                        <th rowspan="2">Kode</th>
                        <th rowspan="2">Nama</th>
                        <th rowspan="2">Singkatan</th>
                        <th colspan="11" style="text-align:center;">Rumus Presentasi</th>
                    </tr>
                    <tr>
                        <th rowspan="2">Besaran Jasa</th>
                        <th rowspan="2">Potongan</th>
                        <th rowspan="2">Jasa Direksi</th>
                        <th rowspan="2">Kue Besar</th>
                        <th rowspan="2">Jasa Dokter</th>
                        <th rowspan="2">Jasa Paramedis</th>
                        <th rowspan="2">Jasa Unit</th>
                        <th rowspan="2">Jasa Balanceins</th>
                        <th rowspan="2">Jasa Emergency</th>
                        <th rowspan="2">Biaya Umum</th>
                        <th rowspan="2">Tambah / Batal</th>
                    </tr>
                </thead>
                <?php
                $no = 1;
                $i = 0;
                ?>
                <tbody>
                    <tr>
                    <tr>
                        <td>
                            <?php echo $form->textField($model, '[' . $i . ']no', array('readonly' => true, 'style' => 'width:20px;', 'value' => $no)) ?>
                        </td>
                        <td>
                            <?php echo $form->dropDownList($model, '[' . $i . ']kelompoktindakan_id', CHtml::listData($model->getKelompoktindakanItems(), 'kelompoktindakan_id', 'kelompoktindakan_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --', 'style' => 'width:60px;')) ?>
                        </td>
                        <td>
                            <?php echo $form->dropDownList($model, '[' . $i . ']ruangan_id', CHtml::listData($model->getRuanganItems(), 'ruangan_id', 'ruangan_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --', 'style' => 'width:60px;')) ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, '[' . $i . ']komponenjasa_kode', array('readonly' => false, 'style' => 'width:40px;')) ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, '[' . $i . ']komponenjasa_nama', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'jasanama', 'style' => 'width:40px;',)); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, '[' . $i . ']komponenjasa_singkatan', array('onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:40px;',)); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, '[' . $i . ']besaranjasa', array('onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:40px;',)); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, '[' . $i . ']potongan', array('onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:40px;',)); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, '[' . $i . ']jasadireksi', array('onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:40px;',)); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, '[' . $i . ']kuebesar', array('onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:40px;',)); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, '[' . $i . ']jasadokter', array('onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:40px;',)); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, '[' . $i . ']jasaparamedis', array('onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:40px;',)); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, '[' . $i . ']jasaunit', array('onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:40px;',)); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, '[' . $i . ']jasabalanceins', array('onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:40px;',)); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, '[' . $i . ']jasaemergency', array('onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:40px;',)); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, '[' . $i . ']biayaumum', array('onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:40px;',)); ?>
                        </td>
                        <td style="width:80px;">
                            <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '', array('class' => 'btn btn-primary', 'title' => 'Tambah data', 'rel' => 'tooltip', 'onclick' => 'tambahKomponenjasa(this);return false', 'id' => 'tambah', 'style' => 'cursor:pointer;')); ?>
                            <?php echo CHtml::link('<i class="icon-minus-sign"></i>', '#', array('class' => 'btn btn-default', 'title' => 'Hapus data', 'rel' => 'tooltip', 'id' => 'hapus', 'onclick' => 'hapusKomponenjasa(this);return false', 'style' => 'cursor:pointer;')); ?>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>
        <!--================================== Akhir form pendidikan ====================================-->

        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'onKeypress' => 'return formSubmit(this,event)', 'name' => 'submitKomponenjasa')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/komponenjasaM/admin'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>

            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Komponen Jasa', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php
            $content = $this->renderPartial('gizi.views.tips.tipsaddedit3e', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    var trKomponenjasa = new String(<?php echo CJSON::encode($this->renderPartial('_rowKomponenJasa', array('form' => $form, 'model' => $model,), true)); ?>);
</script>

<?php
$urlGetKomponenjasa = Yii::app()->createUrl('actionAjax/GetKomponenjasa');
$js = <<< JS
    function tambahKomponenjasa(obj) {
        $(obj).parents("td").children("#hapus").show();
        $(obj).hide();
        $(obj).parents("table").children("tbody").append(trKomponenjasa.replace());
        renameInput();
    }

    function tambahKomponendrinput(obj) {
        $("#hapus").show();
        $("#tambah").hide();
        $(obj).parents("table").children("tbody").append(trKomponenjasa.replace());
        renameInput();
    }

    function hapusKomponenjasa(obj) {
        $("#tambah").show();
        $(obj).hide();
        $(obj).parents("tr").remove();
    }
    
    function renameInput(){
        nourut = 0;
        giliran = 2;
        $(".jasanama").each(function(){
            $(this).parents('tr').find('[name*="REKomponenjasaM"]').each(function(){
                var input = $(this).attr('name');
                var data = input.split('REKomponenjasaM[]');
                var id = input.split('REKomponenjasaM[][');
                if (typeof data[1] === 'undefined'){} else{
                    $(this).attr('name','REKomponenjasaM['+nourut+']'+data[1]);
                };
            });
            
            $(this).parents('tr').find('[id*="date"]').each(function() {
                var input = $(this).attr('id');
                var data = input.split('date-');
                    $(this).attr('id','date-'+data[1]+nourut);
                    
                $(function() {
                    $( "#date-"+data[1]+nourut).datepicker({
                        firstDay: 7,
                        dateFormat:'yy-mm-dd',
                        changeMonth: true,
                        changeYear: true,
                    });
                });
                $.datepicker.setDefaults($.datepicker.regional['id']);

             $(this).parents('tr').find('[id*="REKomponenjasaM_no"]').each(function() {
                var input = $(this).attr('id');
                var data = input.split('REKomponenjasaM_');
                $(this).attr('id','REKomponenjasaM_'+data[1]+nourut);
                $("#REKomponenjasaM_"+data[1]+nourut).val(giliran);
             });

            });
            nourut++;
            giliran++;
        });
    }
    
        function Komponenjasadata()
        {
            pegawai_id = $('#pegawai_id').val();
            if(pegawai_id==''){
                myAlert('Anda belum memilih pegawai');
            }else{
                $.post("${urlGetKomponenjasa}", {},
                function(data){
                    $("#tableKomponenjasa").children("tbody").append(data.tr);
                }, "json");
            }   
        }

        function ViewKomponenjasa() {
            
            if ($("#cekRiwayatPegawaidiklat").is(":checked")) {
                Pegawaidiklatdata();
                $("#tableKomponenjasa").slideDown(60);
            } else {
                $("#tableKomponenjasa").children("tbody").children("tr").remove();
                $("#tableKomponenjasa").slideUp(60);
            }
        }
JS;
Yii::app()->clientScript->registerScript('komponenjasa', $js, CClientScript::POS_HEAD);
?>