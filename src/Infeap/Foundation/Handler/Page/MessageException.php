<?php
/**
 * This file is part of the
 * Infeap Data Manager (https://www.infeap.org/data-manager)
 * open source project.
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeap Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeap\Foundation\Handler\Page;

class MessageException extends \RuntimeException
{

    protected array $descriptionLines = [];
    protected ?string $type;

    public function __construct(string $heading = null, $description = null, string $type = 'info', int $code = 0, \Exception $previous = null)
    {
        if ($description) {
            if (is_string($description)) {
                $this->descriptionLines = [$description];
            } else if (is_array($description)) {
                $this->descriptionLines = $description;
            }
        }

        $this->type = $type;

        parent::__construct($heading, $code, $previous);
    }

    public function getHeading(): ?string
    {
        return $this->getMessage();
    }

    public function getDescriptionLines(): array
    {
        return $this->descriptionLines;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

}
