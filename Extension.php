<?php

namespace Bolt\Extension\sahassar\facebookembeds;

use Bolt\Extensions\Snippets\Location as SnippetLocation;

class Extension extends \Bolt\BaseExtension
{
    public function getName()
    {
        return "Facebook Embeds";
    }

    public function initialize()
    {
        if ($this->app['config']->getWhichEnd()=='frontend') {
            $this->addSnippet('endofbody', 'facebookScript');
            $this->addTwigFunction('facebookLike', 'facebookLike', array('is_variadic' => true));
            $this->addTwigFunction('facebookComments', 'facebookComments', array('is_variadic' => true));
            $this->addTwigFunction('facebookPage', 'facebookPage', array('is_variadic' => true));
        }
    }

    public function facebookScript()
    {

        $language = $this->app['config']->get('general/locale');

        $html = <<< EOM
        <div id="fb-root"></div>
        <script>if(!!(document.getElementsByClassName("fb-like").length || document.getElementsByClassName("fb-comments").length || document.getElementsByClassName("fb-page").length)){(function (d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/$language/all.js#xfbml=1";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'))}</script>
EOM;
        return $html;
    }
    
    function facebookPage(array $args = array())
    {
        $defaults = array(
              'url' => $this->app['paths']['canonicalurl'],
              'height' => 500,
              'small' => false,
              'cover' => true,
              'faces' => true,
              'posts' => true,
              'cta' => true,
              'responsive' => true,
              'showlink' => false,
        );
        $args = array_merge($defaults, $args);
        $html = <<< EOM

<div class="fb-page" data-href="%url%" data-height="%height%" data-hide-cta="%cta%" data-small-header="%small%" data-adapt-container-width="%responsive%" data-hide-cover="%cover%" data-show-facepile="%faces%" data-show-posts="%posts%">
    <div class="fb-xfbml-parse-ignore" %showlink%>
        <blockquote cite="%url%">
            <a href="%url%">%url%</a>
        </blockquote>
    </div>
</div>
EOM;
        $html = str_replace("%url%", $args['url'], $html);
        $html = str_replace("%height%", $args['height'], $html);
        $html = str_replace("%small%", ($args['small'] ? 'true' : 'false'), $html);
        $html = str_replace("%posts%", ($args['posts'] ? 'true' : 'false'), $html);
        $html = str_replace("%cover%", ($args['cover'] ? 'false' : 'true'), $html);
        $html = str_replace("%faces%", ($args['faces'] ? 'true' : 'false'), $html);
        $html = str_replace("%cta%", ($args['cta'] ? 'false' : 'true'), $html);
        $html = str_replace("%responsive%", ($args['responsive'] ? 'true' : 'false'), $html);
        $html = str_replace("%showlink%", ($args['showlink'] ? '' : 'style="opacity:0;"'), $html);

        return new \Twig_Markup($html, 'UTF-8');
    }
    
    function facebookComments(array $args = array())
    {
        $defaults = array(
              'url' => $this->app['paths']['canonicalurl'],
              'width' => "100%",
              'posts' => 10,
              'colorscheme' => "light",
              'orderby' => "social",
        );
        $args = array_merge($defaults, $args);
        $html = <<< EOM
<div class="fb-comments" data-width="%width%" data-order-by="%orderby%" data-colorscheme="%colorscheme%" data-href="%url%" data-numposts="%posts%"></div>
EOM;
        $html = str_replace("%url%", $args['url'], $html);
        $html = str_replace("%width%", $args['width'], $html);
        $html = str_replace("%posts%", $args['posts'], $html);
        $html = str_replace("%colorscheme%", $args['colorscheme'], $html);
        $html = str_replace("%orderby%", $args['orderby'], $html);

        return new \Twig_Markup($html, 'UTF-8');
    }
    
    function facebookLike(array $args = array())
    {
        $defaults = array(
              'url' => $this->app['paths']['canonicalurl'],
              'width' => "100%",
              'action' => "like",
              'faces' => true,
              'layout' => "standard",
              'share' => false,
              'colorscheme' => "light",
        );
        $args = array_merge($defaults, $args);
        $html = <<< EOM
    <div class="fb-like" data-href="%url%" data-layout="%layout%" data-width="%width%"
    data-show-faces="%faces%" data-action="%action%" data-share="%share%" data-colorscheme="%colorscheme%"></div>
EOM;
        $html = str_replace("%url%", $args['url'], $html);
        $html = str_replace("%width%", $args['width'], $html);
        $html = str_replace("%action%", $args['action'], $html);
        $html = str_replace("%layout%", $args['layout'], $html);
        $html = str_replace("%faces%", ($args['faces'] ? 'true' : 'false'), $html);
        $html = str_replace("%share%", ($args['share'] ? 'true' : 'false'), $html);
        $html = str_replace("%colorscheme%", $args['colorscheme'], $html);

        return new \Twig_Markup($html, 'UTF-8');
    }
}
