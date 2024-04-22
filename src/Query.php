<?php

declare(strict_types=1);

namespace Salsan\Members;

use Salsan\Utils\String\HiddenSpaceTrait;
use Salsan\Utils\DOM\DOMDocumentTrait;
use DOMDocument;
use DOMXPath;

class Query
{
    use HiddenSpaceTrait;
    use DOMDocumentTrait;

    private DOMDocument $dom;
    private string $url = "https://www.federscacchi.com/fsi/index.php/struttura/tesserati";

    public function __construct(array $params)
    {
        $this->dom = new DOMDocument();

        // Members Parameters
        $idx = $params['idx'] ?? '';
        $cgn = $params['surname'] ?? '';
        $gen = $params['gender'] ?? '';
        $an1 = $params['bornFrom'] ?? '';
        $an2 = $params['bornTo'] ?? '';
        $cat = $params['category'] ?? '';
        $pro = $params['province'] ?? '';
        $reg = $params['region'] ?? '';
        $tiptes = $params['membershipType'] ?? '';
        $anno = $params['membershipYear'] ?? '';
        // Club Parameters
        $socpro = $params['clubProvince'] ?? '';
        $socreg = $params['clubRegion'] ?? '';
        $cir = $params['clubId'] ?? '';
        // Order Parameters
        $ord = $params['order'] ?? '';
        $senso = $params['sense'] ?? '';

        $this->url .=
            "?idx={$idx}" .
            "&cgn={$cgn}" .
            "&gen={$gen}" .
            "&an1={$an1}" .
            "&an2={$an2}" .
            "&cat={$cat}" .
            "&pro={$pro}" .
            "&reg={$reg}" .
            "&tiptes={$tiptes}" .
            "&anno={$anno}" .
            "&socpro={$socpro}" .
            "&socreg={$socreg}" .
            "&cir={$cir}" .
            "&ord={$ord}" .
            "&senso={$senso}" .
            "&ric=1" .
            "&tabella=tabella";

        $this->dom = $this->getHTML($this->url, null);
    }

    public function getNumber(): array
    {
        $xpath = new DOMXPath($this->dom);

        $total = $this->getNodeValue(
            $xpath,
            '//table[@class="table table-striped table-hover"]//following::div[@class="alert alert-success"]//b[1]'
        );

        $rookie = $this->getNodeValue(
            $xpath,
            '//table[@class="table table-striped table-hover"]//following::div[@class="alert alert-success"]//b[2]'
        );

        $members = ["total" => $total, "rookie" => $rookie];

        return $members;
    }

    public function getList(): iterable
    {
        $xpath = new DOMXPath($this->dom);
        $total_rows = $xpath->evaluate('count(//tr[@bgcolor="#03A83A"]/following-sibling::tr)');

        $members = [];
        $row = 0;

        for ($i = 0; $total_rows > $i; $i++) {
            $row = $row + 1;
            $xpath_member = '//tr[@bgcolor]/following-sibling::tr[' . $row . ']';

            //  id
            $id = $this->getNodeValue(
                $xpath,
                $xpath_member . '//td[1]'
            );
            //  Surname and Name
            $members[$id]["name"] = $this->getNodeValue(
                $xpath,
                $xpath_member . '//td[2]'
            );
            // Rookie (boolean)
            $members[$id]["isRookie"] = (bool) $this->getNodeValue(
                $xpath,
                $xpath_member . '//td[3]'
            );
            //  year subscribe
            $members[$id]["year_subscribe"] = $this->getNodeValue(
                $xpath,
                $xpath_member . '//td[4]'
            );
            //  gender
            $members[$id]["gender"] = $this->getNodeValue(
                $xpath,
                $xpath_member . '//td[5]'
            );
            //  born date
            $members[$id]["birthday"] = $this->getNodeValue(
                $xpath,
                $xpath_member . '//td[6]'
            );
            //  category
            $members[$id]["category"] = $this->getNodeValue(
                $xpath,
                $xpath_member . '//td[7]'
            );
            //  province
            $members[$id]["province"] = $this->getNodeValue(
                $xpath,
                $xpath_member . '//td[8]'
            );
            $members[$id]["region"] =  $this->getNodeValue(
                $xpath,
                $xpath_member . '//td[9]'
            );
            //  citizenship
            $members[$id]["citizenship"] = $this->getNodeValue(
                $xpath,
                $xpath_member . '//td[10]'
            );
            //  club id
            $members[$id]["club_id"] = $this->getNodeValue(
                $xpath,
                $xpath_member . '//td[11]'
            );
            //  club name
            $members[$id]["club_name"] = $this->getNodeValue(
                $xpath,
                $xpath_member . '//td[12]'
            );
            //  club city
            $members[$id]["club_city"] = $this->getNodeValue(
                $xpath,
                $xpath_member . '//td[13]'
            );
            //  club region
            $members[$id]["club_region"] = $this->getNodeValue(
                $xpath,
                $xpath_member . '//td[14]'
            );
            //  members type and number
            $members[$id]["card_number"] = $this->getNodeValue(
                $xpath,
                $xpath_member . '//td[15]'
            );
        }

        return $members;
    }
}
