<?php

namespace App\Services\JWT;

use Firebase\JWT\JWT;
use PhalconApi\Auth\Session;
use PhalconApi\Http\Response;

class JWTService implements \PhalconApi\Auth\TokenParserInterface
{
    protected $jwt;
    protected $publicKey;
    protected $private_token;
    protected $payload;

    /**
     * Create instance of JWTAuth and assign jwt, payload.
     * JWTAuth constructor.
     * @param $payload
     */
    public function __construct()
    {
        $this->jwt = new JWT();
    }

    /**
     * Create new private key.
     * @return resource
     */
    public static function create_private_token()
    {
        $config = array(
            'digest_alg' => 'sha256',
            'private_key_bits' => 2048,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
        );
        $res = openssl_pkey_new($config);
        openssl_pkey_export($res, $private_token);
        return $private_token;
    }

    /**
     * @param String $token
     */
    public function set_private_token(String $token)
    {
        $this->private_token = $token;
    }

    /**
     * Create new private key
     * @param string $private_token
     * @return string
     */
    public static function create_public_token(string $private_token) :string
    {
        $resource = openssl_pkey_get_private($private_token);

        $public_token = openssl_pkey_get_details($resource);
        if($public_token) {
            return $public_token['key'];
        }else{
            return false;
        }
    }

    /**
     * Create new public token and compare with current public token
     * @param $private_token
     * @param $public_token
     * @return int
     */
    public function check_token($private_token, $public_token)
    {
        $pubToken = $this->create_public_token($private_token);

        return strcasecmp($public_token, $pubToken);
    }

    /**
     * @param array $playload
     * @param string $alg
     * @param string|null $keyId
     * @param null $head
     * @return string
     * @throws JWTAuthException
     */
    public function encode(array $playload, $alg = 'RS256', string $keyId = null, $head = null) :string
    {
        $token = $this->jwt->encode($this->payload, $this->private_token, $alg, $playload, $head) ;

        if ( !$token ) {
            throw new JWTAuthException();
        }
        return	$token;
    }

    /**
     * Getting payload from token
     * @param string $token
     * @param $public_token
     * @param array $allowed_algs
     * @return object
     * @throws JWTAuthException
     */
    public function decode(string $token, $public_token, array $allowed_algs = array('RS256')) :object
    {
        $payload = $this->jwt->decode($token, $public_token, $allowed_algs);
        if ( !$payload ) {
            throw new JWTAuthException();
        }
        return	$payload;
    }

    public function getToken(Session $session)
    {
        $tokenData = $this->create(
            $session->getAccountTypeName(),
            $session->getIdentity(),
            $session->getStartTime(),
            $session->getExpirationTime()
        );

        return $this->encode($tokenData);
    }

    protected function create($issuer, $user, $iat, $exp)
    {

        return [

            /*
            The iss (issuer) claim identifies the principal
            that issued the JWT. The processing of this claim
            is generally application specific.
            The iss value is a case-sensitive string containing
            a StringOrURI value. Use of this claim is OPTIONAL.
            ------------------------------------------------*/
            "iss" => $issuer,

            /*
            The sub (subject) claim identifies the principal
            that is the subject of the JWT. The Claims in a
            JWT are normally statements about the subject.
            The subject value MUST either be scoped to be
            locally unique in the context of the issuer or
            be globally unique. The processing of this claim
            is generally application specific. The sub value
            is a case-sensitive string containing a
            StringOrURI value. Use of this claim is OPTIONAL.
            ------------------------------------------------*/
            "sub" => $user,

            /*
            The iat (issued at) claim identifies the time at
            which the JWT was issued. This claim can be used
            to determine the age of the JWT. Its value MUST
            be a number containing a NumericDate value.
            Use of this claim is OPTIONAL.
            ------------------------------------------------*/
            "iat" => $iat,

            /*
            The exp (expiration time) claim identifies the
            expiration time on or after which the JWT MUST NOT
            be accepted for processing. The processing of the
            exp claim requires that the current date/time MUST
            be before the expiration date/time listed in the
            exp claim. Implementers MAY provide for some small
            leeway, usually no more than a few minutes,
            to account for clock skew. Its value MUST be a
            number containing a NumericDate value.
            Use of this claim is OPTIONAL.
            ------------------------------------------------*/
            "exp" => $exp,
        ];
    }

    public function getSession($token)
    {
        $tokenData = $this->decode($token);

        return new Session($tokenData->iss, $tokenData->sub, $tokenData->iat, $tokenData->exp, $token);
    }
}