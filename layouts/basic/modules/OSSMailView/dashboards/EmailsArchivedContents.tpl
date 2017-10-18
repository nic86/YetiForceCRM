{*<!-- {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} --!>*}
{strip}
	{if count($EMAILS) > 0}
	    <div class="row no-margin">
		<div class="col-sm-12">
		{if $PAGING_MODEL->getCurrentPage() eq 1}
			<div class="row">
			<div class="col-xs-2">
				<h6><b>{vtranslate('Subject' ,$MODULE_NAME)}</b></h6>
			</div>
			<div class="col-xs-2">
				<h6><b>{vtranslate('From' ,$MODULE_NAME)}</b></h6>
			</div>
			<div class="col-xs-2">
				<h6><b>{vtranslate('To' ,$MODULE_NAME)}</b></h6>
			</div>
            <div class="col-xs-2">
				<h6><b>{vtranslate('Date' ,$MODULE_NAME)}</b></h6>
			</div>
            <div class="col-xs-2">
				<h6><b>Azione</b></h6>
			</div>

			<div class="col-xs-12"><hr></div>
			{/if}
            </div>
			<div class="row">
			{foreach from=$EMAILS key=RECORD_ID item=EMAIL_MODEL}
				<div class="col-xs-12 paddingLRZero">
					<div class="col-xs-2">
							{$EMAIL_MODEL['subject']}
					</div>
					<div class="col-xs-2">
						{$EMAIL_MODEL['from_email']}
                	</div>
                    <div class="col-xs-2">
						{$EMAIL_MODEL['to_email']}
                	</div>
					<div class="col-xs-2">
						<span title="{$EMAIL_MODEL['date']}">
							{Vtiger_Util_Helper::formatDateDiffInStrings($EMAIL_MODEL['date'])}
						</span>
					</div>
                    <div class="col-xs-2">
                        <div class ="row">
                            <input type="hidden" value="" id="tempField{$EMAIL_MODEL['crmid']}" name="tempField{$EMAIL_MODEL['crmid']}"/>
                            <select class="btn btn-xs btn-default" id="tempSelect{$EMAIL_MODEL['crmid']}" name="tempSelect{$EMAIL_MODEL['crmid']}">
                                {foreach item="ITEM" from=$LINKS}
                                    <option value="{$ITEM->get('modulename')}">
                                        {vtranslate($ITEM->get('modulename'), $MODULE_NAME)}
                                    </option>
                                {/foreach}
                            </select>
                        </div>
                        <div class ="row">
                            <div class ="col-xs-4">
                                <a class="btn btn-xs btn-default pull-left" style='vertical-align: middle;' onclick="OSSMailView_Widget_Js.selectRecord('{$RECORD_ID}');"><span class='glyphicon glyphicon-search'  style='vertical-align: middle;' border='0' title="Relaziona" alt="Relaziona"></span></a>
                            </div>
                            <div class ="col-xs-4">
                                <a class="btn btn-xs btn-default pull-left" style='vertical-align: middle;' target="_blank" href="index.php?module=OSSMailView&view=Detail&record={$RECORD_ID}"><span class='glyphicon glyphicon-link'  style='vertical-align: middle;' border='0' title="Apri" alt="Apri"></span></a>
                            </div>
                            <div class ="col-xs-4">
                                <a class="btn btn-xs btn-default pull-left" style='vertical-align: middle;' onclick="OSSMailView_Widget_Js.setHasRelated('{$RECORD_ID}');"><span class='glyphicon glyphicon-ok'  style='vertical-align: middle;' border='0' title="Salta" alt="Salta"></span></a>
                            </div>
                        </div>
					</div>
				</div>
			{/foreach}
            </div>
		{if count($EMAILS) eq $PAGING_MODEL->getPageLimit()}
			<div class="pull-right padding5">
				<button type="button" class="btn btn-xs btn-primary showMoreHistory" data-url="{$WIDGET->getUrl()}&page={$PAGING_MODEL->getNextPage()}">{vtranslate('LBL_MORE', $MODULE_NAME)}</button>
			</div>
		{/if}
	{else}
		{if $PAGING_MODEL->getCurrentPage() eq 1}
			<span class="noDataMsg">
				{vtranslate('LBL_NO_RECORDS_MATCHED_THIS_CRITERIA')}
			</span>
		{/if}
	{/if}
    </div>
    </div>
{/strip}
