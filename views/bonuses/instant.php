<? if (!empty($instant)) : ?>
<table>
    <tr>
        <th><?= CHtml::encode('ИД') ?></th>
        <th><?= CHtml::encode('ИД пользователя кому бонус') ?></th>
        <th><?= CHtml::encode('Username') ?></th>
        <th><?= CHtml::encode('ИД пользователя от кого бонус') ?></th>
        <th><?= CHtml::encode('ИД транзакции') ?></th>
        <th><?= CHtml::encode('Сумма с которой нач бонус') ?></th>
        <th><?= CHtml::encode('Сумма бонуса') ?></th>
        <th><?= CHtml::encode('Дата периода') ?></th>
    </tr>
<? foreach($instant as $bonus) : ?>
    <tr>
        <td><?= $bonus->id; ?></td>
        <td><?= $bonus->users__id__to; ?></td>
        <td><?= $bonus->user->username; ?></td>
        <td><?= $bonus->users__id__from; ?></td>
        <td><?= $bonus->transactions__id; ?></td>
        <td><?= $bonus->amount_from; ?></td>
        <td><?= $bonus->amount; ?></td>
        <td><?= $bonus->periode_date; ?></td>
    </tr>
<? endforeach; ?>
</table>
<? else : ?>
<h2>Пусто</h2>
<? endif; ?>