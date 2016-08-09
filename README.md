Facebook Embeds
====================

This extension adds four twig functions with named arguments. Use as many or as
few arguments as you like. The first three have arguments that map very closely
to facebooks own documented arguments, see the following for more info:

https://developers.facebook.com/docs/plugins/like-button

https://developers.facebook.com/docs/plugins/page-plugin

https://developers.facebook.com/docs/plugins/comments

##Examples:

    {{facebook_page(
        url = "https://www.facebook.com/facebook"
    )}}
    
    {{facebook_like(
        url = "https://developers.facebook.com/docs/plugins/"
    )}}
    
    {{facebook_comments(
        url = "http://developers.facebook.com/docs/plugins/comments/"
    )}}
    
The final function, `facebook_feed` is a bit different. It fetches info from
facebook via the graph api, and caches it in bolts cache. Since you get the
full data you can layout your widget however you want. See facebooks developer
tools for help in generating an access token, I recommend that you use a app
token since those do not expire. The access_token can also be set in the main
configuration using the key `facebook_access_token` if you do not want it in
your template.
    
    {% set result =  facebook_feed(
        user = "facebook",
        access_token = "dfhjdfhjsdfjkgshdglsdfg|dfgsdfgjklsdfg",
        fields = ['id', 'name', 'link', 'about', 'cover', 'description_html', 'posts.limit(5){link, story, picture, message, created_time}']
    ) %}
    {% if result.error %}
        {{ result.error }}
    {% else %}
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
                    <p>{{post.story|default(post.message)}}</p>
                {% endfor %}
            </div>
        </div>
    {% endif %}
