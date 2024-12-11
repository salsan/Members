<?php

declare(strict_types=1);

namespace Salsan\Members;

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

    public function getGenders(): array
    {
        return ($this->getArray("'gen'", $this->dom));
    }

    public function getMembersProvinces(): array
    {
        return ($this->getArray("'pro'", $this->dom));
    }

    public function getMembersRegions(): array
    {
        return ($this->getArray("'reg'", $this->dom));
    }

    public function getClubsProvinces(): array
    {
        return ($this->getArray("'socpro'", $this->dom));
    }

    public function getClubList(): array
    {
        return ($this->getArray("'cir'", $this->dom));
    }

    public function getMembershipYears(): array
    {
        return ($this->getArray("'anno'", $this->dom));
    }

    public function getMembershipTypes(): array
    {
        return ($this->getArray("'tiptes'", $this->dom));
    }

    public function getOrder(): array
    {
        return ($this->getArray("'ord'", $this->dom));
    }

    public function getDirection(): array
    {
        $xpath = new \DOMXPath($this->dom);
        $direction = $xpath->evaluate("//*[contains(@name, 'senso')]//@value");
        $result = [];

        foreach ($direction as $valueNode) {
            $result[$valueNode->nodeValue] = $valueNode->nodeValue;
        }

        return ($result);
    }
}
