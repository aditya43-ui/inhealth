<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class BoxPengumuman extends CWidget
{
    protected $pengumumans;
    
    public function init() {
        $criteria = new CDbCriteria;
        $criteria->order = 'pengumuman_id DESC';
        $this->pengumumans = Pengumuman::model()->published()->with('userCreate')->findAll($criteria);
    }
    
    public function run() {        
        
        $this->render('boxPengumuman/box', array('pengumumans'=>$this->pengumumans));
    }
}
?>
