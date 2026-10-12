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
class __TwigTemplate_d982e49a153943ef34396c2b9667105f extends Template
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
  <body>
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
            yield "      <section class=\"page-shell\" id=\"product\">
        <a class=\"back-link\" href=\"menu.php\"> ← Back to menu </a>

        <div class=\"detail-layout\" style=\"margin-top: 25px\">
          <div class=\"gallery\">

            ";
            // line 20
            yield "            <div class=\"thumbs\">
              ";
            // line 21
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "images", [], "any", false, false, false, 21));
            foreach ($context['_seq'] as $context["_key"] => $context["image"]) {
                // line 22
                yield "                <button
                  class=\"";
                // line 23
                yield (string) (((CoreExtension::getAttribute($this->env, $this->source, $context["image"], "image_order", [], "any", false, false, false, 23) == 1)) ? ("selected") : (""));
                yield "\"
                  type=\"button\"
                >
                  <img
                    src=\"/";
                // line 27
                yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["image"], "image_path", [], "any", false, false, false, 27), "html", null, true);
                yield "\"
                    alt=\"";
                // line 28
                yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "product_name", [], "any", false, false, false, 28), "html", null, true);
                yield "\"
                  />
                </button>
                      
              ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['image'], $context['_parent']);
            $context = array_intersect_key($context, $_parent);
            $context += $_parent;
            // line 33
            yield "            </div>

            ";
            // line 36
            yield "            <div class=\"main-photo\">
              ";
            // line 37
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "images", [], "any", false, false, false, 37));
            foreach ($context['_seq'] as $context["_key"] => $context["image"]) {
                // line 38
                yield "                ";
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["image"], "image_order", [], "any", false, false, false, 38) == 1)) {
                    // line 39
                    yield "                  <img
                    src=\"/";
                    // line 40
                    yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["image"], "image_path", [], "any", false, false, false, 40), "html", null, true);
                    yield "\"
                    alt=\"";
                    // line 41
                    yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "product_name", [], "any", false, false, false, 41), "html", null, true);
                    yield "\"
                  />
                ";
                }
                // line 44
                yield "              ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['image'], $context['_parent']);
            $context = array_intersect_key($context, $_parent);
            $context += $_parent;
            // line 45
            yield "            </div>

          </div>
        </div>

        <div class=\"detail-copy\">
          <span class=\"kicker\"> ";
            // line 51
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "category", [], "any", false, false, false, 51), "html", null, true);
            yield " </span>
          <h1>";
            // line 52
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "product_name", [], "any", false, false, false, 52), "html", null, true);
            yield "</h1>
          <!-- <div class=\"detail-rating\">
            <span> ★★★★★ </span>
            <b> 4.9 </b>
            <u> 128 reviews </u>
          </div> -->
          <p>
            ";
            // line 59
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "description", [], "any", false, false, false, 59), "html", null, true);
            yield "
          </p>
          <strong class=\"detail-price\"> ₱";
            // line 61
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "base_price", [], "any", false, false, false, 61), "html", null, true);
            yield " </strong>
          <span class=\"stock\"> ● In stock · Ready in 10~15 min </span>
          <div class=\"option-block\">
            
            ";
            // line 66
            yield "            <h4>
              Choose a size
              <small>Required</small>
            </h4>

            <div class=\"option-block\">
              <h4>Size</h4>

              <div class=\"option-grid\">
                ";
            // line 75
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "variants", [], "any", false, false, false, 75));
            $context['_iterated'] = false;
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
            foreach ($context['_seq'] as $context["_key"] => $context["variant"]) {
                // line 76
                yield "                  <label class=\"option\">

                    <input
                      type=\"radio\"
                      name=\"size\"
                      value=\"";
                // line 81
                yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["variant"], "id", [], "any", false, false, false, 81), "html", null, true);
                yield "\"
                      ";
                // line 82
                if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "first", [], "any", false, false, false, 82)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    yield "checked";
                }
                // line 83
                yield "                      ";
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["variant"], "stock_quantity", [], "any", false, false, false, 83) <= 0)) {
                    yield "disabled";
                }
                // line 84
                yield "                      required
                    />

                    <b>";
                // line 87
                yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["variant"], "size_oz", [], "any", false, false, false, 87), "html", null, true);
                yield "</b>

                    <small>
                      ₱";
                // line 90
                yield (string) $this->escaper->escape($this->extensions['Twig\Extension\CoreExtension']->formatNumber(CoreExtension::getAttribute($this->env, $this->source, $context["variant"], "price", [], "any", false, false, false, 90), 2), "html", null, true);
                yield "

                      ";
                // line 92
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["variant"], "stock_quantity", [], "any", false, false, false, 92) <= 0)) {
                    // line 93
                    yield "                        - Out of stock
                      ";
                }
                // line 95
                yield "                    </small>

                  </label>
                ";
                $context['_iterated'] = true;
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
                if (isset($context['loop']['revindex0'], $context['loop']['revindex'])) {
                    --$context['loop']['revindex0'];
                    --$context['loop']['revindex'];
                    $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                }
            }
            // line 98
            if (!$context['_iterated']) {
                // line 99
                yield "                  <p>No sizes available for this product.</p>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['variant'], $context['_parent'], $context['_iterated'], $context['loop']);
            $context = array_intersect_key($context, $_parent);
            $context += $_parent;
            // line 101
            yield "              </div>
            </div>
            ";
            // line 104
            yield "          ";
            // line 105
            yield "          ";
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "category", [], "any", false, false, false, 105) == "Coffee")) {
                // line 106
                yield "            ";
                // line 107
                yield "            <div class=\"option-block\">            
                  <h4>Milk preference</h4>

                  <div class=\"option-grid\">
                    <label class=\"option\">
                      <input type=\"radio\" name=\"milk\" value=\"regular\" checked />
                      <b>Regular</b>
                      <small>No additional cost</small>
                    </label>

                    <label class=\"option\">
                      <input type=\"radio\" name=\"milk\" value=\"oat\" />
                      <b>Oat</b>
                      <small>+ ₱25</small>
                    </label>

                    <label class=\"option\">
                      <input type=\"radio\" name=\"milk\" value=\"soy\" />
                      <b>Soy</b>
                      <small>+ ₱20</small>
                    </label>
                  </div>
                </div>
                
                <div class=\"custom-row\">
                  <label>
                    Sugar level
                    <select>
                      <option>100% - Regular</option>
                      <option>75% - Less sweet</option>
                      <option>50% - Half sweet</option>
                      <option>0% - No sugar</option>
                    </select>
                  </label>
            ";
                // line 141
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "category", [], "any", false, false, false, 141) == "Iced-Coffee")) {
                    // line 142
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
                // line 151
                yield "              
                </div>

            ";
            }
            // line 155
            yield "            ";
            // line 156
            yield "           
            ";
            // line 158
            yield "            <div class=\"addons\">
              <h4>Add-ons</h4>

              ";
            // line 161
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["prod"], "addons", [], "any", false, false, false, 161));
            $context['_iterated'] = false;
            foreach ($context['_seq'] as $context["_key"] => $context["addon"]) {
                // line 162
                yield "                <label class=\"addon\">

                  <input
                    type=\"checkbox\"
                    name=\"addons[]\"
                    value=\"";
                // line 167
                yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["addon"], "id", [], "any", false, false, false, 167), "html", null, true);
                yield "\"
                  />

                  <span>
                    <b>";
                // line 171
                yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["addon"], "addon_name", [], "any", false, false, false, 171), "html", null, true);
                yield "</b>
                  </span>

                  <strong>
                    + ₱";
                // line 175
                yield (string) $this->escaper->escape($this->extensions['Twig\Extension\CoreExtension']->formatNumber(CoreExtension::getAttribute($this->env, $this->source, $context["addon"], "addon_price", [], "any", false, false, false, 175), 2), "html", null, true);
                yield "
                  </strong>

                </label>
              ";
                $context['_iterated'] = true;
            }
            // line 179
            if (!$context['_iterated']) {
                // line 180
                yield "                <p>No add-ons available for this product.</p>
              ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['addon'], $context['_parent'], $context['_iterated']);
            $context = array_intersect_key($context, $_parent);
            $context += $_parent;
            // line 182
            yield "            </div>

            <label class=\"notes\">
              Order notes
              <textarea placeholder=\"Any special requests?\"></textarea>
            </label>
            <div class=\"add-row\">
              <div class=\"quantity\">
                <button>−</button>
                <b> 1 </b>
                <button>+</button>
              </div>
              <a class=\"primary grow\" href=\"cart.php\"> Add to cart · ₱145 </a>

              ";
            // line 197
            yield "            </div>
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
        // line 244
        yield "    ";
        yield from $this->load("/components/footer.twig", 244)->unwrap()->yield($context);
        // line 245
        yield "    <script type=\"module\" src=\"";
        yield (string) $this->escaper->escape(($context["base_url"] ?? null), "html", null, true);
        yield "public/js/main.js\"></script>
    ";
        // line 247
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
        return array (  473 => 247,  468 => 245,  465 => 244,  412 => 197,  396 => 182,  388 => 180,  386 => 179,  377 => 175,  370 => 171,  363 => 167,  356 => 162,  351 => 161,  346 => 158,  343 => 156,  341 => 155,  335 => 151,  324 => 142,  322 => 141,  286 => 107,  284 => 106,  281 => 105,  279 => 104,  275 => 101,  267 => 99,  265 => 98,  250 => 95,  246 => 93,  244 => 92,  239 => 90,  233 => 87,  228 => 84,  223 => 83,  219 => 82,  215 => 81,  208 => 76,  190 => 75,  179 => 66,  172 => 61,  167 => 59,  157 => 52,  153 => 51,  145 => 45,  138 => 44,  132 => 41,  128 => 40,  125 => 39,  122 => 38,  118 => 37,  115 => 36,  111 => 33,  99 => 28,  95 => 27,  88 => 23,  85 => 22,  81 => 21,  78 => 20,  70 => 13,  65 => 12,  63 => 11,  61 => 10,  55 => 7,  47 => 1,);
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
  <body>
    {% include \x27/components/header.twig\x27 %}
    {# <?php include(\x27../components/header.php\x27);?> #}
    {% for prod in products %}
      <section class=\"page-shell\" id=\"product\">
        <a class=\"back-link\" href=\"menu.php\"> ← Back to menu </a>

        <div class=\"detail-layout\" style=\"margin-top: 25px\">
          <div class=\"gallery\">

            {# Product thumbnails #}
            <div class=\"thumbs\">
              {% for image in prod.images %}
                <button
                  class=\"{{ image.image_order == 1 ? \x27selected\x27 : \x27\x27 }}\"
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
              {% for image in prod.images %}
                {% if image.image_order == 1 %}
                  <img
                    src=\"/{{ image.image_path }}\"
                    alt=\"{{ prod.product_name }}\"
                  />
                {% endif %}
              {% endfor %}
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
            
            {# Size chooser #}
            <h4>
              Choose a size
              <small>Required</small>
            </h4>

            <div class=\"option-block\">
              <h4>Size</h4>

              <div class=\"option-grid\">
                {% for variant in prod.variants %}
                  <label class=\"option\">

                    <input
                      type=\"radio\"
                      name=\"size\"
                      value=\"{{ variant.id }}\"
                      {% if loop.first %}checked{% endif %}
                      {% if variant.stock_quantity <= 0 %}disabled{% endif %}
                      required
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
          {% if prod.category == \x27Coffee\x27 %}
            {# <h1>hi!!</h1> #}
            <div class=\"option-block\">            
                  <h4>Milk preference</h4>

                  <div class=\"option-grid\">
                    <label class=\"option\">
                      <input type=\"radio\" name=\"milk\" value=\"regular\" checked />
                      <b>Regular</b>
                      <small>No additional cost</small>
                    </label>

                    <label class=\"option\">
                      <input type=\"radio\" name=\"milk\" value=\"oat\" />
                      <b>Oat</b>
                      <small>+ ₱25</small>
                    </label>

                    <label class=\"option\">
                      <input type=\"radio\" name=\"milk\" value=\"soy\" />
                      <b>Soy</b>
                      <small>+ ₱20</small>
                    </label>
                  </div>
                </div>
                
                <div class=\"custom-row\">
                  <label>
                    Sugar level
                    <select>
                      <option>100% - Regular</option>
                      <option>75% - Less sweet</option>
                      <option>50% - Half sweet</option>
                      <option>0% - No sugar</option>
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
                    name=\"addons[]\"
                    value=\"{{ addon.id }}\"
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

            <label class=\"notes\">
              Order notes
              <textarea placeholder=\"Any special requests?\"></textarea>
            </label>
            <div class=\"add-row\">
              <div class=\"quantity\">
                <button>−</button>
                <b> 1 </b>
                <button>+</button>
              </div>
              <a class=\"primary grow\" href=\"cart.php\"> Add to cart · ₱145 </a>

              {# <button class=\"wish\">♡</button> #}
            </div>
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
