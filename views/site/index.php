<?php
use yii\helpers\Html;
use yii\web\View;

$this->title = 'Csoportok kezelés';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Üdvözöllek, <?= Html::encode(Yii::$app->user->identity->username) ?>!</h1>
        <p class="lead">Itt láthatod a csoportok hierarchiáját.</p>
    </div>

    <?php if (Yii::$app->user->can('ManageGroups')): ?>
        <?php
            echo Html::tag('div', null, [
                'id' => 'group-container',
            ]);

            $groupsData = json_encode($groups);
            $this->registerJs(<<<JS
                function render(groups, parent) {
                    groups.forEach(function(g) {
                        var div = document.createElement('div');
                        div.className = 'group-item';
                        div.innerText = g.name;
                        parent.appendChild(div);
                        $(div).draggable({ containment: "#group-container" });
                        if (g.children && g.children.length) {
                            render(g.children, parent);
                        }
                    });
                }
                $(function(){
                    var data = $groupsData;
                    var container = document.getElementById('group-container');
                    render(data, container);
                });
            JS
            , View::POS_END);
        ?>
    <?php else: ?>
        <p>Nincs jogosultságod csoportok kezelésére.</p>
    <?php endif; ?>

</div>
