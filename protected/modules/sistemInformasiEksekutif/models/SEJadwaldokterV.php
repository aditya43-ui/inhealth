<?php


class SEJadwaldokterV extends JadwaldokterV {
    public function searchDashboardJadwal() {
        $cr = new CDbCriteria;
        $cr->addBetweenCondition('jadwaldokter_tgl::date', date('Y-m-d'), date('Y-m-d', strtotime('+30 days')));
        $cr->order = 'jadwaldokter_tgl, jadwaldokter_mulai';
        
        return new CActiveDataProvider($this, array(
            'criteria'=>$cr,
            //'pagination'=>false,
        ));
    }
public function searchDashboardJadwal7hari() {
    $cr = new CDbCriteria;
		$cr->compare('t.jadwaldokter_hari',$this->jadwaldokter_hari);
        // $cr->compare('t.jadwaldokter_hari', 'KAMIS');
            // $cr->compare('DATE(jadwaldokter_tgl)', date('Y-m-d'));
            // $cr->addBetweenCondition('jadwaldokter_tgl::date', date('Y-m-d'), date('Y-m-d', strtotime('+7 days')));
    $cr->order = 'jadwaldokter_tgl, jadwaldokter_mulai';
    
    return new CActiveDataProvider($this, array(
        'criteria'=>$cr,
        //'pagination'=>false,
    ));
}
}
