<?php

/* admin/alert/flash.twig */
class __TwigTemplate_d537fae7d7e054a4b5cee7c301dd9113c3dba9d271d950d91650cc3931f83724 extends Twig_Template
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
        echo "      ";
        if ($this->getAttribute((isset($context["flash"]) ? $context["flash"] : null), "message", array())) {
            // line 2
            echo "      <div class=\"row\">
        <div class=\"alert alert-";
            // line 3
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["flash"]) ? $context["flash"] : null), "alert_type", array()), "html", null, true);
            echo "\">
          <p>";
            // line 4
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["flash"]) ? $context["flash"] : null), "message", array()), "html", null, true);
            echo "</p>
        </div>
      </div>
      ";
        }
    }

    public function getTemplateName()
    {
        return "admin/alert/flash.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  29 => 4,  25 => 3,  22 => 2,  19 => 1,);
    }
}
/*       {% if flash.message  %}*/
/*       <div class="row">*/
/*         <div class="alert alert-{{ flash.alert_type }}">*/
/*           <p>{{ flash.message }}</p>*/
/*         </div>*/
/*       </div>*/
/*       {% endif %}*/
/* */
