<div class="row-fluid">
     <div class="panel panel-primary panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"><strong>Kebutuhan Aktifitas & Istirahat</strong></div>
        </div>
         <div class="panel-body">
             <table width="100%">
                 <tr>
                     <td width="50%">
                         <table width="100%">
                             <tr>
                                 <td class="fontColor" style="width:250px">
                                     Rentang Gerak / Range Of Motion(ROM)
                                 </td>
                                 <td colspan="2">
                                     <div class="controls">
                                        <div class="radio inline">
                                            <div class="form-inline">
                                                <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'rentanggerak',array('Aktif'=>'Aktif','Pasif'=>'Pasif','Tidak dapat dinilai'=>'Tidak dapat dinilai') , array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                                            </div>
                                        </div>
                                    </div>
                                 </td>
                             </tr>
                             <tr>
                                 <td class="fontColor">
                                     Deformitas
                                 </td>
                                 <td>
                                     <div class="controls">
                                        <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'deformitas_status',array(0=>'Tidak Ada',1=>'Ada ,Regio') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setDeformitas(this);')); ?>
                                    </div>
                                 </td>
                                 <td valign="bottom">
                                     <?php echo $form->textField($modAsesmenawalkeperawatanT, 'deformitas_regio', array('class' => 'span3 inline', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
                                 </td>
                             </tr>
                         </table>
                     </td>
                     <td width="50%">
                         <table width="100%">
                             <tr>
                                 <td class="fontColor" style="width:250px">
                                     Gangguan Tidur
                                 </td>
                                 <td>
                                      <div class="controls">
                                        <?php echo $form->radioButtonList($modAsesmenawalkeperawatanT,'gangguantidur_status',array(0=>'Tidak',1=>'Ya') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'setGangguanTidur(this);')); ?>
                                    </div>
                                 </td>
                             </tr>
                             <tr>
                                 <td>&nbsp;</td>
                                 <td>
                                     <?php echo $form->textArea($modAsesmenawalkeperawatanT, 'gangguantidur_keterangan', array('rows' => 2, 'cols' => 1, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
                                 </td>
                             </tr>
                         </table>
                     </td>
                 </tr>
             </table>




         </div>
     </div>
</div>
