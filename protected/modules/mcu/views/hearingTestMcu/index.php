<?php
$this->breadcrumbs = array(
    'Mcu',
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data Pemeriksaan Kacamata berhasil disimpan");
}
$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'hearingtest-mcu-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
)); ?>

<?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'form-riwayat',
    'content' => array(
        'content-riwayat' => array(
            'header' => '<b>Riwayat Hearing Test</b>',
            'isi' => $this->renderPartial($this->path_view . '_formRiwayat', array(
                //'form'=>$form,
                'format' => $format,
                'modHearingTest' => $modHearingTest,
                'modHearingTestRiwayat' => $modHearingTestRiwayat,
                //'modPegawai'=>$modPegawai
            ), true),
            'active' => false,
        ),
    ),
)); ?>

<div class="formInputTab">
    <?php echo $form->errorSummary($modHearingTest); ?>
    <legend class="rim">Hearing Test</legend>
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

    <div class="form-actions">
        <?php
        $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
        $disableSave = false;
        $disableSave = (!empty($_GET['id'])) ? true : (($sukses > 0) ? true : false);
        ?>
        <?php $disablePrint = ($disableSave) ? false : true; ?>
        <?php
        //		echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'button', 'onclick'=>'cekInput();', 'onkeypress'=>'cekInputan();','disabled'=>$disableSave)); //formSubmit(this,event)        
        //  jika tanpa cek inputan
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => $disableSave)
        );

        ?>
        <?php if (!isset($_GET['frame'])) {
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id']),
                array(
                    'class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);'
                )
            );
        } ?>
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => $disablePrint, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
        ?>
        <?php
        $content = $this->renderPartial($this->path_view . 'tips/tipsTreadmill', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
    <?php $this->endWidget(); ?>
    <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modPendaftaran' => $modPendaftaran, 'modHearingTest' => $modHearingTest, 'modHearingTestRiwayat' => $modHearingTestRiwayat)); ?>

    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'diagramTelingaKanan',
        'options' => array(
            'title' => 'Diagram Telinga Kanan',
            'autoOpen' => false,
            'modal' => true,
            'width' => 600,
            'height' => 550,
            'resizable' => false,
        ),
    ));
    ?>
    <iframe name='frameTelingaKanan' style="width: 100%; height: 98%;"></iframe>
    <?php $this->endWidget(); ?>

    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'diagramTelingaKiri',
        'options' => array(
            'title' => 'Diagram Telinga Kiri',
            'autoOpen' => false,
            'modal' => true,
            'width' => 600,
            'height' => 550,
            'resizable' => false,
        ),
    ));
    ?>
    <iframe name='frameTelingaKiri' style="width: 100%; height: 98%;"></iframe>
    <?php $this->endWidget(); ?>