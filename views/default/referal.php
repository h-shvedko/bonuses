<?=CHtml::hiddenField('assetpath', Yii::app()->createabsoluteUrl(Yii::app()->assetManager->getPublishedUrl(Yii::getPathOfAlias('application.modules.office.js.controllers.default.zclip')) . '/ZeroClipboard.swf'), array('id' => 'assetpath'))?>
<script type="text/javascript" src="<?=Yii::app()->assetManager->getPublishedUrl(Yii::getPathOfAlias('application.modules.office.js.controllers.default.zclip')); ?>/jquery.zclip.js"></script>
<script type="text/javascript" src="<?=Yii::app()->assetManager->getPublishedUrl(Yii::getPathOfAlias('application.modules.office.js.controllers.default.zclip')); ?>/referal.js"></script>

<div style="margin-top: 5px;">
    <div>Ваша реферальная ссылка:</div>
    <?=CHtml::link($referal_link, $referal_link, array('style' => 'font-size: 15px;', 'id' => 'link_referalbutton'));?>&nbsp;&nbsp;&nbsp;
	<?=CHtml::button('', array('class' => 'btnbuffercopy', 'id' => 'referalbutton', 'style' => 'font-size: 14px; display: inline-block;'));?>
    <br />

    <? /*<a href="javascript: void(0)" style="font-size: 12px;" onClick="show_edit_block()" id="show_edit_block_link">Настройки реферальной ссылки</a> */ ?>
    <div id="edit_block" style="margin-top: 15px;">
        <?=CHtml::beginForm()?>
        <table style="width: 430px; margin-bottom: 10px;">
            <tr>
                <td style="width: 135px;">Тип регистрации:</td>
                <td>
                    <?=CHtml::activeRadioButtonList($bonamorStructureSettings, 'referal_register_type', array(
                        '1' => 'Под меня:',
                        '2' => 'Под пользователя:'
                    ), array('class' => 'show-contract-choose-radiobutton'))?>
                    <div id="errorMessage" style="color: red; font-size: 12px;"><?=$bonamorStructureSettings->getError('profile_bonamor__contract_no');?></div>
                </td>
				<td>
					<div id="contract_no_1" class="contract-no-span" style="display: none;"><?=CHtml::textField('username_myself', $_user->username, array('style' => 'width: 80px; float: right;', 'disabled' => 'disabled'))?></div>
					<div id="contract_no_2" class="contract-no-span" style="display: none; margin-top: 0; margin-left: 30px;"><?=CHtml::textField('username_other', !empty($userName) ? $userName : (($bonamorStructureSettings->profile_contract_no != NULL && $bonamorStructureSettings->profile_contract_no->user != NULL) ? $bonamorStructureSettings->profile_contract_no->user->username : ''), array('style' => 'width: 80px; float: left; margin-top: -7px;'))?><?php $this->widget('UserSearchWidget', array('input_login'=>'username_other'))->userSearch(); ?></div>
					
				</td>
            </tr>
            <tr>
                <td>Выбор ноги:</td>
                <td colspan="2"><?=CHtml::activeRadioButtonList($bonamorStructureSettings, 'register_leg', array('1' => 'В левую ногу', '2' => 'В правую ногу'))?></td>
            </tr>
            <tr>
                <td>Тип заполнения:</td>
                <td colspan="2"><?=CHtml::activeRadioButtonList($bonamorStructureSettings, 'register_filltype', array('1' => 'В сильную позицию', '2' => 'В слабую позицию'))?></td>
            </tr>
        </table>
        <div id="save_info" style="color: red; font-size: 12px; display: none;">
            Для того, чтобы изменения вступили в силу, нажминте кнопку "Сохранить"
        </div>
        <?=CHtml::submitButton('Сохранить', array('class' => 'btn100', 'style' => 'display: inline-block; margin-right: 20px;', 'name' => 'btn-save'))?>
        <? /* <a href="javascript: void(0)" style="font-size: 12px; display: inline-block;" onClick="hide_edit_block()">Отмена</a>*/ ?>
        <?=CHtml::endForm()?>
    </div>

</div>