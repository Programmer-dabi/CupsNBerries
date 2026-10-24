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

/* cart.twig */
class __TwigTemplate_66a545f9a42891dd82d73e56d0f99359 extends Template
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
        // line 7
        yield (string) $this->escaper->escape(($context["base_url"] ?? null), "html", null, true);
        yield "public/style/style.css\" rel=\"stylesheet\" />
  </head>
  <body>
    ";
        // line 10
        yield from $this->load("components/header.twig", 10)->unwrap()->yield($context);
        // line 11
        yield "    <section class=\"page-shell\" id=\"cart\">
      <div class=\"page-title compact\">
        <span class=\"kicker\"> YOUR ORDER </span>
        <h1>Shopping cart</h1>
        <p data-cart-summary-count>";
        // line 15
        yield (string) $this->escaper->escape(($context["cart_count"] ?? null), "html", null, true);
        yield " ";
        yield (string) (((($context["cart_count"] ?? null) == 1)) ? ("item") : ("items"));
        yield " waiting for you</p>
        <p data-cart-update-status role=\"status\" aria-live=\"polite\"></p>
        ";
        // line 17
        if ((($tmp = ($context["cart_error"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 18
            yield "        <p role=\"alert\">";
            yield (string) $this->escaper->escape(($context["cart_error"] ?? null), "html", null, true);
            yield "</p>
        ";
        }
        // line 20
        yield "      </div>
      <div class=\"cart-layout\">
        <div class=\"cart-list\">
          ";
        // line 23
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["items"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["key"] => $context["item"]) {
            // line 24
            yield "          <article class=\"cart-item\" data-cart-item=\"";
            yield (string) $this->escaper->escape($context["key"], "html", null, true);
            yield "\">
            ";
            // line 25
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["item"], "image_path", [], "any", false, false, false, 25)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 26
                yield "            <img
              alt=\"";
                // line 27
                yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "product_name", [], "any", false, false, false, 27), "html", null, true);
                yield "\"
              src=\"";
                // line 28
                yield (string) $this->escaper->escape(($context["base_url"] ?? null), "html", null, true);
                yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "image_path", [], "any", false, false, false, 28), "html", null, true);
                yield "\"
            />
            ";
            } else {
                // line 31
                yield "            <span aria-hidden=\"true\"></span>
            ";
            }
            // line 33
            yield "            <div class=\"cart-item-info\">
              <span>";
            // line 34
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "category", [], "any", false, false, false, 34), "html", null, true);
            yield "</span>
              <h3><a href=\"/product/";
            // line 35
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "product_id", [], "any", false, false, false, 35), "html", null, true);
            yield "\">";
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "product_name", [], "any", false, false, false, 35), "html", null, true);
            yield "</a></h3>
              <p>
                ";
            // line 37
            yield (string) (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["item"], "variant_label", [], "any", false, false, false, 37)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "variant_label", [], "any", false, false, false, 37), "html", null, true)) : ("Standard"));
            yield "
                ";
            // line 38
            if ( !(null === CoreExtension::getAttribute($this->env, $this->source, $context["item"], "milk_preference", [], "any", false, false, false, 38))) {
                yield " · ";
                yield (string) $this->escaper->escape(Twig\Extension\CoreExtension::capitalize($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["item"], "milk_preference", [], "any", false, false, false, 38)), "html", null, true);
                yield " milk";
            }
            // line 39
            yield "                ";
            if ( !(null === CoreExtension::getAttribute($this->env, $this->source, $context["item"], "sugar_level", [], "any", false, false, false, 39))) {
                yield " · ";
                yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "sugar_level", [], "any", false, false, false, 39), "html", null, true);
                yield "% sugar";
            }
            // line 40
            yield "                ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "addons", [], "any", false, false, false, 40));
            foreach ($context['_seq'] as $context["_key"] => $context["addon"]) {
                yield " · ";
                yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["addon"], "name", [], "any", false, false, false, 40), "html", null, true);
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['addon'], $context['_parent']);
            $context = array_intersect_key($context, $_parent);
            $context += $_parent;
            // line 41
            yield "              </p>
              <form action=\"/cart/";
            // line 42
            yield (string) $this->escaper->escape($context["key"], "html", null, true);
            yield "/remove\" method=\"POST\">
                <input type=\"hidden\" name=\"csrf_token\" value=\"";
            // line 43
            yield (string) $this->escaper->escape(($context["csrf_token"] ?? null), "html", null, true);
            yield "\" />
                <button type=\"submit\">Remove</button>
              </form>
            </div>
            <div class=\"cart-item-end\">
              <strong data-cart-line-total>₱";
            // line 48
            yield (string) $this->escaper->escape($this->extensions['Twig\Extension\CoreExtension']->formatNumber(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "line_total", [], "any", false, false, false, 48), 2), "html", null, true);
            yield "</strong>
              <form class=\"quantity\" action=\"/cart/";
            // line 49
            yield (string) $this->escaper->escape($context["key"], "html", null, true);
            yield "/quantity\" method=\"POST\" data-cart-quantity-form>
                <input type=\"hidden\" name=\"csrf_token\" value=\"";
            // line 50
            yield (string) $this->escaper->escape(($context["csrf_token"] ?? null), "html", null, true);
            yield "\" />
                <button type=\"submit\" name=\"quantity\" value=\"";
            // line 51
            yield (string) $this->escaper->escape((CoreExtension::getAttribute($this->env, $this->source, $context["item"], "quantity", [], "any", false, false, false, 51) - 1), "html", null, true);
            yield "\" data-quantity-step=\"-1\" aria-label=\"Decrease quantity of ";
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "product_name", [], "any", false, false, false, 51), "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["item"], "quantity", [], "any", false, false, false, 51) <= 1)) {
                yield "disabled";
            }
            yield ">−</button>
                <b data-cart-quantity>";
            // line 52
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "quantity", [], "any", false, false, false, 52), "html", null, true);
            yield "</b>
                <button type=\"submit\" name=\"quantity\" value=\"";
            // line 53
            yield (string) $this->escaper->escape((CoreExtension::getAttribute($this->env, $this->source, $context["item"], "quantity", [], "any", false, false, false, 53) + 1), "html", null, true);
            yield "\" data-quantity-step=\"1\" aria-label=\"Increase quantity of ";
            yield (string) $this->escaper->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "product_name", [], "any", false, false, false, 53), "html", null, true);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["item"], "quantity", [], "any", false, false, false, 53) >= 99)) {
                yield "disabled";
            }
            yield ">+</button>
              </form>
            </div>
          </article>
          ";
            $context['_iterated'] = true;
        }
        // line 57
        if (!$context['_iterated']) {
            // line 58
            yield "          <p>Your cart is empty.</p>
          ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['key'], $context['item'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 60
        yield "          <a class=\"back-link\" href=\"/#menu\"> ← Continue shopping </a>
        </div>
        <aside class=\"summary-card\">
          <h2>Order summary</h2>
          <div>
            <span> Subtotal </span>
            <b data-cart-subtotal> ₱";
        // line 66
        yield (string) $this->escaper->escape($this->extensions['Twig\Extension\CoreExtension']->formatNumber(($context["subtotal"] ?? null), 2), "html", null, true);
        yield " </b>
          </div>
          <div>
            <span> Pickup fee </span>
            <b class=\"green\"> Free </b>
          </div>
          <hr />
          <div class=\"total\">
            <span> Total </span>
            <b data-cart-total> ₱";
        // line 75
        yield (string) $this->escaper->escape($this->extensions['Twig\Extension\CoreExtension']->formatNumber(($context["total"] ?? null), 2), "html", null, true);
        yield " </b>
          </div>
          <small> Taxes are included in listed prices. </small>
          <a
            class=\"primary\"
            href=\"checkout.php\"
            style=\"display: block; text-align: center; margin-top: 15px\">
            Proceed to checkout →
          </a>
          <p class=\"safe-note\">✓ Pay with cash at the counter</p>
        </aside>
      </div>
    </section>
    ";
        // line 88
        yield from $this->load("components/footer.twig", 88)->unwrap()->yield($context);
        // line 89
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
        return "cart.twig";
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
        return array (  266 => 89,  264 => 88,  248 => 75,  236 => 66,  228 => 60,  220 => 58,  218 => 57,  203 => 53,  199 => 52,  189 => 51,  185 => 50,  181 => 49,  177 => 48,  169 => 43,  165 => 42,  162 => 41,  150 => 40,  143 => 39,  137 => 38,  133 => 37,  126 => 35,  122 => 34,  119 => 33,  115 => 31,  108 => 28,  104 => 27,  101 => 26,  99 => 25,  94 => 24,  89 => 23,  84 => 20,  78 => 18,  76 => 17,  69 => 15,  63 => 11,  61 => 10,  55 => 7,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!doctype html>
<html lang=\"en\">
  <head>
    <meta charset=\"utf-8\" />
    <meta content=\"width=device-width, initial-scale=1\" name=\"viewport\" />
    <title>Kapétolyo Coffee &amp; Bakehouse</title>
    <link href=\"{{ base_url }}public/style/style.css\" rel=\"stylesheet\" />
  </head>
  <body>
    {% include \x27components/header.twig\x27 %}
    <section class=\"page-shell\" id=\"cart\">
      <div class=\"page-title compact\">
        <span class=\"kicker\"> YOUR ORDER </span>
        <h1>Shopping cart</h1>
        <p data-cart-summary-count>{{ cart_count }} {{ cart_count == 1 ? \x27item\x27 : \x27items\x27 }} waiting for you</p>
        <p data-cart-update-status role=\"status\" aria-live=\"polite\"></p>
        {% if cart_error %}
        <p role=\"alert\">{{ cart_error }}</p>
        {% endif %}
      </div>
      <div class=\"cart-layout\">
        <div class=\"cart-list\">
          {% for key, item in items %}
          <article class=\"cart-item\" data-cart-item=\"{{ key }}\">
            {% if item.image_path %}
            <img
              alt=\"{{ item.product_name }}\"
              src=\"{{ base_url }}{{ item.image_path }}\"
            />
            {% else %}
            <span aria-hidden=\"true\"></span>
            {% endif %}
            <div class=\"cart-item-info\">
              <span>{{ item.category }}</span>
              <h3><a href=\"/product/{{ item.product_id }}\">{{ item.product_name }}</a></h3>
              <p>
                {{ item.variant_label ?: \x27Standard\x27 }}
                {% if item.milk_preference is not null %} · {{ item.milk_preference|capitalize }} milk{% endif %}
                {% if item.sugar_level is not null %} · {{ item.sugar_level }}% sugar{% endif %}
                {% for addon in item.addons %} · {{ addon.name }}{% endfor %}
              </p>
              <form action=\"/cart/{{ key }}/remove\" method=\"POST\">
                <input type=\"hidden\" name=\"csrf_token\" value=\"{{ csrf_token }}\" />
                <button type=\"submit\">Remove</button>
              </form>
            </div>
            <div class=\"cart-item-end\">
              <strong data-cart-line-total>₱{{ item.line_total|number_format(2) }}</strong>
              <form class=\"quantity\" action=\"/cart/{{ key }}/quantity\" method=\"POST\" data-cart-quantity-form>
                <input type=\"hidden\" name=\"csrf_token\" value=\"{{ csrf_token }}\" />
                <button type=\"submit\" name=\"quantity\" value=\"{{ item.quantity - 1 }}\" data-quantity-step=\"-1\" aria-label=\"Decrease quantity of {{ item.product_name }}\" {% if item.quantity <= 1 %}disabled{% endif %}>−</button>
                <b data-cart-quantity>{{ item.quantity }}</b>
                <button type=\"submit\" name=\"quantity\" value=\"{{ item.quantity + 1 }}\" data-quantity-step=\"1\" aria-label=\"Increase quantity of {{ item.product_name }}\" {% if item.quantity >= 99 %}disabled{% endif %}>+</button>
              </form>
            </div>
          </article>
          {% else %}
          <p>Your cart is empty.</p>
          {% endfor %}
          <a class=\"back-link\" href=\"/#menu\"> ← Continue shopping </a>
        </div>
        <aside class=\"summary-card\">
          <h2>Order summary</h2>
          <div>
            <span> Subtotal </span>
            <b data-cart-subtotal> ₱{{ subtotal|number_format(2) }} </b>
          </div>
          <div>
            <span> Pickup fee </span>
            <b class=\"green\"> Free </b>
          </div>
          <hr />
          <div class=\"total\">
            <span> Total </span>
            <b data-cart-total> ₱{{ total|number_format(2) }} </b>
          </div>
          <small> Taxes are included in listed prices. </small>
          <a
            class=\"primary\"
            href=\"checkout.php\"
            style=\"display: block; text-align: center; margin-top: 15px\">
            Proceed to checkout →
          </a>
          <p class=\"safe-note\">✓ Pay with cash at the counter</p>
        </aside>
      </div>
    </section>
    {% include \x27components/footer.twig\x27 %}
    <script type=\"module\" src=\"{{ base_url }}public/js/main.js\"></script>
  </body>
</html>
", "cart.twig", "/opt/lampp/htdocs/final-project/app/views/cart.twig");
    }
}
