<?php
/**
 * Created by PhpStorm.
 */
/**
 * Class SiteController
 *
 */
class SiteController extends Controller
{
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('index');
    }
    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error=Yii::app()->errorHandler->error){
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
    /**
     * Вывод списка сотрудников
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionEmployees()
    {
        $this->render('viewEmployees',array('employees'=>People::model()->findAll()));
    }
    /**
     * Вывод списка встреч
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionMeeting()
    {
        $this->render('viewMeetings',array('meetings'=>Meets::model()->findAll()));
    }

    /**
     * Вывод формы добавления или само добавление сотрудника
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionInsertEmployee()
    {
        $newman=new People();
        if (isset($_POST['ID'])){
            $newman->saveAs();
            $this->redirect($this->createUrl('employees'));
        }
        else{
            $this->render('viewInsertEmployeeForm',
                [
                    'model'     =>$newman,
                    'action'    =>$this->createUrl('insertEmployee'),
                    'optionsM'  =>Meets::model()->findAll(),
                    'optionsD'  =>Department::model()->findAll(),
                ]);
        }
    }

    /**
     * Вывод формы добавления или само добавление встречи
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionInsertMeeting()
    {
        $newmeet=new Meets();
        if (isset($_POST['ID'])) {
            $newmeet->saveAs();
            $this->redirect($this->createUrl('site/meeting'));
        }
        else {
            $this->render('viewInsertMeetingForm', [
                'model'     =>$newmeet,
                'action'    =>$this->createUrl('insertMeeting'),
                'optionsP'  =>People::model()->findAll(),
                'optionsR'  =>Room::model()->findAll(),
            ]);
        }
    }
    public function getLikeStatus($meeting_id)
    {
        Yii::trace("getLikeStatus ID: $meeting_id ", 'system.web.CController');
        $record = Meets::model()->findByPk($meeting_id);
        if (is_null($record)) {
            Yii::trace("getLikeStatus returned error <record is null>", 'system.web.CController');
            return ['icon' => 'error_button_icon', 'tooltip' => 'error'];
        }
        $tooltip = "";
        $icon = 'like_button_icon';
        foreach($record->liked_by as $lover) {
            if ($lover->user_id == Yii::app()->user->id) {
                $icon='dislike_button_icon';
            } else {
                $tooltip.= $lover->user->username." ";
            }
        }
        if (!empty($tooltip)) $tooltip="also liked by ".$tooltip;
        Yii::trace("getLikeStatus returned icon<$icon>, tooltip<$tooltip>", 'system.web.CController');
        return ['icon'=>$icon, 'tooltip'=>$tooltip];
    }
    /**
     * AJAX script called when meeting, liked by user
     * @param integer $id ключ лайкнутой встречи.
     */
    public function actionToggleLike($meeting_id)
    {
        Yii::trace("actionToggleLike ID: $meeting_id ", 'system.web.CController');
        $criteria=new CDbCriteria();
        $criteria->addCondition('user_id=:user_crit');
        $criteria->addCondition('meet_id=:meet_crit');
        $criteria->params=array(':user_crit'=>Yii::app()->user->id, ':meet_crit'=>$meeting_id);
        $result=Like::model()->find($criteria);
        if (is_null($result)) {
            //insert users like here
            $model = new Like;
            $model->user_id = Yii::app()->user->id;
            $model->meet_id = $meeting_id;
            $model->save();
            $retarray=$this->getLikeStatus($meeting_id);
            Yii::trace("actionToggleLike ID: $meeting_id returning1:".$retarray['icon'].'@'.$retarray['tooltip'], 'system.web.CController');
            echo $retarray['icon'].'@'.$retarray['tooltip'];
        }
        else {
            $result->delete();
            $retarray=$this->getLikeStatus($meeting_id);
            Yii::trace("actionToggleLike ID: $meeting_id returning2:".$retarray['icon'].'@'.$retarray['tooltip'], 'system.web.CController');
            echo $retarray['icon'].'@'.$retarray['tooltip'];
        }
    }
    /**
     * Удаление записи
     * @param integer $id ключ сотрудника.
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionDeleteEmployee($id)
    {
        $record=People::model()->findByPk($id);
        if (is_null($record))
            throw new CHttpException(404,"Записи сотрудника с ключом $id нет в базе");
        $record->delete();
        $this->redirect($this->createUrl('site/employees'));
    }

    /**
     * Удаление встречи из базы
     * @param integer $id ключ встречи.
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionDeleteMeeting($id)
    {
        $record=Meets::model()->findByPk($id);
        if (is_null($record))
            throw new CHttpException(404,"Записи встречи с ключом $id нет в базе");
        $record->delete();
        $this->redirect($this->createUrl('site/meeting'));
    }

    /**
     * Редактирование записи сотрудника
     * @param integer $id ключ записи в БД
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionEditEmployee($id)
    {
        if (isset($_POST['ID'])){
            $record=People::model()->findByPk(intval($_POST['ID']));

            if (is_null($record))
                throw new CHttpException(404,"Записи сотрудника с ключом $id нет в базе");
            $record->saveAs();

            $this->redirect($this->createUrl('site/employees'));
        }
        else {
            $record=People::model()->findByPk($id);
            if (is_null($record))
                throw new CHttpException(404,"Записи сотрудника с ключом $id нет в базе");

            $this->render('viewInsertEmployeeForm',
                [
                    'model'     =>  $record,
                    'action'    =>$this->createUrl('editEmployee', ['id'=>$id]),
                    'optionsM'  =>Meets::model()->findAll(),
                    'optionsD'  =>Department::model()->findAll(),
                ]);
        }
    }
    /**
     *  Редактирование записи встречи.
     * @param integer $id ключ в таблице встреч
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionEditMeeting($id)
    {

        if (isset($_POST['ID'])) {
            $id=intval($_POST['ID']);
            $record=Meets::model()->findByPk($id);
            if (is_null($record))
                throw new CHttpException(404,"Записи встречи с ключом $id нет в базе");
            $record->saveAs();
            $this->redirect($this->createUrl('site/meeting'));
        }
        else {
            $record=Meets::model()->findByPk($id);
            if (is_null($record))
                throw new CHttpException(404,"Записи встречи с ключом $id нет в базе");
            $this->render('viewInsertMeetingForm',
                [
                    'model'     =>  $record,
                    'action'    =>  $this->createUrl('editMeeting', ['id'=>$id]),
                    'optionsP'=>People::model()->findAll(),
                    'optionsR'=>Room::model()->findAll(),
                ]);
        }
    }
    /**
     * Действие для страницы 'поиск больших встреч'
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionMemberCountForm()
    {
        if (isset($_POST['count'])) {
            $count=intval($_POST['count']);
            $meetingList = Meets::getAllByMemberCount($count);
            $this->render('viewMemberCountForm', array('meetingList' => $meetingList));
        }
        else
            $this->render('viewMemberCountForm', array());
    }

    /**
     * Позволяет выбрать комнату и выводит список событий в ней
     * с параметром all выводит список всех комнат
     * @param  string $id ключ комнаты базе
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionRoomExplore($id)
    {
        if ($id!='all' ) {
            $model=Room::model()->findByPk($id);
            if (is_null($model))
                throw new CHttpException(404, "Записи комнаты с ключом $id нет в базе");
            $this->render('viewRoomTree',array('model'=>$model,));
        }
        else{
            $this->render('viewRoomList',array('items'=>Room::model()->findAll(),));
        }
    }

    /**
     * Удаляет комнату
     * @param  integer $id ключ комнаты базе
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionRoomDelete($id)
    {
        if (isset($id)) {
            $model = Room::model()->findByPk($id);
            if (is_null($model))
                throw new CHttpException(404, "Записи комнаты с ключом $id нет в базе");
            $model->delete();
            $this->redirect($this->createUrl('roomExplore/all'));
        }
        else {
            throw new CHttpException(404, "неверный формат адреса");
        }
    }
    /**
     * Добавление новой записи комнаты в базу
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionInsertRoom()
    {
        $newrum = new Room();
        if (isset($_POST['ID'])) {
            $newrum->saveAs();
            $this->redirect($this->createUrl('site/roomExplore/all'));
        }
        else {
            $this->render('viewRoomForm',
                [
                    'model' => $newrum,
                    'action' => 'insertRoom',
                ]);
        }
    }
    /**
     * Редактирование записи комнаты
     * @param integer $id ключ записи в БД
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionEditRoom($id)
    {
        if (isset($_POST['ID'])) {
            $newrum=Room::model()->findByPk(intval($_POST['ID']));
            if (is_null($newrum))
                throw new CHttpException(404, "Записи комнаты с ключом $id нет в базе");
            $newrum->SaveAs();
            $this->redirect($this->createUrl('site/roomExplore/all'));
        }
        else {
            $newrum=Room::model()->findByPk($id);
            if (is_null($newrum))
                throw new CHttpException(404, "Записи комнаты с ключом $id нет в базе");
            $this->render('viewRoomForm',
                [
                    'model' => $newrum,
                    'action' => 'editRoom',
                ]);
        }
    }
    /**
     * Позволяет выбрать отдел и выводит список сотрудников в нём
     * с параметром all выводит список всех отделов
     * @param  string $id ключ отдела в базе
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionDeptExplore($id)
    {
        if ($id!='all' ) {
            $model=Department::model()->findByPk($id);
            if (is_null($model))
                throw new CHttpException(404, "Записи отдела с ключом $id нет в базе");
            $this->render('viewDepartmentTree',array('model'=>$model,));
        }
        else{
            $this->render('viewDepartmentList',array('items'=>Department::model()->findAll(),));
        }
    }

    /**
     * Удаляет отдел
     * @param  integer $id ключ отдела базе
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionDeptDelete($id)
    {
        if (isset($id)) {
            $model = Department::model()->findByPk($id);
            if (is_null($model))
                throw new CHttpException(404, "Записи отдела с ключом $id нет в базе");
            $model->delete();
            $this->redirect($this->createUrl('site/deptExplore/all'));
        }
        else
            throw new CHttpException(404, "неверный формат адреса");
    }


    /**
     * Добавление новой записи отдела в базу
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionInsertDepartment()
    {
        $newdept = new Department();
        if (isset($_POST['ID'])) {
            $newdept->saveAs();
            $this->redirect($this->createUrl('site/deptExplore/all'));
        } else {
            $this->render('viewDepartmentForm',
                [
                    'model' => $newdept,
                    'action' => 'insertDepartment',
                ]);
        }
    }

    /**
     * Редактирование записи отдела
     * @param integer $id ключ записи в БД
     * @author  Sasha
     * @data    21.08.2019
     */
    public function actionEditDepartment($id)
    {
        if (isset($_POST['ID'])) {
            $newdept=Department::model()->findByPk(intval($_POST['ID']));
            if (is_null($newdept))
                throw new CHttpException(404, "Ошибка! Не найден отдел с ключём $id");
            $newdept->SaveAs();
            $this->redirect($this->createUrl('site/deptExplore/all'));
        }
        else {
            $newdept=Department::model()->findByPk($id);
            if (is_null($newdept))
                throw new CHttpException(404, "Ошибка! Не найден отдел с ключём $id");
            $this->render('viewDepartmentForm',
                [
                    'model' => $newdept,
                    'action' => 'editDepartment',
                ]);
        }
    }
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * задаёт ограничения на посещение страниц категориям пользователей
     * @return array
     */
    public function accessRules()
    {
        return array(
           /* array('allow',
                'actions' => array('Index', 'Login'),
                'users'=>array('*'),
            ),*/
            array('allow',
                'actions' => array('employees', 'meeting', 'memberCountForm', 'roomExplore', 'deptExplore'),
                'users'=>array('admin', 'signed'),
            ),
            array('deny',
                'actions' => array('employees', 'meeting', 'memberCountForm', 'roomExplore', 'deptExplore'),
                'users'=>array('guest'),
            ),
        );
    }

}