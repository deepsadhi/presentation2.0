<?php

/* home.twig */
class __TwigTemplate_089eed550a7d6a935ac4eaec39998a989483ca423e7c5ad680b3d37622167d3f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.twig", "home.twig", 1);
        $this->blocks = array(
            'js' => array($this, 'block_js'),
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
        echo "/js/script.js\"></script>
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
    public function block_content($context, array $blocks = array())
    {
        // line 10
        echo "
    <span class=\"label label-success pull-right\" id=\"broadcast\">On-line</span>
    <a href=\"javascript:window.location.reload()\" class=\"btn btn-primary btn-xs pull-right\" id=\"reconnect\">Reconnect</a>

    <!-- Begin page content -->
    <div class=\"container\" id=\"container\">
      <h1>Could not establish Web Socket connection :(</h1><br>
      <h3>Try reloading the page.</h3>
      <h3>Or ask your presenter to troubleshoot.</h3>
    </div> <!-- /container -->

";
    }

    public function getTemplateName()
    {
        return "home.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  50 => 10,  47 => 9,  41 => 6,  37 => 5,  32 => 4,  29 => 3,  11 => 1,);
    }
}
/* {% extends "layout.twig" %}*/
/* */
/* {% block js %}*/
/*   <script src="{{ app.request.basepath }}/js/script.js"></script>*/
/*   <script src="{{ app.request.basepath }}/js/vendor/velocity.min.js"></script>*/
/*   <script src="{{ app.request.basepath }}/js/vendor/velocity.ui.js"></script>*/
/* {% endblock %}*/
/* */
/* {% block content %}*/
/* */
/*     <span class="label label-success pull-right" id="broadcast">On-line</span>*/
/*     <a href="javascript:window.location.reload()" class="btn btn-primary btn-xs pull-right" id="reconnect">Reconnect</a>*/
/* */
/*     <!-- Begin page content -->*/
/*     <div class="container" id="container">*/
/*       <h1>Could not establish Web Socket connection :(</h1><br>*/
/*       <h3>Try reloading the page.</h3>*/
/*       <h3>Or ask your presenter to troubleshoot.</h3>*/
/*     </div> <!-- /container -->*/
/* */
/* {% endblock %}*/
/* */
