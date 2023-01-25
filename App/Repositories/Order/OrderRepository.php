<?php

namespace App\Repositories\Order;

use App\Entities\EntityInterface;
use App\Entities\Order\Order;
use App\Exceptions\OrderNotFoundException;
use App\Repositories\EntityRepository;
use PDO;
use PDOStatement;

class OrderRepository extends EntityRepository implements OrderRepositoryInterface
{

    /**
     * @throws OrderNotFoundException
     */
    public function get(int $id): EntityInterface
    {
        $statement = $this->connector->getConnection()->prepare(
            'SELECT * FROM orders WHERE id = :id'
        );

        $statement->execute([':id' => $id]);

        return $this->getOrder($statement);
    }

    /**
     * @throws OrderNotFoundException
     */
    private function getOrder(PDOStatement $statement): Order
    {
        $result = $statement->fetch(PDO::FETCH_OBJ);
        if (false === $result) {
            throw new OrderNotFoundException("Order not found");
        }

        return new Order(
            $result->number,
            $result->customer_id,
            $result->book_id,
            $result->payment,
            $result->deadline,
            $result->status_id,
            $result->accepted_date,
            $result->started_date,
            $result->finished_date,
            $result->description,
        );
    }

    /**
     * @throws OrderNotFoundException
     */
    public function getOrderByNumber(int $number): Order
    {
        $statement = $this->connector->getConnection()->prepare(
            'SELECT * FROM orders WHERE number = :number'
        );
        $statement->execute([':number' => $number]);

        return $this->getOrder($statement);
    }

}