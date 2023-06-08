<?php

namespace Tests\Smorken\Sanitizer\Unit;

class RdsCdsSanitizerTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var \Smorken\Sanitizer\Actors\Standard
     */
    protected $sut;

    public function setUp(): void
    {
        parent::setUp();
        $this->sut = new \Smorken\Sanitizer\Actors\RdsCds();
    }

    public function testAcadOrg()
    {
        $t = '123abc-_ ';
        $this->assertEquals('123abc', $this->sut->acadOrg($t));
    }

    public function testCollegeId()
    {
        $t = '123abc _-';
        $this->assertEquals('123abc', $this->sut->collegeId($t));
    }

    public function testComments()
    {
        $t = '123<script>alert(1)';
        $this->assertEquals('123&lt;script&gt;alert(1)', $this->sut->comments($t));
    }

    public function testCourseId()
    {
        $t = '123abc-_ ';
        $this->assertEquals('123abc-_', $this->sut->courseId($t));
    }

    public function testCredits()
    {
        $t = '123abc';
        $this->assertEquals(123, $this->sut->credits($t));
    }

    public function testDetailId()
    {
        $t = '123abc-_ ';
        $this->assertEquals('123abc-_', $this->sut->detailId($t));
    }

    public function testDiff()
    {
        $t = '123.5abc';
        $this->assertEquals(123.5, $this->sut->diff($t));
    }

    public function testGroupId()
    {
        $t = '123abc-_ ';
        $this->assertEquals('123abc-_', $this->sut->groupId($t));
    }

    public function testLoad()
    {
        $t = 'FOO';
        $this->assertNull($this->sut->load($t));
    }

    public function testMeidOrId()
    {
        $t = '123abc-_ ';
        $this->assertEquals('123abc', $this->sut->meidOrId($t));
    }

    public function testName()
    {
        $t = '123<script>alert(1)';
        $this->assertEquals('123&lt;script&gt;alert(1)', $this->sut->name($t));
    }

    public function testPage()
    {
        $t = '123abc';
        $this->assertEquals(123, $this->sut->page($t));
    }

    public function testPlanCode()
    {
        $t = '123abc-_ ';
        $this->assertEquals('123abc', $this->sut->planCode($t));
    }

    public function testStudentId()
    {
        $t = '123abc';
        $this->assertEquals(123, $this->sut->studentId($t));
    }

    public function testTermId()
    {
        $t = '123abc';
        $this->assertEquals(123, $this->sut->termId($t));
    }
}
