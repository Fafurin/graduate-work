<?php

namespace App\Http\Actions;

use App\Exceptions\CustomerNotFoundException;
use App\Exceptions\HttpException;
use App\Http\ErrorResponse;
use App\Http\Request;
use App\Http\Response;
use App\Http\SuccessfulResponse;
use App\Repositories\User\Customer\CustomerRepository;
use App\Repositories\User\Customer\CustomerRepositoryInterface;

class FindCustomerByEmail implements ActionInterface
{

    public function __construct(
        private ?CustomerRepositoryInterface $customerRepository = null
    )
    {
        $this->customerRepository = $this->customerRepository ?? new CustomerRepository();
    }

    public function handle(Request $request): Response
    {
        try {
            $email = $request->query('email');
        } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage());
        }

        try {
            $customer = $this->customerRepository->getCustomerByEmail($email);
        } catch (CustomerNotFoundException $e) {
            return new ErrorResponse($e->getMessage());
        }

        return new SuccessfulResponse(
            [
                'name' => $customer->getFirstName() . ' ' .
                          $customer->getMiddleName() . ' ' .
                          $customer->getLastName(),
                'email' => $customer->getEmail()
            ]
        );
    }
}