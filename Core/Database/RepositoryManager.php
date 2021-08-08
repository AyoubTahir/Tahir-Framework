<?php
/*
 * This file is part of the MagmaCore package.
 *
 * (c) Ricardo Miller <ricardomiller@lava-studio.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tahir\Core\Database;

use Tahir\Core\Database\EntityManager;

class RepositoryManager
{

    protected $entityManager;


    public function __construct(string $tableSchema, string $ID)
    {
        $this->entityManager = new EntityManager( $tableSchema, $ID);
    }

    
    private function  isArray(array $conditions): void
    {
        if (!is_array($conditions))
            throw new DataLayerInvalidArgumentException('The argument supplied is not an array');
    }


    private function isEmpty(mixed $id): void
    {
        if (empty($id))
            throw new DataLayerInvalidArgumentException('Argument should not be empty');
    }

    public function select(string $selectors = '*'): array
    {
        try
        {
            $this->entityManager->select($selectors);

            return $this;
        }
        catch (Throwable $throwable)
        {
            throw $throwable;
        }
    }

    public function All(): array
    {
        try
        {
            return $this->entityManager->select()->get();
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }


    public function findOneById(int $id) : object
    {
        $this->isEmpty($id);

        try
        {
            return $this->entityManager->select('*')->where('id','=', $id)->first();
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }


    public function findOneWhere( string $param, int $value ): object
    {
        $this->isEmpty($param);
        $this->isEmpty($value);

        try
        {
            return $this->entityManager->select('*')->where( $param,'=', $value)->first();
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }

    public function deleteIfExist(int $id): bool
    {
        $this->isEmpty($id);

        try
        {
            $result = $this->findOneById($id);

            if ($result)
            {
                $this->entityManager->delete()->where('id','=',$id)->execute();

                return true;
            }

        }
        catch (Throwable $throwable)
        {
            throw $throwable;
        }

        return false;
    }


    public function deleteByIds(array $items = []): bool
    {
        if (is_array($items) && count($items) > 0)
        {
            foreach ($items as $item)
            {
                $delete = $this->deleteIfExist($item);    
            }

            if ($delete)
            {
                return true;
            }
        }
        return false;
    }


    public function Update(array $fields, int $id): bool
    {
        $this->isArray($fields);
        try
        {
            $result = $this->findOneById($id);

            if ($result != null)
            {
                $update = $this->entityManager->update($fields)->where('id','=',$id)->execute();
                
                return true;
            }
        }
        catch (Throwable $throwable)
        {
            throw $throwable;
        }
        return false;
    }


    public function or404(): ?object
    {
        if ($this->findAndReturn != null) {
            return $this->findAndReturn;
        } else {
            header('HTTP/1.1 404 not found');
            // $twig = new \Magma\Base\BaseView();
            //$twig->twigRender('error/404.html.twig');
            exit;
        }
    }


    public function count(array $conditions = [], ?string $field = 'id')
    {
        return $this->em->getCrud()->countRecords($conditions, $field);
    }


    public function fetchLastID(): int
    {
        return $this->em->getCrud()->lastID();
    }

}