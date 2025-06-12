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
    position: absolute;
    min-width: 120px;
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

function renderGroupsWithPosition($groups, $depth = 0, &$top = 20, $leftStart = 20) {
    $left = $leftStart + $depth * 60;
    foreach ($groups as $g) {
        echo Html::tag('div', Html::encode($g['name']), [
            'class' => 'group-item',
            'style' => "left: {$left}px; top: {$top}px;",
        ]);
        $myTop = $top;
        $top += 60;
        if (!empty($g['children'])) {
            $childTop = $myTop + 40;
            renderGroupsWithPosition($g['children'], $depth + 1, $childTop, $leftStart);
            if ($childTop > $top) {
                $top = $childTop;
            }
        }
    }
}
?>

<div id="group-container">
<?php if (Yii::$app->user->can('ManageGroups')): ?>
    <?php
    $startTop = 20;
    renderGroupsWithPosition($groups, 0, $startTop);
    ?>
<?php endif; ?>
</div>
