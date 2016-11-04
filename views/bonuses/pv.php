<h3>Личный объем</h3>
<? if (!empty($binar)) : ?>
<table style="text-align: center;">
    <tr>
        <th><?= CHtml::encode('ИД') ?></th>
        <th><?= CHtml::encode('ИД пользователя') ?></th>
        <th><?= CHtml::encode('Логин') ?></th>
        <th><?= CHtml::encode('Сумма') ?></th>
    </tr>
<? foreach($binar as $bonus) : ?>
    <tr>
        <td><?= $bonus->id; ?></td>
        <td><?= $bonus->users__id; ?></td>
        <td><?= $bonus->user->username; ?></td>
        <td><?= $bonus->value; ?></td>
        
    </tr>
<? endforeach; ?>
</table>
<? else : ?>
<h2>Пусто</h2>
<? endif; ?>