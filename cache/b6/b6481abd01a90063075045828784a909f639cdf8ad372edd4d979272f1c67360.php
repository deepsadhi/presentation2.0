<?php

/* admin/partials/controls.twig */
class __TwigTemplate_5a5978e89e9638904779a43fb2b35863b209cf514331591e6bb784727f729596 extends Twig_Template
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
        <div id=\"navbar\">
          <div class=\"col-lg-12\">
            <div id=\"action\" class=\"pull-left\">
              <button id=\"prev\" class=\"btn btn-default btn-lg\">Prev</button>
              <button id=\"next\" class=\"btn btn-primary btn-lg\">Next</button>
            </div>
            <div class=\"pull-right\">
              <a href=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('slim')->pathFor("admin"), "html", null, true);
        echo "\" class=\"btn btn-info btn-lg\">Home</a>
              <button id=\"start\" class=\"btn btn-success btn-lg\">Start</button>
              <button id=\"stop\" class=\"btn btn-danger btn-lg\">Stop</button>
              <div>
                <span class=\"label label-success\" id=\"broadcast\">Live</span>
                <a href=\"javascript:window.location.reload()\" class=\"btn btn-primary btn-xs\" id=\"reconnect\">Reconnect</a>
              </div>
            </div>
          </div>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
";
    }

    public function getTemplateName()
    {
        return "admin/partials/controls.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  31 => 11,  19 => 1,);
    }
}
/*     <!-- Fixed navbar -->*/
/*     <nav class="navbar navbar-default navbar-fixed-top">*/
/*       <div class="container">*/
/*         <div id="navbar">*/
/*           <div class="col-lg-12">*/
/*             <div id="action" class="pull-left">*/
/*               <button id="prev" class="btn btn-default btn-lg">Prev</button>*/
/*               <button id="next" class="btn btn-primary btn-lg">Next</button>*/
/*             </div>*/
/*             <div class="pull-right">*/
/*               <a href="{{ path_for('admin') }}" class="btn btn-info btn-lg">Home</a>*/
/*               <button id="start" class="btn btn-success btn-lg">Start</button>*/
/*               <button id="stop" class="btn btn-danger btn-lg">Stop</button>*/
/*               <div>*/
/*                 <span class="label label-success" id="broadcast">Live</span>*/
/*                 <a href="javascript:window.location.reload()" class="btn btn-primary btn-xs" id="reconnect">Reconnect</a>*/
/*               </div>*/
/*             </div>*/
/*           </div>*/
/*         </div><!--/.nav-collapse -->*/
/*       </div>*/
/*     </nav>*/
/* */
