<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                Mekanisme Koping
            </div>
        </div>
        <div class="panel-body">
            <table class='form_predispo' style="width: 100%">
                <tr>
                    <td width="10"></td>
                    <td colspan="2">
                        
                        <table style="width: 100%; border: none;">
                            <thead>
                                <tr>
                                    <th width="50%"><label>Adaptif</label></th>
                                    <th><label>Maladaptif</label></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <?php
                                        
                                        echo $form->checkBoxList($model, 'mekanismekoping_adaptif', LookupM::getItemsUrutan('koping_adaptif'), array('uncheckValue'=>null));
                                        echo $form->textField($model, 'mekanismekoping_adaptif_lainnya');
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo $form->checkBoxList($model, 'mekanismekoping_maladaptif', LookupM::getItemsUrutan('koping_maladaptif'), array('uncheckValue'=>null));
                                        echo $form->textField($model, 'mekanismekoping_maladaptif_lainnya');
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                            
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td></td>
                    <td width="200"><label><b>Masalah Keperawatan</b></label></td>
                    <td>
                        <?php echo $form->textArea($model, 'mekanismekoping_masalahkeperawatan'); ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                Pengetahuan Kurang Tentang...
            </div>
        </div>
        <div class="panel-body">
            <div class="col-sm-6">
                <?php 
                
                echo $form->checkBoxList($model, 'pengetahuankurang', PengkajiankeperawatanjiwaT::pengetahuanKurangLabel(), array('uncheckValue'=>null)); ?>
                <?php echo $form->textField($model, 'pengetahuankurang_lainnya'); ?>
            </div>
            <div class="col-sm-6">
                <label><b>Masalah Keperawatan</b></label><br>
                <?php echo $form->textArea($model, 'pengetahuankurang_masalahkeperawatan', array('rows'=>2, 'style'=>'width: 100%')); ?>
            </div>
        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                Aspek Medik
            </div>
        </div>
        <div class="panel-body">
            <table class='form_predispo' style="width: 100%">
                <tr>
                    <td width="10"></td>
                    <td width="200"><label>Diagnosa Medik</label></td>
                    <td><?php echo $form->textArea($model, 'diagnosamedik', array('rows'=>3, 'style'=>'width: 100%')); ?></td>
                </tr>
                <tr>
                    <td width="10"></td>
                    <td width="200"><label>Terapi Medik</label></td>
                    <td><?php echo $form->textArea($model, 'terapimedik', array('rows'=>3, 'style'=>'width: 100%')); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                Masalah Psikososial dan Lingkungan
            </div>
        </div>
        <div class="panel-body">
            <table class='form_predispo' style="width: 100%">
                <?php foreach (PengkajiankeperawatanjiwaT::psikososialLabel() as $idx => $item) : ?>
                <tr>
                    <td width="10"></td>
                    <td>
                        <label><?php echo $item; ?></label><br>
                        <?php echo $form->textArea($model, 'masalahpsikososial['.$idx.']', array('rows'=>2, 'style'=>'width: 100%')); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td width="10"></td>
                    <td>
                        <label><b>Masalah Keperawatan</b></label><br>
                        <?php echo $form->textArea($model, 'masalahpsikososial_masalahkeperawatan', array('rows'=>2, 'style'=>'width: 100%')); ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="clear"></div>