<? if (!empty($gifts)) : ?>
<table>
    <tr>
        <th><?= CHtml::encode('ИД') ?></th>
        <th><?= CHtml::encode('ИД пользователя кому бонус') ?></th>
        <th><?= CHtml::encode('Username') ?></th>
        <th><?= CHtml::encode('Процент') ?></th>
        <th><?= CHtml::encode('ИД транзакции') ?></th>
        <th><?= CHtml::encode('Сумма бонуса') ?></th>
        <th><?= CHtml::encode('Дата периода') ?></th>
    </tr>
<? foreach($gifts as $bonus) : ?>
    <tr>
        <td><?= $bonus->id; ?></td>
        <td><?= $bonus->users__id; ?></td>
        <td><?= $bonus->user->username; ?></td>
        <td><?= $bonus->persents; ?></td>
        <td><?= $bonus->transactions__id; ?></td>
        <td><?= $bonus->amount; ?></td>
        <td><?= $bonus->periode_date; ?></td>
    </tr>
<? endforeach; ?>
</table>
<? else : ?>
<h2>Пусто</h2>
<? endif; ?>