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

/* components/footer.twig */
class __TwigTemplate_285b1b3d832768273857340e939966a9 extends Template
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
        yield "<footer>
      <div class=\"footer-main\">
        <div>
          <a class=\"logo logo-light\" href=\"home.php\">
            <span class=\"logo-mark\"> C&B </span>
            <span>
              Cups &amp; Berry
              <small> COFFEE &amp; PASTRY </small>
            </span>
          </a>
          <p>
            Thoughtful coffee and fresh bakes,
            <br />
            made for your everyday moments.
          </p>
        </div>
        <div>
          <b> EXPLORE </b>
          <a href=\"menu.php\"> Our menu </a>
          <a href=\"home.php#about\"> Our story </a>
          <a href=\"home.php#visit\"> Visit us </a>
        </div>
        <div>
          <b> HELP </b>
          <a href=\"tracking.php\"> Track order </a>
          <a href=\"account.php\"> My account </a>
          <a> FAQs </a>
        </div>
        <div>
          <b> STAY IN THE LOOP </b>
          <p>Get first dibs on new drinks and treats.</p>
          <label>
            <input placeholder=\"Your email address\" />
            <button>→</button>
          </label>
        </div>
      </div>
      <div class=\"footer-bottom\">
        <span> © 2026  Cups &amp; Berry </span>
        <a href=\"admin.php\"> Admin portal </a>
        <span> Privacy · Terms </span>
      </div>
    </footer>";
        return; yield;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "components/footer.twig";
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
        return new Source("<footer>
      <div class=\"footer-main\">
        <div>
          <a class=\"logo logo-light\" href=\"home.php\">
            <span class=\"logo-mark\"> C&B </span>
            <span>
              Cups &amp; Berry
              <small> COFFEE &amp; PASTRY </small>
            </span>
          </a>
          <p>
            Thoughtful coffee and fresh bakes,
            <br />
            made for your everyday moments.
          </p>
        </div>
        <div>
          <b> EXPLORE </b>
          <a href=\"menu.php\"> Our menu </a>
          <a href=\"home.php#about\"> Our story </a>
          <a href=\"home.php#visit\"> Visit us </a>
        </div>
        <div>
          <b> HELP </b>
          <a href=\"tracking.php\"> Track order </a>
          <a href=\"account.php\"> My account </a>
          <a> FAQs </a>
        </div>
        <div>
          <b> STAY IN THE LOOP </b>
          <p>Get first dibs on new drinks and treats.</p>
          <label>
            <input placeholder=\"Your email address\" />
            <button>→</button>
          </label>
        </div>
      </div>
      <div class=\"footer-bottom\">
        <span> © 2026  Cups &amp; Berry </span>
        <a href=\"admin.php\"> Admin portal </a>
        <span> Privacy · Terms </span>
      </div>
    </footer>", "components/footer.twig", "/opt/lampp/htdocs/final-project/app/views/components/footer.twig");
    }
}
