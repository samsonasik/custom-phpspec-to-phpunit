<?php

namespace Sets\Fixture;

use PhpSpec\ObjectBehavior;

class ItIsMeSpec extends ObjectBehavior
{
    public function it_is_me()
    {
        $this->shouldHaveType(ItIsMe::class);
    }
}

?>
-----
<?php

namespace Tests\Rector\PhpSpecToPHPUnit\Tests\Rector\Variable\PhpSpecToPHPUnitRector\Fixture;

class ItIsMeTest extends \PHPUnit\Framework\TestCase
{
    private \Sets\Fixture\ItIsMe $itIsMe;
    protected function setUp(): void
    {
        parent::setUp();
        $this->itIsMe = new \Sets\Fixture\ItIsMe();
    }
}

?>