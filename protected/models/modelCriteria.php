<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 19.08.2019
 * Time: 14:32
 */
/**
 * Class ModelCriteria
 * ищет большие встречи, на которой сотрудников больше критерия
 */
class ModelCriteria extends CFormModel{
    public $criteria;
    /**
     * rules
     * Declares the validation rules.
     * заполнено, неотрицательно, числовое.
     */
    public function rules()
    {
        return [
            [['criteria'],  'required', 'message' => 'Введите предельное число участников'],
            [['criteria'],  'numerical', 'message'=>'введите предельное число участников десятичным положительным числом'],
            [['criteria'],  'compare', 'compareValue' => 0,'operator' => '>=', 'message' => 'Введите неотрицательное число - лимит участников'],
        ];
    }
    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'criteria'=>'Вывести встречи с числом участников не меньше',
        );
    }
    public $results;
    public $buddies;
    /**
     * запрашивает в базе список  больших встречи, на которой сотрудников больше критерия
     */
    public function QueryNames()
    {
        /*$criteria=new CDbCriteria;
        $criteria->select='Meeting, m.ID';
        $criteria->join='JOIN relations ON m.ID=MID';
        $criteria->group='MID';
        $criteria->having=*/
        $sql="SELECT Meeting,m.ID FROM meets m JOIN relations ON m.ID=MID GROUP BY MID HAVING COUNT(*)>=$this->criteria";
        $this->results=Yii::app()->db->createCommand($sql)->queryAll();
    }
    public function QueryBuddies()
    {
        foreach($this->results as $MeetingLine)
        {
            $sql="SELECT Name FROM people p JOIN relations ON p.ID=EID AND ".$MeetingLine["ID"]."=MID";
            $this->buddies[$MeetingLine['ID']]=Yii::app()->db->createCommand($sql)->queryAll();
        }
    }
}