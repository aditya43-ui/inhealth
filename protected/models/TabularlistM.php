<?php

/**
 * This is the model class for table "tabularlist_m".
 *
 * The followings are the available columns in table 'tabularlist_m':
 * @property integer $tabularlist_id
 * @property string $tabularlist_chapter
 * @property string $tabularlist_block
 * @property string $tabularlist_title
 * @property string $tabularlist_revisi
 * @property string $tabularlist_versi
 * @property boolean $tabularlist_aktif
 */
class TabularlistM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TabularlistM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tabularlist_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tabularlist_chapter, tabularlist_block', 'required'),
			array('tabularlist_chapter, tabularlist_block, tabularlist_revisi, tabularlist_versi', 'length', 'max'=>50),
			array('tabularlist_title, tabularlist_title2, tabularlist_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tabularlist_id, tabularlist_chapter, tabularlist_block, tabularlist_title, tabularlist_revisi, tabularlist_versi, tabularlist_aktif, tabularlist_title2', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tabularlist_id' => 'ID',
			'tabularlist_chapter' => 'Chapter',
			'tabularlist_block' => 'Block',
			'tabularlist_title' => 'Title',
                        'tabularlist_title2' => 'Judul',
			'tabularlist_revisi' => 'Revisi',
			'tabularlist_versi' => 'Versi',
			'tabularlist_aktif' => 'Aktif',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('tabularlist_id',$this->tabularlist_id);
		$criteria->compare('LOWER(tabularlist_chapter)',strtolower($this->tabularlist_chapter),true);
		$criteria->compare('LOWER(tabularlist_block)',strtolower($this->tabularlist_block),true);
		$criteria->compare('LOWER(tabularlist_title)',strtolower($this->tabularlist_title),true);
		$criteria->compare('LOWER(tabularlist_revisi)',strtolower($this->tabularlist_revisi),true);
		$criteria->compare('LOWER(tabularlist_versi)',strtolower($this->tabularlist_versi),true);
		$criteria->compare('tabularlist_aktif',isset($this->tabularlist_aktif)?$this->tabularlist_aktif:true);
                $criteria->order = "tabularlist_id ASC";
//                $criteria->addCondition('tabularlist_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('tabularlist_id',$this->tabularlist_id);
		$criteria->compare('LOWER(tabularlist_chapter)',strtolower($this->tabularlist_chapter),true);
		$criteria->compare('LOWER(tabularlist_block)',strtolower($this->tabularlist_block),true);
		$criteria->compare('LOWER(tabularlist_title)',strtolower($this->tabularlist_title),true);
		$criteria->compare('LOWER(tabularlist_revisi)',strtolower($this->tabularlist_revisi),true);
		$criteria->compare('LOWER(tabularlist_versi)',strtolower($this->tabularlist_versi),true);
                $criteria->compare('tabularlist_aktif',isset($this->tabularlist_aktif)?$this->tabularlist_aktif:true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}