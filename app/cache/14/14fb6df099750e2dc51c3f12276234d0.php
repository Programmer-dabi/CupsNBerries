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
class __TwigTemplate_e69946eb7dfa497789971f17d3bc299e extends Template
{
    private Source $source;
    /**
     * @var array<string, MacroNamespace>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

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
          <a href=\"menu.php\"> Menu </a>
          <a href=\"home.php#about\"> Our Story </a>
          <a href=\"home.php#visit\"> Visit Us </a>
          <a href=\"account.php\"> My Account </a>
          <a href=\"/logout\"> logout (temp) </a>
        </nav>
      
        <div class=\"nav-actions\">
          <a aria-label=\"Account\" href=\"/login\"> ♙ </a>
          <a aria-label=\"Cart\" href=\"cart.php\">
            🛒
            <span> 2 </span>
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
          <a href=\"menu.php\"> Menu </a>
          <a href=\"home.php#about\"> Our Story </a>
          <a href=\"home.php#visit\"> Visit Us </a>
          <a href=\"account.php\"> My Account </a>
          <a href=\"/logout\"> logout (temp) </a>
      </div>
    </header>";
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
    public function getDefaultEscapeStrategy(): string|false
    {
        return "html";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  44 => 1,);
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
          <a href=\"menu.php\"> Menu </a>
          <a href=\"home.php#about\"> Our Story </a>
          <a href=\"home.php#visit\"> Visit Us </a>
          <a href=\"account.php\"> My Account </a>
          <a href=\"/logout\"> logout (temp) </a>
        </nav>
      
        <div class=\"nav-actions\">
          <a aria-label=\"Account\" href=\"/login\"> ♙ </a>
          <a aria-label=\"Cart\" href=\"cart.php\">
            🛒
            <span> 2 </span>
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
          <a href=\"menu.php\"> Menu </a>
          <a href=\"home.php#about\"> Our Story </a>
          <a href=\"home.php#visit\"> Visit Us </a>
          <a href=\"account.php\"> My Account </a>
          <a href=\"/logout\"> logout (temp) </a>
      </div>
    </header>", "components/header.twig", "/opt/lampp/htdocs/final-project/app/views/components/header.twig");
    }
}
