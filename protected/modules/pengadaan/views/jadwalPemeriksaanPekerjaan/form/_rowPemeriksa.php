<tr row-data="0">
    <td>
        <div class="control-group">
            <div class="controls" style="margin-left:0px;">
        <?php
                echo CHtml::activeHiddenField($model, '['.$i.']pegpemeriksa_id', array('readonly' => true, 'class' => 'span4 pegpemeriksa_id required',));
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => '['.$i.']pegpemeriksa_nama',
                    'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('/actionAutoComplete/GetPejabatPengadaan') . '",
                                dataType: "json",
                                data: {
                                    term: request.term,                                    
                                    jabatan_pengadaan:"'.Params::JABATAN_PENGADAAN_TIM_TEKNIS.'"
                                },
                                success: function (data) {
                                    response(data);
                                }
                            })
                        }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                return false;
                            }',
                        'select' => 'js:function( event, ui ) {
                                setPegPemeriksa(ui.item, this);
                                return false;
                            }',
                    ),
                    'htmlOptions' => array(
                        'class' => 'lebarcustom pegpemeriksa_nama ',
                        'placeholder' => 'Ketik Nama Pemeriksa',                            
                        'onblur' => 'if(this.value==""){clearPegPemeriksa(this);}'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPeg', 'jsFunction'=>'setRow(this);$("#dialogPeg").dialog("open");'),
                ));
                ?>
            </div>
            <div class="controls">
                <?php                
                   echo CHtml::link('<i class="glyphicon glyphicon-minus"></i>', "javascript:;", array('class'=>'btnhapus btn btn-danger hide','onclick'=>'hapusBaris(this); return false;'));        
                   echo "&nbsp;&nbsp;&nbsp;";
                   echo CHtml::link('<i class="glyphicon glyphicon-plus"></i>', "javascript:;", array('class'=>'btntambah btn btn-primary ','onclick'=>'tambahBaris(this); return false;'));                
               ?>
           </div>
        </div>
    </td>    
</tr>