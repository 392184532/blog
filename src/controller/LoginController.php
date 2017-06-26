<?php

namespace Ran\controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Lcobucci\JWT\Signer\Keychain; // just to make our life simpler
use Lcobucci\JWT\Signer\Rsa\Sha256; // you can use Lcobucci\JWT\Signer\Ecdsa\Sha256 if you're using ECDSA keys
use \Ran\controller\Controller;
use \Ran\Fun;
use \Ran\model\UserModel;

class LoginController extends Controller{
    //ע��
    public function register(RequestInterface $request, ResponseInterface $respons, $args){
        
        $returnData = $request->getQueryParams();

        if ($request->isPost()) {
            $returnData = $request->getParsedBody();
        }
        
        $this->logger->addInfo(Fun::getIp().' Try to register: '.implode('---', $returnData));
        
        //��֤���
        $user = $returnData['email']??false;
        $pass = $returnData['password']??false;
        $confirm = $returnData['confirm_passowrd']??false;
        
        if($pass !== $confirm){
            
            throw new \Exception("check your password please!");
        }
        
        if(!$user || !$pass){
            
            throw new \Exception("user or password cannot be empty!");
        }
        
        $userBool = preg_match_all('/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/', $user, $userName);
        $passBool = preg_match_all('/^[a-zA-Z0-9_-]{6,16}$/', $pass, $passWord);
        if(!$userBool || !$passBool){
            
            throw new \Exception("user or password data type error!");
        }
        
        $userName = $userName[0][0];
        $passWord = $passWord[0][0];
        
        $username = UserModel::where('user_name', $userName)->first()->user_name;
        
        if($username === $userName){
            
            throw new \Exception("username repeat!");
        }
        
        //����ɢ�ѻ�
        $password = password_hash($passWord, PASSWORD_BCRYPT);
        if(!$password){
            
            throw new \Exception("register error!");
        }
        
        //д�����ݿ�
        $userModel = new UserModel;
        
        $userModel->user_name = $userName;
        $userModel->user_pwd = $password;
        $userModel->user_register_time = time();
        $userModel->user_register_ip = Fun::getIp();
        $userModel->user_lock = 0;
        $userModel->user_freeze = 0;
        
        $bool = $userModel->save();
        if(!$bool){
            throw new \Exception("register error!");
        }
        
        $this->logger->addInfo(Fun::getIp().' register secusse: '.implode('---', $returnData));
        header("Location: http://blog.com/"); 
    }
    
    //��¼
    public function login(RequestInterface $request, ResponseInterface $respons, $args){

        $returnData = $request->getQueryParams();

        if ($request->isPost()) {
            $returnData = $request->getParsedBody();
        }
        
        $this->logger->addInfo(Fun::getIp().' Try to login: '.implode('---', $returnData));
        
        $user = $returnData['email']??false;
        $pass = $returnData['password']??false;
        if(!$user || !$pass){
            
            throw new \Exception("user or password cannot be empty!");
        }
        
        $userBool = preg_match_all('/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/', $user, $userName);
        $passBool = preg_match_all('/^[a-zA-Z0-9_-]{6,16}$/', $pass, $passWord);
        if(!$userBool || !$passBool){
            
            throw new \Exception("user or password data type error!");
        }
        
        $userName = $userName[0][0];
        $passWord = $passWord[0][0];
        
        $userModel = UserModel::where('user_name', $userName)->first();
        if(!$userModel){
            
            throw new \Exception("Not is user!");
        }
        
        //����ֵ
        $userLock = $userModel->user_lock;
        if($userLock !== 0){
            
            throw new \Exception("The user is Locked!");
        }
        
        //����ֵ
         $userFreeze = $userModel->user_freeze;
         if($userFreeze !== 0){
            
            throw new \Exception("User freeze!");
        }
        
        //�����ϣ
        $userHash = $userModel->user_pwd;
        //������֤
        $boolean =  password_verify ($passWord, $userHash);
        
        if(!$boolean){
            throw new \Exception("password error!");
        }

        //iwt token
        $signer = new Sha256();
        $keychain = new Keychain();
        
        $publicKey = file_get_contents(dirname( __DIR__ ).'/../config/blog_public.key');
        $privatekey = file_get_contents(dirname( __DIR__ ).'/../config/blog_private.key');
        $token = $this->jwt->setIssuer('http://blog.com') // Configures the issuer (iss claim)
                        ->setAudience('http://blog.org') // Configures the audience (aud claim)
                        ->setId('4f1g23a12aa', true) // Configures the id (jti claim), replicating as a header item
                        ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
                        ->setNotBefore(time() + 60) // Configures the time that the token can be used (nbf claim)
                        ->setExpiration(time() + 3600) // Configures the expiration time of the token (nbf claim)
                        ->set('uid', 1) // Configures a new claim, called "uid"
                        ->sign($signer,  $keychain->getPrivateKey('file://'.dirname( __DIR__ ).'/../config/blog_private.key')) // creates a signature using your private key
                        ->getToken(); // Retrieves the generated token

        //echo $token;                
        //var_dump($token->verify($signer, $keychain->getPublicKey('file://'.dirname( __DIR__ ).'/../config/blog_public.key'))); // true when the public key was generated by the private one =)
        
        $bool = setcookie('jwt_token',$token,time()+3600,'/','blog.com',false,true);
        //var_dump($bool);
        
        $this->logger->addInfo(Fun::getIp().' Login secusse: '.implode('---', $returnData));
        header("Location: http://blog.com");
    }
    
    //�ǳ�
    public function logout(){
        
        setcookie('jwt_token','',time(),'/','blog.com',false,true);
        $this->logger->addInfo(Fun::getIp().' Logout secusse: '.implode('---', $returnData));
        header("Location: http://blog.com");
        exit;
    }
}
