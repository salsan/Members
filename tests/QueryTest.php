<?php

declare(strict_types=1);


use PHPUnit\Framework\TestCase;
use Salsan\Members;

final class QueryTest extends TestCase
{
    private $paramters = array(
        'id' => '165714',
        'membershipYear' => '2022'
    );

    public function testInit(): object
    {
        $members = new Members\Query($this->paramters);
        $this->assertIsObject($members);

        return $members;
    }

    /**
     * @depends testInit
     */
    public function testGetInfo($members): void
    {
        $info = $members->getList();

        foreach ($info as $member) {

            $this->assertStringStartsWith("SANTAGATI SALVATORE", $member["name"]);
            $this->assertIsBool($member['isRookie']);
            $this->assertIsNumeric($member['year_subscribe']);
            $this->assertIsString($member["category"]);
            $this->assertEmpty($member["province"]);
            $this->assertStringContainsString("SICILIA", $member["region"]);
            $this->assertStringContainsString("ITA", $member["citizenship"]);
            $this->assertIsNumeric($member["club_id"]);
        }
    }

    /**
     * @depends testInit
     */
    public function testGetNumber($members): void
    {
        $membersNumber = $members->getNumber();

        $this->assertIsArray($membersNumber);
        $this->assertEquals(1, $membersNumber['total']);
        $this->assertEquals(0, $membersNumber['rookie']);
    }
}
