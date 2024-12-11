<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Salsan\Members;

final class FormTest extends TestCase
{
    public function testInit(): object
    {
        $form = new Members\Form();
        $this->assertIsObject($form);

        return $form;
    }

    /**
     * @depends testInit
     */

    public function testGetGenders($form): void
    {
        $genders = $form->getGenders();
        $this->assertIsArray($genders);
        $this->assertGreaterThanOrEqual(2, count($genders));
    }

    /**
     * @depends testInit
     */

    public function testGetProvinces($form): void
    {
        $provinces = $form->getMembersProvinces();
        $this->assertIsArray($provinces);
        $this->assertGreaterThanOrEqual(2, count($provinces));
    }

    /**
     * @depends testInit
     */

    public function testGetRegions($form): void
    {
        $regions = $form->getMembersRegions();
        $this->assertIsArray($regions);
        $this->assertEquals(22, count($regions));
    }

    /**
     * @depends testInit
     */

    public function testGetClubsProvinces($form): void
    {
        $provinces = $form->getClubsProvinces();
        $this->assertIsArray($provinces);
        $this->assertLessThanOrEqual(112, count($provinces));
    }

    /**
     * @depends testInit
     */

    public function testGetClubsList($form): void
    {
        $clubs = $form->getClubList();
        $this->assertIsArray($clubs);
        $this->assertEquals(0, count($clubs));
    }

    /**
     * @depends testInit
     */

    public function testGetYears($form): void
    {
        $years = $form->getMembershipYears();
        $this->assertIsArray($years);
        $this->assertGreaterThan(5, count($years));
    }

    /**
     * @depends testInit
     */

    public function testGetMembershipTypes($form): void
    {
        $membershipTypes = $form->getMembershipTypes();
        $this->assertIsArray($membershipTypes);
        $this->assertGreaterThan(5, count($membershipTypes));
    }

    /**
     * @depends testInit
     */

    public function testGetOrder($form): void
    {
        $order = $form->getOrder();
        $this->assertIsArray($order);
        $this->assertGreaterThanOrEqual(1, count($order));
    }

    /**
     * @depends testInit
     */

    public function testgetDirection($form): void
    {
        $direction = $form->getDirection();
        $this->assertIsArray($direction);
        $this->assertGreaterThanOrEqual(1, count($direction));
    }
}
