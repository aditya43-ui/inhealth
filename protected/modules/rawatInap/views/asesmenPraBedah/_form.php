

 <div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Data Umum
        </div>
    </div>
    <div class="panel-body">
        <?php
            $this->renderPartial('rawatInap.views.asesmenPraBedah/form/_1_dataAwal',['model'=>$model, 'form'=>$form]);

            $this->renderPartial('rawatInap.views.asesmenPraBedah/form/_2_dataFisikAnamnesa',['model'=>$model, 'form'=>$form]);
            
            $this->renderPartial('rawatInap.views.asesmenPraBedah/form/_3_dataNyeri',['model'=>$model, 'form'=>$form]);
            
            $this->renderPartial('rawatInap.views.asesmenPraBedah/form/_4_dataPerokok',['model'=>$model, 'form'=>$form]);
        ?>
    </div>
 </div>

 <div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Pemeriksaan Fisik
        </div>
    </div>
    <div class="panel-body">
        <?php
            $this->renderPartial('rawatInap.views.asesmenPraBedah/form/_5_dataPemeriksaanFisik',['model'=>$model, 'form'=>$form]);
        ?>
    </div>
 </div>

 <div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Diagnosis dan Rencana Tindakan
        </div>
    </div>
    <div class="panel-body">
        <?php
            $this->renderPartial('rawatInap.views.asesmenPraBedah/form/_6_dataDiagnosisRencanaTindakan',['model'=>$model, 'form'=>$form]);
        ?>
    </div>
 </div>

 <div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
             Rencana Pasca Pembedahan
        </div>
    </div>
    <div class="panel-body">
        <?php
            $this->renderPartial('rawatInap.views.asesmenPraBedah/form/_7_dataRencanaPascaBedah',['model'=>$model, 'form'=>$form]);
        ?>
    </div>
 </div>