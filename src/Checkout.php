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

    private array $client_data = [];

    private array $client_identification = [];
    
    private array $client_address = [];
    
    private string $currency_id;

    private int $amount;

    private int $quantity;
    
    private array $excluded_payment_methods = [];

    private array $excluded_payment_types = [];

    private array $tracks = [];

    private int $installments = null;

    private int $default_installments = null;

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
                ...$this->getExpirationTime(),
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
                "payer" => [
                  ...$this->client_data,
                  "identification" => [
                    ...$this->client_identification
                  ],
                  "address"=> [
                    ...$this->client_address
                  ]
                ],
                "payment_methods"=> [
                  "excluded_payment_methods" => [
                    ...$this->excluded_payment_methods
                  ],
                  "excluded_payment_types" => [
                    ...$this->excluded_payment_types
                  ],
                  "installments" => $this->installments,
                  "default_installments" => $this->default_installments
                ],
                "tracks"=> [
                  ...$this->tracks
                ]
        ]);

        return $response;
    }

    public function getExpirationTime() : array
    {
      if(isset($this->custom_data['expiration_date_from']) &&  $this->custom_data['expiration_date_to']) {
        return [
          'expiration_date_from' => $this->custom_data['expiration_date_from'],
          'expiration_date_to' => $this->custom_data['expiration_date_to'],
        ];
      }

      return [];
    }

    
    public function withMaxNumbersOfDue(int $max_dues) : self
    {
      $this->installments = $max_dues;

      return $this;
    }

    public function withDefaultNumbersOfDue(int $max_dues) : self
    {
      $this->default_installments = $max_dues;

      return $this;
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

    public function withExcludedPaymentMethods(array $methods) : self
    {
      $this->excluded_payment_methods = $methods;

      return $this;
    }

    public function withExcludedPaymentTypes(array $methods) : self
    {
      $this->excluded_payment_types = $methods;
      
      return $this;
    }
    //USER LOCATION
    public function withUserZipCode(string $postal_code) : self
    {
      $this->client_data['zip_code'] = $postal_code;
   
      return $this;
    }

    public function withUserStreetName(string $street_name) : self
    {
      $this->client_data['street_name'] = $street_name;
   
      return $this;
    }

    public function withUserStreetNumber(int $street_number) : self
    {
      $this->client_data['street_number'] = $street_number;
   
      return $this;
    }
    //USER IDENTIFICATION 
    public function withIdentificationType(string $type) : self
    {
      $this->client_identification['type'] = $type;
   
      return $this;
    }

    public function withIdentificationNumber(int $number) : self
    {
      $this->client_identification['number'] = $number;
   
      return $this;
    }

    //USER DATA 
    public function withName(string $name) : self
    {
      $this->client_data['name'] = $name;
   
      return $this;
    }

    public function withSurname(string $surname) : self
    {
      $this->client_data['surname'] = $surname;
      
      return $this;
    }

    public function withEmail(string $email) : self
    {
      $this->client_data['email'] = $email;

      return $this;
    }

    public function withPhone(string $area_code, int $number) : self
    {
      $this->client_data['phone'] = [
        'area_code' => $area_code,
        'number' => $number
      ];
      
      return $this;
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

    public function withGoogleTracks(string $values) : self
    {
      array_push($this->tracks, [
        'type' => 'google_ad',
        'values' => $values
      ]);

      return $this;
    }

    public function withFacebookTracks(string $values) : self
    {
      array_push($this->tracks, [
        'type' => 'facebook_ad',
        'values' => $values
      ]);

      return $this;
    }
}
