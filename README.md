Facebook Embeds
====================

This extension adds three twig functions with named arguments. Use as many or as few arguments as you like.
The arguments map very closely to facebooks own documented arguments, see the following for more info:

https://developers.facebook.com/docs/plugins/like-button

https://developers.facebook.com/docs/plugins/page-plugin

https://developers.facebook.com/docs/plugins/comments

##Examples:

    {{facebookpage(
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
    
    {{facebooklike(
        url = "https://developers.facebook.com/docs/plugins/",
        width = "100%",
        action = "like",
        faces = true,
        layout = "standard",
        share = false,
        colorscheme = "light"
    )}}
    
    {{facebookcomments(
        url = "http://developers.facebook.com/docs/plugins/comments/",
        posts = 1,
        colorscheme = light,
        orderby = social
    )}}
    
