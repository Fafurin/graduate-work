<?php

namespace Test\Actions;

use App\Entities\EntityInterface;
use App\Entities\User\Customer\Customer;
use App\Exceptions\CustomerNotFoundException;
use App\Http\Actions\FindCustomerByEmail;
use App\Http\ErrorResponse;
use App\Http\Request;
use App\Http\SuccessfulResponse;
use App\Repositories\User\Customer\CustomerRepositoryInterface;
use PHPUnit\Framework\TestCase;

class FindCustomerByEmailTest extends TestCase
{

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testItReturnsErrorResponseIfNoEmailProvided(): void
    {
        $request = new Request([], []);
        $customerRepository = $this->getCustomerRepository([]);
        $action = new FindCustomerByEmail($customerRepository);
        $response = $action->handle($request);
        $this->assertInstanceOf(ErrorResponse::class, $response);
        $this->expectOutputString('{"success":false,"reason":"No such query param in request: email"}');
        $response->send();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testItReturnsErrorResponseIfUserNotFound(): void
    {
        $request = new Request(['email' => 'test@email.email'], []);
        $customerRepository = $this->getCustomerRepository([]);
        $action = new FindCustomerByEmail($customerRepository);
        $response = $action->handle($request);
        $this->assertInstanceOf(ErrorResponse::class, $response);
        $this->expectOutputString('{"success":false,"reason":"Customer not found"}');
        $response->send();

    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testItReturnsSuccessfulResponse(): void
    {
        $request = new Request(['email' => 'test@email.email'], []);
        $customerRepository = $this->getCustomerRepository([
                new Customer(
                    'TestFirstName',
                    'TestLastName',
                    'TestMiddleName',
                    '81234567890',
                    'test@email.email'
                )]
        );

        $action = new FindCustomerByEmail($customerRepository);
        $response = $action->handle($request);
        $this->assertInstanceOf(SuccessfulResponse::class, $response);
        $this->expectOutputString('{"success":true,"data":{"name":"TestFirstName TestMiddleName TestLastName","email":"test@email.email"}}');
        $response->send();
    }

    private function getCustomerRepository(array $customers): CustomerRepositoryInterface
    {
        return new class($customers) implements CustomerRepositoryInterface {

            public function __construct(private array $customers){}

            public function get(int $id): EntityInterface
            {
                throw new CustomerNotFoundException('Customer not found');
            }

            public function getCustomerByEmail(string $email): Customer
            {
                foreach ($this->customers as $customer) {
                    if ($customer instanceof Customer && $email === $customer->getEmail()) {
                        return $customer;
                    }
                }
                throw new CustomerNotFoundException('Customer not found');
            }
        };
    }
}