<?php

/* themes/bootstrap/templates/input/form-element-label.html.twig */
class __TwigTemplate_45b78077272e5595b591af8b0387d3949c476e046e547245d3b5b5996321bce7 extends Twig_Template
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
        $tags = array("set" => 22, "if" => 30);
        $filters = array();
        $functions = array();

        try {
            $this->env->getExtension('Twig_Extension_Sandbox')->checkSecurity(
                array('set', 'if'),
                array(),
                array()
            );
        } catch (Twig_Sandbox_SecurityError $e) {
            $e->setSourceContext($this->getSourceContext());

            if ($e instanceof Twig_Sandbox_SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

        // line 22
        $context["classes"] = array(0 => "control-label", 1 => (((        // line 24
(isset($context["title_display"]) ? $context["title_display"] : null) == "after")) ? ("option") : ("")), 2 => ((((        // line 25
(isset($context["title_display"]) ? $context["title_display"] : null) == "invisible") &&  !((isset($context["is_checkbox"]) ? $context["is_checkbox"] : null) || (isset($context["is_radio"]) ? $context["is_radio"] : null)))) ? ("sr-only") : ("")), 3 => ((        // line 26
(isset($context["required"]) ? $context["required"] : null)) ? ("js-form-required") : ("")), 4 => ((        // line 27
(isset($context["required"]) ? $context["required"] : null)) ? ("form-required") : ("")));
        // line 30
        if ((( !twig_test_empty((isset($context["title"]) ? $context["title"] : null)) && ((isset($context["title_display"]) ? $context["title_display"] : null) == "invisible")) && ((isset($context["is_checkbox"]) ? $context["is_checkbox"] : null) || (isset($context["is_radio"]) ? $context["is_radio"] : null)))) {
            // line 35
            $context["attributes"] = $this->getAttribute((isset($context["attributes"]) ? $context["attributes"] : null), "setAttribute", array(0 => "title", 1 => (isset($context["title"]) ? $context["title"] : null)), "method");
            // line 36
            $context["title"] = null;
        }
        // line 42
        if ((( !twig_test_empty((isset($context["title"]) ? $context["title"] : null)) || (isset($context["is_checkbox"]) ? $context["is_checkbox"] : null)) || (isset($context["is_radio"]) ? $context["is_radio"] : null))) {
            // line 43
            echo "<label";
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute((isset($context["attributes"]) ? $context["attributes"] : null), "addClass", array(0 => (isset($context["classes"]) ? $context["classes"] : null)), "method"), "html", null, true));
            echo ">";
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, (isset($context["element"]) ? $context["element"] : null), "html", null, true));
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true));
            // line 44
            if ((isset($context["description"]) ? $context["description"] : null)) {
                // line 45
                echo "<p class=\"help-block\">";
                echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, (isset($context["description"]) ? $context["description"] : null), "html", null, true));
                echo "</p>";
            }
            // line 47
            echo "</label>";
        }
    }

    public function getTemplateName()
    {
        return "themes/bootstrap/templates/input/form-element-label.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  71 => 47,  66 => 45,  64 => 44,  58 => 43,  56 => 42,  53 => 36,  51 => 35,  49 => 30,  47 => 27,  46 => 26,  45 => 25,  44 => 24,  43 => 22,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "themes/bootstrap/templates/input/form-element-label.html.twig", "/home/zyxware/projects/makequiz/themes/bootstrap/templates/input/form-element-label.html.twig");
    }
}
