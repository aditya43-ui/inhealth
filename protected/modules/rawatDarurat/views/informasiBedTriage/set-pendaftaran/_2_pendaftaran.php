<div class="row" style="padding-left: 20px;">
    <div class="row">
        <div class="col-md-4">
            <label class="control-label">Nomor Pendaftaran<span class="required">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="controls">
                <?php
                $criteria = new CDbCriteria();
                // $criteria->addCondition(" statusperiksa = '" . Params::STATUSPERIKSA_ANTRIAN . "' ");
                $criteria->addCondition(" instalasi_id = '" . Params::INSTALASI_ID_RD . "' ");
                $criteria->addCondition(" tgl_pendaftaran::date = '" . date('Y-m-d') . "' ");
                $criteria->select = 'pendaftaran_id,no_pendaftaran,nama_pasien';
                $criteria->group = 'pendaftaran_id,no_pendaftaran,nama_pasien';
                // echo '<pre>';var_dump($criteria);die;
                $infokunjungan = InfokunjunganrdV::model()->findAll($criteria);
                ?>
                <select id="select-state" class="required span4" onchange="loadDataPasien(this)" style="font-size: 10px;">
                    <option value="">-- Pilih --</option>
                    <?php foreach ($infokunjungan as $result) { ?>
                        <option value="<?php echo $result->pendaftaran_id; ?>">
                            <?php echo $result->no_pendaftaran . " - " . $result->nama_pasien; ?>
                        </option>
                    <?php } ?>
                </select>
                <?php // echo $form->dropDownList($model, 'pendaftaran_id', InfokunjunganrdV::loadPendaftaranAntrian(), ['empty' => '-- Pilih --', 'class' => 'required', 'onchange' => 'loadDataPasien(this)']); ?>
                <?php 
                echo $form->hiddenField($model, 'pendaftaran_id', array('readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); 
                echo $form->hiddenField($model, 'pasien_id', array('class' => 'petugastriage_id', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); 
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="control-label">Nama Pasien<span class="required">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="controls" style="padding-top: 7px;">
                <b class="label-nama-pasien"><?= $modPas->nama_pasien ?></b>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="control-label">Nomor Rekam Medik<span class="required">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="controls" style="padding-top: 7px;">
                <b class="label-no-rm"><?= $modPas->no_rekam_medik ?></b>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="control-label">Alamat Pasien<span class="required">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="controls" style="padding-top: 7px;">
                <b class="label-alamat-pasien"><?= $modPas->alamat_pasien ?></b>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
      $('#select-state').selectize({
          sortField: 'text',
          hideSelected: 'true'
      });
  });
</script>