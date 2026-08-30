<?php
$this->breadcrumbs = array(
    'Mcu',
);
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'hearingtest-mcu-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
));
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Hasil Hearing Test
        </div>
    </div>
    <div class="panel-body">
        <div class="panel-body">
            <div class='control-group'>
                <ol style="list-style-type: upper-roman;">
                    <li>RIWAYAT PEKERJAAN
                        <table class="table-condensed" width="100%">
                            <tr>
                                <td width="100%">
                                    <table id="form-riwayatpekerjaan-mcu" class="table table-bordered table-condensed">
                                        <thead>
                                            <tr>
                                                <th style='text-align:center;'>Nama Perusahaan</th>
                                                <th style='text-align:center;'>Lama Bekerja / <br>Satuan Lama (thn/bln/hr)</th>
                                                <th style='text-align:center;'>Jenis Pekerjaan</th>
                                                <th style='text-align:center;'>Terpapar/Kontak dengan Bising</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $this->renderPartial('_rowPemeriksaan', array('modHearingTest' => $modHearingTest)); ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="control-group">
                                    <?php echo CHtml::label('Hobby Menembak/Musik <span style=color:red>*</span>', '', array('class' => 'control-label required')); ?>
                                    <div class="controls form-inline required">
                                        <?php echo $form->radioButtonList($modHearingTest, 'hobtembak_musik', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'required')); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label('Alat proteksi telinga yang pernah dikenakan <span style=color:red>*</span>', '', array('class' => 'control-label required')); ?>
                                    <div class="controls">
                                        <?php echo $form->dropDownList($modHearingTest, 'altproteksi_telinga', LookupM::getItems('alatproteksitelinga'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <?php echo $form->LabelEx($modHearingTest, 'ket_kerja_lingkungan', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php echo $form->textField($modHearingTest, 'ket_kerja_lingkungan', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="control-group">
                                    <?php echo CHtml::label('Paparan bahan kimia di lingkungan kerja <span style=color:red>*</span>', '', array('class' => 'control-label required')); ?>
                                    <div class="controls form-inline">
                                        <?php echo $form->radioButtonList($modHearingTest, 'bahankimia_lk', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <?php echo CHtml::label('Kelainan Pendengaran di kalangan keluarga <span style=color:red>*</span>', '', array('class' => 'control-label required')); ?>
                                    <div class="controls form-inline">
                                        <?php echo $form->radioButtonList($modHearingTest, 'kelainanpend_kal_kel', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>KELUHAN-KELUHAN LAINNYA
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="control-group">
                                    <?php echo CHtml::label('Apakah ada gangguan Pembicaraan antara perorangan <span style=color:red>*</span>', '', array('class' => 'control-label required')); ?>
                                    <div class="controls form-inline">
                                        <?php echo $form->radioButtonList($modHearingTest, 'gangguan_antarperorangan', array('Baik' => 'Baik', 'Susah' => 'Susah'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label('Apakah ada gangguan Pendengaran di lingkungan yang gaduh/berisik <span style=color:red>*</span>', '', array('class' => 'control-label required')); ?>
                                    <div class="controls form-inline">
                                        <?php echo $form->radioButtonList($modHearingTest, 'gangguan_lingkgaduh', array('Baik' => 'Baik', 'Susah' => 'Susah'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label('Apakah telinganya sering mendenging <span style=color:red>*</span>', '', array('class' => 'control-label required')); ?>
                                    <div class="controls form-inline">
                                        <?php echo $form->radioButtonList($modHearingTest, 'telinga_mendenging', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">

                            </div>
                        </div>
                    </li>
                    <li>PEMERIKSAAN TELINGA
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="control-group">
                                    <?php echo CHtml::label('Telinga Kanan : Membran Tympani <span style=color:red>*</span>', '', array('class' => 'control-label required')); ?>
                                    <div class="controls form-inline">
                                        <?php echo $form->radioButtonList($modHearingTest, 'tkn_membrantympani', array('Utuh' => 'Utuh', 'Robek' => 'Robek'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <?php echo CHtml::label('Infeksi Lubang Telinga <span style=color:red>*</span>', '', array('class' => 'control-label required')); ?>
                                    <div class="controls form-inline">
                                        <?php echo $form->radioButtonList($modHearingTest, 'tkn_influbtelinga', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <?php echo CHtml::label('Serumen <span style=color:red>*</span>', '', array('class' => 'control-label required')); ?>
                                    <div class="controls form-inline">
                                        <?php echo $form->radioButtonList($modHearingTest, 'tkn_serumen', array('Ada' => 'Ada', 'Tidak' => 'Tidak'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="control-group">
                                    <?php echo CHtml::label('Telinga Kiri : Membran Tympani <span style=color:red>*</span>', '', array('class' => 'control-label required')); ?>
                                    <div class="controls form-inline">
                                        <?php echo $form->radioButtonList($modHearingTest, 'tkr_membrantympani', array('Utuh' => 'Utuh', 'Robek' => 'Robek'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label('Infeksi Lubang Telinga <span style=color:red>*</span>', '', array('class' => 'control-label required')); ?>
                                    <div class="controls form-inline">
                                        <?php echo $form->radioButtonList($modHearingTest, 'tkr_influbtelinga', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label('Serumen <span style=color:red>*</span>', '', array('class' => 'control-label required')); ?>
                                    <div class="controls form-inline">
                                        <?php echo $form->radioButtonList($modHearingTest, 'tkr_serumen', array('Ada' => 'Ada', 'Tidak' => 'Tidak'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>KESIMPULAN HASIL AUDIOGRAM
                        <div class="row">
                            1. Penurunan kemampuan pendenganran untuk komunikasi akibat terpapar kebisingan derajat
                            <?php echo $form->dropDownList($modHearingTest, 'penuruankempendengaran', LookupM::getItems('penurunanpendengaran'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'required')); ?><br>
                            2. Penurunan kemampuan pendenganran pada frekuensi<br>
                            <table class="table-condensed" width="100%">
                                <tr>
                                    <td width="10%">
                                        Telinga Kanan
                                    </td>
                                    <td width="90%">
                                        <table id="form-pemeriksaan-telingakanan-mcu" class="table table-bordered table-condensed">
                                            <thead>
                                                <tr>
                                                    <th style='text-align:center;'>Freq</th>
                                                    <th style='text-align:center;'>500</th>
                                                    <th style='text-align:center;'>1k</th>
                                                    <th style='text-align:center;'>2k</th>
                                                    <th style='text-align:center;'>3k</th>
                                                    <th style='text-align:center;'>4k</th>
                                                    <th style='text-align:center;'>6k</th>
                                                    <th style='text-align:center;'>8k</th>
                                                    <th style='text-align:center;'>Diagram</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $this->renderPartial('_rowTelingaKanan', array('modHearingTest' => $modHearingTest)); ?>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%">
                                        Telinga Kiri
                                    </td>
                                    <td width="90%">
                                        <table id="form-pemeriksaan-telingakiri-mcu" class="table table-bordered table-condensed">
                                            <thead>
                                                <tr>
                                                    <th style='text-align:center;'>Freq</th>
                                                    <th style='text-align:center;'>500</th>
                                                    <th style='text-align:center;'>1k</th>
                                                    <th style='text-align:center;'>2k</th>
                                                    <th style='text-align:center;'>3k</th>
                                                    <th style='text-align:center;'>4k</th>
                                                    <th style='text-align:center;'>6k</th>
                                                    <th style='text-align:center;'>8k</th>
                                                    <th style='text-align:center;'>Diagram</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $this->renderPartial('_rowTelingaKiri', array('modHearingTest' => $modHearingTest)); ?>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            3. Penurunan kemampuan pendengaran akibat : Pertambahan usia/Presbyacusis
                            <?php echo $form->textField($modHearingTest, 'penurunan_presbyacusis', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?><br><br>
                            4. Penurunan kemampuan pendengaran akibat : Penyakit infeksi dan lainnya
                            <?php echo $form->textField($modHearingTest, 'penurunan_infdanlain', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?><br>
                            <div class="col-sm-6">
                                <?php echo $form->textAreaRow($modHearingTest, 'catatan_hearingtest', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?><br>
                                <div class="control-group">
                                    <?php echo $form->LabelEx($modHearingTest, 'namapemeriksa_hearingtest', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php $this->widget('MyJuiAutoComplete', array(
                                            'model' => $modHearingTest,
                                            'attribute' => 'namapemeriksa_hearingtest',
                                            'value' => '',
                                            'sourceUrl' => $this->createUrl('AutocompletePemeriksa'),
                                            'options' => array(
                                                'showAnim' => 'fold',
                                                'minLength' => 3,
                                                'focus' => 'js:function( event, ui ) {
                                                        $(this).val( ui.item.nama_pegawai);
                                                        return false;
                                                    }',
                                            ),
                                        )); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <?php echo $form->textAreaRow($modHearingTest, 'keterangan_hearingtest', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?><br>
                            </div>
                        </div>
                    </li>
                </ol>
            </div>
        </div>
        <?php echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-primary', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;')) ?>
    </div>
</div>

<?php $this->endWidget(); ?>
<?php
echo $this->renderPartial($this->path_view . '_jsFunctions', array('modHearingTest' => $modHearingTest), true);
?>

<script>
    $(document).ready(function() {
        $("input, select, textarea").attr("readonly", true);
    });
</script>