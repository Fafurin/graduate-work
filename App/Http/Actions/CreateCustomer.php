<?php

namespace App\Http\Actions;

use App\Commands\CreateEntityCommand;
use App\Commands\User\Customer\CreateCustomerCommandHandler;
use App\Entities\User\Customer\Customer;
use App\Exceptions\HttpException;
use App\Exceptions\UserEmailExistException;
use App\Http\ErrorResponse;
use App\Http\Request;
use App\Http\Response;
use App\Http\SuccessfulResponse;
use App\Repositories\User\Customer\CustomerRepository;
use App\Repositories\User\Customer\CustomerRepositoryInterface;

class CreateCustomer implements ActionInterface
{

    public function __construct(
        private ?CustomerRepositoryInterface $customerRepository = null,
        private ?CreateCustomerCommandHandler $createCustomerCommandHandler = null
    )
    {
        $this->customerRepository = $this->customerRepository ?? new CustomerRepository();
        $this->createCustomerCommandHandler =
            $this->createCustomerCommandHandler ??
            new CreateCustomerCommandHandler();
    }

    public function handle(Request $request): Response
    {
        try {
            $customer = new Customer(
                $request->jsonBodyField('firstName'),
                $request->jsonBodyField('lastName'),
                $request->jsonBodyField('middleName'),
                $request->jsonBodyField('phone'),
                $request->jsonBodyField('email')
            );
            $this->createCustomerCommandHandler->handle(new CreateEntityCommand($customer));
        } catch (HttpException|UserEmailExistException $e) {
            return new ErrorResponse($e->getMessage());
        }

        return new SuccessfulResponse([
            'email' => $customer->getEmail()
        ]);
    }
}