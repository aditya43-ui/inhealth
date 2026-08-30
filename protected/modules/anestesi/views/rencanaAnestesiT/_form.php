<div class="row-fluid">
    <div class="span6">
        <div class="pramedikasi">
            <table width=100%>
                <tr>
                    <td rowspan="4" style="vertical-align: top; width: 25%" > 
                        <?php echo $form->checkBox($model, 'premedikasi', array('onkeypress' => "return $(this).focusNextInputField(event)", 'onclick' => 'setPramedikasi()')); ?> <label> Pramedikasi </label> <br>
                    </td>
                    <td>
                        <?php echo $form->checkBox($model, 'premedikasi_midazolam', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Midazolam Dosis 0,07 - 0,15 mg/KgBB, IM </label> <br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo $form->checkBox($model, 'premedikasi_morphine', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Morphine Dosis 0,05 - 0,2 mg/KgBB, IM </label> <br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo $form->checkBox($model, 'premedikasi_pethidine', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Pethidine Dosis 0,5 - 1 mg/KgBB, IM </label> <br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo $form->checkBox($model, 'premedikasi_ssulfasatropin', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Sulfas Atropin Dosis 0,01 - 0,02 mg/KgBB, IM </label> <br>
                    </td>
                </tr>
            </table>        
            <?php echo $form->checkBox($model, 'sedasi', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Sedasi </label>
            <?php echo $form->checkBox($model, 'monitor', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Monitor </label>
            <?php echo $form->checkBox($model, 'observasi', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Observasi </label>
            <br>
            <?php echo $form->checkBox($model, 'general_anestesi', array('onclick' => 'setGeneral()', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> General Anestesi </label>
            <?php echo $form->checkBox($model, 'general_masker', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Masker </label>
            <?php echo $form->checkBox($model, 'general_tiva', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> TIVA </label>
            <?php echo $form->checkBox($model, 'general_intubasi', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Intubasi </label>
            <?php echo $form->checkBox($model, 'general_lma', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> LMA </label>
        </div>
        <div class="induksi">
            <p> <b> INDUKSI </b></p>
            <table width=100%>
                <tr>
                    <td>
                        <?php echo $form->checkBox($model, 'induksi_insfluasidengan', array('onclick' => 'setInsfluasi()', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Insfluasi dengan </label>
                    </td>
                    <td>
                        <?php echo $form->textField($model, 'induksi_insfluasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </td>
                </tr>
                <tr>
                    <td rowspan="3" style="vertical-align: top; width: 25%"> 
                        <?php echo $form->checkBox($model, 'induksi_sedatif', array('onkeypress' => "return $(this).focusNextInputField(event)", 'onclick' => 'setSedatif()')); ?> <label> Sedatif </label> <br>
                    </td>
                    <td>
                        <?php echo $form->checkBox($model, 'induksi_sedatif_midazolam', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Midazolam, Dosis 0,1 - 0,4 mg/KgBB, IV </label> <br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo $form->checkBox($model, 'induksi_sedatif_propofol', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Propofol, Dosis 1-2,5 mg/KgBB, IV</label> <br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo $form->checkBox($model, 'induksi_sedatif_ketamine', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Ketamine, Dosis 1-2 mg/KgBB. IV</label> <br>
                    </td>
                </tr>
            </table>
            <table width=100%>
                <tr>
                    <td rowspan="4" style="vertical-align: top; width: 25%"> 
                        <?php echo $form->checkBox($model, 'induksi_analgetik', array('onkeypress' => "return $(this).focusNextInputField(event)", 'onclick' => 'setAnalgetik()')); ?> <label> Analgetik </label> <br>
                    </td>
                    <td>
                        <?php echo $form->checkBox($model, 'induksi_analgetik_morphine', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Morphine, Dosis 0,1-1 mg/KgBB, IV</label> <br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo $form->checkBox($model, 'induksi_analgetik_pethidine', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Pethidine, Dosis 2,5-5 mg/KgBB, IV </label> <br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo $form->checkBox($model, 'induksi_analgetik_fentanyl', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Fentanyl, Dosis2-150 mg/KgBB, IV </label> <br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo $form->checkBox($model, 'induksi_analgetik_ketamine', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Ketamine, Dosis 0,25 - 0,5  mg/KgBB, IV </label> <br>
                    </td>
                </tr>
            </table>
            <table width=100%>
                <tr>
                    <td rowspan="3" style="vertical-align: top; width: 25%"> 
                        <?php echo $form->checkBox($model, 'induksi_pelumpuhotak', array('onkeypress' => "return $(this).focusNextInputField(event)", 'onclick' => 'setPelumpuhOtak()')); ?> <label> Pelumpuh Otak </label> <br>
                    </td>
                    <td>
                        <?php echo $form->checkBox($model, 'induksi_pelumpuhotak_atracurium', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Atracurium, Dosis 0,5 mg/KgBB, IV </label> <br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo $form->checkBox($model, 'induksi_pelumpuhotak_vecuronium', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Vecuronium, Dosis 0,12 mg/KgBB, IV </label> <br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo $form->checkBox($model, 'induksi_pelumpuhotak_rocuronium', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Rocuronium, Dosis 0,6 - 1,2 mg/KgBB, IV </label> <br>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="span6">
        <p> <b> MAINTENANCE </b></p>
        <table width=100%>
            <tr>
                <td rowspan="6" style="vertical-align: top; width: 25%"> 
                    <?php echo $form->checkBox($model, 'inhalasi', array('onkeypress' => "return $(this).focusNextInputField(event)", 'onclick' => 'setInhalasi()')); ?> <label> Inhalasi </label> <br>
                </td>
                <td>
                    <?php echo $form->checkBox($model, 'inhalasi_o2', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> O2 </label> <br>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->checkBox($model, 'inhalasi_halothan', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Halothan, 1 MAC = 0,75% </label> <br>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->checkBox($model, 'inhalasi_isofluran', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Isofluran, 1 MAC = 1,2% </label> <br>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->checkBox($model, 'inhalasi_sevofluran', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Sevofluran, 1 MAC = 2%  </label> <br>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->checkBox($model, 'inhalasi_enfluran', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Enfluran, 1 MAC = 1,7%  </label> <br>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->checkBox($model, 'inhalasi_desflurane', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Defluran, 1 MAC = 6% </label> <br>
                </td>
            </tr>
        </table>
        <table width=100%>
            <tr>
                <td rowspan="8" style="vertical-align: top; width: 25%">
                    <?php echo $form->checkBox($model, 'intravena', array('onClick' => 'setIntravena()', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Intravena </label> <br>
                </td>
                <td>
                    <?php echo $form->checkBox($model, 'intravena_propofol', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Propofol, Dosis 1-2 mg/KgBB </label> <br>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->checkBox($model, 'intravena_morphien', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Morphine, Dosis 0,1-1 mg/KgBB </label> <br>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->checkBox($model, 'intravena_pethidine', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Pethidine, Dosis 2,5-5 mg/KgBB </label> <br>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->checkBox($model, 'intravena_fentanyl', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Fentanyl, Dosis 2-150 mg/KgBB </label> <br>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->checkBox($model, 'intravena_atracurium', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Atracurium, Dosis 0,1 mg/KgBB </label> <br>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->checkBox($model, 'intravena_vecuronium', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Vecuronium, Dosis 0,01 mg/KgBB </label> <br>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->checkBox($model, 'intravena_recoronium', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Rocuronium, Dosis 0,15 mg/KgBB  </label> <br>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->checkBox($model, 'intravena_lainnya_cek', array('onkeypress' => "return $(this).focusNextInputField(event)",
                        'onclick' => 'cekIntravenaLain(this);'
                        )); ?> 
                    <label> Lainnya </label> <?php echo $form->textField($model, 'intravena_lainnya', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>  
                    <label> Dosis </label><?php echo $form->textField($model, 'intravena_lainnya_dosis', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>

                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td rowspan="3" style="vertical-align: top; width: 25%">
                    <?php echo $form->checkBox($model, 'regional_anestesi', array('onclick' => 'setRegional()', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Regional Anastesi</label>                     
                </td> 
                <td>
                    <?php echo $form->checkBox($model, 'sab', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> SAB  </label> 
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->checkBox($model, 'epidural', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Epidural </label>  
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->checkBox($model, 'pnb', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> PNB </label> 
                </td>
            </tr>
        </table>
        <table width=100%>
            <tr>
                <td rowspan="3" style="vertical-align: top; width: 25%">
                    <?php echo $form->checkBox($model, 'anestesi_lokal', array('onclick' => 'setAnestesi()', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Anastesi Lokal </label> 
                </td>
                <td>
                    <?php echo $form->checkBox($model, 'anestesi_lokal_lidocaine', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Lidocaine, Dosis maks 4,5 mg/KgBB (7mg/KgBB dengan epinephrine) </label> 
                </td>
            </tr>   
            <tr>
                <td>
                    <?php echo $form->checkBox($model, 'anestesi_lokal_bupivacaine', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Bupivacaine, Dosis maks 2,5 mg/KgBB(3mg/KgBB dengan epinephrine) </label> 
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->checkBox($model, 'anestesi_lokal_rapivacaine', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Ropivacaine, Dosis maks 3 mg/KgBB </label> 
                </td>
            </tr>
        </table>
        <table width='100%'>
            <tr>
                <td rowspan="2" style="vertical-align: top; width: 25%">
                    <?php echo $form->checkBox($model, 'additif', array('onclick' => 'setAdditif()','onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> Additif </label> 
                </td>
                <td>
                    <?php echo $form->textField($model, 'additif_keterangan1', array('placeholder' => 'Keterangan','class' => 'span2','onkeypress' => "return $(this).focusNextInputField(event)")); ?> 
                </td>
                <td>
                     <label> Dosis </label> <?php echo $form->textField($model, 'additif_dosis1', array('placeholder' => 'Dosis','class' => 'span2','onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->textField($model, 'additif_keterangan2', array('placeholder' => 'Keterangan','class' => 'span2','onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                </td>
                <td>
                    <label> Dosis </label> <?php echo $form->textField($model, 'additif_dosis2', array('placeholder' => 'Dosis','class' => 'span2','onkeypress' => "return $(this).focusNextInputField(event)")); ?> 
                </td>
            </tr>
        </table>
    </div>
</div>