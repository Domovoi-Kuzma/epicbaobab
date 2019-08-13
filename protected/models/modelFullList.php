<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 08.08.2019
 * Time: 11:22
 */

/**
 * Class ModelList
 *  отображается на viewList.php
 * (это один вид, модель подкидывает в него различные данные в зависимости от опции employees/meets)
 */
class ModelFullList extends CModel
{
    /**
     * @var array|null должен содержать таблицу из базы(имён людей либо имён встреч)
     * далее отображаемых в главных пунктах списка
     */
    private $names;

    /**
     * @return array|null
     */
    public function NamesList()
    {
        return $this->names;
    }
    /**
     * @var array|null должен содержать массив, индексируемый номерами имён из главн.пунктов,
     *                  возвращающий для каждой строки имени массив подпунктов списка
     * @example buddies[$meeting] string список участников для встречи с номером $meeting
     */
    private $buddies;

    /**
     * @param $who индекс соответствующий имени в массиве names (основного меню)
     * @return список подпунктов
     */
    public function RelativesList($who)
    {
        return $this->buddies[$who];
    }

    private $myNameFieldCaption;

    /**
     * @return string имя столбца в таблице БД, содержащего данные главных пунктов списка
     */
    public function MyField()
    {
        return $this->myNameFieldCaption;
    }
    /**
     * @var string
     */
    private $buddyNameFieldCaption;
    /**
     * @return string имя столбца в таблице БД, содержащего данные подпунктов списка
     */
    public function BuddyField()
    {
        return $this->buddyNameFieldCaption;
    }
    private $dbtable;
    private $buddyNameFieldCaptionEx;
    private $myIDFieldCaptionEx;
    /**
     * ModelList constructor.
     * @param string $title  заголовок, отображаемый на странице ()
     * @param string $what опция отображаемого списка "employees" либо "meets"
     */
    function __construct($what)
    {
        if ($what == 'employees')
        {//параметры для создания списка сотрудников
            $this->dbtable = 'people';
            $this->myNameFieldCaption='Name';
            $this->myIDFieldCaptionEx='p.ID';
            $this->buddyNameFieldCaptionEx = 'm.Meeting';
            $this->buddyNameFieldCaption='Meeting';
        }
        else//if ($what == 'meets')
        {//параметры для создания списка встреч
            $this->dbtable = 'meets';
            $this->myNameFieldCaption='Meeting';
            $this->myIDFieldCaptionEx='m.ID';
            $this->buddyNameFieldCaptionEx = 'p.Name';
            $this->buddyNameFieldCaption='Name';
        }
    }

    /**
     * формирование списка по SQL запросу
     */
    public function QueryNames()
    {
        $sql = "SELECT * FROM $this->dbtable";
        $this->names = Yii::app()->db->createCommand($sql)->queryAll();

        foreach ($this->names as $item)
        {
            $id=$item['ID'];
            $sql = "SELECT $this->buddyNameFieldCaptionEx FROM people p JOIN meets m JOIN relations r ON m.ID=r.MID AND p.ID=r.EID AND $this->myIDFieldCaptionEx=$id";
            $this->buddies[$id] = Yii::app()->db->createCommand($sql)->queryAll();
        }
    }

    /**
     * @return array
     */
    public function attributeNames(){
        return array();
    }
}