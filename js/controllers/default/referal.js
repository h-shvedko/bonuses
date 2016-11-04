function show_edit_block ()
{
    $('a#show_edit_block_link').hide();
    $('div#edit_block').show();
}

function hide_edit_block ()
{
    $('div#edit_block').hide();
    $('a#show_edit_block_link').show();
}

function show_contract_choose()
{
    $('div.contract-no-span').hide();
    $('div#contract_no_' + this.value).show();
}

function show_info()
{
    $('div#save_info').show();
    $('div#errorMessage').hide();
}

$(function(){

    if ($('div#errorMessage').html() != '')
    {
        show_edit_block ();
    }

    $('input.show-contract-choose-radiobutton').bind('change', show_contract_choose);

    $('div.contract-no-span').hide();

    $.each($('input.show-contract-choose-radiobutton'), function(){
        if (this.checked)
        {
            $('div#contract_no_' + this.value).show();
			$('div#contract_no_' + this.value).css('display', 'flex');
        }
    });

    $('input#username_other').bind('change', show_info);

    $('input[type="radio"]').bind('change', show_info);

});
