Facebook Embeds
====================

This extension adds four twig functions with named arguments. Use as many or as
few arguments as you like. The first three have arguments that map very closely
to facebooks own documented arguments, see the following for more info:

https://developers.facebook.com/docs/plugins/like-button

https://developers.facebook.com/docs/plugins/page-plugin

https://developers.facebook.com/docs/plugins/comments

##Examples:

    {{facebookPage(
        url = "https://www.facebook.com/facebook",
        height = 500,
        small = true,
        cover = true,
        faces = false,
        posts = true,
        responsive = true,
        cta = false,
        showlink = false
    )}}
    
    {{facebookLike(
        url = "https://developers.facebook.com/docs/plugins/",
        width = "100%",
        action = "like",
        faces = true,
        layout = "standard",
        share = false,
        colorscheme = "light"
    )}}
    
    {{facebookComments(
        url = "http://developers.facebook.com/docs/plugins/comments/",
        posts = 1,
        colorscheme = light,
        orderby = social
    )}}
    
The final function, `facebookfeed` is a bit different. It fetches info from
facebook via the graph api, and caches it in bolts cache. Since you get the
full data you can layout your widget however you want. See facebooks developer
tools for help in generating an access token, I recommend that you use a app
token since those do not expire. The access_token can also be set in the main
configuration using the key `facebook_access_token` if you do not want it in
your template.
    
    {% set result =  facebookfeed(
        user = "facebook",
        access_token = "dfhjdfhjsdfjkgshdglsdfg|dfgsdfgjklsdfg",
        fields = ['id', 'name', 'link', 'about', 'cover', 'description_html', 'posts.limit(5){link, story, picture, message, created_time}']
    ) %}
    <div class="fbWidget">
        <div class="fbHeader" style="background-image:url({{result.cover.source}})">
            <h2><a href="{{result.link}}">{{result.name}}</a></h2>
            <p>{{result.about}}</p>
        </div>
        <div class="fbPosts">
            {% for post in result.posts.data %}
                <a href="{{post.link}}">
                    <img src="{{post.picture}}"/>
                </a>
                <p>{{post.story}}</p>
            {% endfor %}
        </div>
    </div>
