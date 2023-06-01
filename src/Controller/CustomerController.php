<?php

namespace App\Controller;

use App\Command\Customer\CreateCustomerHandlerInterface;
use App\Command\Customer\DeleteCustomerHandlerInterface;
use App\Command\Customer\UpdateCustomerHandlerInterface;
use App\Model\CustomerListItem;
use App\Model\CustomerListResponse;
use App\Service\CustomerServiceInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    public function __construct(
        private readonly CustomerServiceInterface $customerService,
        private readonly CreateCustomerHandlerInterface $createCustomerHandler,
        private readonly UpdateCustomerHandlerInterface $updateCustomerHandler,
        private readonly DeleteCustomerHandlerInterface $deleteCustomerHandler,
    ){}

    #[Route('/api/v1/customers', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Returns customers',
        content: new Model(type: CustomerListResponse::class)
    )]
    public function get(): Response
    {
        return $this->json($this->customerService->getCustomers());
    }

    #[Route('/api/v1/customer/create', methods: ['POST'])]
    #[OA\Response(
        response: 200,
        description: 'Create new customer'
    )]
    public function create(Request $request): Response
    {
        $this->createCustomerHandler->handle($request);

        return $this->json(['customer' => 'saved']);
    }

    #[Route('/api/v1/customer/{name}', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Return customer by name',
        content: new Model(type: CustomerListItem::class)
    )]
    public function show(string $name): Response
    {
        return $this->json($this->customerService->getCustomer($name));
    }

    #[Route('/api/v1/customer/{id}/get', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Return customer by id',
        content: new Model(type: CustomerListItem::class)
    )]
    public function getOneById(int $id): Response
    {
        return $this->json($this->customerService->getCustomerById($id));
    }

    #[Route('/api/v1/customer/{id}/update', methods: ['PUT'])]
    #[OA\Response(
        response: 200,
        description: 'Update customer by id'
    )]
    public function update(Request $request, int $id): Response
    {
        $this->updateCustomerHandler->handle($request, $id);

        return $this->json(['customer' => 'updated']);
    }

    #[Route('/api/v1/customer/{id}/delete', methods: ['DELETE'])]
    #[OA\Response(
        response: 200,
        description: 'Delete customer by id'
    )]
    public function delete(int $id): Response
    {
        $this->deleteCustomerHandler->handle($id);

        return $this->json(['customer' => 'deleted']);
    }
}
