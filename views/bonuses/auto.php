<?= CHtml::beginForm() ?>
<?= CHtml::submitButton(Yii::t('app', 'Провести расчеты'), array('name' => 'btn')); ?><br><br>
<?= CHtml::endForm() ?>
<? if (!empty($auto)) : ?>
<table>
    <tr>
        <th><?= CHtml::encode('ИД') ?></th>
        <th><?= CHtml::encode('ИД пользователя кому бонус') ?></th>
        <th><?= CHtml::encode('Username') ?></th>
        <th><?= CHtml::encode('Сумма бонуса') ?></th>
        <th><?= CHtml::encode('Сумма ГО') ?></th>
        <th><?= CHtml::encode('Дата периода') ?></th>
    </tr>
<? foreach($auto as $bonus) : ?>
    <tr>
        <td><?= $bonus->id; ?></td>
        <td><?= $bonus->users__id   ; ?></td>
        <td><?= $bonus->user->username; ?></td>
        <td><?= $bonus->amount; ?></td>
        <td><?= $bonus->amount_from; ?></td>
        <td><?= $bonus->periode_date; ?></td>
    </tr>
<? endforeach; ?>
</table>
<? else : ?>
<h2>Пусто</h2>
<? endif; ?>