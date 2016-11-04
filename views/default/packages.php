<div>
    <table>
        <th><?= Yii::t('app', 'ID');?></th>
        <th><?= Yii::t('app', 'Название пакета');?></th>
        <th><?= Yii::t('app', 'Стоимость пакета');?></th>
        <th><?= Yii::t('app', 'Выбор пакета');?></th>
        <? foreach ($packages as $pack) : ?>
        <tr>
            <td><?= CHtml::label($pack->id, 'id'); ?></td>
            <td><?= CHtml::label($pack->lang->name, 'name'); ?></td>
            <td><?= CHtml::label(ProfileBonuses::model()->getValueOfPackage($pack->id), 'price'); ?></td>
            <?= CHtml::beginForm() ?>
            <td>
                <?= CHtml::activeHiddenField($pack, 'id')?>
                <?= CHtml::activeHiddenField($pack, 'price')?>
                <?php echo CHtml::submitButton('Оплатить', array('name' => 'btn_buy')); ?>
            </td>
            <?= CHtml::endForm() ?>
        </tr>
        <? endforeach; ?>
    </table>
    <br>
</div>