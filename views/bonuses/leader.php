<?= CHtml::beginForm() ?>
<?= CHtml::submitButton(Yii::t('app', 'Провести расчеты'), array('name' => 'btn')); ?><br><br>
<?= CHtml::endForm() ?>

<? if (!empty($leader)) : ?>
<table>
    <tr>
        <th><?= CHtml::encode('ИД') ?></th>
        <th><?= CHtml::encode('ИД пользователя кому бонус') ?></th>
        <th><?= CHtml::encode('Username') ?></th>
        <th><?= CHtml::encode('Процент бонуса') ?></th>
        <th><?= CHtml::encode('Сумма бонуса') ?></th>
        <th><?= CHtml::encode('Алиас') ?></th>
        <th><?= CHtml::encode('Алиас диретора') ?></th>
        <th><?= CHtml::encode('Дата периода') ?></th>
    </tr>
    <? foreach($leader as $bonus) : ?>
    <tr>
        <td><?= $bonus->id; ?></td>
        <td><?= $bonus->users__id__to; ?></td>
        <td><?= $bonus->user->username; ?></td>
        <td><?= $bonus->persent; ?></td>
        <td><?= $bonus->amount; ?></td>
        <td><?= $bonus->alias; ?></td>
        <td><?= $bonus->director_alias; ?></td>
        <td><?= $bonus->periode_date; ?></td>
    </tr>
    <? endforeach; ?>
</table>
<? else : ?>
<h2>Пусто</h2>
<? endif; ?>