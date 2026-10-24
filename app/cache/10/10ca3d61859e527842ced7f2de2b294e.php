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

/* product.twig */
class __TwigTemplate_bdd08a30946d5463560c8ee1192676b2 extends Template
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
        yield "
<html lang=\"en\">
  <head>
    <meta charset=\"utf-8\"/>
    <meta content=\"width=device-width, initial-scale=1\" name=\"viewport\"/>
    <title>Kapétolyo Coffee &amp; Bakehouse</title>
    <link href=\"";
        // line 7
        yield (string) $this->escaper->escape(($context["base_url"] ?? null), "html", null, true);
        yield "public/style/style.css\" rel=\"stylesheet\"/>
  </head>
  <body data-page=\"product\">
    ";
        // line 10
        yield from $this->load("/components/header.twig", 10)->unwrap()->yield($context);
        // line 11
        yield "    ";
        // line 12
        yield "    ";
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["products"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["prod"]) {
            // line 13
            yield "      <section class=\"page-shell\" id=\"product\" data-id=\"";
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "id", [], "any", false, false, false, 13), "html", null, true);
            yield "\">
        <a class=\"back-link\" href=\"/\"> ← Back to menu </a>

        <div class=\"detail-layout\" style=\"margin-top: 25px\">
          <div class=\"gallery\">

            ";
            // line 20
            yield "            <div class=\"thumbs\">
              ";
            // line 21
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "images", [], "any", false, false, false, 21));
            $context['loop'] = [
              'parent' => $context['_parent'],
              'index0' => 0,
              'index'  => 1,
              'first'  => true,
            ];
            if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
                $length = count($context['_seq']);
                $context['loop']['revindex0'] = $length - 1;
                $context['loop']['revindex'] = $length;
                $context['loop']['length'] = $length;
                $context['loop']['last'] = 1 === $length;
            }
            foreach ($context['_seq'] as $context["_key"] => $context["image"]) {
                // line 22
                yield "                <button
                  class=\"";
                // line 23
                yield (string) (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "first", [], "any", false, false, false, 23)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("selected") : (""));
                yield "\"
                  aria-pressed=\"";
                // line 24
                yield (string) (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "first", [], "any", false, false, false, 24)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("true") : ("false"));
                yield "\"
                  type=\"button\"
                >
                  <img
                    src=\"/";
                // line 28
                yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["image"], "image_path", [], "any", false, false, false, 28), "html", null, true);
                yield "\"
                    alt=\"";
                // line 29
                yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "product_name", [], "any", false, false, false, 29), "html", null, true);
                yield "\"
                  />
                </button>
                      
              ";
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
                if (isset($context['loop']['revindex0'], $context['loop']['revindex'])) {
                    --$context['loop']['revindex0'];
                    --$context['loop']['revindex'];
                    $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['image'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent);
            $context += $_parent;
            // line 34
            yield "            </div>

            ";
            // line 37
            yield "            <div class=\"main-photo\">
              <img
                    src=\"/";
            // line 39
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, (($_v0 = CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "images", [], "any", false, false, false, 39)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[0] ?? null) : null), "image_path", [], "any", false, false, false, 39), "html", null, true);
            yield "\"
                    alt=\"";
            // line 40
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "product_name", [], "any", false, false, false, 40), "html", null, true);
            yield "\"
                  />
            </div>

          </div>
        </div>

        <div class=\"detail-copy\">
          <span class=\"kicker\"> ";
            // line 48
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "category", [], "any", false, false, false, 48), "html", null, true);
            yield " </span>
          <h1>";
            // line 49
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "product_name", [], "any", false, false, false, 49), "html", null, true);
            yield "</h1>
          <!-- <div class=\"detail-rating\">
            <span> ★★★★★ </span>
            <b> 4.9 </b>
            <u> 128 reviews </u>
          </div> -->
          <p>
            ";
            // line 56
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "description", [], "any", false, false, false, 56), "html", null, true);
            yield "
          </p>
          <strong class=\"detail-price\"> ₱";
            // line 58
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "base_price", [], "any", false, false, false, 58), "html", null, true);
            yield " </strong>
          <span class=\"stock\"> ● In stock · Ready in 10~15 min </span>
          <div class=\"option-block\">
            
            <form action=\"/addToCart/";
            // line 62
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "id", [], "any", false, false, false, 62), "html", null, true);
            yield "\" method=\"POST\" data-cart-form data-base-price=\"";
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "base_price", [], "any", false, false, false, 62), "html", null, true);
            yield "\">
            ";
            // line 64
            yield "            <h4>
              Choose a variants
              <small>Required</small>
            </h4>

            <div class=\"option-block\">
              <h4>Variants</h4>

              <div class=\"option-grid\" id=\"productRadioVariant\">
                ";
            // line 73
            $context["variantSelected"] = false;
            // line 74
            yield "                ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "variants", [], "any", false, false, false, 74));
            $context['_iterated'] = false;
            foreach ($context['_seq'] as $context["_key"] => $context["variant"]) {
                // line 75
                yield "                  <label class=\"option\">

                    ";
                // line 78
                yield "                    <input
                      type=\"radio\"
                      name=\"variant_id\"
                      value=\"";
                // line 81
                yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["variant"], "id", [], "any", false, false, false, 81), "html", null, true);
                yield "\"
                      ";
                // line 82
                if (( !(($tmp = ($context["variantSelected"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp) && (CoreExtension::getAttribute($this->env, $this->source, $context["variant"], "stock_quantity", [], "any", false, false, false, 82) > 0))) {
                    // line 83
                    yield "                        checked
                        ";
                    // line 84
                    $context["variantSelected"] = true;
                    // line 85
                    yield "                      ";
                }
                // line 86
                yield "                      ";
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["variant"], "stock_quantity", [], "any", false, false, false, 86) <= 0)) {
                    yield "disabled";
                }
                // line 87
                yield "                      required
                      data-price=\"";
                // line 88
                yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["variant"], "price", [], "any", false, false, false, 88), "html", null, true);
                yield "\"
                    />

                    <b>";
                // line 91
                yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["variant"], "size_oz", [], "any", false, false, false, 91), "html", null, true);
                yield "</b>

                    <small>
                      ₱";
                // line 94
                yield (string) $this->escaper->escape($this->extensions['Twig\Extension\CoreExtension']->formatNumber(CoreExtension::getAttribute($this->env, $this->source, $context["variant"], "price", [], "any", false, false, false, 94), 2), "html", null, true);
                yield "

                      ";
                // line 96
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["variant"], "stock_quantity", [], "any", false, false, false, 96) <= 0)) {
                    // line 97
                    yield "                        - Out of stock
                      ";
                }
                // line 99
                yield "                    </small>

                  </label>
                ";
                $context['_iterated'] = true;
            }
            // line 102
            if (!$context['_iterated']) {
                // line 103
                yield "                  <p>No sizes available for this product.</p>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['variant'], $context['_parent'], $context['_iterated']);
            $context = array_intersect_key($context, $_parent);
            $context += $_parent;
            // line 105
            yield "              </div>
            </div>
            ";
            // line 108
            yield "          ";
            // line 109
            yield "          ";
            if (((CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "category", [], "any", false, false, false, 109) == "Coffee") || (CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "category", [], "any", false, false, false, 109) == "Iced-Coffee"))) {
                // line 110
                yield "            ";
                // line 111
                yield "            <div class=\"option-block\">            
                  <h4>Milk preference</h4>

                  <div class=\"option-grid\" id=\"productRadioMilk\">
                    ";
                // line 115
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(($context["milk_options"] ?? null));
                $context['loop'] = [
                  'parent' => $context['_parent'],
                  'index0' => 0,
                  'index'  => 1,
                  'first'  => true,
                ];
                if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
                    $length = count($context['_seq']);
                    $context['loop']['revindex0'] = $length - 1;
                    $context['loop']['revindex'] = $length;
                    $context['loop']['length'] = $length;
                    $context['loop']['last'] = 1 === $length;
                }
                foreach ($context['_seq'] as $context["_key"] => $context["milk"]) {
                    // line 116
                    yield "                    <label class=\"option\">
                      <input type=\"radio\" name=\"milk_preference\" value=\"";
                    // line 117
                    yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["milk"], "value", [], "any", false, false, false, 117), "html", null, true);
                    yield "\" data-price=\"";
                    yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["milk"], "price", [], "any", false, false, false, 117), "html", null, true);
                    yield "\" ";
                    if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "first", [], "any", false, false, false, 117)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                        yield "checked";
                    }
                    yield " />
                      <b>";
                    // line 118
                    yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["milk"], "label", [], "any", false, false, false, 118), "html", null, true);
                    yield "</b>
                      ";
                    // line 119
                    if ((CoreExtension::getAttribute($this->env, $this->source, $context["milk"], "price", [], "any", false, false, false, 119) == 0)) {
                        // line 120
                        yield "                      <small>No additional cost</small>
                      ";
                    } else {
                        // line 122
                        yield "                      <small>+ ₱";
                        yield (string) $this->escaper->escape($this->extensions['Twig\Extension\CoreExtension']->formatNumber(CoreExtension::getAttribute($this->env, $this->source, $context["milk"], "price", [], "any", false, false, false, 122), 2), "html", null, true);
                        yield "</small>
                      ";
                    }
                    // line 124
                    yield "                    </label>
                    ";
                    ++$context['loop']['index0'];
                    ++$context['loop']['index'];
                    $context['loop']['first'] = false;
                    if (isset($context['loop']['revindex0'], $context['loop']['revindex'])) {
                        --$context['loop']['revindex0'];
                        --$context['loop']['revindex'];
                        $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                    }
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['milk'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent);
                $context += $_parent;
                // line 126
                yield "                  </div>
                </div>
                
                <div class=\"custom-row\">
                  <label>
                    Sugar level
                    <select id=\"sugarLevel\" name=\"sugar_level\">
                      <option value =\"100\">100% - Regular</option>
                      <option value =\"75\">75% - Less sweet</option>
                      <option value =\"50\">50% - Half sweet</option>
                      <option value =\"0\">0% - No sugar</option>
                    </select>
                  </label>
            ";
                // line 139
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "category", [], "any", false, false, false, 139) == "Iced-Coffee")) {
                    // line 140
                    yield "                  <label>
                    Ice level
                    <select>
                      <option>Regular ice</option>
                      <option>Less ice</option>
                      <option>No ice</option>
                    </select>
                  </label>
            ";
                }
                // line 149
                yield "              
                </div>

            ";
            }
            // line 153
            yield "            ";
            // line 154
            yield "           
            ";
            // line 156
            yield "            <div class=\"addons\">
              <h4>Add-ons</h4>

              ";
            // line 159
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "addons", [], "any", false, false, false, 159));
            $context['_iterated'] = false;
            foreach ($context['_seq'] as $context["_key"] => $context["addon"]) {
                // line 160
                yield "                <label class=\"addon\">

                  <input
                    type=\"checkbox\"
                    name=\"addon_ids[]\"
                    value=\"";
                // line 165
                yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["addon"], "id", [], "any", false, false, false, 165), "html", null, true);
                yield "\"
                    data-price=\"";
                // line 166
                yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["addon"], "addon_price", [], "any", false, false, false, 166), "html", null, true);
                yield "\"
                  />

                  <span>
                    <b>";
                // line 170
                yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["addon"], "addon_name", [], "any", false, false, false, 170), "html", null, true);
                yield "</b>
                  </span>

                  <strong>
                    + ₱";
                // line 174
                yield (string) $this->escaper->escape($this->extensions['Twig\Extension\CoreExtension']->formatNumber(CoreExtension::getAttribute($this->env, $this->source, $context["addon"], "addon_price", [], "any", false, false, false, 174), 2), "html", null, true);
                yield "
                  </strong>

                </label>
              ";
                $context['_iterated'] = true;
            }
            // line 178
            if (!$context['_iterated']) {
                // line 179
                yield "                <p>No add-ons available for this product.</p>
              ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['addon'], $context['_parent'], $context['_iterated']);
            $context = array_intersect_key($context, $_parent);
            $context += $_parent;
            // line 181
            yield "            </div>

            ";
            // line 187
            yield "            <div class=\"add-row\">
              <div class=\"quantity\">
                <button type = \"button\" id=\"minusButton\">−</button>
                <b data-quantity aria-live=\"polite\">1</b>
                <button type = \"button\" id=\"addButton\">+</button>
              </div>

              <input type=\"hidden\" name=\"quantity\" value=\"1\">
              <input type=\"hidden\" name=\"totalPrice\" value=\"";
            // line 195
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "base_price", [], "any", false, false, false, 195), "html", null, true);
            yield "\" id=\"inputTotalPrice\">
              <input type=\"submit\" value=\"Add to Cart &#8369;";
            // line 196
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "base_price", [], "any", false, false, false, 196), "html", null, true);
            yield "\" class = \"primary grow\" data-totalprice=\"";
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "base_price", [], "any", false, false, false, 196), "html", null, true);
            yield "\" id=\"totalPriceHandler\">
              ";
            // line 198
            yield "            </div>
            <p data-cart-status role=\"status\" aria-live=\"polite\"></p>
            </form>
          </div>
        </div>
        <!-- <div class=\"reviews\">
        <div class=\"section-heading\">
          <div>
            <span class=\"kicker\"> WHAT PEOPLE SAY </span>
            <h2>Customer reviews</h2>
          </div>
          <button class=\"outline\">Write a review</button>
        </div>
        <div class=\"review-grid\">
          <div class=\"rating-summary\">
            <b> 4.9 </b>
            <span> ★★★★★ </span>
            <p>Based on 128 verified orders</p>
          </div>
          <article class=\"review\">
            <div>
              <span class=\"avatar\"> M </span>
              <b> Mika R. </b>
              <small> Verified purchase </small>
            </div>
            <span class=\"stars\"> ★★★★★ </span>
            <p>
              My go-to order! Creamy without being too sweet, and the espresso
              still comes through.
            </p>
            <time> 2 days ago </time>
          </article>
          <article class=\"review\">
            <div>
              <span class=\"avatar\"> P </span>
              <b> Paolo D. </b>
              <small> Verified purchase </small>
            </div>
            <span class=\"stars\"> ★★★★★ </span>
            <p>
              Ordered it with oat milk and an extra shot. It was ready right on
              time.
            </p>
            <time> 1 week ago </time>
          </article>
        </div>
      </div> -->
      </section>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['prod'], $context['_parent']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 247
        yield "    ";
        yield from $this->load("/components/footer.twig", 247)->unwrap()->yield($context);
        // line 248
        yield "    <script type=\"module\" src=\"";
        yield (string) $this->escaper->escape(($context["base_url"] ?? null), "html", null, true);
        yield "public/js/main.js\"></script>
    ";
        // line 250
        yield "  </body>
</html>
";
        return; yield;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "product.twig";
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
        return array (  542 => 250,  537 => 248,  534 => 247,  479 => 198,  473 => 196,  469 => 195,  459 => 187,  455 => 181,  447 => 179,  445 => 178,  436 => 174,  429 => 170,  422 => 166,  418 => 165,  411 => 160,  406 => 159,  401 => 156,  398 => 154,  396 => 153,  390 => 149,  379 => 140,  377 => 139,  362 => 126,  346 => 124,  340 => 122,  336 => 120,  334 => 119,  330 => 118,  320 => 117,  317 => 116,  300 => 115,  294 => 111,  292 => 110,  289 => 109,  287 => 108,  283 => 105,  275 => 103,  273 => 102,  266 => 99,  262 => 97,  260 => 96,  255 => 94,  249 => 91,  243 => 88,  240 => 87,  235 => 86,  232 => 85,  230 => 84,  227 => 83,  225 => 82,  221 => 81,  216 => 78,  212 => 75,  206 => 74,  204 => 73,  193 => 64,  187 => 62,  180 => 58,  175 => 56,  165 => 49,  161 => 48,  150 => 40,  146 => 39,  142 => 37,  138 => 34,  118 => 29,  114 => 28,  107 => 24,  103 => 23,  100 => 22,  83 => 21,  80 => 20,  70 => 13,  65 => 12,  63 => 11,  61 => 10,  55 => 7,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("
<html lang=\"en\">
  <head>
    <meta charset=\"utf-8\"/>
    <meta content=\"width=device-width, initial-scale=1\" name=\"viewport\"/>
    <title>Kapétolyo Coffee &amp; Bakehouse</title>
    <link href=\"{{ base_url }}public/style/style.css\" rel=\"stylesheet\"/>
  </head>
  <body data-page=\"product\">
    {% include \x27/components/header.twig\x27 %}
    {# <?php include(\x27../components/header.php\x27);?> #}
    {% for prod in products %}
      <section class=\"page-shell\" id=\"product\" data-id=\"{{prod.id}}\">
        <a class=\"back-link\" href=\"/\"> ← Back to menu </a>

        <div class=\"detail-layout\" style=\"margin-top: 25px\">
          <div class=\"gallery\">

            {# Product thumbnails #}
            <div class=\"thumbs\">
              {% for image in prod.images %}
                <button
                  class=\"{{ loop.first ? \x27selected\x27 : \x27\x27 }}\"
                  aria-pressed=\"{{ loop.first ? \x27true\x27 : \x27false\x27 }}\"
                  type=\"button\"
                >
                  <img
                    src=\"/{{ image.image_path }}\"
                    alt=\"{{ prod.product_name }}\"
                  />
                </button>
                      
              {% endfor %}
            </div>

            {# Main product image #}
            <div class=\"main-photo\">
              <img
                    src=\"/{{ prod.images[0].image_path }}\"
                    alt=\"{{ prod.product_name }}\"
                  />
            </div>

          </div>
        </div>

        <div class=\"detail-copy\">
          <span class=\"kicker\"> {{ prod.category }} </span>
          <h1>{{ prod.product_name }}</h1>
          <!-- <div class=\"detail-rating\">
            <span> ★★★★★ </span>
            <b> 4.9 </b>
            <u> 128 reviews </u>
          </div> -->
          <p>
            {{ prod.description }}
          </p>
          <strong class=\"detail-price\"> ₱{{ prod.base_price }} </strong>
          <span class=\"stock\"> ● In stock · Ready in 10~15 min </span>
          <div class=\"option-block\">
            
            <form action=\"/addToCart/{{prod.id}}\" method=\"POST\" data-cart-form data-base-price=\"{{ prod.base_price }}\">
            {# Size chooser #}
            <h4>
              Choose a variants
              <small>Required</small>
            </h4>

            <div class=\"option-block\">
              <h4>Variants</h4>

              <div class=\"option-grid\" id=\"productRadioVariant\">
                {% set variantSelected = false %}
                {% for variant in prod.variants %}
                  <label class=\"option\">

                    {# <input type=\"hidden\" name=\"\" value=\"{{variant.price}}\"> #}
                    <input
                      type=\"radio\"
                      name=\"variant_id\"
                      value=\"{{ variant.id }}\"
                      {% if not variantSelected and variant.stock_quantity > 0 %}
                        checked
                        {% set variantSelected = true %}
                      {% endif %}
                      {% if variant.stock_quantity <= 0 %}disabled{% endif %}
                      required
                      data-price=\"{{variant.price}}\"
                    />

                    <b>{{ variant.size_oz }}</b>

                    <small>
                      ₱{{ variant.price|number_format(2) }}

                      {% if variant.stock_quantity <= 0 %}
                        - Out of stock
                      {% endif %}
                    </small>

                  </label>
                {% else %}
                  <p>No sizes available for this product.</p>
                {% endfor %}
              </div>
            </div>
            {# end size chooser #}
          {# my overlooked fix later #}
          {% if prod.category == \x27Coffee\x27 or prod.category == \x27Iced-Coffee\x27 %}
            {# <h1>hi!!</h1> #}
            <div class=\"option-block\">            
                  <h4>Milk preference</h4>

                  <div class=\"option-grid\" id=\"productRadioMilk\">
                    {% for milk in milk_options %}
                    <label class=\"option\">
                      <input type=\"radio\" name=\"milk_preference\" value=\"{{ milk.value }}\" data-price=\"{{ milk.price }}\" {% if loop.first %}checked{% endif %} />
                      <b>{{ milk.label }}</b>
                      {% if milk.price == 0 %}
                      <small>No additional cost</small>
                      {% else %}
                      <small>+ ₱{{ milk.price|number_format(2) }}</small>
                      {% endif %}
                    </label>
                    {% endfor %}
                  </div>
                </div>
                
                <div class=\"custom-row\">
                  <label>
                    Sugar level
                    <select id=\"sugarLevel\" name=\"sugar_level\">
                      <option value =\"100\">100% - Regular</option>
                      <option value =\"75\">75% - Less sweet</option>
                      <option value =\"50\">50% - Half sweet</option>
                      <option value =\"0\">0% - No sugar</option>
                    </select>
                  </label>
            {% if prod.category == \x27Iced-Coffee\x27 %}
                  <label>
                    Ice level
                    <select>
                      <option>Regular ice</option>
                      <option>Less ice</option>
                      <option>No ice</option>
                    </select>
                  </label>
            {% endif %}
              
                </div>

            {% endif %}
            {# end overlooked #}
           
            {# Custom add-ons #}
            <div class=\"addons\">
              <h4>Add-ons</h4>

              {% for addon in prod.addons %}
                <label class=\"addon\">

                  <input
                    type=\"checkbox\"
                    name=\"addon_ids[]\"
                    value=\"{{ addon.id }}\"
                    data-price=\"{{ addon.addon_price }}\"
                  />

                  <span>
                    <b>{{ addon.addon_name }}</b>
                  </span>

                  <strong>
                    + ₱{{ addon.addon_price|number_format(2) }}
                  </strong>

                </label>
              {% else %}
                <p>No add-ons available for this product.</p>
              {% endfor %}
            </div>

            {# <label class=\"notes\">
              Order notes
              <textarea placeholder=\"Any special requests?\"></textarea>
            </label> #}
            <div class=\"add-row\">
              <div class=\"quantity\">
                <button type = \"button\" id=\"minusButton\">−</button>
                <b data-quantity aria-live=\"polite\">1</b>
                <button type = \"button\" id=\"addButton\">+</button>
              </div>

              <input type=\"hidden\" name=\"quantity\" value=\"1\">
              <input type=\"hidden\" name=\"totalPrice\" value=\"{{prod.base_price}}\" id=\"inputTotalPrice\">
              <input type=\"submit\" value=\"Add to Cart &#8369;{{prod.base_price}}\" class = \"primary grow\" data-totalprice=\"{{prod.base_price}}\" id=\"totalPriceHandler\">
              {# <button class=\"wish\">♡</button> #}
            </div>
            <p data-cart-status role=\"status\" aria-live=\"polite\"></p>
            </form>
          </div>
        </div>
        <!-- <div class=\"reviews\">
        <div class=\"section-heading\">
          <div>
            <span class=\"kicker\"> WHAT PEOPLE SAY </span>
            <h2>Customer reviews</h2>
          </div>
          <button class=\"outline\">Write a review</button>
        </div>
        <div class=\"review-grid\">
          <div class=\"rating-summary\">
            <b> 4.9 </b>
            <span> ★★★★★ </span>
            <p>Based on 128 verified orders</p>
          </div>
          <article class=\"review\">
            <div>
              <span class=\"avatar\"> M </span>
              <b> Mika R. </b>
              <small> Verified purchase </small>
            </div>
            <span class=\"stars\"> ★★★★★ </span>
            <p>
              My go-to order! Creamy without being too sweet, and the espresso
              still comes through.
            </p>
            <time> 2 days ago </time>
          </article>
          <article class=\"review\">
            <div>
              <span class=\"avatar\"> P </span>
              <b> Paolo D. </b>
              <small> Verified purchase </small>
            </div>
            <span class=\"stars\"> ★★★★★ </span>
            <p>
              Ordered it with oat milk and an extra shot. It was ready right on
              time.
            </p>
            <time> 1 week ago </time>
          </article>
        </div>
      </div> -->
      </section>
    {% endfor %}
    {% include \x27/components/footer.twig\x27 %}
    <script type=\"module\" src=\"{{base_url}}public/js/main.js\"></script>
    {# <script type=\"module\" src=\"../js/main.js\"></script> #}
  </body>
</html>
", "product.twig", "/opt/lampp/htdocs/final-project/app/views/product.twig");
    }
}
