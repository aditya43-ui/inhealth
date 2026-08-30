<?php

class ListUserChat extends CWidget
{
    protected $messages;
    protected $userOnline;
    public $htmlOptions;

    public function init() {
            $criteria = new CDbCriteria;
            $criteria->compare('loginpemakai_aktif', true);
            $criteria->compare('statuslogin', true);
            $criteria->order = 'statuslogin, nama_pemakai ASC';
            $this->userOnline = LoginpemakaiK::model()->findAll($criteria);
    }
    
    public function run() {
        echo CHtml::openTag('ul', $this->htmlOptions);
        $this->renderItems($this->userOnline);
        echo '</ul>';
    }
    
    /**
     * Renders the items in this menu.
     * @param array $items the menu items
     */
    public function renderItems($userOnline)
    {
        $this->render('listUserChat/list',array('userOnline'=>$userOnline));
    }
}
?>
