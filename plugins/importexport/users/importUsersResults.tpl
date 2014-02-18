{**
 * plugins/importexport/users/importUsersResults.tpl
 *
 * Copyright (c) 2014 Simon Fraser University Library
 * Copyright (c) 2003-2014 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Show the results of importing users.
 *
 *}
{strip}
{assign var="pageTitle" value="plugins.importexport.users.import.importUsers"}
{include file="common/header.tpl"}
{/strip}
<div id="importUsersResults">
{translate key="plugins.importexport.users.import.usersWereImported"}:
<table class="listing">
	<tr>
		<td colspan="4" class="headseparator">&nbsp;</td>
	</tr>
	<tr class="heading" valign="bottom">
		<td>{translate key="user.username"}</td>
		<td>{translate key="user.name"}</td>
		<td>{translate key="user.email"}</td>
		<td align="right">{translate key="common.action"}</td>
	</tr>
	<tr>
		<td colspan="4" class="headseparator">&nbsp;</td>
	</tr>
	{foreach name=importedUsers from=$importedUsers item=user}
	<tr>
		<td><a href="{url page="manager" op="userProfile" path=$user->getId()}">{$user->getUsername()|escape}</a></td>
		<td>{$user->getFullName()|escape}</td>
		<td>{$user->getEmail()|escape}</td>
		<td align="right" class="nowrap">
			<a href="{url page="manager" op="editUser" path=$user->getId()}" class="action">{translate key="common.edit"}</a>&nbsp;|&nbsp;<a href="{url page="login" op="signInAsUser" path=$user->getId()}" class="action">{translate key="manager.people.signInAs"}</a>
		</td>
	</tr>
	<tr>
		<td colspan="4" class="{if $smarty.foreach.importedUsers.last}end{/if}separator">&nbsp;</td>
	</tr>
	{foreachelse}
	<tr>
		<td colspan="4" class="nodata">{translate key="manager.people.noneEnrolled"}</td>
	</tr>
	<tr>
		<td colspan="4" class="endseparator">&nbsp;</td>
	</tr>
{/foreach}
</table>

{if $isError}
<p>
	<span class="formError">{translate key="plugins.importexport.users.import.errorsOccurred"}:</span>
	<ul class="formErrorList">
	{foreach key=field item=message from=$errors}
		<li>{$message}</li>
	{/foreach}
	</ul>
</p>
{/if}

<p>&#187; <a href="{url page="manager"}">{translate key="manager.journalManagement"}</a></p>
</div>
{include file="common/footer.tpl"}
