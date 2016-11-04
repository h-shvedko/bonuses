<h3 class="h1-office" style="margin: 0;"><?= Yii::t('app', 'Логин') ?>, <?= $_user['username'] ?></h3>
<h3 class="h1-office" style="margin: 0;"><?= Yii::t('app', 'Ваша реферальная ссылка') ?>: <a href="http://<?= $_user['username'] ?>.<?=$_SERVER['SERVER_NAME']?>"><?= $_user['username'] ?>.<?=$_SERVER['SERVER_NAME']?></a></h3>
<? if ($userPV == FALSE) : ?>
<h3 class="h1-office" style="margin: 0;"><?= Yii::t('app', 'ЛО: 0') ?></h3>
<? else : ?>
<h3 class="h1-office" style="margin: 0;"><?= Yii::t('app', 'ЛО: ') ?><?= $userPV ?></h3>
<? endif; ?>

<? if ($userGO == FALSE) : ?>
<h3 class="h1-office" style="margin: 0;"><?= Yii::t('app', 'ГО текущего: 0') ?></h3>
<? else : ?>
<h3 class="h1-office" style="margin: 0;"><?= Yii::t('app', 'ГО текущего: ') ?><?= $userGO ?></h3>
<? endif; ?>

<? if ($userGOprev == FALSE) : ?>
<h3 class="h1-office" style="margin: 0;"><?= Yii::t('app', 'ГО предыдущего: 0') ?></h3>
<? else : ?>
<h3 class="h1-office" style="margin: 0;"><?= Yii::t('app', 'ГО предыдущего: ') ?><?= $userGOprev ?></h3>
<? endif; ?>

<? if ($userAGV == FALSE) : ?>
<h3 class="h1-office" style="margin: 0;"><?= Yii::t('app', 'НГО: 0') ?></h3>
<? else : ?>
<h3 class="h1-office" style="margin: 0;"><?= Yii::t('app', 'НГО: ') ?><?= $userAGV ?></h3>
<? endif; ?>

<? if ($userVPG == FALSE) : ?>
<h3 class="h1-office" style="margin: 0;"><?= Yii::t('app', 'ОЛГ: 0') ?></h3>
<? else : ?>
<h3 class="h1-office" style="margin: 0;"><?= Yii::t('app', 'ОЛГ: ') ?><?= $userVPG ?></h3>
<? endif; ?>

<h3 class="h1-office" style="margin: 0;"><?= Yii::t('app', 'БО: ') ?><?= Yii::t('app', $userBO) ?></h3>
<h3 class="h1-office" style="margin: 0;"><?= Yii::t('app', 'ранг: ') ?><?= Yii::t('app', $userRank) ?></h3>
<? if (!empty($activity->date_end)) : ?>
<h3 class="h1-office" style="margin: 0;"><?= Yii::t('app', 'Ваша активность до: ') ?><?= Yii::t('app', $activity->date_end) ?></h3>
<? else : ?>
<h3 class="h1-office" style="margin: 0;"><?= Yii::t('app', 'Ваша активность до: ') ?></h3>
<? endif; ?>

<table style="font-size: 18px; margin: 20px;">
	<tr>
		<td>
			<?=Yii::t('app','Линейный бонус')?>
		</td>
		<td>
			<? if (!empty($linearBonuses)) : ?>
			<?=CHtml::encode($linearBonuses->amount)?>
			<? else : ?>
			<?= Yii::t('app', '0') ?>
			<? endif; ?>
		</td>
	</tr>
	<tr>
		<td>
			<?=Yii::t('app','Мгновенный бонус')?>
		</td>
		<td>
			<? if (!empty($instantBonuses)) : ?>
			<?=CHtml::encode($instantBonuses->amount)?>
			<? else : ?>
			<?= Yii::t('app', '0') ?>
			<? endif; ?>
		</td>
	</tr>
</table>


<?= CHtml::beginForm() ?>
<?= CHtml::link(Yii::t('app', 'Оплатить регистрационный пакет'), '/office/default/packages'); ?><br><br>
<?= CHtml::link(Yii::t('app', 'Перейти в магазин'), '/store/'); ?><br><br>
<?= CHtml::link(Yii::t('app', 'Перейти в корзину'), '/store/order'); ?>
<?= CHtml::endForm() ?>
<bR>
<bR>
<bR>
<div>
    <?= CHtml::link(Yii::t('app', 'Страница бонусов'), '/office/default/bonusesprint') ?>
</div>