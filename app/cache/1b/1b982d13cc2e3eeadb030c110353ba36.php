<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\MacroNamespace;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Sandbox\SecurityNotAllowedTestError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* components/header.twig */
class __TwigTemplate_b67c16eae998c761740d9b67f6a4e783 extends Template
{
    private Source $source;
    /**
     * @var array<string, MacroNamespace>
     */
    private array $macros = [];
    private \Twig\Runtime\EscaperRuntime $escaper;

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->escaper = $env->getRuntime('Twig\Runtime\EscaperRuntime');

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield " <header class=\"site-header\">
      <div class=\"nav-wrap\">
        <a class=\"logo\" href=\"/\">
          <span class=\"logo-mark\"> C&B </span>
          <span>
            Cups & Berry
            <small> COFFEE &amp; PASTRY </small>
          </span>
        </a>
        <nav>
          <a href=\"/\"> Home </a>
          <a href=\"/#menu\"> Menu </a>
          <a href=\"/#about\"> Our Story </a>
          <a href=\"/#visit\"> Visit Us </a>
          <a href=\"account.php\"> My Account </a>
          <a href=\"/logout\"> logout (temp) </a>
        </nav>
      
        <div class=\"nav-actions\">
          <a aria-label=\"Account\" href=\"/login\"> ♙ </a>
          <a aria-label=\"Cart\" href=\"/cart\">
            🛒
            <span data-cart-count> ";
        // line 23
        yield (string) $this->escaper->escape(((array_key_exists("cart_count", $context)) ? (Twig\Extension\CoreExtension::default(($context["cart_count"] ?? null), 0)) : (0)), "html", null, true);
        yield " </span>
          </a>
        </div>
        <div class=\"Hamburger\">
          <div class=\"line1\"></div>
          <div class=\"line2\"></div>
          <div class=\"line3\"></div>
        </div>
      </div>

      <div class=\"navLinks\">
          <a href=\"/\"> Home </a>
          <a href=\"/#menu\"> Menu </a>
          <a href=\"/#about\"> Our Story </a>
          <a href=\"/#visit\"> Visit Us </a>
          <a href=\"account.php\"> My Account </a>
          <a href=\"/logout\"> logout (temp) </a>
      </div>
    </header>
";
        return; yield;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "components/header.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDefaultEscapeStrategy(): string|false
    {
        return "html";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  71 => 23,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source(" <header class=\"site-header\">
      <div class=\"nav-wrap\">
        <a class=\"logo\" href=\"/\">
          <span class=\"logo-mark\"> C&B </span>
          <span>
            Cups & Berry
            <small> COFFEE &amp; PASTRY </small>
          </span>
        </a>
        <nav>
          <a href=\"/\"> Home </a>
          <a href=\"/#menu\"> Menu </a>
          <a href=\"/#about\"> Our Story </a>
          <a href=\"/#visit\"> Visit Us </a>
          <a href=\"account.php\"> My Account </a>
          <a href=\"/logout\"> logout (temp) </a>
        </nav>
      
        <div class=\"nav-actions\">
          <a aria-label=\"Account\" href=\"/login\"> ♙ </a>
          <a aria-label=\"Cart\" href=\"/cart\">
            🛒
            <span data-cart-count> {{ cart_count|default(0) }} </span>
          </a>
        </div>
        <div class=\"Hamburger\">
          <div class=\"line1\"></div>
          <div class=\"line2\"></div>
          <div class=\"line3\"></div>
        </div>
      </div>

      <div class=\"navLinks\">
          <a href=\"/\"> Home </a>
          <a href=\"/#menu\"> Menu </a>
          <a href=\"/#about\"> Our Story </a>
          <a href=\"/#visit\"> Visit Us </a>
          <a href=\"account.php\"> My Account </a>
          <a href=\"/logout\"> logout (temp) </a>
      </div>
    </header>
", "components/header.twig", "/opt/lampp/htdocs/final-project/app/views/components/header.twig");
    }
}
