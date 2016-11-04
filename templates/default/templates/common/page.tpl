{if $ShowBodyOnly eq 1}{* include ONLY $tplFile (body) file *}
{include file=$tplFile}
{else}{* include header/body/footer files *}
{if $session->id > 0}{if $session->is_admin == 1}{include file="common/header_main_website.tpl"}{else}{include file="common/header_main_website.tpl"}{/if}
{else}{include file="common/header_main_website.tpl"}{/if}
{* does the user have permission to view this page? *}
{if ($user->session->access_denied)}{include file='common/denied.tpl'}
{else}
{include file=$tplFile}{/if}
{include file="common/footer.tpl"}
{/if}