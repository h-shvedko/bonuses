<h3>Товарооборот склада</h3>
<? if (!empty($volume)) : ?>
<table class="table table-hover" style="text-align: center;">
    <tr>
        <th><?= CHtml::encode('ИД склада') ?></th>
        <th><?= CHtml::encode('Название склада') ?></th>
        <th><?= CHtml::encode('Товарооборот за текущий период') ?></th>
    </tr>
<? foreach($volume as $bonus) : ?>
    <tr>
        <td><?= $bonus['model']->id; ?></td>
        <td><?= $bonus['model']->lang->name; ?></td>
        <td><?= $bonus['value']; ?></td>
    </tr>
<? endforeach; ?>
</table>
<? else : ?>
<h2>Пусто</h2>
<? endif; ?>