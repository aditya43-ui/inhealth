<div id="" hidden>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-gradient">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-info-circled"></i> Informasi <b>Harga</b>
                    </div>
                </div>
                <div class="panel-body">
                    <?php echo $form->textFieldRow($modFakturPembelian, 'totharganetto', array('class' => 'span3 integer2', 'readonly' => TRUE, 'onkeyup' => "return $(this).focusNextInputField(event)")) ?>
                    <?php /*
					<div class="control-group">
							<label class='control-label'>
								<?php //echo CHtml::checkbox('diskonSemua',false,array('onclick'=>'setPersenDiskonFaktur(this)','disabled'=>TRUE,'style'=>'width : 10px', 'onkeyup'=>"return $(this).focusNextInputField(event)"))?>
								Diskon 
							</label>
							<div class="controls">
								<?php echo $form->textField($modFakturPembelian,'persendiscount', array('class'=>'span2  float2','readonly'=>false, 'onblur'=>'setJmlDiskonFaktur(this);hitungTotalFaktur()'));   ?>
							</div>
						</div>
					 * 
					 */ ?>
                    <div class="control-group">
                        <label class='control-label'>
                            Total Keringanan
                        </label>
                        <div class="controls">
                            <?php
                            $modFakturPembelian->persendiscount = (empty($modFakturPembelian->persendiscount) ? 0 : $modFakturPembelian->persendiscount);
                            echo $form->textField($modFakturPembelian, 'persendiscount', array('class' => 'span1  float2', 'readonly' => false, 'onblur' => 'setJmlDiskonFaktur(this);hitungTotalFaktur()')) . '% ';   ?>
                        </div>
                        <div class="controls">
                            <?php echo $form->textField($modFakturPembelian, 'jmldiscount', array('class' => 'span2 integer2', 'readonly' => false, 'onblur' => 'setPersenDisFaktur(this);hitungTotalFaktur()')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class='control-label'>
                            <?php //echo CHtml::checkbox('termasukPPN',true,array('onclick'=>'persenPpn(this)','disabled'=>TRUE,'style'=>'width : 10px', 'onkeyup'=>"return $(this).focusNextInputField(event)"))
                            ?>
                            Total PPN
                        </label>
                        <div class="controls">
                            <?php
                            $modFakturPembelian->persenppn = (empty($modFakturPembelian->persenppn) ? 10 : $modFakturPembelian->persenppn);
                            echo $form->textField($modFakturPembelian, 'persenppn', array('class' => 'span1 integer2', 'readonly' => false, 'onkeyup' => "return $(this).focusNextInputField(event)", 'onblur' => 'setPersenPPNTerima(this);hitungTotalFaktur();')) . ' %'; ?>
                        </div>
                        <div class="controls">
                            <?php echo $form->textField($modFakturPembelian, 'totalpajakppn', array('class' => 'span2 integer2', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event)", 'onblur' => 'hitungTotalFaktur()')) ?>
                        </div>
                    </div>
                    <div class="control-group " hidden>
                        <label class='control-label'>
                            <?php //echo CHtml::checkBox('termasukPPH',false,array('onclick'=>'persenPph(this)','disabled'=>TRUE,'style'=>'width : 10px', 'onkeyup'=>"return $(this).focusNextInputField(event)"))
                            ?>
                            Total PPh
                        </label>
                        <div class="controls">
                            <?php echo $form->textField($modFakturPembelian, 'totalpajakpph', array('class' => 'span2 integer2', 'readonly' => false, 'onkeyup' => "return $(this).focusNextInputField(event)", 'onblur' => 'hitungTotalFaktur()')) ?>
                        </div>
                    </div>
                    <?php echo $form->textField($modFakturPembelian, 'biayamaterai', array('class' => 'span2 integer2', 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'display:none;')) ?>
                    <?php echo $form->textFieldRow($modFakturPembelian, 'totalhargabruto', array('class' => 'span3 integer2', 'readonly' => TRUE, 'onkeyup' => "return $(this).focusNextInputField(event)")) ?>
                </div>
            </div>
        </div>
    </div>
</div>