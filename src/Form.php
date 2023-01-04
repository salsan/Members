<?php

declare(strict_types=1);

namespace Salsan\Members;

use DOMDocument;
use Salsan\Utils\DOM\Form\DOMOptionTrait;

class Form
{

    use DOMOptionTrait;

    private DOMDocument $dom;
    private string $url = "https://www.federscacchi.it/str_tess.php";

    function __construct()
    {
        $this->dom = new DOMDocument();
        libxml_use_internal_errors(true);

        $this->dom->loadHTMLFile($this->url);
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
        return ($this->getArray("'senso'", $this->dom));
    }
}
