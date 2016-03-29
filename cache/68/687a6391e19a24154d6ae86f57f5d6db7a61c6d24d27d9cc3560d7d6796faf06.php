<?php

/* admin/login.twig */
class __TwigTemplate_ea9557cad9d4bcea9abe0d859c77ea79a58c2a986c7ceb9dba8ec49fc2503d54 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.twig", "admin/login.twig", 1);
        $this->blocks = array(
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
    public function block_navbar($context, array $blocks = array())
    {
        // line 4
        echo "
    <!-- Fixed navbar -->
    <nav class=\"navbar navbar-default navbar-fixed-top\">
      <div class=\"container\">
        <div class=\"navbar-header\">
          <a class=\"navbar-brand\" href=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('slim')->pathFor("login"), "html", null, true);
        echo "\">Presentation 2.0</a>
        </div>
      </div>
    </nav>

";
    }

    // line 16
    public function block_content($context, array $blocks = array())
    {
        // line 17
        echo "
    <!-- Begin page content -->
    <div class=\"container\">
        <div class=\"col-lg-6 col-md-offset-3\">


          <form class=\"form-horizontal\" action=\"";
        // line 23
        echo twig_escape_filter($this->env, $this->env->getExtension('slim')->pathFor("login"), "html", null, true);
        echo "\" method=\"POST\">
            <input type=\"hidden\" value=\"";
        // line 24
        echo twig_escape_filter($this->env, (isset($context["csrf_value"]) ? $context["csrf_value"] : null), "html", null, true);
        echo "\" name=\"";
        echo twig_escape_filter($this->env, (isset($context["csrf_name"]) ? $context["csrf_name"] : null), "html", null, true);
        echo "\">
            <fieldset>

              ";
        // line 27
        $this->loadTemplate("admin/alert/form.twig", "admin/login.twig", 27)->display($context);
        // line 28
        echo "
              <div class=\"";
        // line 29
        echo (($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "error", array())) ? ("has-error") : (""));
        echo "\">
                <label class=\"control-label\">Username</label>
                <div class=\"\">
                  <input type=\"text\" name=\"username\" value=\"";
        // line 32
        echo twig_escape_filter($this->env, ((($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "input_value", array(), "any", false, true), "username", array(), "any", true, true) &&  !(null === $this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "input_value", array(), "any", false, true), "username", array())))) ? ($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "input_value", array(), "any", false, true), "username", array())) : ("")), "html", null, true);
        echo "\" class=\"form-control\">
                </div>
              </div>
              <div class=\"";
        // line 35
        echo (($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "error", array())) ? ("has-error") : (""));
        echo "\">
                <label class=\"control-label\">Password</label>
                <div class=\"\">
                  <input type=\"password\" name=\"password\" class=\"form-control\">
                </div>
              </div>
              <div class=\"\">
                <label></label>
                <div>
                  <button class=\"btn btn-primary\" type=\"submit\">Login</button>
                </div>
              </div>
            </fieldset>
          </form>
        </div>
    </div> <!-- /container -->


";
    }

    public function getTemplateName()
    {
        return "admin/login.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  89 => 35,  83 => 32,  77 => 29,  74 => 28,  72 => 27,  64 => 24,  60 => 23,  52 => 17,  49 => 16,  39 => 9,  32 => 4,  29 => 3,  11 => 1,);
    }
}
/* {% extends "layout.twig" %}*/
/* */
/* {% block navbar %}*/
/* */
/*     <!-- Fixed navbar -->*/
/*     <nav class="navbar navbar-default navbar-fixed-top">*/
/*       <div class="container">*/
/*         <div class="navbar-header">*/
/*           <a class="navbar-brand" href="{{ path_for('login') }}">Presentation 2.0</a>*/
/*         </div>*/
/*       </div>*/
/*     </nav>*/
/* */
/* {% endblock %}*/
/* */
/* {% block content %}*/
/* */
/*     <!-- Begin page content -->*/
/*     <div class="container">*/
/*         <div class="col-lg-6 col-md-offset-3">*/
/* */
/* */
/*           <form class="form-horizontal" action="{{ path_for('login') }}" method="POST">*/
/*             <input type="hidden" value="{{ csrf_value }}" name="{{ csrf_name }}">*/
/*             <fieldset>*/
/* */
/*               {% include "admin/alert/form.twig" %}*/
/* */
/*               <div class="{{ form.error ? 'has-error' : '' }}">*/
/*                 <label class="control-label">Username</label>*/
/*                 <div class="">*/
/*                   <input type="text" name="username" value="{{ form.input_value.username ?? '' }}" class="form-control">*/
/*                 </div>*/
/*               </div>*/
/*               <div class="{{ form.error ? 'has-error' : '' }}">*/
/*                 <label class="control-label">Password</label>*/
/*                 <div class="">*/
/*                   <input type="password" name="password" class="form-control">*/
/*                 </div>*/
/*               </div>*/
/*               <div class="">*/
/*                 <label></label>*/
/*                 <div>*/
/*                   <button class="btn btn-primary" type="submit">Login</button>*/
/*                 </div>*/
/*               </div>*/
/*             </fieldset>*/
/*           </form>*/
/*         </div>*/
/*     </div> <!-- /container -->*/
/* */
/* */
/* {% endblock %}*/
/* */
