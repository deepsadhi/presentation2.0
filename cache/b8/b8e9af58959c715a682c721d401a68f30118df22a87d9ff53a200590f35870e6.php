<?php

/* admin/partials/navbar.twig */
class __TwigTemplate_0f42a98ca65f14ceadf9cd3bc336205cb604d5579629cce8a24210ad37101780 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "    <!-- Fixed navbar -->
    <nav class=\"navbar navbar-default navbar-fixed-top\">
      <div class=\"container\">
        <div class=\"navbar-header\">
          <a class=\"navbar-brand\" href=\"";
        // line 5
        echo twig_escape_filter($this->env, $this->env->getExtension('slim')->pathFor("admin"), "html", null, true);
        echo "\">Presentation 2.0</a>
        </div>
        <div id=\"navbar\" class=\"collapse navbar-collapse\">
          <ul class=\"nav navbar-nav\">
            <li class=\"";
        // line 9
        echo ((((isset($context["active_page"]) ? $context["active_page"] : null) == "home")) ? ("active") : (""));
        echo "\"><a href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('slim')->pathFor("admin"), "html", null, true);
        echo "\">Home</a></li>
            <li class=\"";
        // line 10
        echo ((((isset($context["active_page"]) ? $context["active_page"] : null) == "create")) ? ("active") : (""));
        echo "\"><a href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('slim')->pathFor("create"), "html", null, true);
        echo "\">Create</a></li>
            <li class=\"";
        // line 11
        echo ((((isset($context["active_page"]) ? $context["active_page"] : null) == "media")) ? ("active") : (""));
        echo "\"><a href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('slim')->pathFor("media"), "html", null, true);
        echo "\">Media</a></li>
          </ul>
          <ul class=\"nav navbar-nav navbar-right\">
            <li><a href=\"./presentation/presentation2_0_md/show\">User Guide</a></li>
            <li class=\"";
        // line 15
        echo ((((isset($context["active_page"]) ? $context["active_page"] : null) == "settings")) ? ("active") : (""));
        echo "\"><a href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('slim')->pathFor("settings"), "html", null, true);
        echo "\">Settings</a></li>
            <li><a href=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->env->getExtension('slim')->pathFor("logout"), "html", null, true);
        echo "\">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
";
    }

    public function getTemplateName()
    {
        return "admin/partials/navbar.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  59 => 16,  53 => 15,  44 => 11,  38 => 10,  32 => 9,  25 => 5,  19 => 1,);
    }
}
/*     <!-- Fixed navbar -->*/
/*     <nav class="navbar navbar-default navbar-fixed-top">*/
/*       <div class="container">*/
/*         <div class="navbar-header">*/
/*           <a class="navbar-brand" href="{{ path_for('admin') }}">Presentation 2.0</a>*/
/*         </div>*/
/*         <div id="navbar" class="collapse navbar-collapse">*/
/*           <ul class="nav navbar-nav">*/
/*             <li class="{{ active_page == 'home' ? 'active' : '' }}"><a href="{{ path_for('admin') }}">Home</a></li>*/
/*             <li class="{{ active_page == 'create' ? 'active' : '' }}"><a href="{{ path_for('create') }}">Create</a></li>*/
/*             <li class="{{ active_page == 'media' ? 'active' : '' }}"><a href="{{ path_for('media') }}">Media</a></li>*/
/*           </ul>*/
/*           <ul class="nav navbar-nav navbar-right">*/
/*             <li><a href="./presentation/presentation2_0_md/show">User Guide</a></li>*/
/*             <li class="{{ active_page == 'settings' ? 'active' : '' }}"><a href="{{ path_for('settings') }}">Settings</a></li>*/
/*             <li><a href="{{ path_for('logout') }}">Logout</a></li>*/
/*           </ul>*/
/*         </div><!--/.nav-collapse -->*/
/*       </div>*/
/*     </nav>*/
/* */
