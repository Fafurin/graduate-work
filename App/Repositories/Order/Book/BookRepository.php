<?php

namespace App\Repositories\Order\Book;

use App\Entities\EntityInterface;
use App\Entities\Order\Book\Book;
use App\Exceptions\BookNotFoundException;
use App\Repositories\EntityRepository;
use PDO;
use PDOStatement;

class BookRepository extends EntityRepository implements BookRepositoryInterface
{

    /**
     * @throws BookNotFoundException
     */
    public function get(int $id): EntityInterface
    {
        $statement = $this->connector->getConnection()->prepare(
            'SELECT * FROM books WHERE id = :id'
        );

        $statement->execute([':id' => $id]);

        return $this->getBook($statement);
    }

    /**
     * @throws BookNotFoundException
     */
    private function getBook(PDOStatement $statement): Book
    {
        $result = $statement->fetch(PDO::FETCH_OBJ);
        if (!$result) {
            throw new BookNotFoundException("Book not found");
        }

        return new Book(
            $result->title,
            $result->author,
            $result->isbn,
            $result->circulation,
            $result->conv_print_sheets,
            $result->publishing_sheets,
            $result->type_id,
            $result->format_id,
        );
    }

    /**
     * @throws BookNotFoundException
     */
    // переписать этот метод
    public function getBookByISBN(string $isbn): Book
    {
        $statement = $this->connector->getConnection()->prepare(
            'SELECT * FROM books WHERE isbn = :isbn'
        );
        $statement->execute([':isbn' => $isbn]);

        return $this->getBook($statement);
    }
}