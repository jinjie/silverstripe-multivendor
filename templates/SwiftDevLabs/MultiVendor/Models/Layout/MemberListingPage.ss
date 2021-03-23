<div class="content-container size3of4 unit lastUnit">
    <article>
        <h1>{$Title}</h1>

        <a href="{$Link(add)}">Add new listing</a>

        <% if $Listings %>
            <div class="multivendor-listings-list">
                <% loop PaginatedListings %>
                    <div class="multivendor-listings-list-item">
                        <a href="{$Top.Link(edit)}/{$ID}">
                            {$FeaturedImage.Fill(200, 200)}
                        </a>

                        <h2><a href="{$Top.Link(edit)}/{$ID}">{$Title}</a></h2>

                        <p>Price: {$Price.Nice}</p>
                    </div>
                <% end_loop %>
            </div>
        <% end_if %>
    </article>
</div>
