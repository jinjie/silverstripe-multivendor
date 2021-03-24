<% if $Result.MoreThanOnePage %>
<nav aria-label="Pagination navigation">
    <ul class="pagination justify-content-center">
        <% if $Result.NotFirstPage %>
            <li class="page-item">
                <a href="{$Result.PrevLink}" class="page-link">&lt;</a>
            </li>
        <% end_if %>
        <% loop $Result.Pages %>
            <li class="page-item <% if $CurrentBool %>active<% end_if %>">
                <a href="{$Link}" class="page-link">{$PageNum}</a>
            </li>
        <% end_loop %>
        <% if $Result.NotLastPage %>
            <li class="page-item">
                <a href="{$Result.NextLink}" class="page-link">&gt;</a>
            </li>
        <% end_if %>
    </ul>
</nav>
<% end_if %>
