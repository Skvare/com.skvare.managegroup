<div class="crm-block crm-content-block crm-group-mailinglist-block">
  <div class="crm-submit-buttons">
    <a href="javascript:self.close()" class="button cancel">{ts}Close{/ts}</a>
  </div>

  {if ! $mailingGroups}
    <div class="messages status no-popup">
      <div class="icon inform-icon"></div>
      {ts}No mailings found that use this group.{/ts}
    </div>
  {else}
    <div class="crm-results-block">
      <div class="crm-search-results">
        <table class="selector row-highlight">
          <thead>
            <tr>
              <th class="col sortable">{ts}Mailing Name{/ts}</th>
              <th class="col sortable">{ts}Created Date{/ts}</th>
              <th class="col sortable">{ts}Scheduled Date{/ts}</th>
              <th class="col sortable">{ts}End Date{/ts}</th>
              <th class="col sortable">{ts}Status{/ts}</th>
              <th class="col">{ts}Group Usage{/ts}</th>
            </tr>
          </thead>
          <tbody>
            {foreach from=$mailingGroups item=row}
              {if $row}
                <tr class="{cycle values='odd-row,even-row'}">
                  <td><strong>{$row.name}</strong></td>
                  <td>{$row.created_date|crmDate}</td>
                  <td>{$row.scheduled_date|crmDate}</td>
                  <td>{$row.mailing_job_end_date|crmDate}</td>
                  <td>
                    <span class="crm-status-{$row.mailing_job_status|lower}">
                      {$row.mailing_job_status}
                    </span>
                  </td>
                  <td>
                    <span class="crm-tag crm-tag-{$row.group_type|lower}">
                      {$row.group_type}
                    </span>
                  </td>
                </tr>
              {/if}
            {/foreach}
          </tbody>
        </table>
      </div>
    </div>
  {/if}
</div>
