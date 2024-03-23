<?php

namespace LaravelMercadoPago\LaravelMercadoPago;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use DateTimeInterface;

class Checkout implements Responsable
{
    private string $title;

    private string $description;

    private string $picture_url;

    private string $category_id;

    private string $product_id;

    private array $custom_data = [];
    
    private string $currency_id;

    private int $amount;

    private int $quantity;

    private ?DateTimeInterface $expiresAt;

    public function __construct(string $product_id) 
    {
    }

    public static function make(string $product_id): static
    {
        return new static($product_id);
    }

    public function url(): string
    {
        $response = LaravelMercadoPago::api('POST', 'checkout/preferences', [
                "back_urls"=> $this->getBackUrls(),
                "differential_pricing"=> [
                  "id"=> null
                ],
                "expires"=> isset($this->expiresAt) ? $this->expiresAt->format(DateTimeInterface::ATOM) : null,
                "items"=> [
                  [
                    "title"=> $this->title,
                    "description"=> $this->description,
                    "picture_url"=> $this->picture_url,
                    "category_id"=> $this->category_id,
                    "quantity"=> $this->quantity,
                    "currency_id"=> $this->currency_id,
                    "unit_price"=> $this->amount
                  ]
                ],
                "marketplace_fee"=> null,
                "metadata"=> null,
                "payer"=> [
                  "phone"=> [
                    "number"=> null
                  ],
                  "identification"=> [],
                  "address"=> [
                    "street_number"=> null
                  ]
                ],
                "payment_methods"=> [
                  "excluded_payment_methods"=> [
                    []
                  ],
                  "excluded_payment_types"=> [
                    []
                  ],
                  "installments"=> null,
                  "default_installments"=> null
                ],
                "shipments"=> [
                  "local_pickup"=> false,
                  "default_shipping_method"=> null,
                  "free_methods"=> [
                    [
                      "id"=> null
                    ]
                  ],
                  "cost"=> null,
                  "free_shipping"=> false,
                  "receiver_address"=> [
                    "street_number"=> null
                  ]
                ],
                "tracks"=> [
                  []
                ]
        ]);

        return $response;
    }

    public function getBackUrls() : array 
    {
      $keys = [
        'success',
        'pending',
        'failed'
      ];

      $urls = [];

      foreach($keys as $key) {
        if(isset($this->custom_data["back_{$key}_url"])) {
          array_push($urls, $this->custom_data["back_{$key}_url"]);
        }
      }

      return $urls;
    }

    public function ExpirationTime(DateTimeInterface $start_time, DateTimeInterface $end_time) : self
    {
      $this->custom_data['expiration_date_from'] = $start_time;
      $this->custom_data['expiration_date_to'] = $end_time;

      return $this;
    }
 
    public function redirect(): RedirectResponse
    {
        return Redirect::to($this->url(), 303);
    }

    public function toResponse($request): RedirectResponse
    {
        return $this->redirect();
    }

    public function withTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function withDescription(string $description) : self
    {
        $this->description = $description;

        return $this;
    }

    public function withPictureUrl(string $picture_url): self
    {
        $this->picture_url = $picture_url;

        return $this;
    }

    public function withCategoryId(string $category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function withProductId(string $product_id): self
    {
        $this->product_id = $product_id;

        return $this;
    }

    public function withAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function withQuantity(int $quantity) : self
    {
        $this->quantity = $quantity;
        
        return $this;
    }

    public function expiresAt(DateTimeInterface $expiresAt): self
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }
}
