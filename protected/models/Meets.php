<?php

/**
 * This is the model class for table "meets".
 *
 * The followings are the available columns in table 'meets':
 * @property integer $ID
 * @property string $Meeting
 * @property integer $Place
 *
 * The followings are the available model relations:
 * @property Room $place
 * @property Relations[] $relations
 */
class Meets extends CActiveRecord
{
    /**
     * Сохраняет параметры $_POST в модель и в БД
     * @return  boolean успешность сохранения
     * @author  Sasha
     * @data    21.08.2019
     */
    public function saveAs()
    {
        $this->Meeting = $_POST['NameInput'];
        $this->Place=intval($_POST['room']);
        if (isset($_POST['options']))
            $this->related_people=$_POST['options'];
        else
            $this->related_people=[];
        return $this->save();
    }
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'meets';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('Place', 'required'),
            array('Place', 'numerical', 'integerOnly'=>true),
            array('Meeting', 'length', 'max'=>255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('ID, Meeting, Place', 'safe', 'on'=>'search'),
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
            'related_people'=>array(self::MANY_MANY, 'People', 'relations(MID, EID)'),
            'room' => array(self::BELONGS_TO, 'Room', 'Place'),
            'liked_by' => array(self::HAS_MANY, 'Like', 'meet_id'),
            'memberCount' => array(self::STAT, 'People', 'relations(MID, EID)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ID' => 'ID',
            'Meeting' => 'Meeting',
            'Place' => 'Place',
        );
    }

    /**
     * Возвращает массив встреч,
     * с числом участников не меньше $count
     * @return array массив моделей встреч
     * @param  $count заданный пользователем минимум участников
     * @author  Sasha
     * @data    21.08.2019
     */
    public static function getAllByMemberCount($count)
    {
        $criteria=new CDbCriteria;
        $criteria->select='Meeting,m.ID';
        $criteria->alias = 'm';
        $criteria->join='JOIN relations  ON m.id=MID';
        $criteria->group='MID';
        $criteria->having='COUNT(*)>='.$count;

        return  Meets::model()->findAll($criteria);;
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

        $criteria=new CDbCriteria;

        $criteria->compare('ID',$this->ID);
        $criteria->compare('Meeting',$this->Meeting,true);
        $criteria->compare('Place',$this->Place);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Meets the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    /**
     * @return an array of behavior configurations that this model should behave as.
     */
    public function behaviors()
    {
        return array(
            'CAdvancedArBehavior' => array(
            'class' => 'application.extensions.CAdvancedArBehavior')
        );
    }
    /**
     * Обрывает все отношения с другими таблицами перед удалением записи
     * @return boolean whether the Meets record should be deleted.
     * @author  Sasha
     * @data    28.08.2019
     */
    public function beforeDelete()
    {
        $this->related_people=[];
        $this->save();
        return parent::beforeDelete();
    }
}
