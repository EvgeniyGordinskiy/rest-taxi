<?php

namespace App\Services\Validator;

use Firebase\JWT\JWT;
use PhalconApi\Auth\Session;
use PhalconApi\Http\Response;

class JWTService implements \PhalconApi\Auth\TokenParserInterface
{
    protected $jwt;
    protected $publicKey;
    protected $privateKey;
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
     * Create new private key
     * @param string $private_token
     * @return string
     */
    public static function create_public_token(string $private_token) :string
    {
        $resource = openssl_pkey_get_private($private_token);

        $public_token = openssl_pkey_get_details($resource);
        if($public_token) {
            return md5($public_token['key']);
        }else{
            return false;
        }
    }

    /**
     * Create new private key.
     * @return string
     */
    public static function create_key_for_public_token(string $public_token) :string
    {
        return md5($public_token);
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

    public function getToken(Session $session)
    {
        // TODO: Implement getToken() method.
    }

    /**
     * @param $uId
     * @param $private_token
     * @param string $alg
     * @param null $keyId
     * @param null $head
     * @return string
     * @throws FileException
     * @throws JWTAuthException
     */
    public function encode(string $uId, string $private_token, $alg = 'RS256', string $keyId = null, $head = null) :string
    {
        $publicToken = $this->create_public_token($private_token);

        $this->write_public_key($publicToken, $uId);

        $token = $this->jwt->encode($this->payload, $private_token, $alg, $uId, $head) ;

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

    /**
     * @param $publicToken
     * @param $uId
     * @throws FileException
     */
    private function write_public_key($publicToken, $uId)
    {
        $file = $this->url->getBaseUri()."../../../storage/users_public_keys/$uId.txt";

        if(!file_exists($file)){
            $newFile = new FileService($file, 'a');
            $bytes = $newFile->write($publicToken);
        }else{
            $newFile = fopen($file, 'a');
            flock($newFile,LOCK_EX);
            $bytes = fwrite($newFile, $publicToken);
            flock($newFile,LOCK_UN);
            fclose($newFile);
        }

        if(!$bytes){
            throw new FileException('Nothing written in the file');
        }
    }
}