<?php

/* admin/show.twig */
class __TwigTemplate_2a5c6dbf0060649cabecef186a5708d27f7c673be833080e43f6fc8478ffaf1d extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.twig", "admin/show.twig", 1);
        $this->blocks = array(
            'js' => array($this, 'block_js'),
            'navbar' => array($this, 'block_navbar'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_js($context, array $blocks = array())
    {
        // line 4
        echo "  <script src=\"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "basepath", array()), "html", null, true);
        echo "/js/app.js\"></script>
  <script src=\"";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "basepath", array()), "html", null, true);
        echo "/js/vendor/velocity.min.js\"></script>
  <script src=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "basepath", array()), "html", null, true);
        echo "/js/vendor/velocity.ui.js\"></script>
";
    }

    // line 9
    public function block_navbar($context, array $blocks = array())
    {
        // line 10
        $this->loadTemplate("admin/partials/controls.twig", "admin/show.twig", 10)->display($context);
    }

    // line 13
    public function block_content($context, array $blocks = array())
    {
        // line 14
        echo "
    <!-- Begin page content -->
    <div class=\"container\" id=\"container\">
      <h1>Couldn't make AJAX request :(</h1><br>
      <h3>Check connection status, browser JavaScript connection</h3>
    </div> <!-- /container -->


";
    }

    public function getTemplateName()
    {
        return "admin/show.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  58 => 14,  55 => 13,  51 => 10,  48 => 9,  42 => 6,  38 => 5,  33 => 4,  30 => 3,  11 => 1,);
    }
}
/* {% extends "layout.twig" %}*/
/* */
/* {% block js %}*/
/*   <script src="{{ app.request.basepath }}/js/app.js"></script>*/
/*   <script src="{{ app.request.basepath }}/js/vendor/velocity.min.js"></script>*/
/*   <script src="{{ app.request.basepath }}/js/vendor/velocity.ui.js"></script>*/
/* {% endblock %}*/
/* */
/* {% block navbar %}*/
/* {% include "admin/partials/controls.twig" %}*/
/* {% endblock %}*/
/* */
/* {% block content %}*/
/* */
/*     <!-- Begin page content -->*/
/*     <div class="container" id="container">*/
/*       <h1>Couldn't make AJAX request :(</h1><br>*/
/*       <h3>Check connection status, browser JavaScript connection</h3>*/
/*     </div> <!-- /container -->*/
/* */
/* */
/* {% endblock %}*/
/* */
