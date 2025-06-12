<?php
use yii\helpers\Html;
use yii\web\View;

$this->registerCss("
#group-container {
    width: 100%;
    max-width: 800px;
    min-height: 400px;
    border: 2px solid #ccc;
    margin: 20px auto;
    padding: 10px;
    position: relative;
    overflow: auto;
}
.group-item {
    font-size: 30px;
    text-transform: uppercase;
    cursor: move;
    margin: 5px 0;
}
");

$this->registerJsFile('https://code.jquery.com/ui/1.13.0/jquery-ui.min.js', [
    'depends' => [\yii\web\JqueryAsset::class],
]);
$this->registerJs("
    $('.group-item').draggable({
        containment: '#group-container'
    });
", View::POS_READY);

$groups = \app\models\Group::getHierarchy();
?>

<div id="group-container">
<?php if (Yii::$app->user->can('ManageGroups')): ?>
    <?php 
    $render = function(array $groups, int $depth = 0) use (&$render) {
        foreach ($groups as $g) {
            $ml = $depth * 30;
            echo Html::tag('div', Html::encode($g['name']), [
                'class' => 'group-item',
                'style' => "margin-left:{$ml}px;",
            ]);
            if (!empty($g['children'])) {
                $render($g['children'], $depth + 1);
            }
        }
    };
    $render($groups);
    ?>
<?php endif; ?>
</div>
