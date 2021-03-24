<div class="container">
    <article>
        <h1>{$Title}</h1>

        <a href="{$Link(add)}" class="btn btn-primary">Add new listing</a>

        <% if $Listings %>
            <div class="multivendor-listings-list row">
                <% loop $PaginatedListings %>
                    <div class="multivendor-listings-list-item col-6 col-md-4">
                        <a href="{$Top.Link(edit)}/{$ID}">
                            {$FeaturedImage.Fill(200, 200)}
                        </a>

                        <h2><a href="{$Top.Link(edit)}/{$ID}">{$Title}</a></h2>

                        <p>Price: {$Price.Nice}</p>
                    </div>
                <% end_loop %>
            </div>

            <% include SwiftDevLabs/MultiVendor/Includes/Pagination Result=$PaginatedListings %>
        <% end_if %>
    </article>
</div>
