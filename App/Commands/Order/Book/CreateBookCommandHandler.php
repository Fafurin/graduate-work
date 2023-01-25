<?php

namespace App\Commands\Order\Book;

use App\Commands\CommandHandlerInterface;
use App\Commands\CommandInterface;
use App\Connections\ConnectorInterface;
use App\Connections\PostgresConnector;
use App\Entities\Order\Book\Book;
use App\Exceptions\BookISBNExistException;
use App\Exceptions\BookNotFoundException;
use App\Repositories\Order\Book\BookRepository;
use App\Repositories\Order\Book\BookRepositoryInterface;

class CreateBookCommandHandler implements CommandHandlerInterface
{

    private \PDOStatement|false $statement;

    public function __construct(
        private ?BookRepositoryInterface $bookRepository = null,
        private ?ConnectorInterface $connector = null
    )
    {
        $this->bookRepository = $bookRepository ?? new BookRepository();
        $this->connector = $connector ?? new PostgresConnector();
        $this->statement = $this->connector->getConnection()->prepare($this->getSQL());
    }

    /**
     * @throws BookISBNExistException
     */
    public function handle(CommandInterface $command): void
    {
        /**
         * @var Book $book
         */

        $book = $command->getEntity();
        $isbn = $book->getIsbn();

        if (!$this->isBookExists($isbn)) {
            $this->statement->execute([
                ':title' => $book->getTitle(),
                ':author' => $book->getAuthor(),
                ':isbn' => $isbn,
                ':circulation' => $book->getCirculation(),
                ':conv_print_sheets' => $book->getConvPrintSheets(),
                ':publishing_sheets' => $book->getPublishingSheets(),
                ':type_id' => $book->getTypeId(),
                ':format_id' => $book->getFormatId(),
            ]);
        } else throw new BookISBNExistException();
    }

    // Нужно переделать проверку по isbn,
    // так как при добавлении книги в базу isbn не всегда известен,
    // еще не у каждого издания есть isbn
    private function isBookExists(string $isbn): bool
    {
        try {
            $this->bookRepository->getBookByISBN($isbn);
        } catch (BookNotFoundException) {
            return false;
        }
        return true;
    }

    public function getSQL(): string
    {
        return "INSERT INTO books (title, author, isbn, circulation, conv_print_sheets, 
                                                publishing_sheets, type_id, format_id) 
                             VALUES (:title, :author, :isbn, :circulation, :conv_print_sheets, 
                                     :publishing_sheets, :type_id, :format_id)";
    }
}