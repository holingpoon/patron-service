<?php
namespace NYPL\Services\Model\DataModel;

use NYPL\Services\Model\DataModel;
use NYPL\Starter\APIException;
use NYPL\Starter\Model\ModelTrait\SierraTrait\SierraReadTrait;

abstract class Query extends DataModel
{
    use SierraReadTrait;

    /**
     * @return string
     */
    abstract protected function getBody(): string;

    /**
     * @var array
     */
    protected $ids = [];

    /**
     * @param array $data
     * @param bool $validateData
     *
     * @throws APIException
     */
    public function translate(array $data = [], $validateData = false)
    {
        if (!$data['entries']) {
            throw new APIException(
                'No matching record found',
                null,
                0,
                null,
                404
            );
        }

        foreach ($data['entries'] as $entry) {
            $link = explode('/', $entry['link']);

            $this->addId(array_pop($link));
        }
    }

    /**
     * @return string
     */
    public function getRequestType()
    {
        return 'POST';
    }

    /**
     * @param string $id
     */
    protected function addId($id = '')
    {
        $this->ids[] = $id;
    }

    /**
     * @return array
     */
    public function getIds(): array
    {
        return $this->ids;
    }

    /**
     * @param array $ids
     */
    public function setIds(array $ids)
    {
        $this->ids = $ids;
    }
}