<?php

namespace App\Commands\Order;

use App\Commands\CommandHandlerInterface;
use App\Commands\CommandInterface;
use App\Connections\ConnectorInterface;
use App\Connections\PostgresConnector;
use App\Entities\Order\Order;
use App\Exceptions\OrderNotFoundException;
use App\Exceptions\OrderNumberExistException;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Order\OrderRepositoryInterface;

class CreateOrderCommandHandler implements CommandHandlerInterface
{

    private \PDOStatement|false $statement;

    public function __construct(
        private ?OrderRepositoryInterface $orderRepository = null,
        private ?ConnectorInterface $connector = null
    )
    {
        $this->orderRepository = $orderRepository ?? new OrderRepository();
        $this->connector = $connector ?? new PostgresConnector();
        $this->statement = $this->connector->getConnection()->prepare($this->getSQL());
    }

    /**
     * @throws OrderNumberExistException
     */
    public function handle(CommandInterface $command): void
    {
        /**
         * @var Order $order
         */

        $order = $command->getEntity();
        $number = $order->getNumber();

        if (!$this->isOrderExists($number)) {
            $this->statement->execute([
                ':number' => $number,
                ':customer_id' => $order->getCustomerId(),
                ':book_id' => $order->getBookId(),
                ':payment' => $order->getPayment(),
                ':deadline' => $order->getDeadline(),
                ':status_id' => $order->getStatusId(),
                ':accepted_date' => $order->getAcceptedDate(),
                ':started_date' => $order->getStartedDate(),
                ':finished_date' => $order->getFinishedDate(),
                ':description' => $order->getDescriptions(),
            ]);
        } else throw new OrderNumberExistException();
    }

    private function isOrderExists(int $number): bool
    {
        try {
            $this->orderRepository->getOrderByNumber($number);
        } catch (OrderNotFoundException) {
            return false;
        }
        return true;
    }

    public function getSQL(): string
    {
        return "INSERT INTO orders (number, customer_id, book_id, payment, 
                                    deadline, status_id, accepted_date,
                                    started_date, finished_date, description) 
                            VALUES (:number, :customer_id, :book_id, :payment,
                                    :deadline, :status_id, :accepted_date,
                                    :started_date, :finished_date, :description)";
    }
}