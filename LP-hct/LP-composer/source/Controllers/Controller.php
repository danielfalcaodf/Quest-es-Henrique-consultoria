<?php

namespace Source\Controllers;

use NumberFormatter;
use League\Plates\Engine;
use CoffeeCode\Optimizer\Optimizer;
use CoffeeCode\Router\Router;

/**
 * Controller
 */
abstract class Controller
{
    protected $formatter;
    /** @var Engine */
    protected $view;
    /** @var Router */
    protected $router;
    /** @var Optimizer */
    protected $seo;

    /**
     * @param mixed $router
     */
    public function __construct($router)
    {
        $this->formatter = new NumberFormatter('pt_BR',  NumberFormatter::CURRENCY);
        $this->router = $router;
        $this->view = Engine::create(dirname(__DIR__, 2) . "/views", "php");
        $this->view->addData(["router" => $this->router]);

        $this->seo = new Optimizer();
        $this->seo->openGraph(site("name"), site("locale"), "article");
        // ->publisher(SOCIAL["facebook_page"], SOCIAL["facebook_author"])
        // ->twitterCard(SOCIAL["twitter_creator"], SOCIAL["twitter_site"], site("domain"))
        // ->facebook(SOCIAL["facebook_appId"]);
    }

    /**
     * @param array $produtos
     * 
     * @return array
     */
    public function formtNormal(array $produtos): array
    {
        $this->formatter = new NumberFormatter('pt_BR',  NumberFormatter::DECIMAL);

        for ($c = 0; $c < count($produtos); $c++) {

            $produtos[$c] = $this->formatter->parse($produtos[$c]);;
        }



        return $produtos;
    }

    public function formtMoney($value): string
    {

        $this->formatter = new NumberFormatter('pt_BR',  NumberFormatter::CURRENCY);
        return $this->formatter->formatCurrency((float) $value, 'BRL');
    }
    public function formtMoneyArr($data): array
    {

        $this->formatter = new NumberFormatter('pt_BR',  NumberFormatter::CURRENCY);

        for ($i = 0; $i < count($data); $i++) {
            $data[$i] = $this->formatter->formatCurrency((float) $data[$i], 'BRL');
        }
        return  $data;
    }

    /**
     * @param array $values
     * @param string $status
     * 
     * @return string
     */
    public function ajaxResponse(array $values, int $status = 200): string
    {
        http_response_code($status);
        return json_encode($values);
    }
}