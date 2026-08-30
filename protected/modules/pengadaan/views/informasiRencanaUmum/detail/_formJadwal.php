<?php if($model->rencanaumumpengadaan_kategori == 'Swakelola'){?>
<div class="row-fluid">
    <div class="col-md-12">
        <div class="control-group">
            <?php echo $form->labelEx($model,'Pelaksanaan Pekerjaan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $model->pelaksanaankontrak_tglawal = date('d ', strtotime($model->pelaksanaankontrak_tglawal)) . MyFormatter::getMonthId(date('m', strtotime($model->pelaksanaankontrak_tglawal))) . date(' Y', strtotime($model->pelaksanaankontrak_tglawal));
                echo $form->textField($model, 'pelaksanaankontrak_tglawal', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
            <div class="controls">
            <label> - </label>
            </div>
            <div class="controls">
                <?php
                $model->pelaksanaankontrak_tglakhir = date('d ', strtotime($model->pelaksanaankontrak_tglakhir)) . MyFormatter::getMonthId(date('m', strtotime($model->pelaksanaankontrak_tglakhir))) . date(' Y', strtotime($model->pelaksanaankontrak_tglakhir));
                echo $form->textField($model, 'pelaksanaankontrak_tglakhir', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
        </div>
    </div>
</div>
<?php }else{ ?>
<div class="row-fluid">
    <div class="col-md-12">
        <div class="control-group">
            <?php echo $form->labelEx($model,'Pemanfaatan Barang/Jasa', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $model->pemanfaatanbarang_tglawal = date('d ', strtotime($model->pemanfaatanbarang_tglawal)) . MyFormatter::getMonthId(date('m', strtotime($model->pemanfaatanbarang_tglawal))) . date(' Y', strtotime($model->pemanfaatanbarang_tglawal));
                echo $form->textField($model, 'pemanfaatanbarang_tglawal', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
            <div class="controls">
            <label> - </label>
            </div>
            <div class="controls">
                <?php
                $model->pemanfaatanbarang_tglakhir = date('d ', strtotime($model->pemanfaatanbarang_tglakhir)) . MyFormatter::getMonthId(date('m', strtotime($model->pemanfaatanbarang_tglakhir))) . date(' Y', strtotime($model->pemanfaatanbarang_tglakhir));
                echo $form->textField($model, 'pemanfaatanbarang_tglakhir', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="control-group">
            <?php echo $form->labelEx($model,'Pelaksanaan Kontrak', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $model->pelaksanaankontrak_tglawal = date('d ', strtotime($model->pelaksanaankontrak_tglawal)) . MyFormatter::getMonthId(date('m', strtotime($model->pelaksanaankontrak_tglawal))) . date(' Y', strtotime($model->pelaksanaankontrak_tglawal));
                echo $form->textField($model, 'pelaksanaankontrak_tglawal', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
            <div class="controls">
            <label> - </label>
            </div>
            <div class="controls">
                <?php
                $model->pelaksanaankontrak_tglakhir = date('d ', strtotime($model->pelaksanaankontrak_tglakhir)) . MyFormatter::getMonthId(date('m', strtotime($model->pelaksanaankontrak_tglakhir))) . date(' Y', strtotime($model->pelaksanaankontrak_tglakhir));
                echo $form->textField($model, 'pelaksanaankontrak_tglakhir', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="control-group">
            <?php echo $form->labelEx($model,'Pelaksanaan Pemilihan Penyedia', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $model->pemilihanpenyedia_tglawal = date('d ', strtotime($model->pemilihanpenyedia_tglawal)) . MyFormatter::getMonthId(date('m', strtotime($model->pemilihanpenyedia_tglawal))) . date(' Y', strtotime($model->pemilihanpenyedia_tglawal));
                echo $form->textField($model, 'pemilihanpenyedia_tglawal', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
            <div class="controls">
            <label> - </label>
            </div>
            <div class="controls">
                <?php
                $model->pemilihanpenyedia_tglakhir = date('d ', strtotime($model->pemilihanpenyedia_tglakhir)) . MyFormatter::getMonthId(date('m', strtotime($model->pemilihanpenyedia_tglakhir))) . date(' Y', strtotime($model->pemilihanpenyedia_tglakhir));
                echo $form->textField($model, 'pemilihanpenyedia_tglakhir', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>