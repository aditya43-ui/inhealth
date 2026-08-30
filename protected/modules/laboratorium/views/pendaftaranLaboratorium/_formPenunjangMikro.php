<div class="row">
    <div class="col-sm-6">
        <?php echo $form->hiddenField($modPasienMasukPenunjang, '[' . $i . ']pendaftaran_id', array('readonly' => true, 'class' => 'span3')); ?>
        <?php echo $form->hiddenField($modPasienMasukPenunjang, '[' . $i . ']pasienmasukpenunjang_id', array('readonly' => true, 'class' => 'span3')); ?>
        <?php echo $form->hiddenField($modPasienMasukPenunjang, '[' . $i . ']ruangan_id', array('readonly' => true, 'class' => 'span3')); ?>
        <?php
    $ruangan_skr = Yii::app()->user->getState('ruangan_id');
    $hide_kp = $ruangan_skr == 53 ? "hide" : "";
        ?>
        <div class="<?php $hide_kp ?>">
            <?php echo $form->dropDownListRow($modPasienMasukPenunjang, '[' . $i . ']jeniskasuspenyakit_id', CHtml::listData($model->getJenisKasusPenyakitItems(1131), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
        </div>
        <div>
            <?php echo $form->dropDownListRow($modPasienMasukPenunjang, '[' . $i . ']kelaspelayanan_id', CHtml::listData($model->getKelasPelayananItems($modPasienMasukPenunjang->ruangan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => "setKarcis(" . $i . ");", 'class' => 'span3 kelaspelayanan_0')); ?>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Dokter', 'pegawai_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($modPasienMasukPenunjang, '[' . $i . ']pegawai_id', CHtml::listData($model->getDokterItems($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'nama_pegawai'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Analis', 'perawat_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($modPasienMasukPenunjang, '[' . $i . ']perawat_id', CHtml::listData(LBPegawaiM::model()->getTenagaLaboratoriums($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'nama_pegawai'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Dokter Perujuk</label>
            <div class="controls">
                <?php 
                echo $form->hiddenField($modPasienMasukPenunjang, '[' . $i . ']dokterperujuk', array('class'=>'dokterperujuk'));
                $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modPasienMasukPenunjang,
                                'attribute'=>'[' . $i . ']dokter_perujuk',
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('autocompleteDokterPerujuk').'",
                                                   dataType: "json",
                                                   data: {
                                                       term: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 2,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val( ui.item.label);
                                            $(".dokterperujuk").val( ui.item.value);
                                            return false;
                                        }',
                                ),
                                //'tombolDialog'=>array('idDialog'=>'dialogDokter'),
                                'htmlOptions'=>array('placeholder'=>'Ketik Dokter Perujuk','class'=>'span3 dokter_perujuk','rel'=>'tooltip','title'=>'Ketik dokter perujuk / klik icon untuk mencari data dokter perujuk',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
                                    ),
                            )); 
            ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Jenis Permintaan', 'jenis_permintaan', array('class' => 'control-label')); ?>
            <div class="controls">
                <div class="row">
                    <table style="width: 100%;">
                        <tr>
                            <td style="vertical-align: middle;">
                                <?php echo $form->radioButton($modKirimUnitLain, 'is_nonprogram', array('onchange' => 'setInputan("non", this, ' . null . ');', 'class' => 'jenispermintaan', 'onkeypress' => "return $(this).focusNextInputField(event);", 'checked' => '', 'value' => 'non')) . ' <label for="LBPasienKirimKeUnitLainT_is_nonprogram">Non Program</label>'; ?>&emsp;&emsp;
                            </td>
                            <td style="vertical-align: middle;">
                                <?php echo $form->radioButton($modKirimUnitLain, 'is_programtbc', array('onchange' => 'setInputan("tbc", this, ' . null . ');', 'class' => 'jenispermintaan', 'onkeypress' => "return $(this).focusNextInputField(event);", 'checked' => '', 'value' => 'tbc')) . ' <label for="LBPasienKirimKeUnitLainT_is_programtbc">Program TBC</label>'; ?>&emsp;&emsp;
                            </td>
                            <td style="vertical-align: middle;">
                                <?php echo $form->radioButton($modKirimUnitLain, 'is_programhiv', array('onchange' => 'setInputan("hiv", this, ' . null . ');',  'class' => 'jenispermintaan', 'onkeypress' => "return $(this).focusNextInputField(event);", 'checked' => '', 'value' => 'hiv')) . ' <label for="LBPasienKirimKeUnitLainT_is_programhiv">Program HIV</label>'; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div id="form-tindakanpemeriksaan-<?php echo $i; ?>" style="margin-top: 8px;" hidden>
            <table class="table table-condensed table-striped">
                <thead>
                    <th>No.</th>
                    <th>Nama Pemeriksaan</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Tarif</th>
                    <th>Total Tarif</th>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemeriksaan</b>
                    <?php 
                        // echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-arrow-down icon-white"></i>')), array('class' => 'btn btn-mini btn-primary', 'type' => 'button', "onclick" => "setCheckedPemeriksaanDariPermintaan();", 'rel' => 'tooltip', 'title' => 'Klik untuk menyalin dari tabel permintaan')); 
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Tambah', array('{icon}' => '<i class="icon-plus icon-white"></i>')), array('class' => 'btn btn-success', 'type' => 'button', "onclick" => "$('#dialogLab2').dialog('open')", 'rel' => 'tooltip', 'title' => 'Klik untuk menambah pemeriksaan')); 
                    ?>
                </div>
            </div>
            <div id="form-tindakanpemeriksaan" class="panel-body table-responsive">
                <table class="table table-condensed table-striped" id="tabelBahan">
                    <thead>
                        <th>No.</th>
                        <th>No. Lab</th>
                        <th>Jenis Pemeriksaan</th>
                        <th>Uraian Tindakan</th>
                        <th>Sample Lab</th>
                        <th>Cara Ambil</th>
                        <th>Kode Tindakan</th>
                        <th>Jumlah</th>
                        <th>Nominal Tarif</th>
                        <th>Total Tarif</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php echo CHtml::hiddenField('jenispermintaan','',array('readonly'=>TRUE));?>
        <div class="panel panel-success panel-jenis panel-non hide">
            <?php $this->renderPartial($this->path_view_order.'__non',array('form' => $form, 'modKirimKeUnitLain'=>$modKirimUnitLain)) ?>
        </div>
        <div class="panel panel-success panel-jenis panel-tbc hide">
            <?php $this->renderPartial($this->path_view_order.'__tbc',array('form' => $form, 'modKirimKeUnitLain'=>$modKirimUnitLain, 'modPenunjang2' => $modPenunjang2)) ?>
        </div>
        <div class="panel panel-success panel-jenis panel-hiv hide">
            <?php $this->renderPartial($this->path_view_order.'__hiv',array('form' => $form, 'modKirimKeUnitLain'=>$modKirimUnitLain, 'modPenunjang2' => $modPenunjang2)) ?>
        </div>
    </div>
</div>
<div style="" id="loadSpesimen">
    <!-- <div style="height:400px;overflow-y: scroll;" id="loadSpesimen">  -->
    <?php 
             $genBahan = JenispemeriksaanlabM::model()->findAll("jenispemeriksaanlab_aktif = true and jenispemeriksaanlab_kelompok='" . Params::JENISPEMERIKSAANLAB_KELOMPOK_MIKROBIOLOGI . "'");
             foreach($genBahan as $i => $gen){ 
                 $bahan = PemeriksaanlabM::model()->findAll('jenispemeriksaanlab_id =' . $gen->jenispemeriksaanlab_id);
                 // var_dump($bahan);
             ?>
    <div class="boxSample"></div>

    <?php } ?>
</div>