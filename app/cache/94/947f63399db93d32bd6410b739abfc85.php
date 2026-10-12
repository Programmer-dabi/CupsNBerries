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

/* addproduct.twig */
class __TwigTemplate_cbec2b86b68bf74a957dfdd82c35bb28 extends Template
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
        yield "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Document</title>
     <link href=\"";
        // line 7
        yield (string) $this->escaper->escape(($context["base_url"] ?? null), "html", null, true);
        yield "public/style/style.css\" rel=\"stylesheet\"/>
</head>
<body>
    <section class=\"page-shell\" id=\"product-modal\">
      <div class=\"panel\">
        <h2>Add new product</h2>
        <p>Create a menu item with pricing, inventory, and options.</p>
        <form action=\"/add\" method=\"POST\" enctype=\"multipart/form-data\">
        <div class=\"modal-fields field-grid\">
          <label>
            Product name
            <input placeholder=\"e.g. Spanish Latte\" name = \"name\">
          </label>
            <label for=\"category\">Category
            <select id=\"category\" name=\"category\" required>
                <option value=\"\">Select category</option>
                <option value=\"Coffee\">Coffee</option>
                <option value=\"Iced-Coffee\">Iced-Coffee</option>
                <option value=\"Tea\">Tea</option>
                <option value=\"Pastries\">Pastries</option>
                <option value=\"Desserts\">Desserts</option>
            </select>
            </label>
          <label class=\"full\">
            Description
            <textarea
              placeholder=\"Briefly describe the product and its ingredients.\"
              name=\"description\"
            ></textarea>
          </label>
          <label>
            Base price
            <input min=\"1\" placeholder=\"0.00\" type=\"number\" name = \"price\">
          </label>
          <!-- <label>
            Stock quantity
            <input min=\"0\" placeholder=\"0\" type=\"number\" />
          </label>
          <label>
            SKU
            <input placeholder=\"KP-0010\" />
          </label> -->
          <label>
            Availability
            <select>
              <option>Available</option>
              <option>Unavailable</option>
            </select>
          </label>
          <label>
            Images
            <div id=\"fileDropper\">
              <input type=\"file\" name=\"image1\" id=\"\" accept=\"image/*\">
              <input type=\"file\" name=\"image2\" id=\"\" accept=\"image/*\">
              <input type=\"file\" name=\"image3\" id=\"\" accept=\"image/*\">
            </div>
          </label>
        </div>

           <div id=\"variantsSection\" hidden>
                <h3>Product variants</h3>

                <div class=\"admin-table\">
                    <div class=\"admin-tr admin-header\">
                    <span>Size (oz)</span>
                    <span>Price</span>
                    <span>Stock</span>
                    <span>Action</span>
                    </div>

                    <div id=\"variantList\">
                    <!-- JavaScript inserts .admin-tr rows here -->
                    </div>
                </div>

                <button type=\"button\" id=\"addVariant\">
                    + Add variant
                </button>
            </div>


          <h3>Optional add-ons</h3>

          <div id=\"addonList\" class=\"addon-list\">

           
          </div>

          <button type=\"button\" id=\"addAddon\">
            + Add add-on
          </button>

        <input type=\"submit\" value=\"Add product\" class=\"primary\">
      </div>
    </form>

    </section>
    <script type=\"module\" src=\"";
        // line 104
        yield (string) $this->escaper->escape(($context["base_url"] ?? null), "html", null, true);
        yield "public/js/main.js\"></script>

</body>
</html>";
        return; yield;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "addproduct.twig";
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
        return array (  155 => 104,  55 => 7,  47 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Document</title>
     <link href=\"{{base_url}}public/style/style.css\" rel=\"stylesheet\"/>
</head>
<body>
    <section class=\"page-shell\" id=\"product-modal\">
      <div class=\"panel\">
        <h2>Add new product</h2>
        <p>Create a menu item with pricing, inventory, and options.</p>
        <form action=\"/add\" method=\"POST\" enctype=\"multipart/form-data\">
        <div class=\"modal-fields field-grid\">
          <label>
            Product name
            <input placeholder=\"e.g. Spanish Latte\" name = \"name\">
          </label>
            <label for=\"category\">Category
            <select id=\"category\" name=\"category\" required>
                <option value=\"\">Select category</option>
                <option value=\"Coffee\">Coffee</option>
                <option value=\"Iced-Coffee\">Iced-Coffee</option>
                <option value=\"Tea\">Tea</option>
                <option value=\"Pastries\">Pastries</option>
                <option value=\"Desserts\">Desserts</option>
            </select>
            </label>
          <label class=\"full\">
            Description
            <textarea
              placeholder=\"Briefly describe the product and its ingredients.\"
              name=\"description\"
            ></textarea>
          </label>
          <label>
            Base price
            <input min=\"1\" placeholder=\"0.00\" type=\"number\" name = \"price\">
          </label>
          <!-- <label>
            Stock quantity
            <input min=\"0\" placeholder=\"0\" type=\"number\" />
          </label>
          <label>
            SKU
            <input placeholder=\"KP-0010\" />
          </label> -->
          <label>
            Availability
            <select>
              <option>Available</option>
              <option>Unavailable</option>
            </select>
          </label>
          <label>
            Images
            <div id=\"fileDropper\">
              <input type=\"file\" name=\"image1\" id=\"\" accept=\"image/*\">
              <input type=\"file\" name=\"image2\" id=\"\" accept=\"image/*\">
              <input type=\"file\" name=\"image3\" id=\"\" accept=\"image/*\">
            </div>
          </label>
        </div>

           <div id=\"variantsSection\" hidden>
                <h3>Product variants</h3>

                <div class=\"admin-table\">
                    <div class=\"admin-tr admin-header\">
                    <span>Size (oz)</span>
                    <span>Price</span>
                    <span>Stock</span>
                    <span>Action</span>
                    </div>

                    <div id=\"variantList\">
                    <!-- JavaScript inserts .admin-tr rows here -->
                    </div>
                </div>

                <button type=\"button\" id=\"addVariant\">
                    + Add variant
                </button>
            </div>


          <h3>Optional add-ons</h3>

          <div id=\"addonList\" class=\"addon-list\">

           
          </div>

          <button type=\"button\" id=\"addAddon\">
            + Add add-on
          </button>

        <input type=\"submit\" value=\"Add product\" class=\"primary\">
      </div>
    </form>

    </section>
    <script type=\"module\" src=\"{{base_url}}public/js/main.js\"></script>

</body>
</html>", "addproduct.twig", "/opt/lampp/htdocs/final-project/app/views/addproduct.twig");
    }
}
