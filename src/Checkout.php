<?php

namespace LaravelMercadoPago\LaravelMercadoPago;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class Checkout implements Responsable 
{
    private string $title;
    
    private string $description;

    private string $picture_url;

    private string $category_id;

    private string $product_id;

    private int $amount;

    public function __construct(string $product_id) 
    {
    }

    public static function make(string $product_id) : static
    {
        return new static($product_id);
    }

    public function url() : string
    {
        return '';
    }

    public function redirect(): RedirectResponse
    {
        return Redirect::to($this->url(), 303);
    }

    public function toResponse($request): RedirectResponse
    {
        return $this->redirect();
    }

    public function withTitle(string $title) : self
    {
        $this->title = $title;

        return $this;
    }


    public function withDescription(string $description) : self
    {
        $this->description = $description;

        return $this;
    }

    public function withPictureUrl(string $picture_url) : self
    {
        $this->picture_url = $picture_url;

        return $this;
    }

    public function withCategoryId(string $category_id) : self
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function withProductId(string $product_id) : self
    {
        $this->product_id = $product_id;

        return $this;
    }

    public function withAmount(int $amount) : self
    {
        $this->amount = $amount;

        return $this;
    }
}
