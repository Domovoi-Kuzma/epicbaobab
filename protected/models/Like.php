<?php

/**
 * This is the model class for table "like".
 *
 * The followings are the available columns in table 'like':
 * @property integer $ID
 * @property integer $user_id
 * @property integer $meet_id
 *
 * The followings are the available model relations:
 * @property Meets $meet
 * @property User $user
 */
class Like extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'like';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, meet_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID, user_id, meet_id', 'safe', 'on'=>'search'),
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
			'meet' => array(self::BELONGS_TO, 'Meets', 'meet_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'user_id' => 'User',
			'meet_id' => 'Meet',
		);
	}

    /**
     * получение списка лайков к встрече $MID в виде массива + статус лайкнутости текущим юзером
     * @param  MID ключ встречи, которую проверяют
     * @return array
     * @author  Sasha
     * @data    04.09.2019
     */
    public static function getLikeStatus($MID)
    {
        Yii::trace("Like::getLikeStatus ID: ".$MID, 'system.web.CController');

        //таск1 посчитать все лайки
        $criteria=new CDbCriteria();
        $criteria->addCondition('meet_id=:meet_crit');
        $criteria->params=array(':meet_crit'=>$MID);
        $count=Like::model()->count($criteria);//

        //таск2 получить имена всех лайкнувших
        $criteria=new CDbCriteria();
        $criteria->addCondition('meet_id=:meet_crit');
        $criteria->addCondition('user_id!=:user_crit');
        $criteria->params=array(':meet_crit'=>$MID, ':user_crit'=>Yii::app()->user->id);
        $co_likers=Like::model()->findAll($criteria);

        //таск3 узнать, лайкнул ли юзер
        $criteria=new CDbCriteria();
        $criteria->addCondition('user_id=:user_crit');
        $criteria->addCondition('meet_id=:meet_crit');
        $criteria->params=array(':meet_crit'=>$MID, ':user_crit'=>Yii::app()->user->id);
        $currentlike=Like::model()->find($criteria);

        return ['current'=>$currentlike, 'tooltip'=>$co_likers, 'count'=>$count];
    }

    /**
     * переворот лайка (если есть - удаление, если нет - добавление)
     * @param MID ключ модели в базе
     * @author  Sasha
     * @data    04.09.2019
     */
    public static function Toggle($MID)
    {
        Yii::trace("Like::Toggle ID: ".$MID, 'system.web.CController');
        $criteria=new CDbCriteria();
        $criteria->addCondition('user_id=:user_crit');
        $criteria->addCondition('meet_id=:meet_crit');
        $criteria->params=array(':user_crit'=>Yii::app()->user->id, ':meet_crit'=>$MID);
        $result=Like::model()->find($criteria);
        if (is_null($result)) {
            $model = new Like;
            $model->user_id = Yii::app()->user->id;
            $model->meet_id = $MID;
            $model->save();
        } else {
            $result->delete();
        }
    }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('ID',$this->ID);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('meet_id',$this->meet_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Like the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
