<?php

namespace RabbitMq\ManagementApi\Api;

/**
 * Definitions
 *
 * The server definitions - exchanges, queues, bindings, users, virtual hosts, permissions and parameters.
 * Everything apart from messages.
 *
 * Use export() to get all definitions.
 * Use import() to upload an existing set of definitions.
 *
 * Note that:
 * - The definitions are merged. Anything already existing is untouched.
 * - Conflicts will cause an error.
 * - In the event of an error you will be left with a part-applied set of definitions.
 *
 */
class Definitions extends AbstractApi
{
    /**
     * Export definitions.
     *
     * @return array
     */
    public function export(): array
    {
        return $this->client->send('/api/definitions');
    }

    /**
     *  Import definitions.
     *
     * @param array $definitionsJson
     * @return array|null
     */
    public function import(array $definitionsJson)
    {
        return $this->client->send('/api/definitions', 'POST', [], $definitionsJson);
    }
}
