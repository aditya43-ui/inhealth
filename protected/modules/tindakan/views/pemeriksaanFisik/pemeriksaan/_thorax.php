<style type="text/css">
    table.thorak_input{
        margin-top: 10px;
    }
    table.thorak_input tr td{
        padding: 8px;
        color: #001F3E;
        vertical-align: top;
        text-align: center;
    }
    table.thorak_input tr td.linekiri{
        /*border-left: 1px solid #000;*/
    }
    table.thorak_input tr td.borderbawah{
        border-bottom: 1px solid #eee;
    }
    .pback{
        padding: 3px 8px;
        background-color: #96BA89;
        margin-right: 10px;
    }
</style>    

<?php echo $form->textFieldRow($modPemeriksaanFisik,'inspeksi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
<?php echo $form->textFieldRow($modPemeriksaanFisik,'palpasi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
<?php // echo $form->textFieldRow($modPemeriksaanFisik,'perkusi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
<?php // echo $form->textFieldRow($modPemeriksaanFisik,'auskultasi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
<table class="thorak_input">
    <tr>
        <td>
            <br>
            <br>
            Auskultasi
        </td>
        <td>
            <br>
            <br>
            <b class="pback">P</b> Rh
        </td>
        <td class="borderbawah">
            Kanan
            <br>
            <br>
            <p>
                <?php echo $form->dropDownList($modPemeriksaanFisik, 'au_parurhkanan_1', array('+'=>'+', '-'=>'-'), array('empty'=>'-- Pilih --', 'style'=>'width:80px;', 'class'=>'au_paruwhkanan')); ?>
            </p>
            <p>
                <?php echo $form->dropDownList($modPemeriksaanFisik, 'au_parurhkanan_2', array('+'=>'+', '-'=>'-'), array('empty'=>'-- Pilih --', 'style'=>'width:80px;', 'class'=>'au_paruwhkanan')); ?>
            </p>
            <p>
                <?php echo $form->dropDownList($modPemeriksaanFisik, 'au_parurhkanan_3', array('+'=>'+', '-'=>'-'), array('empty'=>'-- Pilih --', 'style'=>'width:80px;', 'class'=>'au_paruwhkanan')); ?>
            </p>
        </td>
        <td class="borderbawah">
            Kiri
            <br>
            <br>
            <p>
                <?php echo $form->dropDownList($modPemeriksaanFisik, 'au_parurhkiri_1', array('+'=>'+', '-'=>'-'), array('empty'=>'-- Pilih --', 'style'=>'width:80px;', 'class'=>'au_paruwhkiri')); ?>
            </p>
            <p>
                <?php echo $form->dropDownList($modPemeriksaanFisik, 'au_parurhkiri_2', array('+'=>'+', '-'=>'-'), array('empty'=>'-- Pilih --', 'style'=>'width:80px;', 'class'=>'au_paruwhkiri')); ?>
            </p>
            <p>
                <?php echo $form->dropDownList($modPemeriksaanFisik, 'au_parurhkiri_3', array('+'=>'+', '-'=>'-'), array('empty'=>'-- Pilih --', 'style'=>'width:80px;', 'class'=>'au_paruwhkiri')); ?>
            </p>
        </td>
    </tr>
    <tr>
        <td>
            <br>
            <br>
            
        </td>
        <td class="linekiri">
            <br>
            <br>
            &nbsp; &nbsp; &nbsp; &nbsp; Wh
        </td>
        <td>
            Kanan
            <br>
            <br>
            <p>
                <?php echo $form->dropDownList($modPemeriksaanFisik, 'au_paruwhkanan_1', array('+'=>'+', '-'=>'-'), array('empty'=>'-- Pilih --', 'style'=>'width:80px;', 'class'=>'au_paruwhkanan')); ?>
            </p>
            <p>
                <?php echo $form->dropDownList($modPemeriksaanFisik, 'au_paruwhkanan_2', array('+'=>'+', '-'=>'-'), array('empty'=>'-- Pilih --', 'style'=>'width:80px;', 'class'=>'au_paruwhkanan')); ?>
            </p>
            <p>
                <?php echo $form->dropDownList($modPemeriksaanFisik, 'au_paruwhkanan_3', array('+'=>'+', '-'=>'-'), array('empty'=>'-- Pilih --', 'style'=>'width:80px;', 'class'=>'au_paruwhkanan')); ?>
            </p>
        </td>
        <td>
            Kiri
            <br>
            <br>
            <p>
                <?php echo $form->dropDownList($modPemeriksaanFisik, 'au_paruwhkiri_1', array('+'=>'+', '-'=>'-'), array('empty'=>'-- Pilih --', 'style'=>'width:80px;', 'class'=>'au_paruwhkanan')); ?>
            </p>
            <p>
                <?php echo $form->dropDownList($modPemeriksaanFisik, 'au_paruwhkiri_2', array('+'=>'+', '-'=>'-'), array('empty'=>'-- Pilih --', 'style'=>'width:80px;', 'class'=>'au_paruwhkanan')); ?>
            </p>
            <p>
                <?php echo $form->dropDownList($modPemeriksaanFisik, 'au_paruwhkiri_3', array('+'=>'+', '-'=>'-'), array('empty'=>'-- Pilih --', 'style'=>'width:80px;', 'class'=>'au_paruwhkanan')); ?>
            </p>
        </td>
    </tr>
</table>

<table class="thorak_input">
    <tr>
        <td>
            <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
        </td>
        <td>
            <b class="pback">C</b> Bunyi Jantung
        </td>
        <td>S1</td>
        <td>
            <p>
                <?php echo $form->dropDownList($modPemeriksaanFisik, 'au_cardios1', array('Reguler'=>'Reguler', 'Irreguler'=>'Irreguler'), array('empty'=>'-- Pilih --', 'style'=>'width:100px;', 'class'=>'au_cardios')); ?>
            </p>
        </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td>S2</td>
        <td>
            <p>
                <?php echo $form->dropDownList($modPemeriksaanFisik, 'au_cardios2', array('Reguler'=>'Reguler', 'Irreguler'=>'Irreguler'), array('empty'=>'-- Pilih --', 'style'=>'width:100px;', 'class'=>'au_cardios')); ?>
            </p>
        </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td>S3</td>
        <td>
            <p>
                <?php echo $form->dropDownList($modPemeriksaanFisik, 'au_cardios3', array('+'=>'+', '-'=>'-'), array('empty'=>'-- Pilih --', 'style'=>'width:100px;', 'class'=>'au_cardios_1')); ?>
            </p>
        </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td>S4</td>
        <td>
            <p>
                <?php echo $form->dropDownList($modPemeriksaanFisik, 'au_cardios4', array('+'=>'+', '-'=>'-'), array('empty'=>'-- Pilih --', 'style'=>'width:100px;', 'class'=>'au_cardios_1')); ?>
            </p>
        </td>
    </tr>
</table>
<div class="control-group">
    <?php echo Chtml::label("Bising Jantung", 'bisingjantung', array('class' => 'control-label')) ?>
    <div class="controls">
    <?php echo $form->textField($modPemeriksaanFisik,'bisingjantung', array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
    </div>
</div>
<div class="control-group">
    <?php echo Chtml::label("Obgyn", 'panel_obgyn', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo $form->textField($modPemeriksaanFisik, 'panel_obgyn', array('class' => 'span3','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength' => 50, 'rows' => 3)); ?>
    </div>
</div>