<? if (!empty($binar)) : ?>
<table>
    <tr>
        <th><?= CHtml::encode('ИД') ?></th>
        <th><?= CHtml::encode('ИД пользователя в бинаре') ?></th>
        <th><?= CHtml::encode('Username') ?></th>
        <th><?= CHtml::encode('ИД пользователя кто осуществил продление активности') ?></th>
        <th><?= CHtml::encode('Username') ?></th>
        <th><?= CHtml::encode('Дата начала') ?></th>
        <th><?= CHtml::encode('Дата конца') ?></th>
    </tr>
<? foreach($binar as $bonus) : ?>
    <tr>
        <td><?= $bonus->id; ?></td>
        <td><?= $bonus->user__id; ?></td>
        <td><?= $bonus->user->username; ?></td>
        <td><?= $bonus->created_by; ?></td>
        <td><?= $bonus->sponsor->username; ?></td>
        <td><?= $bonus->date_begin; ?></td>
        <td><?= $bonus->date_end; ?></td>
    </tr>
<? endforeach; ?>
</table>
<? else : ?>
<h2>Пусто</h2>
<? endif; ?>