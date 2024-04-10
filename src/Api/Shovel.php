<?php

namespace RabbitMq\ManagementApi\Api;

/**
 * Shovel
 */
class Shovel extends AbstractApi
{
    /**
     * A list of all shovels.
     *
     * OR
     *
     * A list of all shovels in a given virtual host.
     *
     * @param string|null $vhost
     * @return array
     */
    public function all($vhost = null)
    {
        if ($vhost) {
            return $this->client->send(sprintf('/api/shovels/%s', urlencode($vhost)));
        } else {
            return $this->client->send('/api/shovels');
        }
    }

    /**
     * An individual shovel.
     *
     * @param string $vhost
     * @param string $name
     * @return array
     */
    public function get($vhost, $name)
    {
        // Workaround for the fact that the API does not seem to support getting a single shovel
        $allShovels = $this->all($vhost);

        foreach ($allShovels as $shovel) {
            if ($shovel['name'] === $name) {
                return $shovel;
            }
        }

        // @TODO: Figure out why is this not working although it's documented
        return $this->client->send(sprintf('/api/shovels/vhost/%s/%s', urlencode($vhost), urlencode($name)));
    }

    /**
     * Create a shovel
     *
     * @param string $vhost
     * @param string $name
     * @param array $shovelSettings
     * @return array
     */
    public function create($vhost, $name, array $shovelSettings)
    {
        return $this->client->parameters()->create('shovel', $vhost, $name, [
                'value' => $shovelSettings
            ]
        );
    }

    /**
     * Restart a shovel
     *
     * @param $vhost
     * @param $name
     * @return array
     */
    public function restart($vhost, $name)
    {
        return $this->client->send(sprintf('/api/shovels/%s/%s/restart', urlencode($vhost), urlencode($name)), 'DELETE');
    }

    /**
     * @param string $vhost
     * @param string $name
     * @return array
     */
    public function delete($vhost, $name)
    {
        return $this->client->parameters()->delete('shovel', $vhost, $name);
    }
}
