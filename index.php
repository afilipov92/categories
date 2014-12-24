<?php
error_reporting(E_ALL);

function __autoload($className) {
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . $className . '.php';
}

$templ = new Template();
$db = new DB();
$ob = new FormData();


$page = Template::getTemplate('page');
$templ->setHtml(Template::getTemplate('form'));
$selectTpl = Template::getTemplate('option_for_select');
$buttonDel = Template::getTemplate('button_del');
$buttonEdit = Template::getTemplate('button_edit');
$listCatTpl = Template::getTemplate('list_cat');

$msg = "";
$list = "";
$listCat = $db->getCategories();

if($id = FormCategory::isGetID()){
    $arr = $db->requestSelect($id);
} else{
    $arr = array('id' => "", 'title' => "", 'id_parent' => "");
}

FormCategory::setFormData($ob, $arr);
if(FormCategory::isFormSubmitted() == true){
	$id = FormCategory::isPostID();
	if(FormCategory::isDel()){
        $db->requestDel($id);
        header('Location: '.$_SERVER['REQUEST_URI']);
        die;
	} else if(FormCategory::isEdit()){
        header("Location: ".$_SERVER['PHP_SELF']."?id=$id");
        die;
	}
    else{
        $validateFormResult = FormCategory::isFormVaild($ob);
        if($validateFormResult!== true) {
            $templ->setHtml($templ->processTemplateErrorOutput($validateFormResult));
        } else {
            if($ob->id != ""){
                $query = "UPDATE categories SET id_parent=:id_parent, title=:title WHERE id='$ob->id'";
            } else{
                $query = "INSERT INTO categories (id_parent, title) VALUES (:id_parent, :title)";
            }
            if($db->saveCat($ob, $query)){
                header('Location: '.$_SERVER['PHP_SELF']);
                die;
            } else {
                $msg = 'Ошибка сохранения';
            }
        }
    }
}

$select = '<option selected value>--</option>';
if($listCat){
    $select .= Categories::getCtaegoriesForForm($db->getCategories(), $selectTpl, $ob->id_parent);
}


$templ->setHtml(Template::processTemplace($templ->getHtml(), array (
    'id' => $ob->id,
    'title' => $ob->title, 
    'id_parent' => $select
)));

if($listCat){
    $cat = new Categories($listCat);
    $cat->toStringListTopics($listCatTpl);
	$list = Template::processTemplace($cat->getListTopics(), array(
        'DEL' => $buttonDel,
        'EDIT' => $buttonEdit
    ));
}

$page = Template::processTemplace($page, array(
    'MSG' => $msg,
    'FORM' => $templ->getHtml(),
    'LIST' => $list
));
echo $page;

