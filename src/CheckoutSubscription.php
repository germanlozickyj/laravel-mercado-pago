<?php

namespace LaravelMercadoPago\LaravelMercadoPago;

use DateTimeInterface;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class checkoutSubscription implements Responsable
{
    private string $back_url;

    private string $card_token_id;
    
    private string $external_reference;
    
    private string $payer_email;
    
    private string $preapproval_plan_id;
    
    private string $reason;

    private string $status;

    public function url(): string
    {
        $response = LaravelMercadoPago::api('POST', 'checkout/preferences', [
                "back_url" => $this->back_url,
                "card_token_id" => $this->card_token_id,
                "external_reference" => $this->external_reference,
                "payer_email" => $this->payer_email,
                "preapproval_plan_id" => $this->preapproval_plan_id,
                "reason" => $this->reason,
                "status" => $this->status
        ]);

        return $response;
    }

    public function withBackUrl(string $back_url): self 
    {
        $this->back_url = $back_url;

        return $this;
    }

    public function withCardTokenId(string $card_token_id): self 
    {
        $this->card_token_id = $card_token_id;
        
        return $this;
    }

    public function withExternalReference(string $external_reference): self 
    {
        $this->external_reference = $external_reference;
        
        return $this;
    }

    public function withPayerEmail(string $payer_email): self 
    {
        $this->payer_email = $payer_email;
        
        return $this;
    }

    public function withPreapprovalPlanId(string $preapproval_plan_id): self 
    {
        $this->preapproval_plan_id = $preapproval_plan_id;
        
        return $this;
    }

    public function withReason(string $reason): self 
    {
        $this->reason = $reason;
        
        return $this;
    }

    public function withStatus(string $status): self 
    {
        $this->status = $status;
        
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
}