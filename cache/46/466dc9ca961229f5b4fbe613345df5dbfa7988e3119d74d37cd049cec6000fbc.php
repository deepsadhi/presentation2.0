<?php

/* admin/admin.twig */
class __TwigTemplate_74ceced4b947fc913070244310007b972b05b46946b9075696ff3379172a1c7b extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.twig", "admin/admin.twig", 1);
        $this->blocks = array(
            'navbar' => array($this, 'block_navbar'),
            'content' => array($this, 'block_content'),
            'js' => array($this, 'block_js'),
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
    public function block_navbar($context, array $blocks = array())
    {
        // line 4
        $this->loadTemplate("admin/partials/navbar.twig", "admin/admin.twig", 4)->display($context);
    }

    // line 7
    public function block_content($context, array $blocks = array())
    {
        // line 8
        echo "
    <!-- Begin page content -->
    <div class=\"container\">

      ";
        // line 12
        $this->loadTemplate("admin/alert/flash.twig", "admin/admin.twig", 12)->display($context);
        // line 13
        echo "
      <div class=\"row\">
        <div class=\"alert alert-info\">
          <p>Markdown file with regex '/^[a-zA-Z0-9_]*./ only listed.</p>
        </div>
      </div>

      ";
        // line 20
        $this->loadTemplate("admin/index/presentation.twig", "admin/admin.twig", 20)->display($context);
        // line 21
        echo "
    </div> <!-- /container -->

    ";
        // line 24
        $this->loadTemplate("admin/alert/dialogbox.twig", "admin/admin.twig", 24)->display($context);
        // line 25
        echo "

";
    }

    // line 29
    public function block_js($context, array $blocks = array())
    {
        // line 30
        echo "    <script src=\"/js/app.js\"></script>
";
    }

    public function getTemplateName()
    {
        return "admin/admin.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  75 => 30,  72 => 29,  66 => 25,  64 => 24,  59 => 21,  57 => 20,  48 => 13,  46 => 12,  40 => 8,  37 => 7,  33 => 4,  30 => 3,  11 => 1,);
    }
}
/* {% extends "layout.twig" %}*/
/* */
/* {% block navbar %}*/
/* {% include "admin/partials/navbar.twig" %}*/
/* {% endblock %}*/
/* */
/* {% block content %}*/
/* */
/*     <!-- Begin page content -->*/
/*     <div class="container">*/
/* */
/*       {% include "admin/alert/flash.twig" %}*/
/* */
/*       <div class="row">*/
/*         <div class="alert alert-info">*/
/*           <p>Markdown file with regex '/^[a-zA-Z0-9_]*./ only listed.</p>*/
/*         </div>*/
/*       </div>*/
/* */
/*       {% include "admin/index/presentation.twig" %}*/
/* */
/*     </div> <!-- /container -->*/
/* */
/*     {% include "admin/alert/dialogbox.twig" %}*/
/* */
/* */
/* {% endblock %}*/
/* */
/* {% block js %}*/
/*     <script src="/js/app.js"></script>*/
/* {% endblock %}*/
/* */
