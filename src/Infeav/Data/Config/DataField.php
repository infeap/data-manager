<?php
/**
 * This file is part of the
 * Infeav Data Manager (https://www.infeav.org/data-manager)
 * open source project
 *
 * @copyright   2018-2020 Tobias Krebs and the Infeav Team
 * @license     https://www.gnu.org/licenses/gpl.html GNU General Public License 3
 */

namespace Infeav\Data\Config;

abstract class DataField
{

    protected ?string $type = null;

    public function __construct(
        protected array $config,
        protected mixed $value = null,
    ) { }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getName(): ?string
    {
        return $this->config['name'] ?? null;
    }

    public function getLabel(): ?string
    {
        return $this->config['label'] ?? null;
    }

    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function toResponse(): array
    {
        return [
            'type' => $this->getType(),
            'name' => $this->getName(),
            'label' => $this->getLabel(),
            'value' => $this->getValue(),
        ];
    }

}
