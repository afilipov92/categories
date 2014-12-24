<?php

class FormCategory{

    /**
     * проверяет была ли отправлена форма
     * @return bool
     */
    public  static function isFormSubmitted(){
        return (isset($_POST) AND !empty($_POST));
    }

    /**
     * проверяет была ли нажата кнопка del
     * @return bool
     */
    public static function isDel(){
        return (isset($_POST['del']));
    }

    /**
     * проверяет была ли нажата кнопка edit
     * @return bool
     */
    public static function isEdit(){
        return (isset($_POST['edit']));
	}

    /**
     * проверяет был ли отправле id методом get
     * @return bool
     */
    public static function isGetID(){
        return isset($_GET['id'])? $_GET['id']: false;
    }

    /**
     * проверяет был ли отправле id методом post
     * @return bool
     */
    public static function isPostID(){
        return isset($_POST['id'])? $_POST['id']: false;
	}

    /**
     * устанавливает значения массива из формы
     * @param FormData $ob
     * @param array $arr
     */
    public static function setFormData(FormData $ob, array $arr){
        $ob->id = isset($_POST['id'])? $_POST['id']: $arr['id'];
        $ob->title = isset($_POST['title'])? trim($_POST['title']): $arr['title'];
        $ob->id_parent = isset($_POST['id_parent'])? trim($_POST['id_parent']): $arr['id_parent'];
    }

    /**
     * проверяет валидность формы
     * @param FormData $ob
     * @return array|bool
     */
    public static function isFormVaild(FormData $ob){
        $resp = true;
        $errors = array();

        if(strlen($ob->title) < 4){
            $resp = false;
            $errors['title'] = 'Название темы должно быть от 4 cимволов';
        }
        if(!$resp){
            return $errors;
        } else {
            return $resp;
        }
    }
}