<?php

/* admin/alert/dialogbox.twig */
class __TwigTemplate_852a216000ce209511f35aa7107c2d2db0a3258cb8ddaa6e34ff2ba8aed2d3a7 extends Twig_Template
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
        echo "    <div class=\"modal fade\" id=\"confirm-delete\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
      <div class=\"modal-dialog\">
        <div class=\"modal-content\">
          <form method=\"POST\" action=\"";
        // line 4
        echo twig_escape_filter($this->env, $this->env->getExtension('slim')->pathFor("file"), "html", null, true);
        echo "\" id=\"delete-form\">
            <div class=\"modal-header\">
              <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>
              <h4 class=\"modal-title\" id=\"myModalLabel\">Confirm Delete</h4>
            </div>

            <div class=\"modal-body\">
              <p>Are you sure want to delete file <strong id=\"name\"></strong>?</p>
            </div>

            <div class=\"modal-footer\">
              <input type=\"hidden\" name=\"";
        // line 15
        echo twig_escape_filter($this->env, (isset($context["csrf_name"]) ? $context["csrf_name"] : null), "html", null, true);
        echo "\" value=\"";
        echo twig_escape_filter($this->env, (isset($context["csrf_value"]) ? $context["csrf_value"] : null), "html", null, true);
        echo "\">
              <input type=\"hidden\" name=\"_METHOD\" value=\"DELETE\">
              <input type=\"hidden\" name=\"file\" id=\"file\">
              <input type=\"hidden\" name=\"path\" id=\"path\">
              <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Cancel</button>
              <button type=\"submit\" class=\"btn btn-danger btn-ok\">Delete</button>
            </div>
          </form>
        </div>
      </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "admin/alert/dialogbox.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  38 => 15,  24 => 4,  19 => 1,);
    }
}
/*     <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">*/
/*       <div class="modal-dialog">*/
/*         <div class="modal-content">*/
/*           <form method="POST" action="{{ path_for('file') }}" id="delete-form">*/
/*             <div class="modal-header">*/
/*               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>*/
/*               <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>*/
/*             </div>*/
/* */
/*             <div class="modal-body">*/
/*               <p>Are you sure want to delete file <strong id="name"></strong>?</p>*/
/*             </div>*/
/* */
/*             <div class="modal-footer">*/
/*               <input type="hidden" name="{{ csrf_name }}" value="{{ csrf_value }}">*/
/*               <input type="hidden" name="_METHOD" value="DELETE">*/
/*               <input type="hidden" name="file" id="file">*/
/*               <input type="hidden" name="path" id="path">*/
/*               <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>*/
/*               <button type="submit" class="btn btn-danger btn-ok">Delete</button>*/
/*             </div>*/
/*           </form>*/
/*         </div>*/
/*       </div>*/
/*     </div>*/
/* */
