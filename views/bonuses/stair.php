<?= CHtml::beginForm() ?>
<?= CHtml::submitButton(Yii::t('app', 'Провести расчеты'), array('name' => 'btn')); ?><br><br>
<?= CHtml::endForm() ?>

<? if (!empty($stair)) : ?>
<table>
    <tr>
        <th><?= CHtml::encode('ИД') ?></th>
        <th><?= CHtml::encode('ИД пользователя кому бонус') ?></th>
        <th><?= CHtml::encode('Username') ?></th>
        <th><?= CHtml::encode('ИД пользователя от кого бонус') ?></th>
        <th><?= CHtml::encode('Username спонсора') ?></th>
        <th><?= CHtml::encode('Алиас кому') ?></th>
        <th><?= CHtml::encode('Алиас от кого') ?></th>
        <th><?= CHtml::encode('Сумма бонуса') ?></th>
        <th><?= CHtml::encode('Дата периода') ?></th>
    </tr>
<? foreach($stair as $bonus) : ?>
    <tr>
        <td><?= $bonus->id; ?></td>
        <td><?= $bonus->users__id__to; ?></td>
        <td><?= $bonus->user->username; ?></td>
        <td><?= $bonus->users__id__from; ?></td>
        <td><?= $bonus->user_sponsor->username; ?></td>
        <td><?= $bonus->alias__to; ?></td>
        <td><?= $bonus->alias__from; ?></td>
        <td><?= $bonus->amount; ?></td>
        <td><?= $bonus->periode_date; ?></td>
    </tr>
<? endforeach; ?>
</table>
<? else : ?>
<h2>Пусто</h2>
<? endif; ?>