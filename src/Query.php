<?php

declare(strict_types=1);

namespace Salsan\Members;

use Salsan\Utils\String\HiddenSpaceTrait;

use DOMDocument;

class Query
{
    use HiddenSpaceTrait;

    private DOMDocument $dom;
    private string $url = "https://www.federscacchi.it/str_tess.php";

    function __construct(array $params)
    {
        $this->dom = new DOMDocument();
        libxml_use_internal_errors(true);

        $id = $params['id'] ?? '';
        $cgn = $params['surname'] ?? '';
        $gen = $params['gender'] ?? '';
        $an1 = $params['bornFrom'] ?? '';
        $an2 = $params['bornTo'] ?? '';
        $cat = $params['category'] ?? '';
        $pro = $params['province'] ?? '';
        $reg = $params['region'] ?? '';
        $socpro = $params['clubProvince'] ?? '';
        $socreg = $params['clubRegion'] ?? '';
        $cir = $params['clubId'] ?? '';
        $anno = $params['membershipYear'] ?? '';
        $tiptes = $params['membershipType'] ?? '';
        $ord = $params['order'] ?? '';
        $senso = $params['sense'] ?? '';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'id' => $id,
                'cgn' => $cgn,
                'gen' => $gen,
                'an1' => $an1,
                'an2' => $an2,
                'cat' => $cat,
                'pro' => $pro,
                'reg' => $reg,
                'socpro' => $socpro,
                'socreg' => $socreg,
                'cir' => $cir,
                'anno' => $anno,
                'ord' => $ord,
                'senso' => $senso,
                'ric' => '1'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $this->dom->loadHTML($response);
    }

    public function getNumber(): array
    {
        $row = $this->dom
            ->getElementsByTagName("table")
            ->item(4)
            ->getElementsByTagName("td");


        preg_match_all(
            "/\d+/",
            $row[count($row) - 1]->textContent,
            $matches,
            PREG_SET_ORDER,
            0,
        );

        $members = ["total" => $matches[0][0], "rookie" => $matches[1][0]];

        return $members;
    }

    public function getList(): iterable
    {
        $row = $this->dom
            ->getElementsByTagName("table")
            ->item(4)
            ->getElementsByTagName("tr");

        $members = [];

        foreach ($row as $user) {
            if ($user->getElementsByTagName("td")->length > 14) {
                //  id
                $id = $user->getElementsByTagName("td")[0]->textContent;
                //  Surname and Name
                $members[$id]["name"] = $this->replaceWithStandardSpace($user->getElementsByTagName(
                    "td",
                )[1]->textContent);
                // Rookie (boolean)
                $members[$id]["isRookie"] = (bool) $user->getElementsByTagName("td")[2]
                    ->textContent;
                //  year subscribe
                $members[$id]["year_subscribe"] = $user->getElementsByTagName(
                    "td",
                )[3]->textContent;
                //  gender
                $members[$id]["gender"] = $user->getElementsByTagName(
                    "td",
                )[4]->textContent;
                //  born date
                $members[$id]["birthday"] = $user->getElementsByTagName(
                    "td",
                )[5]->textContent;
                //  category
                $members[$id]["category"] = $user->getElementsByTagName(
                    "td",
                )[6]->textContent;
                //  province
                $members[$id]["province"] = $user->getElementsByTagName(
                    "td",
                )[7]->textContent;
                //  region
                $members[$id]["region"] = $this->replaceWithStandardSpace($user->getElementsByTagName(
                    "td",
                )[8]->textContent);
                //  citizenship
                $members[$id]["citizenship"] = $user->getElementsByTagName(
                    "td",
                )[9]->textContent;
                //  club id
                $members[$id]["club_id"] = $user->getElementsByTagName(
                    "td",
                )[10]->textContent;
                //  club name
                $members[$id]["club_name"] = $this->replaceWithStandardSpace($user->getElementsByTagName(
                    "td",
                )[11]->textContent);
                //  club city
                $members[$id]["club_city"] = $this->replaceWithStandardSpace($user->getElementsByTagName(
                    "td",
                )[12]->textContent);
                //  club region
                $members[$id]["club_region"] = $this->replaceWithStandardSpace($user->getElementsByTagName(
                    "td",
                )[13]->textContent);
                //  members type and number
                $members[$id]["card_number"] = $this->replaceWithStandardSpace($user->getElementsByTagName(
                    "td",
                )[14]->textContent);
            }
        }

        return $members;
    }
}
