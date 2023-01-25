<?php

namespace App\Repositories\Order\Book\File;

use App\Entities\EntityInterface;
use App\Entities\Order\Book\File\File;
use App\Exceptions\FileNotFoundException;
use App\Repositories\EntityRepository;
use PDO;

class FileRepository extends EntityRepository implements FileRepositoryInterface
{

    public function save(EntityInterface $entity): void
    {
        /**
         * @var File $entity
         */
        $statement = $this->connector->getConnection()
            ->prepare("INSERT INTO files (book_id, path) VALUES (:book_id, :path)");

        $statement->execute(
            [':book_id' => $entity->getBookId(), ':path' => $entity->getPath()]
        );
    }

    /**
     * @throws FileNotFoundException
     */
    public function get(int $id): EntityInterface
    {
        $statement = $this->connector->getConnection()->prepare(
            'SELECT * FROM files WHERE id = :id'
        );

        $statement->execute([':id' => $id]);

        return $this->getFile($statement, $id);
    }

    /**
     * @throws FileNotFoundException
     */
    private function getFile(\PDOStatement $statement): EntityInterface
    {
        $result = $statement->fetch(PDO::FETCH_OBJ);
        if (!$result) {
            throw new FileNotFoundException("File not found");
        }

        return new File($result->book_id, $result->path);
    }

    /**
     * @throws FileNotFoundException
     */
    public function getFileByPath(string $path): File
    {
        $statement = $this->connector->getConnection()->prepare(
            'SELECT * FROM files WHERE path = :path'
        );
        $statement->execute([':path' => $path]);

        return $this->getFile($statement);
    }
}