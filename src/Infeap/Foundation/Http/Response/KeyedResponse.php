<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeap\Foundation\Http\Response;

use Laminas\Diactoros\Response;

class KeyedResponse extends Response
{

    protected ?string $key;
    protected array $details;
    protected array $debug;

    /**
     * @param $options ['key']: string
     *                 ['details']: array
     *                 ['debug']: array   ['message']: string
     *                                    ['exception']: \Throwable
     *
     *                 ['status']: int
     *                 ['headers']: array
     */
    public function __construct(array $options = [])
    {
        $this->key = $options['key'] ?? null;
        $this->details = $options['details'] ?? [];
        $this->debug = $options['debug'] ?? [];

        parent::__construct(
            'php://memory',
            $options['status'] ?? 200,
            $options['headers'] ?? [],
        );
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function getDetails(): array
    {
        return $this->details;
    }

    public function getDebug(): array
    {
        return $this->debug;
    }

}
