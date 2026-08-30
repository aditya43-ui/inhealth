<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">
            <label for="" class="control-label">Klinik</label>
            <div class="controls">
                <?php echo $form->textField($modAdvancePayment,'nama_rumahsakit', array('readonly'=>true)) ?>
            </div>
            
        </div>
        <?php echo $form->HiddenField($modAdvancePayment,'advancepayment_id', array('readonly'=>true)) ?>
        <?php echo $form->textFieldRow($modAdvancePayment,'jenistransaksi', array('readonly'=>true)) ?>
        <?php echo $form->textFieldRow($modAdvancePayment,'tglpengajuan', array('readonly'=>true)) ?>
        <?php echo $form->textFieldRow($modAdvancePayment,'nopengajuan', array('readonly'=>true)) ?>
        <div class="control-group">
            <label for="" class="control-label">Tgl. Kas Keluar</label>
            <div class="controls">
                <?php echo $form->textField($modAdvancePayment,'tglkaskeluar', array('readonly'=>true)) ?>
            </div>
            
        </div>
        <div class="control-group">
            <label for="" class="control-label">No. Kas Keluar</label>
            <div class="controls">
                <?php echo $form->textField($modAdvancePayment,'nokaskeluar', array('readonly'=>true)) ?>
            </div>
            
        </div>
        <?php echo $form->textFieldRow($modAdvancePayment,'nodokumen', array('readonly'=>true)) ?>
        <?php echo $form->textFieldRow($modAdvancePayment,'noanggaran', array('readonly'=>true)) ?>
        <?php echo $form->textAreaRow($modAdvancePayment,'keterangan', array('readonly'=>true)) ?>

    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <label for="" class="control-label">Pegawai Yang Mengajukan</label>
            <div class="controls">
                <?php echo $form->textField($modAdvancePayment,'pegawai_nama', array('readonly'=>true)) ?>
            </div>
        </div>
        <div class="control-group">
            <label for="" class="control-label">Pegawai Pemeriksa</label>
            <div class="controls">
                <?php echo $form->textField($modAdvancePayment,'pegawaipemeriksa_nama', array('readonly'=>true)) ?>
            </div>
        </div>
        <div class="control-group">
            <label for="" class="control-label">Pegawai Menyetujui</label>
            <div class="controls">
                <?php echo $form->textField($modAdvancePayment,'pegawaimenyetujui_nama', array('readonly'=>true)) ?>
            </div>
        </div>
        <div class="control-group">
            <label for="" class="control-label">Cara Pembayaran</label>
            <div class="controls">
                <?php echo $form->textField($modTandaBuktiKeluar,'carabayarkeluar', array('readonly'=>true)) ?>
            </div>
        </div>
        <?php echo $form->textAreaRow($modAdvancePayment,'catatanpembayaran', array('readonly'=>true)) ?>
        <?php echo $form->textFieldRow($modAdvancePayment,'jmlpembayaran', array('readonly'=>true,'class'=>'integer-decimal')) ?>
        <?php echo $form->textFieldRow($modTandaBuktiKeluar,'biayaadministrasi', array('readonly'=>true,'class'=>'integer-decimal')) ?>
        <?php echo $form->textFieldRow($modTandaBuktiKeluar,'jmlkaskeluar', array('readonly'=>true,'class'=>'integer-decimal')) ?>

    </div>
</div>