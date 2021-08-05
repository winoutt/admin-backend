<?php

namespace App\Services;

use App\Exceptions\InvalidJwtTokenData;
use Exception;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\ValidationData;

class JWT
{
    private $time;
    private $builder;
    private $signer;
    private $key;
    private $parser;
    private $validationData;

    function __construct()
    {
        $this->time = time();
        $this->builder = new Builder;
        $this->signer = new Sha256;
        $this->key = new Key(env('APP_KEY'));
        $this->parser = new Parser;
        $this->validationData = new ValidationData;
    }

    public function authToken ($adminId)
    {
        return (string) $this->builder
            ->issuedAt($this->time)
            ->expiresAt($this->time + 3600)
            ->withClaim('admin_id', $adminId)
            ->getToken($this->signer, $this->key);
    }

    public function refreshToken ()
    {
        return (string) $this->builder
            ->issuedAt($this->time)
            ->expiresAt(false)
            ->getToken($this->signer, $this->key);
    }

    public function verify (string $token)
    {
        try {
            $token = $this->parser->parse($token);
            $isValidToken = $token->verify($this->signer, $this->key);
            if (!$isValidToken) throw new Exception('Invalid token');
            return $token;
        } catch (Exception $e) {
            throw new Exception('Invalid token');
        }
    }

    public function validate (Token $token)
    {
        try {
            $isValidData = $token->validate($this->validationData);
            if (!$isValidData) throw new Exception('Invalid token data');
        } catch (Exception $e) {
            throw new InvalidJwtTokenData('Invalid token data');
        }
    }
}