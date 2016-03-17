<?php

namespace App\Controllers;

//DBS Models
use App\Models\Employee;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\ProductLine;
use App\Models\Customer;
use App\Models\Office;
use App\Models\Product;
use App\Models\User;
use App\Models\PasswordReset;

use Aura\Auth\Exception;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

use App\Traits\Auth;
use App\Traits\Mail;

/**
 * Class ApiController
 * @package App\Controllers
 */
class ApiController
{
    //@todo class this could use a rate limiter to avoid spam attacks
    use Auth, Mail;
    /**
     * @var array
     */
    protected $noAuth = ['postLogin', 'postResetPassword', 'getLogout', 'postResetPasswordRequest'];
    /**
     * @var int
     */
    protected $responseStatus = 200;

    /**
     * ApiController constructor.
     */
    public function __construct()
    {
        $this->makeAuth();
        $this->resumeService->resume($this->auth);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $method
     * @return ResponseInterface
     */
    public function apiRouter(ServerRequestInterface $request, ResponseInterface $response, $method)
    {
        $method = strtolower($request->getMethod()).ucfirst($method['param']);
        if (!method_exists($this, $method)) {
            return $response->withStatus(403);
        }
        if (!in_array($method, $this->noAuth) && !$this->checkAuth($request)) {
            return $response->withStatus(401);
        }

        return $this->$method($request, $response);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function postLogin(ServerRequestInterface $request, ResponseInterface $response)
    {
        // create the login service
        $input = $request->getParsedBody();
        if (!is_array($input) || !array_key_exists('email', $input) || !array_key_exists('password', $input)) {
            return $response->withStatus(401);
        }
        $userdata = [
            'username' => $input['email'],
            'password' => $input['password']
        ];
        try {
            $this->loginService->login($this->auth, $userdata);
        } catch (Exception $e) {
fix: remove            return $this->createJsonResponse($response, ['error'=> [['message' => 'Problem logging in, please check your credentials and try again']]], 401);
        } finally {
            if ($this->auth->isValid()) {
                return $this->createJsonResponse($response, 'Authorized', 200);
            }
        }
    }

    /**
     * @param $request
     * @param $response
     * @return ResponseInterface
     */
    public function postResetPasswordRequest($request, $response)
    {
        $input = $request->getParsedBody();
        if (is_array($input) && array_key_exists('email', $input)) {
            $email = $input['email'];
            $user = User::where('email', $email)->first();
            if (!empty($user)) {
                $mailResponse = 'PROBLEM';
                $passwordResetToken = $this->createPasswordResetToken($user);
                if ($this->sendResetPasswordLink($email, $user->firstname, $passwordResetToken)){$mailResponse = 'OK';}
                return $this->createJsonResponse($response, $mailResponse, 200);
            }
        }

        return $response->withStatus(401);
    }


    /**
     * @param $request
     * @param $response
     */
    public function postResetPassword($request, $response)
    {
        $input = $request->getParsedBody();
        if (is_array($input)
            && array_key_exists('email', $input)
            && array_key_exists('token', $input)
            && array_key_exists('password', $input)
            && array_key_exists('password_confirmation', $input)
            && $input['password'] === $input['password_confirmation']
        ) {
            //@todo add input verification (password length, etc.)
            //@todo setup expiration of the token (maybe 24-48hrs)
            $user = User::where('email', PasswordReset::where('email', $input['email'])->where('token', $input['token'])->first(['email'])->email)->first();//@todo this can probably be done as a join to the User Model
            //@todo this can probably be done as a join to the User Model
            if ($user->email) {
                $user->password = password_hash($input['password'], PASSWORD_BCRYPT);
                $user->save();
                header('Location: /');exit;//@todo SPA this route and add in messaging for expired/invalid token
            } else {
                //@todo something went wrong return with error message
            }
        } else {
            //@todo something went wrong do something
        }
    }

    /**
     * @param $request
     * @param $response
     * @return mixed
     */
    public function getLogout($request, $response)
    {
        $this->logoutService->logout($this->auth);

        return $response->withStatus(403);
    }

    /**
     * @return mixed
     */
    private function checkAuth()
    {
        return $this->auth->isValid();
    }

    /**
     * @param ResponseInterface $response
     * @param $data
     * @param $status
     * @return ResponseInterface
     */
    private function createJsonResponse(ResponseInterface $response, $data, $status)
    {
        $response->getBody()->write(json_encode($data));

        return $response->withStatus($status);
    }
    //Get stuff
    /**
     * @return string
     */
    public function getIndex()
    {
        return json_encode(['user' => Customer::all()]);

    }

    /**
     * @return string
     */
    public function getCustomers()
    {
        return json_encode(['customers' => Customer::all()]);
    }

    /**
     * @return string
     */
    public function getProducts()
    {
        return json_encode(['products' => Product::all()]);
    }

    /**
     * @return string
     */
    public function getEmployees()
    {
        return json_encode(['employees' => Employee::all()]);
    }

    /**
     * @return string
     */
    public function getOffices()
    {
        return json_encode(['offices' => Office::all()]);
    }

    /**
     * @return string
     */
    public function getProductlines()
    {
        return json_encode(['productlines' => ProductLine::all()]);
    }

    /**
     * @return string
     */
    public function getOrders()
    {
        return json_encode(['orders' => Order::all()]);
    }

    /**
     * @return string
     */
    public function getOrderdetails()
    {
        return json_encode(['orderdetails' => OrderDetail::all()]);
    }

    /**
     * @return string
     */
    public function getPayments()
    {
        return json_encode(['payments' => Payment::all()]);
    }

    /**
     * @param $toEmail
     * @param $toName
     * @param $passwordResetToken
     * @return boolean
     */
    private function sendResetPasswordLink($toEmail, $toName = '', $passwordResetToken)
    {
        $domain = getenv('DOMAIN');
        $messageHtml = '<html><body>Reset Password <a href="' . $domain . 'resetPassword/'.$passwordResetToken.'">'. $domain . 'resetPassword/'.$passwordResetToken.'</a></body></html>';
        $subject = 'Password Reset';

        return $this->sendMail($messageHtml, $subject, $toEmail, $toName);
    }

    /**
     * @param $user
     * @return string
     */
    private function createPasswordResetToken($user)
    {
//        $token = bin2hex(random_bytes(16)); //php7
        $token = bin2hex(openssl_random_pseudo_bytes(16)); //php <7
        PasswordReset::create(['email' => $user->email, 'token' => $token]);

        return $token;
    }
}