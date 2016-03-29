<?php

/* admin/index/presentation.twig */
class __TwigTemplate_c91bfadf6d0662e0e1085cdd9e53706db7192e0d28cb1343dd8eec4eaed80ce5 extends Twig_Template
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
        echo "      <div class=\"row\">
        <table class=\"table table-striped table-hover \">
          <thead>
            <tr>
              <th>#</th>
              <th>File name</th>
              <th>File size</th>
              <th>Modified on</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            ";
        // line 13
        $context["i"] = 1;
        // line 14
        echo "            ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["files"]) ? $context["files"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["file"]) {
            // line 15
            echo "            <tr>
              <td>";
            // line 16
            echo twig_escape_filter($this->env, (isset($context["i"]) ? $context["i"] : null), "html", null, true);
            echo "</td>
              <td><a href=\"";
            // line 17
            echo twig_escape_filter($this->env, $this->env->getExtension('slim')->pathFor("show", array("file" => $this->getAttribute($context["file"], "name_", array()))), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute($context["file"], "name", array()), "html", null, true);
            echo "</a></td>
              <td>";
            // line 18
            echo twig_escape_filter($this->env, $this->getAttribute($context["file"], "size", array()), "html", null, true);
            echo "</td>
              <td>";
            // line 19
            echo twig_escape_filter($this->env, $this->getAttribute($context["file"], "date", array()), "html", null, true);
            echo "</td>
              <td>
                <a href=\"";
            // line 21
            echo twig_escape_filter($this->env, $this->env->getExtension('slim')->pathFor("edit", array("file" => $this->getAttribute($context["file"], "name_", array()))), "html", null, true);
            echo "\" class=\"btn btn-primary btn-xs\">edit</a>
                <a class=\"btn btn-danger btn-xs\" data-target=\"#confirm-delete\" data-toggle=\"modal\" data-file=\"";
            // line 22
            echo twig_escape_filter($this->env, $this->getAttribute($context["file"], "name", array()), "html", null, true);
            echo "\" data-path=\"presentation\" href=\"#\">Delete</a>
              </td>
            </tr>
            ";
            // line 25
            $context["i"] = ((isset($context["i"]) ? $context["i"] : null) + 1);
            // line 26
            echo "            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['file'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 27
        echo "          </tbody>
        </table>
      </div>
";
    }

    public function getTemplateName()
    {
        return "admin/index/presentation.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  80 => 27,  74 => 26,  72 => 25,  66 => 22,  62 => 21,  57 => 19,  53 => 18,  47 => 17,  43 => 16,  40 => 15,  35 => 14,  33 => 13,  19 => 1,);
    }
}
/*       <div class="row">*/
/*         <table class="table table-striped table-hover ">*/
/*           <thead>*/
/*             <tr>*/
/*               <th>#</th>*/
/*               <th>File name</th>*/
/*               <th>File size</th>*/
/*               <th>Modified on</th>*/
/*               <th>Action</th>*/
/*             </tr>*/
/*           </thead>*/
/*           <tbody>*/
/*             {% set i = 1 %}*/
/*             {% for file in files %}*/
/*             <tr>*/
/*               <td>{{ i }}</td>*/
/*               <td><a href="{{ path_for('show', {'file': file.name_}) }}">{{ file.name }}</a></td>*/
/*               <td>{{ file.size }}</td>*/
/*               <td>{{ file.date }}</td>*/
/*               <td>*/
/*                 <a href="{{ path_for('edit', {'file': file.name_}) }}" class="btn btn-primary btn-xs">edit</a>*/
/*                 <a class="btn btn-danger btn-xs" data-target="#confirm-delete" data-toggle="modal" data-file="{{ file.name }}" data-path="presentation" href="#">Delete</a>*/
/*               </td>*/
/*             </tr>*/
/*             {% set i = i + 1 %}*/
/*             {% endfor %}*/
/*           </tbody>*/
/*         </table>*/
/*       </div>*/
/* */
