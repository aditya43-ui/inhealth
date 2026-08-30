<div style="padding:10px;">
    <table class="table table-bordered table-condesed table-striped">
        <tr>
            <th style="text-align:center;">CPIS Point</th>
            <th style="text-align:center;">Nilai</th>
            <th style="text-align:center;">Skor</th>            
        </tr>
        <?php                   
            foreach($model->setLoadCpisPoint as $k => $v){
                $this->renderPartial('form/row/_barisCpisPoint',['model'=>$v, 'i'=>$k]);
            }
        ?>
    </table>
</div>

<div class="col-sm-6">
    <?= $form->textAreaRow($modDet, 'hasil_vap',['rows'=>7]) ?>
</div>


<div class="col-sm-6">
    <?= ($this->action->id == 'detail')?$form->textAreaRow($modDet, 'hasil_kultur',['rows'=>7, 'class'=>'open-field']):'' ?>
</div>