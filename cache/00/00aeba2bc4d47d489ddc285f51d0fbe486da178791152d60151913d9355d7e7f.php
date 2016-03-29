<?php

/* layout.twig */
class __TwigTemplate_8aded71d403feb51379d4c981d4e05b898d6ae141bfbe88e95014923a0b4ffcc extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'navbar' => array($this, 'block_navbar'),
            'content' => array($this, 'block_content'),
            'js' => array($this, 'block_js'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
  <head>
    <meta charset=\"utf-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <meta name=\"description\" content=\"Presentation2.0 is a PHP Web App that helps you quickly prepare and present presentation simply from Markdown file.\">
    <meta name=\"keywords\" content=\"presentation, markdown, slide sync, presentation2.0, slide\">
    <meta name=\"author\" content=\"Deepak Adhikari <deeps.adhi@gmail.com>\">

    <title>Presentation 2.0</title>

    <!-- Bootstrap core CSS -->
    <link href=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "basepath", array()), "html", null, true);
        echo "/theme/";
        echo twig_escape_filter($this->env, (isset($context["theme"]) ? $context["theme"] : null), "html", null, true);
        echo "/bootstrap.min.css\" rel=\"stylesheet\">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href=\"";
        // line 17
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "basepath", array()), "html", null, true);
        echo "/css/ie10-viewport-bug-workaround.css\" rel=\"stylesheet\">

    <!-- Custom styles for this template -->
    <link href=\"";
        // line 20
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "basepath", array()), "html", null, true);
        echo "/css/style.css\" rel=\"stylesheet\">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src=\"";
        // line 23
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "basepath", array()), "html", null, true);
        echo "/js/vendor/ie8-responsive-file-warning.js\"></script><![endif]-->
    <script src=\"";
        // line 24
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "basepath", array()), "html", null, true);
        echo "/js/vendor/ie-emulation-modes-warning.js\"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src=\"";
        // line 28
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "basepath", array()), "html", null, true);
        echo "/js/vendor/html5shiv.min.js\"></script>
      <script src=\"";
        // line 29
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "basepath", array()), "html", null, true);
        echo "/js/vendor/respond.min.js\"></script>
    <![endif]-->
  </head>

  <body>

    ";
        // line 35
        $this->displayBlock('navbar', $context, $blocks);
        // line 37
        echo "
    ";
        // line 38
        $this->displayBlock('content', $context, $blocks);
        // line 40
        echo "
    <footer class=\"footer\">
      <div class=\"container\">
        <p class=\"text-muted\">
          <a target=\"_blank\" href=\"https://github.com/deepsadhi/presentation2.0\">GitHub</a>
        </p>
      </div>
    </footer>

    <script src=\"";
        // line 49
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "basepath", array()), "html", null, true);
        echo "/js/vendor/jquery-2.2.1.min.js\"></script>
    <script src=\"";
        // line 50
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "basepath", array()), "html", null, true);
        echo "/js/vendor/bootstrap.min.js\"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src=\"";
        // line 52
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "basepath", array()), "html", null, true);
        echo "/js/vendor/ie10-viewport-bug-workaround.js\"></script>
    ";
        // line 53
        $this->displayBlock('js', $context, $blocks);
        // line 55
        echo "  </body>
</html>
";
    }

    // line 35
    public function block_navbar($context, array $blocks = array())
    {
        // line 36
        echo "    ";
    }

    // line 38
    public function block_content($context, array $blocks = array())
    {
        // line 39
        echo "    ";
    }

    // line 53
    public function block_js($context, array $blocks = array())
    {
        // line 54
        echo "    ";
    }

    public function getTemplateName()
    {
        return "layout.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  137 => 54,  134 => 53,  130 => 39,  127 => 38,  123 => 36,  120 => 35,  114 => 55,  112 => 53,  108 => 52,  103 => 50,  99 => 49,  88 => 40,  86 => 38,  83 => 37,  81 => 35,  72 => 29,  68 => 28,  61 => 24,  57 => 23,  51 => 20,  45 => 17,  37 => 14,  22 => 1,);
    }
}
/* <!DOCTYPE html>*/
/* <html lang="en">*/
/*   <head>*/
/*     <meta charset="utf-8">*/
/*     <meta http-equiv="X-UA-Compatible" content="IE=edge">*/
/*     <meta name="viewport" content="width=device-width, initial-scale=1">*/
/*     <meta name="description" content="Presentation2.0 is a PHP Web App that helps you quickly prepare and present presentation simply from Markdown file.">*/
/*     <meta name="keywords" content="presentation, markdown, slide sync, presentation2.0, slide">*/
/*     <meta name="author" content="Deepak Adhikari <deeps.adhi@gmail.com>">*/
/* */
/*     <title>Presentation 2.0</title>*/
/* */
/*     <!-- Bootstrap core CSS -->*/
/*     <link href="{{ app.request.basepath }}/theme/{{ theme }}/bootstrap.min.css" rel="stylesheet">*/
/* */
/*     <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->*/
/*     <link href="{{ app.request.basepath }}/css/ie10-viewport-bug-workaround.css" rel="stylesheet">*/
/* */
/*     <!-- Custom styles for this template -->*/
/*     <link href="{{ app.request.basepath }}/css/style.css" rel="stylesheet">*/
/* */
/*     <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->*/
/*     <!--[if lt IE 9]><script src="{{ app.request.basepath }}/js/vendor/ie8-responsive-file-warning.js"></script><![endif]-->*/
/*     <script src="{{ app.request.basepath }}/js/vendor/ie-emulation-modes-warning.js"></script>*/
/* */
/*     <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->*/
/*     <!--[if lt IE 9]>*/
/*       <script src="{{ app.request.basepath }}/js/vendor/html5shiv.min.js"></script>*/
/*       <script src="{{ app.request.basepath }}/js/vendor/respond.min.js"></script>*/
/*     <![endif]-->*/
/*   </head>*/
/* */
/*   <body>*/
/* */
/*     {% block navbar %}*/
/*     {% endblock %}*/
/* */
/*     {% block content %}*/
/*     {% endblock %}*/
/* */
/*     <footer class="footer">*/
/*       <div class="container">*/
/*         <p class="text-muted">*/
/*           <a target="_blank" href="https://github.com/deepsadhi/presentation2.0">GitHub</a>*/
/*         </p>*/
/*       </div>*/
/*     </footer>*/
/* */
/*     <script src="{{ app.request.basepath }}/js/vendor/jquery-2.2.1.min.js"></script>*/
/*     <script src="{{ app.request.basepath }}/js/vendor/bootstrap.min.js"></script>*/
/*     <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->*/
/*     <script src="{{ app.request.basepath }}/js/vendor/ie10-viewport-bug-workaround.js"></script>*/
/*     {% block js %}*/
/*     {% endblock %}*/
/*   </body>*/
/* </html>*/
/* */
