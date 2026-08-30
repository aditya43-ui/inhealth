<div class="col-sm-9">
    <div class="control-group form-panggil-antrian" style="text-align: center;">
        <div class="controls">
            <label>Jenis Antrian</label><br/>
            <?= CHtml::dropDownList('jenisAntrian', '', ModelantrianM::dropModelAntrian(),['class'=>'required','empty'=>'-- Pilih --']) ?>
        </div>
        
        <div class="controls">
            <label>Loket</label><br/>
            <?= CHtml::dropDownList('loket', '', [],['class'=>'required','empty'=>'-- Pilih --']) ?>
        </div>
        
        <div class="controls">
            <label>Jumlah Panggil</label><br/>
            <?= CHtml::dropDownList('jumlahPanggil', '', [
                1 => 1,
                5 => 5,
                10 => 10,
                20 => 20
            ],['empty'=>'-- Pilih --','class'=>'span2 required']) ?>
        </div>
        
        <div class="controls">
            <label>Panggil</label><br/>
            <label id="panggilAntrian" onclick="panggilNoAntrian('');" class='hover'><span  rel="tooltip" title="Klik untuk panggil antrian" class="glyphicon glyphicon-volume-up hover" style="font-size:30px;"></span></label>
        </div>
    </div>
</div>
<style>
    #tampil-no-antrian .box-antrian:not(:first-child){
        display: none;
    }
    .flex-100 {
        flex: 1 100%;
    }
</style>
<div><b>No. Antrian Sedang Dipanggil</b></div>
<div id="tampil-no-antrian" class="col-sm-3" style="display:flex;align-items: center;justify-content: center;">
    <div class="flex-100 flex text-center container-dipanggil" style="padding-top: 0px;">

    </div>
    <?php // $this->renderPartial('form/baris/_1_barisNoAntrian',[], true) ?>
</div>