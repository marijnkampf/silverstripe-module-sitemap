<% if SMShowPageThumbnail %><% if SMThumbnail %><a class="smthumb" href="$Page.AbsoluteLink" title="Go to the '$Page.Title' page">$SMThumbnail.SetWidth(150)</a><% end_if %><% end_if %>
<% if SMShowPageName %><h3><a href="$Page.AbsoluteLink" title="Go to the '$Page.Title' page">$Page.Title</a></h3><% end_if %>
<% if SMShowMetaTitle %><div><a href="$Page.AbsoluteLink" title="Go to the '$Page.Title' page">$Page.MetaTitle</a></div><% end_if %>
<% if SMShowMetaDescription %><div>$Page.MetaDescription</div><% end_if %>