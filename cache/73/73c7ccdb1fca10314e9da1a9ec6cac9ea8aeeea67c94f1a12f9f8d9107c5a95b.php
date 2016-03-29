<?php

/* admin/alert/form.twig */
class __TwigTemplate_28669e5005110a2a70223c7e5696c7e58e268beb6cc130375da9a2de51233c7f extends Twig_Template
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
        if ($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "message", array())) {
            // line 2
            echo "        <div class=\"alert alert-";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["form"]) ? $context["form"] : null), "alert_type", array()), "html", null, true);
            echo "\">
          <p>";
            // line 3
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["form"]) ? $context["form"] : null), "message", array()), "html", null, true);
            echo "</p>
        </div>
      ";
        }
    }

    public function getTemplateName()
    {
        return "admin/alert/form.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  27 => 3,  22 => 2,  19 => 1,);
    }
}
/*       {% if form.message  %}*/
/*         <div class="alert alert-{{ form.alert_type }}">*/
/*           <p>{{ form.message }}</p>*/
/*         </div>*/
/*       {% endif %}*/
/* */
