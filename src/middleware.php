<?php
// Application middleware
use Lcobucci\JWT\Signer\Keychain; // just to make our life simpler
use Lcobucci\JWT\Signer\Rsa\Sha256; // you can use Lcobucci\JWT\Signer\Ecdsa\Sha256 if you're using ECDSA keys
use Lcobucci\JWT\Parser;

// e.g: $app->add(new \Slim\Csrf\Guard);
class ExampleMiddleware
{
    /**
     * Example middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        
        //获取cookie中token值
        if(isset($_COOKIE) && isset($_COOKIE['jwt_token'])){
            $data = $_COOKIE['jwt_token'];
        }else{
            header("Location: http://blog.com/login");
            exit;
        }
        
        //iwt token 验证
        $signer = new Sha256();
        $keychain = new Keychain();
        //从token读取出token对象
        $token = (new Parser())->parse($data); // Parses from a string  $token = (new Parser())->parse((string) $token); // Parses from a string
        //rsa密钥验证
        $boolean = $token->verify($signer, $keychain->getPublicKey('file://'.dirname( __DIR__ ).'/config/blog_public.key'));
        if($boolean){
            setcookie('jwt_token',$data,time()+3600,'/','blog.com',false,true);
            $response = $next($request, $response);
        }else{
            header("Location: http://blog.com/login");
            exit;
        }
        //$response->getBody()->write('2');

        return $response;
    }
}