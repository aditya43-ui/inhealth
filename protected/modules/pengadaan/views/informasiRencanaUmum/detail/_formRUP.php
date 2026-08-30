<div class="row-fluid">
    <div class="col-md-12">
        <?php echo $form->textFieldRow($model, 'rencanaumumpengadaan_nomor', array('disabled' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php
        if (!empty($_GET['revisi'])) {
            echo $form->textFieldRow($model, 'kode_rup', array('disabled' => false, 'class' => 'span4'));
        }
        ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'rencanaumumpengadaan_tanggal', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $model->rencanaumumpengadaan_tanggal = date('d ', strtotime($model->rencanaumumpengadaan_tanggal)) . MyFormatter::getMonthId(date('m', strtotime($model->rencanaumumpengadaan_tanggal))) . date(' Y', strtotime($model->rencanaumumpengadaan_tanggal));
                echo $form->textField($model, 'rencanaumumpengadaan_tanggal', array('disabled' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'pegawaipembuat_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->hiddenField($model, 'pegawaipembuat_id', array('disabled' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                echo $form->textField($model, 'pegawaipembuat_nama', array('disabled' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'unitkerja_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->hiddenField($model, 'unitkerja_id', array('disabled' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                echo $form->textField($model, 'unitkerja_nama', array('disabled' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif IS TRUE ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array('disabled' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'rencanaumumpengadaan_tahun', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'periodeanggaran_id', $model->getPeriodeAnggaran(), array('disabled' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)"));
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"> Ketegori Pekerjaan </label>
            <div class="controls">
                <?= $form->textField($model, 'ispaket', array('value' => ($model->ispaket == 1) ? 'Paket' : 'Non Paket', 'disabled' => true, 'class' => 'span4')); ?>
            </div>
        </div>
        <?php if ($model->ispaket == true) : ?>
            <div class="control-group" id="form-pilih-paket">
                <label class="control-label">&nbsp;</label>
                <div class="controls">
                    <table width="50%" class="table table-striped table-bordered table-condensed" id="tabel-paket-rup">
                        <thead>
                            <tr>
                                <th style="text-align: center">No.</th>
                                <th style="text-align: center">Kode Paket Pekerjaan </th>                            
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $criRen = new CDbCriteria();
                            $criRen->addCondition('rencanaumumpengadaan_id = ' . $model->rencanaumumpengadaan_id);
                            $criRen->select = "paketpekerjaan_id";
                            $criRen->group = $criRen->select;
                            $modDetail = ADRencanaumumpengadaandetT::model()->findAll($criRen);
                            if (!empty($modDetail)) {
                                $no = 1;
                                foreach ($modDetail as $det) {
                                    if (!empty($det->paketpekerjaan_id)) {
                                        $modPaket = PaketpekerjaanT::model()->findByPk($det->paketpekerjaan_id);
                                        ?>
                                        <tr>
                                            <td> <?= $no++ ?></td>
                                            <td> <?= $modPaket['kode_paketpekerjaan'] ?></td> 
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif ?>
        <div class="control-group" id="form-pilih-paket">
            <label class="control-label">&nbsp;</label>
            <div class="controls">
                <table width="50%" class="table table-striped table-bordered table-condensed" id="tabel-program-kegiatan">
                    <thead>
                        <tr>
                            <th style="text-align: center"> Program </th>
                            <th style="text-align: center"> Kegiatan </th>                            
                            <th style="text-align: center"> Sub Kegiatan </th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $modProgram = PengadaanprogramT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $model->rencanaumumpengadaan_id));
                        if (!empty($modProgram)) {
                            foreach ($modProgram as $data) {
                                ?>
                                <tr>
                                    <td> <?= $data->programkerja->programkerja_nama ?></td>
                                    <td> <?= $data->kegiatanprogram->kegiatanprogram_nama ?></td>
                                    <td> <?= $data->subkegiatanprogram->subkegiatanprogram_nama ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'nama_pekerjaan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->textField($model, 'nama_pekerjaan', array('disabled' => true, 'class' => 'span8', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Nama Pekerjaan'));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Lokasi Pekerjaan', array('class' => 'control-label')); ?>
            <div class="controls">
                <table class="table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Propinsi <span class="required">*</span></th>
                            <th>Kabupaten/Kota <span class="required">*</span></th>
                            <th>Detail Lokasi</th>
                        </tr>
                    </thead>
                    <tbody id="lokasiPekerjaan">
                        <?php
                        $tr = "";
                        if (count($arrLokasi)) {
                            $i = 1;
                            foreach ($arrLokasi as $key => $value) {
                                $tr .= $this->renderPartial("detail/_rowLokasiPekerjaan", array('sendiri' => true, 'modLokasi' => $value, 'form' => $form, 'i' => $i++), true);
                            }
                            echo $tr;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>


        <div class="swakelola">
            <div class="control-group swakelola">
                <?php echo $form->labelEx($model, 'Tipe Swakelola', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo $form->textField($model, 'swakelola_tipe', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'swakelola_penyelenggara', array('class' => 'control-label')); ?>
                <div class="controls" style="padding-top: 6px !important">
                    <label><b>K/L/P/D</b></label>
                    <br>
                    <?php
                    echo $form->textField($model, 'swakelola_penyelenggara', array('readonly' => true, 'class' => 'span8', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'K/L/P/D'));
                    ?>
                    <br>
                    <label><b>Satker/OPD</b></label>
                    <br>
                    <?php
                    echo $form->textField($model, 'swakelola_satker', array('readonly' => true, 'class' => 'span8', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Satker/ODP'));
                    ?>
                </div>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'is_hutang', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->radioButtonList($model, 'is_hutang', array('1' => "YA", '0' => 'TIDAK'), array('disabled' => true, 'class' => 'span1', 'value' => 'pengunjung', 'inline' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"))
                ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow($model, 'rencanaumumpengadaan_kategori', LookupM::getItems('kategoripengadaan'), array('disabled' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onchange' => 'setJenisRUP(this)')); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'volume_pekerjaan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->textField($model, 'volume_pekerjaan', array('disabled' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Volume'));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'uraian_pekerjaan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->textArea($model, 'uraian_pekerjaan', array('disabled' => true, 'class' => 'span8', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Uraian'));
                ?>
            </div>
        </div>
        <div class="penyedia">
            <div class="control-group">
                <?php echo $form->labelEx($model, 'spesifikasi_pekerjaan', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo $form->textArea($model, 'spesifikasi_pekerjaan', array('readonly' => true, 'class' => 'span8', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Spesifikasi'));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'isprodukdalamnegeri', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $isprodukdalamnegeri = '';
                    if ($model->isprodukdalamnegeri == 0) {
                        $isprodukdalamnegeri = 'TIDAK';
                    } elseif ($model->isprodukdalamnegeri == 1) {
                        $isprodukdalamnegeri = 'YA';
                    }
                    echo $form->textField($model, 'isprodukdalamnegeri', array('readonly' => true, 'class' => 'span8', 'onkeyup' => "return $(this).focusNextInputField(event);", 'value' => $isprodukdalamnegeri));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'isusahakecil', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $isusahakecil = '';
                    if ($model->isusahakecil == 0) {
                        $isusahakecil = 'TIDAK';
                    } elseif ($model->isusahakecil == 1) {
                        $isusahakecil = 'YA';
                    }
                    echo $form->textField($model, 'isusahakecil', array('readonly' => true, 'class' => 'span8', 'onkeyup' => "return $(this).focusNextInputField(event);", 'value' => $isusahakecil));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>