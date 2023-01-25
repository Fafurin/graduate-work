<?php

namespace App\Commands\Order\Book\File;

use App\Commands\CommandHandlerInterface;
use App\Commands\CommandInterface;
use App\Connections\ConnectorInterface;
use App\Connections\PostgresConnector;
use App\Entities\Order\Book\File\File;
use App\Exceptions\FileNotFoundException;
use App\Exceptions\FilePathExistException;
use App\Repositories\Order\Book\File\FileRepository;
use App\Repositories\Order\Book\File\FileRepositoryInterface;

class CreateFileCommandHandler implements CommandHandlerInterface
{

    private \PDOStatement|false $statement;

    public function __construct(
        private ?FileRepositoryInterface $fileRepository = null,
        private ?ConnectorInterface $connector = null
    )
    {
        $this->fileRepository = $fileRepository ?? new FileRepository();
        $this->connector = $connector ?? new PostgresConnector();
        $this->statement = $this->connector->getConnection()->prepare($this->getSQL());
    }

    /**
     * @throws FilePathExistException
     */
    public function handle(CommandInterface $command): void
    {
        /**
         * @var File $file
         */

        $file = $command->getEntity();
        $path = $file->getPath();

        if (!$this->isFileExists($path)) {
            $this->statement->execute([
                ':book_id' => $file->getBookId(),
                ':path' => $path
            ]);
        } else throw new FilePathExistException();
    }

    private function isFileExists(string $path): bool
    {
        try {
            $this->fileRepository->getFileByPath($path);
        } catch (FileNotFoundException) {
            return false;
        }
        return true;
    }

    public function getSQL(): string
    {
        return "INSERT INTO files (book_id, path) VALUES (:book_id, :path)";
    }
}