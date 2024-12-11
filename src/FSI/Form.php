<?php

declare(strict_types=1);

namespace Salsan\Members\Fsi;

use DOMDocument;
use Salsan\Utils\DOM\Form\DOMOptionTrait;
use Salsan\Utils\DOM\DOMDocumentTrait;

class Form
{
    use DOMOptionTrait;
    use DOMDocumentTrait;

    private DOMDocument $dom;
    private string $url = "https://www.federscacchi.com/fsi/index.php/struttura/tesserati";

    public function __construct()
    {
        $this->dom = $this->getHTML($this->url, null);
    }

    /**
     * @return array<string>
     */
    public function getGenders(): array
    {
        return ($this->getArray("'gen'", $this->dom));
    }

    /**
     * @return array<string>
     */
    public function getMembersProvinces(): array
    {
        return ($this->getArray("'pro'", $this->dom));
    }

    /**
     * @return array<string>
     */
    public function getMembersRegions(): array
    {
        return ($this->getArray("'reg'", $this->dom));
    }

    /**
     * @return array<string>
     */
    public function getClubsProvinces(): array
    {
        return ($this->getArray("'socpro'", $this->dom));
    }

    /**
     * @return array<string>
     */
    public function getClubList(): array
    {
        return ($this->getArray("'cir'", $this->dom));
    }

    /**
     * @return array<string>
     */
    public function getMembershipYears(): array
    {
        return ($this->getArray("'anno'", $this->dom));
    }

    /**
     * @return array<string>
     */
    public function getMembershipTypes(): array
    {
        return ($this->getArray("'tiptes'", $this->dom));
    }

    /**
     * @return array<string>
     */
    public function getOrder(): array
    {
        return ($this->getArray("'ord'", $this->dom));
    }

    /**
     * @return array<string, string|null>
     */
    public function getDirection(): array
    {
        $xpath = new \DOMXPath($this->dom);
        $direction = $xpath->evaluate("//*[contains(@name, 'senso')]//@value");

        if (!$direction  instanceof \DOMNodeList) {
            return [];
        }

        $result = [];

        /** @var \DOMAttr $valueNode */
        foreach ($direction as $valueNode) {
            if ($valueNode->nodeValue !== null) {
                $result[$valueNode->nodeValue] = $valueNode->nodeValue;
            }
        }

        return $result;
    }
}
