<?php
$jui=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application').
					'/../../yii/framework/web/js/source/jui/js/jquery-ui.min.js');
$tag_it=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.tag').'/tag-it.js');
$tag_it_css=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.tag').'/tag-it.css');
$cs=Yii::app()->clientScript;
$cs->registerScriptFile($jui);
$cs->registerScriptFile($tag_it);
$cs->registerCssFile($tag_it_css);

/*$cs->registerScript($id,'
    $("#'.$id.'").tagit({
        tags: '.$tags.',
        url: "'.$url.'"
    });
', CClientScript::POS_READY);*/

$cs->registerScript($id,'
    $("#'.$id.'").tagit({
        tags: '.$tags.'
    });
', CClientScript::POS_READY);

?>

<label for="<?php echo CHtml::encode($id);?>"><h4>Tags</h4></label>
<ul id="<?php echo CHtml::encode($id);?>">
    <li class="tagit-new">
        <!--input class="tagit-input" type="text" /-->
        <?php
        	echo CHtml::dropDownList("tag_drop_down", "", $data ,array(
				"class" => "tagit-input",));
        ?>
        <button id="tagAddButton" type="button">Add</button>
    </li>
</ul>