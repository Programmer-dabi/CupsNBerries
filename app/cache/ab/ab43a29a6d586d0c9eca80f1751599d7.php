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

/* home.twig */
class __TwigTemplate_1a39f4abef2a4cc2e0a4bf57364344c1 extends Template
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
        yield "<!doctype html>
<html lang=\"en\">
  <head>
    <meta charset=\"utf-8\" />
    <meta content=\"width=device-width, initial-scale=1\" name=\"viewport\" />
    <title>Kapétolyo Coffee &amp; Bakehouse</title>
    
    <link href=\"";
        // line 8
        yield (string) $this->escaper->escape(($context["base_url"] ?? null), "html", null, true);
        yield "public/style/style.css\" rel=\"stylesheet\"/>
  </head>
  <body>
    ";
        // line 11
        yield from $this->load("components/header.twig", 11)->unwrap()->yield($context);
        // line 12
        yield "    <section class=\"hero\">
      <div class=\"hero-inner\">
        <div class=\"hero-copy\">
          <span class=\"kicker\"> Your neighborhood cup, made better. </span>
          <h1>
            Slow mornings.
            <br />
            <em> Great coffee. </em>
          </h1>
          <p>
            Thoughtfully sourced beans, comforting bakes, and handcrafted
            drinks—made fresh for your everyday rituals.
          </p>
          <div class=\"hero-actions\">
            <a class=\"primary\" href=\"/#menu\"> Explore our menu → </a>
            <a class=\"text-link\" href=\"/#about\"> Our story </a>
          </div>
          <div class=\"hero-trust\">
            <span>
            <i> </i>
            <span>
              <b> 15 min </b>
              average pickup
            </span>
            <i> </i>
            <span>
              <b> Fresh </b>
              daily
            </span>
          </div>
        </div>
        <div class=\"hero-image\">
          <img
            alt=\"Cappuccino\"
            src=\"https://images.unsplash.com/photo-1753727470826-584b80850a3c?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;q=85&amp;w=1200\"
          />
          <div class=\"floating-card\">
            <span> Start your day with</span>
            <b> Spanish Latte </b>
            <small> Silky, sweet, perfectly balanced </small>
          </div>
        </div>
      </div>
    </section>
    <section class=\"section\">
      <div class=\"section-heading\">
        <div>
          <span class=\"kicker\"> Find your favorite </span>
          <h2>What are you craving?</h2>
        </div>
        <a class=\"text-link\" href=\"/#menu\"> View full menu → </a>
      </div>
      <div class=\"category-grid\">
        <a class=\"category-card\" href=\"/#menu\">
          <span class=\"cat-icon\"> ○ </span>
          <span>
            <b> Coffee </b>
            <small> Freshly pulled </small>
          </span>
          ›
        </a>
        <a class=\"category-card\" href=\"/#menu\">
          <span class=\"cat-icon\"> ○ </span>
          <span>
            <b> Non-Coffee </b>
            <small> Smooth &amp; cozy </small>
          </span>
          ›
        </a>
        <a class=\"category-card\" href=\"/#menu\">
          <span class=\"cat-icon\"> ○ </span>
          <span>
            <b> Tea </b>
            <small> Calm in a cup </small>
          </span>
          ›
        </a>
        <a class=\"category-card\" href=\"/#menu\">
          <span class=\"cat-icon\"> ◇ </span>
          <span>
            <b> Pastries </b>
            <small> Baked this morning </small>
          </span>
          ›
        </a>
      </div>
    </section>
    <section class=\"section\" id=\"menu\">
      <div class=\"section-heading\">
        <div>
          <span class=\"kicker\"> Made with care </span>
          <h2>Most-loved picks</h2>
          <p>The drinks and treats our regulars always come back for.</p>
        </div>
        <a class=\"outline\" href=\"/#menu\"> Browse all </a>
      </div>
      <div class=\"product-grid\">
      ";
        // line 109
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["products"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["product"]) {
            // line 110
            yield "        <article class=\"product-card\">
          <a class=\"product-photo\" href=\"/product/";
            // line 111
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["product"], "id", [], "any", false, false, false, 111), "html", null, true);
            yield "\">
          ";
            // line 112
            if ( !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, $context["product"], "images", [], "any", false, false, false, 112))) {
                // line 113
                yield "                  <img
                      alt=\"";
                // line 114
                yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["product"], "product_name", [], "any", false, false, false, 114), "html", null, true);
                yield "\"
                      src=\"";
                // line 115
                yield (string) $this->escaper->escape(($context["base_url"] ?? null), "html", null, true);
                yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, (($_v0 = CoreExtension::getAttribute($this->env, $this->source, $context["product"], "images", [], "any", false, false, false, 115)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[0] ?? null) : null), "image_path", [], "any", false, false, false, 115), "html", null, true);
                yield "\"
                  />
          ";
            }
            // line 118
            yield "            ";
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["product"], "availability", [], "any", false, false, false, 118) != "Available")) {
                // line 119
                yield "            <span class=\"photo-badge\"> Unavailable </span>
            ";
            }
            // line 121
            yield "            <span class=\"heart\"> ♡ </span>
          </a>
          <div class=\"product-info\">
            <div class=\"eyebrow-row\">
              <span> ";
            // line 125
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["product"], "category", [], "any", false, false, false, 125), "html", null, true);
            yield " </span>
              <!-- <span class=\"rating\"> ★ 4.9 </span> -->
            </div>
            <h3>";
            // line 128
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["product"], "product_name", [], "any", false, false, false, 128), "html", null, true);
            yield "</h3>
            <p>";
            // line 129
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["product"], "description", [], "any", false, false, false, 129), "html", null, true);
            yield "</p>
            <div class=\"product-bottom\">
              <strong> ₱";
            // line 131
            yield (string) $this->escaper->escape($this->extensions['Twig\Extension\CoreExtension']->formatNumber(CoreExtension::getAttribute($this->env, $this->source, $context["product"], "base_price", [], "any", false, false, false, 131), 2), "html", null, true);
            yield " </strong>
              <a class=\"add-circle\" href=\"/product/";
            // line 132
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["product"], "id", [], "any", false, false, false, 132), "html", null, true);
            yield "\" aria-label=\"Choose options for ";
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["product"], "product_name", [], "any", false, false, false, 132), "html", null, true);
            yield "\"> + </a>
            </div>
          </div>
        </article>
        ";
            $context['_iterated'] = true;
        }
        // line 136
        if (!$context['_iterated']) {
            // line 137
            yield "        <h3>No Product found</h3>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['product'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 139
        yield "      </div>
    </section>
    <section class=\"story\" id=\"about\">
      <div class=\"story-image\">
        <img
          alt=\"Fresh coffee\"
          src=\"https://images.unsplash.com/photo-1587982708730-ffc82d18e9fc?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;q=85&amp;w=1200\"
        />
        <span class=\"story-stamp\">
          ROASTED
          <br />
          WITH CARE
        </span>
      </div>
      <div class=\"story-copy\">
        <span class=\"kicker\"> A little about us </span>
        <h2>
          Good coffee brings
          <br />
          good people together.
        </h2>
        <p>
          Kapétolyo started with a simple belief: your daily cup should feel
          special. We work with local roasters and bakers to serve honest
          flavors, warm hospitality, and a pause worth taking.
        </p>
        <div class=\"story-stats\">
          <div>
            <b> 100% </b>
            <span> Locally roasted beans </span>
          </div>
          <div>
            <b> 2021 </b>
            <span> Serving the community </span>
          </div>
        </div>
        <a class=\"text-link\" href=\"/#about\"> Read our story → </a>
      </div>
    </section>
    <section class=\"visit\" id=\"visit\">
      <div>
        <span class=\"kicker\"> Come say hello </span>
        <h2>Your corner for coffee &amp; calm.</h2>
        <p>Open daily · 7:00 AM – 9:00 PM</p>
      </div>
      <div class=\"visit-details\">
        <div>
          <small> FIND US </small>
          <b> 18 Mabini Street, Quezon City </b>
        </div>
        <div>
          <small> CALL AHEAD </small>
          <b> 0917 843 2024 </b>
        </div>
        <a class=\"cream-button\" href=\"/#visit\"> Get directions → </a>
      </div>
    </section>
            ";
        // line 196
        yield from $this->load("components/footer.twig", 196)->unwrap()->yield($context);
        // line 197
        yield "    <script type=\"module\" src=\"";
        yield (string) $this->escaper->escape(($context["base_url"] ?? null), "html", null, true);
        yield "public/js/main.js\"></script>
  </body>
</html>
";
        return; yield;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "home.twig";
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
        return array (  305 => 197,  303 => 196,  244 => 139,  236 => 137,  234 => 136,  223 => 132,  219 => 131,  214 => 129,  210 => 128,  204 => 125,  198 => 121,  194 => 119,  191 => 118,  184 => 115,  180 => 114,  177 => 113,  175 => 112,  171 => 111,  168 => 110,  163 => 109,  64 => 12,  62 => 11,  56 => 8,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!doctype html>
<html lang=\"en\">
  <head>
    <meta charset=\"utf-8\" />
    <meta content=\"width=device-width, initial-scale=1\" name=\"viewport\" />
    <title>Kapétolyo Coffee &amp; Bakehouse</title>
    
    <link href=\"{{base_url}}public/style/style.css\" rel=\"stylesheet\"/>
  </head>
  <body>
    {% include \x27components/header.twig\x27 %}
    <section class=\"hero\">
      <div class=\"hero-inner\">
        <div class=\"hero-copy\">
          <span class=\"kicker\"> Your neighborhood cup, made better. </span>
          <h1>
            Slow mornings.
            <br />
            <em> Great coffee. </em>
          </h1>
          <p>
            Thoughtfully sourced beans, comforting bakes, and handcrafted
            drinks—made fresh for your everyday rituals.
          </p>
          <div class=\"hero-actions\">
            <a class=\"primary\" href=\"/#menu\"> Explore our menu → </a>
            <a class=\"text-link\" href=\"/#about\"> Our story </a>
          </div>
          <div class=\"hero-trust\">
            <span>
            <i> </i>
            <span>
              <b> 15 min </b>
              average pickup
            </span>
            <i> </i>
            <span>
              <b> Fresh </b>
              daily
            </span>
          </div>
        </div>
        <div class=\"hero-image\">
          <img
            alt=\"Cappuccino\"
            src=\"https://images.unsplash.com/photo-1753727470826-584b80850a3c?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;q=85&amp;w=1200\"
          />
          <div class=\"floating-card\">
            <span> Start your day with</span>
            <b> Spanish Latte </b>
            <small> Silky, sweet, perfectly balanced </small>
          </div>
        </div>
      </div>
    </section>
    <section class=\"section\">
      <div class=\"section-heading\">
        <div>
          <span class=\"kicker\"> Find your favorite </span>
          <h2>What are you craving?</h2>
        </div>
        <a class=\"text-link\" href=\"/#menu\"> View full menu → </a>
      </div>
      <div class=\"category-grid\">
        <a class=\"category-card\" href=\"/#menu\">
          <span class=\"cat-icon\"> ○ </span>
          <span>
            <b> Coffee </b>
            <small> Freshly pulled </small>
          </span>
          ›
        </a>
        <a class=\"category-card\" href=\"/#menu\">
          <span class=\"cat-icon\"> ○ </span>
          <span>
            <b> Non-Coffee </b>
            <small> Smooth &amp; cozy </small>
          </span>
          ›
        </a>
        <a class=\"category-card\" href=\"/#menu\">
          <span class=\"cat-icon\"> ○ </span>
          <span>
            <b> Tea </b>
            <small> Calm in a cup </small>
          </span>
          ›
        </a>
        <a class=\"category-card\" href=\"/#menu\">
          <span class=\"cat-icon\"> ◇ </span>
          <span>
            <b> Pastries </b>
            <small> Baked this morning </small>
          </span>
          ›
        </a>
      </div>
    </section>
    <section class=\"section\" id=\"menu\">
      <div class=\"section-heading\">
        <div>
          <span class=\"kicker\"> Made with care </span>
          <h2>Most-loved picks</h2>
          <p>The drinks and treats our regulars always come back for.</p>
        </div>
        <a class=\"outline\" href=\"/#menu\"> Browse all </a>
      </div>
      <div class=\"product-grid\">
      {% for product in products %}
        <article class=\"product-card\">
          <a class=\"product-photo\" href=\"/product/{{product.id}}\">
          {% if product.images is not empty %}
                  <img
                      alt=\"{{ product.product_name }}\"
                      src=\"{{ base_url }}{{ product.images[0].image_path }}\"
                  />
          {% endif %}
            {% if product.availability != \x27Available\x27 %}
            <span class=\"photo-badge\"> Unavailable </span>
            {% endif %}
            <span class=\"heart\"> ♡ </span>
          </a>
          <div class=\"product-info\">
            <div class=\"eyebrow-row\">
              <span> {{ product.category }} </span>
              <!-- <span class=\"rating\"> ★ 4.9 </span> -->
            </div>
            <h3>{{ product.product_name }}</h3>
            <p>{{ product.description }}</p>
            <div class=\"product-bottom\">
              <strong> ₱{{ product.base_price|number_format(2) }} </strong>
              <a class=\"add-circle\" href=\"/product/{{ product.id }}\" aria-label=\"Choose options for {{ product.product_name }}\"> + </a>
            </div>
          </div>
        </article>
        {% else %}
        <h3>No Product found</h3>
    {% endfor %}
      </div>
    </section>
    <section class=\"story\" id=\"about\">
      <div class=\"story-image\">
        <img
          alt=\"Fresh coffee\"
          src=\"https://images.unsplash.com/photo-1587982708730-ffc82d18e9fc?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;q=85&amp;w=1200\"
        />
        <span class=\"story-stamp\">
          ROASTED
          <br />
          WITH CARE
        </span>
      </div>
      <div class=\"story-copy\">
        <span class=\"kicker\"> A little about us </span>
        <h2>
          Good coffee brings
          <br />
          good people together.
        </h2>
        <p>
          Kapétolyo started with a simple belief: your daily cup should feel
          special. We work with local roasters and bakers to serve honest
          flavors, warm hospitality, and a pause worth taking.
        </p>
        <div class=\"story-stats\">
          <div>
            <b> 100% </b>
            <span> Locally roasted beans </span>
          </div>
          <div>
            <b> 2021 </b>
            <span> Serving the community </span>
          </div>
        </div>
        <a class=\"text-link\" href=\"/#about\"> Read our story → </a>
      </div>
    </section>
    <section class=\"visit\" id=\"visit\">
      <div>
        <span class=\"kicker\"> Come say hello </span>
        <h2>Your corner for coffee &amp; calm.</h2>
        <p>Open daily · 7:00 AM – 9:00 PM</p>
      </div>
      <div class=\"visit-details\">
        <div>
          <small> FIND US </small>
          <b> 18 Mabini Street, Quezon City </b>
        </div>
        <div>
          <small> CALL AHEAD </small>
          <b> 0917 843 2024 </b>
        </div>
        <a class=\"cream-button\" href=\"/#visit\"> Get directions → </a>
      </div>
    </section>
            {% include \x27components/footer.twig\x27 %}
    <script type=\"module\" src=\"{{base_url}}public/js/main.js\"></script>
  </body>
</html>
", "home.twig", "/opt/lampp/htdocs/final-project/app/views/home.twig");
    }
}
