<?php
$reproduksikblain = $model->reproduksi_kb;
?>
<div class="control-group">
    <label class="controls"><b>Untuk Pasien Bayi dan Anak</b></label>
</div>
<div class="control-group">
    <label class="controls">1.</label>
    <label class="controls col-sm-2">Lahir pada kehamilan</label>
    <label class="controls">:</label>
    <div class="controls">
        <?=
        $form->textField($model, 'bayi_lahir', ['class'=>'span1 numbers-only'])
        ?>
    </div>
    <label class="controls">Bulan/minggu, lahir di </label>
    <div class="controls">
        <?=
        $form->textField($model, 'bayi_lokasilahir', ['class'=>'span3','maxlength'=>100, 'onkeypress' => "return $(this).focusNextInputField(event)"])
        ?>
    </div>
</div>       

<div class="control-group">
    <label class="controls">2.</label>
    <label class="controls col-sm-2">Ditolong oleh</label>
    <label class="controls">:</label>
    <div class="controls">
        <?=
        $form->radioButtonList($model, 'bayi_ditolongoleh', [
            'Dokter' => 'Dokter',
            'Bidan' => 'Bidan',
            'Dukun' => 'Dukun',           
                ], [''])
        ?>
    </div>
</div>  

<div class="control-group">
    <label class="controls">3.</label>
    <label class="controls col-sm-2">Anak ke</label>
    <label class="controls">:</label>
    <div class="controls">
        <?=
        $form->textField($model, 'bayi_anakke', ['class'=>'span1 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)"])
        ?>
    </div>   
</div>    

<div class="control-group">
    <label class="controls">4.</label>
    <label class="controls col-sm-2">BBL</label>
    <label class="controls">:</label>
    <div class="controls">
        <?=
        $form->textField($model, 'bayi_bbl', ['class' => 'span1 angkacoma-only','onkeypress' => "return $(this).focusNextInputField(event)"])
        ?>
    </div>  
    <label class="controls">gr/kg, Panjang Badan : </label>
    <div class="controls">
        <?=
        $form->textField($model, 'bayi_panjangbadan', ['class' => 'span1 angkacoma-only','onkeypress' => "return $(this).focusNextInputField(event)"])
        ?>
    </div>
    <label class="controls">cm</label>
</div>

<div class="control-group">
    <label class="controls">5.</label>
    <label class="controls col-sm-2">BBL Sekarang</label>
    <label class="controls">:</label>
    <div class="controls">
        <?=
        $form->textField($model, 'bayi_bbsekarang', ['class' => 'span1 angkacoma-only','onkeypress' => "return $(this).focusNextInputField(event)"])
        ?>
    </div>  
    <label class="controls">kg, Tinggi Sekarang : </label>
    <div class="controls">
        <?=
        $form->textField($model, 'bayi_tinggisekarang', ['class' => 'span1 angkacoma-only','onkeypress' => "return $(this).focusNextInputField(event)"])
        ?>
    </div>  
    <label class="controls">cm</label>
</div>

<div class="control-group">
    <label class="controls">6.</label>
    <label class="controls col-sm-2">Nutrisi Anak</label>
    <label class="controls">:</label>
    <div class="controls">
        <?=
        $form->checkBox($model, 'is_nutrisi_asi', [])
        ?>
    </div>
    <label class="controls">ASI</label>
    <div class="controls">
        <?=
        $form->checkBox($model, 'is_nutrisi_pasi', [])
        ?>
    </div>
    <label class="controls">PASI</label>
    <div class="controls">
        <?=
        $form->checkBox($model, 'is_nutrisi_makanantambahan', [])
        ?>
    </div>
    <label class="controls">Makanan Tambahan</label>
</div> 

<div class="control-group">
    <label class="controls">7.</label>
    <label class="controls col-sm-2">Imunisasi</label>
    <label class="controls">:</label>
    <div class="kelompok">
        <div class="controls">
            <?=
            $form->checkBox($model, 'is_imunisasi_dasar', ['class'=>'open-ket-dis'])
            ?>
        </div>
        <label class="controls">Dasar, Jenis</label>
        <div class="controls">
            <?=
            $form->textField($model, 'jenis_imunisasi', ['maxlength'=>100,'class'=>'span2 ket-dis','onkeypress' => "return $(this).focusNextInputField(event)"])
            ?>
        </div>
    </div>
    <div class="kelompok">
        <div class="controls">
            <?=
            $form->checkBox($model, 'is_imunisasi_ulang', ['class'=>'open-ket-dis'])
            ?>
        </div>
        <label class="controls">Ulang imunisasi : ya/tidak</label>
        <div class="controls">
            <?=
            $form->textField($model, 'jenis_imunisasiulang', ['maxlength'=>100,'class'=>'span2 ket-dis','onkeypress' => "return $(this).focusNextInputField(event)"])
            ?>
        </div>
    </div>
</div> 