<style>
    
    .tab_spirometri {
        width: 100%;
        border-collapse: collapse;
        border-radius: 0;
    }
    
    .tab_spirometri th {
        text-align: center;
        font-weight: bold;
    }
    
    .tab_spirometri td, .tab_spirometri th {
        padding: 5px;
    }
    
    .input_spirometri {
        text-align: right;
        width: 70px;
    }
    
    .tab_spirometri tbody tr td:not(:first-child) {
        text-align: center;
    }
    
    .tab_spirometri tr td:nth-child(n+2),
    .tab_spirometri thead tr:first-child > th:nth-child(2) {
        background-color: whitesmoke;
    }
    
    .tab_spirometri thead tr {
        border-bottom: 1px solid gray;
    }
    
    .tab_spirometri tr td:nth-child(n+3),
    .tab_spirometri thead tr:first-child > th:nth-child(n+3),
    .tab_spirometri thead tr:nth-child(2) > th:nth-child(n+2) {
        background-color: #FFA0A2;
    }
    
</style>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Tes Spirometri</div>
    </div>
    <div class="panel-body">
        <table class="tab_spirometri">
            <thead>
                <tr>
                    <th style="text-align: left;"><?php echo $form->checkBox($model, 'pakai_bronkhodilator', array(
                        'id'=>'pakai_bronkhodilator',
                        'onclick'=>'hitungTestSpirometri();'
                    ))." Pakai Bronkhodilator"; ?></th>
                    <th>Prediksi</th>
                    <th>Angka</th>
                    <th>%</th>
                </tr>
            </thead>
            <tbody>
                <tr class="row_svc">
                    <td>Social Vital Capacity (SVC)</td>
                    <td><?php echo $form->textField($model, 'svc_prediksi', array('class'=>'angkacoma-only input_spirometri prediksi')); ?></td>
                    <td><?php echo $form->textField($model, 'svc', array('class'=>'angkacoma-only input_spirometri bro_nilai')); ?></td>
                    <td><?php echo $form->textField($model, 'svc_persen', array('class'=>'angkacoma-only input_spirometri bro_persen', 'readonly'=>true)); ?></td>
                </tr>
                <tr class="row_fvc">
                    <td>Forced Vital Capacity (FVC)</td>
                    <td><?php echo $form->textField($model, 'fvc_prediksi', array('class'=>'angkacoma-only input_spirometri prediksi')); ?></td>
                    <td><?php echo $form->textField($model, 'fvc', array('class'=>'angkacoma-only input_spirometri bro_nilai')); ?></td>
                    <td><?php echo $form->textField($model, 'fvc_persen', array('class'=>'angkacoma-only input_spirometri bro_persen', 'readonly'=>true)); ?></td>
                 </tr>
                <tr class="row_fev1">
                    <td>Forced Expiratory Volume in one second (FEV1)</td>
                    <td><?php echo $form->textField($model, 'fev1_prediksi', array('class'=>'angkacoma-only input_spirometri prediksi')); ?></td>
                    <td><?php echo $form->textField($model, 'fev1', array('class'=>'angkacoma-only input_spirometri bro_nilai')); ?></td>
                    <td><?php echo $form->textField($model, 'fev1_persen', array('class'=>'angkacoma-only input_spirometri bro_persen', 'readonly'=>true)); ?></td>
                </tr>
                <tr class="row_fev1_fvc">
                    <td>FEV1 / FVC</td>
                    <td></td>
                    <td></td>
                    <td><?php echo $form->textField($model, 'fev1_fvc_persen', array('class'=>'angkacoma-only input_spirometri bro_persen', 'readonly'=>true)); ?></td>
                </tr>
                <tr class="row_pfr">
                    <td>Peak Expiratory Flow Rate (PFR)</td>
                    <td><?php echo $form->textField($model, 'pfr_prediksi', array('class'=>'angkacoma-only input_spirometri prediksi')); ?></td>
                    <td><?php echo $form->textField($model, 'pfr', array('class'=>'angkacoma-only input_spirometri bro_nilai')); ?></td>
                    <td><?php echo $form->textField($model, 'pfr_persen', array('class'=>'angkacoma-only input_spirometri bro_persen', 'readonly'=>true)); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>